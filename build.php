<?php

require_once __DIR__ . '/capusta.php';

$capusta['build'] = function () {
    $files = array(
        __DIR__ . '/capusta.php',
            __DIR__ . '/vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php',
        __DIR__ . '/src/Rithis/Capusta.php',
            __DIR__ . '/vendor/Pimple/lib/Pimple.php',
            __DIR__ . '/vendor/Symfony/Component/Console/Output/ConsoleOutput.php',
                __DIR__ . '/vendor/Symfony/Component/Console/Output/StreamOutput.php',
                    __DIR__ . '/vendor/Symfony/Component/Console/Output/Output.php',
                        __DIR__ . '/vendor/Symfony/Component/Console/Output/OutputInterface.php',
                        __DIR__ . '/vendor/Symfony/Component/Console/Formatter/OutputFormatter.php',
                __DIR__ . '/vendor/Symfony/Component/Console/Formatter/OutputFormatterInterface.php',
            __DIR__ . '/vendor/Symfony/Component/Console/Input/ArgvInput.php',
                __DIR__ . '/vendor/Symfony/Component/Console/Input/Input.php',
                    __DIR__ . '/vendor/Symfony/Component/Console/Input/InputInterface.php',
            __DIR__ . '/vendor/Symfony/Component/Process/Process.php',
            __DIR__ . '/src/Rithis/InputDefinition.php',
                __DIR__ . '/vendor/Symfony/Component/Console/Input/InputDefinition.php',
                __DIR__ . '/vendor/Symfony/Component/Console/Input/InputArgument.php',
                __DIR__ . '/vendor/Symfony/Component/Console/Input/InputOption.php',
            __DIR__ . '/src/Rithis/TaskProviderInterface.php',
    );

    $phar = new Phar(__DIR__ . '/build/capusta.phar');

    foreach ($files as $file) {
        $phar->addFile($file);
    }

    $phar->setStub('<?php Phar::mapPhar("capusta.phar"); include "capusta.php"; __HALT_COMPILER();');
};
