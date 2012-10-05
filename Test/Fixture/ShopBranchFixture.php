<?php
/**
 * ShopBranchFixture
 *
 */
class ShopBranchFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'contact_branch_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36),
		'manager_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36),
		'ordering' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
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
			'id' => 'branch-1',
			'contact_branch_id' => 'branch-1',
			'manager_id' => 'managet-1',
			'ordering' => 1,
			'active' => 1,
			'created' => '2012-10-05 13:23:16',
			'modified' => '2012-10-05 13:23:16'
		),
		array(
			'id' => 'branch-2',
			'contact_branch_id' => 'branch-2',
			'manager_id' => 'managet-2',
			'ordering' => 1,
			'active' => 1,
			'created' => '2012-10-05 13:23:16',
			'modified' => '2012-10-05 13:23:16'
		),
	);

}
