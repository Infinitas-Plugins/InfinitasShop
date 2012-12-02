<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopPaymentMethodStatus Model
 *
 * @property ShopPaymentMethod $ShopPaymentMethod
 */

class ShopPaymentMethodStatus extends ShopAppModel {

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
		)
	);
}