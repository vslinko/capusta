<?php

require_once __DIR__ . '/vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();

$loader->registerNamespaces(array(
    'Symfony' => __DIR__ . '/vendor',
    'Rithis' => __DIR__ . '/src',
));

$loader->registerPrefixes(array(
    'Pimple' => __DIR__ . '/vendor/Pimple/lib',
));

$loader->register();

$capusta = new Rithis\Capusta();
