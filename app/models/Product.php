<?php

Class Product extends Eloquent {
	protected $table = 'products';
	public $timestamps = false;
	public $primaryKey = 'product_id';
}