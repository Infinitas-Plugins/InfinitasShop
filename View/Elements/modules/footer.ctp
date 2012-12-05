<hr>
<footer>
	<?php
		$blocks = array();
		$links = array(
			__d('shop', 'About Us') => array(
				'plugin' => 'cms',
				'controller' => 'cms_contents',
				'action' => 'view',
				'category' => 'information',
				'slug' => 'about-us'
			),
			__d('shop', 'Shipping') => array(
				'plugin' => 'cms',
				'controller' => 'cms_contents',
				'action' => 'view',
				'category' => 'information',
				'slug' => 'shipping'
			),
			__d('shop', 'Privacy Policy') => array(
				'plugin' => 'cms',
				'controller' => 'cms_contents',
				'action' => 'view',
				'category' => 'information',
				'slug' => 'privacy-policy'
			),
			__d('shop', 'Terms & Conditions') => array(
				'plugin' => 'cms',
				'controller' => 'cms_contents',
				'action' => 'view',
				'category' => 'information',
				'slug' => 'terms-and-conditions'
			),
			__d('shop', 'Trademarks') => array(
				'plugin' => 'cms',
				'controller' => 'cms_contents',
				'action' => 'view',
				'category' => 'information',
				'slug' => 'trademarks'
			),
		);
		$blocks[] = $this->Shop->infoLinks(__d('shop', 'Information'), $links);

		$links = array(
			__d('shop', 'Contact Us') => array(
				'plugin' => 'newsletter',
				'controller' => 'newsletters',
				'action' => 'contact'
			),
			__d('shop', 'Returns') => array(
				'plugin' => 'cms',
				'controller' => 'cms_contents',
				'action' => 'view',
				'category' => 'information',
				'slug' => 'returns'
			),
			__d('shop', 'Site Map') => array(

			)
		);
		$blocks[] = $this->Shop->infoLinks(__d('shop', 'Customer Service'), $links);

		$links = array(
			__d('shop', 'Brands') => array(

			),
			__d('shop', 'Gift Vouchers') => array(

			),
			__d('shop', 'Specials') => array(

			),
			__d('shop', 'Featured') => array(

			)
		);
		$blocks[] = $this->Shop->infoLinks(__d('shop', 'More'), $links);

		$links = array(
			__d('shop', 'My Account') => array(

			),
			__d('shop', 'Order History') => array(

			),
			__d('shop', 'Wish list') => array(

			),
			__d('shop', 'Newsletter') => array(

			)
		);
		$blocks[] = $this->Shop->infoLinks(__d('shop', 'My Account'), $links);
		echo $this->Html->tag('div', implode('', $blocks), array('class' => 'row-fluid'));

		echo $this->Html->tag('p', __d('shop', '&copy %s %s', $this->Html->link(Configure::read('Website.name'), '/'), date('Y')));
	?>
</footer>