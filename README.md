Sort select
===========

Installation
------------

```sh
$ composer require geniv/nette-sort-select
```
or
```json
"geniv/nette-sort-select": ">=1.0.0"
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
    - SortSelect
```

presenter usage:
```php
protected function createComponentSortSelect(SortSelect $sortSelect): SortSelect
{
    $sortSelect->setTemplatePath(__DIR__ . '/templates/sortSelect.latte');
    $sortSelect->setParameter('order', 'asc');
    $sortSelect->addLink('Abecedně A - Z', 'Sort!', ['order' => 'asc']);
    $sortSelect->addLink('Abecedně Z - A', 'Sort!', ['order' => 'desc']);
    return $sortSelect;
}
```

latte usage:
```latte
{control sortSelect}
```
