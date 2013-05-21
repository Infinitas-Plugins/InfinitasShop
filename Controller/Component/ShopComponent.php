<?php
App::uses('InfinitasComponent', 'Libs.Controller/Component');
App::uses('ShopCurrencyLib', 'Shop.Lib');

/**
 * @property CookieComponent $Cookie
 */
class ShopComponent extends InfinitasComponent {

/**
 * BeforeFilter callback
 *
 * Check if the use existed previously and load the cookie data so thier cart will be available
 *
 * @return void
 */
	public function startup(Controller $Controller) {
		parent::startup($Controller);
		if (!AuthComponent::user('id')) {
			$this->_getGuest($Controller);
		}
	}

/**
 * load up required variables for the store
 *
 * @param Controller $Controller the controller being run
 *
 * @return boolean
 */
	public function beforeRender(Controller $Controller) {
		if (isset($Controller->request->params['admin']) && $Controller->request->params['admin']) {
			return parent::beforeRender($Controller);
		}
		if ($Controller->request->params['controller'] == 'shop_products') {
			$shopConnectedAttributes = ClassRegistry::init('Shop.ShopProduct')->find('availableAttributes', array(
				'category' => !empty($Controller->request->params['category']) ? $Controller->request->params['category'] : null,
				'product' => !empty($Controller->request->params['slug']) ? $Controller->request->params['slug'] : null,
				'named' => $Controller->request->params['named']
			));
			$shopConnectedColours = ClassRegistry::init('Shop.ShopProduct')->find('availableColours', array(
				'category' => !empty($Controller->request->params['category']) ? $Controller->request->params['category'] : null,
				'product' => !empty($Controller->request->params['slug']) ? $Controller->request->params['slug'] : null,
				'named' => $Controller->request->params['named']
			));
			$shopConnectedAttributes = array_merge($shopConnectedAttributes, $shopConnectedColours);
		}

		$shopCurrencies = ClassRegistry::init('Shop.ShopCurrency')->find('switch');
		$shopCategoriesNav = ClassRegistry::init('Shop.ShopCategory')->find('threaded', array(
			'fields' => array(
				'ShopCategory.id',
				'ShopCategory.name',
				'ShopCategory.slug',
				'ShopCategory.parent_id',
				'ShopCategory.lft',
				'ShopCategory.rght',
				'ShopCategory.shop_product_count'
			),
			'conditions' => array(
				'ShopCategory.active' => 1
			)
		));
		$shopBrandsList = ClassRegistry::init('Shop.ShopBrand')->find('brands');
		$shopListOverview = ClassRegistry::init('Shop.ShopList')->find('overview');
		$Controller->set(compact('shopConnectedAttributes', 'shopCurrencies', 'shopCategoriesNav', 'shopBrandsList', 'shopListOverview'));

		$this->_moduleData($Controller);

		return parent::beforeRender($Controller);
	}

/**
 * Get the guests details
 *
 * Check if the guest has a session id, if not check the cookie for a past id. If there is no cookie
 * details an id is generated and saved to a cookie and session.
 *
 * If there is a cookie that is set to the session for eash access.
 *
 * @param Controller $Controller
 *
 * @return boolean
 */
	protected function _getGuest(Controller $Controller) {
		if ($Controller->Session->read('Shop.Guest.id')) {
			return true;
		}

		if (!$Controller->Cookie instanceof CookieComponent) {
			$Controller->Cookie = $Controller->Components->load('Cookie');

			foreach ((array)Configure::read('Security.Cookie') as $k => $v) {
				$Controller->Cookie->{$k} = $v;
			}
		}

		$guest = $Controller->Cookie->read('Guest');
		if (empty($guest['id'])) {
			$guest['id'] = String::uuid();
		}

		$Controller->Session->write('Shop.Guest.id', $guest['id']);
		$Controller->Cookie->write('Guest', array(
			'id' => $guest['id'],
			'created' => time()
		), true, '1 year');
		return true;
	}

	protected function _moduleData(Controller $Controller) {
		$ShopProduct = ClassRegistry::init('Shop.ShopProduct');

		$shopRecentlyViewed = $ShopProduct->find('recentlyViewed', array(
			'limit' => 5
		));
		$shopNewProducts = $ShopProduct->find('new', array(
			'limit' => 5
		));
		$shopPopularProducts = $ShopProduct->find('mostViewed', array(
			'limit' => 5
		));

		$category = null;
		if ($Controller->request->category) {
			$category = $Controller->request->category;
		}
		//$shopFilterOptions = $ShopProduct->find('possibleOptions', array('category' => $category));

		//$shopRelatedCategories = $ShopProduct->ShopCategoriesProduct->ShopCategory->find('all');

		$Controller->set(compact('shopRecentlyViewed', 'shopNewProducts', 'shopPopularProducts', 'shopRelatedCategories', 'shopFilterOptions'));
	}
}