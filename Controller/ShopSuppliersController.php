<?php
/**
 * ShopSuppliers controller
 *
 * Add some documentation for ShopSuppliers controller.
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

class ShopSuppliersController extends ShopAppController {
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
 * the index method
 *
 * Show a paginated list of ShopSupplier records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		$this->Paginator->settings = array(
			'contain' => array(
				'ContactAddress',
			)
		);

		$shopSuppliers = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
			'active' => (array)Configure::read('CORE.active_options'),
		);

		$this->set(compact('shopSuppliers', 'filterOptions'));
	}

/**
 * view method for a single row
 *
 * Show detailed information on a single ShopSupplier
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

		$shopSupplier = $this->ShopSupplier->getViewData(
			array($this->ShopSupplier->alias . '.' . $this->ShopSupplier->primaryKey => $id)
		);

		$this->set(compact('shopSupplier'));
	}

/**
 * admin create action
 *
 * Adding new ShopSupplier records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_add() {
		parent::admin_add();

		$contactAddresses = $this->ShopSupplier->ContactAddress->find('list');
		$this->set(compact('contactAddresses'));
	}

/**
 * admin edit action
 *
 * Edit old ShopSupplier records.
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		parent::admin_edit($id);

		$contactAddresses = $this->ShopSupplier->ContactAddress->find('list');
		$this->set(compact('contactAddresses'));
	}
}