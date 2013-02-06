<?php
/**
 * ShopProductAttributes controller
 *
 * @brief Add some documentation for ShopProductAttributes controller.
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

class ShopProductAttributesController extends ShopAppController {

/**
 * @brief the index method
 *
 * Show a paginated list of ShopProductAttribute records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		$this->Paginator->settings = array(
			'contain' => array(
				'ShopAttribute',
				'ShopProduct',
			)
		);

		$shopProductAttributes = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'id',
		);

		$this->set(compact('shopProductAttributes', 'filterOptions'));
	}

/**
 * @brief view method for a single row
 *
 * Show detailed information on a single ShopProductAttribute
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

		$shopProductAttribute = $this->ShopProductAttribute->getViewData(
			array($this->ShopProductAttribute->alias . '.' . $this->ShopProductAttribute->primaryKey => $id)
		);

		$this->set(compact('shopProductAttribute'));
	}

/**
 * @brief admin create action
 *
 * Adding new ShopProductAttribute records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_add() {
		parent::admin_add();

		$shopAttributes = $this->ShopProductAttribute->ShopAttribute->find('list');
		$shopProducts = $this->ShopProductAttribute->ShopProduct->find('list');
		$this->set(compact('shopAttributes', 'shopProducts'));
	}

/**
 * @brief admin edit action
 *
 * Edit old ShopProductAttribute records.
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		parent::admin_edit($id);

		$shopAttributes = $this->ShopProductAttribute->ShopAttribute->find('list');
		$shopProducts = $this->ShopProductAttribute->ShopProduct->find('list');
		$this->set(compact('shopAttributes', 'shopProducts'));
	}
}