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
 * @brief custom find methods
 *
 * @var array
 */
	public $findMethods = array(
		'hasList' => true,
		'listDetails' => true
	);

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
 * @brief overload construct for translated validation
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
					'required' => true
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
 * @brief validate the user is correct
 *
 * @param array $field the data being validated
 *
 * @return boolean
 */
	public function validateUserId(array $field) {
		$field = current($field);
		if(!$this->User->exists($field)) {
			return (bool)CakeSession::read('Shop.Guest.id', $field);
		}
		return true;
	}

/**
 * @brief get the id of the current list
 *
 * get the id of the list currently being used.
 *
 * @return string
 */
	public function currentListId($create = false) {
		$currentList = CakeSession::read(self::$sessionListKey);

		if(!empty($currentList) && $this->exists($currentList)) {
			return $currentList;
		}

		$currentList = $this->find(
			'list',
			array(
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
			)
		);

		$currentList = current($currentList);
		if(!empty($currentList)) {
			return $this->setCurrentList($currentList);
		}

		if(!$create) {
			return false;
		}

		return $this->createList();
	}

/**
 * @brief set the current list id
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
		if(empty($listId)) {
			throw new InvalidArgumentException('Invalid list selected');
		}

		CakeSession::write(self::$sessionListKey, current($listId));

		return CakeSession::read(self::$sessionListKey);
	}

/**
 * @brief create a list for a user
 *
 * This will create a list for a user, if no data is passed a generic cart
 * will be created.
 *
 * @param array $data the data to create the list with.
 *
 * @return string
 */
	public function createList(array $data = array()) {
		$data = array_merge(
			array(
				'name' => __d('shop', 'Cart'),
				'user_id' => $this->currentUserId(),
			),
			$data
		);

		if($this->save($data)) {
			return $this->id;
		}

		return false;
	}

/**
 * @brief string find conditions
 *
 * @param string $state
 * @param array $query
 *
 * @return array
 */
	protected function _baseFind($state, array $query) {
		if($state == 'before') {
			$query['fields'] = array_merge(
				(array)$query['fields'],
				array(
					$this->alias . '.' . $this->primaryKey,
					$this->alias . '.' . $this->displayField,
					$this->alias . '.user_id',
					$this->User->alias . '.' . $this->User->primaryKey,
					$this->User->alias . '.' . $this->User->displayField,

					$this->ShopPaymentMethod->alias  . '.' . $this->ShopPaymentMethod->primaryKey,
					$this->ShopPaymentMethod->alias  . '.' . $this->ShopPaymentMethod->displayField,

					$this->ShopShippingMethod->alias  . '.' . $this->ShopShippingMethod->primaryKey,
					$this->ShopShippingMethod->alias  . '.' . $this->ShopShippingMethod->displayField
				)
			);

			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				array(
					$this->alias . '.user_id' => $this->currentUserId(),
				)
			);

			$conditions = array(
				'ShopPaymentMethod.id = ShopList.shop_payment_method_id',
				$this->ShopPaymentMethod->alias . '.active' => 1
			);
			if($this->isGuest()) {
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
			if($this->isGuest()) {
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
 * @brief check if the user has a list already
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return boolean
 */
	protected function _findHasList($state, array $query, array $results = array()) {
		if($state == 'before') {
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

}
