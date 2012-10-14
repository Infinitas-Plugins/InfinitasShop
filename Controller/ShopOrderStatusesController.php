<?php
/**
 * ShopOrderStatuses controller
 *
 * @brief Add some documentation for ShopOrderStatuses controller.
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

class ShopOrderStatusesController extends ShopAppController {
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
 * Show a paginated list of ShopOrderStatus records.
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

		$shopOrderStatuses = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
		);

		$statuses = $this->{$this->modelClass}->statuses();
		$this->set(compact('shopOrderStatuses', 'filterOptions', 'statuses'));
	}

/**
 * @brief admin create action
 *
 * Adding new ShopOrderStatus records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_add() {
		parent::admin_add();

		$statuses = $this->{$this->modelClass}->statuses();
		$this->set(compact('statuses'));
	}

/**
 * @brief admin edit action
 *
 * Edit old ShopOrderStatus records.
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		parent::admin_edit($id);

		$statuses = $this->{$this->modelClass}->statuses();
		$this->set(compact('statuses'));
	}
}