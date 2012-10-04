<?php
	class ShopCategory extends ShopAppModel {
		public $order = array();

		public $belongsTo = array(
			'Parent' => array(
				'className' => 'Shop.ShopCategory',
				'foreignKey' => 'parent_id',
				'fields' => array(
					'Parent.id',
					'Parent.name',
					'Parent.slug',
					'Parent.lft',
					'Parent.rght',
					'Parent.parent_id'
				),
				'conditions' => array(),
				'order' => array(
					'Parent.name' => 'ASC'
				)
			),
			'Image' => array(
				'className' => 'Shop.ShopImage',
				'foreignKey' => 'shop_image_id',
				'fields' => array(
					'ShopImage.id',
					'ShopImage.image',
					'ShopImage.width',
					'ShopImage.height'
				),
				'conditions' => array(),
				'order' => array(
					'ShopImage.image' => 'ASC'
				)
			)
		);

		public $hasAndBelongsToMany = array(
			'Product' => array(
				'className' => 'Shop.ShopProduct',
				'foreignKey' => 'shop_product_id',
				'associationForeignKey' => 'category_id',
				'with' => 'Shop.ShopCategoriesProduct',
				'unique' => true,
				'conditions' => '',
				'fields' => array(
					'ShopProduct.id',
					'ShopProduct.name',
					'ShopProduct.cost'
				),
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => ''
			),
			'ShopBranch' => array(
				'className' => 'Shop.ShopShopBranch',
				'foreignKey' => 'branch_id',
				'associationForeignKey' => 'category_id',
				'with' => 'Shop.BranchesCategory',
				'unique' => true,
				'conditions' => '',
				'fields' => array(
					'ShopBranch.id',
					'ShopBranch.branch_id',
				),
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => ''
			),
		);

		public function __construct($id = false, $table = null, $ds = null) {
			parent::__construct($id, $table, $ds);

			$this->order = array(
				$this->alais . '.lft' => 'ASC'
			);
		}

		public function getCategories($category_id = null) {
			$conditions = array(
				$this->alais . '.parent_id IS NULL'
			);

			if((int)$category_id > 0) {
				$conditions = array(
					$this->alais . '.parent_id' => $category_id
				);
			}

			$cacheName = cacheName('categories', $conditions);
			$categories = Cache::read($cacheName, 'shop');
			if($categories !== false) {
				return $categories;
			}

			$categories = $this->find(
				'all',
				array(
					'conditions' => array(
						$conditions
					),
					'fields' => array(
						$this->alais . '.id',
						$this->alais . '.parent_id',
						$this->alais . '.name',
						$this->alais . '.slug',
						$this->alais . '.product_count'
					)
				)
			);

			Cache::write($cacheName, $categories, 'shop');

			return $categories;
		}

		public function getActiveCategories() {
			$cacheName = cacheName('categories_active', $conditions);
			$category_ids = Cache::read($cacheName, 'shop');
			if($category_ids !== false) {
				return $category_ids;
			}

			$category_ids = $this->find(
				'list',
				array(
					'fields' => array(
						$this->alais . '.id',$this->alais . '.id'
					),
					'conditions' => array(
						$this->alais . '.active' => 1
					)
				)
			);

			Cache::write($cacheName, $category_ids, 'shop');

			return $category_ids;
		}
	}