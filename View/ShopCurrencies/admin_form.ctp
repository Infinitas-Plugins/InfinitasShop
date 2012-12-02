<?php
	/**
	 * Add some documentation for this edit form.
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
	echo $this->Form->create();
		echo $this->Infinitas->adminEditHead();
		echo $this->Form->input('id');

		$tabs = array(
			__d('shop', 'Currecny'),
			__d('shop', 'Output')
		);
		$contents = array(
			implode('', array(
				$this->Form->input('name'),
				$this->Form->input('code'),
				$this->Form->input('factor')
			)),
			implode('', array(
				$this->Form->input('whole_symbol'),
				$this->Form->input('whole_position', array(
					'label' => __d('shop', 'Symbol to rear of value')
				)),
				$this->Form->input('fraction_symbol'),
				$this->Form->input('fraction_position', array(
					'label' => __d('shop', 'Symbol to front of value')
				)),
				$this->Form->input('zero', array(
					'label' => __d('shop', 'Zero value'),
					'default' => '0'
				)),
				$this->Form->input('places', array(
					'label' => __d('shop', 'Deciaml places'),
					'default' => 2
				)),
				$this->Form->input('thousands', array(
					'label' => __d('shop', 'Thousands separator'),
					'default' => ',',
					'options' => array(
						',' => ', (comma)',
						'.' => '. (point)'
					)
				)),
				$this->Form->input('decimals', array(
					'label' => __d('shop', 'Decimal separator'),
					'default' => '.',
					'options' => array(
						',' => ', (comma)',
						'.' => '. (point)'
					)
				)),
				$this->Form->input('negative', array(
					'label' => __d('shop', 'Negative value indicator'),
					'default' => '()'
				)),
				$this->Form->input('escape', array(
					'label' => __d('shop', 'Escape for html output')
				))
			))
		);
		echo $this->Design->tabs($tabs, $contents);
	echo $this->Form->end();
