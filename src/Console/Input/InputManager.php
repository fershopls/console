<?php

namespace FershoPls\Console\Input;

class InputManager {

    public function get ($input = "> ")
    {
        echo $input;
        $handle = fopen ("php://stdin","r");
        $stream = trim(fgets($handle));
        echo PHP_EOL;
        return $stream;
    }

}