<?php
	class ShopProductsController extends ShopAppController {
		public function dashboard() {
			$specials = $this->{$this->modelClass}->Special->getSpecials();
			$mostViewedProducts = $this->{$this->modelClass}->getMostViewed();
			$spotlights = $this->{$this->modelClass}->Spotlight->getSpotlights();
			$newest = $this->{$this->modelClass}->getNewest();

			$this->set(compact('specials', 'mostViewedProducts', 'spotlights', 'newest'));
		}

		public function index() {
			$this->Paginator->settings = array(
				'fields' => array(
					$this->modelClass . '.id',
					$this->modelClass . '.name',
					$this->modelClass . '.slug',
					$this->modelClass . '.description',
					$this->modelClass . '.image_id',
					$this->modelClass . '.cost',
					$this->modelClass . '.retail',
					$this->modelClass . '.price',
					$this->modelClass . '.active',
					$this->modelClass . '.image_id',
				),
				'conditions' => array(
					$this->modelClass . '.id' => $this->{$this->modelClass}->getActiveProducts(),
				),
				'contain' => array(
					'Image',
					'ShopCategory',
					'Special' => array(
						'Image'
					)
				)
			);

			$products = $this->Paginator->paginate('Product');

			$spotlights = $this->{$this->modelClass}->Spotlight->getSpotlights(5);
			$specials = $this->{$this->modelClass}->Special->getSpecials(5);
			$this->set(compact('products', 'specials', 'spotlights'));
		}

		public function search() {
			if(!isset($this->data['Search']['search'])) {
				$this->notice(
					__d('shop', 'Please enter your search term'),
					array(
						'redirect' => true
					)
				);
			}

			$this->Paginator->settings = array(
				'fields' => array(
					$this->modelClass . '.id',
					$this->modelClass . '.name',
					$this->modelClass . '.slug',
					$this->modelClass . '.description',
					$this->modelClass . '.image_id',
					$this->modelClass . '.cost',
					$this->modelClass . '.retail',
					$this->modelClass . '.price',
					$this->modelClass . '.active',
					$this->modelClass . '.image_id',
				),
				'conditions' => array(
					$this->modelClass . '.id' => $this->{$this->modelClass}->getActiveProducts(),
					'or' => array(
						$this->modelClass . '.name LIKE ' => '%'. $this->data['Search']['search'] .'%',
						$this->modelClass . '.description LIKE ' => '%'. $this->data['Search']['search'] .'%',
						$this->modelClass . '.specifications LIKE ' => '%'. $this->data['Search']['search'] .'%'
					)
				),
				'contain' => array(
					'Image',
					'ShopCategory',
					'Special' => array(
						'Image'
					)
				),
				'limit' => 1
			);

			$products = $this->Paginator->paginate('Product');

			$spotlights = $this->{$this->modelClass}->Spotlight->getSpotlights(5);
			$specials = $this->{$this->modelClass}->Special->getSpecials(5);
			$this->set(compact('products', 'specials', 'spotlights'));
			$this->render('index');
		}

		public function view() {
			if (!isset($this->request->params['slug'])) {
				$this->notice('invalid');
			}

			$conditions = array(
				$this->modelClass . '.id' => $this->{$this->modelClass}->getActiveProducts(),
				$this->modelClass . '.slug' => $this->request->params['slug']
			);

			$product = $this->{$this->modelClass}->find(
				'first',
				array(
					'fields' => array(
					),
					'conditions' => $conditions,
					'contain' => array(
						'ShopCategory' => array(
							'Parent'
						),
						'Image',
						'ProductImage',
						'Special' => array(
							'Image'
						),
						'Spotlight' => array(
							'Image'
						),
						'ShopUnit',
						'Supplier',
						'ShopBranch'
					)
				)
			);

			if(empty($product)) {
				$this->notice('invalid');
			}

			$tabs = array(
				'description' => '/Product/description',
				'specifications' => '/Product/specifications',
				'comments' => 'comments'
			);

			$eventData = $this->Event->trigger('Shop.setupTabs', $tabs);
			if (isset($eventData)) {
			}

			$neighbors = $this->{$this->modelClass}->find(
				'neighbors',
				array(
					'fields' => array(
						$this->modelClass . '.id',
						$this->modelClass . '.name',
						$this->modelClass . '.slug',
						$this->modelClass . '.image_id'
					),
					'contain' => array(
						'Image'
					)
				)
			);

			$specials = $this->{$this->modelClass}->Special->getSpecials(5);
			$spotlights = $this->{$this->modelClass}->Spotlight->getSpotlights(5);
			$this->set(compact('product', 'tabs', 'neighbors', 'specials', 'spotlights'));
		}

		public function admin_dashboard() {

		}

		public function admin_index() {
			$conditions = array();
			if(isset($this->Filter->filter[$this->modelClass . '.category_id'])) {
				$category_id  = $this->Filter->filter[$this->modelClass . '.category_id'];
				unset($this->Filter->filter[$this->modelClass . '.category_id']);
			}
			if(isset($category_id)) {
				$conditions = array(
					$this->modelClass . '.id' => $this->{$this->modelClass}->getActiveProducts($category_id, array(0,1))
				);
			}

			$this->Paginator->settings = array(
				'fields' => array(
					$this->modelClass . '.id',
					$this->modelClass . '.name',
					$this->modelClass . '.slug',
					$this->modelClass . '.active',
					$this->modelClass . '.cost',
					$this->modelClass . '.retail',
					$this->modelClass . '.price',
					$this->modelClass . '.modified',
					$this->modelClass . '.supplier_id',
					$this->modelClass . '.shop_unit_id',
					$this->modelClass . '.image_id'
				),
				'conditions' => $conditions,
				'contain' => array(
					'Image',
					'ShopUnit',
					'Supplier',
					'ShopCategory',
					'ShopBranch' => array(
						'BranchDetail',
					),
					'Special' => array(
						'Image'
					)
				)
			);

			$products = $this->Paginator->paginate(
				null,
				$this->Filter->filter
			);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'name',
				'category_id' => $this->{$this->modelClass}->ShopCategory->generateTreeList(null, null, null, '_'),
				'supplier_id' => $this->{$this->modelClass}->Supplier->find('list'),
				'shop_unit_id' => $this->{$this->modelClass}->ShopUnit->find('list'),
				'active' => (array)Configure::read('CORE.active_options')
			);
			$this->set(compact('products','filterOptions'));
		}

		public function admin_statistics() {
			$this->Paginator->settings = array(
				'fields' => array(
					$this->modelClass . '.id',
					$this->modelClass . '.name',
					$this->modelClass . '.active',
					$this->modelClass . '.views',
					$this->modelClass . '.rating',
					$this->modelClass . '.rating_count',
					$this->modelClass . '.sales',
					$this->modelClass . '.modified',
					$this->modelClass . '.supplier_id',
					$this->modelClass . '.shop_unit_id',
					$this->modelClass . '.image_id',
					$this->modelClass . '.added_to_cart',
					$this->modelClass . '.added_to_wishlist'
				),
				'contain' => array(
					'Image',
					'Supplier',
					'ShopCategory',
					'ShopBranch' => array(
						'BranchDetail',
					)
				)
			);

			$products = $this->Paginator->paginate(
				null,
				$this->Filter->filter
			);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'name',
				'category_id' => $this->{$this->modelClass}->ShopCategory->generateTreeList(null, null, null, '_'),
				'supplier_id' => $this->{$this->modelClass}->Supplier->find('list'),
				'shop_unit_id' => $this->{$this->modelClass}->ShopUnit->find('list'),
				'active' => (array)Configure::read('CORE.active_options')
			);
			$this->set(compact('products','filterOptions'));
		}

		public function admin_add() {
			parent::admin_add();

			$shopCategories = $this->{$this->modelClass}->ShopCategory->generateTreeList(null, null, null, '_');
			$units = $this->{$this->modelClass}->ShopUnit->find('list');
			$suppliers = $this->{$this->modelClass}->Supplier->find('list');
			$shopBranches = $this->{$this->modelClass}->ShopBranch->getList();
			$images = $this->{$this->modelClass}->Image->getImagePaths();
			$this->set(compact('shopCategories', 'units', 'suppliers', 'shopBranches', 'images'));
		}

		public function admin_edit($id = null) {
			parent::admin_edit($id);

			$units          = $this->{$this->modelClass}->ShopUnit->find('list');
			$suppliers      = $this->{$this->modelClass}->Supplier->find('list');
			$images         = $this->{$this->modelClass}->Image->getImagePaths();
			$shopBranches   = $this->{$this->modelClass}->ShopBranch->getList();
			$shopCategories = $this->{$this->modelClass}->ShopCategory->generateTreeList(null, null, null, '_');
			$this->set(compact('shopCategories', 'units', 'suppliers', 'shopBranches', 'images'));
		}
	}