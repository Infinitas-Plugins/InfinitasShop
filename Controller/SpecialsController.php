<?php
	class SpecialsController extends ShopAppController {
		public function index(){
			$this->paginate = array(
				'fields' => array(
					'Special.id',
					'Special.image_id',
					'Special.amount',
					'Special.active',
					'Special.start_date',
					'Special.end_date'
				),
				'conditions' => array(
					'Special.active' => 1,
					'and' => array(
						'start <= ' => date('Y-m-d H:i:s'),
						'end >= '   => date('Y-m-d H:i:s')
					)
				),
				'contain' => array(
					'Image',
					'Product' => array(
						'Image',
						'ShopCategory'
					)
				)
			);

			$specials = $this->paginate('Special');

			$spotlights = $this->Special->Product->Spotlight->getSpotlights(5);
			$this->set(compact('specials', 'spotlights'));
		}

		public function admin_index(){
			$this->paginate = array(
				'fields' => array(
					'Special.id',
					'Special.product_id',
					'Special.image_id',
					'Special.discount',
					'Special.amount',
					'Special.start_date',
					'Special.end_date',
					'Special.start_time',
					'Special.end_time',
					'Special.active',
					'Special.modified',
				),
				'contain' => array(
					'Product' => array(
						'Image'
					),
					'Image'
				)
			);

			$specials = $this->paginate(
				null,
				$this->Filter->filter
			);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'product_id' => $this->Special->Product->find('list'),
				'active' => (array)Configure::read('CORE.active_options')
			);
			$this->set(compact('specials','filterOptions'));
		}

		public function admin_add(){
			parent::admin_add();

			$shopBranches = $this->Special->ShopBranch->getList();
			$products = $this->Special->Product->find('list');
			$images = $this->Special->Image->getImagePaths();

			$maxPrice = $this->Special->Product->find(
				'all',
				array(
					'fields' => array(
						'Product.price'
					),
					'order' => array(
						'Product.price' => 'DESC'
					)
				)
			);
			$maxPrice = isset($maxPrice[0]['Product']['price']) ? $maxPrice[0]['Product']['price'] : 1000;

			$minPrice = $this->Special->Product->find(
				'all',
				array(
					'fields' => array(
						'Product.cost'
					),
					'order' => array(
						'Product.cost' => 'ASC'
					)
				)
			);
			$minPrice = isset($minPrice[0]['Product']['cost']) ? $minPrice[0]['Product']['cost'] : 0;

			$this->set(compact('shopBranches', 'products', 'images', 'minPrice', 'maxPrice'));
		}

		public function admin_edit($id = null){
			parent::admin_edit($id);

			$shopBranches = $this->Special->ShopBranch->getList();
			$products = $this->Special->Product->find('list');
			$images = $this->Special->Image->getImagePaths();
			$this->set(compact('shopBranches', 'products', 'images'));
		}

		public function admin_getPrices(){
			$this->set(
				'json',
				$this->Special->Product->find(
					'first',
					array(
						'conditions' => array(
							'Product.id' => $this->params['named']['product']
						),
						'fields' => array(
							'Product.price',
							'Product.retail',
							'Product.cost',
						)
					)
				)
			);
		}
	}