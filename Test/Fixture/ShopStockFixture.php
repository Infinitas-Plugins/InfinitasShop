<?php
/**
 * ShopStockFixture
 *
 * @package Shop.Test.Fixture
 * @since 0.9b1
 */

class ShopStockFixture extends CakeTestFixture {

	public $name = 'ShopStock';

	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'branch_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36),
		'product_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36),
		'stock' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
		array(
			'id' => 1,
			'branch_id' => 1,
			'product_id' => 1,
			'stock' => 120
		),
		array(
			'id' => 2,
			'branch_id' => 1,
			'product_id' => 2,
			'stock' => 15
		),
	);
}