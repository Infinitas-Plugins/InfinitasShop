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
		$this->Model = ClassRegistry::init('Shop.ShopBranchStock');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Model);

		parent::tearDown();
	}

/**
 * test validation rules
 *
 * @dataProvider validationDataProvider
 */
	public function testValidation($data, $expected) {
		$result = $this->Model->save($data);
		$this->assertEquals($expected['saveResult'], $result);

		$result = $this->Model->validationErrors;
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
		$this->Model->find($data);
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
		$result = $this->Model->find('productStock', array('shop_product_id' => $data));
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
		$result = $this->Model->find('productStock', array(
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
		$result = $this->Model->find('isInStock', array('shop_product_id' => $data));
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
		$this->assertEquals(10, $this->Model->find('totalProductStock', $data));
		$this->assertTrue($this->Model->updateStock(array($data)));
		$this->assertEquals(20, $this->Model->find('totalProductStock', $data));

		$data['change'] = -5;
		$this->assertTrue($this->Model->updateStock(array($data)));
		$this->assertEquals(15, $this->Model->find('totalProductStock', $data));

		$data['change'] = -6;
		$this->assertTrue($this->Model->updateStock(array('ShopBranchStockLog' => $data)));
		$this->assertEquals(9, $this->Model->find('totalProductStock', $data));
	}

/**
 * test exceptions when not passing the correct data
 *
 * @expectedException InvalidArgumentException
 *
 * @dataProvider addRemoveStockExceptionDataProvider
 */
	public function testAddRemoveStockException($data) {
		$this->Model->{$data['method']}($data['data']);
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
			'fields' => array($this->Model->alias . '.stock'),
			'conditions' => array($this->Model->alias . '.shop_product_id' => 'active'));

		$this->assertTrue($this->Model->addStock($data));
		$result = $this->Model->find('all', $conditions);
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
		$stock = $this->Model->ShopBranchStockLog->find('all', $conditions);
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
			'fields' => array($this->Model->alias . '.stock'),
			'conditions' => array($this->Model->alias . '.shop_product_id' => 'active'));

		$this->assertTrue($this->Model->removeStock($data));
		$result = $this->Model->find('all', $conditions);
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
		$stock = $this->Model->ShopBranchStockLog->find('all', $conditions);
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
		$result = $this->Model->addStock(array(
			'shop_product_id' => 'active',
			'shop_branch_id' => 'branch-2',
			'change' => 'asd'
		));
		$this->assertFalse($result);

		$conditions = array(
			'fields' => array($this->Model->alias . '.stock'),
			'conditions' => array($this->Model->alias . '.shop_product_id' => 'active'));
		$expected = array(
			array('ShopBranchStock' => array('stock' => '10')),
			array('ShopBranchStock' => array('stock' => '15'))
		);
		$result = $this->Model->find('all', $conditions);
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
		$results = Hash::extract($this->Model->ShopBranchStockLog->find('all', $conditions), '{n}.ShopBranchStockLog');
		$this->assertEquals($expected, $results);

		$result = $this->Model->removeStock(array(
			'shop_product_id' => 'active',
			'shop_branch_id' => 'branch-2',
			'change' => 'asd'
		));
		$this->assertFalse($result);

		$conditions = array(
			'fields' => array($this->Model->alias . '.stock'),
			'conditions' => array($this->Model->alias . '.shop_product_id' => 'active'));
		$expected = array(
			array('ShopBranchStock' => array('stock' => '10')),
			array('ShopBranchStock' => array('stock' => '15'))
		);
		$result = $this->Model->find('all', $conditions);
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
		$results = Hash::extract($this->Model->ShopBranchStockLog->find('all', $conditions), '{n}.ShopBranchStockLog');
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
		$result = $this->Model->find('totalProductStock', $data);
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
		$result = $this->Model->find('stockList');
		$this->assertEquals($expected, $result);

		$this->assertEmpty($this->Model->find('stockList', array(
			'conditions' => array(
				$this->Model->alias . '.' . $this->Model->primaryKey => 'fake-record'
			)
		)));
	}

	public function testAddStockNewCombo() {
		$data = array(
			'shop_product_id' => 'out-of-stock',
			'shop_branch_id' => 'branch-2',
			'change' => 10
		);
		$result = $this->Model->addStock($data);
		$this->assertTrue((bool)$result);
	}
}