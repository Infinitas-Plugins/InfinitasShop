<?php
$link = $this->Html->link(__dn('shop', '%d item - %s', '%d items - %s', 0, 0, 0), array(
	'plugin' => 'shop',
	'controller' => 'shop_lists',
	'action' => 'index'
), array('class' => 'navbar-link'));

echo $this->Html->tag('p', $link, array('class' => 'navbar-text pull-right'));