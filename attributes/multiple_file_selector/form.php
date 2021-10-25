<?php

defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\File\Type\Type as FileType;

echo '<ul style="margin-bottom: 10px" class="list-group multiple-file-list" id="' . $id . '">';
if (!empty($values)) {
    foreach ($values as $file) {
        $thumb = $file->getListingThumbnailImage();
        echo '<li class="list-group-item"><i class="fa fa-arrows-v"></i>' . $thumb . ' ' . $file->getTitle() . '<a><i class="pull-right float-right fa fa-minus-circle"></i></a><input type="hidden" name="' . $this->field('value') . '[]" value="' . $file->getFileID() . '" /></li>';
    }
}
echo '</ul>';

switch ($type) {
    case 'file':
        $filetype = FileType::T_UNKNOWN;
        $label = t('Choose Files');
        break;
    case 'image':
        $filetype = FileType::T_IMAGE;
        $label = t('Choose Images');
        break;
    case 'video':
        $filetype = FileType::T_VIDEO;
        $label = t('Choose Video Files');
        break;
    case 'text':
        $filetype = FileType::T_TEXT;
        $label = t('Choose Text Files');
        break;
    case 'audio':
        $filetype = FileType::T_AUDIO;
        $label = t('Choose Audio Files');
        break;
    case 'doc':
        $filetype = FileType::T_DOCUMENT;
        $label = t('Choose Documents');
        break;
    case 'app':
        $filetype = FileType::T_APPLICATION;
        $label = t('Choose Application Files');
        break;
    default:
        $filetype = '';
        $label = t('Choose Files');

}

$hide = '';

if ($maxItems > 0 && count($values) >= $maxItems) {
    $hide = 'hidden';
}

$filter = ", filters : []";
$check = 'if(true){';

if ($filetype) {
    $filter = ", filters : [{ field : 'type', type : '" . $filetype . "' }]";
    $check = 'if (file.genericTypeText == "' . FileType::getGenericTypeText($filetype) . '") {';
}

echo "<div href=\"#\" id=\"" . $id . "_launch\" data-max-items=\"" . $maxItems . "\" data-launch=\"file-manager\" class=\"ccm-file-selector btn btn-primary " . $hide . "\">" . $label . "</div>
<script type=\"text/javascript\">
		$(function() {
			$('#" . $id . "_launch').on('click', function(e) {
				e.preventDefault();

				var options = {
      				multipleSelection:  " . ($multiple ? 'true' : 'false') . $filter . "
 				}

				ConcreteFileManager.launchDialog(function (data) {
					ConcreteFileManager.getFileDetails(data.fID, function(r) {
						var maxItems = 	$('#" . $id . "_launch').data('max-items');
						var currentItems = $('#" . $id . " li').length;

						if (maxItems > 0 && r.files.length > (maxItems - currentItems)) {
							var toomanymessage = '" . t('Please select a maximum of %1$s files to add, %2$s of %3$s files are currently selected') . "';" . '
							var remaining = maxItems - currentItems;
							toomanymessage = toomanymessage.replace(\'%1$s\',remaining);
							toomanymessage = toomanymessage.replace(\'%2$s\',currentItems);
							toomanymessage = toomanymessage.replace(\'%3$s\',maxItems);
							alert(toomanymessage);
							' . "
						} else {
							for(var i in r.files) {
								var file = r.files[i];
								" . $check . "
									$('#" . $id . "').append('<li class=\"list-group-item\"><i class=\"fa fa-arrows-v\"></i>'+ file.resultsThumbnailImg +' ' +  file.title +'<a><i class=\"pull-right fa fa-minus-circle\"></i></a><input type=\"hidden\" name=\"" . $this->field('value') . "[]\" value=\"' + file.fID + '\" /></li>');
									$('#ccm-panel-detail-page-attributes').animate({scrollTop: '+=83px'}, 0);

									var currentItems = $('#" . $id . " li').length;

									if (maxItems > 0 && currentItems >= maxItems) {
										$('#" . $id . "_launch').addClass('hidden');
									}
								} else {
									alert('" . t('Please select only %s file types', t($filetype ? FileType::getGenericTypeText($filetype) : 'file')) . "');
								}
							}
						}
					});
				},options);
			});

			$('#" . $id . "').sortable({ 
			axis: 'y', 
			forcePlaceholderSize: true, 
			opacity: 0.5
			});

			$('#" . $id . "').on('click', 'a', function(){
				$(this).parent().remove();
				var maxItems = 	$('#" . $id . "_launch').data('max-items');
				if (maxItems > 0 && $('#" . $id . " li').length < maxItems) {
					$('#" . $id . "_launch').removeClass('hidden');
				}
			});
		});
		</script>
<style>
    .ccm-ui .multiple-file-list li {cursor: move;}
    .ccm-ui .multiple-file-list .fa-arrows-v {margin-right: 10px;}
    .ccm-ui .multiple-file-list img {max-width: 60px!important; display: inline!important; margin-right: 10px;}
    .ccm-ui .multiple-file-list .fa {cursor: pointer}
    .ccm-ui .multiple-file-list a:hover {color: red} 
</style>
";
