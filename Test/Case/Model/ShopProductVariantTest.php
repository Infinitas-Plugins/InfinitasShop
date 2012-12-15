<?php
App::uses('ShopProductVariant', 'Model');

/**
 * ShopProductVariant Test Case
 *
 */
class ShopProductVariantTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_product_variant',
		'plugin.shop.shop_product',
		'plugin.shop.shop_list_product',
		'plugin.shop.shop_option_variant',
		'plugin.shop.shop_option_value',
		'plugin.shop.shop_option',
		'plugin.shop.shop_price',
		'plugin.shop.shop_size',
		'plugin.shop.shop_branch_stock',
		'plugin.shop.shop_brand',

		'plugin.view_counter.view_counter_view',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Model = ClassRegistry::init('Shop.ShopProductVariant');
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
 * test find variants exception
 *
 * @expectedException InvalidArgumentException
 */
	public function testFindVariantsException() {
		$this->Model->find('variants');
	}

/**
 * test find variants
 *
 * @dataProvider findVariantsDataProvider
 */
	public function testFindVariants($data, $expected) {
		$result = $this->Model->find('variants', $data);
		$this->assertEquals($expected, count($result));
	}

/**
 * test find variants data provider
 *
 * @return array
 */
	public function findVariantsDataProvider() {
		return array(
			'missing' => array(
				array('master' => 0, 'shop_product_id' => 'fake-product'),
				0
			),
			'active master' => array(
				array('master' => true, 'shop_product_id' => 'active'),
				1
			),
			'active' => array(
				array('master' => false, 'shop_product_id' => 'active'),
				3
			),
			'active' => array(
				array('master' => null, 'shop_product_id' => 'active'),
				4
			)
		);
	}

/**
 * test find variant data
 */
	public function testFindVariantData() {
		$expected = array(
			'id' => 'variant-active-master',
			'shop_product_id' => 'active',
			'product_code' => 'active-:option-size',
		);
		$result = $this->Model->find('variants', array(
			'master' => true,
			'shop_product_id' => 'active'
		));

		$this->assertEquals(1, count($result));
		$result = current(array_values($result));

		unset($result['ShopProductVariantPrice'], $result['ShopProductVariantSize']);
		unset($result['ShopOptionVariant'], $result['ShopBranchStock']);
		$this->assertEquals($expected, $result);

		$expected = array(
			'id' => 'variant-active-1',
			'shop_product_id' => 'active',
			'product_code' => 'active-s',
		);
		$result = $this->Model->find('variants', array(
			'master' => false,
			'shop_product_id' => 'active'
		));

		$this->assertEquals(3, count($result));
		$result = current(array_values($result));

		$shopOptionVariant = $result['ShopOptionVariant'];
		$shopBranchStock = $result['ShopBranchStock'];
		unset($result['ShopProductVariantPrice'], $result['ShopProductVariantSize']);
		unset($result['ShopOptionVariant'], $result['ShopBranchStock']);

		$this->assertEquals($expected, $result);

		$this->assertEquals(1, count($shopOptionVariant));
		$expected = array(
			'variant-active-1a'
		);
		$result = Hash::extract($shopOptionVariant, '{n}.id');
		$this->assertEquals($expected, $result);

		$expected = array(10, 15);
		$result = Hash::extract($shopBranchStock, '{n}.stock');
		$this->assertEquals($expected, $result);
	}

/**
 * test product code
 */
	public function testProductCode() {
		$this->Model->ShopProduct->id = 'active';
		$this->Model->ShopProduct->saveField('product_code', 'abc');

		$expected = array(
			'abc-s',
			'abc-m',
			'abc-l',
		);
		$result = $this->Model->find('variants', array(
			'master' => false,
			'shop_product_id' => 'active'
		));
		$result = Hash::extract($result, '{n}.product_code');
		$this->assertEquals($expected, $result);


		$this->Model->ShopProduct->id = 'active';
		$this->Model->ShopProduct->saveField('product_code', '');
		$expected = array(
			's',
			'm',
			'l',
		);
		$result = $this->Model->find('variants', array(
			'master' => false,
			'shop_product_id' => 'active'
		));
		$result = Hash::extract($result, '{n}.product_code');
		$this->assertEquals($expected, $result);

		$updated = $this->Model->ShopOptionVariant->ShopOptionValue->updateAll(array(
			'ShopOptionValue.product_code' => null,
		));
		$this->assertTrue($updated);
		$result = $this->Model->find('variants', array(
			'master' => false,
			'shop_product_id' => 'active'
		));
		$result = array_filter(Hash::extract($result, '{n}.product_code'));
		$this->assertEmpty($result);
	}

/**
 * test variant override
 */
	public function testVariantOverride() {
		$result = end($this->Model->find('variants', array(
			'master' => false,
			'shop_product_id' => 'active'
		)));
		$expected = array(
			'id' => null,
			'product_width' => '1.50000',
			'product_height' => '1.50000',
			'product_length' => '1.50000',
			'shipping_width' => '2.50000',
			'shipping_height' => '2.50000',
			'shipping_length' => '2.50000',
			'product_weight' => '50.00000',
			'shipping_weight' => '65.00000',
		);
		$this->assertEquals($expected, $result['ShopOptionVariant'][0]['ShopSize']);

		$result = end($this->Model->find('variants', array(
			'master' => false,
			'shop_product_id' => 'active',
			'override' => false
		)));
		$expected = array(
			'id' => null,
			'product_width' => null,
			'product_height' => null,
			'product_length' => null,
			'shipping_width' => null,
			'shipping_height' => null,
			'shipping_length' => null,
			'product_weight' => null,
			'shipping_weight' => null,
		);
		$this->assertEquals($expected, $result['ShopOptionVariant'][0]['ShopSize']);
	}
}