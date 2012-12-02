<?php
App::uses('ShopBranchStockLog', 'Shop.Model');

/**
 * ShopBranchStockLog Test Case
 *
 */
class ShopBranchStockLogTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_branch_stock_log',
		'plugin.shop.shop_branch_stock'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopBranchStockLog = ClassRegistry::init('Shop.ShopBranchStockLog');
		$this->modelClass = $this->ShopBranchStockLog->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopBranchStockLog);

		parent::tearDown();
	}

/**
 * test validation rules
 *
 * @dataProvider validationDataProvider
 */
	public function testValidation($data, $expected) {
		$result = $this->{$this->modelClass}->save($data);
		$this->assertEquals($expected['saveResult'], (bool)$result);

		$result = $this->{$this->modelClass}->validationErrors;
		$this->assertEquals($expected['validationErrors'], $result);
	}

/**
 * validation rules data provider
 *
 * @return array
 */
	public function validationDataProvider() {
		return array(
			'all' => array(
				array(),
				array(
					'saveResult' => false,
					'validationErrors' => array(
						'shop_branch_stock_id' => array('Specified branch / product combination does not exist'),
						'change' => array('The specified amount is invalid, should be non-zero number'),
						'notes' => array('No notes specified for stock change')
					)
				)
			),
			'zero' => array(
				array('change' => 0),
				array(
					'saveResult' => false,
					'validationErrors' => array(
						'shop_branch_stock_id' => array('Specified branch / product combination does not exist'),
						'change' => array('The specified amount is invalid, should be non-zero number'),
						'notes' => array('No notes specified for stock change')
					)
				)
			),
			'positive' => array(
				array('change' => 10),
				array(
					'saveResult' => false,
					'validationErrors' => array(
						'shop_branch_stock_id' => array('Specified branch / product combination does not exist'),
						'notes' => array('No notes specified for stock change')
					)
				)
			),
			'negative' => array(
				array('change' => -10),
				array(
					'saveResult' => false,
					'validationErrors' => array(
						'shop_branch_stock_id' => array('Specified branch / product combination does not exist'),
						'notes' => array('No notes specified for stock change')
					)
				)
			),
			'invalid-branch' => array(
				array('shop_branch_stock_id' => 'invalid', 'change' => 5),
				array(
					'saveResult' => false,
					'validationErrors' => array(
						'shop_branch_stock_id' => array('Specified branch / product combination does not exist'),
						'notes' => array('No notes specified for stock change')
					)
				)
			),
			'almost' => array(
				array('shop_branch_stock_id' => 'branch-stock-1', 'change' => 5),
				array(
					'saveResult' => false,
					'validationErrors' => array(
						'notes' => array('No notes specified for stock change')
					)
				)
			),
			'valid' => array(
				array('shop_branch_stock_id' => 'branch-stock-1', 'change' => 5, 'notes' => 'upping the stock levels'),
				array(
					'saveResult' => true,
					'validationErrors' => array()
				)
			)
		);
	}

}
