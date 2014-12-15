<?php
session_start();
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\GraphUser;

FacebookSession::setDefaultApplication('912427898786255', '20a82601da3115af73c00512b392e7fa');

class AuthenController extends BaseController {
	
	public function signIn()
	{
		$helper = new FacebookRedirectLoginHelper("https://adverbike-kingsoul.rhcloud.com/signin/callback");
		return Redirect::to($helper->getLoginUrl());
	}

	public function signInCallback()
	{
		$helper = new FacebookRedirectLoginHelper("https://adverbike-kingsoul.rhcloud.com/signin/callback");
		$session = null;
		try {
		    $session = $helper->getSessionFromRedirect();
		} catch(FacebookRequestException $ex) {
		    // When Facebook returns an error
		} catch(\Exception $ex) {
		    // When validation fails or other local issues
		}
		$_SESSION['token'] = $session->getToken();
		$_SESSION['authorized'] = true;
		$me = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());
		$picture = (new FacebookRequest($session, 'GET', '/me/picture', array('redirect' => false, 'type' => 'square', 'height' => '25', 'width' => '25')))->execute()->getGraphObject()->getProperty('url');
		$_SESSION['picurl'] = $picture;
		$facebookid = $me->getId();
		$name = $me->getName();
		$_SESSION['facebookid'] = $facebookid;
		$_SESSION['name'] = $name;
		$register = Member::where("facebookid", '=', $facebookid)->first();
		if(is_null($register)) {
			$member = new Member;
			$member->facebookid = $facebookid;
			$member->fullname = $name;
			$member->save();
		} else {
			if($register->fullname != $name) {
				$register->fullname = $name;
				$register->save();
			}
		}
		return Redirect::to('/');
	}

	public function logOut()
	{
		session_unset();
		return Redirect::to('/');
	}

}
