<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopShippingMethod Model
 *
 * @property ShopList $ShopList
 * @property ShopOrder $ShopOrder
 */
class ShopShippingMethod extends ShopAppModel {
/**
 * @brief custom find methods
 * 
 * @var array
 */
	public $findMethods = array(
		'shipping' => true,
		'product' => true,
		'productList' => true
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopSupplier' => array(
			'className' => 'Shop.ShopSupplier',
			'foreignKey' => 'shop_supplier_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * @brief hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ShopList' => array(
			'className' => 'Shop.ShopList',
			'foreignKey' => 'shop_shipping_method_id',
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
		'ShopOrder' => array(
			'className' => 'Shop.ShopOrder',
			'foreignKey' => 'shop_shipping_method_id',
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
		'ShopShippingMethodValue' => array(
			'className' => 'Shop.ShopShippingMethodValue',
			'foreignKey' => 'shop_shipping_method_id',
			'dependent' => true,
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
 * @param boolean $id    [description]
 * @param [type]  $table [description]
 * @param [type]  $ds    [description]
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(

		);
	}

/**
 * @brief get a sipping rate
 *
 * This will fetch a shipping rate based on either the passed in shipping id or 
 * the users current cart set up.
 *
 * @param  string $state   [description]
 * @param  array  $query   [description]
 * @param  array  $results [description]
 * 
 * @return array
 */
	protected function _findShipping($state, array $query, array $results = array()) {
		if($state == 'before') {

			$query['fields'] = array_merge(
				(array)$query['fields'],
				array(
					$this->alias . '.' . $this->primaryKey,
					$this->alias . '.' . $this->displayField,
					$this->ShopSupplier->alias . '.' . $this->ShopSupplier->primaryKey,
					$this->ShopSupplier->alias . '.' . $this->ShopSupplier->displayField
				)
			);

			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				array(
					$this->alias . '.active' => 1,
					$this->ShopSupplier->alias . '.active' => 1,
				)
			);
			$query['joins'][] = $this->autoJoinModel($this->ShopSupplier->fullModelName());

			if(empty($query['shop_shipping_method_id'])) {
				$query['joins'][] = $this->autoJoinModel(array(
					'model' => 'Shop.ShopList',
					'conditions' => array(
						'ShopList.shop_shipping_method_id = ShopShippingMethod.id',
						'ShopList.id' => ClassRegistry::init('Shop.ShopList')->currentListId()
					),
					'type' => 'right'
				));
			} else {
				$query['conditions'][$this->alias . '.' . $this->primaryKey] = $query['shop_shipping_method_id'];
			}

			$query['limit'] = 1;
			
			return $query;
		}

		if(empty($results)) {
			return array();
		}

		$results = current($results);
		$results[$this->alias][$this->ShopShippingMethodValue->alias] = $this->ShopShippingMethodValue->find('values', array(
			'shop_shipping_method_id' => $results[$this->alias][$this->primaryKey]
		));
		$results[$this->alias][$this->ShopSupplier->alias] = $results[$this->ShopSupplier->alias];
		unset($results[$this->ShopSupplier->alias]);

		if(empty($results[$this->alias][$this->ShopShippingMethodValue->alias])) {
			return array();
		}

		return $results;
	}

/**
 * @brief get the shipping particulars for a selected product
 * 
 * @param  string $state   [description]
 * @param  array $query   [description]
 * @param  array $results [description]
 * 
 * @return array
 */
	protected function _findProduct($state, array $query, array $results = array()) {
		if($state == 'before') {
			$query = array_merge(array('shop_product_id' => null), $query);
			return self::_findShipping($state, $query);
		}

		$results = self::_findShipping($state, $query, $results);

		if(empty($results)) {
			throw new CakeException(__d('shop', 'Unable to get the selected shipping method'));
		}

		$sizes = ClassRegistry::init('Shop.ShopProduct')->find('productShipping', $query['shop_product_id']);

		return self::_getShipping($sizes, $results[$this->alias][$this->ShopShippingMethodValue->alias][0]);
	}

/**
 * @brief get the shipping details of a product list
 * 
 * @param  string $state   [description]
 * @param  array  $query   [description]
 * @param  array  $results [description]
 * 
 * @return array
 */
	protected function _findProductList($state, array $query, array $results = array()) {
		if($state == 'before') {
			$query = array_merge(array('shop_list_id' => null), $query);
			if(empty($query['shop_list_id'])) {
				$query['shop_list_id'] = ClassRegistry::init('Shop.ShopList')->currentListId();
			}
			return self::_findShipping($state, $query);
		}

		$results = self::_findShipping($state, $query, $results);

		if(empty($results)) {
			throw new CakeException(__d('shop', 'Unable to get the selected shipping method'));
		}

		$sizes = ClassRegistry::init('Shop.ShopProduct')->find('prodcutListShipping', array(
			'shop_list_id' => $query['shop_list_id']
		));

		return self::_getShipping($sizes, $results[$this->alias][$this->ShopShippingMethodValue->alias][0]);
	}

/**
 * @brief get the shipping costs
 *
 * $sizes expects having the width, height, lenght and cost available.
 * 
 * @param array $sizes the values for the current check
 * @param array $rates the rates table from the database
 * 
 * @return array
 */
	protected function _getShipping(array $sizes, array &$method) {
		$shipping = self::_calculateShipping($sizes['weight'], $method['rates']);
		$insurance = self::_calculateInsurance($sizes['cost'], $method['insurance']);
		return array(
			'total' => round($shipping + $method['surcharge'] + $insurance['rate'], 4),
			'shipping' => round($shipping, 4),
			'insurance_rate' => round($insurance['rate'], 4),
			'insurance_cover' => round($insurance['limit'], 4),
			'surcharge' => $method['surcharge']
		);
	}

/**
 * @brief calculate the shipping cost based on the product weight
 *
 * @param  float $weight the weight of the item being checked
 * @param  array $shipping the shipping prices
 *
 * @throws CakeException when no option is available
 * 
 * @return float
 */
	protected function _calculateShipping($weight, array &$rates) {
		foreach($rates as $cost) {
			if($weight < $cost['limit']) {
				return $cost['rate'];
			}
		}

		throw new CakeException(__d('shop', 'Product is to heavy to be shipped by this method'));
	}
/**
 * @brief calculate the insurance provided by selected shipping method
 *
 * This will return the best insurance cover base on the price of the passed
 * in value. If the item is more expensive than the highest available insurance 
 * option the highest option is returned.
 *
 * The rate + limit is returned to be displayed on the front end so users will 
 * see how much cover they have (or if there is short fall)
 * 
 * @param  float $price the cost of goods being insured
 * @param  array $insurance the insurance options
 * 
 * @return array
 */
	protected function _calculateInsurance($price, array &$insurance) {
		foreach($insurance as $cost) {
			if($price < $cost['limit']) {
				return $cost;
			}
		}

		return $price;
	}

}
