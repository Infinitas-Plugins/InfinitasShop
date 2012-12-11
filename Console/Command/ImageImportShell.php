<?php
App::uses('ShopImageIterator', 'Shop.Lib');

class ImageImportShell extends AppShell {

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
}
