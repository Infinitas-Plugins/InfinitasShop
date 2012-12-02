<?php
	/**
	 * Add some documentation for this admin_edit form.
	 *
	 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
	 *
	 * @link    http://infinitas-cms.org/Shop
	 * @package	Shop.views.admin_edit
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
			__d('shop', 'Status')
		);

		$contents = array(
			implode('', array(
				$this->Form->input('name'),
				$this->Form->input('status', array('options' => $statuses))
			))
		);

		echo $this->Design->tabs($tabs, $contents);
	echo $this->Form->end();
