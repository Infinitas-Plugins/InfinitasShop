<?php
	class ShopUnit extends ShopAppModel{
		public $hasMany = array(
			'Product' => array(
				'className' => 'Shop.Product'
			)
		);
	}