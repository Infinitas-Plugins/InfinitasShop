<?php
App::uses('ShopAppModel', 'Shop.Model');

/**
 * ShopPaymentMethodApi Model
 *
 * @property ShopPaymentMethod $ShopPaymentMethod
 * @property ShopCurrency $ShopCurrency
 */

class ShopPaymentMethodApi extends ShopAppModel {

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopPaymentMethod' => array(
			'className' => 'ShopPaymentMethod',
			'foreignKey' => 'shop_payment_method_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopCurrency' => array(
			'className' => 'ShopCurrency',
			'foreignKey' => 'shop_currency_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}