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

}
