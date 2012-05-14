<?php

	if($this->request->params['controller'] !== 'specials') {
		echo $this->element('specials', array('plugin' => 'shop'));
	}

	if($this->request->params['controller'] !== 'spotlights') {
		echo $this->element('spotlights', array('plugin' => 'shop'));
	}