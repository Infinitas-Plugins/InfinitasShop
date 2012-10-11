<?php
	/**
	 * @brief Add some documentation for this admin_add form.
	 *
	 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
	 *
	 * @link    http://infinitas-cms.org/Shop
	 * @package	Shop.views.admin_add
	 * @license	http://infinitas-cms.org/mit-license The MIT License
	 * @since   0.9b1
	 *
	 * @author dogmatic69
	 *
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 */
	echo $this->Form->create(null, array(
		'inputDefaults' => array(
			'empty' => Configure::read('Website.empty_select')
		)
	));
		echo $this->Infinitas->adminEditHead(); 
		echo $this->Form->input('id');

		$tabs = array(
			__d('shop', 'Category'),
			__d('shop', 'Config')
		);

		$contents = array(
			implode('', array(
				$this->Form->input('name'),
				$this->Form->input('slug'),
				$this->Form->input('parent_id', array(
					'label' => __d('shop', 'Parent Category'),
					'empty' => __d('shop', 'Root Category'),
					'options' => $parentShopCategories
				)),
				$this->Infinitas->wysiwyg('ShopCategory.description')
			)),
			implode('', array(
				$this->Form->input('shop_image_id', array(
					'label' => __d('shop', 'Category Image')
				)),
				$this->Form->input('shop_product_type_id', array('label' => __d('shop', 'Type'))),
				$this->Form->input('active')
			))
		);

		echo $this->Design->tabs($tabs, $contents);
	echo $this->Form->end();
