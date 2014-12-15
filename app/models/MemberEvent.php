<?php

Class MemberEvent extends Eloquent {
	protected $table = 'memberevents';
	public $timestamps = false;
	public $primaryKey = 'mevent_id';
}