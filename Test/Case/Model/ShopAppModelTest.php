<?php
App::uses('ShopList', 'Shop.Model');

/**
 * ShopList Test Case
 *
 */
class ShopAppModelTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_list',
		'plugin.shop.core_user',
		'plugin.shop.core_group',
		'plugin.shop.shop_shipping_method',
		'plugin.shop.shop_payment_method',
		'plugin.shop.shop_list_product_option',
		'plugin.shop.shop_list_product'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopList = ClassRegistry::init('Shop.ShopList');
		$this->modelClass = $this->ShopList->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopList);

		parent::tearDown();
	}

/**
 * @brief test current user id
 */
	public function testCurrentUserId() {
		$result = $this->{$this->modelClass}->currentUserId();
		$this->assertNull($result);

		$guestId = String::uuid();
		CakeSession::write('Shop.Guest.id', $guestId);

		$result = $this->{$this->modelClass}->currentUserId();
		$this->assertEquals($guestId, $result);

		$userId = String::uuid();
		CakeSession::write('Auth.User.id', $userId);

		$result = $this->{$this->modelClass}->currentUserId();
		$this->assertEquals($userId, $result);

		$result = CakeSession::read();
		unset($result['Config']);
		$expected = array(
			'Shop' => array(
				'Guest' => array(
					'id' => $guestId
				)
			),
			'Auth' => array(
				'User' => array(
					'id' => $userId
				)
			)
		);
		$this->assertEquals($expected, $result);
	}

}
