Class Named Services
====================

[![Packagist](https://img.shields.io/packagist/v/symfonette/class-named-services.svg?style=flat-square)](https://packagist.org/packages/symfonette/class-named-services)
[![Build Status](https://img.shields.io/travis/symfonette/class-named-services.svg?style=flat-square)](https://travis-ci.org/symfonette/class-named-services)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/symfonette/class-named-services.svg?style=flat-square)](https://scrutinizer-ci.com/g/symfonette/class-named-services)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/2f5b60cc-519e-468c-a9cc-6d0eed908012.svg?style=flat-square)](https://insight.sensiolabs.com/projects/2f5b60cc-519e-468c-a9cc-6d0eed908012)

All services can be accessed by FQCN.

Installation
------------

This project can be installed via Composer:

    composer require symfonette/class-named-services

#### Standalone

```php
use Symfonette\ClassNamedServices\ContainerBuilderConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;

$builder = new ContainerBuilder();
$configurator = new ContainerBuilderConfigurator();

$configurator->configure($builder);

```

#### Symfony Bundle

```php
use Symfonette\ClassNamedServices\Bundle\ClassNamedServiceBundle;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            // ...
            new ClassNamedServiceBundle,
            // ...
        ];
    }
}
```

Usage
-----

In dependency injection definition:

```yaml
# app/config/services.yml
services:
    controller_main:
        class: AppBundle\Controller\MainController
        arguments:
            - '@Symfony\Bridge\Doctrine\RegistryInterface'
            - '@Twig_Environment'
```

In routing definition:

```yaml
# app/config/routing.yml
homepage:
    path: /
    defaults:
      _controller: AppBundle\Controller\MainController:homepage
```

In controller:

```php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    public function formAction()
    {
        $validator = $this->get(Validator::class);
        // ...
    }
}
```
