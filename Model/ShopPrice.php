<?php
/**
 * ShopPrice Model
 */

class ShopPrice extends ShopAppModel {

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
	);

/**
 * Get the fields for finds
 *
 * @return array
 */
	public function findFields($alias = null) {
		return array(
			$this->fullFieldName($this->primaryKey, $alias),
			$this->fullFieldName('cost', $alias),
			$this->fullFieldName('selling', $alias),
			$this->fullFieldName('retail', $alias)
		);
	}
}