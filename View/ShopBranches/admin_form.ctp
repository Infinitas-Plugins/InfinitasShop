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
		echo $this->Form->input('ContactBranch.id');
		echo $this->Form->hidden('ContactBranch.model', array('value' => 'Shop.ShopBranch'));
		echo $this->Form->hidden('ContactAddress.id');

		$tabs = array(
			__d('shop', 'Branch'),
			__d('shop', 'Address')
		);

		$contents = array(
			implode('', array(
				$this->Form->input('ContactBranch.name'),
				$this->Form->input('ContactBranch.image', array('type' => 'file')),
				$this->Form->input('email'),
				$this->Form->input('phone'),
				$this->Form->input('fax'),
				$this->Form->input('manager_id'),
				$this->Form->input('active')
			)),
			implode('', array(
				$this->Form->hidden('ContactAddress.name', array('value' => 'Branch name')),
				$this->Form->input('ContactBranch.map'),
				$this->Form->input('ContactAddress.continent_id'),
				$this->Form->input('ContactAddress.country_id'),
				$this->Form->input('ContactAddress.province'),
				$this->Form->input('ContactAddress.city'),
				$this->Form->input('ContactAddress.street'),
				$this->Form->input('ContactAddress.postal'),
				$this->Form->input('ContactAddress.latitude'),
				$this->Form->input('ContactAddress.longitude')
			))
		);

		echo $this->Design->tabs($tabs, $contents);
	echo $this->Form->end();
