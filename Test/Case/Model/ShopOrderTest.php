<?php

App::uses('ShopOrder', 'Shop.Model');

/**
 * ShopOrder Test Case
 *
 */
class ShopOrderTest extends CakeTestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array(
		'plugin.shop.shop_order',
		'plugin.shop.core_user',
		'plugin.shop.core_group',
		'plugin.shop.shop_address',
		'plugin.shop.shop_payment_method',
		'plugin.shop.shop_list',
		'plugin.shop.shop_shipping_method',
		'plugin.shop.shop_supplier',
		'plugin.shop.shop_branch_stock_log',
		'plugin.shop.shop_branch_stock',
		'plugin.shop.shop_product_variant',
		'plugin.shop.shop_product',
		'plugin.shop.shop_image',
		'plugin.shop.shop_category',
		'plugin.shop.shop_product_type',
		'plugin.shop.shop_product_types_option',
		'plugin.shop.shop_option',
		'plugin.shop.shop_option_value',
		'plugin.shop.shop_price',
		'plugin.shop.shop_size',
		'plugin.shop.shop_categories_product',
		'plugin.shop.shop_special',
		'plugin.shop.shop_products_special',
		'plugin.shop.shop_spotlight',
		'plugin.shop.shop_brand',
		'plugin.shop.shop_images_product',
		'plugin.shop.shop_list_product',
		'plugin.shop.shop_option_variant',
		'plugin.shop.shop_order_product',
		'plugin.shop.shop_shipping_method_value',
		'plugin.shop.shop_order_status',
		'plugin.shop.shop_order_note',
		'plugin.trash.trash',
		'plugin.installer.plugin',
		'plugin.management.ticket',
		'plugin.infinitas_payments.infinitas_payment_log',
		'plugin.view_counter.view_counter_view',
	);

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		CakeSession::destroy();
		$this->Model = ClassRegistry::init('Shop.ShopOrder');
		$this->Model->query('ALTER TABLE  `shop_orders` CHANGE  `invoice_number`  `invoice_number` INT( 5 ) UNSIGNED ZEROFILL NOT null AUTO_INCREMENT');
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Model);
		CakeSession::destroy();

		parent::tearDown();
	}

	/**
	 * test find details exception
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function testFindDetailsException() {
		$this->Model->find('details');
	}

	/**
	 * test find details
	 */
	public function testFindDetails() {
		CakeSession::write('Shop.Guest.id', 'guest-1');

		$expected = 'order-1';
		$results = $this->Model->find('details', array(
			$expected,
			'admin' => true
		));
		$this->assertEquals($expected, $results[$this->Model->alias]['id']);

		$expected = array();
		$results = $this->Model->find('details', 'order-1');
		$this->assertEmpty($results);

		CakeSession::write('Auth.User.id', 'bob');
		$expected = 'order-1';
		$results = $this->Model->find('details', $expected);
		$this->assertEquals($expected, $results[$this->Model->alias]['id']);

		$expected = 'order-2';
		$results = $this->Model->find('details', $expected);
		$this->assertEmpty($results);

		CakeSession::write('Auth.User.id', 'sally');
		$results = $this->Model->find('details', $expected);
		$this->assertEquals($expected, $results[$this->Model->alias]['id']);
	}

	/**
	 * test find details format
	 */
	public function testFindDetailsFormat() {
		$result = $this->Model->find('details', array(
			'order-1',
			'admin' => true
		));

		$expected = $this->_order1();
		$this->_sort($expected, false);
		$this->_sort($result, false);
		$this->assertEquals($expected, $result);
	}

	/**
	 * test find mine
	 */
	public function testFindMine() {
		$this->assertEmpty($this->Model->find('mine'));

		CakeSession::write('Auth.User.id', 'bob');
		$expected = array(
			'order-1'
		);
		$results = Hash::extract($this->Model->find('mine'), '{n}.ShopOrder.id');
		$this->assertEquals($expected, $results);

		CakeSession::write('Auth.User.id', 'sally');
		$expected = array(
			'order-2'
		);
		$results = Hash::extract($this->Model->find('mine'), '{n}.ShopOrder.id');
		$this->assertEquals($expected, $results);
	}

	/**
	 * testOrderFromList method
	 *
	 * @return void
	 */
	public function testOrderFromList() {
		$expected = array(
			'invoice_number' => '00003',
			'infinitas_payment_log_id' => null,
			'tracking_number' => null,
			'user_id' => 'bob'
		);
		$result = $this->Model->orderFromList('shop-list-bob-cart');
		unset($result['id']);
		$this->assertEquals($expected, $result);
	}

	/**
	 * Check that the cart is cleared but remains available for use
	 */
	public function testOrderFromListCartCleared() {
		$result = $this->Model->orderFromList('shop-list-bob-cart');

		$ShopList = ClassRegistry::init('Shop.ShopList');
		$this->assertTrue($ShopList->exists('shop-list-bob-cart'));
		$result = $ShopList->ShopListProduct->find('list', array(
			'conditions' => array(
				'ShopListProduct.shop_list_id' => 'shop-list-bob-cart'
			)
		));
		$this->assertCount(0, $result);

		$expected = array(
			'shop-list-guest-1',
			'shop-list-sally'
		);
		$result = array_keys($ShopList->ShopListProduct->find('list'));
		$this->assertEquals($expected, $result);
	}

/**
 * Test the format of order after convering from a list
 */
	public function testOrderFromListOrderFormat() {
		$result = $this->Model->orderFromList('shop-list-bob-cart', array(
			'infinitas_payment_log_id' => 'payment-log-1'
		));
		$result = $this->Model->find('details', array(
			$result['id'],
			'admin' => true
		));
		$expected = $this->_orderFromListBobCart();
		$this->_sort($expected);
		$this->_sort($result);

		$this->assertEquals($expected, $result);
	}

/**
 * test find new order basics
 */
	public function testFindNewOrderBasics() {
		$result = $this->Model->find('newOrderBasics');
		$this->assertEmpty($result);


		$this->Model->id = 'order-1';
		$expected = array(
			'id' => 'order-1',
			'invoice_number' => '00001',
			'infinitas_payment_log_id' => 'payment-1',
			'tracking_number' => null,
			'user_id' => 'bob'
		);
		$result = $this->Model->find('newOrderBasics');
		$this->assertEquals($expected, $result);
	}

	protected function _sort(&$array, $clean = true) {
		if ($clean) {
			$this->_removeFields($array);
		}

		usort($array['ShopOrderProduct'], function ($a, $b) {
			return strcasecmp($a['ShopOrderProduct']['shop_product_variant_id'], $b['ShopOrderProduct']['shop_product_variant_id']);
		});
	}

/**
 * Helper method for removing ids from data so it can be compared with newly saved data.
 *
 * Cant tell what the ids will be as they are uuids.
 *
 * @param array $array the data to be filtered
 *
 * @return void
 */
	protected function _removeFields(&$array) {
		if (!is_array($array)) {
			return;
		}
		$fieldsToRemove = array('id', 'shop_order_id', 'time_to_purchase', 'foreign_key', 'created', 'modified');
		foreach ($array as $k => &$v) {
			if (in_array($k, $fieldsToRemove)) {
				unset($array[$k]);
				continue;
			}
			self::_removeFields($v);
		}
	}

	protected function _orderFromListBobCart() {
		return array(
			'ShopOrder' => array(
				'id' => '50ecd2de-50e0-4650-8bb3-1e776318cd70',
				'invoice_number' => '00003',
				'shop_order_product_count' => '3',
				'ip_address' => null,
				'total' => 91.050003,
				'tax' => '0.000000',
				'shipping' => 3.050000,
				'insurance' => 1,
				'handling' => '0.000000',
				'previous_orders_count' => '1',
				'previous_orders_value' => '72.000000',
				'shop_order_status_id' => 'pending'
			),
			'User' => array(
				'id' => 'bob',
				'username' => 'bob',
				'full_name' => 'bob bob',
				'prefered_name' => 'b. bob',
				'email' => 'bob@bob.com',
				'browser' => 'Chrome',
				'operating_system' => 'Linux',
				'last_login' => '2012-10-08 19:39:28',
				'last_click' => '2012-10-08 19:39:28',
			),
			'ShopBillingAddress' => array(
				'id' => null,
				'user_id' => null,
				'name' => null,
				'address_1' => null,
				'address_2' => null,
				'state_id' => null,
				'country_id' => null,
				'post_code' => null,
				'created' => null,
				'modified' => null,
			),
			'ShopShippingAddress' => array(
				'id' => null,
				'user_id' => null,
				'name' => null,
				'address_1' => null,
				'address_2' => null,
				'state_id' => null,
				'country_id' => null,
				'post_code' => null,
				'created' => null,
				'modified' => null,
			),
			'ShopPaymentMethod' => array(
				'id' => 'paypal',
				'name' => 'paypal',
			),
			'ShopShippingMethod' => array(
				'id' => 'royal-mail-1st',
				'name' => 'royal-mail-1st',
			),
			'ShopOrderStatus' => array(
				'id' => 'pending',
				'name' => 'pending',
			),
			'InfinitasPaymentLog' => array(
				'id' => 'payment-log-1',
				'token' => 'foo-bar',
				'transaction_id' => 'transaction xyz',
				'transaction_type' => 'payment',
				'transaction_fee' => 3.50,
				'raw_request' => array('json' => 'request'),
				'raw_response' => array('json' => 'response'),
				'transaction_date' => '2013-01-09 00:11:13',
				'currency_code' => 'GBP',
				'total' => 25.00,
				'tax' => 2.50,
				'custom' => 'custom-var',
				'status' => 'Complete',
				'created' => '2013-01-09 00:11:13',
				'modified' => '2013-01-09 00:11:13'
			),
			'ShopOrderNote' => array(),
			'ShopOrderProduct' => array(
				array(
					'ShopProduct' => array(
						'id' => 'active',
						'name' => 'active',
						'slug' => 'active',
						'rating' => '1',
						'rating_count' => '1',
						'views' => '5',
						'sales' => '1',
						'active' => true,
						'total_variants' => '1',
						'price_max' => 0,
						'price_min' => 0,
						'shop_product_attribute_count' => '0',
					),
					'ShopProductType' => array(
						'id' => 'shirts',
						'name' => 'shirts',
						'slug' => 'shirts',
					),
					'ShopBrand' => array(
						'id' => 'inhouse',
						'name' => 'inhouse',
						'slug' => 'inhouse',
					),
					'ShopImage' => array(
						'id' => 'image-product-active',
						'image' => 'image-product-active.png',
						'image_full' => '/files/shop_image/image/image-product-active/image-product-active.png',
						'image_large' => '/files/shop_image/image/image-product-active/large_image-product-active.png',
						'image_medium' => '/files/shop_image/image/image-product-active/medium_image-product-active.png',
						'image_small' => '/files/shop_image/image/image-product-active/small_image-product-active.png',
						'image_thumb' => '/files/shop_image/image/image-product-active/thumb_image-product-active.png',
					),
					'ShopProductVariant' => array(
						'id' => 'variant-active-1',
						'shop_product_id' => 'active',
						'shop_image_id' => null,
						'master' => false,
						'created' => '2012-12-12 01:45:05',
						'modified' => '2012-12-12 01:45:05',
						'ShopProductVariantPrice' => array(
							'id' => 'variant-active-master',
							'cost' => '10.00000',
							'selling' => '12.00000',
							'retail' => '15.00000',
						),
						'ShopProductVariantSize' => array(
							'id' => 'product-active',
							'product_width' => '10.50000',
							'product_height' => '10.50000',
							'product_length' => '10.50000',
							'shipping_width' => '12.50000',
							'shipping_height' => '12.50000',
							'shipping_length' => '12.50000',
							'product_weight' => '500.00000',
							'shipping_weight' => '650.00000',
						),
					),
					'ShopOrderProduct' => array(
						'id' => '50ecd2de-fec0-4c6e-a941-1e776318cd70',
						'shop_order_id' => '50ecd2de-50e0-4650-8bb3-1e776318cd70',
						'shop_product_variant_id' => 'variant-active-1',
						'shop_product_type_id' => 'shirts',
						'quantity' => '1.000',
						'name' => 'active',
						'brand' => 'inhouse',
						'shop_image_id' => 'image-product-active',
						'product_code' => 'active-:option-size',
						'time_to_purchase' => '7951411',
						'view_to_purchase' => '0',
					),
					'ShopCategory' => array(
						array(
							'id' => 'active',
							'name' => 'active',
							'slug' => 'active',
							'shop_product_id' => 'active',
						),
					),
					'ShopOrderProductPrice' => array(
						'cost' => '10.00000',
						'selling' => '12.00000',
						'retail' => '15.00000',
					),
					'ShopOrderProductSize' => array(
						'product_width' => '10.50000',
						'product_height' => '10.50000',
						'product_length' => '10.50000',
						'shipping_width' => '12.50000',
						'shipping_height' => '12.50000',
						'shipping_length' => '12.50000',
						'product_weight' => '500.00000',
						'shipping_weight' => '650.00000',
					),
				),
				array(
					'ShopProduct' => array(
						'id' => 'multi-option',
						'name' => 'multi-option',
						'slug' => 'multi-option',
						'rating' => '1',
						'rating_count' => '1',
						'views' => '100',
						'sales' => '25',
						'active' => true,
						'total_variants' => '0',
						'price_max' => 0,
						'price_min' => 0,
						'shop_product_attribute_count' => '0',
					),
					'ShopProductType' => array(
						'id' => 'complex-options',
						'name' => 'complex-options',
						'slug' => 'complex-options',
					),
					'ShopBrand' => array(
						'id' => 'inhouse',
						'name' => 'inhouse',
						'slug' => 'inhouse',
					),
					'ShopImage' => array(
						'id' => 'image-product-multi-option',
						'image' => 'image-product-multi-option.png',
						'image_full' => '/files/shop_image/image/image-product-multi-option/image-product-multi-option.png',
						'image_large' => '/files/shop_image/image/image-product-multi-option/large_image-product-multi-option.png',
						'image_medium' => '/files/shop_image/image/image-product-multi-option/medium_image-product-multi-option.png',
						'image_small' => '/files/shop_image/image/image-product-multi-option/small_image-product-multi-option.png',
						'image_thumb' => '/files/shop_image/image/image-product-multi-option/thumb_image-product-multi-option.png',
					),
					'ShopProductVariant' => array(
						'id' => 'variant-multi-option-2',
						'shop_product_id' => 'multi-option',
						'shop_image_id' => null,
						'master' => false,
						'created' => '2012-12-12 01:45:05',
						'modified' => '2012-12-12 01:45:05',
						'ShopProductVariantPrice' => array(
							'id' => 'product-multi-option',
							'cost' => '20.00000',
							'selling' => '25.00000',
							'retail' => '30.00000'
						),
						'ShopProductVariantSize' => array(
							'id' => null,
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
					'ShopOrderProduct' => array(
						'id' => '50ecd2de-f510-442c-958c-1e776318cd70',
						'shop_order_id' => '50ecd2de-50e0-4650-8bb3-1e776318cd70',
						'shop_product_variant_id' => 'variant-multi-option-2',
						'shop_product_type_id' => 'complex-options',
						'quantity' => '2.000',
						'name' => 'multi-option',
						'brand' => 'inhouse',
						'shop_image_id' => 'image-product-multi-option',
						'product_code' => 'multi-option-:option-size(:option-colour)',
						'time_to_purchase' => '7951411',
						'view_to_purchase' => '0',
					),
					'ShopCategory' => array(
						array(
							'id' => 'active',
							'name' => 'active',
							'slug' => 'active',
							'shop_product_id' => 'multi-option',
						)
					),
					'ShopOrderProductPrice' => array(
						'cost' => '20.00000',
						'selling' => '25.00000',
						'retail' => '30.00000',
						'model' => 'Shop.ShopOrderProduct',
					),
					'ShopOrderProductSize' => array(
						'model' => null,
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
				array(
					'ShopProduct' => array(
						'id' => 'multi-option',
						'name' => 'multi-option',
						'slug' => 'multi-option',
						'rating' => '1',
						'rating_count' => '1',
						'views' => '100',
						'sales' => '25',
						'active' => true,
						'total_variants' => '0',
						'price_max' => 0,
						'price_min' => 0,
						'shop_product_attribute_count' => '0',
					),
					'ShopProductType' => array(
						'id' => 'complex-options',
						'name' => 'complex-options',
						'slug' => 'complex-options',
					),
					'ShopBrand' => array(
						'id' => 'inhouse',
						'name' => 'inhouse',
						'slug' => 'inhouse',
					),
					'ShopImage' => array(
						'id' => 'image-product-multi-option',
						'image' => 'image-product-multi-option.png',
						'image_full' => '/files/shop_image/image/image-product-multi-option/image-product-multi-option.png',
						'image_large' => '/files/shop_image/image/image-product-multi-option/large_image-product-multi-option.png',
						'image_medium' => '/files/shop_image/image/image-product-multi-option/medium_image-product-multi-option.png',
						'image_small' => '/files/shop_image/image/image-product-multi-option/small_image-product-multi-option.png',
						'image_thumb' => '/files/shop_image/image/image-product-multi-option/thumb_image-product-multi-option.png',
					),
					'ShopProductVariant' => array(
						'id' => 'variant-multi-option-1',
						'shop_product_id' => 'multi-option',
						'shop_image_id' => null,
						'master' => false,
						'created' => '2012-12-12 01:45:05',
						'modified' => '2012-12-12 01:45:05',
						'ShopProductVariantPrice' => array(
							'id' => 'product-multi-option',
							'cost' => '20.00000',
							'selling' => '25.00000',
							'retail' => '30.00000',
						),
						'ShopProductVariantSize' => array(
							'id' => null,
							'product_width' => null,
							'product_height' => null,
							'product_length' => null,
							'shipping_width' => null,
							'shipping_height' => null,
							'shipping_length' => null,
							'product_weight' => null,
							'shipping_weight' => null,
						),
					),
					'ShopOrderProduct' => array(
						'id' => '50ecd2de-6fa8-4997-a247-1e776318cd70',
						'shop_order_id' => '50ecd2de-50e0-4650-8bb3-1e776318cd70',
						'shop_product_variant_id' => 'variant-multi-option-1',
						'shop_product_type_id' => 'complex-options',
						'quantity' => '1.000',
						'name' => 'multi-option',
						'brand' => 'inhouse',
						'shop_image_id' => 'image-product-multi-option',
						'product_code' => 'multi-option-:option-size(:option-colour)',
						'time_to_purchase' => '7951411',
						'view_to_purchase' => '0',
					),
					'ShopCategory' => array(
						array(
							'id' => 'active',
							'name' => 'active',
							'slug' => 'active',
							'shop_product_id' => 'multi-option',
						)
					),
					'ShopOrderProductPrice' => array(
						'cost' => '20.00000',
						'selling' => '25.00000',
						'retail' => '30.00000',
						'model' => 'Shop.ShopOrderProduct',
					),
					'ShopOrderProductSize' => array(
						'model' => null,
						'product_width' => null,
						'product_height' => null,
						'product_length' => null,
						'shipping_width' => null,
						'shipping_height' => null,
						'shipping_length' => null,
						'product_weight' => null,
						'shipping_weight' => null,
					)
				)
			)
		);
	}

	protected function _order1() {
		return array(
			'ShopOrder' => array(
				'id' => 'order-1',
				'invoice_number' => '00001',
				'shop_order_product_count' => '2',
				'ip_address' => '127.0.0.1',
				'total' => '72.000000',
				'tax' => '0.000000',
				'shipping' => '2.500000',
				'insurance' => '1.000000',
				'handling' => '10.000000',
				'previous_orders_count' => '0',
				'previous_orders_value' => null,
				'shop_order_status_id' => 'pending',
				'created' => '2013-01-08 15:22:12',
				'modified' => '2013-01-08 15:22:12'
			),
			'User' => array(
				'id' => 'bob',
				'username' => 'bob',
				'full_name' => 'bob bob',
				'prefered_name' => 'b. bob',
				'email' => 'bob@bob.com',
				'browser' => 'Chrome',
				'operating_system' => 'Linux',
				'last_login' => '2012-10-08 19:39:28',
				'last_click' => '2012-10-08 19:39:28',
			),
			'ShopBillingAddress' => array(
				'id' => null,
				'user_id' => null,
				'name' => null,
				'address_1' => null,
				'address_2' => null,
				'state_id' => null,
				'country_id' => null,
				'post_code' => null,
				'created' => null,
				'modified' => null,
			),
			'ShopShippingAddress' => array(
				'id' => null,
				'user_id' => null,
				'name' => null,
				'address_1' => null,
				'address_2' => null,
				'state_id' => null,
				'country_id' => null,
				'post_code' => null,
				'created' => null,
				'modified' => null,
			),
			'ShopPaymentMethod' => array(
				'id' => null,
				'name' => null,
			),
			'ShopShippingMethod' => array(
				'id' => null,
				'name' => null,
			),
			'ShopOrderStatus' => array(
				'id' => 'pending',
				'name' => 'pending',
			),
			'InfinitasPaymentLog' => array(
				'id' => null,
				'token' => null,
				'transaction_id' => null,
				'transaction_type' => null,
				'transaction_fee' => null,
				'raw_request' => false,
				'raw_response' => false,
				'transaction_date' => null,
				'currency_code' => null,
				'total' => null,
				'tax' => null,
				'custom' => null,
				'status' => null,
				'created' => null,
				'modified' => null,
			),
			'ShopOrderNote' => array(
				array(
					'id' => 'order-1-note-a',
					'shop_order_id' => 'order-1',
					'shop_order_status_id' => 'pending',
					'notes' => 'Order created',
					'user_notified' => 1,
					'created' => '2012-10-14 11:25:27'
				),
				array(
					'id' => 'order-1-note-c',
					'shop_order_id' => 'order-1',
					'shop_order_status_id' => 'shipped',
					'notes' => 'Shipped',
					'user_notified' => 1,
					'created' => '2012-10-14 11:25:27'
				)
			),
			'ShopOrderProduct' => array(
				array(
					'ShopProduct' => array(
						'id' => 'active',
						'name' => 'active',
						'slug' => 'active',
						'rating' => '1',
						'rating_count' => '1',
						'views' => '5',
						'sales' => '1',
						'active' => true,
						'total_variants' => '0',
						'price_max' => 0,
						'price_min' => 0,
						'shop_product_attribute_count' => '0',
					),
					'ShopProductType' => array(
						'id' => 'shirts',
						'name' => 'shirts',
						'slug' => 'shirts',
					),
					'ShopBrand' => array(
						'id' => 'inhouse',
						'name' => 'inhouse',
						'slug' => 'inhouse',
					),
					'ShopImage' => array(
						'id' => 'image-product-active',
						'image' => 'image-product-active.png',
						'image_full' => '/files/shop_image/image/image-product-active/image-product-active.png',
						'image_large' => '/files/shop_image/image/image-product-active/large_image-product-active.png',
						'image_medium' => '/files/shop_image/image/image-product-active/medium_image-product-active.png',
						'image_small' => '/files/shop_image/image/image-product-active/small_image-product-active.png',
						'image_thumb' => '/files/shop_image/image/image-product-active/thumb_image-product-active.png',
					),
					'ShopProductVariant' => array(
						'id' => 'variant-active-2',
						'shop_product_id' => 'active',
						'shop_image_id' => null,
						'master' => false,
						'created' => '2012-12-12 01:45:05',
						'modified' => '2012-12-12 01:45:05',
						'ShopProductVariantPrice' => array(
							'id' => 'variant-active-master',
							'cost' => '10.00000',
							'selling' => '12.00000',
							'retail' => '15.00000',
						),
						'ShopProductVariantSize' => array(
							'id' => 'product-active',
							'product_width' => '10.50000',
							'product_height' => '10.50000',
							'product_length' => '10.50000',
							'shipping_width' => '12.50000',
							'shipping_height' => '12.50000',
							'shipping_length' => '12.50000',
							'product_weight' => '500.00000',
							'shipping_weight' => '650.00000',
						)
					),
					'ShopOrderProduct' => array(
						'id' => 'order-1b',
						'shop_order_id' => 'order-1',
						'shop_product_variant_id' => 'variant-active-2',
						'shop_product_type_id' => 'shirts',
						'quantity' => '1.000',
						'name' => 'active',
						'brand' => 'inhouse',
						'shop_image_id' => 'image-product-active',
						'product_code' => '',
						'time_to_purchase' => '1500',
						'view_to_purchase' => '25',
					),
					'ShopCategory' => array(
						array(
							'id' => 'active',
							'name' => 'active',
							'slug' => 'active',
							'shop_product_id' => 'active',
						)
					),
					'ShopOrderProductPrice' => array(
						'id' => 'order-1b-price',
						'model' => 'Shop.ShopOrderProduct',
						'foreign_key' => 'order-1b',
						'cost' => '10.00000',
						'selling' => '12.00000',
						'retail' => '15.00000',
						'created' => '2012-10-05 10:04:09',
						'modified' => '2012-10-05 10:04:09'
					),
					'ShopOrderProductSize' => array(
						'id' => 'order-1b-size',
						'model' => 'Shop.ShopOrderProduct',
						'foreign_key' => 'order-1b',
						'product_width' => '10.50000',
						'product_height' => '10.50000',
						'product_length' => '10.50000',
						'shipping_width' => '12.50000',
						'shipping_height' => '12.50000',
						'shipping_length' => '12.50000',
						'product_weight' => '500.00000',
						'shipping_weight' => '650.00000',
					)
				),
				array(
					'ShopProduct' => array(
						'id' => 'active',
						'name' => 'active',
						'slug' => 'active',
						'rating' => '1',
						'rating_count' => '1',
						'views' => '5',
						'sales' => '1',
						'active' => true,
						'total_variants' => '1',
						'price_max' => 0,
						'price_min' => 0,
						'shop_product_attribute_count' => '0',
					),
					'ShopProductType' => array(
						'id' => 'shirts',
						'name' => 'shirts',
						'slug' => 'shirts',
					),
					'ShopBrand' => array(
						'id' => 'inhouse',
						'name' => 'inhouse',
						'slug' => 'inhouse',
					),
					'ShopImage' => array(
						'id' => 'image-product-active',
						'image' => 'image-product-active.png',
						'image_full' => '/files/shop_image/image/image-product-active/image-product-active.png',
						'image_large' => '/files/shop_image/image/image-product-active/large_image-product-active.png',
						'image_medium' => '/files/shop_image/image/image-product-active/medium_image-product-active.png',
						'image_small' => '/files/shop_image/image/image-product-active/small_image-product-active.png',
						'image_thumb' => '/files/shop_image/image/image-product-active/thumb_image-product-active.png',
					),
					'ShopProductVariant' => array(
						'id' => 'variant-active-1',
						'shop_product_id' => 'active',
						'shop_image_id' => null,
						'master' => false,
						'created' => '2012-12-12 01:45:05',
						'modified' => '2012-12-12 01:45:05',
						'ShopProductVariantPrice' => array(
							'id' => 'variant-active-master',
							'cost' => '10.00000',
							'selling' => '12.00000',
							'retail' => '15.00000',
						),
						'ShopProductVariantSize' => array(
							'id' => 'product-active',
							'product_width' => '10.50000',
							'product_height' => '10.50000',
							'product_length' => '10.50000',
							'shipping_width' => '12.50000',
							'shipping_height' => '12.50000',
							'shipping_length' => '12.50000',
							'product_weight' => '500.00000',
							'shipping_weight' => '650.00000',
						),
					),
					'ShopOrderProduct' => array(
						'id' => 'order-1a',
						'shop_order_id' => 'order-1',
						'shop_product_variant_id' => 'variant-active-1',
						'shop_product_type_id' => 'shirts',
						'quantity' => '5.000',
						'name' => 'active',
						'brand' => 'inhouse',
						'shop_image_id' => 'image-product-active',
						'product_code' => '',
						'time_to_purchase' => '2500',
						'view_to_purchase' => '10',
					),
					'ShopCategory' => array(
						array(
							'id' => 'active',
							'name' => 'active',
							'slug' => 'active',
							'shop_product_id' => 'active',
						)
					),
					'ShopOrderProductPrice' => array(
						'id' => 'order-1a-price',
						'model' => 'Shop.ShopOrderProduct',
						'foreign_key' => 'order-1a',
						'cost' => '10.00000',
						'selling' => '12.00000',
						'retail' => '15.00000',
						'created' => '2012-10-05 10:04:09',
						'modified' => '2012-10-05 10:04:09'
					),
					'ShopOrderProductSize' => array(
						'id' => 'order-1a-size',
						'model' => 'Shop.ShopOrderProduct',
						'foreign_key' => 'order-1a',
						'product_width' => '10.50000',
						'product_height' => '10.50000',
						'product_length' => '10.50000',
						'shipping_width' => '12.50000',
						'shipping_height' => '12.50000',
						'shipping_length' => '12.50000',
						'product_weight' => '500.00000',
						'shipping_weight' => '650.00000',
					)
				)
			)
		);
	}

}
