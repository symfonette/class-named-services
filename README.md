Class Named Services
====================

[![Packagist](https://img.shields.io/packagist/v/webuni/commonmark-attributes-extension.svg?style=flat-square)](https://packagist.org/packages/webuni/commonmark-attributes-extension)
[![Build Status](https://img.shields.io/travis/webuni/commonmark-attributes-extension.svg?style=flat-square)](https://travis-ci.org/webuni/commonmark-attributes-extension)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/webuni/commonmark-attributes-extension.svg?style=flat-square)](https://scrutinizer-ci.com/g/webuni/commonmark-attributes-extension)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/8fbbdeb9-d7ba-4c5c-8d88-db950a668265.svg?style=flat-square)](https://insight.sensiolabs.com/projects/8fbbdeb9-d7ba-4c5c-8d88-db950a668265)

The Attributes extension adds a syntax to define attributes on the various HTML elements in markdown’s output.

Installation
------------

This project can be installed via Composer:

    composer require symfonette/class-named-services

Standalone

```php
$builder = new ContainerBuilder
```

Symfony Bundle

```php
use Symfonette\DependencyInjection\ClassNamedServices\Bundle\SymfonetteClassNamedServicesBundle;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            // ...
            new SymfonetteClassNamedServicesBundle,
            // ...
        ];
    }
}
```
    
Usage
-----

In definition

```yaml
services:
    class:
    
    '@Symfony\Component'
```

In controller

```php
class extends Controller
{
    public function Action()
    {
        $validator = $this->get(Validator::class);
    }
}
```
