<?php
session_start();
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;

FacebookSession::setDefaultApplication('912427898786255', '20a82601da3115af73c00512b392e7fa');

class EventController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$oevents = OfficialEvent::orderBy('date', 'desc')->get();
		$mevents = MemberEvent::leftJoin('members', 'memberevents.own_id', '=', 'members.facebookid')
								->orderBy('appointment', 'desc')->get();
		if(isset($_SESSION['authorized'])) {
			return View::make('pages.index')->with('oevents', $oevents)->with('mevents', $mevents)->with('authorized', true);
		} else {
			return View::make('pages.index')->with('oevents', $oevents)->with('authorized', false);
		}
	}

	public function officialEventList()
	{
		$events = OfficialEvent::orderBy('date', 'desc')->get();
		if(isset($_SESSION['authorized'])) {
			return View::make('pages.officialevent')->with('events', $events)->with('authorized', true);
		} else {
			return View::make('pages.officialevent')->with('events', $events)->with('authorized', false);
		}
	}

	public function memberEventList()
	{
		$events = OfficialEvent::orderBy('date', 'desc')->get();
		if(isset($_SESSION['authorized'])) {
			return View::make('pages.memberevent')->with('events', $events)->with('authorized', true);
		} else {
			return Redirect::to('/');
		}
	}

	public function createMemberEvent()
	{
		if(isset($_SESSION['authorized'])) {
			return View::make('pages.creatememberevent')->with('authorized', true);
		} else {
			return Redirect::to('/');
		}
	}

	public function addMemberEvent()
	{
		$mapvalue = "'" . Input::get('mapvalue') . "'";
		$event = new MemberEvent;
		$event->own_id = $_SESSION['facebookid'];
		$event->name = Input::get('eventname');
		$event->description = Input::get('description');
		$event->appointment = date('Y-m-d H:i:s', strtotime(Input::get('appointment')));
		$event->startplace = Input::get('startplace');
		$event->endplace = Input::get('endplace');
		$event->path = DB::raw("GeomFromText($mapvalue)");
		$event->save();
		return Redirect::to('/');
	}

	public function join()
	{
		$eventid = Input::get('eventid');
		$type = Input::get('type');
		$isjoin = Wishlist::where('facebookid', '=', $_SESSION['facebookid'])
							->where('eventid', '=', $eventid)
							->where('type', '=', $type)
							->first();
		if(is_null($isjoin)) {
			$joinevent = new Wishlist;
			$joinevent->facebookid = $_SESSION['facebookid'];
			$joinevent->eventid = $eventid;
			$joinevent->type = $type;
			$joinevent->save();
		}
		return Redirect::to('/wishlist');
	}

	public function myevent()
	{
		if(isset($_SESSION['authorized'])) {
			$mywishlists = Wishlist::join('officialevents', 'wishlists.eventid', '=', 'officialevents.id')->where('facebookid', '=', $_SESSION['facebookid'])->orderBy('date')->get();
			return View::make('pages.myevent')->with('mywishlists', $mywishlists)->with('authorized', true);
		} else {
			return Redirect::to('/');
		}
	}

	public function getOEPoint($id)
	{
		$size = OfficialEvent::where('id', '=', $id)->select(DB::raw("NumGeometries(startpoint) As size"))->first()->size;
		$points = array();
		for ($i = 1; $i <= $size; $i++) {
			array_push($points, OfficialEvent::where('id', '=', $id)->select(DB::raw("X(GeometryN(startpoint,$i)) AS x"), DB::raw("Y(GeometryN(startpoint,$i)) AS y"))->get());
		}
		if(Request::ajax()) {
			return $points;
		}
		return $points;
	}

	public function getMEPoint($id)
	{
		$size = MemberEvent::where('mevent_id', '=', $id)->select(DB::raw("NumPoints(path) As size"))->first()->size;
		$points = array();
		for ($i = 1; $i <= $size; $i++) {
			array_push($points, MemberEvent::where('mevent_id', '=', $id)->select(DB::raw("X(PointN(path,$i)) AS x"), DB::raw("Y(PointN(path,$i)) AS y"))->get());
		}
		if(Request::ajax()) {
			return $points;
		}
		return $points;
	}

}
