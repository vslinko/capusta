<?php

require_once __DIR__ . '/capusta.php';

$capusta['host'] = array('dev.example.com');
$capusta['checkout'] = "HEAD";

$capusta['production'] = function (Capusta $capusta) {
    $capusta['host'] = array('example.com');
};

$capusta['deploy'] = function (Capusta $capusta) {
    foreach ($capusta['host'] as $host) {
        $capusta->execute("ssh $host 'cd /var/www; php capusta.php update --checkout={$capusta['checkout']}'");
    }
};

$capusta['update'] = function (Capusta $capusta) {
    $capusta->execute('git pull');
    $capusta->execute("git checkout {$capusta['checkout']}");
    $capusta->execute('git submodule update --init');
};
