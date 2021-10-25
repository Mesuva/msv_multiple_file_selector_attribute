<?php
// Author: Ryan Hewitt - http://www.mesuva.com.au
namespace Concrete\Package\MsvMultipleFileSelectorAttribute;

use Concrete\Core\Package\Package;

class Controller extends Package {

	protected $pkgHandle = 'msv_multiple_file_selector_attribute';
	protected $appVersionRequired = '8.0';
	protected $pkgVersion = '0.9';

	public function getPackageDescription() {
		return t("Attribute that allows the selection of multiple files/images");
	}

	public function getPackageName() {
		return t("Multiple File Selector Attribute");
	}

	public function install() {
        $pkg = parent::install();

        $factory = $this->app->make('Concrete\Core\Attribute\TypeFactory');
        $type = $factory->getByHandle('multiple_file_selector');
        if (!is_object($type)) {
            $type = $factory->add('multiple_file_selector', t('Multiple Image/File'), $pkg);
        }

        $category = $this->app->make('Concrete\Core\Attribute\Category\CategoryService')->getByHandle('collection')->getController();
        $category->associateAttributeKeyType($type);
	}
}
