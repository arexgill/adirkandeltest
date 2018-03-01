<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;

class LinksController extends Controller
{
	/**
	 * Scraping links from a given domain.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function fetch(Request $request) {
		$links = Link::get(['link','valid']);
		return response()->json(["status" => "success", "data" => $links]);
	}
}
