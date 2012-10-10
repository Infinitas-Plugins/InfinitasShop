<?php
	/**
	 * @brief Add some documentation for this add form.
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
		'type' => 'file',
		'inputDefaults' => array(
			'empty' => Configure::read('Website.empty_select')
		)
	));
		echo $this->Infinitas->adminEditHead();
		echo $this->Form->input('id');

		$tabs = array(
			__d('shop', 'Supplier'),
			__d('shop', 'Details')
		);

		$contents = array(
			implode('', array(
				$this->Form->input('name'),
				$this->Form->input('logo', array('type' => 'file')),
				$this->Form->input('terms'),
				$this->Form->input('active')
			)),
			implode('', array(
				$this->Form->input('email'),
				$this->Form->input('phone'),
				$this->Form->input('fax'),
				$this->Form->input('contact_address_id')
			))
		);

		echo $this->Design->tabs($tabs, $contents);
	echo $this->Form->end();
