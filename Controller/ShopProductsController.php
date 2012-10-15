<?php
/**
 * ShopProducts controller
 *
 * @brief Add some documentation for ShopProducts controller.
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
/**
 * @brief the index method
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
			'active' => (array)Configure::read('CORE.active_options'),
		);

		$this->set(compact('shopProducts', 'filterOptions'));
	}

/**
 * @brief view method for a single row
 *
 * Show detailed information on a single ShopProduct
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to find
 *
 * @return void
 */
	public function admin_view($id = null) {
		if(!$id) {
			$this->Infinitas->noticeInvalidRecord();
		}

		$shopProduct = $this->ShopProduct->getViewData(
			array($this->ShopProduct->alias . '.' . $this->ShopProduct->primaryKey => $id)
		);

		$this->set(compact('shopProduct'));
	}

/**
 * @brief admin create action
 *
 * Adding new ShopProduct records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_add() {
		parent::admin_add();

		$shopImages = $this->ShopProduct->ShopImage->find('list');
		$shopSuppliers = $this->ShopProduct->ShopSupplier->find('list');
		$shopBrands = $this->ShopProduct->ShopBrand->find('list');
		$shopProductTypes = $this->ShopProduct->ShopProductType->find('list');
		$shopBranches = $this->ShopProduct->ShopBranchStock->ShopBranch->find('all', array(
			'contain' => array(
				'ContactBranch.name',
				'Manager.full_name'
			)
		));
		$this->set(compact('shopImages', 'shopSuppliers', 'shopBrands', 'shopProductTypes', 'shopBranches'));
	}

/**
 * @brief admin edit action
 *
 * Edit old ShopProduct records.
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		parent::admin_edit($id);

		$shopImages = $this->ShopProduct->ShopImage->find('list');
		$shopSuppliers = $this->ShopProduct->ShopSupplier->find('list');
		$shopBrands = $this->ShopProduct->ShopBrand->find('list');
		$shopProductTypes = $this->ShopProduct->ShopProductType->find('list');
		$shopBranches = $this->ShopProduct->ShopBranchStock->ShopBranch->find('list');
		$this->set(compact('shopImages', 'shopSuppliers', 'shopBrands', 'shopProductTypes', 'shopBranches'));
	}
}