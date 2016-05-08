VRiaEnhancedFileBundle
=============

[![Build Status](https://travis-ci.org/riabchenkovlad/enhanced-file.svg?branch=symfony23)](https://travis-ci.org/riabchenkovlad/enhanced-file)

File type for Symfony forms with additional functionality:

- if file has been previously uploaded, the download link is rendered
- previously uploaded file can be deleted if new one is uploaded

Check out this [blogpost](https://vria.eu/news/2016/4/10/creating-enhanced-file-type-for-symfony-forms) to know the details of implementation.


##Installation

Using [Composer](http://packagist.org), run:
```sh
composer require vria/enhanced-file
```

Add the VRiaNoDiacriticBundle to your application kernel:

```php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new VRia\Bundle\EnhancedFileBundle\VRiaEnhancedFileBundle(),
    );
}
```


##Use

In Symfony 3 you should use:

```php
$form = $this->createFormBuilder()
    ->add('file', EnhancedFileType::class, $options)
    ...
```

While in Symfony ~2.3:

```php
$form = $this->createFormBuilder()
    ->add('file', 'enhanced_file', $options)
    ...
```

`$options` is an array of options form FormType Field enlarged with:

- `directory_path` - physycal directory to put files. E.g. `$this->get('kernel')->getRootDir() . '/../web/upload/'`. *Required*
- `public_directory_path` - path from your public directory (often `/web`) to directory with files. E.g. `'/upload/'`. *Required*
- `delete_previous_file` - whether to delete previously uploaded file. Default value is `true`

So, the complete definition could be:

```php
$form = $this->createFormBuilder()
    ->add('file', EnhancedFileType::class, array(
        'label' => 'Curriculum vitae',
        'directory_path' => $this->get('kernel')->getRootDir() . '/../web/upload/',
        'public_directory_path' => '/upload/',
        'required' => false
    ))
```
