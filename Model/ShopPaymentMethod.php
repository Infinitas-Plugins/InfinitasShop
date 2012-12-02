<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopPaymentMethod Model
 *
 * @property PaymentMethodApi $PaymentMethodApi
 * @property ShopList $ShopList
 * @property ShopOrder $ShopOrder
 * @property ShopPaymentField $ShopPaymentField
 * @property ShopPaymentMethodStatus $ShopPaymentMethodStatus
 * @property ShopPaymentResponse $ShopPaymentResponse
 */
class ShopPaymentMethod extends ShopAppModel {

	public $findMethods = array(
		'available' => true
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'PaymentMethodApi' => array(
			'className' => 'PaymentMethodApi',
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
		'ShopPaymentField' => array(
			'className' => 'ShopPaymentField',
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
		'ShopPaymentMethodStatus' => array(
			'className' => 'ShopPaymentMethodStatus',
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
		'ShopPaymentResponse' => array(
			'className' => 'ShopPaymentResponse',
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
		)
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