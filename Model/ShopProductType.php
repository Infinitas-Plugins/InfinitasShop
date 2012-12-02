<?php
/**
 * ShopProductTypesOption Model
 *
 * @property ShopCategory $ShopCategory
 * @property ShopProduct $ShopProduct
 * @property ShopProductTypesOption $ShopProductTypesOption
 */
class ShopProductType extends ShopAppModel {

/**
 * Custom find methods
 *
 * @var array
 */
	public $findMethods = array(
		'options' => true
	);

/**
 * HasMany relations
 *
 * @var array
 */
	public $hasMany = array(
		'ShopProductTypesOption' => array(
			'className' => 'Shop.ShopProductTypesOption',
			'foreignKey' => 'shop_product_type_id',
			'dependent' => true
		),
		'ShopCategory' => array(
			'className' => 'Shop.ShopCategory',
			'foreignKey' => 'shop_product_type_id',
			'dependent' => true
		),
		'ShopProduct' => array(
			'className' => 'Shop.ShopProduct',
			'foreignKey' => 'shop_product_type_id',
			'dependent' => true
		)
	);

/**
 * Constructor
 *
 * @param type $id
 * @param type $table
 * @param type $ds
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(

		);
	}
}