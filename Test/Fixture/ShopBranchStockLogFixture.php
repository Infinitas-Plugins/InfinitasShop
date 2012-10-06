<?php
/**
 * ShopBranchStockLogFixture
 *
 */
class ShopBranchStockLogFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_branch_stock_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'change' => array('type' => 'integer', 'null' => true, 'default' => null),
		'notes' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_branch_stock_logs_shop_branch_stocks1' => array('column' => 'shop_branch_stock_id', 'unique' => 0)
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
			'id' => 'stock-log-branch-stock-1a',
			'shop_branch_stock_id' => 'branch-stock-1',
			'change' => 5,
			'notes' => 'Adding some test stock',
			'created' => '2012-10-05 12:00:44'
		),
		array(
			'id' => 'stock-log-branch-stock-1b',
			'shop_branch_stock_id' => 'branch-stock-1',
			'change' => 5,
			'notes' => 'Adding more stock',
			'created' => '2012-10-05 12:01:44'
		),
		array(
			'id' => 'stock-log-branch-stock-2a',
			'shop_branch_stock_id' => 'branch-stock-2',
			'change' => 15,
			'notes' => 'Initial stock',
			'created' => '2012-10-05 12:01:44'
		),
		array(
			'id' => 'stock-log-branch-stock-3a',
			'shop_branch_stock_id' => 'branch-stock-3',
			'change' => 9,
			'notes' => 'Initial stock',
			'created' => '2012-10-05 12:01:44'
		),
		array(
			'id' => 'stock-log-branch-stock-3b',
			'shop_branch_stock_id' => 'branch-stock-3',
			'change' => -3,
			'notes' => 'Sale',
			'created' => '2012-10-05 12:01:44'
		),
		array(
			'id' => 'stock-log-branch-stock-3c',
			'shop_branch_stock_id' => 'branch-stock-3',
			'change' => -3,
			'notes' => 'Sale',
			'created' => '2012-10-05 12:01:44'
		),
		array(
			'id' => 'stock-log-branch-stock-3d',
			'shop_branch_stock_id' => 'branch-stock-3',
			'change' => -3,
			'notes' => 'Sale',
			'created' => '2012-10-05 12:01:44'
		),
	);

}
