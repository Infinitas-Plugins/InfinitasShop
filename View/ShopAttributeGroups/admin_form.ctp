<?php
/**
 * Attribute group add / edit view
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link http://infinitas-cms.org/Shop
 * @package	Shop.View
 * @license	http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author Carl Sutton <dogmatic69@infinitas-cms.org>
 */

echo $this->Form->create();
	echo $this->Infinitas->adminEditHead(); 
	echo $this->Form->input('id');
	echo $this->Form->input('name');
echo $this->Form->end();
