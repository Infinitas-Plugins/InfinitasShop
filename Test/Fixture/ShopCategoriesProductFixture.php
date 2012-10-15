<?php
/**
 * ShopCategoriesProductFixture
 *
 */
class ShopCategoriesProductFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'shop_category_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index'),
		'shop_product_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_categories_products_shop_categories1' => array('column' => 'shop_category_id', 'unique' => 0),
			'fk_shop_categories_products_shop_products1' => array('column' => 'shop_product_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'shop_category_id' => 'active',
			'shop_product_id' => 'active'
		),
		array(
			'id' => 2,
			'shop_category_id' => 'active',
			'shop_product_id' => 'inactive'
		),
		array(
			'id' => 3,
			'shop_category_id' => 'inactive',
			'shop_product_id' => 'inactive-category'
		),
		array(
			'id' => 4,
			'shop_category_id' => 'inactive-parent',
			'shop_product_id' => 'inactive-parent-category'
		),
		array(
			'id' => 5,
			'shop_category_id' => 'another',
			'shop_product_id' => 'multi-category'
		),
		array(
			'id' => 6,
			'shop_category_id' => 'active',
			'shop_product_id' => 'multi-category'
		),
		array(
			'id' => 7,
			'shop_category_id' => 'active',
			'shop_product_id' => 'multi-category-mixed-state'
		),
		array(
			'id' => 8,
			'shop_category_id' => 'inactive',
			'shop_product_id' => 'multi-category-mixed-state'
		),
		array(
			'id' => 9,
			'shop_category_id' => 'active',
			'shop_product_id' => 'multi-category-parent-inactive'
		),
		array(
			'id' => 10,
			'shop_category_id' => 'active',
			'shop_product_id' => 'inactive-parent'
		),
		array(
			'id' => 11,
			'shop_category_id' => 'active',
			'shop_product_id' => 'multi-option'
		),
	);

}
