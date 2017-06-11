# middleware

Функции выполняются в прямой последовательности. 
Первой выполняется основная функция,
последней выполниться последняя добавленая функция.
Основная функция принимают переменное количество аргументов,
В промежуточных функциях аргументом будет 
результат вышестоящей функции.

Поведение промежуточных функций можно изменить через метод withBehavior

Пример:

```php

$product = new Middleware\Middleware(function ($a, $b) {
    // Основная функция
    return $a * $b;
});

$cube = $product->add(function ($next) {
    // Промежуточная функция
    return $next * $next * $next;
});

$cube2 = $this->product
    ->withBehavior(function ($callable, $next) {
    // Функция изменяющая поведение промежуточных функций
        return function () use ($callable, $next) {
            $arguments = func_get_args();
            $arguments[] = $next;
            return $callable(...$arguments);
        };
    })
    ->add(function ($a, $b, $next) {
    // Промежуточная функция с измененным поведением
        return $next($a, $b) * $next($a, $b) * $next($a, $b);
    });

echo $product(2, 3); // 6
echo $cube(2, 3); // 216
echo $cube2(2, 3); // 216
```