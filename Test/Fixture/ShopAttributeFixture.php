<?php
/**
 * @brief fixture file for ShopAttribute tests.
 *
 * @package .Fixture
 * @since 0.9b1
 */
class ShopAttributeFixture extends CakeTestFixture {
	public $name = 'ShopAttribute';

	public $fields = array( 
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'image' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shop_attribute_group_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shop_product_attribute_count' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 5),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_attributes_shop_attribute_groups2_idx' => array('column' => 'shop_attribute_group_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
		array(
			'id' => 'attr-condition-new',
			'name' => 'attr-condition-new',
			'slug' => 'attr-condition-new',
			'image' => 'attr-condition-new.png',
			'shop_attribute_group_id' => 'attr-group-condition',
			'shop_product_attribute_count' => 1,
			'created' => '2013-01-31 21:18:03',
			'modified' => '2013-01-31 21:18:03'
		),
		array(
			'id' => 'attr-condition-used',
			'name' => 'attr-condition-used',
			'slug' => 'attr-condition-used',
			'image' => 'attr-condition-used.png',
			'shop_attribute_group_id' => 'attr-group-condition',
			'shop_product_attribute_count' => 1,
			'created' => '2013-01-31 21:18:03',
			'modified' => '2013-01-31 21:18:03'
		),
	);
}