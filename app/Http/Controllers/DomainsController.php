<?php

namespace App\Http\Controllers;

use App\Domain;
use Illuminate\Http\Request;

class DomainsController extends Controller
{
	
	const VALID_URL_REGEX = "/((https?:|[^.])\/\/w{0,3}[.]?.[a-z]{2,4})|.[a-z]{2,4}/";
	
    /**
     * Scraping links from a given domain.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function scrap(Request $request) {
        $domain = $request->input('domain');
	
	    if(Domain::where('domain', '=', $domain)->first())
		    return response()->json(["status" => "error", "msg" => "This domain already exists, try an other one"]);
	
	    $inputLinks = [];
	
	    if($this->ValidateUrl($domain)) {
		    $pageHtml = file_get_contents($domain);
		    preg_match_all("/<a[^>]+href\s*=\s*[\"']([^\"#']+)[\"'][^>]*>/i", $pageHtml, $matchLinks);
		    $fetchedLinks = $matchLinks[1];
		    
		    if(count($fetchedLinks) > 0) {
		    	// insert a new domain.
			    $domainObj = Domain::create(['domain'=>$domain]);
			    foreach ($fetchedLinks as $link) {
			    	if(strpos($link, "//") === 0) $link = 'http:' . $link;
			    	elseif (strpos($link, "http") === false) $link = 'http://' . $link;
			    	
			    	$link = urldecode($link);
			    	
			    	if(!in_array($link, $inputLinks)) {
					    array_push($inputLinks, $link);
				    }
			    }
			    
			    // attach the links to the created domain.
			    if(count($inputLinks) > 0) {
				    $domainObj->links()->createMany(array_map(function($link) {
					    return [
						    "link" => $link,
						    "valid" => ($this->ValidateUrl($link) && $link !== "#" && strpos($link, 'javascript') === false)
					    ];
				    }, $inputLinks));
			    }
		    }
	    }
	
        return response()->json(["status" => "success", "data" => count($inputLinks)]);
    }
	
	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  string $url
	 * @return bool
	 */
    protected function CheckIfUrlWork($url) {
    	///////
    	// i'm not using this method because it's taking to much time checking every link that way, but i checked it and it works!
	    ///////
	    $exists = true;
	    $file_headers = @get_headers($url);
	    $InvalidHeaders = array('404', '403', '500');
	    foreach($InvalidHeaders as $HeaderVal)
	    {
		    if(strstr($file_headers[0], $HeaderVal))
		    {
			    $exists = false;
			    break;
		    }
	    }
	    return $exists;
    }
	
	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  string $url
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function ValidateUrl(string $url)
	{
		return preg_match(self::VALID_URL_REGEX, $url);
	}
}
