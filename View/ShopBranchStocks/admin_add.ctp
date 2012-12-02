<?php
	/**
	 * Add some documentation for this add form.
	 *
	 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
	 *
	 * @link    http://infinitas-cms.org/Shop
	 * @package	Shop.views.add
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
			__d('shop', 'Branch Stock')
		);
		$contents = array(
			implode('', array(
				$this->Form->input('shop_branch_id', array('titel' => __d('shop', 'Branch'))),
				$this->Form->input('shop_product_id', array('title' => __d('shop', 'Product'))),
				$this->Form->input('change', array(
					'label' => __d('shop', 'Amount to be added / removed (10 or -10 etc)'),
					'type' => 'number'
				)),
				$this->Form->input('notes', array('type' => 'textarea'))
			))
		);
		echo $this->Design->tabs($tabs, $contents);
	echo $this->Form->end();
