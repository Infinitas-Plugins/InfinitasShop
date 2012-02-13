<?php
    /**
     * Shop orders view
     *
     * This page is used to view orders
     *
     * Copyright (c) 2009 Carl Sutton ( dogmatic69 )
     *
     * Licensed under The MIT License
     * Redistributions of files must retain the above copyright notice.
     *
     * @filesource
     * @copyright     Copyright (c) 2009 Carl Sutton ( dogmatic69 )
     * @link          http://infinitas-cms.org
     * @package       shop
     * @subpackage    shop.plugins.order.views.orders.view
     * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
     * @since 0.8a
     */

    echo $this->Form->create('Order', array('type' => 'file'));
        echo $this->Infinitas->adminEditHead($this, array('cancel'));
        	?>
        		<dl>
        			<dt><?php echo __('Order Number'); ?></dt>
        				<dd><?php echo $this->Shop->orderNumber($order['Order']['id']); ?></dd>
        			<dt><?php echo __('Shipping'); ?></dt>
        				<dd><?php echo $this->Shop->currency($order['Order']['shipping']);?></dd>
        			<dt><?php echo __('Total Value'); ?></dt>
        				<dd><?php echo $this->Shop->currency($order['Order']['grand_total']);?></dd>
        			<dt><?php echo __('Total Items'); ?></dt>
        				<dd><?php echo count($order['Item']); ?></dd>
        			<dt><?php echo __('Payment method'); ?></dt>
        				<dd><?php echo Inflector::humanize($order['Order']['payment_method']); ?></dd>
        			<dt><?php echo __('Shipping method'); ?></dt>
        				<dd><?php echo Inflector::humanize($order['Order']['shipping_method']); ?></dd>
        			<dt><?php echo __('Status'); ?></dt>
        				<dd><?php echo $order['Status']['name']; ?></dd>
        			<dt><?php echo __('Ordered'); ?></dt>
        				<dd title="<?php echo $order['Order']['created']; ?>"><?php echo $this->Time->niceShort($order['Order']['created']); ?></dd>
        			<dt><?php echo __('Special Info'); ?></dt>
        				<dd><?php echo $order['Order']['special_instructions']; ?></dd>
				</dl>
	<div class="table">
		<h2><?php echo __('Items Ordered'); ?></h2>
	    <table class="listing" cellpadding="0" cellspacing="0">
	        <?php
	            echo $this->Infinitas->adminTableHeader(
	                array(
	                    __('Product'),
	                    __('Quantity') => array(
	                    	'style' => 'width: 100px;'
	                    ),
	                    __('Price') => array(
	                    	'style' => 'width: 100px;'
	                    ),
	                    __('Sub total') => array(
	                    	'style' => 'width: 100px;'
	                    )
	                ),
	                false
	            );

	            foreach ($order['Item'] as $item){
	                ?>
	                	<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
							<td>
								<?php
									if(!empty($item['Product'])){
										echo $this->Html->link(
											$item['Product']['name'],
											array(
												'plugin' => 'shop',
												'controller' => 'products',
												'action' => 'edit',
												$item['Product']['id']
											)
										);
									}
									else{
										echo sprintf('%s) %s (%s)', $item['product_id'], $item['name'], __('Discontinued'));
									}
								?>
							</td>
							<td>
								<?php echo $item['quantity']; ?>
							</td>
							<td>
								<?php echo $this->Shop->currency($item['price']); ?>
							</td>
							<td>
								<?php echo $this->Shop->currency($item['sub_total']); ?>
							</td>
	                	</tr>
	                <?php
	            }
			?>
    	</table>
		<h2><?php echo __('Payments made'); ?></h2>
	    <table class="listing" cellpadding="0" cellspacing="0">
			<?php
	            echo $this->Infinitas->adminTableHeader(
	                array(
	                    __('Method'),
	                    __('Amount') => array(
	                    	'style' => 'width: 100px;'
	                    ),
	                    __('Created') => array(
	                    	'style' => 'width: 100px;'
	                    )
	                ),
	                false
	            );

	            foreach ($order['Payment'] as $payment){
	                ?>
	                	<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
							<td>
								<?php echo Inflector::humanize($payment['payment_method']); ?>
							</td>
							<td>
								<?php echo $this->Shop->currency($payment['amount']); ?>
							</td>
							<td>
								<?php echo $this->Time->niceShort($payment['created']); ?>
							</td>
	                	</tr>
	                <?php
	            }
			?>
		</table>
    <?php echo $this->Form->end(); ?>
</div>
<style>
	dt{
		clear:left;
		float:left;
		font-size:130%;
		font-weight:bold;
		padding-bottom:2px;
		width:30%;
	}
	dd{
		clear:right;
		float:left;
		padding-top:3px;
	}
</style>