<?php
App::uses('ShopListProduct', 'Shop.Model');
App::uses('CakeSession', 'Model/Datasource');

/**
 * ShopListProduct Test Case
 *
 */
class ShopListProductTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_list_product',
		'plugin.shop.shop_list_product_option',
		'plugin.shop.shop_option',
		'plugin.shop.shop_option_value',
		'plugin.shop.shop_list',
		'plugin.shop.shop_product',
		'plugin.shop.shop_price',
		'plugin.shop.shop_product_type',
		'plugin.shop.shop_image',
		'plugin.shop.shop_products_option_value_override',

		'plugin.view_counter.view_counter_view'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopListProduct = ClassRegistry::init('Shop.ShopListProduct');
		$this->modelClass = $this->ShopListProduct->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopListProduct);
		CakeSession::destroy();

		parent::tearDown();
	}

/**
 * @brief test find products exception
 *
 * @expectedException InvalidArgumentException
 */
	public function testFindProductsException() {
		$this->{$this->modelClass}->find('products');
	}

/**
 * @brief test find products
 *
 * @dataProvider findProdcutsDataProvider
 */
	public function testFindProducts($data, $expected) {
		CakeSession::write('Auth.User.id', $data['user_id']);
		CakeSession::write('Shop.Guest.id', $data['guest_id']);

		$result = $this->{$this->modelClass}->find('products', array(
			'shop_list_id' => $data['shop_list_id']
		));
		$this->assertEquals($expected, $result);
	}

/**
 * @brief find products data provider
 *
 * @return array
 */
	public function findProdcutsDataProvider() {
		return array(
			'bob-normal' => array(
				array(
					'shop_list_id' => 'shop-list-bob-cart',
					'user_id' => 'bob',
					'guest_id' => null
				),
				array(
					array(
						'id' => 'shop-list-bob-cart-active',
						'shop_list_id' => 'shop-list-bob-cart',
						'shop_product_id' => 'active',
						'quantity' => '1.00000',
						'base_price' => '12.00000',
						'created' => '2012-10-09 01:32:27',
						'modified' => '2012-10-09 01:32:27',
						'ShopProduct' => array(
							'id' => 'active',
							'name' => 'active',
							'slug' => 'active',
							'ShopImage' => array(
								'id' => 'image-product-active',
								'image' => 'image-product-active.png',
							),
							'ShopProductType' => array(
								'id' => 'shirts',
								'name' => 'shirts',
							),
							'ShopListProductOption' => array(
								array(
									'id' => 'bob-cart-option-size-large',
									'shop_list_product_id' => 'shop-list-bob-cart-active',
									'shop_option_id' => 'option-size',
									'shop_option_value_id' => 'option-size-large',
									'ShopOption' => array(
										'id' => 'option-size',
										'name' => 'option-size',
										'slug' => 'option-size',
										'required' => '1',
									),
									'ShopOptionValue' => array(
										'id' => 'option-size-large',
										'name' => 'option-size-large',
										'product_code' => 'l',
										'ShopOverridePrice' => array(
											'selling' => null,
											'retail' => null
										),
										'ShopPrice' => array(
											'selling' => '3.00000',
											'retail' => '4.00000'
										)
									)
								)
							)
						)
					),
					array(
						'id' => 'shop-list-bob-cart-multi-option',
						'shop_list_id' => 'shop-list-bob-cart',
						'shop_product_id' => 'multi-option',
						'quantity' => '1.00000',
						'base_price' => '25.00000',
						'created' => '2012-10-09 01:32:27',
						'modified' => '2012-10-09 01:32:27',
						'ShopProduct' => array(
							'id' => 'multi-option',
							'name' => 'multi-option',
							'slug' => 'multi-option',
							'ShopImage' => array(
								'id' => 'image-product-multi-option',
								'image' => 'image-product-multi-option.png',
							),
							'ShopProductType' => array(
								'id' => 'complex-options',
								'name' => 'complex-options',
							),
							'ShopListProductOption' => array(

							)
						)
					)
				)
			),
			'sally' => array(
				array(
					'shop_list_id' => 'shop-list-sally-cart',
					'user_id' => 'sally',
					'guest_id' => null
				),
				array(
					array(
						'id' => 'shop-list-sally',
						'shop_list_id' => 'shop-list-sally-cart',
						'shop_product_id' => 'multi-option',
						'quantity' => '10.00000',
						'base_price' => '25.00000',
						'created' => '2012-10-09 01:32:27',
						'modified' => '2012-10-09 01:32:27',
						'ShopProduct' => array(
							'id' => 'multi-option',
							'name' => 'multi-option',
							'slug' => 'multi-option',
							'ShopImage' => array(
								'id' => 'image-product-multi-option',
								'image' => 'image-product-multi-option.png',
							),
							'ShopProductType' => array(
								'id' => 'complex-options',
								'name' => 'complex-options',
							),
							'ShopListProductOption' => array(
								array(
									'id' => 'sally-cart-option-colour-red',
									'shop_list_product_id' => 'shop-list-sally',
									'shop_option_id' => 'option-colour',
									'shop_option_value_id' => 'option-colour-red',
									'ShopOption' => array(
										'id' => 'option-colour',
										'name' => 'option-colour',
										'slug' => 'option-colour',
										'required' => '0',
									),
									'ShopOptionValue' => array(
										'id' => 'option-colour-red',
										'name' => 'option-colour-red',
										'product_code' => 'red',
										'ShopOverridePrice' => array(
											'selling' => null,
											'retail' => null
										),
										'ShopPrice' => array(
											'selling' => null,
											'retail' => null
										)
									)
								),
								array(
									'id' => 'sally-cart-option-size-medium',
									'shop_list_product_id' => 'shop-list-sally',
									'shop_option_id' => 'option-size',
									'shop_option_value_id' => 'option-size-medium',
									'ShopOption' => array(
										'id' => 'option-size',
										'name' => 'option-size',
										'slug' => 'option-size',
										'required' => '1',
									),
									'ShopOptionValue' => array(
										'id' => 'option-size-medium',
										'name' => 'option-size-medium',
										'product_code' => 'm',
										'ShopOverridePrice' => array(
											'selling' => null,
											'retail' => null
										),
										'ShopPrice' => array(
											'selling' => null,
											'retail' => null
										)
									)
								)
							)
						)
					)
				)
			),
			'guest-1' => array(
				array(
					'shop_list_id' => 'shop-list-guest-1-cart',
					'user_id' => 'guest-1',
					'guest_id' => null
				),
				array(
					array(
						'id' => 'shop-list-guest-1',
						'shop_list_id' => 'shop-list-guest-1-cart',
						'shop_product_id' => 'multi-category',
						'quantity' => '3.00000',
						'base_price' => '6.00000',
						'created' => '2012-10-09 01:32:27',
						'modified' => '2012-10-09 01:32:27',
						'ShopProduct' => array(
							'id' => 'multi-category',
							'name' => 'multi-category',
							'slug' => 'multi-category',
							'ShopImage' => array(
								'id' => null,
								'image' => null,
							),
							'ShopProductType' => array(
								'id' => null,
								'name' => null,
							),
							'ShopListProductOption' => array(

							)
						)
					)
				)
			)
		);
	}

}
