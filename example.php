<?php

require_once __DIR__ . '/capusta.php';

class DeployTaskProvider implements Rithis\TaskProviderInterface
{
    public function register(Rithis\Capusta $capusta)
    {
        $capusta['host'] = array();
        $capusta['checkout'] = "HEAD";


        $capusta['deploy'] = function (Rithis\Capusta $capusta) {
            foreach ($capusta['host'] as $host) {
                $capusta->execute("ssh $host 'cd /var/www; php capusta.php update --checkout={$capusta['checkout']}'");
            }
        };

        $capusta['update'] = function (Rithis\Capusta $capusta) {
            $capusta->execute('git pull');
            $capusta->execute("git checkout {$capusta['checkout']}");
            $capusta->execute('git submodule update --init');
        };
    }
}

$capusta['production'] = function (Rithis\Capusta $capusta) {
    $capusta['host'] = array('example.com');
};

$capusta->register(new DeployTaskProvider(), array(
    'host' => array('dev.example.com'),
));
