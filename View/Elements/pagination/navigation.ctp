<?php
/**
 * Shop pagination view element file.
 *
 * this is a custom pagination element for the shop plugin.  you can
 * customize the entire shop pagination look and feel by modyfying this file.
 *
 * Copyright (c) 2009 Carl Sutton ( dogmatic69 )
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright (c) 2009 Carl Sutton ( dogmatic69 )
 * @link          http://infinitas-cms.org
 * @package       blog
 * @subpackage    blog.views.elements.pagination.navigation
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

$currentRoute = InfinitasRouter::currentRoute();
if (!empty($currentRoute->options['pass'])) {
	$url = array();
	$currentRoute = Configure::read('CORE.current_route');

	foreach ($currentRoute->options['pass'] as $pass) {
		if (!empty($this->request->{$pass})) {
			$url[$pass] = $this->request->{$pass};
		}
	}
	if (!empty($url)) {
		$this->Paginator->options(array('url' => $url));
	}
}

$hasPrev = $this->Paginator->hasPrev();
$hasNext = $this->Paginator->hasNext();

if (!$this->Paginator->request->params['paging'][$this->Paginator->defaultModel()]['current']) {
	echo sprintf('<p class="pagination empty">%s</p>', __d(Inflector::underscore($this->plugin), Configure::read('Pagination.nothing_found_message' )));
	return true;
}

if (!$hasPrev && !$hasNext) {
	echo sprintf('<p class="pagination low">%s</p>', __d(Inflector::underscore($this->plugin), __d('shop', 'No more products')));
	return;
}

$prev = $hasPrev ? $this->Paginator->prev(__d('shop', 'Prev'), array('tag' => 'li'), "\n") : null;
$next = $hasNext ? $this->Paginator->next(__d('shop', 'Next'), array('tag' => 'li'), "\n") : null;

$numbers = str_replace(
	array(
		sprintf('>%d<', $this->Paginator->request->params['paging'][$this->Paginator->defaultModel()]['page']),
		sprintf('>...<', $this->Paginator->request->params['paging'][$this->Paginator->defaultModel()]['page'])
	),
	array(
		sprintf('>%s<', $this->Html->link($this->Paginator->request->params['paging'][$this->Paginator->defaultModel()]['page'], '#', array(
			'onclick' => 'return false;'
		))),
		sprintf('>%s<', $this->Html->tag('li', $this->Html->link('...', '#', array('onclick' => 'return false;'))))
	),
	$this->Paginator->numbers(array(
		'separator' => false,
		'tag' => 'li',
		'first' => 5,
		'last' => 5,
		'currentClass' => 'disabled'
	))
);

echo $this->Html->tag('div', $this->Html->tag('ul', implode('', array(
	$prev, $numbers, $next
))), array('class' => array('pagination', 'pagination-centered')));