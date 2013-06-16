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
				'ShopAssignedUser',
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

	public function admin_report_data($type = null) {
		switch ($type) {
			case 'swimlane':
				$shopOrders = $this->ShopOrder->find('all', array(
					'contain' => array(
						'ShopAssignedUser',
					),
					'fields' => array(
						'ShopOrder.id',
						'ShopOrder.invoice_number',
						'ShopOrder.created',
						'ShopOrder.total',
						'ShopOrder.assigned_user_id',
						'ShopAssignedUser.id',
						'ShopAssignedUser.prefered_name'
					)
				));

				$return = array();
				foreach ($shopOrders as $k => $shopOrder) {
					$return['items'][] = array(
						'id' => $k,
						'class' => 'past',
						'desc' => sprintf('#%s', $shopOrder['ShopOrder']['invoice_number']),
						'start' => $shopOrder['ShopOrder']['created'],
						'end' => date('Y-m-d H:i:s', strtotime($shopOrder['ShopOrder']['created']) + rand(0, 5 * 24 * 60 * 60)),
						'lane' => $shopOrder['ShopOrder']['assigned_user_id']
					);
				}
				$return['lanes'] = array(
					array('id' => 1, 'label' => 'User 1'),
					array('id' => 2, 'label' => 'User 2'),
					array('id' => 3, 'label' => 'User 3'),
					array('id' => 4, 'label' => 'User 4'),
					array('id' => 5, 'label' => 'User 5'),
				);
				break;

			case 'orders':
				$shopOrders = $this->ShopOrder->find('all', array(
					'contain' => array(
						'InfinitasPaymentLog',
					)
				));
				$return = array();
				foreach ($shopOrders as $shopOrder) {
					$return[] = array(
						'invoice_number' => $shopOrder['ShopOrder']['invoice_number'],
						'value' => $shopOrder['ShopOrder']['total'],
						//'tax' => $shopOrder['ShopOrder']['tax'],
						//'shipping' => $shopOrder['ShopOrder']['shipping'],
						//'insurance' => $shopOrder['ShopOrder']['insurance'],
						//'handling' => $shopOrder['ShopOrder']['handling'],
						'date' => $shopOrder['ShopOrder']['created'],
						'end_date' => date('Y-m-d H:i:s', strtotime($shopOrder['ShopOrder']['created']) + rand(0, 5 * 24 * 60 * 60)),
						'user_id' => $shopOrder['ShopOrder']['user_id'],
						//'fee' => $shopOrder['InfinitasPaymentLog']['transaction_fee'],
						'product_count' => $shopOrder['ShopOrder']['shop_order_product_count']
					);
				}
				break;

			case 'grouped':
				$return = array(
					'days' => $this->ShopOrder->find('grouped', array(
						'group' => 'days'
					)),
					'weeks' => $this->ShopOrder->find('grouped', array(
						'group' => 'weeks'
					)),
					'months' => $this->ShopOrder->find('grouped', array(
						'group' => 'months'
					)),
					'years' => $this->ShopOrder->find('grouped', array(
						'group' => 'years'
					)),
				);

				foreach ($return['weeks'] as $k => $week) {
					$return['weeks'][$k]['_start'] = date('Y-m-d H:i:s', strtotime($week['year'] . 'W' . str_pad($week['week'], 2, '0', STR_PAD_LEFT)));
				}
				break;

			default:
				throw new InvalidArgumentException(__('shop', 'Unknown data type selected'));
		}
		echo json_encode($return);
		exit;
	}

/**
 * Show detailed information on a single ShopOrder
 *
 * @param mixed $id int or string uuid or the row to find
 *
 * @return void
 */
	public function admin_view($id = null) {
		if ($this->request->data) {
			$this->{$this->modelClass}->updateStatus($id, $this->request->data['ShopOrderNote']['shop_order_status_id']);
			$saved = $this->{$this->modelClass}->ShopOrderNote->saveNote(array(
				'shop_order_id' => $this->request->data['ShopOrderNote']['shop_order_id'],
				'shop_order_status_id' => $this->request->data['ShopOrderNote']['shop_order_status_id'],
				'notes' => $this->request->data['ShopOrderNote']['notes'],
				'user_notified' => $this->request->data['ShopOrderNote']['user_notified'],
				'internal' => $this->request->data['ShopOrderNote']['internal'],
			));
			if ($saved) {
				$this->notice(__d('shop', 'Order notes have been saved'), array(
					'redirect' => true,
				));
			}
			$this->notice(__d('shop', 'There was a problem saving the order notes'), array(
				'level' => 'warning'
			));
		}
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