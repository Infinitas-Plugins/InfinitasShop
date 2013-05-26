<?php
/**
 * ShopAddresses controller
 *
 * @brief Add some documentation for ShopAddresses controller.
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

class ShopAddressesController extends ShopAppController {

/**
 * @brief the index method
 *
 * Show a paginated list of ShopAddress records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function index() {
		$this->Paginator->settings = array(
			'contain' => array(
				'User',
			)
		);

		$shopAddresses = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
		);

		$this->set(compact('shopAddresses', 'filterOptions'));
	}

/**
 * @brief view method for a single row
 *
 * Show detailed information on a single ShopAddress
 *
 * @todo update the documentation 
 * @param mixed $id int or string uuid or the row to find
 *
 * @return void
 */
	public function view($id = null) {
		if (!$id) {
			$this->Infinitas->noticeInvalidRecord();
		}

		$shopAddress = $this->ShopAddress->getViewData(
			array($this->ShopAddress->alias . '.' . $this->ShopAddress->primaryKey => $id)
		);

		$this->set(compact('shopAddress'));
	}

/**
 * @brief the index method
 *
 * Show a paginated list of ShopAddress records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		$this->Paginator->settings = array(
			'contain' => array(
				'User',
			)
		);

		$shopAddresses = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
		);

		$this->set(compact('shopAddresses', 'filterOptions'));
	}

/**
 * @brief view method for a single row
 *
 * Show detailed information on a single ShopAddress
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

		$shopAddress = $this->ShopAddress->getViewData(
			array($this->ShopAddress->alias . '.' . $this->ShopAddress->primaryKey => $id)
		);

		$this->set(compact('shopAddress'));
	}

/**
 * @brief admin create action
 *
 * Adding new ShopAddress records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_add() {
		parent::admin_add();

		$users = $this->ShopAddress->User->find('list');
		$this->set(compact('users'));
	}

/**
 * @brief admin edit action
 *
 * Edit old ShopAddress records.
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		parent::admin_edit($id);

		$users = $this->ShopAddress->User->find('list');
		$this->set(compact('users'));
	}
}