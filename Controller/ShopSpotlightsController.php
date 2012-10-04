<?php
	class ShopSpotlightsController extends ShopAppController {
		public function index() {
			$this->Paginator->settings = array(
				'fields' => array(
					$this->modelClass . '.id',
					$this->modelClass . '.image_id',
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

			$spotlights = $this->Paginator->paginate('Spotlight');

			$specials = $this->{$this->modelClass}->Product->Special->getSpecials(5);
			$this->set(compact('spotlights', 'specials'));
		}

		public function admin_index() {
			$this->Paginator->settings = array(
				'fields' => array(
					$this->modelClass . '.id',
					$this->modelClass . '.product_id',
					$this->modelClass . '.image_id',
					$this->modelClass . '.start_date',
					$this->modelClass . '.end_date',
					$this->modelClass . '.start_time',
					$this->modelClass . '.end_time',
					$this->modelClass . '.active',
					$this->modelClass . '.modified',
				),
				'contain' => array(
					'Product' => array(
						'Image',
						'Special'
					),
					'Image'
				)
			);

			$spotlights = $this->Paginator->paginate(
				null,
				$this->Filter->filter
			);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'product_id' => $this->{$this->modelClass}->Product->find('list'),
				'active' => (array)Configure::read('CORE.active_options')
			);
			$this->set(compact('spotlights','filterOptions'));
		}

		public function admin_add() {
			parent::admin_add();

			$shopBranches = $this->{$this->modelClass}->ShopBranch->getList();
			$products = $this->{$this->modelClass}->Product->find('list');
			$images = $this->{$this->modelClass}->Image->getImagePaths();
			$this->set(compact('shopBranches', 'products', 'images'));
		}

		public function admin_edit($id = null) {
			parent::admin_edit($id);

			$shopBranches = $this->{$this->modelClass}->ShopBranch->getList();
			$products = $this->{$this->modelClass}->Product->find('list');
			$images = $this->{$this->modelClass}->Image->getImagePaths();
			$this->set(compact('shopBranches', 'products', 'images'));
		}
	}