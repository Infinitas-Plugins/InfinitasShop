<?php
$config['Shop'] = array(
	'currency' => 'GBP',
	'display_category_count' => true,
	'robots' => array(
		'index' => array(
			'index' => true,
			'follow' => true
		),
		'view' => array(
			'index' => true,
			'follow' => true
		),
	),
	'meta' => array(
		'keywords' => 'infinitas shop, infinitas ecommerce, cakephp shop, cakephp ecommerce',
		'description' => 'Infinitas Shop is a powerful ecommerce plugin built on top of the Infinitas CMS. For more information see http://infinitas-cms.org',
		'title' => 'Infinitas Shop'
	),

	'allow_ratings' => true,
	'allow_comments' => true,
	'payment_terms' => array(
		__d('shop', 'Cash')    => __d('shop', 'Cash'),
		__d('shop', '30 days') => __d('shop', '30 days'),
		__d('shop', '60 days') => __d('shop', '60 days'),
		__d('shop', '90 days') => __d('shop', '90 days'),
	)
);