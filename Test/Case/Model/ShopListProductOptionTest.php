<?php
App::uses('ShopListProductOption', 'Shop.Model');

/**
 * ShopListProductOption Test Case
 *
 */
class ShopListProductOptionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_list_product_option',
		'plugin.shop.shop_list',
		'plugin.shop.shop_option',
		'plugin.shop.shop_option_value',
		'plugin.shop.shop_products_option_value_override',
		'plugin.shop.shop_price',
		'plugin.shop.shop_list_product',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopListProductOption = ClassRegistry::init('Shop.ShopListProductOption');
		$this->modelClass = $this->ShopListProductOption->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopListProductOption);

		parent::tearDown();
	}

/**
 * test validation
 *
 * @dataProvider validationDataProvider
 */
	public function testValidation($data, $expected) {
		$this->{$this->modelClass}->create();
		$result = $this->{$this->modelClass}->save($data);

		$this->assertEquals(empty($expected), (bool)$result);
		$this->assertEquals($expected, $this->{$this->modelClass}->validationErrors);
	}

/**
 * validation data provider
 *
 * @return array
 */
	public function validationDataProvider() {
		return array(
			'empty' => array(
				array(),
				array(
					'shop_list_product_id' => array('No product specified')
				)
			),
			'invalid option' => array(
				array(
					'shop_list_product_id' => null,
					'shop_option_id' => 'fake-option',
					'shop_option_value_id' => 'fake-option-value',
				),
				array(
					'shop_list_product_id' => array('No product specified'),
					'shop_option_id' => array('Invalid option'),
					'shop_option_value_id' => array('Invalid option value')
				)
			),
			'invalid option value' => array(
				array(
					'shop_list_product_id' => 'shop-list-bob-cart-active',
					'shop_option_id' => 'option-size',
					'shop_option_value_id' => 'fake-option-value',
				),
				array(
					'shop_option_value_id' => array('Invalid option value')
				)
			),
			'Unique option / value' => array(
				array(
					'shop_list_product_id' => 'shop-list-bob-cart-active',
					'shop_option_id' => 'option-size',
					'shop_option_value_id' => 'fake-option-value',
				),
				array(
					'shop_option_value_id' => array('Invalid option value')
				)
			),
			'duplicate option / value' => array(
				array(
					'shop_list_product_id' => 'shop-list-bob-cart-active',
					'shop_option_id' => 'option-size',
					'shop_option_value_id' => 'option-size-large',
				),
				array(
					'shop_list_product_id' => array('Product already added')
				)
			),
			'invalid product' => array(
				array(
					'shop_list_product_id' => 'fake-product-id',
					'shop_option_id' => 'option-size',
					'shop_option_value_id' => 'option-size-small',
				),
				array(
					'shop_list_product_id' => array('Invalid product')
				)
			),
			'valid' => array(
				array(
					'shop_list_product_id' => 'shop-list-bob-cart-active',
					'shop_option_id' => 'option-size',
					'shop_option_value_id' => 'option-size-small',
				),
				array()
			)
		);
	}

/**
 * test find options exception
 *
 * @expectedException InvalidArgumentException
 */
	public function testFindOptionsException() {
		$this->{$this->modelClass}->find('options');
	}

	public function testFindOptions() {
		$expected = array();
		$result = $this->{$this->modelClass}->find('options', array(
			'shop_list_product_id' => 'something-invalid'
		));
		$this->assertEquals($expected, $result);

		$expected = array(
			array(
				'shop_list_product_id' => 'shop-list-bob-cart-active',
				'ShopOption' => array(
					'id' => 'option-size',
					'name' => 'option-size',
					'description' => 'some descriptive text about option-size'
				),
				'ShopOptionValue' => array(
					'id' => 'option-size-large',
					'name' => 'option-size-large'
				)
			)
		);
		$result = $this->{$this->modelClass}->find('options', array(
			'shop_list_product_id' => 'shop-list-bob-cart-active'
		));
		$this->assertEquals($expected, $result);
	}

	public function testSaveProductOptions() {
		$data = array(
			'option-size' => 'option-size-medium'
		);
		$result = $this->{$this->modelClass}->saveProductOptions('shop-list-bob-cart-active', $data);
		$this->assertTrue($result);

		$data = array(
			'option-size' => 'option-size-fake'
		);
		$result = $this->{$this->modelClass}->saveProductOptions('shop-list-bob-cart-active', $data);
		$this->assertFalse($result);

		$data = array(
			'option-fake' => 'option-size-medium'
		);
		$result = $this->{$this->modelClass}->saveProductOptions('shop-list-bob-cart-active', $data);
		$this->assertFalse($result);

		$data = array(
			'option-size' => 'option-size-medium'
		);
		$result = $this->{$this->modelClass}->saveProductOptions('shop-list-bob-cart-fake', $data);
		$this->assertFalse($result);
	}
}
