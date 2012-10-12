<?php
/**
 * ShopShippingMethods controller
 *
 * @brief Add some documentation for ShopShippingMethods controller.
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

class ShopShippingMethodsController extends ShopAppController {
/**
 * The helpers linked to this controller
 *
 * @access public
 * @var array
 */
	public $helpers = array(
		//'Shop.Shop', // uncoment this for a custom plugin controller
		//'Libs.Gravatar',
	);

/**
 * @brief the index method
 *
 * Show a paginated list of ShopShippingMethod records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		$this->Paginator->settings = array(
			'contain' => array(
			)
		);

		$shopShippingMethods = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
			'active' => (array)Configure::read('CORE.active_options'),
		);

		$this->set(compact('shopShippingMethods', 'filterOptions'));
	}

/**
 * @brief view method for a single row
 *
 * Show detailed information on a single ShopShippingMethod
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

		$shopShippingMethod = $this->ShopShippingMethod->getViewData(
			array($this->ShopShippingMethod->alias . '.' . $this->ShopShippingMethod->primaryKey => $id)
		);

		$this->set(compact('shopShippingMethod'));
	}

/**
 * @brief admin create action
 *
 * Adding new ShopShippingMethod records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_add() {
		parent::admin_add();

	}

/**
 * @brief admin edit action
 *
 * Edit old ShopShippingMethod records.
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		parent::admin_edit($id);

	}
}