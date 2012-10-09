<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopPaymentMethodStatus Model
 *
 * @property ShopPaymentMethod $ShopPaymentMethod
 */
class ShopPaymentMethodStatus extends ShopAppModel {


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
		)
	);
}
