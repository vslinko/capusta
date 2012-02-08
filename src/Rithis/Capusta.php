<?php

namespace Rithis;

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Process\Process;

class Capusta extends \Pimple
{
    public $output;

    public function __construct()
    {
        $this->output = new ConsoleOutput();
        $this->register(new DefaultTaskProvider());
    }

    public function __destruct()
    {
        try {
            $input = new ArgvInput(null, new InputDefinition($this));

            $tasks = array_reverse($input->getArgument('tasks'));

            if (count($tasks) == 0) {
                $this->abort('Sorry, you didn\'t specify some task');
            }

            foreach ($tasks as $task) {
                if (!$this->taskExists($task)) {
                    $this->abort(sprintf('Task <info>%s</info> not found', $task));
                }
            }

            $lastTask = array_pop($tasks);

            foreach ($tasks as $task) {
                $this[$task];
            }

            foreach ($input->getOptions() as $key => $value) {
                $this[$key] = $value;
            }

            $this[$lastTask];

        } catch (\Exception $e) {
            $this->abort($e->getMessage());
        }
    }

    public function abort($message, $code = 1)
    {
        $this->output->getErrorOutput()->writeln($message);
        exit($code);
    }

    public function execute($command)
    {
        $capusta = $this;

        $process = new Process($command);
        $process->run(function ($type, $data) use ($capusta) {
            if ($type == 'out') {
                $capusta->output->write($data);
            } else {
                $capusta->output->getErrorOutput()->write($data);
            }
        });

        return $process->isSuccessful();
    }

    public function taskExists($id)
    {
        return $this->offsetExists($id) && $this->raw($id) instanceof \Closure;
    }

    public function register(TaskProviderInterface $provider, array $values = array())
    {
        $provider->register($this);

        foreach ($values as $key => $value) {
            $this[$key] = $value;
        }
    }
}
