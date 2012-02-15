<?php
	class SpotlightsController extends ShopAppController {
		public function index(){
			$this->paginate = array(
				'fields' => array(
					'Spotlight.id',
					'Spotlight.image_id',
					'Spotlight.active',
					'Spotlight.start_date',
					'Spotlight.end_date'
				),
				'conditions' => array(
					'Spotlight.active' => 1,
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

			$spotlights = $this->paginate('Spotlight');

			$specials = $this->Spotlight->Product->Special->getSpecials(5);
			$this->set(compact('spotlights', 'specials'));
		}

		public function admin_index(){
			$this->paginate = array(
				'fields' => array(
					'Spotlight.id',
					'Spotlight.product_id',
					'Spotlight.image_id',
					'Spotlight.start_date',
					'Spotlight.end_date',
					'Spotlight.start_time',
					'Spotlight.end_time',
					'Spotlight.active',
					'Spotlight.modified',
				),
				'contain' => array(
					'Product' => array(
						'Image',
						'Special'
					),
					'Image'
				)
			);

			$spotlights = $this->paginate(
				null,
				$this->Filter->filter
			);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'product_id' => $this->Spotlight->Product->find('list'),
				'active' => (array)Configure::read('CORE.active_options')
			);
			$this->set(compact('spotlights','filterOptions'));
		}

		public function admin_add(){
			parent::admin_add();

			$shopBranches = $this->Spotlight->ShopBranch->getList();
			$products = $this->Spotlight->Product->find('list');
			$images = $this->Spotlight->Image->getImagePaths();
			$this->set(compact('shopBranches', 'products', 'images'));
		}

		public function admin_edit($id = null){
			parent::admin_edit($id);

			$shopBranches = $this->Spotlight->ShopBranch->getList();
			$products = $this->Spotlight->Product->find('list');
			$images = $this->Spotlight->Image->getImagePaths();
			$this->set(compact('shopBranches', 'products', 'images'));
		}
	}