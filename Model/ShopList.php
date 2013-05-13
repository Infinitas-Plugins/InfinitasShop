<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopList Model
 *
 * @property User $User
 * @property ShopShippingMethod $ShopShippingMethod
 * @property ShopPaymentMethod $ShopPaymentMethod
 * @property ShopListProduct $ShopListProduct
 */
class ShopList extends ShopAppModel {

/**
 * custom find methods
 *
 * @var array
 */
	public $findMethods = array(
		'hasList' => true,
		'details' => true,
		'overview' => true,
		'mine' => true,
		'orderDetails' => true
	);

/**
 * Session key for current shopping list
 *
 * @var string
 */
	public static $sessionListKey = 'Shop.current_list';

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
		'ShopShippingMethod' => array(
			'className' => 'Shop.ShopShippingMethod',
			'foreignKey' => 'shop_shipping_method_id',
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
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ShopListProduct' => array(
			'className' => 'Shop.ShopListProduct',
			'foreignKey' => 'shop_list_id',
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
 * overload construct for translated validation
 *
 * @param type $id
 * @param type $table
 * @param type $ds
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'name' => array(
				'notEmpty' => array(
					'rule' => 'notEmpty',
					'message' => __d('shop', 'Please enter a name for your list'),
					'allowEmpty' => false,
					'required' => true,
					'on' => 'create'
				)
			),
			'user_id' => array(
				'validateUserId' => array(
					'rule' => 'validateUserId',
					'message' => __d('shop', 'There was a problem validating your user details'),
					'required' => true
				)
			),
			'shop_shipping_method_id' => array(
				'validateRecordExists' => array(
					'rule' => 'validateRecordExists',
					'message' => __d('shop', 'Invalid shipping method selected'),
					'allowEmpty' => true,
					'required' => false
				)
			),
			'shop_payment_method_id' => array(
				'validateRecordExists' => array(
					'rule' => 'validateRecordExists',
					'message' => __d('shop', 'Invalid payment method selected'),
					'allowEmpty' => true,
					'required' => false
				)
			)
		);
	}

/**
 * validate the user is correct
 *
 * @param array $field the data being validated
 *
 * @return boolean
 */
	public function validateUserId(array $field) {
		$field = current($field);
		if (!$this->User->exists($field)) {
			return (bool)CakeSession::read('Shop.Guest.id', $field);
		}
		return true;
	}

/**
 * Get the details for a shopping list
 *
 * This will fetch details such as the current payment and shopping methods to display on checkout
 * pages
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findDetails($state, array $query, array $results = array()) {
		if ($state == 'before') {
			if (empty($query[0])) {
				$query[0] = $this->currentListId(true);
			}

			if (empty($query['user_id'])) {
				$query['user_id'] = $this->currentUserId();
			}


			$query['fields'] = array_merge((array)$query['fields'], array(
				$this->alias . '.' . $this->primaryKey,
				$this->alias . '.' . $this->displayField,
				$this->alias . '.token',

				$this->ShopShippingMethod->alias . '.' . $this->ShopShippingMethod->primaryKey,
				$this->ShopShippingMethod->alias . '.' . $this->ShopShippingMethod->displayField,

				$this->ShopPaymentMethod->alias . '.' . $this->ShopPaymentMethod->primaryKey,
				$this->ShopPaymentMethod->alias . '.' . $this->ShopPaymentMethod->displayField,
			));

			$query['conditions'] = array_merge((array)$query['conditions'], array(
				$this->alias . '.' . $this->primaryKey => $query[0],
				$this->alias . '.user_id' => $query['user_id']
			));

			$query['joins'] = array(
				$this->autoJoinModel($this->ShopShippingMethod->fullModelName()),
				$this->autoJoinModel($this->ShopPaymentMethod->fullModelName()),
			);
			$results['limit'] = 1;
			return $query;
		}

		if (empty($results[0])) {
			return array();
		}

		$results = $results[0];

		try {
			$results['ShopShipping'] = $this->ShopShippingMethod->find('productList');
		} catch (Exception $e) {
			$results['ShopShipping'] = $results['ShopPayment'] = array();
		}

		return $results;
	}

	protected function _findOverview($state, array $query, array $results = array()) {
		if ($state == 'before') {
			$query['fields'] = array(
				$this->alias . '.shop_list_product_count'
			);

			$query['conditions'] = array_merge((array)$query['conditions'], array(
				$this->alias . '.id' => $this->currentListId(true),
				$this->alias . '.user_id' => $this->currentUserId()
			));

			$query['limit'] = 1;

			return $query;
		}

		if (empty($results)) {
			return array(
				'shop_list_product_count' => 0,
				'value' => 0
			);
		}

		return array(
			'shop_list_product_count' => (int)current(Hash::flatten($results)),
			'value' => $this->ShopListProduct->ShopProductVariant->ShopProduct->find('costForList')
		);

		return $results;
	}

/**
 * Get the lists a user has made
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findMine($state, array $query, array $results = array()) {
		if ($state == 'before') {
			$query['fields'] = array_merge((array)$query['fields'], array(
				$this->alias . '.' . $this->primaryKey,
				$this->alias . '.' . $this->displayField,
				$this->alias . '.shop_list_product_count',
				$this->alias . '.modified'
			));
			$query['conditions'] = array_merge((array)$query['conditions'], array(
				$this->alias . '.user_id' => $this->currentUserId()
			));
			return $query;
		}

		foreach ($results as &$result) {
			$result[$this->alias]['value'] = 0;
		}

		return $results;
	}

/**
 * get the id of the current list
 *
 * get the id of the list currently being used.
 *
 * @return string
 */
	public function currentListId($create = false) {
		$currentList = CakeSession::read(self::$sessionListKey);

		if (!empty($currentList)) {
			$mine = $this->find('count', array(
				'conditions' => array(
					$this->alias . '.' . $this->primaryKey => $currentList,
					$this->alias . '.user_id' => $this->currentUserId()
				)
			));
			if ($mine) {
				return $currentList;
			}
		}

		$currentList = $this->find('list', array(
			'fields' => array(
				$this->alias . '.' . $this->primaryKey,
				$this->alias . '.' . $this->primaryKey,
			),
			'conditions' => array(
				$this->alias . '.user_id' => $this->currentUserId()
			),
			'order' => array(
				$this->alias . '.modified' => 'desc'
			)
		));

		$currentList = current($currentList);
		if (!empty($currentList)) {
			return $this->setCurrentList($currentList);
		}

		if (!$create) {
			return false;
		}

		return $this->createList();
	}

/**
 * Set the shipping method for a shopping list
 *
 * @param string $shippingMethodId the method to use
 * @param string $thisId optional, will use the default list if not passed in
 *
 * @return array
 */
	public function setShippingMethod($shippingMethodId, $thisId = null) {
		if (!$this->ShopShippingMethod->exists($shippingMethodId)) {
			throw new InvalidArgumentException(__d('shop', 'Invalid shipping method selected'));
		}

		if (!$thisId) {
			$thisId = $this->currentListId();
		}

		$this->id = $thisId;
		return $this->saveField('shop_shipping_method_id', $shippingMethodId);
	}

/**
 * set the current list id
 *
 * This sets the list that is being used for adding products to saved in the
 * session
 *
 * The selected id is returned, or exception thrown if not valid
 *
 * @param string $listId the id of the list being used
 *
 * @return string
 *
 * @throws InvalidArgumentException
 */
	public function setCurrentList($listId) {
		$listId = $this->find('list', array(
			'conditions' => array(
				$this->alias . '.' . $this->primaryKey => $listId,
				$this->alias . '.user_id' => $this->currentUserId()
			)
		));

		if (empty($listId)) {
			throw new InvalidArgumentException('Invalid list selected');
		}

		CakeSession::write(self::$sessionListKey, key($listId));

		return CakeSession::read(self::$sessionListKey);
	}

/**
 * create a list for a user
 *
 * This will create a list for a user, if no data is passed a generic cart
 * will be created.
 *
 * @param array $data the data to create the list with.
 *
 * @return string
 */
	public function createList(array $data = array()) {
		$data = array_merge(array(
			'name' => __d('shop', 'Cart'),
			'user_id' => $this->currentUserId(),
		), $data);

		if ($this->save($data)) {
			return $this->id;
		}

		return false;
	}

/**
 * Convert the guests list to the logged in users account
 *
 * When called, any items that are under the users guest id are moved to the users account by updating
 * the user_id field to the users id (from the guest id)
 *
 * @return null|boolean
 */
	public function guestToUser() {
		$this->deleteAll(array(
			$this->alias . '.shop_list_product_count <=' => 0,
			$this->alias . '.user_id' => CakeSession::read('Shop.Guest.id')
		));

		$lists = $this->find('all', array(
			'fields' => array(
				$this->alias . '.' . $this->primaryKey
			),
			'conditions' => array(
				$this->alias . '.user_id' => CakeSession::read('Shop.Guest.id')
			)
		));
		if (empty($lists)) {
			return null;
		}

		$userId = AuthComponent::user('id');
		foreach ($lists as &$list) {
			$list = array(
				'id' => $list[$this->alias][$this->primaryKey],
				'user_id' => $userId
			);
		}
		return (bool)$this->saveAll($lists);
	}

/**
 * string find conditions
 *
 * @param string $state
 * @param array $query
 *
 * @return array
 */
	protected function _baseFind($state, array $query) {
		if ($state == 'before') {
			$query['fields'] = array_merge((array)$query['fields'], array(
				$this->alias . '.' . $this->primaryKey,
				$this->alias . '.' . $this->displayField,
				$this->alias . '.user_id',
				$this->User->alias . '.' . $this->User->primaryKey,
				$this->User->alias . '.' . $this->User->displayField,

				$this->ShopPaymentMethod->alias . '.' . $this->ShopPaymentMethod->primaryKey,
				$this->ShopPaymentMethod->alias . '.' . $this->ShopPaymentMethod->displayField,

				$this->ShopShippingMethod->alias . '.' . $this->ShopShippingMethod->primaryKey,
				$this->ShopShippingMethod->alias . '.' . $this->ShopShippingMethod->displayField
			));

			$query['conditions'] = array_merge((array)$query['conditions'], array(
				$this->alias . '.user_id' => $this->currentUserId(),
			));

			$conditions = array(
				'ShopPaymentMethod.id = ShopList.shop_payment_method_id',
				$this->ShopPaymentMethod->alias . '.active' => 1
			);
			if ($this->isGuest()) {
				$conditions[$this->ShopPaymentMethod->alias . '.require_login'] = 0;
			}
			$query['joins'][] = $this->autoJoinModel(array(
				'model' => $this->ShopPaymentMethod->fullModelName(),
				'conditions' => $conditions
			));

			$conditions = array(
				'ShopShippingMethod.id = ShopList.shop_shipping_method_id',
				$this->ShopShippingMethod->alias . '.active' => 1
			);
			if ($this->isGuest()) {
				$conditions[$this->ShopShippingMethod->alias . '.require_login'] = 0;
			}
			$query['joins'][] = $this->autoJoinModel(array(
				'model' => $this->ShopShippingMethod->fullModelName(),
				'conditions' => $conditions
			));

			return $query;
		}
	}

/**
 * check if the user has a list already
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return boolean
 */
	protected function _findHasList($state, array $query, array $results = array()) {
		if ($state == 'before') {
			$query = $this->_baseFind($state, $query);
			$this->virtualFields['list_count'] = sprintf('COUNT(%s.user_id)', $this->alias);

			$query['fields'] = array(
				'list_count'
			);

			$query['joins'] = array();

			$query['group'] = array(
				$this->alias . '.user_id'
			);

			return $query;
		}

		return (bool)current(Hash::extract($results, sprintf('{n}.%s.list_count', $this->alias)));
	}

	protected function _gateway() {
		if (!empty($this->_Gateway)) {
			return $this->_Gateway;
		}
		$this->_Gateway = new InfinitasGateway();
		$this->_Gateway
			->provider('paypal-express')
			->user(AuthComponent::user());
		return $this->_Gateway;
	}

/**
 * If a new method of shipping is submitted in the form save it
 *
 * - If the form and db method is the same it is returned as is
 * - If the form value is empty and db is set the db value is returned
 * - If a valid form value is submitted in the the db is updated
 *
 * If no shipping method can be found an execption will be thrown
 *
 * @param string $shopListId
 * @param array $data
 *
 * @return string
 *
 * @throws InvalidArgumentException
 */
	protected function _shippingMethod($shopListId, array $data) {
		$shipping = $this->find('first', array(
			'fields' => array(
				$this->alias . '.shop_shipping_method_id'
			),
			'conditions' => array(
				$this->alias . '.' . $this->primaryKey => $shopListId,
			)
		));
		$dbShippingMethod = current(Hash::flatten($shipping));
		$formShippingMethod = !empty($data['ShopList']['shop_shipping_method_id']) ? $data['ShopList']['shop_shipping_method_id'] : null;

		if ($dbShippingMethod == $formShippingMethod) {
			return $dbShippingMethod;
		}

		if ($dbShippingMethod && empty($formShippingMethod)) {
			return $dbShippingMethod;
		}
		if ($this->ShopShippingMethod->exists($formShippingMethod)) {
			$updated = $this->updateAll(
				array($this->alias . '.shop_shipping_method_id' => sprintf('"%s"', $formShippingMethod)),
				array($this->alias . '.' . $this->primaryKey => $shopListId)
			);
			if ($updated) {
				return $formShippingMethod;
			}
		}

		throw new InvalidArgumentException(__d('shop', 'No shipping method selected'));
	}

	public function checkout(array $data) {
		App::uses('InfinitasGateway', 'InfinitasPayments.Lib');

		$shopListId = $this->currentListId();
		$shopShippingMethodId = $this->_shippingMethod($shopListId, $data);
		$shopList = $this->find('details');

		if (!empty($shopList['ShopList']['token'])) {
			$status = $this->_gateway()->status(array(
				'token' => $shopList['ShopList']['token']
			));
			if ($status['paid_status'] === InfinitasGateway::$PAID) {
				$this->toOrder($shopListId, $status);
				return $status;
			}
		}

		$shopListProducts = $this->ShopListProduct->ShopProductVariant->ShopProduct->find('productsForList');
		if (empty($shopListProducts)) {
			throw new InvalidArgumentException(__d('shop', 'There are no products to checkout'));
		}
		if (empty($shopList['ShopShipping'])) {
			throw new InvalidArgumentException(__d('shop', 'Shipping details have not been completed'));
		}
		$this->_gateway()
			->shipping($shopList['ShopShipping']['shipping'])
			->insurance($shopList['ShopShipping']['insurance_rate'])
			->handling($shopList['ShopShipping']['surcharge'])
			->custom($shopListId)
			->notifyUrl(array(
				'plugin' => 'shop',
				'controller' => 'shop_list_products',
				'action' => 'process_payment',
				$shopListId
			))
			->currencyCode(ShopCurrencyLib::getCurrency());

		foreach ($shopListProducts as $shopListProduct) {
			$this->_gateway()->item(array(
				'name' => $shopListProduct['ShopProduct']['name'],
				'selling' => $shopListProduct['ShopProductVariantMaster']['ShopProductVariantPrice']['selling'],
				'quantity' => $shopListProduct['ShopListProduct']['quantity']
			));
		}
		$request = $this->_gateway()->prepare();

		if ($request['token']) {
			$this->id = $shopListId;
			$this->saveField('token', $request['token']);
			return $request;
		}
		return false;
	}

/**
 * Check that the order details match the list
 *
 * @param string $listId
 * @param array $order
 *
 * @return boolean
 */
	public function validateOrder($listId, array $order) {
		$shopList = $this->find('first', array(
			'conditions' => array(
				$this->alias . '.' . $this->primaryKey => $listId,
				$this->alias . '.token' => $order['details']['token']
			)
		));
		if (empty($shopList)) {
			return false;
		}

		// check totals are correct

		return true;
	}

/**
 * remove all the products in a list
 *
 * @param string $listId the list id to empty
 *
 * @return array
 */
	public function truncateUserList($listId) {
		$cleared = $this->ShopListProduct->deleteAll(array(
			$this->ShopListProduct->alias . '.shop_list_id' => $listId
		));

		$updated = false;
		if ($cleared) {
			$updated = $this->updateAll(
				array($this->alias . '.shop_list_product_count' => 0),
				array($this->alias . '.id' => $listId)
			);
		}

		return $cleared && $updated;
	}

/**
 * Get the details required for making an order
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array|boolean
 *
 * @throws InvalidArgumentException
 */
	protected function _findOrderDetails($state, array $query, array $results = array()) {
		if ($state == 'before') {
			if (empty($query[0])) {
				throw new InvalidArgumentException(__d('shop', 'No list specified'));
			}
			$query['fields'] = array(
				$this->alias . '.user_id',
				$this->alias . '.shop_shipping_method_id',
				$this->alias . '.shop_payment_method_id',
			);

			$query['conditions'] = array(
				$this->alias . '.' . $this->primaryKey => $query[0]
			);
			return $query;
		}

		if (!empty($results[0][$this->alias])) {
			return $results[0][$this->alias];
		}

		return false;
	}
}