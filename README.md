Html select
===========

Installation
------------

```sh
$ composer require geniv/nette-html-select
```
or
```json
"geniv/nette-html-select": ">=1.0.0"
```

require:
```json
"php": ">=7.0.0",
"nette/nette": ">=2.4.0",
"geniv/nette-general-form": ">=1.0.0"
```

Include in application
----------------------

neon configure services:
```neon
services:
    - HtmlSelect
```

presenter usage:
```php
protected function createComponentHtmlSelect(HtmlSelect $htmlSelect): HtmlSelect
{
    $htmlSelect->setTemplatePath(__DIR__ . '/templates/htmlSelect.latte');
    $htmlSelect->setParameter('order', 'asc');
    $htmlSelect->addLink('Abecedně A - Z', 'Sort!', ['order' => 'asc']);
    $htmlSelect->addLink('Abecedně Z - A', 'Sort!', ['order' => 'desc']);
    return $htmlSelect;
}
```

latte usage:
```latte
{control htmlSelect}
```
