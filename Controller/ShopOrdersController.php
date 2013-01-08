<?php
/**
 * ShopOrdersController
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 * @link http://infinitas-cms.org/Shop
 * @package Shop.Controller
 * @license http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author Carl Sutton <dogmatic69@infinitas-cms.org>
 */

class ShopOrdersController extends ShopAppController {

/**
 * @brief the index method
 *
 * Show a paginated list of ShopOrder records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function index() {
		$this->Paginator->settings = array(
			'contain' => array(
				'User',
				'ShopBillingAddress',
				'ShopShippingAddress',
				'ShopPaymentMethod',
				'ShopShippingMethod',
				'ShopOrderStatus',
				'InfinitasPaymentLog',
			)
		);

		$shopOrders = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'id',
		);

		$this->set(compact('shopOrders', 'filterOptions'));
	}

/**
 * @brief view method for a single row
 *
 * Show detailed information on a single ShopOrder
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

		$shopOrder = $this->ShopOrder->getViewData(
			array($this->ShopOrder->alias . '.' . $this->ShopOrder->primaryKey => $id)
		);

		$this->set(compact('shopOrder'));
	}

/**
 * @brief the index method
 *
 * Show a paginated list of ShopOrder records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		$this->Paginator->settings = array(
			'contain' => array(
				'User',
				'ShopBillingAddress',
				'ShopShippingAddress',
				'ShopPaymentMethod',
				'ShopShippingMethod',
				'ShopOrderStatus',
				'InfinitasPaymentLog',
			)
		);

		$shopOrders = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'id',
		);

		$this->set(compact('shopOrders', 'filterOptions'));
	}

/**
 * @brief view method for a single row
 *
 * Show detailed information on a single ShopOrder
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to find
 *
 * @return void
 */
	public function admin_view($id = null) {
		try {
			$this->set('shopOrder', $this->ShopOrder->find('details', $id));
		} catch (Exception $e) {
			$this->notice($e);
		}
	}

/**
 * @brief admin create action
 *
 * Adding new ShopOrder records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_add() {
		parent::admin_add();

		$users = $this->ShopOrder->User->find('list');
		$shopBillingAddresses = $this->ShopOrder->ShopBillingAddress->find('list');
		$shopShippingAddresses = $this->ShopOrder->ShopShippingAddress->find('list');
		$shopPaymentMethods = $this->ShopOrder->ShopPaymentMethod->find('list');
		$shopShippingMethods = $this->ShopOrder->ShopShippingMethod->find('list');
		$shopOrderStatuses = $this->ShopOrder->ShopOrderStatus->find('list');
		$infinitasPaymentLogs = $this->ShopOrder->InfinitasPaymentLog->find('list');
		$this->set(compact('users', 'shopBillingAddresses', 'shopShippingAddresses', 'shopPaymentMethods', 'shopShippingMethods', 'shopOrderStatuses', 'infinitasPaymentLogs'));
	}

/**
 * @brief admin edit action
 *
 * Edit old ShopOrder records.
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		parent::admin_edit($id);

		$users = $this->ShopOrder->User->find('list');
		$shopBillingAddresses = $this->ShopOrder->ShopBillingAddress->find('list');
		$shopShippingAddresses = $this->ShopOrder->ShopShippingAddress->find('list');
		$shopPaymentMethods = $this->ShopOrder->ShopPaymentMethod->find('list');
		$shopShippingMethods = $this->ShopOrder->ShopShippingMethod->find('list');
		$shopOrderStatuses = $this->ShopOrder->ShopOrderStatus->find('list');
		$infinitasPaymentLogs = $this->ShopOrder->InfinitasPaymentLog->find('list');
		$this->set(compact('users', 'shopBillingAddresses', 'shopShippingAddresses', 'shopPaymentMethods', 'shopShippingMethods', 'shopOrderStatuses', 'infinitasPaymentLogs'));
	}
}