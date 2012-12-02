<?php
App::uses('ShopAppModel', 'Shop.Model');

/**
 * ShopPaymentField Model
 *
 * @property ShopPaymentMethod $ShopPaymentMethod
 */

class ShopPaymentField extends ShopAppModel {

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