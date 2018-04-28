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

    // add all in one
    $htmlSelect->setRoute('SwitchFkId!');
    $htmlSelect->setPrompt('-- žádný výběr --');
    $htmlSelect->addItem(3, 'c');
    $htmlSelect->setItems([1 => 'a', 2 => 'b']);
    $htmlSelect->setItems([1 => 'a', 2 => 'b'], false);

    $htmlSelect->addVariableTemplate([1 => 'a']);

    // add step by step
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
