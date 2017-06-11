<?php

include 'src/Middleware/Middleware.php';

$middleware = new \Middleware\Middleware(function ($name){
    return 'My name is ' . $name;
});

$middleware->add(function ($next){
    return 'Hello World!!! ' . $next;
});

echo $middleware('Middleware');