<?php
	class Unit extends ShopAppModel{
		public $hasMany = array(
			'Product' => array(
				'className' => 'Shop.Product'
			)
		);
	}