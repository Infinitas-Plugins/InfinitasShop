<div class="shopProducts view">
<h2><?php echo __('Shop Product');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopProduct['ShopProduct']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopProduct['ShopProduct']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Slug'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopProduct['ShopProduct']['slug']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopProduct['ShopProduct']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Specifications'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopProduct['ShopProduct']['specifications']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopProduct['ShopProduct']['active']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Shop Image'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($shopProduct['ShopImage']['id'], array('controller' => 'shop_images', 'action' => 'view', $shopProduct['ShopImage']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Rating'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopProduct['ShopProduct']['rating']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Rating Count'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopProduct['ShopProduct']['rating_count']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Views'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopProduct['ShopProduct']['views']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Sales'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopProduct['ShopProduct']['sales']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Shop Supplier'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($shopProduct['ShopSupplier']['name'], array('controller' => 'shop_suppliers', 'action' => 'view', $shopProduct['ShopSupplier']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopProduct['ShopProduct']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopProduct['ShopProduct']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Shop Product Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($shopProduct['ShopProductType']['name'], array('controller' => 'shop_product_types', 'action' => 'view', $shopProduct['ShopProductType']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('Edit %s'), __('Shop Product')), array('action' => 'edit', $shopProduct['ShopProduct']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('Delete %s'), __('Shop Product')), array('action' => 'delete', $shopProduct['ShopProduct']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $shopProduct['ShopProduct']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Shop Products')), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Product')), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Shop Images')), array('controller' => 'shop_images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Image')), array('controller' => 'shop_images', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Shop Suppliers')), array('controller' => 'shop_suppliers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Supplier')), array('controller' => 'shop_suppliers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Shop Product Types')), array('controller' => 'shop_product_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Product Type')), array('controller' => 'shop_product_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Shop Prices')), array('controller' => 'shop_prices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Price')), array('controller' => 'shop_prices', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Shop Sizes')), array('controller' => 'shop_sizes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Size')), array('controller' => 'shop_sizes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Shop Specials')), array('controller' => 'shop_specials', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Current Special')), array('controller' => 'shop_specials', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Shop Spotlights')), array('controller' => 'shop_spotlights', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Current Spotlight')), array('controller' => 'shop_spotlights', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Shop Branch Stocks')), array('controller' => 'shop_branch_stocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Branch Stock')), array('controller' => 'shop_branch_stocks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Shop Categories Products')), array('controller' => 'shop_categories_products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Categories Product')), array('controller' => 'shop_categories_products', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Shop Images Products')), array('controller' => 'shop_images_products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Images Product')), array('controller' => 'shop_images_products', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Shop List Products')), array('controller' => 'shop_list_products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop List Product')), array('controller' => 'shop_list_products', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('View Counter Views')), array('controller' => 'view_counter_views', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('View Count')), array('controller' => 'view_counter_views', 'action' => 'add')); ?> </li>
	</ul>
</div>
	<div class="related">
		<h3><?php printf(__('Related %s'), __('Shop Prices'));?></h3>
	<?php if (!empty($shopProduct['ShopPrice'])):?>
		<dl>	<?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopPrice']['id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Cost');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopPrice']['cost'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Selling');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopPrice']['selling'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Retail');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopPrice']['retail'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Model');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopPrice']['model'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Foreign Key');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopPrice']['foreign_key'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopPrice']['created'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopPrice']['modified'];?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(sprintf(__('Edit %s'), __('Shop Price')), array('controller' => 'shop_prices', 'action' => 'edit', $shopProduct['ShopPrice']['id'])); ?></li>
			</ul>
		</div>
	</div>
		<div class="related">
		<h3><?php printf(__('Related %s'), __('Shop Sizes'));?></h3>
	<?php if (!empty($shopProduct['ShopSize'])):?>
		<dl>	<?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopSize']['id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Model');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopSize']['model'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Foreign Key');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopSize']['foreign_key'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Product Width');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopSize']['product_width'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Product Height');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopSize']['product_height'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Product Length');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopSize']['product_length'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Shipping Width');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopSize']['shipping_width'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Shipping Height');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopSize']['shipping_height'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Shipping Length');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopSize']['shipping_length'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Product Weight');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopSize']['product_weight'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Shipping Weight');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopSize']['shipping_weight'];?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(sprintf(__('Edit %s'), __('Shop Size')), array('controller' => 'shop_sizes', 'action' => 'edit', $shopProduct['ShopSize']['id'])); ?></li>
			</ul>
		</div>
	</div>
		<div class="related">
		<h3><?php printf(__('Related %s'), __('Shop Specials'));?></h3>
	<?php if (!empty($shopProduct['ShopCurrentSpecial'])):?>
		<dl>	<?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopCurrentSpecial']['id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Shop Product Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopCurrentSpecial']['shop_product_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Shop Image Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopCurrentSpecial']['shop_image_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Discount');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopCurrentSpecial']['discount'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Amount');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopCurrentSpecial']['amount'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Start Date');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopCurrentSpecial']['start_date'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('End Date');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopCurrentSpecial']['end_date'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Active');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopCurrentSpecial']['active'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopCurrentSpecial']['created'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopCurrentSpecial']['modified'];?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(sprintf(__('Edit %s'), __('Shop Current Special')), array('controller' => 'shop_specials', 'action' => 'edit', $shopProduct['ShopCurrentSpecial']['id'])); ?></li>
			</ul>
		</div>
	</div>
		<div class="related">
		<h3><?php printf(__('Related %s'), __('Shop Spotlights'));?></h3>
	<?php if (!empty($shopProduct['ShopCurrentSpotlight'])):?>
		<dl>	<?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopCurrentSpotlight']['id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Shop Product Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopCurrentSpotlight']['shop_product_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Shop Image Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopCurrentSpotlight']['shop_image_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Start Date');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopCurrentSpotlight']['start_date'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('End Date');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopCurrentSpotlight']['end_date'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Active');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopCurrentSpotlight']['active'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopCurrentSpotlight']['created'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $shopProduct['ShopCurrentSpotlight']['modified'];?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(sprintf(__('Edit %s'), __('Shop Current Spotlight')), array('controller' => 'shop_spotlights', 'action' => 'edit', $shopProduct['ShopCurrentSpotlight']['id'])); ?></li>
			</ul>
		</div>
	</div>
	<div class="related">
	<h3><?php printf(__('Related %s'), __('Shop Branch Stocks'));?></h3>
	<?php if (!empty($shopProduct['ShopBranchStock'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Shop Branch Id'); ?></th>
		<th><?php echo __('Shop Product Id'); ?></th>
		<th><?php echo __('Stock'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($shopProduct['ShopBranchStock'] as $shopBranchStock):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $shopBranchStock['id'];?></td>
			<td><?php echo $shopBranchStock['shop_branch_id'];?></td>
			<td><?php echo $shopBranchStock['shop_product_id'];?></td>
			<td><?php echo $shopBranchStock['stock'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'shop_branch_stocks', 'action' => 'view', $shopBranchStock['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'shop_branch_stocks', 'action' => 'edit', $shopBranchStock['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'shop_branch_stocks', 'action' => 'delete', $shopBranchStock['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $shopBranchStock['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Branch Stock')), array('controller' => 'shop_branch_stocks', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php printf(__('Related %s'), __('Shop Categories Products'));?></h3>
	<?php if (!empty($shopProduct['ShopCategoriesProduct'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Shop Category Id'); ?></th>
		<th><?php echo __('Shop Product Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($shopProduct['ShopCategoriesProduct'] as $shopCategoriesProduct):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $shopCategoriesProduct['id'];?></td>
			<td><?php echo $shopCategoriesProduct['shop_category_id'];?></td>
			<td><?php echo $shopCategoriesProduct['shop_product_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'shop_categories_products', 'action' => 'view', $shopCategoriesProduct['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'shop_categories_products', 'action' => 'edit', $shopCategoriesProduct['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'shop_categories_products', 'action' => 'delete', $shopCategoriesProduct['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $shopCategoriesProduct['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Categories Product')), array('controller' => 'shop_categories_products', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php printf(__('Related %s'), __('Shop Images Products'));?></h3>
	<?php if (!empty($shopProduct['ShopImagesProduct'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Shop Image Id'); ?></th>
		<th><?php echo __('Shop Product Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($shopProduct['ShopImagesProduct'] as $shopImagesProduct):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $shopImagesProduct['id'];?></td>
			<td><?php echo $shopImagesProduct['shop_image_id'];?></td>
			<td><?php echo $shopImagesProduct['shop_product_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'shop_images_products', 'action' => 'view', $shopImagesProduct['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'shop_images_products', 'action' => 'edit', $shopImagesProduct['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'shop_images_products', 'action' => 'delete', $shopImagesProduct['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $shopImagesProduct['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Images Product')), array('controller' => 'shop_images_products', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php printf(__('Related %s'), __('Shop Specials'));?></h3>
	<?php if (!empty($shopProduct['ShopSpecial'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Shop Product Id'); ?></th>
		<th><?php echo __('Shop Image Id'); ?></th>
		<th><?php echo __('Discount'); ?></th>
		<th><?php echo __('Amount'); ?></th>
		<th><?php echo __('Start Date'); ?></th>
		<th><?php echo __('End Date'); ?></th>
		<th><?php echo __('Active'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($shopProduct['ShopSpecial'] as $shopSpecial):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $shopSpecial['id'];?></td>
			<td><?php echo $shopSpecial['shop_product_id'];?></td>
			<td><?php echo $shopSpecial['shop_image_id'];?></td>
			<td><?php echo $shopSpecial['discount'];?></td>
			<td><?php echo $shopSpecial['amount'];?></td>
			<td><?php echo $shopSpecial['start_date'];?></td>
			<td><?php echo $shopSpecial['end_date'];?></td>
			<td><?php echo $shopSpecial['active'];?></td>
			<td><?php echo $shopSpecial['created'];?></td>
			<td><?php echo $shopSpecial['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'shop_specials', 'action' => 'view', $shopSpecial['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'shop_specials', 'action' => 'edit', $shopSpecial['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'shop_specials', 'action' => 'delete', $shopSpecial['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $shopSpecial['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Special')), array('controller' => 'shop_specials', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php printf(__('Related %s'), __('Shop Spotlights'));?></h3>
	<?php if (!empty($shopProduct['ShopSpotlight'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Shop Product Id'); ?></th>
		<th><?php echo __('Shop Image Id'); ?></th>
		<th><?php echo __('Start Date'); ?></th>
		<th><?php echo __('End Date'); ?></th>
		<th><?php echo __('Active'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($shopProduct['ShopSpotlight'] as $shopSpotlight):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $shopSpotlight['id'];?></td>
			<td><?php echo $shopSpotlight['shop_product_id'];?></td>
			<td><?php echo $shopSpotlight['shop_image_id'];?></td>
			<td><?php echo $shopSpotlight['start_date'];?></td>
			<td><?php echo $shopSpotlight['end_date'];?></td>
			<td><?php echo $shopSpotlight['active'];?></td>
			<td><?php echo $shopSpotlight['created'];?></td>
			<td><?php echo $shopSpotlight['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'shop_spotlights', 'action' => 'view', $shopSpotlight['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'shop_spotlights', 'action' => 'edit', $shopSpotlight['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'shop_spotlights', 'action' => 'delete', $shopSpotlight['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $shopSpotlight['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Spotlight')), array('controller' => 'shop_spotlights', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php printf(__('Related %s'), __('Shop List Products'));?></h3>
	<?php if (!empty($shopProduct['ShopListProduct'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Shop List Id'); ?></th>
		<th><?php echo __('Shop Product Id'); ?></th>
		<th><?php echo __('Price'); ?></th>
		<th><?php echo __('Quantity'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($shopProduct['ShopListProduct'] as $shopListProduct):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $shopListProduct['id'];?></td>
			<td><?php echo $shopListProduct['shop_list_id'];?></td>
			<td><?php echo $shopListProduct['shop_product_id'];?></td>
			<td><?php echo $shopListProduct['price'];?></td>
			<td><?php echo $shopListProduct['quantity'];?></td>
			<td><?php echo $shopListProduct['created'];?></td>
			<td><?php echo $shopListProduct['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'shop_list_products', 'action' => 'view', $shopListProduct['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'shop_list_products', 'action' => 'edit', $shopListProduct['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'shop_list_products', 'action' => 'delete', $shopListProduct['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $shopListProduct['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop List Product')), array('controller' => 'shop_list_products', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php printf(__('Related %s'), __('View Counter Views'));?></h3>
	<?php if (!empty($shopProduct['ViewCount'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Model'); ?></th>
		<th><?php echo __('Foreign Key'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Ip Address'); ?></th>
		<th><?php echo __('Year'); ?></th>
		<th><?php echo __('Month'); ?></th>
		<th><?php echo __('Day'); ?></th>
		<th><?php echo __('Hour'); ?></th>
		<th><?php echo __('Week Of Year'); ?></th>
		<th><?php echo __('Day Of Year'); ?></th>
		<th><?php echo __('Day Of Week'); ?></th>
		<th><?php echo __('Continent Code'); ?></th>
		<th><?php echo __('Country Code'); ?></th>
		<th><?php echo __('Country'); ?></th>
		<th><?php echo __('City'); ?></th>
		<th><?php echo __('Referer'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($shopProduct['ViewCount'] as $viewCount):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $viewCount['id'];?></td>
			<td><?php echo $viewCount['model'];?></td>
			<td><?php echo $viewCount['foreign_key'];?></td>
			<td><?php echo $viewCount['user_id'];?></td>
			<td><?php echo $viewCount['ip_address'];?></td>
			<td><?php echo $viewCount['year'];?></td>
			<td><?php echo $viewCount['month'];?></td>
			<td><?php echo $viewCount['day'];?></td>
			<td><?php echo $viewCount['hour'];?></td>
			<td><?php echo $viewCount['week_of_year'];?></td>
			<td><?php echo $viewCount['day_of_year'];?></td>
			<td><?php echo $viewCount['day_of_week'];?></td>
			<td><?php echo $viewCount['continent_code'];?></td>
			<td><?php echo $viewCount['country_code'];?></td>
			<td><?php echo $viewCount['country'];?></td>
			<td><?php echo $viewCount['city'];?></td>
			<td><?php echo $viewCount['referer'];?></td>
			<td><?php echo $viewCount['created'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'view_counter_views', 'action' => 'view', $viewCount['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'view_counter_views', 'action' => 'edit', $viewCount['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'view_counter_views', 'action' => 'delete', $viewCount['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $viewCount['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s'), __('View Count')), array('controller' => 'view_counter_views', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
