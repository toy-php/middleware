<?php

include '../src/Middleware/Exception.php';
include '../src/Middleware/Middleware.php';

class MiddlewareTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var \Middleware\Middleware
     */
    protected $product;

    public function setUp()
    {
        $this->product = new Middleware\Middleware(function ($a, $b) {
            return $a * $b;
        });
    }

    public function testMainFunction()
    {
        $product = $this->product;
        $this->assertTrue($product(2, 3) === 6);
    }

    public function testMiddleware()
    {
        $cube = $this->product
            ->add(function ($next) {
                return $next * $next * $next;
            });
        $this->assertTrue($cube(2, 3) === 216);
    }

    public function testBehavior()
    {
        $cube = $this->product
            ->withBehavior(function ($callable, $next) {
                return function () use ($callable, $next) {
                    $arguments = func_get_args();
                    $arguments[] = $next;
                    return $callable(...$arguments);
                };
            })
            ->add(function ($a, $b, $next) {
                return $next($a, $b) * $next($a, $b) * $next($a, $b);
            });
        $this->assertTrue($cube(2, 3) === 216);
    }
}
