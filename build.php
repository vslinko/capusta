<?php

require_once __DIR__ . '/capusta.php';

$capusta['build'] = function () {
    $files = array(
        __DIR__ . '/src/Rithis/Capusta.php' => 'Rithis/Capusta.php',
        __DIR__ . '/src/Rithis/InputDefinition.php' => 'Rithis/InputDefinition.php',
        __DIR__ . '/src/Rithis/DefaultTaskProvider.php' => 'Rithis/DefaultTaskProvider.php',
        __DIR__ . '/src/Rithis/TaskProviderInterface.php' => 'Rithis/TaskProviderInterface.php',
        __DIR__ . '/vendor/Pimple/lib/Pimple.php' => 'Pimple.php',
        __DIR__ . '/vendor/Symfony/Component/Console/Output/ConsoleOutput.php' => 'Symfony/Component/Console/Output/ConsoleOutput.php',
        __DIR__ . '/vendor/Symfony/Component/Console/Output/ConsoleOutputInterface.php' => 'Symfony/Component/Console/Output/ConsoleOutputInterface.php',
        __DIR__ . '/vendor/Symfony/Component/Console/Output/StreamOutput.php' => 'Symfony/Component/Console/Output/StreamOutput.php',
        __DIR__ . '/vendor/Symfony/Component/Console/Output/Output.php' => 'Symfony/Component/Console/Output/Output.php',
        __DIR__ . '/vendor/Symfony/Component/Console/Output/OutputInterface.php' => 'Symfony/Component/Console/Output/OutputInterface.php',
        __DIR__ . '/vendor/Symfony/Component/Console/Formatter/OutputFormatter.php' => 'Symfony/Component/Console/Formatter/OutputFormatter.php',
        __DIR__ . '/vendor/Symfony/Component/Console/Formatter/OutputFormatterInterface.php' => 'Symfony/Component/Console/Formatter/OutputFormatterInterface.php',
        __DIR__ . '/vendor/Symfony/Component/Console/Formatter/OutputFormatterStyle.php' => 'Symfony/Component/Console/Formatter/OutputFormatterStyle.php',
        __DIR__ . '/vendor/Symfony/Component/Console/Formatter/OutputFormatterStyleInterface.php' => 'Symfony/Component/Console/Formatter/OutputFormatterStyleInterface.php',
        __DIR__ . '/vendor/Symfony/Component/Console/Input/ArgvInput.php' => 'Symfony/Component/Console/Input/ArgvInput.php',
        __DIR__ . '/vendor/Symfony/Component/Console/Input/Input.php' => 'Symfony/Component/Console/Input/Input.php',
        __DIR__ . '/vendor/Symfony/Component/Console/Input/InputInterface.php' => 'Symfony/Component/Console/Input/InputInterface.php',
        __DIR__ . '/vendor/Symfony/Component/Console/Input/InputDefinition.php' => 'Symfony/Component/Console/Input/InputDefinition.php',
        __DIR__ . '/vendor/Symfony/Component/Console/Input/InputArgument.php' => 'Symfony/Component/Console/Input/InputArgument.php',
        __DIR__ . '/vendor/Symfony/Component/Console/Input/InputOption.php' => 'Symfony/Component/Console/Input/InputOption.php',
        __DIR__ . '/vendor/Symfony/Component/Process/Process.php' => 'Symfony/Component/Process/Process.php',
    );

    $phar = new Phar(__DIR__ . '/build/capusta.phar');

    foreach ($files as $localFile => $pharFile) {
        $phar->addFile($localFile, $pharFile);
    }

    $phar->setStub('<?php
        Phar::mapPhar("capusta.phar");
        spl_autoload_register(function ($class) {
            include "phar://capusta.phar/" . str_replace("\\\", "/", $class) . ".php";
        });
        $capusta = new Rithis\Capusta();
        __HALT_COMPILER();
    ?>');
};
