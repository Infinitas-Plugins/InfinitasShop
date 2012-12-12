<?php
App::uses('ShopOption', 'Shop.Model');

/**
 * ShopOption Test Case
 *
 */
class ShopOptionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_option',
		'plugin.shop.shop_option_value',
		'plugin.shop.shop_price',
		'plugin.shop.shop_size',
		'plugin.shop.shop_product',
		'plugin.shop.shop_product_types_option',
		'plugin.shop.shop_product_type',
		'plugin.installer.plugin',
		'plugin.view_counter.view_counter_view'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopOption = ClassRegistry::init('Shop.ShopOption');
		$this->modelClass = $this->ShopOption->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopOption);

		parent::tearDown();
	}

/**
 * test options exception
 *
 * @expectedException InvalidArgumentException
 */
	public function testFindOptionsException() {
		$this->{$this->modelClass}->find('options');
	}

/**
 * test finding product options
 *
 * @dataProvider findOptionsDataProvider
 */
	public function testFindOptions($data, $expected) {
		foreach ($expected as &$v) {
			if (!empty($v['ShopOption']['ShopOptionValue'])) {
				foreach ($v['ShopOption']['ShopOptionValue'] as &$vv) {
					if (!empty($vv)) {
						$vv = array_merge(
							array(
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
							$vv
						);
					}
				}
			}
		}
		$results = $this->{$this->modelClass}->find('options', array('shop_product_id' => $data));
		$this->assertEquals($expected, $results);
	}

/**
 * find options data provider
 *
 * @return array
 */
	public function findOptionsDataProvider() {
		return array(
			'multi-category' => array(
				'multi-category',
				array()
			),
			'active' => array(
				'active',
				array(
					array(
						'ShopOption' => array(
							'id' => 'option-size',
							'name' => 'option-size',
							'slug' => 'option-size',
							'description' => 'some descriptive text about option-size',
							'required' => '1',
							'shop_product_id' => 'active',
							'ShopOptionValue' => array(
								array(
									'id' => 'option-size-large',
									'name' => 'option-size-large',
									'description' => 'some text about option-size-large',
									'product_code' => 'l',
									'shop_option_id' => 'option-size',
									'ShopPrice' => array(
										'id' => 'option-value-large',
										'selling' => '3.00000',
										'retail' => '4.00000'
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
										'retail' => null
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
										'retail' => null
									)
								)
							)
						)
					)
				)
			),
			'multi-option' => array(
				'multi-option',
				array(
					array(
						'ShopOption' => array(
							'id' => 'option-size',
							'name' => 'option-size',
							'slug' => 'option-size',
							'description' => 'some descriptive text about option-size',
							'required' => '1',
							'shop_product_id' => 'multi-option',
							'ShopOptionValue' => array(
								array(
									'id' => 'option-size-large',
									'name' => 'option-size-large',
									'description' => 'some text about option-size-large',
									'product_code' => 'l',
									'shop_option_id' => 'option-size',
									'ShopPrice' => array(
										'id' => 'option-value-large',
										'selling' => '3.00000',
										'retail' => '4.00000'
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
										'retail' => null
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
										'retail' => null
									)
								)
							)
						)
					),
					array(
						'ShopOption' => array(
							'id' => 'option-colour',
							'name' => 'option-colour',
							'slug' => 'option-colour',
							'description' => 'some descriptive text about option-colour',
							'required' => '0',
							'shop_product_id' => 'multi-option',
							'ShopOptionValue' => array(
								array(
									'id' => 'option-colour-blue',
									'name' => 'option-colour-blue',
									'description' => 'some text about option-colour-blue',
									'product_code' => 'blue',
									'shop_option_id' => 'option-colour',
									'ShopPrice' => array(
										'id' => null,
										'selling' => null,
										'retail' => null
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
										'retail' => null
									)
								),
							)
						)
					)
				)
			),
			'ignored-options' => array(
				'no-stock-added',
				array(
					array(
						'ShopOption' => array(
							'id' => 'option-size',
							'name' => 'option-size',
							'slug' => 'option-size',
							'description' => 'some descriptive text about option-size',
							'required' => '1',
							'shop_product_id' => 'no-stock-added',
							'ShopOptionValue' => array(
								array(
									'id' => 'option-size-large',
									'name' => 'option-size-large',
									'description' => 'some text about option-size-large',
									'product_code' => 'l',
									'shop_option_id' => 'option-size',
									'ShopPrice' => array(
										'id' => 'option-value-large',
										'selling' => '3.00000',
										'retail' => '4.00000'
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
									'id' => 'option-size-small',
									'name' => 'option-size-small',
									'description' => 'some text about option-size-small',
									'product_code' => 's',
									'shop_option_id' => 'option-size',
									'ShopPrice' => array(
										'id' => null,
										'selling' => null,
										'retail' => null
									)
								)
							)
						)
					)
				)
			)
		);
	}

/**
 * test finding product options extracted
 *
 * @dataProvider productOptionExtractDataProvider
 */
	public function testFindOptionsExtracted($data, $expected) {
		foreach ($expected as &$v) {
			if (!empty($v['ShopOptionValue'])) {
				foreach ($v['ShopOptionValue'] as &$vv) {
					if (!empty($vv)) {
						$vv = array_merge(
							array(
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
							$vv
						);
					}
				}
			}
		}

		$results = $this->{$this->modelClass}->find('options', array('shop_product_id' => $data, 'extract' => true));
		$this->assertEquals($expected, $results);
	}

/**
 * extracted options data provider
 * @return type
 */
	public function productOptionExtractDataProvider() {
		return array(
			'made-up' => array(
				'made-up-option',
				array()
			),
			'multi-option' => array(
				'multi-option',
				array(
					array(
						'id' => 'option-size',
						'name' => 'option-size',
						'slug' => 'option-size',
						'description' => 'some descriptive text about option-size',
						'required' => '1',
						'shop_product_id' => 'multi-option',
						'ShopOptionValue' => array(
							array(
								'id' => 'option-size-large',
								'name' => 'option-size-large',
								'description' => 'some text about option-size-large',
								'product_code' => 'l',
								'shop_option_id' => 'option-size',
								'ShopPrice' => array(
									'id' => 'option-value-large',
									'selling' => '3.00000',
									'retail' => '4.00000'
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
									'retail' => null
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
									'retail' => null
								)
							)
						)
					),
					array(
						'id' => 'option-colour',
						'name' => 'option-colour',
						'slug' => 'option-colour',
						'description' => 'some descriptive text about option-colour',
						'required' => '0',
						'shop_product_id' => 'multi-option',
						'ShopOptionValue' => array(
							array(
								'id' => 'option-colour-blue',
								'name' => 'option-colour-blue',
								'description' => 'some text about option-colour-blue',
								'product_code' => 'blue',
								'shop_option_id' => 'option-colour',
								'ShopPrice' => array(
									'id' => null,
									'selling' => null,
									'retail' => null
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
									'retail' => null
								)
							),
						)
					)
				)
			)
		);
	}

/**
 * test option ordering
 */
	public function testOptionOrdering() {
		$expected = array(
			'option-size',
			'option-colour'
		);
		$result = Hash::extract(
			$this->{$this->modelClass}->find('options', array('shop_product_id' => 'multi-option')),
			'{n}.ShopOption.id'
		);
		$this->assertEquals($expected, $result);

		$this->assertTrue((bool)$this->{$this->modelClass}->ShopProductTypesOption->save(array(
			'id' => 'product-option-comp-options-size',
			'ordering' => 2
		), false));

		$this->assertTrue((bool)$this->{$this->modelClass}->ShopProductTypesOption->save(array(
			'id' => 'product-option-complex-options-colou',
			'ordering' => 1
		), false));

		$expected = array(
			'option-colour',
			'option-size',
		);
		$result = Hash::extract(
			$this->{$this->modelClass}->find('options', array('shop_product_id' => 'multi-option')),
			'{n}.ShopOption.id'
		);
		$this->assertEquals($expected, $result);
	}

/**
 * test finding product options extracted
 *
 * @dataProvider productOptionsProductListDataProvider
 */
	public function testFindOptionsProductList($data, $expected) {
		foreach ($expected as &$v) {
			if (!empty($v['ShopOptionValue'])) {
				foreach ($v['ShopOptionValue'] as &$vv) {
					if (!empty($vv)) {
						$vv = array_merge(
							array(
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
							$vv
						);
					}
				}
			}
		}

		$results = $this->{$this->modelClass}->find('options', array(
			'shop_product_id' => $data,
			'extract' => true,
			'product_list' => true
		));
		$this->assertEquals($expected, $results);
	}

/**
 * extracted options data provider
 * @return type
 */
	public function productOptionsProductListDataProvider() {
		return array(
			'made-up' => array(
				'made-up-option',
				array()
			),
			'multi-option' => array(
				'multi-option',
				array(
					array(
						'id' => 'option-size',
						'name' => 'option-size',
						'slug' => 'option-size',
						'description' => 'some descriptive text about option-size',
						'required' => '1',
						'shop_product_id' => 'multi-option',
						'ShopOptionValue' => array(
							array(
								'id' => 'option-size-large',
								'name' => 'option-size-large',
								'description' => 'some text about option-size-large',
								'product_code' => 'l',
								'shop_option_id' => 'option-size',
								'ShopPrice' => array(
									'id' => 'option-value-large',
									'selling' => '3.00000',
									'retail' => '4.00000'
								),
								'ShopSize' => array(
									'id' => 'option-value-size-large',
									'model' => 'Shop.ShopOptionValue',
									'foreign_key' => 'option-size-large',
									'shipping_width' => '2.50000',
									'shipping_height' => '2.50000',
									'shipping_length' => '2.50000',
									'product_width' => '1.50000',
									'product_height' => '1.50000',
									'product_length' => '1.50000',
									'shipping_weight' => '65.00000',
									'product_weight' => '50.00000'
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
									'retail' => null
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
									'retail' => null
								)
							)
						)
					),
					array(
						'id' => 'option-colour',
						'name' => 'option-colour',
						'slug' => 'option-colour',
						'description' => 'some descriptive text about option-colour',
						'required' => '0',
						'shop_product_id' => 'multi-option',
						'ShopOptionValue' => array(
							array(
								'id' => 'option-colour-blue',
								'name' => 'option-colour-blue',
								'description' => 'some text about option-colour-blue',
								'product_code' => 'blue',
								'shop_option_id' => 'option-colour',
								'ShopPrice' => array(
									'id' => null,
									'selling' => null,
									'retail' => null
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
									'retail' => null
								)
							),
						)
					)
				)
			)
		);
	}

}
