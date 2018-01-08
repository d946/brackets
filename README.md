# Brackets verify

[![Build Status](https://travis-ci.org/d946/brackets.svg?branch=master)](https://travis-ci.org/d946/brackets)

[![codecov](https://codecov.io/gh/d946/brackets/branch/master/graph/badge.svg)](https://codecov.io/gh/d946/brackets)

[![Latest Version](https://img.shields.io/packagist/v/d946/brackets.svg?style=flat)](https://packagist.org/packages/d946/brackets)

## Installing
```
composer require d946/brackets
```

## Basic usage
```php
<?php

$checker = new D946\Brackets();

$checker->load('()'); 
if ($checker->verify()){
  // it's ok   
} else {
  // wrong    
}

```