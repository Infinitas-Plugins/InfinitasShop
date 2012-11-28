<?php
/**
 * ShopShippingMethodValue model
 *
 * @brief Add some documentation for ShopShippingMethodValue model.
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link		  http://infinitas-cms.org/Shop
 * @package	   Shop.Model
 * @license	   http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author dogmatic69
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */

class ShopShippingMethodValue extends ShopAppModel {
	public $findMethods = array(
		'values' => true
	);

/**
 * How the default ordering on this model is done
 *
 * @access public
 * @var array
 */
	public $order = array(
	);

/**
 * hasOne relations for this model
 *
 * @access public
 * @var array
 */
	public $hasOne = array(
	);

/**
 * belongsTo relations for this model
 *
 * @access public
 * @var array
 */
	public $belongsTo = array(
		'ShopShippingMethod' => array(
			'className' => 'Shop.ShopShippingMethod',
			'foreignKey' => 'shop_shipping_method_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => true,
			'counterScope' => array(
				'ShopShippingMethodValue.active' => 1
			),
		)
	);

/**
 * overload the construct method so that you can use translated validation
 * messages.
 *
 * @access public
 *
 * @param mixed $id string uuid or id
 * @param string $table the table that the model is for
 * @param string $ds the datasource being used
 *
 * @return void
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'shop_shipping_method_id' => array(
				'notEmpty' => array(
					'rule' => 'notEmpty',
					'message' => __d('shop', 'No shipping method associated'),
					'allowEmpty' => false,
					'required' => true
				)
			),
			'insurance' => array(
				'field_present' => array(
					'rule' => 'notEmpty',
					'message' => __d('shop', 'No insurance rates'),
					'allowEmpty' => true,
					'required' => true
				)
			),
			'rates' => array(
				'field_present' => array(
					'rule' => 'notEmpty',
					'message' => __d('shop', 'No shipping rates'),
					'allowEmpty' => true,
					'required' => true
				)
			),
			'active' => array(
				'boolean' => array(
					'rule' => 'boolean',
					'message' => __d('shop', 'Active should be boolean (true / false)'),
				)
			),
			'surcharge' => array(
				'validateFloatAboveZero' => array(
					'rule' => 'validateFloatAboveZero',
					'message' => __d('shop', 'Surcharge should be in the format xx.xxx'),
					'required' => true,
					'allowEmpty' => true
				)
			),
			'delivery_time' => array(
				'comparison' => array(
					'rule' => array('comparison', '>', 1),
					'message' => __d('shop', 'Enter a valid number of hours for delivery estimation'),
					'required' => true,
					'allowEmpty' => false
				)
			),
			'total_minimum' => array(
				'validateFloatAboveZero' => array(
					'rule' => 'validateFloatAboveZero',
					'message' => __d('shop', 'Enter a valid amount for the order minimum'),
					'required' => true,
					'allowEmpty' => true
				)
			),
			'total_maximum' => array(
				'validateFloatAboveZero' => array(
					'rule' => 'validateFloatAboveZero',
					'message' => __d('shop', 'Enter a valid amount for the order maximum'),
					'required' => true,
					'allowEmpty' => true
				)
			),
			'require_login' => array(
				'boolean' => array(
					'rule' => 'boolean',
					'message' => __d('shop', 'Require login should be boolean (true / false)'),
				)
			),
		);
	}

/**
 * @brief validate the field is a float type
 *
 * @param array $field the data being validated
 *
 * @return boolean
 */
	public function validateFloatAboveZero(array $field) {
		$field = current($field);
		return empty($field) || is_float((float)$field) || $field > 0;
	}

/**
 * @brief parse the insurance and rates for the backend CRUD
 *
 * @param array|boolean $results the results from a find
 * @param boolean $primary is this find on the model or from a relation
 *
 * @return array|boolean
 */
	public function afterFind($results, $primary = false) {
		if($this->findQueryType == 'first') {
			foreach($results as &$result) {
				self::_explode($result[$this->alias]['insurance']);
				self::_explode($result[$this->alias]['rates']);
			}
		}

		return parent::afterFind($results, $primary);
	}

/**
 * @brief implode the rates before validation/saving
 *
 * @param array $options options for validation see Model::beforeValidate()
 *
 * @return boolean
 */
	public function beforeValidate($options = array()) {
		if(!empty($this->data[$this->alias]['rates'])) {
			$this->_implode($this->data[$this->alias]['rates']);
		}
		if(!empty($this->data[$this->alias]['insurance'])) {
			$this->_implode($this->data[$this->alias]['insurance']);
		}
		return true;
	}

/**
 * @brief find shipping values
 *
 * @param string $state before or after
 * @param array $query the query being performed
 * @param array $results the results from the find
 *
 * @throws InvalidArgumentException
 *
 * @return array
 */
	protected function _findValues($state, array $query, array $results = array()) {
		if($state == 'before') {
			if(empty($query['shop_shipping_method_id'])) {
				throw new InvalidArgumentException(__d('shop', 'No shipping method selected'));
			}

			$query['fields'] = array_merge(
				(array)$query['fields'],
				array(
					$this->alias . '.' . $this->primaryKey,
					$this->alias . '.' . $this->displayField,
					$this->alias . '.shop_shipping_method_id',
					$this->alias . '.insurance',
					$this->alias . '.rates',
					$this->alias . '.surcharge',
					$this->alias . '.delivery_time',
					$this->alias . '.total_minimum',
					$this->alias . '.total_maximum',
					$this->alias . '.require_login',
				)
			);

			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				array(
					$this->alias . '.shop_shipping_method_id' => $query['shop_shipping_method_id']
				)
			);
			if(!AuthComponent::user('id')) {
				$query['conditions'][$this->alias . '.require_login'] = 0;
			}

			if(!empty($query['order_value'])) {
				$query['conditions'][] = array(
					array(
						'or' => array(
							$this->alias . '.total_minimum' => null,
							$this->alias . '.total_minimum <=' => $query['order_value']
						)
					),
					array(
						'or' => array(
							$this->alias . '.total_maximum' => null,
							$this->alias . '.total_maximum >=' => $query['order_value']
						)
					)
				);
			}

			return $query;
		}
		if(empty($results)) {
			return array();
		}

		$results = Hash::extract($results, '{n}.' . $this->alias);
		foreach($results as &$result) {
			self::_explode($result['insurance']);
			self::_explode($result['rates']);
		}

		return $results;
	}

/**
 * @brief parse the shipping values into arrays
 *
 * @param string $values values (passed by reference)
 * @param  boolean $insurance insurance or shipping
 *
 * @return void
 */
	protected function _explode(&$values) {
		$values = array_filter(explode(',', trim($values)));
		if(empty($values)) {
			return;
		}

		array_walk($values, function(&$value) {
			$tmp = explode(':', $value);
			$value = array(
				'limit' => (float)$tmp[0],
				'rate' => (float)$tmp[1]
			);
		});

		usort($values, function($a, $b) {
		    return $a['limit'] - $b['limit'];
		});
	}

/**
 * @brief implode the values for sotrage
 *
 * @param array $values the data to be imploded
 *
 * @return void
 */
	protected function _implode(&$values) {
		foreach($values as $k => &$value) {
			$value = array_filter($value);
			if(count($value) != 2) {
				unset($values[$k]);
				continue;
			}

			$value = implode(':', array(
				'limit' => $value['limit'],
				'rate' => $value['rate']
			));
		}

		$values = implode(',', $values);
	}
}
