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

		return parent::beforeRender($Controller);
	}
}