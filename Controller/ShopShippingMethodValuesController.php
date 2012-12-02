<?php
/**
 * ShopShippingMethodValues controller
 *
 * Add some documentation for ShopShippingMethodValues controller.
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

class ShopShippingMethodValuesController extends ShopAppController {
	public function beforeFilter() {
		parent::beforeFilter();
		
		$this->notice['option_not_selected'] = array(
			'message' => __d('shop', 'No shipping method selected'),
			'redirect' => array(
				'controller' => 'shop_shipping_methods',
				'action' => 'index'
			),
			'level' => 'warning'
		);
	}

/**
 * the index method
 *
 * Show a paginated list of ShopShippingMethodValue records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		if (empty($this->Filter->filter)) {
			$this->notice('option_not_selected');
		}
		$this->Paginator->settings = array(
			'contain' => array(
				'ShopShippingMethod',
			)
		);

		$shopShippingMethodValues = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
			'active' => (array)Configure::read('CORE.active_options'),
		);

		$this->set(compact('shopShippingMethodValues', 'filterOptions'));
	}

/**
 * view method for a single row
 *
 * Show detailed information on a single ShopShippingMethodValue
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

		$shopShippingMethodValue = $this->ShopShippingMethodValue->getViewData(
			array($this->ShopShippingMethodValue->alias . '.' . $this->ShopShippingMethodValue->primaryKey => $id)
		);

		$this->set(compact('shopShippingMethodValue'));
	}

/**
 * admin create action
 *
 * Adding new ShopShippingMethodValue records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_add() {
		parent::admin_add();

		$shopShippingMethods = $this->ShopShippingMethodValue->ShopShippingMethod->find('list');
		$this->set(compact('shopShippingMethods'));
	}

/**
 * admin edit action
 *
 * Edit old ShopShippingMethodValue records.
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		parent::admin_edit($id);

		$shopShippingMethods = $this->ShopShippingMethodValue->ShopShippingMethod->find('list');
		$this->set(compact('shopShippingMethods'));
	}
}