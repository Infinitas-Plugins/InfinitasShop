<?php
App::uses('ShopImageIterator', 'Shop.Lib');

class ImageImportShell extends AppShell {

	public $uses = array(
		'Shop.ShopImage'
	);

	public $imageCommand = 'convert "%s" -fuzz 20%% -trim -shave 10%%x0 -gravity South -crop 50%%\! -colors 100 -resize 1x2\! "%s"';

/**
 * @brief add the option for selecting the import type
 *
 * @return ConsoleOptionParser
 */
	public function getOptionParser() {
		$parser = parent::getOptionParser();
		$parser->description(array(
			'Mass product importer for various product types. Passing no option',
			'will cause <warning>all</warning> available imports to be run. If a valid',
			'option is passed only the selected import will be run'
		))->addOption('folder', array(
			'help' => 'The folder to import from',
			'short' => 'f',
			'required' => true
		));

		return $parser;
	}

	public function main() {
		if (empty($this->params['folder'])) {
			$this->params['folder'] = TMP;
		}
		$this->params['folder'] = rtrim($this->params['folder'], DS) . DS;

		$ShopImage = ClassRegistry::init('Shop.ShopImage');
		$images = array();
		$ImageIterator = new ShopImageIterator(new DirectoryIterator($this->params['folder']));
		for ($ImageIterator->rewind(); $ImageIterator->valid(); $ImageIterator->next()) {
			$image = array(
				'image' => array(
					'name' => $ImageIterator->current()->getFilename(),
					'size' => $ImageIterator->current()->getSize(),
					'type' => mime_content_type($ImageIterator->current()->getPathname()),
					'tmp_name' => $ImageIterator->current()->getPathname()
				),
				'ext' => $ImageIterator->current()->getExtension()
			);
			$ShopImage->create();
			$saved = $ShopImage->save($image);

			if (!$saved) {
				print_r($ShopImage->validationErrors);
				print_r($image);
				exit;
			}
		}
	}
/**
 * Get the main colour of the images
 * 
 * @return void
 */
	public function mainColour() {
		$images = $this->ShopImage->find('all', array(
			'conditions' => array(
				'ShopImage.colour_1 IS NULL'
			)
		));

		$count = count($images);
		foreach ($images as $k => $image) {
			$this->out(sprintf('%s of %d: %s', str_pad($k+1, strlen($count), ' ', STR_PAD_LEFT), $count, $image['ShopImage']['image_full']));
			$colours = $this->_colour(APP . 'webroot/' . $image['ShopImage']['image_full']);
			$image['ShopImage']['colour_1'] = $colours[0];
			$image['ShopImage']['colour_2'] = $colours[1];
			$this->ShopImage->save($image['ShopImage']);
		}
	}

/**
 * Process the image and calculate the colour
 * 
 * @param string $image the full path to the image to be processed
 * 
 * @return array
 */
	protected function _colour($image) {
		$out = TMP . 'image.png';
		$command = sprintf($this->imageCommand, $image, $out);
		`$command`;

		$Image = imagecreatefrompng($out);

		return array(
			$this->_convert(imagecolorat($Image, 0, 0)),
			$this->_convert(imagecolorat($Image, 0, 1)),
		);
	}

/**
 * Convert a integer to hex 
 * 
 * @param integer $colour the integer rgb value from imagecolorat
 * 
 * @return string
 */
	protected function _convert($colour) {
		$r = dechex(($colour >> 16) & 0xFF);
		$g = dechex(($colour >> 8) & 0xFF);
		$b = dechex($colour & 0xFF);

		return implode('', array(
			str_pad($r, 2, $r),
			str_pad($g, 2, $g),
			str_pad($b, 2, $b),
		));
	}
}
