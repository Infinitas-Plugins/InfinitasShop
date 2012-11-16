<?php
App::uses('InfinitasComponent', 'Libs.Controller/Component');
App::uses('ShopCurrencyLib', 'Shop.Lib');

class ShopComponent extends InfinitasComponent {
/**
 * @brief load up required variables for the store
 *
 * @param Controller $Controller the controller being run
 *
 * @return boolean
 */
	public function beforeRender(Controller $Controller) {
		if(isset($Controller->request->params['admin']) && $Controller->request->params['admin']) {
			return parent::beforeRender($Controller);
		}
		if(!$Controller->Session->read('Shop.Guest.id')) {
			CakeSession::write('Shop.Guest.id', String::uuid());
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
		$Controller->set(compact('shopCurrencies', 'shopCategoriesNav', 'shopBrandsList'));

		$this->_moduleData($Controller);

		return parent::beforeRender($Controller);
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
		if($Controller->request->category) {
			$category = $Controller->request->category;
		}
		$shopFilterOptions = $ShopProduct->find('possibleOptions', array(
			'category' => $category
		));

		//$shopRelatedCategories = $ShopProduct->ShopCategoriesProduct->ShopCategory->find('all');

		$Controller->set(compact('shopRecentlyViewed', 'shopNewProducts', 'shopPopularProducts', 'shopRelatedCategories', 'shopFilterOptions'));
	}
}