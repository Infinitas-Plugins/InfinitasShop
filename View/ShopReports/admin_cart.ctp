<?php
$tabs = array(
	__d('shop', 'Conversion rate'),
	__d('shop', 'Abandoned'),
);
$content = array(
	//$this->element('Shop.modules/admin/sales_overview/module'),
	'',
	'',
);
echo $this->Design->tabs($tabs, $content);