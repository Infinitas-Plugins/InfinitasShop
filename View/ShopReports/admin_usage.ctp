<?php
$tabs = array(
	__d('shop', 'Registrations'),
	__d('shop', 'Customer Usage'),
	__d('shop', 'Guest Usage'),
	__d('shop', 'Newsletter response'),
	__d('shop', 'Target Market'),
	__d('shop', 'Errors'),
);
$content = array(
	//$this->element('Shop.modules/admin/sales_overview/module'),
	'',
	'',
	'',
	'',
	'',
	'',
);
echo $this->Design->tabs($tabs, $content);