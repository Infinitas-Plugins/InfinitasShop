<h2 class="fade"><?php echo __d('shop', 'My Account'); ?></h2>
<?php
	if(!empty($pendingOrders)) {
		$here = $this->Html->link(
			__d('shop', 'Here'),
			array(
				'plugin' => 'order',
				'controller' => 'orders',
				'action' => 'pay'
			)
		);
		?>
			<div class="notice">
				<p><?php echo sprintf(__d('shop', 'You have %s pending order(s), click %s to pay them now'), count($pendingOrders), $here);?></p>
			</div>
		<?php
	}
?>
<p>
	<?php
		$here = $this->Html->link(
			__d('shop', 'Here'),
			array(
				'plugin' => 'order',
				'controller' => 'orders',
				'action' => 'index'
			)
		);
		echo sprintf(__d('shop', 'View the status of your orders by clicking %s'), $here);
	?>
</p>
<p>
	<?php
		$here = $this->Html->link(
			__d('shop', 'Here'),
			array(
				'plugin' => 'order',
				'controller' => 'clients',
				'action' => 'addresses'
			)
		);
		echo sprintf(__d('shop', 'You can manage your addresses for delivery by clicking %s'), $here);
	?>
</p>