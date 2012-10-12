<?php
class ShopHelper extends AppHelper {
	public $helpers = array(
		'Text',
		'Html'
	);

	public function emailLink($email, $icon = true, $options = array()) {
		if(!$icon) {
			return $this->Text->autoLinkEmails($email);
		}

		$options = array_merge($options, array(
			'escape' => false,
			'title' => $email,
			'target' => 'blank'
		));

		return $this->Html->link(
			$this->Html->image('Emails.icon.png', array(
				'width' => 24,
				'alt' => __d('shop', 'Email')
			)),
			'mailto:' . $email,
			$options
		);
	}

	public function timeEstimate($hours) {
		if($hours <= 24) {
			return __d('shop', '%d hours', round($hours));
		}

		$days = round($hours / 24);
		if($days <= 7) {
			return __d('shop', '%d days', $days);			
		}

		return __d('shop', '%d weeks', round($days / 7));

	}

	public function adminCurrency($amount) {
		return CakeNumber::currency($amount, 'GBP');
	}
}