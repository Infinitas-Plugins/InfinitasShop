<?php
/**
 * ShopCurrencyFixture
 *
 * @package Shop.Test.Fixture
 * @since 0.9b1
 */

class ShopCurrencyFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'factor' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,8'),
		'whole_symbol' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'whole_position' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'fraction_symbol' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'fraction_position' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'zero' => array('type' => 'string', 'null' => true, 'default' => '0', 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'places' => array('type' => 'integer', 'null' => true, 'default' => '2', 'length' => 6),
		'thousands' => array('type' => 'string', 'null' => true, 'default' => ',', 'length' => 5, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'decimals' => array('type' => 'string', 'null' => true, 'default' => '.', 'length' => 5, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'negative' => array('type' => 'string', 'null' => true, 'default' => '()', 'length' => 5, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'escape' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
			'id' => 'gbp',
			'name' => 'gbp',
			'code' => 'gbp',
			'factor' => 1,
			'whole_symbol' => '£',
			'whole_position' => 0,
			'fraction_symbol' => 'p',
			'fraction_position' => 1,
			'zero' => '0',
			'places' => 2,
			'thousands' => ',',
			'decimals' => '.',
			'negative' => '-',
			'escape' => 1,
			'created' => '2012-10-09 01:23:51',
			'modified' => '2012-10-09 01:23:51'
		),
		array(
			'id' => 'usd',
			'name' => 'usd',
			'code' => 'usd',
			'factor' => 1.5999,
			'whole_symbol' => '$',
			'whole_position' => 0,
			'fraction_symbol' => 'c',
			'fraction_position' => 1,
			'zero' => '-',
			'places' => 2,
			'thousands' => ',',
			'decimals' => '.',
			'negative' => '-',
			'escape' => 1,
			'created' => '2012-10-09 01:23:51',
			'modified' => '2012-10-09 01:23:51'
		),
		array(
			'id' => 'eur',
			'name' => 'eur',
			'code' => 'eur',
			'factor' => 1.2425,
			'whole_symbol' => '€',
			'whole_position' => 0,
			'fraction_symbol' => 'c',
			'fraction_position' => 1,
			'zero' => 'zero',
			'places' => 3,
			'thousands' => '.',
			'decimals' => ',',
			'negative' => '-',
			'escape' => 1,
			'created' => '2012-10-09 01:23:51',
			'modified' => '2012-10-09 01:23:51'
		)
	);

}
