<?php
class ShopEvents extends AppEvents {

/**
 * get the plugins details
 *
 * @return array
 */
	public function onPluginRollCall(Event $Event) {
		return array(
			'name' => 'Shop',
			'description' => 'Online eCommerce',
			'icon' => 'shopping-cart',
			'author' => 'Infinitas',
			'dashboard' => array(
				'plugin' => 'shop',
				'controller' => 'shop',
				'action' => 'dashboard'
			)
		);
	}

/**
 * the admin menu
 *
 * @param Event $Event the Event
 *
 * @return array
 */
	public function onAdminMenu(Event $Event) {
		$menu['main'] = array(
			'Dashboard' => array('plugin' => 'shop', 'controller' => 'shop', 'action' => 'dashboard'),
		);
		$configControllers = array(
			'shop_product_types',
			'shop_options',
			'shop_attributes',
			'shop_currencies',
			'shop_images',
			'shop_downloads',
			'shop_branches',
			'shop_suppliers',
			'shop_payment_',
			'shop_shipping_',
			'shop_order_statuses'
		);

		$configuration = in_array($Event->Handler->request->params['controller'], $configControllers);
		foreach ($configControllers as $controller) {
			if ($configuration) {
				break;
			}
			$configuration = $configuration || strpos($Event->Handler->request->params['controller'], $controller) !== false;
		}
		if ($configuration) {
			$menu['main']['Configuration'] = array('plugin' => 'shop', 'controller' => 'shop', 'action' => 'configuration');
		}

		return $menu;
	}

/**
 * figure out a url slug
 *
 * @param Event $Event the Event
 * @param array $data the data used to build a url
 *
 * @return array
 */
	public function onSlugUrl(Event $Event, $data = null, $type = null) {
		switch($data['type']) {
			case 'products':
				return array(
					'plugin' => 'shop',
					'controller' => 'products',
					'action' => $data['data']['action'],
					'id' => $data['data']['id'],
					'slug' => $data['data']['slug']
				);

			case 'categories':
				return array(
					'plugin' => 'shop',
					'controller' => 'shop_categories',
					'action' => $data['data']['action'],
					'id' => $data['data']['id'],
					'slug' => $data['data']['slug']
				);
		}
	}

/**
 * sort out the guest data once the user logs in
 *
 * @param Event $Event the event
 * @param array data passed in
 *
 * @return array
 */
	public function onUserLogin(Event $Event, array $currentUser) {
		ClassRegistry::init('Shop.ShopList')->guestToUser();
	}

/**
 * get helpers that need loading
 *
 * @return array
 */
	public function onRequireHelpersToLoad(Event $Event) {
		return array(
			'Shop.Shop'
		);
	}

/**
 * get components that need loading
 *
 * @return array
 */
	public function onRequireComponentsToLoad(Event $Event) {
		return array(
			'Shop.Shop'
		);
	}

/**
 * attach behaviors
 *
 * @param Event $Event
 */
	public function onAttachBehaviors(Event $Event) {
		if ($Event->Handler->shouldAutoAttachBehavior()) {
			if ($Event->Handler instanceof ShopProduct) {
				$Event->Handler->Behaviors->attach('Shop.Specials');
			}
		}
	}

/**
 * get css that needs loading
 *
 * @param Event $Event the event
 *
 * @return array
 */
	public function onRequireCssToLoad(Event $Event) {
		if ($Event->Handler->request->params['admin'] || $Event->Handler->request->params['plugin'] != 'shop') {
			return array(
				'Shop.shop_admin'
			);
		}

		return array(
			'Shop.shop'
		);
	}

/**
 * get js that needs loading
 *
 * @param Event $Event the event
 *
 * @return array
 */
	public function onRequireJavascriptToLoad(Event $Event) {
		if ($Event->Handler->request->params['admin'] || $Event->Handler->request->params['plugin'] != 'shop') {
			return array(
				'Shop.shop_admin'
			);
		}

		return array(
			'Shop.shop'
		);
	}

/**
 * update the currency conversions
 *
 * @param Event $Event the event being run
 */
	public function onRunCrons(Event $Event) {
		ClassRegistry::init('Shop.ShopCurrency')->updateCurrencies();
	}

	public function onRouteParse(Event $Event, $data = null) {
		if ($data['plugin'] != 'shop') {
			return false;
		}
		$shopAdmin = !empty($data['prefix']) && $data['prefix'] == 'admin';
		if ($shopAdmin) {
			return $data;
		}

		$controllers = array(
			'shop_products'
		);
		if (!in_array($data['controller'], $controllers)) {
			return $data;
		}

		$ShopProduct = ClassRegistry::init('Shop.ShopProduct');
		if ($data['controller'] == 'shop_products' && !empty($data['slug'])) {
			$count = $ShopProduct->find('count', array(
				'conditions' => array(
					$ShopProduct->alias . '.slug' => $data['slug'],
					$ShopProduct->alias . '.active' => 1,
				)
			));

			if (!$count) {
				return false;
			}
		}

		$ShopCategory = ClassRegistry::init('Shop.ShopCategory');
		if ($data['controller'] == 'shop_products' && !empty($data['category'])) {
			$count = $ShopCategory->find('count', array(
				'conditions' => array(
					$ShopCategory->alias . '.slug' => $data['category'],
					$ShopCategory->alias . '.active' => 1,
				)
			));

			if (!$count) {
				return false;
			}
		}

		return $data;
	}

/**
 * get tracking variables
 *
 * @param Event $Event the event being triggered
 *
 * @return array
 */
	public function onTrackingVariables(Event $Event) {
		$return = array();

		$guestId = CakeSession::read('Shop.Guest.id');
		if ($guestId) {
			$return[] = array(
				'name' => 'guestId',
				'value' => $guestId,
				'scope' => 'visit'
			);
		}

		if ($Event->Handler->request->params['plugin'] !== 'shop') {
			return $return;
		}

		$return[] = array(
			'name' => 'currency',
			'value' => ShopCurrencyLib::getCurrency(),
			'scope' => 'visit'
		);

		$return[] = array(
			'name' => 'listId',
			'value' => ClassRegistry::init('Shop.ShopList')->currentListId(true),
			'scope' => 'page'
		);

		if (!empty($Event->Handler->request->category)) {
			if (!empty($Event->Handler->request->slug)) {
				$return[] = array(
					'name' => 'product',
					'value' => $Event->Handler->request->slug,
					'scope' => 'page'
				);
			}
			$return[] = array(
				'name' => 'category',
				'value' => $Event->Handler->request->category,
				'scope' => 'page'
			);
		}

		return $return;
	}

	public function onUserProfile(Event $Event, $user) {
		$View = $Event->Handler->_View;
		$return = array(
			array(
				'title' => __d('shop', 'Products Viewed'),
				'content' => ''
			)
		);

		$shopLists = ClassRegistry::init('Shop.ShopList')->find('mine');
		if (!empty($shopLists)) {
			$return[] = array(
				'title' => __d('shop', 'Shopping Lists'),
				'content' => $View->element('Shop.profile/shop_lists', array(
					'shopLists' => $shopLists
				))
			);
		}

		$shopOrders = ClassRegistry::init('Shop.ShopOrder')->find('mine', array(
			'limit' => 5
		));
		if (!empty($shopOrders)) {
			$return[] = array(
				'title' => __d('shop', 'Recent orders'),
				'content' => $View->element('Shop.profile/shop_orders', array(
					'shopOrders' => $shopOrders
				))
			);
		}

		$return[] = array(
			'title' => __d('shop', 'Addresses'),
			'content' => $View->element('Shop.profile/shop_addresses', array(
				'shopAddresses' => ClassRegistry::init('Shop.ShopAddress')->find('mine')
			))
		);

		return $return;
	}

	public function onPaymentCompleted(Event $Event, array $data) {
		$ShopList = ClassRegistry::init('Shop.ShopList');
		if (!$ShopList->validateOrder($data['order']['custom'], $data)) {
			return false;
		}

		$order = $ShopList->ShopListProduct->ShopProductVariant->ShopOrderProduct->ShopOrder->orderFromList($data['order']['custom'], array(
			'infinitas_payment_log_id' => $data['order']['infinitas_payment_log_id']
		));
		if (!$order) {
			return false;
		}

		// send email

		return $order;
	}

	public function onPaymentCanceled(Event $Event, array $data) {
		pr($details);
		// redirect to error page
	}

}