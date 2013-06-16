<?php
$tabs = array(
	__d('shop', 'Sales'),
	__d('shop', 'Analytics'),
	__d('shop', 'Calendar view'),
	__d('shop', 'Work load'),
	__d('shop', 'Waterfall'),
);
$content = array(
	$this->element('Shop.modules/admin/sales_overview/module'),
	$this->element('Shop.modules/admin/sales_analytics/module'),
	$this->element('Shop.modules/admin/sales_calendar/module'),
	$this->element('Shop.modules/admin/sales_swimline/module'),
	$this->element('Shop.modules/admin/sales_waterfall/module'),
);
echo $this->Design->tabs($tabs, $content);