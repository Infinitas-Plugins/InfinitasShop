<?php
App::uses('ShopAppModel', 'Shop.Model');

/**
 * ShopOrder Model
 *
 * @property User $User
 * @property ShopBillingAddress $ShopBillingAddress
 * @property ShopShippingAddress $ShopShippingAddress
 * @property ShopPaymentMethod $ShopPaymentMethod
 * @property ShopShippingMethod $ShopShippingMethod
 * @property ShopOrderStatus $ShopOrderStatus
 * @property ShopOrderNote $ShopOrderNote
 * @property ShopOrderProduct $ShopOrderProduct
 * @property ShopPaymentResponse $ShopPaymentResponse
 */
class ShopOrder extends ShopAppModel {

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopBillingAddress' => array(
			'className' => 'Shop.ShopBillingAddress',
			'foreignKey' => 'shop_billing_address_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopShippingAddress' => array(
			'className' => 'Shop.ShopShippingAddress',
			'foreignKey' => 'shop_shipping_address_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopPaymentMethod' => array(
			'className' => 'Shop.ShopPaymentMethod',
			'foreignKey' => 'shop_payment_method_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopShippingMethod' => array(
			'className' => 'Shop.ShopShippingMethod',
			'foreignKey' => 'shop_shipping_method_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopOrderStatus' => array(
			'className' => 'Shop.ShopOrderStatus',
			'foreignKey' => 'shop_order_status_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ShopOrderNote' => array(
			'className' => 'Shop.ShopOrderNote',
			'foreignKey' => 'shop_order_id',
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
		'ShopOrderProduct' => array(
			'className' => 'Shop.ShopOrderProduct',
			'foreignKey' => 'shop_order_id',
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
			'className' => 'Shop.ShopPaymentResponse',
			'foreignKey' => 'shop_order_id',
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
}