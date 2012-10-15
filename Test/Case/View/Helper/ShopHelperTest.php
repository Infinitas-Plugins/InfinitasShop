<?php
App::uses('View', 'View');
App::uses('Helper', 'View');
App::uses('ShopHelper', 'Shop.View/Helper');

/**
 * ShopHelper Test Case
 *
 */
class ShopHelperTest extends CakeTestCase {
	public $fixtures = array(
		'plugin.routes.route',
		'plugin.themes.theme'
	);
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$View = new View();
		$this->Shop = new ShopHelper($View);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Shop);

		parent::tearDown();
	}

/**
 * testEmailLink method
 *
 * @dataProvider emailLinkDataProvider
 */
	public function testEmailLink($data, $expected) {
		$result = $this->Shop->emailLink($data['email'], $data['icon'], $data['config']);
		$this->assertTags($result, $expected);
	}

/**
 * @brief email link data provider
 * 
 * @return array
 */
	public function emailLinkDataProvider() {
		return array(
			'icon' => array(
				array(
					'email' => 'bob@bob.com',
					'icon' => true,
					'config' => array()
				),
				array(
					array('a' => array('href' => 'mailto:bob@bob.com', 'title' => 'bob@bob.com', 'target' => '_blank')),
					array('img' => array('src' => '/emails/img/icon.png', 'width' => 24, 'alt' => 'Email')),
					'/a'
				)
			),
			'no-icon' => array(
				array(
					'email' => 'bob@bob.com',
					'icon' => false,
					'config' => array()
				),
				array(
					array('a' => array('href' => 'mailto:bob@bob.com', 'title' => 'bob@bob.com', 'target' => '_blank')),
					'bob@bob.com',
					'/a'
				)
			),
			'config' => array(
				array(
					'email' => 'bob@bob.com',
					'icon' => true,
					'config' => array(
						'target' => '_self',
						'title' => 'Awesome title'
					)
				),
				array(
					array('a' => array('href' => 'mailto:bob@bob.com', 'title' => 'Awesome title', 'target' => '_self')),
					array('img' => array('src' => '/emails/img/icon.png', 'width' => 24, 'alt' => 'Email')),
					'/a'
				)
			)
		);
	}

/**
 * @brief test time estimate
 *
 * @dataProvider timeEstimateDataProvider
 */
	public function testTimeEstimate($data, $expected) {
		$result = $this->Shop->timeEstimate($data);
		$this->assertEquals($expected, $result);
	}

/**
 * @brief time estimate data porvider
 * 
 * @return array
 */
	public function timeEstimateDataProvider() {
		return array(
			'hours-1' => array(1, '1 hour'),
			'hours-20' => array(20, '20 hours'),
			'hours-25' => array(25, '1 day'),
			'hours-100' => array(100, '4 days'),
			'hours-200' => array(200, '1 week'),
			'hours-400' => array(400, '2 weeks'),
			'hours-1000' => array(1000, '6 weeks'),
			'hours-1500' => array(1500, '2 months'),
		);
	}

/**
 * @brief test admin currency
 *
 * @dataProvider adminCurrencyDataProvider
 */
	public function testAdminCurrency($data, $expected) {
		$result = $this->Shop->adminCurrency($data);
		$this->assertEquals($expected, $result);
	}

/**
 * @brief admin currency data provider
 * 
 * @return array
 */
	public function adminCurrencyDataProvider() {
		return array(
			'penny' => array(.1, '10p'),
			'pound' => array(1, '&#163;1.00'),
			'high' => array(1234.56, '&#163;1,234.56'),
			'neg' => array(-123.999, '(&#163;124.00)')
		);
	}

/**
 * @brief test stock value
 *
 * @dataProvider stockValueDataProvider
 */
	public function testStockValue($data, $expected) {
		$result = $this->Shop->stockValue($data['quantity'], $data['price']);
		$this->assertTags($result, $expected);
	}

/**
 * @brief stock value data provider
 * 
 * @return array
 */
	public function stockValueDataProvider() {
		return array(
			'normal' => array(
				array(
					'quantity' => 10,
					'price' => 10
				),
				array(
					array('div' => array('class' => 'stock-value')),
						array('span' => array('class' => 'quantity')),
							10,
						'/span',
						array('span' => array('class' => 'value')),
							'&#163;100.00',
						'/span',
					'/div'
				)
			),
			'negative-stock' => array(
				array(
					'quantity' => -10,
					'price' => 10
				),
				array(
					array('div' => array('class' => 'stock-value')),
						array('span' => array('class' => 'quantity')),
							-10,
						'/span',
						array('span' => array('class' => 'value')),
							'&#163;0.00',
						'/span',
					'/div'
				)
			),
			'null-price' => array(
				array(
					'quantity' => 10,
					'price' => null
				),
				array(
					array('div' => array('class' => 'stock-value')),
						array('span' => array('class' => 'quantity')),
							10,
						'/span',
						array('span' => array('class' => 'value')),
							'&#163;0.00',
						'/span',
					'/div'
				)
			)
		);
	}

/**
 * @brief test currency
 * 
 * @dataProvider currencyDataProvider
 */
	public function testCurrency($data, $expected) {

	}

/**
 * @brief currency data provider 
 * 
 * @return array
 */
	public function currencyDataProvider() {
		return array(
			array(
				'',
				''
			)
		);
	}

/**
 * @brief test admin status
 * 
 * @dataProvider adminStatusDataProvider
 */
	public function testAdminStatus($data, $expected) {

	}

	public function adminStatusDataProvider() {
		$product = array(
			'ShopProduct' => array(
				'id' => 'active',
				'name' => 'active',
				'slug' => 'active',
				'rating' => '1',
				'rating_count' => '1',
				'views' => '5',
				'sales' => '1',
				'active' => true,
				'modified' => '2012-10-05 01:14:47',
				'available' => '2012-10-05 01:14:47',
				'category_active' => true,
				'total_stock' => '25',
			),
			'ShopProductType' => array(
				'id' => 'shirts',
				'name' => 'shirts',
				'slug' => 'shirts',
				'active' => true,
			),
			'ShopBrand' => array(
				'id' => 'inhouse',
				'name' => 'inhouse',
				'slug' => 'inhouse',
				'active' => true,
			),
			'ShopImage' => array(
				'id' => 'image-product-active',
				'image' => 'image-product-active.png',
			),
			'ShopPrice' => array(
				'id' => 'active',
				'selling' => '12.00000',
				'retail' => '15.00000',
				'cost' => '10.00000',
			),
			'ShopSupplier' => array(
				'id' => 'supplier-1',
				'name' => 'supplier-1',
				'active' => true,
			),
			'ShopCategory' => array(
				array(
					'id' => 'active',
					'name' => 'active',
					'slug' => 'active',
					'shop_product_id' => 'active',
				),
			),
			'ShopSpecial' => array(),
			'ShopSpotlight' => array(),
			'ShopOption' => array(
				array(
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
							'shop_option_id' => 'option-size',
							'product_code' => 'l',
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
								'shipping_weight' => '65.00000',
							),
						),
						array(
							'id' => 'option-size-medium',
							'name' => 'option-size-medium',
							'description' => 'some text about option-size-medium',
							'shop_option_id' => 'option-size',
							'product_code' => 'm',
							'ShopPrice' => array(
								'id' => NULL,
								'selling' => NULL,
								'retail' => NULL,
							),
							'ShopSize' => array(
								'id' => NULL,
								'model' => NULL,
								'foreign_key' => NULL,
								'product_width' => NULL,
								'product_height' => NULL,
								'product_length' => NULL,
								'shipping_width' => NULL,
								'shipping_height' => NULL,
								'shipping_length' => NULL,
								'product_weight' => NULL,
								'shipping_weight' => NULL,
							),
						),
						array(
							'id' => 'option-size-small',
							'name' => 'option-size-small',
							'description' => 'some text about option-size-small',
							'shop_option_id' => 'option-size',
							'product_code' => 's',
							'ShopPrice' => array(
								'id' => NULL,
								'selling' => NULL,
								'retail' => NULL,
							),
							'ShopSize' => array(
								'id' => NULL,
								'model' => NULL,
								'foreign_key' => NULL,
								'product_width' => NULL,
								'product_height' => NULL,
								'product_length' => NULL,
								'shipping_width' => NULL,
								'shipping_height' => NULL,
								'shipping_length' => NULL,
								'product_weight' => NULL,
								'shipping_weight' => NULL,
							),
						)
					)
				)
			)
		);
		return array(
			array(
				'',
				''
			)
		);
	}

/**
 * @brief test admin price
 * 
 * @dataProvider adminPriceDataProvider
 */
	public function testAdminPrice($data, $expected) {
		$result = $this->Shop->adminPrice($data);
		$this->assertTags($result, $expected);
	}

/**
 * @brief admin price data provider
 * 
 * @return array
 */
	public function adminPriceDataProvider() {
		return array(
			array(
				array(
					'selling' => '12.00000',
					'retail' => '15.00000',
					'cost' => '10.00000',
				),
				array(
					array('div' => array('class' => 'price')),
						array('span' => array(
							'class' => 'cost', 
							'title' => 'Price :: &lt;ul  &gt;&lt;li &gt;Cost: &amp;#163;10.00&lt;/li&gt;&lt;li ' .
								'&gt;Selling: &amp;#163;12.00&lt;/li&gt;&lt;li &gt;Markup: 2 (20)&lt;/li&gt;&lt;li ' . 
								'&gt;Retail: &amp;#163;15.00&lt;/li&gt;&lt;/ul&gt;'
						)),
							'&#163;10.00',
						'/span',
						array('span' => array('class' => 'selling')),
							'&#163;12.00',
						'/span',
					'/div'
				)
			)
		);
	}

/**
 * @brief test admin markup
 * 
 * @dataProvider adminMarkupDataProvider
 */
	public function testAdminMarkup($data, $expected) {
		$result = $this->Shop->adminMarkup($data['price'], $data['%']);
		$this->assertTags($result, $expected);
	}

/**
 * @brief admin markup data provider
 * 
 * @return array
 */
	public function adminMarkupDataProvider() {
		return array(
			'normal' => array(
				array(
					'price' => array(
						'selling' => '12.00000',
						'cost' => '10.00000',
					),
					'%' => false
				),
				array(
					array('div' => array('class' => 'markup')),
						array('span' => array('class' => 'amount')),
							'&#163;2.00',
						'/span',
						array('span' => array('class' => 'percentage')),
							'20.00%',
						'/span',
					'/div'
				)
			),
			'negative-markup' => array(
				array(
					'price' => array(
						'selling' => '10.00000',
						'cost' => '12.00000',
					),
					'%' => false
				),
				array(
					array('div' => array('class' => 'markup')),
						array('span' => array('class' => 'amount')),
							'(&#163;2.00)',
						'/span',
						array('span' => array('class' => 'percentage')),
							'-16.67%',
						'/span',
					'/div'
				)
			),
			'even' => array(
				array(
					'price' => array(
						'selling' => '10.00000',
						'cost' => '10.00000',
					),
					'%' => false
				),
				array(
					array('div' => array('class' => 'markup')),
						array('span' => array('class' => 'amount')),
							'&#163;0.00',
						'/span',
						array('span' => array('class' => 'percentage')),
							'0.00%',
						'/span',
					'/div'
				)
			)
		);
	}

}
