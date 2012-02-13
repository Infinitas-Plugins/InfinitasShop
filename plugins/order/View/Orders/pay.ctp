<p><?php echo __('Below are your orders that are still awating payment, to complete the checkout proccess select your payment gateway from the list next to your order.')?></p>
<div class="table payments">
	<h2 class="fade"><?php echo __('Orders pending payments'); ?></h2>
    <table class="listing" cellpadding="0" cellspacing="0">
        <?php
            echo $this->Infinitas->adminTableHeader(
                array(
                    __('Order') => array(
                        'style' => 'width:90px;'
                    ),
                    __('Items') => array(
                        'style' => 'width:100px;'
                    ),
                    __('Status') => array(
                        'style' => 'width:75px;'
                    ),
                    __('Total') => array(
                        'style' => 'width:125px;'
                    ),
                    __('Created') => array(
                        'style' => 'width:150px;'
                    ),
                    __('Pay')
                ),
                false
            );

            $i = 0;
            foreach ($orders as $order){
                ?>
                	<tr class="<?php echo $this->Infinitas->rowClass('even'); ?>">
						<td>
							<?php echo '#'.str_pad($order['Order']['id'], 5, '0', STR_PAD_LEFT); ?>&nbsp;
						</td>
						<td>
							<?php echo $order['Order']['item_count']; ?>&nbsp;
						</td>
						<td>
							<?php echo $order['Status']['name']; ?>&nbsp;
						</td>
						<td>
							<?php echo $this->Shop->currency($order['Order']['grand_total']); ?>&nbsp;
						</td>
						<td>
							<?php echo $this->Time->timeAgoInWords($order['Order']['created']); ?>&nbsp;
						</td>
						<td>
							<?php
								echo $this->Html->link('Pay Now', array('action' => 'pay_now', $order['Order']['id']));
							?>&nbsp;
						</td>
                	</tr>
                <?php
            }
        ?>
    </table>
</div>