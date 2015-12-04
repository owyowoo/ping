<?php
/**
匿名函数，Anonymous functions 也叫闭包函数，closures
*/

/**
作回调函数callback参数的值
*/
// echo preg_replace_callback('~([a-z])~', function ($match){
//     return strtoupper($match[1]);
// }, 'hello-world');

/**
作变量的值
*/
// $greet = function($name) 
// {
//     printf("hello %s\r\n", $name);
// };

// $greet('world');//world
// $greet('php');//php

/**
use语言结构
*/
// $message = 'hello';
// $example = function() {
//     var_dump($message);
// };
// echo $example();//null

// $example = function() use ($message) {
//     var_dump($message);
// };
// echo $example();//hello

// $message = 'world';
// echo $example();//hello

// $message = 'hello';
// $example = function() use (&$message) {
//     var_dump($message);
// };
// echo $example();//hello

// $message = 'world';
// echo $example();//world

// $example = function($arg) use ($message) {
//     var_dump($arg . ' ' . $message);
// };
// $example('hello');//hello world

/**
 Closures 和作用域
*/
class Cart
{
    const PRICE_BUTTER = 1.00;
    const PRICE_MILK = 3.00;
    const PRICE_EGGS = 6.95;

    protected $products = array();

    public function add($product, $quantity) {
        $this->products[$product] = $quantity;
    }

    public function getQuantity($product) {
        return isset($this->products[$product]) ? $this->products[$product] : FALSE;
    }

    public function getTotal($tax) {
        $total = 0.00;
        //val-key
        $callback = function ($quantity, $product) use ($tax, &$total) {
            $pricePerItem = constant(__CLASS__ . "::PRICE_" . strtoupper($product));
            $total += ($pricePerItem * $quantity) * ($tax + 1.0);
        }
        array_walk($this->products, $callback);
        return round($total, 2);
    }
}

$my_cart = new Cart;

// 往购物车里添加条目
$my_cart->add('butter', 1);
$my_cart->add('milk', 3);
$my_cart->add('eggs', 6);

// 打出出总价格，其中有 5% 的销售税.
print $my_cart->getTotal(0.05) . "\n";
// 最后结果是 54.29