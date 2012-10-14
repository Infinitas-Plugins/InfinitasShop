<?php
/**
 * ShopBranchStocks controller
 *
 * @brief Add some documentation for ShopBranchStocks controller.
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

class ShopBranchStocksController extends ShopAppController {
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
 * Show a paginated list of ShopBranchStock records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		$this->Paginator->settings = array('stockList');

		$shopBranchStocks = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'id',
		);

		$shopBranches = $this->{$this->modelClass}->ShopBranch->find('list', array(
			'fields' => array(
				$this->{$this->modelClass}->ShopBranch->alias . '.' . $this->{$this->modelClass}->ShopBranch->primaryKey,
				$this->{$this->modelClass}->ShopBranch->ContactBranch->alias . '.' . $this->{$this->modelClass}->ShopBranch->ContactBranch->displayField
			),
			'joins' => array(
				$this->{$this->modelClass}->ShopBranch->autoJoinModel($this->{$this->modelClass}->ShopBranch->ContactBranch->fullModelName())
			)
		));
		$this->set(compact('shopBranchStocks', 'shopBranches', 'filterOptions'));
	}

/**
 * @brief view method for a single row
 *
 * Show detailed information on a single ShopBranchStock
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

		$shopBranchStock = $this->ShopBranchStock->getViewData(
			array($this->ShopBranchStock->alias . '.' . $this->ShopBranchStock->primaryKey => $id)
		);

		$this->set(compact('shopBranchStock'));
	}

/**
 * @brief admin create action
 *
 * Adding new ShopBranchStock records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_add() {
		parent::admin_add();

		$shopBranches = $this->ShopBranchStock->ShopBranch->find('list');
		$shopProducts = $this->ShopBranchStock->ShopProduct->find('list');
		$this->set(compact('shopBranches', 'shopProducts'));
	}

/**
 * @brief admin edit action
 *
 * Edit old ShopBranchStock records.
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		parent::admin_edit($id);

		$shopBranches = $this->ShopBranchStock->ShopBranch->find('list');
		$shopProducts = $this->ShopBranchStock->ShopProduct->find('list');
		$this->set(compact('shopBranches', 'shopProducts'));
	}
}