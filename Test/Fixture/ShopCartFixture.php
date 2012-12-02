<?php
/**
 * ShopCartFixture
 *
 * @package Shop.Test.Fixture
 * @since 0.9b1
 */

class ShopCartFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 200),
		'user_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36),
		'product_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36),
		'price' => array('type' => 'float', 'null' => false, 'default' => '0'),
		'quantity' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'deleted' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'deleted_date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
	);
}