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
		'plugin.shop.shop_list_product',
		'plugin.management.ticket'
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

/**
 * @brief test is guest
 *
 * @param type $data
 * @param type $expected
 *
 * @dataProvider isGuestDataProvider
 */
	public function testIsGuest($data, $expected) {
		CakeSession::write('Shop.Guest.id', $data['guest_id']);
		CakeSession::write('Auth.User.id', $data['user_id']);

		$result = $this->{$this->modelClass}->isGuest($data);
		$this->assertEquals($expected, $result);
	}

/**
 * @brief is guest data provider
 *
 * @return array
 */
	public function isGuestDataProvider() {
		return array(
			'nothing' => array(
				array(
					'user_id' => null,
					'guest_id' => null
				),
				true
			),
			'guest' => array(
				array(
					'user_id' => null,
					'guest_id' => 'guest-1'
				),
				true
			),
			'user' => array(
				array(
					'user_id' => 'bob',
					'guest_id' => null
				),
				false
			),
			'both' => array(
				array(
					'user_id' => 'bob',
					'guest_id' => 'guest-1'
				),
				false
			)
		);
	}

}
