<?php
/**
 * ContentsEventsTest
 *
 * These tests are extended from InfinitasEventTestCase which does most of the
 * automated testing for simple events
 */

App::uses('InfinitasEventTestCase', 'Events.Test/Lib');

class ShopEventsTest extends InfinitasEventTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_list',
		'plugin.management.ticket',
		'plugin.users.user'
	);

	public function testRequireCss() {
	}

	public function testRequireJs() {
	}

	public function testAdminMenu() {
	}

/**
 * Test lists are moved to user account on login
 */
	public function testUserLogin() {
		$ShopList = ClassRegistry::init('Shop.ShopList');

		CakeSession::write('Shop.Guest.id', 'guest-1');
		$expected = array(
			'shop-list-guest-1-cart'
		);
		$results = Hash::extract($ShopList->find('mine'), '{n}.ShopList.id');
		$this->assertEquals($expected, $results);

		CakeSession::write('Auth.User.id', 'bob');
		EventCore::trigger($this, 'Shop.userLogin', array('id' => 'bob'));
		$expected = array(
			'shop-list-bob-cart',
			'shop-list-bob-wish',
			'shop-list-guest-1-cart',
		);
		$results = Hash::extract($ShopList->find('mine'), '{n}.ShopList.id');
		$this->assertEquals($expected, $results);

	}
}