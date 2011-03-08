<?php

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony'     => __DIR__.'/../vendor/symfony/src',
    'Bench'       => __DIR__.'/../src',
    'Assetic'     => __DIR__.'/../vendor/assetic/src',
    'Zend\\Log'   => __DIR__.'/../vendor/zend-log',
));
$loader->registerPrefixes(array(
    'Twig_Extensions_'   => __DIR__.'/../vendor/twig-extensions/lib',
    'Twig_'              => __DIR__.'/../vendor/twig/lib',
));
$loader->register();
