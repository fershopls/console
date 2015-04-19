<?php

namespace FershoPls\Console\Output;

class OutputManager {

    const MIDDLEWARE_CONCATENATE_CHAR = "|";

    protected $filters = array();

    public function puts ($message = null, $class = "default")
    {
        $message = ($message)?explode ("\n", $message):[];

        foreach ($message as $line)
        {
            $line = is_array($line)?json_encode($line):$line;
            // Execute Filters
            $line = $this->get ($line, $class);
            // Print Message
            echo $line . PHP_EOL;
        }

        // Support Windows/Linux/MacOs for new line character
        //if ($class) echo PHP_EOL;
        // Always return processed string
        return $message;
    }

    public function middleware ($callback = null, $class = "default")
    {
        if ($callback && is_callable($callback))
        {
            array_push($this->filters,
                [
                    "class" => $class,
                    "callback" => $callback,
                ]
            );
        }
    }

    public function dd ($variable = null, $end = true)
    {
        if (is_array($variable)):
            $variable = json_encode($variable);
        elseif (is_null($variable)):
            $variable = "NULL :(";
        elseif ($variable === false):
            $variable = "False";
        else:
            ob_start();
            var_dump($variable);
            $variable = trim(ob_get_clean());
        endif;

        $this->puts($variable);
        if ($end) exit;
    }

    protected function get ($message, $class)
    {
        foreach ($this->filters as $middleware)
        {
            $in_class = array_filter(explode(self::MIDDLEWARE_CONCATENATE_CHAR, $middleware["class"]), function ($item) use ($class){ return ($item==$class);});
            if ($in_class)
            {
                $render = $middleware["callback"]($message, $class);
                $message = ($render)?$render:$message;
            }
        }
        return $message;
    }

}