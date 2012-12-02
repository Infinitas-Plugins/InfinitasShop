<?php
/**
 * ShopBranchStockLogs controller
 *
 * Add some documentation for ShopBranchStockLogs controller.
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

class ShopBranchStockLogsController extends ShopAppController {
/**
 * the index method
 *
 * Show a paginated list of ShopBranchStockLog records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		$this->Paginator->settings = array(
			'fields' => array(
				$this->{$this->modelClass}->alias . '.*',
				$this->{$this->modelClass}->ShopBranchStock->alias . '.*',
				$this->{$this->modelClass}->ShopBranchStock->ShopProduct->fullFieldName($this->{$this->modelClass}->ShopBranchStock->ShopProduct->displayField),
				$this->{$this->modelClass}->ShopBranchStock->ShopBranch->ContactBranch->fullFieldName($this->{$this->modelClass}->ShopBranchStock->ShopBranch->ContactBranch->displayField)
			),
			'joins' => array(
				$this->{$this->modelClass}->autoJoinModel($this->{$this->modelClass}->ShopBranchStock->fullModelName()),
				$this->{$this->modelClass}->autoJoinModel(array(
					'from' => $this->{$this->modelClass}->ShopBranchStock->fullModelName(),
					'model' => $this->{$this->modelClass}->ShopBranchStock->ShopProduct->fullModelName(),
				)),
				$this->{$this->modelClass}->autoJoinModel(array(
					'from' => $this->{$this->modelClass}->ShopBranchStock->fullModelName(),
					'model' => $this->{$this->modelClass}->ShopBranchStock->ShopBranch->fullModelName()
				)),
				$this->{$this->modelClass}->autoJoinModel(array(
					'from' => $this->{$this->modelClass}->ShopBranchStock->ShopBranch->fullModelName(),
					'model' => $this->{$this->modelClass}->ShopBranchStock->ShopBranch->ContactBranch->fullModelName()
				)),
			)
		);

		$shopBranchStockLogs = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'id',
		);

		$this->set(compact('shopBranchStockLogs', 'filterOptions'));
	}

/**
 * view method for a single row
 *
 * Show detailed information on a single ShopBranchStockLog
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

		$shopBranchStockLog = $this->ShopBranchStockLog->getViewData(
			array($this->ShopBranchStockLog->alias . '.' . $this->ShopBranchStockLog->primaryKey => $id)
		);

		$this->set(compact('shopBranchStockLog'));
	}
}