<?php
/**
 * ShopBranchStockFixture
 *
 */
class ShopBranchStockFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'shop_branch_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'shop_product_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'stock' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_branch_stocks_shop_products1' => array('column' => 'shop_product_id', 'unique' => 0),
			'fk_shop_branch_stocks_shop_branches1' => array('column' => 'shop_branch_id', 'unique' => 0)
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
			'id' => 1,
			'shop_branch_id' => 1,
			'shop_product_id' => 1,
			'stock' => 1
		),
	);

}
