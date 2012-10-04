<?php
	class ShopStock extends ShopAppModel {
		public $belongsTo = array(
			'ShopBranch' => array(
				'className' => 'Shop.ShopBranch',
				'foreignKey' => 'shop_branch_id',
				'fields' => array(
					'ShopBranch.id',
					'ShopBranch.branch_id',
				)
			),
			'Product' => array(
				'className' => 'Shop.ShopProduct',
				'foreignKey' => 'shop_product_id',
				'fields' => array(
					'Product.id',
					'Product.name',
				)
			)
		);
	}