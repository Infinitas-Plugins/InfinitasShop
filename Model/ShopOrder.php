<?php
App::uses('ShopAppModel', 'Shop.Model');

/**
 * ShopOrder Model
 *
 * @property User $User
 * @property ShopBillingAddress $ShopBillingAddress
 * @property ShopShippingAddress $ShopShippingAddress
 * @property ShopPaymentMethod $ShopPaymentMethod
 * @property ShopShippingMethod $ShopShippingMethod
 * @property ShopOrderStatus $ShopOrderStatus
 * @property ShopOrderNote $ShopOrderNote
 * @property ShopOrderProduct $ShopOrderProduct
 * @property ShopPaymentResponse $ShopPaymentResponse
 * @property User $ShopAssignedUser
 */

class ShopOrder extends ShopAppModel {

	public $findMethods = array(
		'details' => true,
		'mine' => true,
		'newOrderBasics' => true
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopAssignedUser' => array(
			'className' => 'Users.User',
			'foreignKey' => 'assigned_user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopBillingAddress' => array(
			'className' => 'Shop.ShopAddress',
			'foreignKey' => 'shop_billing_address_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopShippingAddress' => array(
			'className' => 'Shop.ShopAddress',
			'foreignKey' => 'shop_shipping_address_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopPaymentMethod' => array(
			'className' => 'Shop.ShopPaymentMethod',
			'foreignKey' => 'shop_payment_method_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopShippingMethod' => array(
			'className' => 'Shop.ShopShippingMethod',
			'foreignKey' => 'shop_shipping_method_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopOrderStatus' => array(
			'className' => 'Shop.ShopOrderStatus',
			'foreignKey' => 'shop_order_status_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'InfinitasPaymentLog' => array(
			'className' => 'InfinitasPayments.InfinitasPaymentLog',
			'foreignKey' => 'infinitas_payment_log_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ShopOrderNote' => array(
			'className' => 'Shop.ShopOrderNote',
			'foreignKey' => 'shop_order_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ShopOrderProduct' => array(
			'className' => 'Shop.ShopOrderProduct',
			'foreignKey' => 'shop_order_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

/**
 * Constructor
 *
 * @param type $id
 * @param type $table
 * @param type $ds
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->order = array(
			$this->alias . '.created' => 'desc'
		);
	}

/**
 * Find details of an order
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 *
 * @throws InvalidArgumentException
 */
	protected function _findDetails($state, array $query, array $results = array()) {
		if ($state == 'before') {
			if (empty($query[0])) {
				throw new InvalidArgumentException(__d('shop', 'Invalid order selected'));
			}

			$query = array_merge(array(
				'admin' => false
			), $query);

			$this->virtualFields['previous_orders_count'] = 'COUNT(ShopUserOrder.id)';
			$this->virtualFields['previous_orders_value'] = 'SUM(ShopUserOrder.total)';
			$query['fields'] = array_merge((array)$query['fields'], array(
				$this->alias . '.' . $this->primaryKey,
				$this->alias . '.invoice_number',
				$this->alias . '.shop_order_product_count',
				$this->alias . '.shop_order_status_id',
				$this->alias . '.ip_address',
				$this->alias . '.total',
				$this->alias . '.tax',
				$this->alias . '.shipping',
				$this->alias . '.insurance',
				$this->alias . '.handling',
				'previous_orders_count',
				'previous_orders_value',
				$this->alias . '.created',
				$this->alias . '.modified',

				$this->ShopAssignedUser->alias . '.' . $this->ShopAssignedUser->primaryKey,
				$this->ShopAssignedUser->alias . '.username',

				$this->User->alias . '.' . $this->User->primaryKey,
				$this->User->alias . '.username',
				$this->User->alias . '.full_name',
				$this->User->alias . '.prefered_name',
				$this->User->alias . '.email',
				$this->User->alias . '.browser',
				$this->User->alias . '.operating_system',
				$this->User->alias . '.last_login',
				$this->User->alias . '.last_click',

				$this->ShopBillingAddress->alias . '.*',
				$this->ShopShippingAddress->alias . '.*',

				$this->ShopPaymentMethod->alias . '.' . $this->ShopPaymentMethod->primaryKey,
				$this->ShopPaymentMethod->alias . '.' . $this->ShopPaymentMethod->displayField,

				$this->ShopShippingMethod->alias . '.' . $this->ShopShippingMethod->primaryKey,
				$this->ShopShippingMethod->alias . '.' . $this->ShopShippingMethod->displayField,

				$this->ShopOrderStatus->alias . '.' . $this->ShopOrderStatus->primaryKey,
				$this->ShopOrderStatus->alias . '.' . $this->ShopOrderStatus->displayField,

				$this->InfinitasPaymentLog->alias . '.*',
			));

			$query['conditions'] = array_merge((array)$query['conditions'], array(
				$this->alias . '.' . $this->primaryKey => $query[0]
			));

			if ($query['admin'] !== true) {
				$query['conditions'] = array_merge((array)$query['conditions'], array(
					$this->alias . '.user_id' => $this->currentUserId()
				));
			}

			$query['joins'] = (array)$query['joins'];
			$join = $this->autoJoinModel(array(
				'model' => $this,
				'alias' => 'ShopUserOrder',
				'conditions' => array(
					'1=1'
				)
			));
			$join['conditions'] =  array(
				'ShopUserOrder.user_id = ShopOrder.user_id',
				'ShopUserOrder.created < ShopOrder.created'
			);
			$query['joins'][] = $join;
			$query['joins'][] = $this->autoJoinModel($this->ShopAssignedUser);
			$query['joins'][] = $this->autoJoinModel($this->User);
			$query['joins'][] = $this->autoJoinModel($this->ShopBillingAddress);
			$query['joins'][] = $this->autoJoinModel($this->ShopShippingAddress);
			$query['joins'][] = $this->autoJoinModel($this->ShopPaymentMethod);
			$query['joins'][] = $this->autoJoinModel($this->ShopShippingMethod);
			$query['joins'][] = $this->autoJoinModel($this->InfinitasPaymentLog);
			$query['joins'][] = $this->autoJoinModel($this->ShopOrderStatus);


			$query['limit'] = 1;

			return $query;
		}
		$results = $results[0];

		if (empty($results[$this->alias][$this->primaryKey])) {
			return array();
		}

		$results[$this->InfinitasPaymentLog->alias]['raw_request'] = json_decode($results[$this->InfinitasPaymentLog->alias]['raw_request'], true);
		$results[$this->InfinitasPaymentLog->alias]['raw_response'] = json_decode($results[$this->InfinitasPaymentLog->alias]['raw_response'], true);

		$results[$this->ShopOrderNote->alias] = $this->ShopOrderNote->find('notes', $results[$this->alias][$this->primaryKey]);
		$results[$this->ShopOrderProduct->alias] = $this->ShopOrderProduct->ShopProductVariant->ShopProduct->find('productsForOrder', array(
			'shop_order_id' => $results[$this->alias][$this->primaryKey],
			'admin' => $query['admin']
		));

		foreach ($results[$this->ShopOrderProduct->alias] as &$product) {
			unset($product['ShopProductVariant']['ShopOptionVariant'], $product['ShopProductVariantMaster']);
		}
		return $results;
	}

/**
 * Find a users orders
 *
 * This will fetch all orders for the logged in user
 *
 * @param type $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findMine($state, array $query, array $results = array()) {
		if ($state == 'before') {
			$query['fields'] = array_merge((array)$query['fields'], array(
				$this->alias . '.' . $this->primaryKey,
				$this->alias . '.invoice_number',
				$this->alias . '.total',
				$this->alias . '.modified',

				$this->ShopOrderStatus->alias . '.' . $this->ShopOrderStatus->primaryKey,
				$this->ShopOrderStatus->alias . '.' . $this->ShopOrderStatus->displayField,
			));

			$query['conditions'] = array_merge((array)$query['conditions'], array(
				$this->alias . '.user_id' => $this->currentUserId()
			));

			$query['joins'] = (array)$query['joins'];
			$query['joins'][] = $this->autoJoinModel($this->ShopOrderStatus);

			return $query;
		}

		return $results;
	}

/**
 * Create an order from a ShopList
 *
 * This will return the basic details of the order if it was saved or false if it could not be saved
 *
 * @param string $shopListId the id of the list to conver to an order
 *
 * @return array|string
 */
	public function orderFromList($shopListId, array $orderDetails = array()) {
		$shopListProducts = $this->ShopOrderProduct->ShopProductVariant->ShopProduct->find('productsForList', array(
			'shop_list_id' => $shopListId,
		));

		$shopList = $this->ShopOrderProduct->ShopProductVariant->ShopListProduct->ShopList->find('orderDetails', $shopListId);
		$views = $this->_viewsToBuy($shopList['user_id'], Hash::extract($shopListProducts, '{n}.ShopProduct.id'));

		$shopShipping = $this->ShopOrderProduct->ShopProductVariant->ShopListProduct->ShopList->ShopShippingMethod->find('productList', array(
			'shop_list_id' => $shopListId,
			'shop_shipping_method_id' => $shopList['shop_shipping_method_id']
		));
		$shopListTotal = $this->ShopOrderProduct->ShopProductVariant->ShopProduct->find('prodcutListShipping', array(
			'shop_list_id' => $shopListId
		));

		$orderItems = array();
		foreach ($shopListProducts as $shopListProduct) {
			$orderItem = array(
				'name' => $shopListProduct['ShopProduct']['name'],
				'brand' => $shopListProduct['ShopBrand']['name'],
				'product_code' => $shopListProduct['ShopProductVariantMaster']['product_code'],
				'shop_image_id' => $shopListProduct['ShopImage']['id'],
				'shop_product_type_id' => $shopListProduct['ShopProductType']['id'],
				'shop_product_variant_id' => $shopListProduct['ShopListProduct']['shop_product_variant_id'],
				'quantity' => $shopListProduct['ShopListProduct']['quantity'],
				'time_to_purchase' => time() - strtotime($shopListProduct['ShopListProduct']['created']),
				'view_to_purchase' => !empty($views[$shopListProduct['ShopProduct']['id']]) ? $views[$shopListProduct['ShopProduct']['id']] : 0,
			);

			$price = array_filter($shopListProduct['ShopOrderProductPrice']);
			$size = array_filter($shopListProduct['ShopOrderProductSize']);
			unset($price['id'], $size['id']);
			if (!empty($price)) {
				$orderItem['ShopOrderProductPrice'] = $price;
				$orderItem['ShopOrderProductPrice']['model'] = $this->ShopOrderProduct->fullModelName($this->ShopOrderProduct->name);
			}
			if (!empty($size)) {
				$orderItem['ShopOrderProductSize'] = $size;
				$orderItem['ShopOrderProductSize']['model'] = $this->ShopOrderProduct->fullModelName($this->ShopOrderProduct->name);
			}

			$orderItems[] = $orderItem;
		}
		$shopOrderStatusId = $this->ShopOrderStatus->field('id', array(
			$this->ShopOrderStatus->alias . '.status' => ShopOrderStatus::$statusPending
		));

		$orderDetails = array_merge(array(
			'infinitas_payment_log_id' => null,
			'tracking_number' => null,
			'ShopBillingAddress' => array(),
			'ShopShippingAddress' => array(),
		), $orderDetails);

		$return = array(
			$this->alias => array(
				'user_id' => $shopList['user_id'],
				'total' => $shopListTotal['cost'] + $shopShipping['total'],
				'tax' => 0,
				'weight' => $shopListTotal['weight'],
				'shipping' => $shopShipping['shipping'],
				'insurance' => $shopShipping['insurance_rate'],
				'handling' => $shopShipping['surcharge'],
				'tracking_number' => $orderDetails['tracking_number'],
				'infinitas_payment_log_id' => $orderDetails['infinitas_payment_log_id'],
				'shop_shipping_method_id' => $shopList['shop_shipping_method_id'],
				'shop_payment_method_id' => $shopList['shop_payment_method_id'],
				'shop_order_status_id' => $shopOrderStatusId
			),
			$this->ShopOrderProduct->alias => $orderItems
		);

		$this->transaction();
		$this->create();
		if ($this->saveAll($return, array('deep' => true))) {
			$this->ShopOrderProduct->ShopProductVariant->ShopListProduct->ShopList->truncateUserList($shopListId);
			$this->transaction(true);
			return $this->find('newOrderBasics');
		}
		$this->transaction(false);
		return false;
	}

/**
 * Find the basic details of the order
 *
 * @param array $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findNewOrderBasics($state, array $query, array $results = array()) {
		if ($state == 'before') {
			$query['fields'] = array(
				$this->alias . '.' . $this->primaryKey,
				$this->alias . '.invoice_number',
				$this->alias . '.infinitas_payment_log_id',
				$this->alias . '.tracking_number',
				$this->alias . '.user_id'
			);

			$query['conditions'] = array(
				$this->alias . '.' . $this->primaryKey => $this->id
			);

			$query['limit'] = 1;

			return $query;
		}

		if (empty($results)) {
			return array();
		}

		return $results[0][$this->alias];
	}

/**
 * update the status of an order
 *
 * If no status is specified the update wont run, if the status id is not valid it will throw an exception
 *
 * @param string $id the order to update
 * @param string $statusId the new status
 *
 * @return boolean
 *
 * @throws InvalidArgumentException
 */
	public function updateStatus($id, $statusId) {
		if (!$statusId) {
			return;
		}

		if (!$this->ShopOrderStatus->exists($statusId)) {
			throw new InvalidArgumentException(__d('shop', 'Invalid status selected'));
		}

		if (!$this->exists($id)) {
			throw new InvalidArgumentException(__d('shop', 'Invalid order specified'));
		}

		return $this->updateAll(
			array($this->alias . '.shop_order_status_id' => sprintf("'%s'", $statusId)),
			array($this->alias . '.' . $this->primaryKey => $id)
		);
	}

/**
 * Get the number of views each product had before purchasing
 *
 * @param string $userId the user id the order is for
 * @param array $productIds the product ids that are being ordered
 *
 * @return array
 */
	protected function _viewsToBuy($userId, array $productIds) {
		$ViewCounterView = ClassRegistry::init('ViewCounter.ViewCounterView');
		$ViewCounterView->virtualFields['view_count'] = sprintf('COUNT(%s)', $ViewCounterView->fullFieldName($ViewCounterView->primaryKey));
		return $ViewCounterView->find('list', array(
			'fields' => array(
				$ViewCounterView->alias . '.foreign_key',
				$ViewCounterView->alias . '.view_count'
			),
			'conditions' => array(
				$ViewCounterView->alias . '.model' => 'Shop.ShopProduct',
				$ViewCounterView->alias . '.foreign_key' => $productIds,
				$ViewCounterView->alias . '.user_id' => $userId
			),
			'group' => array(
				$ViewCounterView->alias . '.foreign_key'
			)
		));
	}
}