<?php
/* ShopShopBranch Fixture generated on: 2010-08-17 14:08:03 : 1282055223 */
class ShopShopBranchFixture extends CakeTestFixture {
	public $name = 'ShopShopBranch';

	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'branch_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'manager_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'ordering' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
		array(
			'id' => 1,
			'branch_id' => 3,
			'manager_id' => 1,
			'ordering' => 1,
			'active' => 1,
			'deleted' => 0,
			'deleted_date' => '0000-00-00 00:00:00',
			'created' => '2010-04-20 00:29:23',
			'modified' => '2010-04-20 01:15:40'
		),
	);
}
?>