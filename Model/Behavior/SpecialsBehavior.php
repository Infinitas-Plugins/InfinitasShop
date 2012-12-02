<?php
class SpecialsBehavior extends ModelBehavior {
/**
 * Map methods for custom find methods
 *
 * @var array
 */
	public $mapMethods = array(
		'/\b_findPossibleSpecials\b/' => '_findPossibleSpecials'
	);

/**
 * configure the model to use this behavior
 *
 * @param ShopProduct $Model the product model
 * @param array $config the options for the behavior
 *
 * @return void
 */
	public function setup(Model $Model, $config = array()) {
		$Model->findMethods = array_merge(array('possibleSpecials' => true), $Model->findMethods);
	}

/**
 * find possible specials
 *
 * Find good products for creating specials with. This will consider things such as
 * products with good markup and low conversion rates that are not already on special.
 *
 * @param ShopProduct $Model the product model
 * @param string $method the method being called
 * @param string $state the state of the find (before / after)
 * @param array $query the query being performed
 * @param array $results the results from the find
 *
 * @return array
 */
	public function _findPossibleSpecials(ShopProduct $Model, $method, $state, $query, $results = array()) {
		if ($state == 'before') {
			$query['fields'] = array_merge((array)$query['fields'], array(
				$Model->alias . '.' . $Model->primaryKey,
				$Model->alias . '.' . $Model->displayField,
				'conversion_rate',
				'markup_percentage',
				$Model->ShopPrice->alias . '.cost',
				$Model->ShopPrice->alias . '.selling',
			));

			$query['conditions'] = array_merge((array)$query['conditions'], array(
				'ShopProductsSpecial.id IS NULL',
				'conversion_rate < ' => 100,
				'markup_percentage > ' => 0
			));

			$query['joins'][] = $Model->autoJoinModel(array(
				'model' => $Model->ShopProductsSpecial->fullModelName(),
				'conditions' => array(
					'ShopProductsSpecial.shop_product_id = ShopProduct.id',
				)
			));

			$query['joins'][] = $Model->autoJoinModel($Model->ShopPrice->fullModelName());

			$query['order'] = array(
				'conversion_rate' => 'asc'
			);

			return $query;
		}

		return $results;
	}
}