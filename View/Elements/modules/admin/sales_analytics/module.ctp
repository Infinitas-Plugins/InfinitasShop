<?php
$presets = array(
	'time' => array(
		"<li><a href='javascript:filter([[6, 9], null, null, null])'>morning</a></li>",
		"<li><a href='javascript:filter([[10.5, 13.5], null, null, null])'>noon</a></li>",
		"<li><a href='javascript:filter([[18, 21], null, null, null])'>night</a></li>",
		"<li><a href='javascript:filter([[21, 24], null, null, null])'>late</a></li>",
	),
	'value' => array(
		"<li><a href='javascript:filter([null, [0, 15], null, null])'>low value</a></li>",
		"<li><a href='javascript:filter([null, [15, 80], null, null])'>medium value</a></li>",
		"<li><a href='javascript:filter([null, [80, 200], null, null])'>high value</a></li>",
	),
	'products' => array(
		"<li><a href='javascript:filter([null, null, [1, 2], null])'>few products</a></li>",
		"<li><a href='javascript:filter([null, null, [3, 6], null])'>medium products</a></li>",
		"<li><a href='javascript:filter([null, null, [7, 12], null])'>many products</a></li>",
	)
);
$control = $this->Html->tag('div', implode('', array(
	$this->Html->tag('div', implode('', array(
		$this->Html->tag('p', __d('shop', 'Time of day compared to order value / products sold')),
		$this->Html->tag('ul', implode('', $presets['time']))
	)), array('class' => 'span4')),
	$this->Html->tag('div', implode('', array(
		$this->Html->tag('p', __d('shop', 'Order value compared to time / products sold')),
		$this->Html->tag('ul', implode('', $presets['value']))
	)), array('class' => 'span4')),
	$this->Html->tag('div', implode('', array(
		$this->Html->tag('p', __d('shop', 'Products ordered compared to time / order value')),
		$this->Html->tag('ul', implode('', $presets['products']))
	)), array('class' => 'span4')),
)), array('class' => 'row'));

$control .= $this->Html->tag('p', __d('shop', 'Combine filters and find out why <a href="javascript:filter([[18, 21], [80, 200], null, null])">high order value in the eveing</a> differs to <a href="javascript:filter([[6, 9], [80, 200], null, null])">high order value in the mornings</a>.'));
$control .= $this->Html->tag('p', sprintf('<a href="javascript:filter([null, null, null, null])">%s</a>', __d('shop', 'reset all')));

echo $this->Html->tag('div', implode('', array(
	$control, 
	'<div id="charts">
		<div id="hour-chart" class="chart"><div class="title">Time of Day</div></div>
		<div id="orderTotal-chart" class="chart"><div class="title">Order Total (£)</div></div>
		<div id="productCount-chart" class="chart"><div class="title">Products Ordered</div></div>
		<div id="date-chart" class="chart"><div class="title">Date</div></div>
	</div>
	<aside id="totals"><span id="active">-</span> of <span id="total">-</span> orders selected.</aside>
	<div id="lists"><div id="order-list" class="list"></div></div>'
)), array('class' => 'crossfilter'));