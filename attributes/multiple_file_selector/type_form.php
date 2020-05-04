<?php defined('C5_EXECUTE') or die("Access Denied.");

use Concrete\Core\File\Type\Type as FileType;

?>

<?php
$typeList = array();
$typeList['any'] = t('Any file type');
$typeList['image'] = t('Image file types');
$typeList['video'] = t('Video file types');
$typeList['text'] = t('Text file types');
$typeList['audio'] = t('Audio file types');
$typeList['doc'] = t('Document file types');
$typeList['app'] = t('Application file types');
?>

<fieldset class="ccm-attribute ccm-attribute-multipage">
    <legend><?php echo t('Restrictions')?></legend>
    <div class="form-group">
        <label><?php echo t("Selectable File Types")?></label>
        <select class="form-control" name="akType" id="akType">
            <?php if (is_array($typeList)) {
                foreach ($typeList as $type=>$label) { ?>
                    <option value="<?php echo $type ?>" <?php if ($type == $akType) { ?> selected <?php } ?>>
                        <?php echo $label; ?>
                    </option>
                    <?php
                }
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label><?php echo t("Maximum Number Of Files")?></label>
        <?php echo $form->number('akMaxItems', (isset($akMaxItems) ? $akMaxItems : 0), array('min'=>'0','step'=>'1')); ?>
        <span class="help-block"><?php echo t('Enter 0 or blank for no limit');?></span>
    </div>
</fieldset>
