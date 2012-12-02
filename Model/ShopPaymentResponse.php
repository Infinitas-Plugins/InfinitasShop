<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopPaymentResponse Model
 *
 * @property ShopPaymentMethod $ShopPaymentMethod
 * @property ShopOrder $ShopOrder
 */

class ShopPaymentResponse extends ShopAppModel {

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
		'ShopOrder' => array(
			'className' => 'ShopOrder',
			'foreignKey' => 'shop_order_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}