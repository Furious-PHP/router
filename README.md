## Router

Simple router for PSR-7 requests. PHP 7.4+

[![Latest Version](https://img.shields.io/github/release/Furious-PHP/router.svg?style=flat-square)](https://github.com/Arslanoov/furious-router/releases)
[![Build Status](https://scrutinizer-ci.com/g/Furious-PHP/router/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Furious-PHP/router/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/Furious-PHP/router/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Quality Score](https://img.shields.io/scrutinizer/g/Furious-PHP/router.svg?style=flat-square)](https://scrutinizer-ci.com/g/Furious-PHP/router)
[![Maintainability](https://api.codeclimate.com/v1/badges/71ecfc66e6100d3ffa0d/maintainability)](https://codeclimate.com/github/Furious-PHP/router/maintainability)
[![Total Downloads](https://poser.pugx.org/furious/router/downloads)](https://packagist.org/packages/furious/router)
[![Monthly Downloads](https://poser.pugx.org/furious/router/d/monthly.png)](https://packagist.org/packages/furious/router)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

Install:

    composer require furious/router

Use:

    $routes = new RouteCollection();
    
    // Add route
    $routes->get('home', '/path', SomeHandler::class);
    
    $router = new Router($routes);
    
    // '/path'
    $router->generate('home');
    
    // Match route
    $router->match($psr7Request);
    
    // Add route in router
    $router->addRoute(new Route('about', '/about', AboutHandler::class, 'GET'));
    
