<?php
	class Item extends OrderAppModel {
		/**
		 * sub_total is the line total
		 * @var unknown_type
		 */
		public $virtualFields = array(
			'sub_total' => 'Item.quantity * Item.price'
		);

		public $belongsTo = array(
			'Product' => array(
				'className' => 'Shop.Product',
				'fields' => array(
					'Product.id',
					'Product.name',
					'Product.slug',
					'Product.description',
					'Product.image_id',
					'Product.cost',
					'Product.retail',
					'Product.price',
					'Product.active',
					'Product.image_id',
				),
				'counterCache' => 'sales'
			),
			'Order' => array(
				'className' => 'Order.Order'
			)
		);
	}