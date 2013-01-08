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
 */
class ShopOrder extends ShopAppModel {

	public $findMethods = array(
		'details' => true,
		'mine' => true
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

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->order = array(
			$this->alias . '.created' => 'desc'
		);
	}

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
				$this->alias . '.ip_address',
				$this->alias . '.total',
				$this->alias . '.tax',
				$this->alias . '.shipping',
				$this->alias . '.insurance',
				$this->alias . '.handling',
				'previous_orders_count',
				'previous_orders_value',

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

				$this->InfinitasPaymentLog->alias . '.*'
			));

			$query['conditions'] = array_merge((array)$query['conditions'], array(
				$this->alias . '.' . $this->primaryKey => $query[0]
			));

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

		if (empty($results)) {
			throw new InvalidArgumentException(__d('shop', 'Order not found'));
		}
		$results = $results[0];

		$results[$this->InfinitasPaymentLog->alias]['raw_request'] = unserialize($results[$this->InfinitasPaymentLog->alias]['raw_request']);
		$results[$this->InfinitasPaymentLog->alias]['raw_response'] = unserialize($results[$this->InfinitasPaymentLog->alias]['raw_response']);

		$results[$this->ShopOrderNote->alias] = $this->ShopOrderNote->find('notes', $results[$this->alias][$this->primaryKey]);
		$results[$this->ShopOrderProduct->alias] = $this->ShopOrderProduct->ShopProductVariant->ShopProduct->find('productsForOrder', array(
			'shop_order_id' => $results[$this->alias][$this->primaryKey],
			'admin' => $query['admin']
		));
		return $results;
	}

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
}