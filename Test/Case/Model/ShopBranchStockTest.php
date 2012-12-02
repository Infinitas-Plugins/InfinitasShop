<?php
App::uses('ShopBranchStock', 'Shop.Model');

/**
 * ShopBranchStock Test Case
 *
 */

class ShopBranchStockTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_branch_stock',
		'plugin.shop.shop_branch',
		'plugin.shop.shop_product',
		'plugin.shop.shop_price',
		'plugin.shop.shop_branch_stock_log',
		'plugin.view_counter.view_counter_view',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopBranchStock = ClassRegistry::init('Shop.ShopBranchStock');
		$this->modelClass = $this->ShopBranchStock->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopBranchStock);

		parent::tearDown();
	}

/**
 * test validation rules
 *
 * @dataProvider validationDataProvider
 */
	public function testValidation($data, $expected) {
		$result = $this->{$this->modelClass}->save($data);
		$this->assertEquals($expected['saveResult'], $result);

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
			array(
				array(

				),
				array(
					'saveResult' => false,
					'validationErrors' => array()
				)
			)
		);
	}

/**
 * test find productStock exceptions
 *
 * @expectedException InvalidArgumentException
 *
 * @dataProvider customFindExceptionsDataProvider
 */
	public function testCustomFindExceptions($data) {
		$this->{$this->modelClass}->find($data);
	}

/**
 * data provider for testing exceptions in the custom finds
 *
 * @return array
 */
	public function customFindExceptionsDataProvider() {
		return array(
			array('productStock'),
			array('isInStock'),
		);
	}

/**
 * test find product stock
 *
 * @param type $data
 * @param type $expected
 *
 * @dataProvider findProductStockDataProvider
 */
	public function testFindProductStock($data, $expected) {
		$result = $this->{$this->modelClass}->find('productStock', array('shop_product_id' => $data));
		$this->assertEquals($expected, $result);
	}

/**
 * find product stock data provider
 *
 * @return array
 */
	public function findProductStockDataProvider() {
		return array(
			'different-branches' => array(
				'active',
				array(array(
					'ShopBranchStock' => array(
						'id' => 'branch-stock-1',
						'shop_branch_id' => 'branch-1',
						'stock' => '10'
						)), array(
					'ShopBranchStock' => array(
						'id' => 'branch-stock-2',
						'shop_branch_id' => 'branch-2',
						'stock' => '15'
					))
				)
			),
			'no-stock-added' => array(
				'no-stock-added',
				array()
			),
			'out-of-stock' => array(
				'out-of-stock',
				array(array(
					'ShopBranchStock' => array(
						'id' => 'branch-stock-3',
						'shop_branch_id' => 'branch-1',
						'stock' => '0'
					)))
			)
		);
	}

/**
 * test find product stock extracted
 *
 * @param type $data
 * @param type $expected
 *
 * @dataProvider findProductStockExtractedDataProvider
 */
	public function testFindProductStockExtracted($data, $expected) {
		$result = $this->{$this->modelClass}->find('productStock', array(
			'shop_product_id' => $data,
			'extract' => true
		));
		$this->assertEquals($expected, $result);
	}

/**
 * find product stock extracted data provider
 *
 * @return array
 */
	public function findProductStockExtractedDataProvider() {
		return array(
			'different-branches' => array(
				'active',
				array(
					array(
						'id' => 'branch-stock-1',
						'shop_branch_id' => 'branch-1',
						'stock' => '10'
					), array(
						'id' => 'branch-stock-2',
						'shop_branch_id' => 'branch-2',
						'stock' => '15'
					)
				)
			),
			'no-stock-added' => array(
				'no-stock-added',
				array()
			),
			'out-of-stock' => array(
				'out-of-stock',
				array(
					array(
						'id' => 'branch-stock-3',
						'shop_branch_id' => 'branch-1',
						'stock' => '0'
					)
				)
			)
		);
	}

/**
 * test isInStock custom find
 *
 * @dataProvider findIsInStockDataProvider
 */
	public function testFindIsInStock($data, $expected) {
		$result = $this->{$this->modelClass}->find('isInStock', array('shop_product_id' => $data));
		$this->assertEquals($expected, $result);
	}

/**
 * find isInStock data provider
 *
 * @return array
 */
	public function findIsInStockDataProvider() {
		return array(
			'madeup-product' => array(
				'madeup-product',
				array()
			),
			'no-stock-added' => array(
				'no-stock-added',
				array()
			),
			'has-stock' => array(
				'active',
				array(
					'active' => true
				)
			),
			'out-of-stock' => array(
				'out-of-stock',
				array()
			),
			'mixed' => array(
				array(
					'active',
					'no-stock-added',
					'out-of-stock'
				),
				array(
					'active' => true
				)
			)
		);
	}

/**
 * test updating the stock count
 */
	public function testUpdateStock() {
		$data = array(
			'shop_branch_id' => 'branch-1',
			'shop_product_id' => 'active',
			'change' => 10
		);
		$this->assertEquals(10, $this->{$this->modelClass}->find('totalProductStock', $data));
		$this->assertTrue($this->{$this->modelClass}->updateStock(array($data)));
		$this->assertEquals(20, $this->{$this->modelClass}->find('totalProductStock', $data));

		$data['change'] = -5;
		$this->assertTrue($this->{$this->modelClass}->updateStock(array($data)));
		$this->assertEquals(15, $this->{$this->modelClass}->find('totalProductStock', $data));
	}

/**
 * test exceptions when not passing the correct data
 *
 * @expectedException InvalidArgumentException
 *
 * @dataProvider addRemoveStockExceptionDataProvider
 */
	public function testAddRemoveStockException($data) {
		$this->{$this->modelClass}->{$data['method']}($data['data']);
	}

/**
 * add / remove stock exception data provider
 *
 * @return array
 */
	public function addRemoveStockExceptionDataProvider() {
		return array(
			'add-no-product' => array(
				array(
					'method' => 'addStock',
					'data' => array(
						'shop_branch_id' => 'branch-1',
						'change' => 10,
					)
				)
			),
			'add-no-branch' => array(
				array(
					'method' => 'addStock',
					'data' => array(
						'shop_product_id' => 'active',
						'change' => 10,
					)
				)
			),
			'remove-no-product' => array(
				array(
					'method' => 'addStock',
					'data' => array(
						'shop_branch_id' => 'branch-1',
						'change' => 10,
					)
				)
			),
			'remove-no-branch' => array(
				array(
					'method' => 'addStock',
					'data' => array(
						'shop_product_id' => 'active',
						'change' => 10,
					)
				)
			)
		);
	}

/**
 * test adding new stock recalculates and logs
 *
 * @dataProvider addStockDataProvider
 */
	public function testAddStock($data, $expected) {
		$shopBranchStockId = $data['shop_branch_stock_id'];
		unset($data['shop_branch_stock_id']);

		$conditions = array(
			'fields' => array($this->modelClass . '.stock'),
			'conditions' => array($this->modelClass . '.shop_product_id' => 'active'));

		$this->assertTrue($this->{$this->modelClass}->addStock($data));
		$result = $this->{$this->modelClass}->find('all', $conditions);
		$this->assertEquals($expected['stock'], $result);

		$conditions = array(
			'fields' => array(
				'ShopBranchStockLog.change',
				'ShopBranchStockLog.notes'
			),
			'conditions' => array(
				'ShopBranchStockLog.shop_branch_stock_id' => $shopBranchStockId
			)
		);
		$stock = $this->{$this->modelClass}->ShopBranchStockLog->find('all', $conditions);
		$this->assertEquals($expected['stock_log'], Hash::extract($stock, '{n}.ShopBranchStockLog'));
	}

/**
 * add stock data provider
 *
 * @return array
 */
	public function addStockDataProvider() {
		return array(
			'branch-1' => array(
				array(
					'shop_product_id' => 'active',
					'shop_branch_id' => 'branch-1',
					'change' => 10,
					'shop_branch_stock_id' => 'branch-stock-1'
				),
				array(
					'stock' => array(
						array('ShopBranchStock' => array('stock' => '20')),
						array('ShopBranchStock' => array('stock' => '15'))
					),
					'stock_log' => array(
						array(
							'change' => 10,
							'notes' => 'Adding stock'
						),
						array(
							'change' => 5,
							'notes' => 'Adding more stock'
						),
						array(
							'change' => 5,
							'notes' => 'Adding some test stock'
						),
					)
				)
			),
			'branch-2' => array(
				array(
					'shop_product_id' => 'active',
					'shop_branch_id' => 'branch-2',
					'change' => 5,
					'shop_branch_stock_id' => 'branch-stock-2'
				),
				array(
					'stock' => array(
						array('ShopBranchStock' => array('stock' => '10')),
						array('ShopBranchStock' => array('stock' => '20'))
					),
					'stock_log' => array(
						array(
							'change' => 5,
							'notes' => 'Adding stock'
						),
						array(
							'change' => 15,
							'notes' => 'Initial stock'
						),
					)
				)
			),
			'negative-add' => array(
				array(
					'shop_product_id' => 'active',
					'shop_branch_id' => 'branch-2',
					'change' => -5,
					'shop_branch_stock_id' => 'branch-stock-2'
				),
				array(
					'stock' => array(
						array('ShopBranchStock' => array('stock' => '10')),
						array('ShopBranchStock' => array('stock' => '20'))
					),
					'stock_log' => array(
						array(
							'change' => 5,
							'notes' => 'Adding stock'
						),
						array(
							'change' => 15,
							'notes' => 'Initial stock'
						)
					)
				)
			),
			'custom-message' => array(
				array(
					'shop_product_id' => 'active',
					'shop_branch_id' => 'branch-2',
					'change' => 5,
					'notes' => 'Yee Haa',
					'shop_branch_stock_id' => 'branch-stock-2'
				),
				array(
					'stock' => array(
						array('ShopBranchStock' => array('stock' => '10')),
						array('ShopBranchStock' => array('stock' => '20'))
					),
					'stock_log' => array(
						array(
							'change' => 5,
							'notes' => 'Yee Haa'
						),
						array(
							'change' => 15,
							'notes' => 'Initial stock'
						)
					)
				)
			)
		);
	}

/**
 * test removing stock recalculates and logs
 *
 * @dataProvider removeStockDataProvider
 */
	public function testRemoveStock($data, $expected) {
		$shopBranchStockId = $data['shop_branch_stock_id'];
		unset($data['shop_branch_stock_id']);

		$conditions = array(
			'fields' => array($this->modelClass . '.stock'),
			'conditions' => array($this->modelClass . '.shop_product_id' => 'active'));

		$this->assertTrue($this->{$this->modelClass}->removeStock($data));
		$result = $this->{$this->modelClass}->find('all', $conditions);
		$this->assertEquals($expected['stock'], $result);

		$conditions = array(
			'fields' => array(
				'ShopBranchStockLog.change',
				'ShopBranchStockLog.notes'
			),
			'conditions' => array(
				'ShopBranchStockLog.shop_branch_stock_id' => $shopBranchStockId
			)
		);
		$stock = $this->{$this->modelClass}->ShopBranchStockLog->find('all', $conditions);
		$this->assertEquals($expected['stock_log'], Hash::extract($stock, '{n}.ShopBranchStockLog'));
	}

/**
 * remove stock data provider
 *
 * @return array
 */
	public function removeStockDataProvider() {
		return array(
			'branch-1' => array(
				array(
					'shop_product_id' => 'active',
					'shop_branch_id' => 'branch-1',
					'change' => -10,
					'shop_branch_stock_id' => 'branch-stock-1'
				),
				array(
					'stock' => array(
						array('ShopBranchStock' => array('stock' => '0')),
						array('ShopBranchStock' => array('stock' => '15'))
					),
					'stock_log' => array(
						array(
							'change' => -10,
							'notes' => 'Removing stock'
						),
						array(
							'change' => 5,
							'notes' => 'Adding more stock'
						),
						array(
							'change' => 5,
							'notes' => 'Adding some test stock'
						),
					)
				)
			),
			'branch-2' => array(
				array(
					'shop_product_id' => 'active',
					'shop_branch_id' => 'branch-2',
					'change' => -5,
					'shop_branch_stock_id' => 'branch-stock-2'
				),
				array(
					'stock' => array(
						array('ShopBranchStock' => array('stock' => '10')),
						array('ShopBranchStock' => array('stock' => '10'))
					),
					'stock_log' => array(
						array(
							'change' => -5,
							'notes' => 'Removing stock'
						),
						array(
							'change' => 15,
							'notes' => 'Initial stock'
						),
					)
				)
			),
			'positive-remove' => array(
				array(
					'shop_product_id' => 'active',
					'shop_branch_id' => 'branch-2',
					'change' => 5,
					'shop_branch_stock_id' => 'branch-stock-2'
				),
				array(
					'stock' => array(
						array('ShopBranchStock' => array('stock' => '10')),
						array('ShopBranchStock' => array('stock' => '10'))
					),
					'stock_log' => array(
						array(
							'change' => -5,
							'notes' => 'Removing stock'
						),
						array(
							'change' => 15,
							'notes' => 'Initial stock'
						)
					)
				)
			),
			'custom-message' => array(
				array(
					'shop_product_id' => 'active',
					'shop_branch_id' => 'branch-2',
					'change' => -5,
					'notes' => 'Yee Haa',
					'shop_branch_stock_id' => 'branch-stock-2'
				),
				array(
					'stock' => array(
						array('ShopBranchStock' => array('stock' => '10')),
						array('ShopBranchStock' => array('stock' => '10'))
					),
					'stock_log' => array(
						array(
							'change' => -5,
							'notes' => 'Yee Haa'
						),
						array(
							'change' => 15,
							'notes' => 'Initial stock'
						)
					)
				)
			)
		);
	}

/**
 * test adding / removing with invalid amounts
 */
	public function testInvalidStockChange() {
		$result = $this->{$this->modelClass}->addStock(array(
			'shop_product_id' => 'active',
			'shop_branch_id' => 'branch-2',
			'change' => 'asd'
		));
		$this->assertFalse($result);

		$conditions = array(
			'fields' => array($this->modelClass . '.stock'),
			'conditions' => array($this->modelClass . '.shop_product_id' => 'active'));
		$expected = array(
			array('ShopBranchStock' => array('stock' => '10')),
			array('ShopBranchStock' => array('stock' => '15'))
		);
		$result = $this->{$this->modelClass}->find('all', $conditions);
		$this->assertEquals($expected, $result);

		$conditions = array(
			'fields' => array(
				'ShopBranchStockLog.change',
				'ShopBranchStockLog.notes'
			),
			'conditions' => array(
				'ShopBranchStockLog.shop_branch_stock_id' => 'branch-stock-2'
			)
		);
		$expected = array(array(
			'change' => 15,
			'notes' => 'Initial stock'
		));
		$results = Hash::extract($this->{$this->modelClass}->ShopBranchStockLog->find('all', $conditions), '{n}.ShopBranchStockLog');
		$this->assertEquals($expected, $results);

		$result = $this->{$this->modelClass}->removeStock(array(
			'shop_product_id' => 'active',
			'shop_branch_id' => 'branch-2',
			'change' => 'asd'
		));
		$this->assertFalse($result);

		$conditions = array(
			'fields' => array($this->modelClass . '.stock'),
			'conditions' => array($this->modelClass . '.shop_product_id' => 'active'));
		$expected = array(
			array('ShopBranchStock' => array('stock' => '10')),
			array('ShopBranchStock' => array('stock' => '15'))
		);
		$result = $this->{$this->modelClass}->find('all', $conditions);
		$this->assertEquals($expected, $result);

		$conditions = array(
			'fields' => array(
				'ShopBranchStockLog.change',
				'ShopBranchStockLog.notes'
			),
			'conditions' => array(
				'ShopBranchStockLog.shop_branch_stock_id' => 'branch-stock-2'
			)
		);
		$expected = array(array(
			'change' => 15,
			'notes' => 'Initial stock'
		));
		$results = Hash::extract($this->{$this->modelClass}->ShopBranchStockLog->find('all', $conditions), '{n}.ShopBranchStockLog');
		$this->assertEquals($expected, $results);
	}

/**
 * test find total product stock
 *
 * @param type $data
 * @param type $expected
 *
 * @dataProvider findTotalProductStockDataProvider
 */
	public function testFindTotalProductStock($data, $expected) {
		$result = $this->{$this->modelClass}->find('totalProductStock', $data);
		$this->assertEquals($expected, $result);
	}

/**
 * find total product stock data provider
 *
 * @return array
 */
	public function findTotalProductStockDataProvider() {
		return array(
			'product' => array(array('shop_product_id' => 'active'), 25),
			'branch' => array(array('shop_branch_id' => 'branch-1'), 10),
			'product-branch' => array(array('shop_product_id' => 'active', 'shop_branch_id' => 'branch-1'), 10),
			'product-branch' => array(array('shop_product_id' => 'active', 'shop_branch_id' => 'branch-2'), 15),
			'madeup-product' => array(array('shop_product_id' => 'madeup'), 0),
			'madeup-branch' => array(array('shop_branch_id' => 'madeup'), 0),
			'madeup-product-branch' => array(array('shop_product_id' => 'madeup', 'shop_branch_id' => 'madeup'), 0)
		);
	}

/**
 * test find stock list
 */
	public function testFindStockList() {
		$expected = array(
			array(
				'ShopProduct' => array(
					'id' => 'active',
					'name' => 'active',
					'selling' => '12.000'
				),
				'ShopBranchStock' => array(
					'branch-1' => 10,
					'branch-2' => 15
				)
			),
			array(
				'ShopProduct' => array(
					'id' => 'out-of-stock',
					'name' => 'out-of-stock',
					'selling' => null
				),
				'ShopBranchStock' => array(
					'branch-1' => 0
				)
			)
		);
		$result = $this->{$this->modelClass}->find('stockList');
		$this->assertEquals($expected, $result);
	}

	public function testAddStockNewCombo() {
		$data = array(
			'shop_product_id' => 'out-of-stock',
			'shop_branch_id' => 'branch-2',
			'change' => 10
		);
		$result = $this->{$this->modelClass}->addStock($data);
		$this->assertTrue((bool)$result);
	}
}