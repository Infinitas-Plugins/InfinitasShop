<?php
App::uses('ShopAppModel', 'Shop.Model');

/**
 * ShopPaymentMethod Model
 *
 * @property InfinitasPaymentMethod $InfinitasPaymentMethod
 */

class ShopPaymentMethod extends ShopAppModel {

/**
 * custom find methods
 *
 * @var array
 */
	public $findMethods = array(
		'available' => true,
		'info' => true
	);

/**
 * belongsTo relations
 *
 * @var array
 */
	public $belongsTo = array(
		'InfinitasPaymentMethod' => array(
			'className' => 'InfinitasPayments.InfinitasPaymentMethod',
			'foreignKey' => 'infinitas_payment_method_id'
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ShopList' => array(
			'className' => 'ShopList',
			'foreignKey' => 'shop_payment_method_id',
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
			'foreignKey' => 'shop_payment_method_id',
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
	);

/**
 * Find available payment methods
 *
 * This is similar to available shipping methods, the order should match the prescribed rules and auth status.
 * Disabled InfinitasPaymentMethod's will be ignored, only active methods can be used.
 * 
 * @param string $state before / after
 * @param array $query the query conditions
 * @param array $results the find results
 *
 * @return array
 *
 * @throws InvalidArgumentException
 */
	protected function _findAvailable($state, array $query, array $results = array()) {
		if ($state == 'before') {
			if (!array_key_exists('order_value', $query)) {
				throw new InvalidArgumentException(__d('shop', 'No order value specified'));
			}
			$query['conditions'] = array_merge((array)$query['conditions'], array(
				$this->fullFieldName('active') => 1,
				$this->fullFieldName('require_login') => array_unique(array(
					false,
					(bool)AuthComponent::user('id')
				)),
				array('or' => array(
					$this->fullFieldName('total_minimum') => null,
					$this->fullFieldName('total_minimum <=') => $query['order_value'],
				)),
				array('or' => array(
					$this->fullFieldName('total_maximum') => null,
					$this->fullFieldName('total_maximum >=') => $query['order_value'],
				)),
			));

			$query['joins'] = !empty($query['joins']) ? $query['joins'] : array();
			$join = $this->autoJoinModel(array(
				'model' => $this->InfinitasPaymentMethod,
				'type' => 'right'
			));
			$join['conditions'][$this->InfinitasPaymentMethod->fullFieldName('active')] = 1;
			$query['joins'][] = $join;
			return $query;
		}

		return Hash::combine($results,
			sprintf('{n}.%s.%s', $this->alias, $this->primaryKey),
			sprintf('{n}.%s.%s', $this->alias, $this->displayField)
		);
	}


/**
 * get the info of the available payment methods
 *
 * @param string $state
 * @param array $query
 * @param array $results
 *
 * @return array
 */
	protected function _findInfo($state, array $query, array $results = array()) {
		if ($state == 'before') {
			$fields = $query['fields'];
			$query = self::_findAvailable($state, $query);

			$query['fields'] = array_merge((array)$fields, array(
				$this->alias . '.' . $this->primaryKey,
				$this->alias . '.' . $this->displayField,

				$this->InfinitasPaymentMethod->alias . '.' . $this->InfinitasPaymentMethod->primaryKey,
				$this->InfinitasPaymentMethod->alias . '.' . $this->InfinitasPaymentMethod->displayField,
				$this->InfinitasPaymentMethod->alias . '.image',
			));

			return $query;
		}

		foreach ($results as &$result) {
			foreach ($this->InfinitasPaymentMethod->uploadImageSizes('image') as $size) {
				$result['InfinitasPaymentMethod']['image_' . $size] = $this->InfinitasPaymentMethod->uploadImageUrl('image', $result['InfinitasPaymentMethod']['id'], $result['InfinitasPaymentMethod']['image'], $size);
			}
		}

		return $results;
	}
}