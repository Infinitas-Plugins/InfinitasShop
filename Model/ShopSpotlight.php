<?php
	class ShopSpotlight extends ShopAppModel {
		public $virtualFields = array(
			'start' => 'CONCAT(Spotlight.start_date, " ", Spotlight.start_time)',
			'end'   => 'CONCAT(Spotlight.end_date, " ", Spotlight.end_time)'
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
				'associationForeignKey' => 'spotlight_id',
				'with' => 'Shop.BranchesSpotlight',
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

		public function getSpotlights($limit = 10) {
			$cacheName = cacheName('spotlights', $limit);
			$spotlights = Cache::read($cacheName, 'shop');

			if($spotlights !== false) {
				return $spotlights;
			}

			$spotlights = $this->find(
				'all',
				array(
					'fields' => array(
						$this->alais . '.id',
						$this->alais . '.shop_image_id',
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

			Cache::write($cacheName, $spotlights, 'shop');

			return $spotlights;
		}
	}