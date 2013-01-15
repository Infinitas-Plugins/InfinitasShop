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
			),
			'conditions' => array(
				$this->modelClass . '.user_id' => $this->{$this->modelClass}->currentUserId()
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
 * View the oredr invoice
 *
 * @param mixed $id int or string uuid or the row to find
 *
 * @return void
 */
	public function invoice($id = null) {
		try {
			$this->set('shopOrder', $this->ShopOrder->find('details', $id));
		} catch (Exception $e) {
			$this->notice($e);
		}
	}

/**
 * reorder the selected invoice
 *
 * @param string $id the invoice to reorder
 *
 * @return void
 */
	public function reorder($id = null) {
		try {
			$listId = $this->ShopOrder->reorder($id);
			if ($listId) {
				$this->notice(__d('shop', 'Products have been added to your cart'), array(
					'redirect' => array(
						'plugin' => 'shop',
						'controller' => 'shop_lists',
						'action' => 'change',
						$listId
					)
				));
			}
			$this->notice(__d('shop', 'Unable to reorder selected invoice'), array(
				'level' => 'warning',
				'redirect' => true
			));
		} catch (Exception $e) {
			$this->notice($e);
		}
	}

/**
 * Show a paginated list of ShopOrder records.
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
 * Show detailed information on a single ShopOrder
 *
 * @param mixed $id int or string uuid or the row to find
 *
 * @return void
 */
	public function admin_view($id = null) {
		try {
			$this->set('shopOrder', $this->ShopOrder->find('details', array(
				$id,
				'admin' => true
			)));
		} catch (Exception $e) {
			$this->notice($e);
		}

		$this->set('shopOrderStatuses', $this->ShopOrder->ShopOrderStatus->find('statuses'));
	}

/**
 * Adding new ShopOrder records.
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
 * Edit old ShopOrder records.
 *
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

	public function __massActionInvoice(array $ids) {
		$shopOrders = array();
		foreach ($ids as $id) {
			$shopOrders[] = $this->{$this->modelClass}->find('details', array(
				$id,
				'admin' => $this->request->params['admin']
			));
		}

		$this->set('shopOrders', $shopOrders);
		$this->render('admin_invoice', 'Shop.invoice');
	}

	public function __massActionPacking_slip(array $ids) {
		$shopOrders = array();
		foreach ($ids as $id) {
			$shopOrders[] = $this->{$this->modelClass}->find('details', array(
				$id,
				'admin' => $this->request->params['admin']
			));
		}

		$this->set('shopOrders', $shopOrders);
		$this->render('admin_packing_slip', 'Shop.invoice');
	}
}