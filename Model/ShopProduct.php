<?php
	class ShopProduct extends ShopAppModel {
		public $lockable = true;

		public $belongsTo = array(
			'Image' => array(
				'className' => 'Shop.ShopImage',
				'fields' => array(
					'Image.id',
					'Image.image',
					'Image.width',
					'Image.height'
				)
			),
			'ShopUnit' => array(
				'className' => 'Shop.ShopShopUnit',
				'counterCache' =>  true,
				'fields' => array(
					'ShopUnit.id',
					'ShopUnit.name',
					'ShopUnit.symbol',
					'ShopUnit.description'
				)
			),
			'Supplier' => array(
				'className' => 'Shop.ShopSupplier',
				'counterCache' =>  true,
				'fields' => array(
					'Supplier.id',
					'Supplier.name',
					'Supplier.slug'
				)
			)
		);

		public $hasMany = array(
			'Special' => array(
				'className' => 'Shop.ShopSpecial'
			),
			'Spotlight' => array(
				'className' => 'Shop.ShopSpotlight'
			)
		);

		public $hasAndBelongsToMany = array(
			'ProductImage' => array(
				'className' => 'Shop.ShopImage',
				'foreignKey' => 'shop_image_id',
				'associationForeignKey' => 'shop_product_id',
				'with' => 'Shop.ImagesProduct',
				'unique' => true,
				'conditions' => '',
				'fields' => array(
					'ProductImage.id',
					'ProductImage.image',
					'ProductImage.width',
					'ProductImage.height',
				),
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => ''
			),
			'ShopCategory' => array(
				'className' => 'Shop.ShopCategory',
				'foreignKey' => 'shop_category_id',
				'associationForeignKey' => 'product_id',
				'with' => 'Shop.CategoriesProduct',
				'unique' => true,
				'conditions' => '',
				'fields' => array(
					'ShopCategory.id',
					'ShopCategory.name',
					'ShopCategory.slug',
					'ShopCategory.active',
					'ShopCategory.image_id',
					'ShopCategory.parent_id'
				),
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => ''
			),
			'ShopBranch' => array(
				'className' => 'Shop.ShopBranch',
				'foreignKey' => 'shop_branch_id',
				'associationForeignKey' => 'product_id',
				'with' => 'Shop.BranchesProduct',
				'unique' => true,
				'conditions' => '',
				'fields' => array(
					'ShopBranch.id'
				),
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => ''
			),
			'Stock' => array(
				'className' => 'Shop.ShopStock',
				'foreignKey' => 'shop_branch_id',
				'associationForeignKey' => 'stock_id',
				'with' => 'Shop.Stock',
				'unique' => true,
				'conditions' => '',
				'fields' => array(
					'Stock.id',
					'Stock.branch_id',
					'Stock.branch_id',
					'Stock.stock',
				),
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => ''
			)
		);

		public function getBestSellers($limit = 10) {
			$cacheName = cacheName('products_best_sellers', $limit);
			$products = Cache::read($cacheName, 'shop');
			if($products !== false) {
				return $products;
			}

			$products = $this->find(
				'all',
				array(
					'fields' => array(
						$this->alais . '.id',
						$this->alais . '.name',
						$this->alais . '.slug',
						$this->alais . '.cost',
						$this->alais . '.price',
						$this->alais . '.shop_image_id',
					),
					'conditions' => array(
						$this->alais . '.id' => $this->getActiveProducts()
					),
					'limit' => (int)$limit,
					'order' => array(
						$this->alais . '.sales' => 'DESC'
					),
					'contain' => array(
						'ShopCategory',
						'Image',
						'Special' => array(
							'Image'
						)
					)
				)
			);

			Cache::write($cacheName, $products, 'shop');

			return $products;
		}

		public function getMostViewed($limit = 10) {
			$cacheName = cacheName('products_mostViewed', $limit);
			$products = Cache::read($cacheName, 'shop');
			if($products !== false) {
				return $products;
			}

			$products = $this->find(
				'all',
				array(
					'fields' => array(
						$this->alais . '.id',
						$this->alais . '.name',
						$this->alais . '.slug',
						$this->alais . '.cost',
						$this->alais . '.price',
						$this->alais . '.shop_image_id',
					),
					'conditions' => array(
						$this->alais . '.id' => $this->getActiveProducts()
					),
					'limit' => (int)$limit,
					'order' => array(
						$this->alais . '.views' => 'DESC'
					),
					'contain' => array(
						'ShopCategory',
						'Image',
						'Special' => array(
							'Image'
						)
					)
				)
			);

			Cache::write($cacheName, $products, 'shop');

			return $products;
		}

		public function getNewest($limit = 10) {
			$cacheName = cacheName('products_newest', $limit);
			$products = Cache::read($cacheName, 'shop');
			if($products !== false) {
				return $products;
			}

			$products = $this->find(
				'all',
				array(
					'fields' => array(
						$this->alais . '.id',
						$this->alais . '.name',
						$this->alais . '.slug',
						$this->alais . '.cost',
						$this->alais . '.price',
						$this->alais . '.shop_image_id',
					),
					'conditions' => array(
						$this->alais . '.id' => $this->getActiveProducts()
					),
					'limit' => (int)$limit,
					'order' => array(
						$this->alais . '.created' => 'DESC'
					),
					'contain' => array(
						'ShopCategory',
						'Image',
						'Special' => array(
							'Image'
						)
					)
				)
			);

			Cache::write($cacheName, $products, 'shop');

			return $products;
		}

		public function getActiveProducts($category_id = null, $categoryStatus = 1) {
			$conditions = array(
				'ShopCategory.active' => $categoryStatus
			);


			if ($category_id) {
				$conditions = array(
					'ShopCategory.active' => $categoryStatus,
					'ShopCategory.id' => $category_id
				);
			}

			$cacheName = cacheName('products_active', $conditions);
			$products = Cache::read($cacheName, 'shop');
			if($products !== false) {
				return $products;
			}

			$products = $this->ShopCategory->find(
				'all',
				array(
					'fields' => array(
						'ShopCategory.id'
					),
					'conditions' => $conditions,
					'order' => false,
					'contain' => array(
						'Product' => array(
							'fields' => array(
								$this->alais . '.id', $this->alais . '.id'
							),
							'conditions' => array(
								$this->alais . '.active' => $categoryStatus
							)
						)
					)
				)
			);

			$products = Set::extract('/Product/id', $products);

			Cache::write($cacheName, $products, 'shop');

			return $products;
		}
	}