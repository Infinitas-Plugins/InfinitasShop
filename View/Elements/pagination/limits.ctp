<?php
$url = InfinitasRouter::parse($this->here);
$url['named'] = array_merge(array(
	'limit' => Configure::read('Shop.Pagination.default')
), $url['named']);
$url = array_merge($url, $url['named'], $url['pass']);
unset($url['named'], $url['pass'], $url['page']);
if (!empty($url['category'])) {
	$keys = (array)array_keys($url, $url['category']);
	foreach ($keys as $key) {
		if ($key !== 'category') {
			unset($url[$key]);
		}
	}
}

$pagination = array();
foreach (Configure::read('Shop.pagination.options') as $limit) {
	$class = $url['limit'] == $limit ? 'active' : null;
	if ($class) {
		$link = $this->here . '#';
	} else {
		$link = $link = array_merge($url, array('limit' => $limit));
	}
	$pagination[] = $this->Html->link($limit, $link, array('class' => $class));
}
echo $this->Html->tag('div', $this->Html->tag('div', implode('', $pagination)), array(
	'class' => 'pagination-limits'
));