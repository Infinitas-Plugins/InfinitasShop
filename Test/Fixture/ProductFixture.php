<?php
/**
 * @brief fixture file for Product tests.
 *
 * @package Shop.Fixture
 * @since 0.9b1
 */
class ProductFixture extends CakeTestFixture {
	public $name = 'Product';

	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'specifications' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'unit_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36),
		'cost' => array('type' => 'float', 'null' => false, 'default' => '0'),
		'retail' => array('type' => 'float', 'null' => false, 'default' => '0'),
		'price' => array('type' => 'float', 'null' => false, 'default' => null),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'image_id' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'rating' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'rating_count' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'views' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'added_to_cart' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'added_to_wishlist' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'sales' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'supplier_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
	);
}