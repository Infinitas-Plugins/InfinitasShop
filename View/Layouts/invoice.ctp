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
		<?php
			if (!empty($content_heading)) {
				echo $this->Html->tag('div', $this->Html->tag('div', implode('', array(
					$this->Html->tag('div', $content_for_layout, array('class' => 'span10')),
					$this->Html->tag('div', $content_heading, array('class' => 'span2'))
				)), array('class' => 'row-fluid')), array('class' => 'container-fluid'));
			} else {
				echo $this->Html->tag('div', $content_for_layout, array('class' => 'container-fluid'));
			}
			echo $this->Compress->script($js_for_layout),
			$this->fetch('scripts_for_layout');
		?>
	</body>
</html>