<?php

/**
 * generate random path used for performance test purpose
 *
 * @TODO: this script is created in rush, need refactoring 
 *
 * Usage:
 *      php script/create_test_data.php [number of paths]
 *
 *      # example: create 1000 paths
 *      []$ php script/create_test_data.php 1000 > 1000.txt
 *
 */

$nb = $argv[1];
var_dump($nb);

for($i=0;$i<$nb;$i++) {

    echo createPath() . "\n";

}

function createPath()
{
    $arr = array();
    $level = rand(1, 5);
    $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    for($i=0;$i<$level;$i++) {
        $length = rand(1, 5);
        $str = '';
        for($j=0;$j<$length;$j++) {
            $str .= $charset[mt_rand(0, strlen($charset)-1)];
        }

        $arr[] = $str;
    }
    return implode('/',$arr);

}

