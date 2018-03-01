<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}"/>
	
	<title>Metal parking - test</title>
	
	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Raleway:100,400,600" rel="stylesheet" type="text/css">
	
	<!-- Styles -->
	<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css"></link>
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
	      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<main role="main" class="container">
	<div class="row">
		<div class="text-center col-lg-10 offset-lg-1">
			<h1 class="mt-5">Scrap links from a given domain.</h1>
			
			<div class="alert alert-danger col-lg-6 offset-lg-3 d-none" role="alert"></div>
			
			<form id="scrap" class="col-lg-8 offset-lg-2 form-inline d-flex justify-content-center">
				
				<div class="form-group">
					<label for="domain" class="sr-only">Domain</label>
					<input type="text" class="form-control" id="domain" placeholder="Enter domain">
				</div>
				
				<button type="submit" class="btn btn-primary">Submit</button>
				
				<button type="button" id="fetchAllLinks" class="btn btn-default">Get all links</button>
				
				<div class="loader sk-circle">
					<div class="sk-circle1 sk-child"></div>
					<div class="sk-circle2 sk-child"></div>
					<div class="sk-circle3 sk-child"></div>
					<div class="sk-circle4 sk-child"></div>
					<div class="sk-circle5 sk-child"></div>
					<div class="sk-circle6 sk-child"></div>
					<div class="sk-circle7 sk-child"></div>
					<div class="sk-circle8 sk-child"></div>
					<div class="sk-circle9 sk-child"></div>
					<div class="sk-circle10 sk-child"></div>
					<div class="sk-circle11 sk-child"></div>
					<div class="sk-circle12 sk-child"></div>
				</div>
			</form>
		</div>
	</div>
	
	<table id="results"></table>
</main>

<script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
