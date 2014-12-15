<?php

Class OfficialEvent extends Eloquent {
	protected $table = 'officialevents';
	public $incrementing = false;
	public $timestamps = false;
	public $primaryKey = 'id';
}