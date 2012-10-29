<?php
/**
 * CoreUserFixture
 *
 */
class CoreUserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'username' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'facebook_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'twitter_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'key' => 'index'),
		'birthday' => array('type' => 'date', 'null' => true, 'default' => null),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'group_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36),
		'ip_address' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'browser' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'operating_system' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'last_login' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'last_click' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'country' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'city' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'is_mobile' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'time_zone' => array('type' => 'string', 'null' => false, 'default' => 'UTC', 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'full_name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'prefered_name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'username' => array('column' => 'username', 'unique' => 1),
			'email' => array('column' => 'email', 'unique' => 1),
			'twitter_id' => array('column' => 'twitter_id', 'unique' => 0)
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
			'id' => 'admin',
			'username' => 'admin',
			'email' => 'admin@admin.com',
			'password' => 'admin',
			'facebook_id' => 1,
			'twitter_id' => 1,
			'birthday' => '2012-10-08',
			'active' => 1,
			'group_id' => 'admin',
			'ip_address' => '127.0.0.1',
			'browser' => 'Chrome',
			'operating_system' => 'Linux',
			'last_login' => '2012-10-08 19:39:28',
			'last_click' => '2012-10-08 19:39:28',
			'country' => 'Foo Bar',
			'city' => 'Baz',
			'is_mobile' => 0,
			'created' => '2012-10-08 19:39:28',
			'modified' => '2012-10-08 19:39:28',
			'time_zone' => 'foo/bar',
			'full_name' => 'admin admin',
			'prefered_name' => 'a. admin'
		),
		array(
			'id' => 'bob',
			'username' => 'bob',
			'email' => 'bob@bob.com',
			'password' => 'bob',
			'facebook_id' => 1,
			'twitter_id' => 1,
			'birthday' => '2012-10-08',
			'active' => 1,
			'group_id' => 'user',
			'ip_address' => '127.0.0.1',
			'browser' => 'Chrome',
			'operating_system' => 'Linux',
			'last_login' => '2012-10-08 19:39:28',
			'last_click' => '2012-10-08 19:39:28',
			'country' => 'Foo Bar',
			'city' => 'Baz',
			'is_mobile' => 0,
			'created' => '2012-10-08 19:39:28',
			'modified' => '2012-10-08 19:39:28',
			'time_zone' => 'foo/bar',
			'full_name' => 'bob bob',
			'prefered_name' => 'b. bob'
		),
		array(
			'id' => 'sally',
			'username' => 'sally',
			'email' => 'sally@sally.com',
			'password' => 'sally',
			'facebook_id' => 1,
			'twitter_id' => 1,
			'birthday' => '2012-10-08',
			'active' => 1,
			'group_id' => 'user',
			'ip_address' => '127.0.0.1',
			'browser' => 'Chrome',
			'operating_system' => 'Linux',
			'last_login' => '2012-10-08 19:39:28',
			'last_click' => '2012-10-08 19:39:28',
			'country' => 'Foo Bar',
			'city' => 'Baz',
			'is_mobile' => 0,
			'created' => '2012-10-08 19:39:28',
			'modified' => '2012-10-08 19:39:28',
			'time_zone' => 'foo/bar',
			'full_name' => 'sally sally',
			'prefered_name' => 's. sally'
		),
		array(
			'id' => 'reseller',
			'username' => 'reseller',
			'email' => 'reseller@reseller.com',
			'password' => 'reseller',
			'facebook_id' => 1,
			'twitter_id' => 1,
			'birthday' => '2012-10-08',
			'active' => 1,
			'group_id' => 'reseller',
			'ip_address' => '127.0.0.1',
			'browser' => 'Chrome',
			'operating_system' => 'Linux',
			'last_login' => '2012-10-08 19:39:28',
			'last_click' => '2012-10-08 19:39:28',
			'country' => 'Foo Bar',
			'city' => 'Baz',
			'is_mobile' => 0,
			'created' => '2012-10-08 19:39:28',
			'modified' => '2012-10-08 19:39:28',
			'time_zone' => 'foo/bar',
			'full_name' => 'reseller reseller',
			'prefered_name' => 'r. reseller'
		),
	);

}
