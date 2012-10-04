<?php
	class ShopSpecial extends ShopAppModel {
		public $virtualFields = array(
			'start' => 'CONCAT(Special.start_date, " ", Special.start_time)',
			'end'   => 'CONCAT(Special.end_date, " ", Special.end_time)'
		);

		public $order = array(
			'end' => 'ASC'
		);

		public $belongsTo = array(
			'Image' => array(
				'className' => 'Shop.ShopImage',
				'foreignKey' => 'shop_image_id',
				'fields' => array(
					'Image.id',
					'Image.image',
					'Image.width',
					'Image.height'
				),
				'conditions' => array(),
				'order' => array(
					'Image.image' => 'ASC'
				)
			),
			'Product' => array(
				'className' => 'Shop.ShopProduct',
				'foreignKey' => 'shop_product_id',
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
				'conditions' => array(),
				'order' => array(
					'Product.name' => 'ASC'
				)
			)
		);

		public $hasAndBelongsToMany = array(
			'ShopBranch' => array(
				'className' => 'Shop.ShopBranch',
				'foreignKey' => 'shop_branch_id',
				'associationForeignKey' => 'shop_special_id',
				'with' => 'Shop.BranchesSpecial',
				'unique' => true,
				'conditions' => '',
				'fields' => array(
					'ShopBranch.id',
					'ShopBranch.name'
				),
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => ''
			),
		);

		public function getSpecials($limit = 10) {
			$cacheName = cacheName('products_specials', $limit);
			$specials = Cache::read($cacheName, 'shop');
			if($specials !== false) {
				return $specials;
			}
			$specials = $this->find(
				'all',
				array(
					'fields' => array(
						$this->alais . '.id',
						$this->alais . '.shop_image_id',
						$this->alais . '.amount',
						$this->alais . '.active',
						$this->alais . '.start_date',
						$this->alais . '.end_date'
					),
					'conditions' => array(
						$this->alais . '.active' => 1,
						'and' => array(
							'start <= ' => date('Y-m-d H:i:s'),
							'end >= ' => date('Y-m-d H:i:s')
						)
					),
					'contain' => array(
						'Product' => array(
							'Image',
							'ShopCategory'
						),
						'Image'
					),
					'limit' => $limit
				)
			);

			Cache::write($cacheName, $specials, 'shop');

			return $specials;
		}
	}