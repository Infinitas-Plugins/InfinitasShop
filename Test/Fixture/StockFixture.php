<?php
/**
 * @brief fixture file for Stock tests.
 *
 * @package Shop.Fixture
 * @since 0.9b1
 */
class StockFixture extends CakeTestFixture {
	public $name = 'Stock';

	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'branch_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36),
		'product_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36),
		'stock' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
	);
}