<?php
/**
 * ShopPaymentMethods controller
 *
 * @brief Add some documentation for ShopPaymentMethods controller.
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

class ShopPaymentMethodsController extends ShopAppController {

/**
 * @brief the index method
 *
 * Show a paginated list of ShopPaymentMethod records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function index() {
		$this->Paginator->settings = array(
			'contain' => array(
			)
		);

		$shopPaymentMethods = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
			'active' => (array)Configure::read('CORE.active_options'),
		);

		$this->set(compact('shopPaymentMethods', 'filterOptions'));
	}

/**
 * @brief the index method
 *
 * Show a paginated list of ShopPaymentMethod records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		$this->Paginator->settings = array(
			'contain' => array(
				'InfinitasPaymentMethod'
			)
		);

		$shopPaymentMethods = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
			'active' => (array)Configure::read('CORE.active_options'),
		);

		$this->set(compact('shopPaymentMethods', 'filterOptions'));
	}

	public function admin_add() {
		parent::admin_add();

		$infinitasPaymentMethods = $this->{$this->modelClass}->InfinitasPaymentMethod->find('list');
		$this->set(compact('infinitasPaymentMethods'));
	}

	public function admin_edit($id = null) {
		parent::admin_edit($id);

		$infinitasPaymentMethods = $this->{$this->modelClass}->InfinitasPaymentMethod->find('list');
		$this->set(compact('infinitasPaymentMethods'));
	}

}