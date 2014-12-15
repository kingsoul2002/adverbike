<?php

class TradeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{	
		if(isset($_SESSION['authorized'])) {
			$products = Product::orderBy('created_at', 'desc')->get();
			return View::make('pages.tradingzone')->with('products', $products)->with('authorized', true);
		} else {
			return Redirect::to('/');
		}
	}

}
