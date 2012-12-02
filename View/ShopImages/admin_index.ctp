<?php
/**
 * Add some documentation for this index form.
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link		  http://infinitas-cms.org/Shop
 * @package	   Shop.View.index
 * @license	   http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author dogmatic69
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
echo $this->Form->create(null, array('action' => 'mass'));
	echo $this->Infinitas->adminIndexHead($filterOptions, array(
		'add',
		'edit',
		'toggle',
		'copy',
		'delete'
	));
	echo $this->Filter->alphabetFilter();
	
	if (!empty($images)) {
		echo $this->Form->input('all', array('label' => __('Select all'), 'type' => 'checkbox'));
	}

	foreach ($shopImages as &$shopImage) {
		$shopImage = implode('', array(
			$this->Html->tag('span', String::truncate($shopImage['ShopImage']['image'], 25)),
			$this->Html->link(
				$this->Html->image($shopImage['ShopImage']['image_small']),
				$shopImage['ShopImage']['image_full'],
				array(
					'class' => 'thickbox',
					'escape' => false
				)
			),
			$this->Html->tag('div', implode('', array(
				$this->Infinitas->massActionCheckBox($shopImage),
				$this->Html->link(String::truncate($shopImage['ShopImage']['image'], 20), array(
					'action' => 'edit',
					$shopImage['ShopImage']['id']
				))
			)), array('class' => 'details'))
		));
	}
	echo $this->Design->arrayToList($shopImages, array(
		'ul' => 'thumbnails',
		'li' => 'span1'
	));

echo $this->Form->end();
echo $this->element('pagination/admin/navigation');