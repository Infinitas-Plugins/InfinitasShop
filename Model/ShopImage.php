<?php
/**
 * ShopImage Model
 *
 * @property ShopCategory $ShopCategory
 * @property ShopProduct $ShopProduct
 * @property ShopSpecial $ShopSpecial
 * @property ShopSpotlight $ShopSpotlight
 */

class ShopImage extends ShopAppModel {

/**
 * display field
 *
 * @var string
 */
	public $displayField = 'image';

/**
 * behaviors that are attached
 *
 * @var array
 */
	public $actsAs = array(
		'Filemanager.Upload' => array(
			'image' => array(
				'thumbnailSizes' => array(
					'large' => '1000l',
					'medium' => '600l',
					'small' => '300l',
					'thumb' => '75l'
				)
			)
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ShopCategory' => array(
			'className' => 'Shop.ShopCategory',
			'foreignKey' => 'shop_image_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ShopProduct' => array(
			'className' => 'Shop.ShopProduct',
			'foreignKey' => 'shop_image_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ShopSpecial' => array(
			'className' => 'Shop.ShopSpecial',
			'foreignKey' => 'shop_image_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ShopSpotlight' => array(
			'className' => 'Shop.ShopSpotlight',
			'foreignKey' => 'shop_image_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

/**
 * Constructor
 *
 * @param type $id
 * @param type $table
 * @param type $ds
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(

		);
	}

	public function afterFind($results, $primary = false) {
		$noImage = $this->emptyFilePath();
		$sizes = $this->uploadImageSizes('image');

		foreach ($results as &$result) {
			if (empty($result[$this->alias]) || !array_key_exists($this->displayField, $result[$this->alias])) {
				continue;
			}

			$result[$this->alias][$this->displayField . '_full'] = $this->uploadImageUrl(
				$this->displayField,
				$result[$this->alias][$this->primaryKey],
				$result[$this->alias][$this->displayField]
			);

			foreach ($sizes as $size) {
				$result[$this->alias][$this->displayField . '_' . $size] = $this->uploadImageUrl(
					$this->displayField,
					$result[$this->alias][$this->primaryKey],
					$result[$this->alias][$this->displayField],
					$size
				);
			}
		}

		return $results;
	}
}