<?php
class ShopHelper extends AppHelper {
	public $helpers = array(
		'Text',
		'Html'
	);

/**
 * @brief link email addresses with optional icon 
 *
 * Can link as plain text or as an icon
 *
 * @code 
 * 	// using an icon
 * 	$this->Shop->emailLink('foo@bar.com'); // <a ...><img ... /></a>
 *
 * 	// using text
 * 	$this->Shop->emailLink('foo@bar.com', false); // <a ...>foo@bar.com</a>
 * @endcode
 * 
 * @param string $email the email address being linked
 * @param boolean $icon use an icon or not
 * @param array $options options for the icon link
 * 
 * @return sting
 */
	public function emailLink($email, $icon = true, $options = array()) {
		$options = array_merge(array(
			'escape' => false,
			'title' => $email,
			'target' => '_blank'
		), $options);

		if(!$icon) {
			return $this->Text->autoLinkEmails($email, $options);
		}

		return $this->Html->link(
			$this->Html->image('Emails.icon.png', array(
				'width' => 24,
				'alt' => __d('shop', 'Email')
			)),
			'mailto:' . $email,
			$options
		);
	}

/**
 * @brief convert hours to meaningful time
 *
 * @code 
 * 	$this->Shop->timeEstimate(12); // 12 hours
 * 	$this->Shop->timeEstimate(25); // 1 day
 * 	$this->Shop->timeEstimate(360); // 2 weeks
 * @endcode
 * 
 * @param integer $hours the number of hours being converted
 * 
 * @return string
 */
	public function timeEstimate($hours) {
		$hours = round($hours);
		if($hours <= 24) {
			return __dn('shop', '%d hour', '%d hours', $hours, $hours);
		}

		$days = round($hours / 24);
		if($days <= 7) {
			return __dn('shop', '%d day', '%d days', $days, $days);
		}

		$weeks = round($days / 7);
		if($weeks <= 6) {
			return __dn('shop', '%d week', '%d weeks', $weeks, $weeks);	
		}

		$months = round($weeks / 4.2);
		return __dn('shop', '%d month', '%d months', $months, $months);	
	}

/**
 * @brief convert an amount to currency
 * 
 * @param float $amount the amount to show
 * 
 * @return string
 */
	public function adminCurrency($amount) {
		return CakeNumber::currency($amount, 'GBP');
	}

	public function currency($amount, $to = null) {
		App::uses('ShopCurrencyLib', 'Shop.Lib');
		//ShopCurrencyLib::addFormat(strtoupper($to));
		return ShopCurrencyLib::convert($amount);
	}
}