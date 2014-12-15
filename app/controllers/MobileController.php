<?php

class MobileController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getAllOfficialEvent()
	{
		return OfficialEvent::select('id', 'title', 'picurl')->get();
	}

	public function getOfficialEvent($id)
	{
		return OfficialEvent::where('id', '=', $id)->select('id', 'title', 'picurl', 'date', 'startplace', 'description', 'crediturl')->get();
	}
}
