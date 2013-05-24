<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopPaymentMethod Model
 *
 * @property ShopList $ShopList
 * @property ShopOrder $ShopOrder
 */
class ShopPaymentMethod extends ShopAppModel {

	public $findMethods = array(
		'available' => true
	);

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

	protected function _findAvailable($state, array $query, array $results = array()) {
		if ($state == 'before') {
			return $query;
		}

		return Hash::extract($results,
			sprintf('{n}.%s.%s', $this->alias, $this->primaryKey),
			sprintf('{n}.%s.%s', $this->alias, $this->displayField)
		);
	}
}