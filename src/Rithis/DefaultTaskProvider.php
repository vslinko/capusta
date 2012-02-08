<?php

namespace Rithis;

class DefaultTaskProvider implements TaskProviderInterface
{
    public function register(Capusta $capusta)
    {
        /**
         * Print this help
         */
        $capusta['help'] = function (Capusta $capusta) {
            $tasks = array();
            $parameters = array();

            $pimpleValuesRef = new \ReflectionProperty('Pimple', 'values');
            $pimpleValuesRef->setAccessible(true);

            foreach ($pimpleValuesRef->getValue($capusta) as $key => $value) {
                if ($value instanceof \Closure) {
                    $taskRef = new \ReflectionFunction($value);

                    $description = explode("\n", $taskRef->getDocComment());

                    if (count($description) > 1) {
                        $description = $description[1];
                        $description = trim(preg_replace('/^\s+\*/', '', $description));
                    } else {
                        $description = "";
                    }

                    $tasks[] = sprintf('<info>%-24s</info>%s', $key, $description);
                } else {
                    $parameters[] = sprintf('<info>--%s</info>', $key);
                }
            }

            sort($parameters);
            sort($tasks);

            if (count($parameters) > 0) {
                $capusta->output->writeln('Available parameters:');
                foreach ($parameters as $parameter) {
                    $capusta->output->write('    ');
                    $capusta->output->writeln($parameter);
                }
                $capusta->output->writeln('');
            }

            $capusta->output->writeln('Available tasks:');

            foreach ($tasks as $task) {
                $capusta->output->write('    ');
                $capusta->output->writeln($task);
            }

            $pimpleValuesRef->setAccessible(false);
        };
    }
}
