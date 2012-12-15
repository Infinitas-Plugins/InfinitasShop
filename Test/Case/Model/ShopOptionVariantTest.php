<?php
App::uses('ShopOptionVariant', 'Shop.Model');

/**
 * ShopOptionVariant Test Case
 *
 */
class ShopOptionVariantTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_option_variant',
		'plugin.shop.shop_product_variant',
		'plugin.shop.shop_option_value',
		'plugin.shop.shop_option',
		'plugin.shop.shop_price',
		'plugin.shop.shop_size',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Model = ClassRegistry::init('Shop.ShopOptionVariant');
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
 * test find variants
 *
 * @dataProvider findVariantsDataProvider
 */
	public function testFindVariants($data, $expected) {
		$result = $this->Model->find('variants', array(
			'shop_product_variant_id' => $data
		));
		$this->assertEquals($expected, count($result));
	}

/**
 * find variants data provider
 *
 * @return array
 */
	public function findVariantsDataProvider() {
		return array(
			'fake' => array(
				array('nothing'),
				0
			),
			'variant-active-1' => array(
				array('variant-active-1'),
				1
			),
			'variant-active' => array(
				array(
					'variant-active-1',
					'variant-active-2',
					'variant-active-3'
				),
				3
			)
		);
	}

/**
 * testGetViewData method
 *
 * @return void
 */
	public function testOptionOverrides() {
		$result = current($this->Model->find('variants', array(
			'shop_product_variant_id' => 'variant-active-3'
		)));

		$expected = array (
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
		$this->assertEquals($expected, $result['ShopSize']);

		$expected = array (
			'id' => null,
			'cost' => '2.00000',
			'selling' => '3.00000',
			'retail' => '4.00000'
		);
		$this->assertEquals($expected, $result['ShopPrice']);

		$this->Model->ShopPrice->create();
		$saved = (bool)$this->Model->ShopPrice->save(array(
			'model' => $this->Model->fullModelName(),
			'foreign_key' => 'variant-active-1c',
			'selling' => 10.5
		));
		$shopPriceId = $this->Model->ShopPrice->id;
		$this->assertTrue($saved);

		$this->Model->ShopSize->create();
		$saved = (bool)$this->Model->ShopSize->save(array(
			'model' => $this->Model->fullModelName(),
			'foreign_key' => 'variant-active-1c',
			'product_width' => 10.5
		));
		$shopSizeId = $this->Model->ShopSize->id;
		$this->assertTrue($saved);

		$result = current($this->Model->find('variants', array(
			'shop_product_variant_id' => 'variant-active-3'
		)));

		$expected = array (
			'id' => $shopSizeId,
			'product_width' => '10.50000',
			'product_height' => '1.50000',
			'product_length' => '1.50000',
			'shipping_width' => '2.50000',
			'shipping_height' => '2.50000',
			'shipping_length' => '2.50000',
			'product_weight' => '50.00000',
			'shipping_weight' => '65.00000',
		);
		$this->assertEquals($expected, $result['ShopSize']);

		$expected = array (
			'id' => $shopPriceId,
			'cost' => '2.00000',
			'selling' => '10.50000',
			'retail' => '4.00000'
		);
		$this->assertEquals($expected, $result['ShopPrice']);

		$result = current($this->Model->find('variants', array(
			'shop_product_variant_id' => 'variant-active-3',
			'override' => false
		)));

		$expected = array (
			'id' => $shopSizeId,
			'product_width' => '10.50000',
			'product_height' => null,
			'product_length' => null,
			'shipping_width' => null,
			'shipping_height' => null,
			'shipping_length' => null,
			'product_weight' => null,
			'shipping_weight' => null,
		);
		$this->assertEquals($expected, $result['ShopSize']);

		$expected = array (
			'id' => $shopPriceId,
			'cost' => null,
			'selling' => '10.50000',
			'retail' => null
		);
		$this->assertEquals($expected, $result['ShopPrice']);
	}

}
