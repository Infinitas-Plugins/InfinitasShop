<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php
			echo $this->Html->charset();
			echo $this->Html->tag('title', sprintf('Infinitas Admin :: %s', $title_for_layout));
            echo $this->Html->meta('icon');

			echo $this->Compress->css(array(
				'/theme/infinitas/less/admin.less',
				'stylesheet/less', array(
					'ext' => '.less'
				)
			));

			echo $this->Compress->css(array(
				'/shop/less/invoice.less',
				'stylesheet/less', array(
					'ext' => '.less'
				)
			));
			echo $this->Compress->css($css_for_layout);

			echo $this->Html->scriptBlock(sprintf(
				"Infinitas = %s;\nif (Infinitas.base != '/') {Infinitas.base = Infinitas.base + '/';}\n",
				json_encode(isset($infinitasJsData) ? $infinitasJsData : '')
			));
		?>
	</head>
	<body>
		<div class="container">
			<?php
				echo $content_for_layout;
			?>
		</div>
		<?php
			echo $this->Compress->script($js_for_layout),
			$this->fetch('scripts_for_layout');
		?>
	</body>
</html>