<?php
/**
 * ShopCategories controller
 *
 * @brief Add some documentation for ShopCategories controller.
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

class ShopCategoriesController extends ShopAppController {
/**
 * @brief the index method
 *
 * Show a paginated list of ShopCategory records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		$this->Paginator->settings = array(
			'contain' => array(
				'ParentShopCategory',
				'ShopImage',
				'ShopProductType',
			)
		);

		$shopCategories = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
			'active' => (array)Configure::read('CORE.active_options'),
		);

		$this->set(compact('shopCategories', 'filterOptions'));
	}

/**
 * @brief view method for a single row
 *
 * Show detailed information on a single ShopCategory
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

		$shopCategory = $this->ShopCategory->getViewData(
			array($this->ShopCategory->alias . '.' . $this->ShopCategory->primaryKey => $id)
		);

		$this->set(compact('shopCategory'));
	}

/**
 * @brief admin create action
 *
 * Adding new ShopCategory records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_add() {
		parent::admin_add();

		$shopImages = $this->ShopCategory->ShopImage->find('list');
		$parentShopCategories = $this->ShopCategory->ParentShopCategory->generateTreeList();
		$shopCategoriesProducts = $this->ShopCategory->ShopCategoriesProduct->find('list');
		$shopProductTypes = $this->ShopCategory->ShopProductType->find('list');
		$this->set(compact('shopImages', 'parentShopCategories', 'shopCategoriesProducts', 'shopProductTypes'));
	}

/**
 * @brief admin edit action
 *
 * Edit old ShopCategory records.
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		parent::admin_edit($id);

		$shopImages = $this->ShopCategory->ShopImage->find('list');
		$parentShopCategories = $this->ShopCategory->ParentShopCategory->generateTreeList();
		$shopCategoriesProducts = $this->ShopCategory->ShopCategoriesProduct->find('list');
		$shopProductTypes = $this->ShopCategory->ShopProductType->find('list');
		$this->set(compact('shopImages', 'parentShopCategories', 'shopCategoriesProducts', 'shopProductTypes'));
	}
}