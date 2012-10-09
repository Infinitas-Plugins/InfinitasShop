<?php
/**
 * ShopCurrencyFixture
 *
 */
class ShopCurrencyFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'factor' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,8'),
		'whole_symbol' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'whole_position' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'fraction_symbol' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'fraction_position' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'zero' => array('type' => 'string', 'null' => true, 'default' => '0', 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'places' => array('type' => 'integer', 'null' => true, 'default' => '2', 'length' => 6),
		'thousands' => array('type' => 'string', 'null' => true, 'default' => ',', 'length' => 5, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'decimals' => array('type' => 'string', 'null' => true, 'default' => '.', 'length' => 5, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'negative' => array('type' => 'string', 'null' => true, 'default' => '()', 'length' => 5, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'escape' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '50736e97-034c-481d-95d0-6b3b6318cd70',
			'name' => 'Lorem ipsum dolor sit amet',
			'code' => 'L',
			'factor' => 1,
			'whole_symbol' => 'Lorem ipsum dolor sit amet',
			'whole_position' => 1,
			'fraction_symbol' => 'Lorem ipsum dolor sit amet',
			'fraction_position' => 1,
			'zero' => 'Lorem ip',
			'places' => 1,
			'thousands' => 'Lor',
			'decimals' => 'Lor',
			'negative' => 'Lor',
			'escape' => 1,
			'created' => '2012-10-09 01:23:51',
			'modified' => '2012-10-09 01:23:51'
		),
	);

}
