<?php
class ShopEvents extends AppEvents {
/**
 * @brief get the plugins details
 * 
 * @return array
 */
	public function onPluginRollCall() {
		return array(
			'name' => 'Shop',
			'description' => 'Online eCommerce',
			'icon' => '/shop/img/icon.png',
			'author' => 'Infinitas',
			'dashboard' => array(
				'plugin' => 'shop',
				'controller' => 'shop',
				'action' => 'dashboard'
			)
		);
	}

/**
 * @brief the admin menu
 *
 * @param Event $event the Event
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
			'shop_payment_',
			'shop_shipping_'
		);

		$configuration = in_array($Event->Handler->request->params['controller'], $configControllers);
		foreach($configControllers as $controller) {
			if($configuration) {
				break;
			}
			$configuration = $configuration || strpos($Event->Handler->request->params['controller'], $controller) !== false;
		}
		if($configuration) {
			$menu['main']['Configuration'] = array('plugin' => 'shop', 'controller' => 'shop', 'action' => 'configuration');
		}

		return $menu;
	}

/**
 * @brief get the plugins configuration
 * 
 * @return array
 */
	public function onSetupCache() {
		return array(
			'name' => 'shop',
			'config' => array(
				'duration' => 3600,
				'probability' => 100,
				'prefix' => 'shop.',
				'lock' => false,
				'serialize' => true
			)
		);
	}

/**
 * @brief figure out a url slug
 * 
 * @param Event $event the Event
 * @param array $data the data used to build a url
 * 
 * @return array
 */
	public function onSlugUrl(Event $event, $data) {
		switch($data['type']) {
			case 'products':
				return array(
					'plugin' => 'shop',
					'controller' => 'products',
					'action' => $data['data']['action'],
					'id' => $data['data']['id'],
					'slug' => $data['data']['slug']
				);
				break;

			case 'categories':
				return array(
					'plugin' => 'shop',
					'controller' => 'shop_categories',
					'action' => $data['data']['action'],
					'id' => $data['data']['id'],
					'slug' => $data['data']['slug']
				);
				break;
		} // switch
	}

/**
 * @brief sort out the guest data once the user logs in
 * 
 * @param Event $event the event
 * @param array data passed in
 * 
 * @return array
 */
	public function onUserLogin(Event $event, $data) {

	}

/**
 * @brief get helpers that need loading
 * 
 * @return array
 */
	public function onRequireHelpersToLoad() {
		return array(
			'Shop.Shop'
		);
	}

/**
 * @brief get components that need loading
 * 
 * @return array
 */
	public function onRequireComponentsToLoad() {
		return array(
			'Shop.Shop'
		);
	}

/**
 * @brief get css that needs loading
 * 
 * @param Event $event the event
 * 
 * @return array
 */
	public function onRequireCssToLoad(Event $event) {
		if($event->Handler->request->params['admin'] || $event->Handler->request->params['plugin'] != 'shop') {
			return array(
				'Shop.shop_admin'
			);
		}

		return array(
			'Shop.shop'
		);
	}

/**
 * @brief get js that needs loading
 * 
 * @param Event $event the event
 * 
 * @return array
 */
	public function onRequireJavascriptToLoad(Event $event) {
		if($event->Handler->request->params['admin'] || $event->Handler->request->params['plugin'] != 'shop') {
			return array(
				'Shop.shop_admin'
			);
		}

		return array(
			'Shop.shop'
		);
	}
	
}