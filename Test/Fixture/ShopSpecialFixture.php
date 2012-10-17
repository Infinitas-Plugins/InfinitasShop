<?php
/**
 * ShopSpecialFixture
 *
 */
class ShopSpecialFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'discount' => array('type' => 'float', 'null' => true, 'default' => null),
		'amount' => array('type' => 'float', 'null' => true, 'default' => null),
		'free_shipping' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'start_date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'end_date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
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
			'id' => 'special-multi-option',
			'discount' => 1,
			'amount' => 10,
			'free_shipping' => 0,
			'start_date' => '2012-09-06 00:00:00',
			'end_date' => '2050-10-06 23:59:59',
			'active' => 1,
			'created' => '2012-10-06 12:09:58',
			'modified' => '2012-10-06 12:09:58'
		),
		array(
			'id' => 'special-active',
			'discount' => 1,
			'amount' => 15,
			'free_shipping' => 0,
			'start_date' => '2012-10-06 00:00:00',
			'end_date' => '2050-10-06 23:59:59',
			'active' => 0,
			'created' => '2012-10-06 12:09:58',
			'modified' => '2012-10-06 12:09:58'
		),
		array(
			'id' => 'special-active-pending',
			'discount' => 1,
			'amount' => 15,
			'free_shipping' => 0,
			'start_date' => '2050-10-06 00:00:00',
			'end_date' => '2051-10-06 23:59:59',
			'active' => 1,
			'created' => '2012-10-06 12:09:58',
			'modified' => '2012-10-06 12:09:58'
		),
		array(
			'id' => 'special-active-expired',
			'discount' => 0,
			'amount' => 15,
			'free_shipping' => 0,
			'start_date' => '2010-10-06 00:00:00',
			'end_date' => '2011-10-06 23:59:59',
			'active' => 1,
			'created' => '2012-10-06 12:09:58',
			'modified' => '2012-10-06 12:09:58'
		),
	);

}
