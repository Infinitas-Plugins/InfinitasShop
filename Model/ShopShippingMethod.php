<?php
App::uses('ShopAppModel', 'Shop.Model');

/**
 * ShopShippingMethod Model
 *
 * @property ShopList $ShopList
 * @property ShopOrder $ShopOrder
 * @property ShopShippingMethodValue $ShopShippingMethodValue
 * @property ShopSupplier $ShopSupplier
 */

class ShopShippingMethod extends ShopAppModel {

/**
 * custom find methods
 *
 * @var array
 */
	public $findMethods = array(
		'shipping' => true,
		'product' => true,
		'productList' => true,
		'available' => true,
		'info' => true
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
 * hasMany associations
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
 * overload construct for translated validation
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
 * get a sipping rate
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
		if ($state == 'before') {

			$query['fields'] = array_merge((array)$query['fields'], array(
				$this->alias . '.' . $this->primaryKey,
				$this->alias . '.' . $this->displayField,
				$this->ShopSupplier->alias . '.' . $this->ShopSupplier->primaryKey,
				$this->ShopSupplier->alias . '.' . $this->ShopSupplier->displayField
			));

			$query['conditions'] = array_merge((array)$query['conditions'], array(
				$this->alias . '.active' => 1,
				$this->ShopSupplier->alias . '.active' => 1,
			));
			$query['joins'][] = $this->autoJoinModel($this->ShopSupplier->fullModelName());

			if (empty($query['shop_shipping_method_id'])) {
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

		if (empty($results)) {
			return array();
		}

		$results = current($results);
		$results[$this->alias][$this->ShopShippingMethodValue->alias] = $this->ShopShippingMethodValue->find('values', array(
			'shop_shipping_method_id' => $results[$this->alias][$this->primaryKey]
		));
		$results[$this->alias][$this->ShopSupplier->alias] = $results[$this->ShopSupplier->alias];
		unset($results[$this->ShopSupplier->alias]);

		if (empty($results[$this->alias][$this->ShopShippingMethodValue->alias])) {
			return array();
		}

		return $results;
	}

/**
 * get the shipping particulars for a selected product
 *
 * @param  string $state   [description]
 * @param  array $query   [description]
 * @param  array $results [description]
 *
 * @return array
 *
 * @throws CakeException
 */
	protected function _findProduct($state, array $query, array $results = array()) {
		if ($state == 'before') {
			$query = array_merge(array(
				'shop_product_id' => null,
				'shop_product_variant_id' => null
			), $query);
			$query = self::_findShipping($state, $query);
			return $query;
		}

		$sizes = ClassRegistry::init('Shop.ShopProduct')->find('productShipping', array(
			'shop_product_id' => $query['shop_product_id'],
			'shop_product_variant_id' => $query['shop_product_variant_id']
		));

		$results = self::_findShipping($state, $query, $results);

		if (empty($results)) {
			throw new CakeException(__d('shop', 'Unable to get the selected shipping method'));
		}

		return self::_getShipping($sizes, $results[$this->alias][$this->ShopShippingMethodValue->alias][0]);
	}

/**
 * get the shipping details of a product list
 *
 * @param  string $state   [description]
 * @param  array  $query   [description]
 * @param  array  $results [description]
 *
 * @return array
 *
 * @throws CakeException
 */
	protected function _findProductList($state, array $query, array $results = array()) {
		if ($state == 'before') {
			$query = array_merge(array('shop_list_id' => null), $query);
			if (empty($query['shop_list_id'])) {
				$query['shop_list_id'] = ClassRegistry::init('Shop.ShopList')->currentListId();
			}
			return self::_findShipping($state, $query);
		}

		$results = self::_findShipping($state, $query, $results);

		if (empty($results)) {
			throw new CakeException(__d('shop', 'Unable to get the selected shipping method'));
		}

		$sizes = ClassRegistry::init('Shop.ShopProduct')->find('prodcutListShipping', array(
			'shop_list_id' => $query['shop_list_id']
		));

		return self::_getShipping($sizes, $results[$this->alias][$this->ShopShippingMethodValue->alias][0]);
	}

/**
 * get the shipping costs
 *
 * $sizes expects having the width, height, lenght and cost available.
 *
 * @param array $sizes the values for the current check
 * @param array $rates the rates table from the database
 *
 * @return array
 */
	protected function _getShipping(array $sizes, array &$method) {
		$sizes = array_merge(array(
			'weight' => 0,
			'cost' => 0
		), (array)$sizes);
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
 * calculate the shipping cost based on the product weight
 *
 * @param  float $weight the weight of the item being checked
 * @param  array $shipping the shipping prices
 *
 * @throws CakeException when no option is available
 *
 * @return float
 */
	protected function _calculateShipping($weight, array &$rates) {
		foreach ($rates as $cost) {
			if ($weight < $cost['limit']) {
				return $cost['rate'];
			}
		}

		throw new CakeException(__d('shop', 'Product is to heavy to be shipped by this method'));
	}

/**
 * calculate the insurance provided by selected shipping method
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
		foreach ($insurance as $cost) {
			if ($price < $cost['limit']) {
				return $cost;
			}
		}

		return $price;
	}

/**
 * Find the available shipping methods
 *
 * This takes into account the various shipping rules such as what type of user it is and the total of
 * the cart. Only shipping methods that match are returned.
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findAvailable($state, array $query, array $results = array()) {
		if ($state == 'before') {
			$query['fields'] = array(
				$this->alias . '.' . $this->primaryKey,
				$this->alias . '.' . $this->displayField
			);

			$cartTotal = $this->ShopList->ShopListProduct->ShopProductVariant->ShopProduct->find('costForList');

			$query['conditions'] = array_merge((array)$query['conditions'], array(
				$this->alias . '.active' => true
			));

			$query['joins'] = array(
				$this->autoJoinModel(array(
					'model' => $this->ShopShippingMethodValue->fullModelName(),
					'conditions' => array(
						$this->alias . '.' . $this->primaryKey . ' = ' . $this->ShopShippingMethodValue->alias . '.shop_shipping_method_id',
						$this->ShopShippingMethodValue->alias . '.active' => true,
						$this->ShopShippingMethodValue->alias . '.require_login' => array_unique(array(
							false,
							(bool)AuthComponent::user('id')
						)),
						array('or' => array(
							$this->ShopShippingMethodValue->alias . '.total_minimum <=' => $cartTotal,
							$this->ShopShippingMethodValue->alias . '.total_minimum' => null
						)),
						array('or' => array(
							$this->ShopShippingMethodValue->alias . '.total_maximum >=' => $cartTotal,
							$this->ShopShippingMethodValue->alias . '.total_maximum' => null
						))
					),
					'type' => 'right'
				))
			);
			return $query;
		}

		return Hash::combine($results,
			sprintf('{n}.%s.%s', $this->alias, $this->primaryKey),
			sprintf('{n}.%s.%s', $this->alias, $this->displayField)
		);
	}

	protected function _findInfo($state, array $query, array $results = array()) {
		if ($state == 'before') {
			$fields = $query['fields'];
			$query = self::_findAvailable($state, $query);

			$this->virtualFields['shipping_time_min'] = sprintf('MIN(%s.delivery_time)', $this->ShopShippingMethodValue->alias);
			$this->virtualFields['shipping_time_max'] = sprintf('MAX(%s.delivery_time)', $this->ShopShippingMethodValue->alias);

			$query['fields'] = array_merge((array)$fields, array(
				$this->alias . '.' . $this->primaryKey,
				$this->alias . '.' . $this->displayField,
				'shipping_time_min',
				'shipping_time_max',

				$this->ShopSupplier->alias . '.' . $this->ShopSupplier->primaryKey,
				$this->ShopSupplier->alias . '.' . $this->ShopSupplier->displayField,
			));

			$query['joins'][] = $this->autoJoinModel($this->ShopSupplier->fullModelName());
			return $query;
		}
		$shippingMethodValues = $this->ShopShippingMethodValue->find('values', array(
			'shop_shipping_method_id' => Hash::extract($results, sprintf('{n}.%s.%s', $this->alias, $this->primaryKey))
		));
		foreach ($results as &$result) {
			$shippingMethodValue = Hash::extract($shippingMethodValues, sprintf('{n}[shop_shipping_method_id=/%s/]', $result[$this->alias][$this->primaryKey]));
			$result[$this->alias]['insurance_cover_max'] = max(Hash::extract($shippingMethodValue, '{n}.insurance.{n}.limit'));
		}

		return $results;
	}
}