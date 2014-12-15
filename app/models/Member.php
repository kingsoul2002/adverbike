<?php

Class Member extends Eloquent {
	protected $table = 'members';
	public $incrementing = false;
	public $timestamps = false;
	public $primaryKey = 'facebookid';
}