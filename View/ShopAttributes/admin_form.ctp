<?php
/**
 * Attribute add / edit form
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link http://infinitas-cms.org/Shop
 * @package	Shop.views.admin_edit
 * @license	http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author Carl Sutton <dogmatic69@infinitas-cms.org>
 */

echo $this->Form->create(null, array('type' => 'file'));
	echo $this->Infinitas->adminEditHead();
	echo $this->Form->input('id');
	echo $this->Form->input('name');
	echo $this->Form->input('image', array('type' => 'file'));
	echo $this->Form->input('shop_attribute_group_id', array('empty' => Configure::read('Website.empty_select')));
echo $this->Form->end();
