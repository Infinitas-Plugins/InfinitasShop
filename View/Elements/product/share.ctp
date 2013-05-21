<?php
	if (!isset($config)) {
		$config = array();
	}
	$config = array_merge(array(
		'title' => 'Share',
		'hr' => true
	), (array)$config);
?>
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "ur-46f5fb0d-b57d-a69c-771d-9e8611866b38"});</script>

<?php 
	if($config['title']) {
		echo __d('shop', $config['title']);
	}
?>
<div class="pull-right">
	<span class='st_sharethis_large' displayText='ShareThis'></span>
	<span class='st_facebook_large' displayText='Facebook'></span>
	<span class='st_twitter_large' displayText='Tweet'></span>
	<span class='st_googleplus_large' displayText='Google +'></span>
	<span class='st_pinterest_large' displayText='Pinterest'></span>
	<span class='st_reddit_large' displayText='Reddit'></span>
	<span class='st_blogger_large' displayText='Blogger'></span>
	<span class='st_email_large' displayText='Email'></span>
</div>
<?php 
	if ($config['hr']) {
		echo $this->Html->tag('hr');
	}