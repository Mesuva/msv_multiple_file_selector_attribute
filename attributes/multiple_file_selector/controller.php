<?php
namespace Concrete\Package\MsvMultipleFileSelectorAttribute\Attribute\MultipleFileSelector;

use Concrete\Core\Asset\AssetList;
use Concrete\Core\File\File;
use Concrete\Core\Attribute\DefaultController;
use Concrete\Core\Attribute\FontAwesomeIconFormatter;
use Concrete\Core\Entity\Attribute\Value\Value\TextValue;
use Concrete\Package\MsvMultipleFileSelectorAttribute\Entity\Attribute\Key\Settings\MultipleFileSelectorSettings;


class Controller extends DefaultController
{
    public function getIconFormatter()
    {
        return new FontAwesomeIconFormatter('images fa-files-o');
    }

    public function getSearchIndexValue()
    {
        $string = '';
        $value = $this->getValue();
        if (is_array($value)) {
            foreach($value as $file) {
                $string .= $file->getTitle() . ' ';
            }
        }

        return trim($string);
    }

	public function getValue(){
        $fileIDs = $this->getFileIDsValue();
        $files = [];

        foreach($fileIDs as $fID) {
            $file = File::getByID($fID);
            if ($file) {
                $files[] = $file;
            }
        }

        return $files;
    }

    public function getDisplayValue() {
        return $this->getFileIDsValue();
    }

	private function getFileIDsValue() {
        $fileIDs = [];

        if ($this->attributeValue) {
            $value = $this->attributeValue->getValueObject();
            if ($value) {
                $value = (string)$value->getValue();
            }

            if ($value) {
                $fileIDs = explode(',', $value);
            }
        }

		return $fileIDs;
	}

    public function createAttributeValue($value)
    {
        $av = new TextValue();
        $av->setValue($value);

        return $av;
    }

    public function createAttributeValueFromRequest()
    {
        $data = $this->post();
        $list = '';
        if (isset($data['value']) && is_array($data['value'])) {
            $list = implode(',', $data['value']);
        }

        return $this->createAttributeValue($list);
    }

 	public function form() {
        $values =  $this->getValue();
        $settings = $this->getAttributeKeySettings();
		$this->set('values', $values);
		$this->set('type', $settings->getType());
		$this->set('maxItems', $settings->getMaxItems());
		$this->set('id', $this->app->make('helper/validation/identifier')->getString(8));

        $multiple = true;

        $al = AssetList::getInstance();
        if ($al->getAssetGroup('core/file-manager')) {
            $this->requireAsset('core/file-manager');
            $multiple = false;
        }

        $this->set('multiple', $multiple);

	}

    public function composer()
    {
        $this->form();
    }

	public function type_form() {
        $settings = $this->getAttributeKeySettings();
        $this->set('akType', $settings->getType());
        $this->set('akMaxItems', $settings->getMaxItems());
		$this->set('form', $this->app->make('helper/form'));
		$this->set('page_selector', $this->app->make('helper/form/page_selector'));
	}

    public function getAttributeKeySettingsClass()
    {
        return MultipleFileSelectorSettings::class;
    }

    public function getAttributeValueClass()
    {
        return TextValue::class;
    }

    protected function load()
    {
        $ak = $this->getAttributeKey();
        if (!is_object($ak)) {
            return false;
        }

        $type = $ak->getAttributeKeySettings();
    }

    public function saveKey($data)
    {
        $settings = $this->getAttributeKeySettings();
        $settings->setType($data['akType']);
        $settings->setMaxItems($data['akMaxItems']);

        return $settings;
    }

    public function exportKey($akey)
    {
        $settings = $this->getAttributeKeySettings();
        $akey->addChild('type')->addAttribute('type', $settings->getType());
        $akey->addChild('maxFiles')->addAttribute('maxFiles', $settings->getMaxFiles());

        return $akey;
    }

    public function importKey(\SimpleXMLElement $akey)
    {
        $type = $this->getAttributeKeySettings();
        if (isset($akey->type)) {
            $type->setType((string) $akey->type['type']);
            $type->setMaxFiles((int) $akey->type['maxFiles']);
        }

        return $type;
    }


}
