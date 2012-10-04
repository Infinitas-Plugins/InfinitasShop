<?php
	class ShopCategoriesController extends ShopAppController {
		public function index() {
			$conditions = array(
				$this->modelClass . '.active' => 1,
				$this->modelClass . '.parent_id IS NULL'
			);

			$category_id = null;
			if (isset($this->request->params['slug']) && !empty($this->request->params['slug'])) {
				$id = $this->{$this->modelClass}->find(
					'first',
					array(
						'conditions' => array(
							$this->modelClass . '.slug' => $this->request->params['slug']
						),
						'fields' => array(
							$this->modelClass . '.id',
							$this->modelClass . '.name',
							$this->modelClass . '.slug',
							$this->modelClass . '.parent_id'
						),
						'contain' => array(
							'Parent'
						)
					)
				);

				$parent = Set::extract('/Parent', $id);
				$currentCategory[$this->modelClass] = isset($parent[0]['Parent']) ? $parent[0]['Parent'] : null;

				$category_id = isset($id[$this->modelClass]['id']) ? $id[$this->modelClass]['id'] : null;

				if($id) {
					$conditions = array(
						$this->modelClass . '.parent_id' => $category_id
					);
				}

			}

			$this->Paginator->settings = array(
				'fields' => array(
					$this->modelClass . '.id',
					$this->modelClass . '.name',
					$this->modelClass . '.slug',
					$this->modelClass . '.keywords',
					$this->modelClass . '.image_id',
				),
				'conditions' => $conditions,
				'contain' => array(
					'Image'
				)
			);

			$categories = $this->Paginator->paginate($this->modelClass);
			$products = $this->{$this->modelClass}->Product->find(
				'all',
				array(
					'conditions' => array(
						'Product.id' => $this->{$this->modelClass}->Product->getActiveProducts($category_id)
					),
					'contain' => array(
						$this->modelClass,
						'Image',
						'Special',
						'Spotlight'
					),
					'limit' => 10
				)
			);

			$specials = $this->{$this->modelClass}->Product->Special->getSpecials(5);
			$spotlights = $this->{$this->modelClass}->Product->Spotlight->getSpotlights(5);
			$this->set(compact('categories', 'products', 'currentCategory', 'specials', 'spotlights'));
		}

		public function admin_index() {
			$this->Paginator->settings = array(
				'fields' => array(
					$this->modelClass . '.id',
					$this->modelClass . '.name',
					$this->modelClass . '.slug',
					$this->modelClass . '.image_id',
					$this->modelClass . '.active',
					$this->modelClass . '.lft',
					$this->modelClass . '.rght',
					$this->modelClass . '.parent_id',
					$this->modelClass . '.modified'
				),
				'contain' => array(
					'Parent',
					'Image',
					'ShopBranch' => array(
						'BranchDetail'
					)
				)
			);

			$categories = $this->Paginator->paginate(
				null,
				$this->Filter->filter
			);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'name',
				'active' => (array)Configure::read('CORE.active_options'),
				'parent_id' => $this->{$this->modelClass}->generateTreeList(null, null, null, '_')
			);
			$this->set(compact('categories','filterOptions'));
		}

		public function admin_add() {
			parent::admin_add();

			$parents = $this->{$this->modelClass}->generateTreeList(null, null, null, '_');
			$images = $this->{$this->modelClass}->Image->getImagePaths();
			$branches = $this->{$this->modelClass}->ShopBranch->find('list');
			$this->set(compact('parents', 'images', 'branches'));
		}

		public function admin_edit($id = null) {
			parent::admin_edit($id);

			$parents = $this->{$this->modelClass}->generateTreeList(null, null, null, '_');
			$images = $this->{$this->modelClass}->Image->getImagePaths();
			$shopBranches = $this->{$this->modelClass}->ShopBranch->find('list');
			$this->set(compact('parents', 'images', 'shopBranches'));
		}
	}