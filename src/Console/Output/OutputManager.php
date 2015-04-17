<?php

namespace FershoPls\Console\Output;

class OutputManager {

    const MIDDLEWARE_CONCATENATE_CHAR = "|";

    protected $filters = array();

    public function puts ($message = null, $class = "default")
    {
        if ($message)
        {
            // Execute Filters
            $message = $this->get ($message, $class);
            // Print Message
            echo $message;
        }
        // Support Windows/Linux/MacOs for new line character
        if ($class) echo PHP_EOL;
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