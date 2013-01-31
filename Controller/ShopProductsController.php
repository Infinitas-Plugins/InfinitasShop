<?php
/**
 * ShopProducts controller
 *
 * Add some documentation for ShopProducts controller.
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link		  http://infinitas-cms.org/Shop
 * @package	   Shop.Controller
 * @license	   http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author dogmatic69
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */

class ShopProductsController extends ShopAppController {
	public function beforeFilter() {
		parent::beforeFilter();

		$this->notice['no_search'] = array(
			'message' => __d('shop', 'No search string provided'),
			'level' => 'warning',
			'redirect' => ''
		);
	}

/**
 * product search
 *
 * If a simple search is done (single field) a PRG (post redirect get) is done so
 * that search results can be linked and saved.
 */
	public function search() {
		if ($this->request->is('post')) {
			$simpleSearch = !empty($this->request->data[$this->modelClass]) && count($this->request->data[$this->modelClass]) == 1;
			if ($simpleSearch) {
				$this->redirect(array(
					'action' => 'search',
					current($this->request->data[$this->modelClass])
				));
			}
		}

		if ($this->request->is('get')) {
			if (empty($this->request->params['pass'])) {
				$this->notice('no_search');
			}

			$this->Paginator->settings = array(
				'search',
				'search' => current($this->request->params['pass'])
			);

			$this->_productList();
			return $this->render('index');
		}
	}

/**
 * view an index of the products
 *
 * This should generally be accompanied by a category slug so that a sub set of
 * products are displayed.
 *
 * If no category is present all products will be paginated.
 *
 * @return void
 */
	public function index() {
		if (empty($this->request->category)) {
			$this->request->category = null;
		}
		$this->Paginator->settings = array(
			'paginated',
			'category' => $this->request->category
		);

		$this->_productList();
	}

	protected function _productList() {
		$shopProducts = $this->Paginator->paginate(null, $this->Filter->filter);
		$shopCategories = $this->{$this->modelClass}->ShopCategoriesProduct->ShopCategory->find('level', $this->request->category);

		$currentCategory = $parentCategory = $categoryPath = array();
		if ($this->request->category) {
			$currentCategory = $this->{$this->modelClass}->ShopCategoriesProduct->ShopCategory->find('current', $this->request->category);
			$parentCategory = $this->{$this->modelClass}->ShopCategoriesProduct->ShopCategory->find('parent', $this->request->category);
			$categoryPath = $this->{$this->modelClass}->ShopCategoriesProduct->ShopCategory->getPath($this->request->category);
			if (empty($parentCategory)) {
				$parentCategory = array('ShopCategory' => array(
					'name' => __d('shop', 'All Categories'),
					'slug' => null
				));
			}
			if (!empty($currentCategory['ShopCategory']['id'])) {
				$this->set('seoMetaDescription', $currentCategory['ShopCategory']['description']);
			}
		}

		$this->_canonicalUrl();


		$this->set(compact('shopProducts', 'shopCategories', 'currentCategory', 'parentCategory', 'categoryPath'));
	}

	public function view() {
		if (empty($this->request->slug) || empty($this->request->category)) {
			$this->notice('not_found');
		}

		$shopProduct = $this->{$this->modelClass}->find('product', $this->request->slug);
		$categoryPath = $this->{$this->modelClass}->ShopCategoriesProduct->ShopCategory->getPath($this->request->category);

		$this->set(compact('shopProduct', 'categoryPath'));
	}

/**
 * set the canonical url
 *
 * If the current url matches the calculated canonical url then indexing will be
 * set to true allowing spiders to index the page. If it does not mathc
 * (pagination etc) it will set to false so that the page is not indexed.
 *
 * @return void
 */
	protected function _canonicalUrl() {
		$url = array(
			'plugin' => 'shop',
			'controller' => 'shop_products',
			'action' => $this->request->params['action']
		);
		if (!empty($this->request->category)) {
			$url['category'] = $this->request->category;
		}
		if (!empty($this->request->slug)) {
			$url['slug'] = $this->request->slug;
		}
		if ($this->request->params['action'] == 'search' && !empty($this->request->params['pass'][0])) {
			$url[] = $this->request->params['pass'][0];
		}

		if (InfinitasRouter::url($url, false) !== $this->request->here) {
			$this->set('seoContentIndex', false);
		}
		$this->set('seoCanonicalUrl', $url);
	}

/**
 * the index method
 *
 * Show a paginated list of ShopProduct records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		$this->Paginator->settings = array('adminPaginated');

		$shopProducts = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
			'shop_product_type_id' => $this->{$this->modelClass}->ShopProductType->find('list'),
			'shop_brand_id' => $this->{$this->modelClass}->ShopBrand->find('list'),
			'shop_supplier_id' => $this->{$this->modelClass}->ShopSupplier->find('list'),
			'active' => (array)Configure::read('CORE.active_options'),
		);

		$this->set(compact('shopProducts', 'filterOptions'));
	}

	public function admin_matrix($id = null) {
		if (!$id) {
			$this->notice('not_found');
		}

		$shopProduct = $this->{$this->modelClass}->find('product', array(
			'admin' => true,
			$id
		));
		$this->set(compact('shopProduct'));
	}

/**
 * view method for a single row
 *
 * Show detailed information on a single ShopProduct
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to find
 *
 * @return void
 */
	public function admin_view($id = null) {
		if (!$id) {
			$this->Infinitas->noticeInvalidRecord();
		}

		$shopProduct = $this->ShopProduct->getViewData(
			array($this->ShopProduct->alias . '.' . $this->ShopProduct->primaryKey => $id)
		);

		$this->set(compact('shopProduct'));
	}

/**
 * admin create action
 *
 * Adding new ShopProduct records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_add() {
		if (!empty($this->request->data)) {
			$this->request->data['ShopBranchStock'][0]['shop_branch_id'] = '5076d76c-6710-47cc-8f7e-0aeac0a80102';
			try {
				if ($this->{$this->modelClass}->saveProduct($this->request->data)) {
					$this->notice('saved');
				}
				$this->notice('not_saved');
			} catch(Exception $e) {
				$this->notice($e);
			}
		}

		$shopImages = $this->ShopProduct->ShopImage->find('list');
		$shopCategories = $this->ShopProduct->ShopCategoriesProduct->ShopCategory->generateTreeList();
		$shopSuppliers = $this->ShopProduct->ShopSupplier->find('list');
		$shopBrands = $this->ShopProduct->ShopBrand->find('list');
		$shopProductTypes = $this->ShopProduct->ShopProductType->find('list');
		$shopBranches = $this->ShopProduct->ShopBranchStock->ShopBranch->find('all', array(
			'contain' => array(
				'ContactBranch.name',
				'Manager.full_name'
			)
		));
		$this->set(compact('shopImages', 'shopCategories', 'shopSuppliers', 'shopBrands', 'shopProductTypes', 'shopBranches'));
	}

/**
 * admin edit action
 *
 * Edit old ShopProduct records.
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		if (!empty($this->request->data)) {
			$this->request->data['ShopBranchStock'][0]['shop_branch_id'] = '5076d76c-6710-47cc-8f7e-0aeac0a80102';
			try {
				if ($this->{$this->modelClass}->saveProduct($this->request->data)) {
					$this->notice('saved');
				}
				$this->notice('not_saved');
			} catch(Exception $e) {
				$this->notice($e);
			}
		} else {
			parent::admin_edit($id, array(
				'contain' => array(
					'ShopPrice',
					'ShopSize',
					'ShopImagesProduct',
					'ShopCategoriesProduct'
				)
			));
		}

		$shopImages = $this->ShopProduct->ShopImage->find('list');
		$shopCategories = $this->ShopProduct->ShopCategoriesProduct->ShopCategory->generateTreeList();
		$shopSuppliers = $this->ShopProduct->ShopSupplier->find('list');
		$shopBrands = $this->ShopProduct->ShopBrand->find('list');
		$shopProductTypes = $this->ShopProduct->ShopProductType->find('list');
		$shopBranches = $this->ShopProduct->ShopBranchStock->ShopBranch->find('list');
		$this->set(compact('shopImages', 'shopCategories', 'shopSuppliers', 'shopBrands', 'shopProductTypes', 'shopBranches'));
	}
}