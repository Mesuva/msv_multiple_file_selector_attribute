# Multiple File Selector Attribute

A multiple file selector attribute for concrete5 version v8.

- Allow multiple files to be selected from the file manager
- Selected files can be dragged and dropped to re-order
- Attribute can restrict selection to a type of file (images, documents, audio, etc)
- A maximum number of items can be also configured

Once installed, you can fetch the attribute in a page template one of two ways:

```php
$fileList = $c->getAttribute('gallery_files');
// $fileList now contains an array of file objects. This can be looped over, output as a gallery, etc


For reference, the original string with comma seperated ID values can be retrived via:
$fileListIDs = $c->getAttribute('gallery_files', 'raw');
```
