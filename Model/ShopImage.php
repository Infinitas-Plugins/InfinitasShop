<?php
	class ShopImage extends ShopAppModel {
		public $virtualFields = array(
			'full_path' => 'CONCAT("/infinitas/img/content/shop/global/", Image.image)'
		);

		public $displayField = 'image';

		public $order = array(
			'Image.image' => 'ASC'
		);

		public $hasMany = array(
			'Category' => array(
				'className' => 'Shop.ShopCategory'
			)
		);

		public function getImagePaths() {
			$images = Cache::read('images', 'shop');
			if($images !== false) {
				return $images;
			}

			$images = $this->find(
				'list',
				array(
					'fields' =>
						array(
							'Image.id', 'full_path'
						)
					)
			);

			Cache::write('images', $images, 'shop');

			return $images;
		}
	}