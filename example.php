<?php
// Config local php time
date_default_timezone_set("America/Mexico_City");
// Composer autoload *-*
require_once (
    realpath (__DIR__ . '/vendor/autoload.php')
);

// Include Classes
use FershoPls\Console\Output\OutputManager;
use FershoPls\Console\Input\InputManager;
// Instance Classes
$input    = new InputManager();
$output   = new OutputManager();

$output->middleware (function ($message = "")
{
    return "[".date("H:i:s")."] " . $message;
});

$output->dd([1,3,2,4,2], false);
$output->dd(false, false);
$output->dd(NULL, false);
$output->dd(1203, false);
$output->dd("HOla", false);
$output->dd(true, false);

exit;

$output->puts("Hello there!");
$output->puts("What's your name?");
// Get the stream
$name = $input->get();
$output->puts("Nice to meet you " . ucfirst($name) . "!");