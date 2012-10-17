<?php
	/**
	 * @brief Add some documentation for this edit form.
	 *
	 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
	 *
	 * @link    http://infinitas-cms.org/Shop
	 * @package	Shop.views.edit
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
			__d('shop', 'Special'),
			__d('shop', 'Products')
		);

		$contents = array(
			implode('', array(
				$this->Form->input('amount'),
				$this->Form->input('discount'),
				$this->Form->input('free_shipping'),
				$this->Form->input('start_date'),
				$this->Form->input('end_date'),
				$this->Form->input('shop_image_id', array('label' => __d('shop', 'Custom Image'))),
				$this->Form->input('active')
			)),
			implode('', array(
				$this->Form->input('ShopProduct', array(
					'multiple' => true,
					'empty' => false,
					'label' => __d('shop', 'Products')
				))
			))
		);

		echo $this->Design->tabs($tabs, $contents);
	echo $this->Form->end();
