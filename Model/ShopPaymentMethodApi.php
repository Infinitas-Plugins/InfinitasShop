<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopPaymentMethodApi Model
 *
 * @property ShopPaymentMethod $ShopPaymentMethod
 * @property ShopCurrency $ShopCurrency
 */
class ShopPaymentMethodApi extends ShopAppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

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
