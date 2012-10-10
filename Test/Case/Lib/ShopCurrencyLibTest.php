<?php
App::uses('ShopCurrency', 'Shop.Model');
App::uses('ShopCurrencyLib', 'Shop.Lib');
class ShopCurrencyLibTest extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_currency',
		'plugin.shop.shop_payment_method_api'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		CakeSession::destroy();
		parent::tearDown();
	}

/**
 * @brief test get currency
 */
	public function testGetCurrency() {
		$expected = Configure::read('Shop.currency');
		$result = ShopCurrencyLib::getCurrency();
		$this->assertEquals($expected, $result);

		$expected = 'gbp';
		CakeSession::write('Shop.currency', $expected);
		$result = ShopCurrencyLib::getCurrency();
		$this->assertEquals($expected, $result);

		$expected = 'usd';
		CakeSession::write('Shop.currency', $expected);
		$result = ShopCurrencyLib::getCurrency();
		$this->assertEquals($expected, $result);
	}

/**
 * @brief test set currency
 * 
 * @dataProvider setCurrencyDataProvider
 */
	public function testSetCurrency($data, $expected) {
		ShopCurrencyLib::setCurrency($data);
		$result = CakeNumber::currency(1000, ShopCurrencyLib::getCurrency());
		$this->assertEquals($expected, $result);
		CakeSession::destroy();
	}

/**
 * @brief set currency data provider
 */
	public function setCurrencyDataProvider() {
		return array(
			array('gbp', '£1,000.00'),
			array('usd', '$1,000.00'),
			array('eur', '€1.000,000'),
		);
	}

/**
 * @brief test set currency invalid
 *
 * @expectedException CakeException
 */
	public function testSetCurrencyInvalid() {
		ShopCurrencyLib::setCurrency('invalid');
	}
}