<?php

namespace Rithis;

use Symfony\Component\Console\Input\InputDefinition as BaseInputDefinition;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class InputDefinition extends BaseInputDefinition
{
    private $capusta;

    public function __construct(Capusta $capusta)
    {
        parent::__construct();

        $this->capusta = $capusta;

        $this->addArgument(new InputArgument('tasks', InputArgument::IS_ARRAY));
    }

    public function hasShortcut($name)
    {
        return false;
    }

    public function hasOption($name)
    {
        if ($this->capusta->taskExists($name)) {
            return false;
        }

        if (!parent::hasOption($name)) {
            $mode = InputOption::VALUE_REQUIRED | (isset($this->capusta[$name]) && is_array($this->capusta[$name]) ? InputOption::VALUE_IS_ARRAY : 0);
            $this->addOption(new InputOption($name, null, $mode));
        }

        return true;
    }
}
