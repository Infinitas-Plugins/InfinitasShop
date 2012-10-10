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
		'shipping' => true
	);

/**
 * @brief hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ShopList' => array(
			'className' => 'ShopList',
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
			'className' => 'ShopOrder',
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
	public function _findShipping($state, array $query, array $results = array()) {
		if($state == 'before') {

			$query['fields'] = array_merge(
				(array)$query['fields'],
				array(
					$this->alias . '.' . $this->primaryKey,
					$this->alias . '.' . $this->displayField,
					$this->alias . '.insurance',
					$this->alias . '.rates',
					$this->alias . '.total_minimum',
					$this->alias . '.total_maximum'
				)
			);

			$query['conditions'] = array_merge(
				(array)$query['conditions'],
				array(
					$this->alias . '.active' => 1,
				)
			);

			if(empty($query[0])) {
				$query['joins'][] = $this->autoJoinModel(array(
					'model' => 'Shop.ShopList',
					'conditions' => array(
						'ShopList.shop_shipping_method_id = ShopShippingMethod.id',
						'ShopList.id' => ClassRegistry::init('Shop.ShopList')->currentListId()
					),
					'type' => 'right'
				));
			} else {
				$query['conditions'][$this->alias . '.' . $this->primaryKey] = $query[0];
			}

			if(!AuthComponent::user('id')) {
				$query['conditions'][$this->alias . '.require_login'] = 0;
			}

			$query['limit'] = 1;
			
			return $query;
		}

		if(empty($results)) {
			return array();
		}

		$results = current($results);

		self::_parseValues($results[$this->alias]['insurance'], true);
		self::_parseValues($results[$this->alias]['rates']);

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
	protected function _parseValues(&$values, $insurance = false) {
		$values = array_filter(explode(',', trim($values)));
		if(empty($values)) {
			return;
		}

		array_walk($values, function(&$value) use($insurance) {
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

}
