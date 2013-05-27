<?php
App::uses('ShopAddress', 'Shop.Model');

/**
 * ShopAddress Test Case
 *
 */
class ShopAddressTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_address',
		'plugin.shop.core_user',
		'plugin.shop.core_group',
		'plugin.geo_location.geo_location_country',
		'plugin.geo_location.geo_location_region'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Model = ClassRegistry::init('Shop.ShopAddress');
		CakeSession::destroy();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Model);

		parent::tearDown();
		CakeSession::destroy();
	}

/**
 * test find addresses
 *
 * @dataProvider findAddressesDataProvider
 */
	public function testFindAddresses($data, $expected) {
		CakeSession::write('Auth.User.id', $data);
		$result = $this->Model->find('addresses');
		$this->assertEquals($expected, $result);
	}

	public function findAddressesDataProvider() {
		return array(
			'bob' => array(
				'bob',
				array(
					array(
						'ShopAddress' => array(
							'id' => 'bob-address-home',
							'name' => 'Home',
							'address_1' => 'line 1',
							'address_2' => 'line 2',
							'post_code' => 'abc123',
							'billing' => true,
							'modified' => '2013-01-09 00:08:57',
							'country' => 'UK',
							'region' => 'uk1',
						)
					),
					array(
						'ShopAddress' => array(
							'id' => 'bob-address-work',
							'name' => 'Work',
							'address_1' => 'line 1',
							'address_2' => 'line 2',
							'post_code' => 'xyz987',
							'billing' => false,
							'modified' => '2013-01-09 00:08:57',
							'country' => 'UK',
							'region' => 'uk1',
						)
					),
				)
			),
			'sally' => array(
				'sally',
				array(
					array(
						'ShopAddress' => array(
							'id' => 'sally-address',
							'name' => 'sally',
							'address_1' => 'line 1',
							'address_2' => 'line 2',
							'post_code' => 'xyz987',
							'billing' => false,
							'modified' => '2013-01-09 00:08:57',
							'country' => 'inactive',
							'region' => 'uk2',

						)
					),
				)
			)
		);
	}

/**
 * test countries
 */
	public function testCountries() {
		$expected = array(
			'Main' => array(1 => 'UK'),
			'All' => array(2 => 'GB', 1 => 'UK')
		);
		$result = $this->Model->countries();
		$this->assertEquals($expected, $result);

		$this->Model->GeoLocationCountry->updateAll(array(
			'GeoLocationCountry.main' => 0
		));
		$result = $this->Model->countries();
		$this->assertEquals($expected['All'], $result);
	}

/**
 * test regions
 */
	public function testRegions() {
		$expected = array(
			1 => 'uk1'
		);
		$result = $this->Model->regions(1);
		$this->assertEquals($expected, $result);

		$expected = array(
			3 => 'gb1'
		);
		$result = $this->Model->regions(2);
		$this->assertEquals($expected, $result);

		$expected = array();
		$result = $this->Model->regions(3);
		$this->assertEquals($expected, $result);
	}

}
