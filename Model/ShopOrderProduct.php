<?php
/**
 * ShopOrderProduct
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link http://infinitas-cms.org/Shop
 * @package	Shop.Model
 * @license	http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author Carl Sutton <dogmatic69@infinitas-cms.org>
 */

/**
 * ShopOrderProduct
 *
 * @package	Shop.Model
 *
 * @property ShopOrder $ShopOrder
 * @property ShopProductVariant $ShopProductVariant
 * @property ShopProductType $ShopProductType
 * @property ShopImage $ShopImage
 */
class ShopOrderProduct extends ShopAppModel {

/**
 * belongsTo relations for this model
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopOrder' => array(
			'className' => 'Shop.ShopOrder',
			'foreignKey' => 'shop_order_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => true,
		),
		'ShopProductVariant' => array(
			'className' => 'Shop.ShopProductVariant',
			'foreignKey' => 'shop_product_variant_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		),
		'ShopProductType' => array(
			'className' => 'Shop.ShopProductType',
			'foreignKey' => 'shop_product_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterScope' => array(
				'ShopOrderProduct.active' => 1
			),
		),
		'ShopImage' => array(
			'className' => 'Shop.ShopImage',
			'foreignKey' => 'shop_image_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		)
	);

/**
 * Constructor
 *
 * @param string|integer $id string uuid or id
 * @param string $table the table that the model is for
 * @param string $ds the datasource being used
 *
 * @return void
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'time_to_purchase' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'view_to_purchase' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		);
	}
}
