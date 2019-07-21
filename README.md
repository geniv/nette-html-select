Html select
===========

Installation
------------

```sh
$ composer require geniv/nette-html-select
```
or
```json
"geniv/nette-html-select": ">=1.0"
```

require:
```json
"php": ">=7.0",
"nette/application": ">=2.4",
"nette/utils": ">=2.4",
"geniv/nette-general-form": ">=1.0"
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

    // add all in one - strict internal check route for method: setRoute()
    $htmlSelect->setRoute('SwitchFkId!');
    $htmlSelect->setPrompt('-- žádný výběr --');
    $htmlSelect->clearItems();
    $htmlSelect->addItem('name', 'param');
    $htmlSelect->setItems([1 => 'a', 2 => 'b']);
    $htmlSelect->setItems([1 => 'a', 2 => 'b'], false);

    $htmlSelect->addVariableTemplate([1 => 'a']);
    
    $htmlSelect->setActiveValue('aaaxx');

    // add step by step - nothing internal check
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
