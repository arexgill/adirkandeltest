var Alert = function () {
	var alertElm = $('.alert');

	function show(text, hideTimeout, status) {
		alertElm.text(text).removeClass('d-none');

		switch (status) {
			case "success":
				alertElm.removeClass('alert-danger').addClass('alert-success');
				break;
			case "error":
				alertElm.removeClass('alert-success').addClass('alert-danger');
				break;
		}

		if (hideTimeout > 0) {
			setTimeout(function () {
				hide();
			}, 3000)
		}
	}

	function hide() {
		alertElm.addClass('d-none');
	}

	return {
		show: show,
		hide: hide
	}
}();

$('#scrap').submit(function (e) {
	e.preventDefault();

	var domain = $('#domain').val();
	if (domain && checkDomain(domain)) {
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		$.ajax('/scrapDomain', {
			data: {domain: domain, _token: CSRF_TOKEN},
			method: 'post',
			dataType: 'json',
			beforeSend: function () {
				$('.loader').addClass('show');
			},
			success: function (data, textStatus, jqXHR) {
				if(!data.msg && data.status === "success") data.msg = "The scraping done successfully!";
				Alert.show(data.msg, 5000, data.status);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				Alert.show(textStatus, 5000);
			},
			complete: function (jqXHR, textStatus) {
				$('.loader').removeClass('show');
			}
		});
	}
	else {
		Alert.show('Please enter a valid URL', 5000);
	}
});

$('#fetchAllLinks').click(function () {
	$.ajax('/getScrapedLinks', {
		method: 'get',
		dataType: 'json',
		beforeSend: function () {
			$('.loader').addClass('show');
		},
		success: function (data, textStatus, jqXHR) {
			if(data.status === "error") {
				Alert.show(data.msg, 5000, data.status);
				return;
			}

			if(data.data.length === 0) {
				Alert.show("There are no links at the moment", 5000, "error");
			}
			else {
				var tableStr = "<table id='results' class=\"table table-hover\"><thead><tr><th>#</th><th>link</th><th>is valid?</th></tr></thead><tbody>";
				for (var i in data.data) {
					tableStr += "<tr><td>" + (parseInt(i)+1) + "</td><td><a href='" + data.data[i].link + "'>" + data.data[i].link + "</a></td><td>" + (data.data[i].valid === 1).toString() + "</td></tr>";
				}
				tableStr += "</tbody></table>";
				$("#results")[0].outerHTML = tableStr;
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			Alert.show(textStatus, 5000);
		},
		complete: function (jqXHR, textStatus) {
			$('.loader').removeClass('show');
		}
	});
});

function checkDomain(domain) {
	if (!domain) return false;
	var re = /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/;
	return re.test(domain);
}       