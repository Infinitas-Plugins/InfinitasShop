<?php
/**
 * ShopSpecials controller
 *
 * Add some documentation for ShopSpecials controller.
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

class ShopSpecialsController extends ShopAppController {
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
 * Show a paginated list of ShopSpecial records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		$this->Paginator->settings = array(
			'contain' => array(
				'ShopProductsSpecial'
			)
		);

		$shopSpecials = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'free_shipping' => array(
				1 => __d('shop', 'Free Shipping'),
				0 => __d('shop', 'Paid shipping')
			),
			'discount' => array(
				1 => __d('shop', 'Percent off'),
				0 => __d('shop', 'Amount off')
			),
			'active' => (array)Configure::read('CORE.active_options'),
		);

		$this->set(compact('shopSpecials', 'filterOptions'));
	}

/**
 * view method for a single row
 *
 * Show detailed information on a single ShopSpecial
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

		$shopSpecial = $this->ShopSpecial->getViewData(
			array($this->ShopSpecial->alias . '.' . $this->ShopSpecial->primaryKey => $id)
		);

		$this->set(compact('shopSpecial'));
	}

/**
 * admin create action
 *
 * Adding new ShopSpecial records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_add() {
		parent::admin_add();

		$shopProducts = $this->{$this->modelClass}->ShopProductsSpecial->ShopProduct->find('list');
		$this->set(compact('shopProducts'));
	}

/**
 * admin edit action
 *
 * Edit old ShopSpecial records.
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		parent::admin_edit($id, array(
			'contain' => array(
				'ShopProductsSpecial'
			)
		));

		$shopProducts = $this->{$this->modelClass}->ShopProductsSpecial->ShopProduct->find('list');
		$this->set(compact('shopProducts'));
	}
}