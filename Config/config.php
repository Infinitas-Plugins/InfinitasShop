<?php
	$config['Shop'] = array(
		'currency' => 'GBP',
		'display_category_count' => true,

		'allow_ratings' => true,
		'allow_comments' => true,
		'payment_terms' => array(
			__d('shop', 'Cash')    => __d('shop', 'Cash'),
			__d('shop', '30 days') => __d('shop', '30 days'),
			__d('shop', '60 days') => __d('shop', '60 days'),
			__d('shop', '90 days') => __d('shop', '90 days'),
		)
	);