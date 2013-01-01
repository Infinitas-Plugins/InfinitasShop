<?php
/**
 * ShopOptions controller
 *
 * Add some documentation for ShopOptions controller.
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

class ShopOptionsController extends ShopAppController {

/**
 * the index method
 *
 * Show a paginated list of ShopOption records.
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

		$shopOptions = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
		);

		$this->set(compact('shopOptions', 'filterOptions'));
	}

/**
 * view method for a single row
 *
 * Show detailed information on a single ShopOption
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

		$shopOption = $this->ShopOption->getViewData(
			array($this->ShopOption->alias . '.' . $this->ShopOption->primaryKey => $id)
		);

		$this->set(compact('shopOption'));
	}

/**
 * admin create action
 *
 * Adding new ShopOption records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_add() {
		if (!empty($this->request->data)) {
			foreach ($this->request->data['ShopOptionValue'] as $k => $optionValue) {
				if (!array_filter($optionValue)) {
					unset(
						$this->request->data['ShopOptionValue'][$k],
						$this->request->data['ShopPrice'][$k],
						$this->request->data['ShopSize'][$k]
					);
				}
			}
		}
		parent::admin_add();

	}

/**
 * admin edit action
 *
 * Edit old ShopOption records.
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		if (!empty($this->request->data)) {
			foreach ($this->request->data['ShopOptionValue'] as $k => $optionValue) {
				if (!array_filter($optionValue)) {
					unset(
						$this->request->data['ShopOptionValue'][$k],
						$this->request->data['ShopPrice'][$k],
						$this->request->data['ShopSize'][$k]
					);
				}
			}
		}
		parent::admin_edit($id, array(
			'contain' => array(
				'ShopOptionValue' => array(
					'ShopPrice',
					'ShopSize',
					'order' => array(
						'ShopOptionValue.product_code',
					)
				),
				'ShopProductTypesOption'
			)
		));

		$shopProductTypes = $this->{$this->modelClass}->ShopProductTypesOption->ShopProductType->find('list');
		$this->set(compact('shopProductTypes'));
	}

}