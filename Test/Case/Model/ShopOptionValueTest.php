<?php
App::uses('ShopOptionValue', 'Shop.Model');

/**
 * ShopOptionValue Test Case
 *
 */
class ShopOptionValueTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_option_value',
		'plugin.shop.shop_option',
		'plugin.shop.shop_size',
		'plugin.shop.shop_products_option_value_ignore',

		'plugin.shop.shop_price',
		'plugin.installer.plugin'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopOptionValue = ClassRegistry::init('Shop.ShopOptionValue');
		$this->modelClass = $this->ShopOptionValue->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopOptionValue);

		parent::tearDown();
	}

/**
 * @brief test values exception
 *
 * @expectedException InvalidArgumentException
 */
	public function testFindValuesException() {
		$this->{$this->modelClass}->find('values');
	}

/**
 * @brief test option values
 *
 * @param type $data
 * @param type $expected
 *
 * @dataProvider findValuesDataProvider
 */
	public function testFindValues($data, $expected) {
		if(!empty($expected)) {
			foreach($expected as &$k) {
				$k = array_merge(
					array(
						'ProductOptionValueIgnore' => array(),
						'ShopSize' => array(
							'id' => null,
							'model' => null,
							'foreign_key' => null,
							'product_width' => null,
							'product_height' => null,
							'product_length' => null,
							'shipping_width' => null,
							'shipping_height' => null,
							'shipping_length' => null,
							'product_weight' => null,
							'shipping_weight' => null,
						)
					),
					$k
				);
			}
		}
		$results = $this->{$this->modelClass}->find('values', array('shop_option_id' => $data));
		$this->assertEquals($expected, $results);
	}

/**
 * @brief find values data provider
 *
 * @return array
 */
	public function findValuesDataProvider() {
		return array(
			'invalid' => array(
				'option-madeup',
				array()
			),
			'size' => array(
				'option-size',
				array(
					array(
						'id' => 'option-size-large',
						'name' => 'option-size-large',
						'description' => 'some text about option-size-large',
						'product_code' => 'l',
						'shop_option_id' => 'option-size',
						'ShopPrice' => array(
							'id' => 'option-value-large',
							'selling' => '3.00000',
							'retail' => '4.00000',
						),
						'ShopSize' => array(
							'id' => 'option-value-size-large',
							'model' => 'Shop.ShopOptionValue',
							'foreign_key' => 'option-size-large',
							'product_width' => '1.50000',
							'product_height' => '1.50000',
							'product_length' => '1.50000',
							'shipping_width' => '2.50000',
							'shipping_height' => '2.50000',
							'shipping_length' => '2.50000',
							'product_weight' => '50.00000',
							'shipping_weight' => '65.00000'
						)
					),
					array(
						'id' => 'option-size-medium',
						'name' => 'option-size-medium',
						'description' => 'some text about option-size-medium',
						'product_code' => 'm',
						'shop_option_id' => 'option-size',
						'ShopPrice' => array(
							'id' => null,
							'selling' => null,
							'retail' => null,
						),
						'ProductOptionValueIgnore' => array(
							array(
								'id' => 'option-value-no-stock-added',
								'shop_option_value_id' => 'option-size-medium',
								'model' => 'Shop.ShopProduct',
								'foreign_key' => 'no-stock-added'
							)
						)
					),
					array(
						'id' => 'option-size-small',
						'name' => 'option-size-small',
						'description' => 'some text about option-size-small',
						'product_code' => 's',
						'shop_option_id' => 'option-size',
						'ShopPrice' => array(
							'id' => null,
							'selling' => null,
							'retail' => null,
						)
					),
				)
			),
			'colour' => array(
				'option-colour',
				array(
					array(
						'id' => 'option-colour-blue',
						'name' => 'option-colour-blue',
						'description' => 'some text about option-colour-blue',
						'product_code' => 'blue',
						'shop_option_id' => 'option-colour',
						'ShopPrice' => array(
							'id' => null,
							'selling' => null,
							'retail' => null,
						)
					),
					array(
						'id' => 'option-colour-red',
						'name' => 'option-colour-red',
						'description' => 'some text about option-colour-red',
						'product_code' => 'red',
						'shop_option_id' => 'option-colour',
						'ShopPrice' => array(
							'id' => null,
							'selling' => null,
							'retail' => null,
						)
					),
				)
			),
			'multiple' => array(
				array('option-size', 'option-colour'),
				array(
					array(
						'id' => 'option-colour-blue',
						'name' => 'option-colour-blue',
						'description' => 'some text about option-colour-blue',
						'product_code' => 'blue',
						'shop_option_id' => 'option-colour',
						'ShopPrice' => array(
							'id' => null,
							'selling' => null,
							'retail' => null,
						)
					),
					array(
						'id' => 'option-colour-red',
						'name' => 'option-colour-red',
						'description' => 'some text about option-colour-red',
						'product_code' => 'red',
						'shop_option_id' => 'option-colour',
						'ShopPrice' => array(
							'id' => null,
							'selling' => null,
							'retail' => null,
						)
					),
					array(
						'id' => 'option-size-large',
						'name' => 'option-size-large',
						'description' => 'some text about option-size-large',
						'product_code' => 'l',
						'shop_option_id' => 'option-size',
						'ShopPrice' => array(
							'id' => 'option-value-large',
							'selling' => '3.00000',
							'retail' => '4.00000',
						),
						'ShopSize' => array(
							'id' => 'option-value-size-large',
							'model' => 'Shop.ShopOptionValue',
							'foreign_key' => 'option-size-large',
							'product_width' => '1.50000',
							'product_height' => '1.50000',
							'product_length' => '1.50000',
							'shipping_width' => '2.50000',
							'shipping_height' => '2.50000',
							'shipping_length' => '2.50000',
							'product_weight' => '50.00000',
							'shipping_weight' => '65.00000'
						)
					),
					array(
						'id' => 'option-size-medium',
						'name' => 'option-size-medium',
						'description' => 'some text about option-size-medium',
						'product_code' => 'm',
						'shop_option_id' => 'option-size',
						'ShopPrice' => array(
							'id' => null,
							'selling' => null,
							'retail' => null,
						),
						'ProductOptionValueIgnore' => array(
							array(
								'id' => 'option-value-no-stock-added',
								'shop_option_value_id' => 'option-size-medium',
								'model' => 'Shop.ShopProduct',
								'foreign_key' => 'no-stock-added'
							)
						)
					),
					array(
						'id' => 'option-size-small',
						'name' => 'option-size-small',
						'description' => 'some text about option-size-small',
						'product_code' => 's',
						'shop_option_id' => 'option-size',
						'ShopPrice' => array(
							'id' => null,
							'selling' => null,
							'retail' => null,
						)
					),
				)
			)
		);
	}

}
