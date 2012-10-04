<?php
	class ShopSpecialsController extends ShopAppController {
		public function index() {
			$this->Paginator->settings = array(
				'fields' => array(
					$this->modelClass . '.id',
					$this->modelClass . '.image_id',
					$this->modelClass . '.amount',
					$this->modelClass . '.active',
					$this->modelClass . '.start_date',
					$this->modelClass . '.end_date'
				),
				'conditions' => array(
					$this->modelClass . '.active' => 1,
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

			$specials = $this->Paginator->paginate('Special');

			$spotlights = $this->{$this->modelClass}->Product->Spotlight->getSpotlights(5);
			$this->set(compact('specials', 'spotlights'));
		}

		public function admin_index() {
			$this->Paginator->settings = array(
				'fields' => array(
					$this->modelClass . '.id',
					$this->modelClass . '.product_id',
					$this->modelClass . '.image_id',
					$this->modelClass . '.discount',
					$this->modelClass . '.amount',
					$this->modelClass . '.start_date',
					$this->modelClass . '.end_date',
					$this->modelClass . '.start_time',
					$this->modelClass . '.end_time',
					$this->modelClass . '.active',
					$this->modelClass . '.modified',
				),
				'contain' => array(
					'Product' => array(
						'Image'
					),
					'Image'
				)
			);

			$specials = $this->Paginator->paginate(
				null,
				$this->Filter->filter
			);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'product_id' => $this->{$this->modelClass}->Product->find('list'),
				'active' => (array)Configure::read('CORE.active_options')
			);
			$this->set(compact('specials','filterOptions'));
		}

		public function admin_add() {
			parent::admin_add();

			$shopBranches = $this->{$this->modelClass}->ShopBranch->getList();
			$products = $this->{$this->modelClass}->Product->find('list');
			$images = $this->{$this->modelClass}->Image->getImagePaths();

			$maxPrice = $this->{$this->modelClass}->Product->find(
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

			$minPrice = $this->{$this->modelClass}->Product->find(
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

		public function admin_edit($id = null) {
			parent::admin_edit($id);

			$shopBranches = $this->{$this->modelClass}->ShopBranch->getList();
			$products = $this->{$this->modelClass}->Product->find('list');
			$images = $this->{$this->modelClass}->Image->getImagePaths();
			$this->set(compact('shopBranches', 'products', 'images'));
		}

		public function admin_getPrices() {
			$this->set(
				'json',
				$this->{$this->modelClass}->Product->find(
					'first',
					array(
						'conditions' => array(
							'Product.id' => $this->request->params['named']['product']
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