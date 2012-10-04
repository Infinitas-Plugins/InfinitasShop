<div class="viewProduct">
	<?php echo $this->element('product_neighbors', array('plugin' => 'shop', 'neighbors' => $neighbors)); ?>
	<h2 class="fade"><?php echo $product['Product']['name']; ?></h2>
	<?php echo $this->element('product_image_gallery', array('plugin' => 'shop', 'product' => $product)); ?>
	<div class="info">
		<table cellspacing="0" cellpadding="0">
			<tr><th style="width:70px;"><?php echo __d('shop', 'Code'); ?>:</th><td><?php echo 'todo'; ?></td></tr>
			<tr><th><?php echo __d('shop', 'Retail'); ?>:</th><td><?php echo $this->Shop->currency($product['Product']['retail']); ?></td></tr>
			<?php
				$class = '';
				if($isSpecial = $this->Shop->isSpecial($product) === true) {
					$class = 'del';
				}

			?>
			<tr><th><?php echo __d('shop', 'Price'); ?>:</th><td class="<?php echo $class; ?>"><?php echo $this->Shop->currency($product['Product']['price']), ' ', $product['ShopUnit']['symbol']; ?></td></tr>
			<?php
				if($isSpecial) {
					?>
						<tr><th><?php echo __d('shop', 'Sale Price'); ?>:</th><td><?php echo $this->Shop->calculateSpecial($product['Product'], $product['Special']), ' ', $product['ShopUnit']['symbol']; ?></td></tr>
					<?php
				}
			?>
			<tr><th><?php echo __d('shop', 'Sales Unit'); ?>:</th><td><?php echo $product['ShopUnit']['name']; ?></td></tr>
			<tr><th><?php echo __d('shop', 'Supplier'); ?>:</th><td><?php echo $product['Supplier']['name']; ?></td></tr>
			<tr><th><?php echo __d('shop', 'Rating'); ?>:</th><td><?php echo sprintf(__d('shop', '%s out of %s'), $product['Product']['rating'], $product['Product']['rating_count']); ?></td></tr>
			<tr><th><?php echo __d('shop', 'Viewed'); ?>:</th><td><?php echo sprintf(__d('shop', '%s times'), $product['Product']['views']); ?></td></tr>
			<tr><th><?php echo __d('shop', 'Updated'); ?>:</th><td><?php echo $this->Time->niceShort($product['Product']['modified']); ?></td></tr>
		</table>

	    <div class="product_add_to_cart">
	    	<?php
				echo $this->Html->image(
					'/shop/img/add_to_cart.png',
					array(
						'url' => array(
							'plugin' => 'shop',
							'controller' => 'carts',
							'action' => 'adjust',
							'product_id' => $product['Product']['id'],
							'quantity' => 1
						),
						'title' => __d('shop', 'Add to cart'),
						'alt' => __d('shop', 'Add to cart'),
						'width' => '90px'
					)
				);
	    	?>
	    </div>

	    <div class="product_add_to_wishlist">
	    	<?php
				echo $this->Html->image(
					'/shop/img/add_to_wishlist.png',
					array(
						'url' => array(
							'plugin' => 'shop',
							'controller' => 'wishlists',
							'action' => 'adjust',
							'product_id' => $product['Product']['id'],
							'quantity' => 1
						),
						'title' => __d('shop', 'Add to wishlist'),
						'alt' => __d('shop', 'Add to wishlist'),
						'width' => '90px'
					)
				);
	    	?>
	    </div>
	</div>

	<div class="extra">
		<?php
			foreach($tabs as $tab => $path) {
				$list[] = '<li><a href="#product_'.Inflector::underscore($tab).'">'.Inflector::humanize($tab).'</a></li>';

				if(strstr($path, '/')) {
					$temp = Set::extract($path, $product);
					$temp = isset($temp[0]) ? $temp[0] : '';
				}
				else{
					$temp = $this->element($path, isset($product[ucfirst($path)]) ? array($path => $product[ucfirst($path)]) : $product);
				}

				$datas[] = '<div id="product_'.Inflector::underscore($tab).'">'.$temp.'</div>';
			}
		?>
		<div class="tabs">
			<ul>
				<?php echo implode('', $list);?>
			</ul>
			<?php echo implode('', $datas);?>
		</div>
	</div>
</div>

