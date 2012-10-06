<?php
/**
 * ShopProductTypesOption Model
 *
 * @property ShopCategory $ShopCategory
 * @property ShopProduct $ShopProduct
 * @property ShopProductTypesOption $ShopProductTypesOption
 */
class ShopProductType extends ShopAppModel {
	public $validate = array();

	public $belongsTo = array(
		'ShopCategory' => array(
			'modelClass' => 'Shop.ShopCategory',
			'foreignKey' => 'foreign_key',
			'conditions' => array(
				'ShopProductType.model' => 'Shop.ShopCategory'
			)
		),
		'ShopProduct' => array(
			'modelClass' => 'Shop.ShopProduct',
			'foreignKey' => 'foreign_key',
			'conditions' => array(
				'ShopProductType.model' => 'Shop.ShopProduct'
			)
		)
	);

	public $hasMany = array(
		'ShopProductTypesOption' => array(
			'modelClass' => 'Shop.ShopProductTypesOption',
			'foreignKey' => 'shop_product_type_id',
			'dependent' => true
		)
	);

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(

		);
	}

}
