<div>
	<?php
		if(!isset($categories) || empty($categories)){
			$categories = ClassRegistry::init('Shop.ShopCategory')->getCategories();
		}

		if($categories === false){
			echo __('No categories setup');
		}
		else{
			$out = '<ul>';
				foreach($categories as $category){
					$category['ShopCategory']['plugin'] = 'shop';
					$category['ShopCategory']['controller'] = 'categories';
					$category['ShopCategory']['action'] = 'index';
					$category['ShopCategory']['plugin'] = 'shop';

					$eventData = $this->Event->trigger('shop.slugUrl', array('type' => 'categories', 'data' => $category['ShopCategory']));
					$out .= '<li>'.$this->Html->link(
						$category['ShopCategory']['name'],
						current($eventData['slugUrl'])
					).'</li>';
				}
			$out .= '</ul>';

			echo $out,
			$this->Html->link(
				__('All Categories'),
				array(
					'plugin' => 'shop',
					'controller' => 'categories',
					'action' => 'index'
				),
				array(
					'class' => 'all'
				)
			),'<br/>',
			$this->Html->link(
				__('All Products'),
				array(
					'plugin' => 'shop',
					'controller' => 'products',
					'action' => 'index'
				),
				array(
					'class' => 'all'
				)
			),'<br/>',
			$this->Html->link(
				__('All Specials'),
				array(
					'plugin' => 'shop',
					'controller' => 'specials',
					'action' => 'index'
				),
				array(
					'class' => 'all'
				)
			),'<br/>',
			$this->Html->link(
				__('All Spotlights'),
				array(
					'plugin' => 'shop',
					'controller' => 'spotlights',
					'action' => 'index'
				),
				array(
					'class' => 'all'
				)
			);
		}
	?>
</div>