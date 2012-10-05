<?php
/**
 * ShopProductFixture
 *
 */
class ShopProductFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'specifications' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'shop_image_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'rating' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'rating_count' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'views' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'sales' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'shop_supplier_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_products_shop_suppliers1' => array('column' => 'shop_supplier_id', 'unique' => 0),
			'fk_shop_products_shop_images1' => array('column' => 'shop_image_id', 'unique' => 0)
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
			'description' => 'active desc',
			'specifications' => 'active specs',
			'active' => 1,
			'shop_image_id' => 'shop-image-1',
			'rating' => 1,
			'rating_count' => 1,
			'views' => 1,
			'sales' => 1,
			'shop_supplier_id' => 'supplier-1',
			'created' => '2012-10-05 01:14:47',
			'modified' => '2012-10-05 01:14:47'
		),
		array(
			'id' => 'inactive',
			'name' => 'inactive',
			'slug' => 'inactive-slug',
			'description' => 'inactive desc',
			'specifications' => 'inactive specs',
			'active' => 0,
			'shop_image_id' => 'shop-image-1',
			'rating' => 1,
			'rating_count' => 1,
			'views' => 1,
			'sales' => 1,
			'shop_supplier_id' => 'supplier-1',
			'created' => '2012-10-05 01:14:47',
			'modified' => '2012-10-05 01:14:47'
		),
		array(
			'id' => 'inactive-category',
			'name' => 'inactive-category',
			'slug' => 'inactive-category',
			'description' => 'inactive-category desc',
			'specifications' => 'inactive-category specs',
			'active' => 1,
			'shop_image_id' => 'shop-image-1',
			'rating' => 1,
			'rating_count' => 1,
			'views' => 1,
			'sales' => 1,
			'shop_supplier_id' => 'supplier-1',
			'created' => '2012-10-05 01:14:47',
			'modified' => '2012-10-05 01:14:47'
		),
		array(
			'id' => 'inactive-parent-category',
			'name' => 'inactive-parent-category',
			'slug' => 'inactive-parent-category',
			'description' => 'inactive-parent-category desc',
			'specifications' => 'inactive-parent-category specs',
			'active' => 1,
			'shop_image_id' => 'shop-image-1',
			'rating' => 1,
			'rating_count' => 1,
			'views' => 1,
			'sales' => 1,
			'shop_supplier_id' => 'supplier-1',
			'created' => '2012-10-05 01:14:47',
			'modified' => '2012-10-05 01:14:47'
		),
		array(
			'id' => 'multi-category',
			'name' => 'multi-category',
			'slug' => 'multi-category',
			'description' => 'multi-category desc',
			'specifications' => 'multi-category specs',
			'active' => 1,
			'shop_image_id' => 'shop-image-1',
			'rating' => 1,
			'rating_count' => 1,
			'views' => 1,
			'sales' => 1,
			'shop_supplier_id' => 'supplier-1',
			'created' => '2012-10-05 01:14:47',
			'modified' => '2012-10-05 01:14:47'
		),
		array(
			'id' => 'multi-category-mixed-state',
			'name' => 'multi-category-mixed-state',
			'slug' => 'multi-category-mixed-state',
			'description' => 'multi-category-mixed-state desc',
			'specifications' => 'multi-category-mixed-state specs',
			'active' => 1,
			'shop_image_id' => 'shop-image-1',
			'rating' => 1,
			'rating_count' => 1,
			'views' => 1,
			'sales' => 1,
			'shop_supplier_id' => 'supplier-1',
			'created' => '2012-10-05 01:14:47',
			'modified' => '2012-10-05 01:14:47'
		),
		array(
			'id' => 'multi-category-parent-inactive',
			'name' => 'multi-category-parent-inactive',
			'slug' => 'multi-category-parent-inactive',
			'description' => 'multi-category-parent-inactive desc',
			'specifications' => 'multi-category-parent-inactive specs',
			'active' => 1,
			'shop_image_id' => 'shop-image-1',
			'rating' => 1,
			'rating_count' => 1,
			'views' => 1,
			'sales' => 1,
			'shop_supplier_id' => 'supplier-1',
			'created' => '2012-10-05 01:14:47',
			'modified' => '2012-10-05 01:14:47'
		)
	);

}
