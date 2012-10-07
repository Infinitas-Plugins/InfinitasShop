<?php
/**
 * ShopCategoryFixture
 *
 */
class ShopCategoryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'keywords' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_image_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index'),
		'shop_product_type_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index'),
		'product_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'lft' => array('type' => 'integer', 'null' => false, 'default' => null),
		'rght' => array('type' => 'integer', 'null' => false, 'default' => null),
		'parent_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_categories_shop_categories1' => array('column' => 'parent_id', 'unique' => 0),
			'fk_shop_categories_shop_images1' => array('column' => 'shop_image_id', 'unique' => 0)
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
			'id' => 'active',
			'name' => 'active',
			'slug' => 'active',
			'description' => 'Normal active category',
			'keywords' => 'active',
			'shop_image_id' => 'shop-image-1',
			'shop_product_type_id' => null,
			'product_count' => 1,
			'active' => 1,
			'lft' => 1,
			'rght' => 2,
			'parent_id' => null,
			'created' => '2012-10-05 02:00:12',
			'modified' => '2012-10-05 02:00:12'
		),
		array(
			'id' => 'inactive',
			'name' => 'inactive',
			'slug' => 'inactive',
			'description' => 'Normal inactive category',
			'keywords' => 'inactive',
			'shop_image_id' => 'shop-image-1',
			'shop_product_type_id' => null,
			'product_count' => 1,
			'active' => 0,
			'lft' => 3,
			'rght' => 6,
			'parent_id' => null,
			'created' => '2012-10-05 02:00:12',
			'modified' => '2012-10-05 02:00:12'
		),
		array(
			'id' => 'inactive-parent',
			'name' => 'inactive-parent',
			'slug' => 'inactive-parent',
			'description' => 'Active category within an inactive category',
			'keywords' => 'inactive-parent',
			'shop_image_id' => 'shop-image-1',
			'shop_product_type_id' => null,
			'product_count' => 1,
			'active' => 1,
			'lft' => 4,
			'rght' => 5,
			'parent_id' => 'inactive-parent',
			'created' => '2012-10-05 02:00:12',
			'modified' => '2012-10-05 02:00:12'
		),
		array(
			'id' => 'another',
			'name' => 'another',
			'slug' => 'another',
			'description' => 'another Normal active category',
			'keywords' => 'another',
			'shop_image_id' => 'shop-image-1',
			'shop_product_type_id' => null,
			'product_count' => 1,
			'active' => 1,
			'lft' => 7,
			'rght' => 8,
			'parent_id' => null,
			'created' => '2012-10-05 02:00:12',
			'modified' => '2012-10-05 02:00:12'
		),
	);

}
