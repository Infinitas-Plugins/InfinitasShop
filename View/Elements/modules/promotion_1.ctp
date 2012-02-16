<?php
	$showMostViewed =
		$this->request->params['controller'] == 'products' &&
		$this->request->params['action'] == 'index' &&
		(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] == 'views');

	if(!$showMostViewed){
		echo $this->element('most_viewed_products', array('plugin' => 'shop'));
	}

	$showNewest =
		$this->request->params['controller'] == 'products' &&
		$this->request->params['action'] == 'index' &&
		(isset($this->request->params['named']['sort']) && $this->request->params['named']['sort'] == 'created');

	if(!$showNewest){
		echo $this->element('newest', array('plugin' => 'shop'));
	}