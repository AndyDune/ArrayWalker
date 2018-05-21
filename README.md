# ArrayWalker

[![Build Status](https://travis-ci.org/AndyDune/ArrayWalker.svg?branch=master)](https://travis-ci.org/AndyDune/ArrayWalker)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/andydune/array-walker.svg?style=flat-square)](https://packagist.org/packages/andydune/array-walker)
[![Total Downloads](https://img.shields.io/packagist/dt/andydune/array-walker.svg?style=flat-square)](https://packagist.org/packages/andydune/array-walker)


Better implementation foreach operator with nested array compability.


Installation
------------

Installation using composer:

```
composer require andydune/array-walker
```
Or if composer didn't install globally:
```
php composer.phar require andydune/array-walker
```
Or edit your `composer.json`:
```
"require" : {
     "andydune/array-walker": "^1"
}

```
And execute command:
```
php composer.phar update
```

Example
------------

```php
use AndyDune\ArrayWalker\ArrayWalker;
use AndyDune\ArrayWalker\ItemContainer;

// Source array
$array = [
    'one' => 1,
    'two' => 2,
    'three' => 3,
];

$arrayWalker = new ArrayWalker($array);
// Change values
$arrayWalker->addFunction(function (ItemContainer $item) {
    $item->setValue($item->getValue() + 10);
});
$result = $arrayWalker->apply();
$result = [
    'one' => 11,
    'two' => 12,
    'three' => 13,
];

$arrayWalker = new ArrayWalker($array);
// Change keys
$arrayWalker->addFunction(function (ItemContainer $item) {
   $item->setKey(strtoupper($item->getKey()));
});
$result = $arrayWalker->apply();
$result = [
    'ONE' => 1,
    'TWO' => 2,
    'THREE' => 3,
];


$arrayWalker = new ArrayWalker($array);
// Delete value 
$arrayWalker = new ArrayWalker($array);
$arrayWalker->addFunction(function (ItemContainer $item) {
    $item->setValue($item->getValue() + 10);
    if ($item->getKey() == 'one') {
        $item->delete();
    }
});
$result = $arrayWalker->apply();

$result = [
    'two' => 12,
    'three' => 13,
];
```