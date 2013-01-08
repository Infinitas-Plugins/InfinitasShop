<div class="shopOrders view">
<h2><?php echo __('Shop Order');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopOrder['ShopOrder']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Invoice Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopOrder['ShopOrder']['invoice_number']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($shopOrder['User']['username'], array('controller' => 'users', 'action' => 'view', $shopOrder['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Shop Billing Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($shopOrder['ShopBillingAddress']['name'], array('controller' => 'shop_addresses', 'action' => 'view', $shopOrder['ShopBillingAddress']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Shop Shipping Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($shopOrder['ShopShippingAddress']['name'], array('controller' => 'shop_addresses', 'action' => 'view', $shopOrder['ShopShippingAddress']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Shop Payment Method'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($shopOrder['ShopPaymentMethod']['name'], array('controller' => 'shop_payment_methods', 'action' => 'view', $shopOrder['ShopPaymentMethod']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Shop Shipping Method'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($shopOrder['ShopShippingMethod']['name'], array('controller' => 'shop_shipping_methods', 'action' => 'view', $shopOrder['ShopShippingMethod']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Tracking Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopOrder['ShopOrder']['tracking_number']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Infinitas Payment Log'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($shopOrder['InfinitasPaymentLog']['id'], array('controller' => 'infinitas_payment_logs', 'action' => 'view', $shopOrder['InfinitasPaymentLog']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Shop Order Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($shopOrder['ShopOrderStatus']['name'], array('controller' => 'shop_order_statuses', 'action' => 'view', $shopOrder['ShopOrderStatus']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Ip Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopOrder['ShopOrder']['ip_address']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopOrder['ShopOrder']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shopOrder['ShopOrder']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('Edit %s'), __('Shop Order')), array('action' => 'edit', $shopOrder['ShopOrder']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('Delete %s'), __('Shop Order')), array('action' => 'delete', $shopOrder['ShopOrder']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $shopOrder['ShopOrder']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Shop Orders')), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Order')), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Users')), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('User')), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Shop Addresses')), array('controller' => 'shop_addresses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Billing Address')), array('controller' => 'shop_addresses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Shop Payment Methods')), array('controller' => 'shop_payment_methods', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Payment Method')), array('controller' => 'shop_payment_methods', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Shop Shipping Methods')), array('controller' => 'shop_shipping_methods', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Shipping Method')), array('controller' => 'shop_shipping_methods', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Shop Order Statuses')), array('controller' => 'shop_order_statuses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Order Status')), array('controller' => 'shop_order_statuses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Infinitas Payment Logs')), array('controller' => 'infinitas_payment_logs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Infinitas Payment Log')), array('controller' => 'infinitas_payment_logs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Shop Order Notes')), array('controller' => 'shop_order_notes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Order Note')), array('controller' => 'shop_order_notes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Shop Order Products')), array('controller' => 'shop_order_products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Order Product')), array('controller' => 'shop_order_products', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php printf(__('Related %s'), __('Shop Order Notes'));?></h3>
	<?php if (!empty($shopOrder['ShopOrderNote'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Shop Order Id'); ?></th>
		<th><?php echo __('Shop Order Status Id'); ?></th>
		<th><?php echo __('Notes'); ?></th>
		<th><?php echo __('User Notified'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($shopOrder['ShopOrderNote'] as $shopOrderNote):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $shopOrderNote['id'];?></td>
			<td><?php echo $shopOrderNote['shop_order_id'];?></td>
			<td><?php echo $shopOrderNote['shop_order_status_id'];?></td>
			<td><?php echo $shopOrderNote['notes'];?></td>
			<td><?php echo $shopOrderNote['user_notified'];?></td>
			<td><?php echo $shopOrderNote['created'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'shop_order_notes', 'action' => 'view', $shopOrderNote['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'shop_order_notes', 'action' => 'edit', $shopOrderNote['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'shop_order_notes', 'action' => 'delete', $shopOrderNote['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $shopOrderNote['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Order Note')), array('controller' => 'shop_order_notes', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php printf(__('Related %s'), __('Shop Order Products'));?></h3>
	<?php if (!empty($shopOrder['ShopOrderProduct'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Shop Order Id'); ?></th>
		<th><?php echo __('Shop Product Variant Id'); ?></th>
		<th><?php echo __('Shop Product Type Id'); ?></th>
		<th><?php echo __('Quantity'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Brand'); ?></th>
		<th><?php echo __('Shop Image Id'); ?></th>
		<th><?php echo __('Product Code'); ?></th>
		<th><?php echo __('Time To Purchase'); ?></th>
		<th><?php echo __('View To Purchase'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($shopOrder['ShopOrderProduct'] as $shopOrderProduct):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $shopOrderProduct['id'];?></td>
			<td><?php echo $shopOrderProduct['shop_order_id'];?></td>
			<td><?php echo $shopOrderProduct['shop_product_variant_id'];?></td>
			<td><?php echo $shopOrderProduct['shop_product_type_id'];?></td>
			<td><?php echo $shopOrderProduct['quantity'];?></td>
			<td><?php echo $shopOrderProduct['name'];?></td>
			<td><?php echo $shopOrderProduct['brand'];?></td>
			<td><?php echo $shopOrderProduct['shop_image_id'];?></td>
			<td><?php echo $shopOrderProduct['product_code'];?></td>
			<td><?php echo $shopOrderProduct['time_to_purchase'];?></td>
			<td><?php echo $shopOrderProduct['view_to_purchase'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'shop_order_products', 'action' => 'view', $shopOrderProduct['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'shop_order_products', 'action' => 'edit', $shopOrderProduct['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'shop_order_products', 'action' => 'delete', $shopOrderProduct['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $shopOrderProduct['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Shop Order Product')), array('controller' => 'shop_order_products', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
