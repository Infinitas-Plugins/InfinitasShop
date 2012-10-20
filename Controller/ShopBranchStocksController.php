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
	public function beforeFilter() {
		parent::beforeFilter();

		$this->notice['updated'] = array(
			'message' => __d('shop', 'Stock levels have been updted'),
			'redirect' => ''
		);

		$this->notice['not_updated'] = array(
			'message' => __d('shop', 'Stock levels were not updted'),
			'redirect' => false,
			'level' => 'warning'
		);
	}

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
			'ShopProduct.name',
			'ShopBranch.name'
		);

		$shopBranches = $this->{$this->modelClass}->ShopBranch->find('list', array(
			'fields' => array(
				$this->{$this->modelClass}->ShopBranch->alias . '.' . $this->{$this->modelClass}->ShopBranch->primaryKey,
				$this->{$this->modelClass}->ShopBranch->ContactBranch->alias . '.' . $this->{$this->modelClass}->ShopBranch->ContactBranch->displayField
			),
			'joins' => array(
				$this->{$this->modelClass}->ShopBranch->autoJoinModel(array(
					'from' => $this->{$this->modelClass}->ShopBranch->fullModelName(),
					'model' => $this->{$this->modelClass}->ShopBranch->ContactBranch->fullModelName(),
					'type' => 'left'
				))
			)
		));
		$this->set(compact('shopBranchStocks', 'shopBranches', 'filterOptions'));
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
		if(!empty($this->request->data[$this->modelClass]['change'])) {
			$method = 'addStock';
			if($this->request->data[$this->modelClass]['change'] < 0) {
				$method = 'removeStock';
			}

			if($this->{$this->modelClass}->{$method}($this->request->data[$this->modelClass])) {
				$this->notice('updated');
			}

			$this->notice('not_updated');
		}

		$shopBranches = $this->ShopBranchStock->ShopBranch->find('list');
		$shopProducts = $this->ShopBranchStock->ShopProduct->find('list');
		$this->set(compact('shopBranches', 'shopProducts'));

		$this->saveRedirectMarker();
	}

}