<?php

/**
坦克世界-面向对象，设计模式，Ioc和DI
 */


/**
面向对象-接口，抽象类，继承
 */


interface Tank 
{
   public function fire();
   public function run();
   public function turning();
}

abstract class AbstarctTank implements Tank 
{
    public $gun;//火炮
    public $suspension;//悬挂
    public $engine;//发动机
    public $raido;//无线电
    public $turret;//炮塔
    public $user;

    public function __construct($user) 
    {
        $this->setUser = $user;
    }

    public function fire($shell)
    {

    }
    public function run($gas)
    {

    }
    public function turning()
    {

    }
}


class HeavyTank extends AbstarctTank 
{

}

class MiddleTank extends AbstarctTank
{

}

class LightTank extends AbstarctTank
{

}


/**
工厂-简单工厂，工厂方法，抽象工厂
 */
//Simple Factory Pattern
public class TankSimpleFactory
{
    static function  createTank($style)//
    {
        if('HeavyTank' == $style) {
            return new HeavyTank();
        }elseif('MiddleTank' == $style) {
            return new MiddleTank();
        }else {
            return new LightTank();
        }
    }
}

public class Test1
{
    $HeavyTank = TankSimpleFactory::createTank('HeavyTank');
    $HeavyTank->fire();

    $MiddleTank = TankSimpleFactory::createTank('MiddleTank');
    $MiddleTank->run();

    $LightTank = TankSimpleFactory::createTank('LightTank');
    $LightTank->spy();
}

//Factory Method
public abstract class TankFactory
{
    abstract createTank();
}

public class HeavyTankFactory extends TankFactory
{
    public createTank()
    {
        return new HeavyTank();
    }
}

public class MiddleTankFactory extends TankFactory
{
    public createTank()
    {
        return new MiddleTank();
    }
}

public class LightTankFactory extends TankFactory
{
    public createTank()
    {
        return new LightTank();
    }
}

public class Test2
{
    $HeavyTank = HeavyTankFactory::createTank('HeavyTank');
    $HeavyTank->fire();

    $MiddleTank = MiddleTankFactory::createTank('MiddleTank');
    $MiddleTank->run();

    $LightTank = LightTankFactory::createTank('LightTank');
    $LightTank->spy();
}



//Abstract Factory
public abstract class AbstarctFactory
{
    public abstract createTank();
    public abstract createClothes();
    public abstract createFood();
}

public class Factory extends AbstarctFactory
{
    public createTank()
    {
        return new Tank();
    }

    public createClothes()
    {
        return new Clothes();
    }

    public createFood()
    {
        return new Food();
    }
}

public class Test3
{
    $Rheinstahl = new Factory();
    $Tank = $Rheinstahl->createTank();
    $Tank->fire();

    $Asf = new Factory();
    $Clothes = $Asf->createClothes();
    $Clothes->dressed();

    $MacDonald = new Factory();
    $Food = $MacDonald->createFood();
    $Food->eated();

}


/**
单例
 */
class SingleGold59Tank
{
    private static $_instance = NULL;

    private function __construct(){}

    public static function getInstance()
    {
        if(is_null(self::$_instance)) {
            self::$_instance = new SingleGold59Tank();
        }

        return self::$_instance;
    }

    public function __clone()
    {
        die("限量发行，克隆禁止");
    }
}

/**
观察者
 */
//Observer
class Tank implements SplObserver
{
    private $ob_name = 'Tiger';

    public function __construct($ob_name)
    {
        $this->ob_name = $ob_name;
    }

    public function get_name() {
        return $this->ob_name;
    }

    public function fire() {
        return 'Fire';
    };

    public function adjust(SplSubject $object)
    {
        $object->set_attack("Please " . $this->ob_name . " attack " . $object->sb_name);
    }
}

class Td implements SplObserver
{
  
}

class Spg implements SplObserver
{
    
}

//Subject
class Subject implements SplSubject
{
    private $sb_name;
    private $_attack = array();
    private $_classes = array();

    public function __construct($sb_name)
    {
        $this->sb_name = $sb_name;
    }

    private function set_attack($fire)
    {
        $this->_attack[] = $fire;
    }

    private function get_attack()
    {
        return $this->_attack;
    }

    public function attach(SplObserver $classes)
    {
        $this->_classes[] = $classes;
        $this->_attack[] = "The" . $classes->get_name() . " execute" . $classes->fire()  . " and kill enemy";
    }

    public function detach(SplObserver $classes)
    {
        foreach ($this->_classes as $key => $obj) {
            if($obj == $classes) {
                unset($this->_classes[$key]);
                $this->_attack[] = "The " .  $classes->get_name() . "was leaved" . $classes->fire() ." removed";
            }
        }
    }

    public function notify()
    {
        foreach ($this->_classes as $classes) {
            $classes->adjust($this);
        }
    }
}

//Application
$subject= new Subject('x200y400');

$tiger = new Tank('Tiger');
$foch = new Td('foch');
$crusader = new Spg('Crusader');

//add
$subject->attach($tiger);
$subject->attach($foch);
$subject->attach($crusader);

//remove
$subject->detach($crusader);

//notify
$subject->notify();


/**
注册器／树
 */
class Register
{
    protected static $objects

    static function set($alias, $object)
    {
        self::$objects[$alias] = $object;
    }

    static function get($alias)
    {
        return self::$objects[$alias];
    }

    static function _unset($alias)
    {
        unset(self::$objects[$alias]);
    }
}


/**
适配器-统一口径[mysql, mysqli, PDO]
 */

interface Vehicle
{
    function run(){};
    function turn(){};
    function fire(){};
}

class Tank implements Vehicle
{
    function run(){};
    function turn(){};
    function fire(){};
}

class Td implements Vehicle
{
    function run(){};
    function turn(){};
    function fire(){};
}

class Spg implements Vehicle
{
    function run(){};
    function turn(){};
    function fire(){};
}

/**
策略模式-Ioc,DI
 */
interface Tank {
    public function execute();
}

class HeavyTank implements Tank {
    public function execute() {
        echo "Fire";
    }
}

class MiddleTank implements Tank {
    public function execute() {
        echo "Run";
    }
}

class LightTank implements Tank {
    public function execute() {
        echo "Spy";
    }
}

class Task {
    public $tank;

    public function __construct(Tank $tank) {
        $this->tank = $tank;
    }

    public function execute() {
        $this->tank->execute();
    }
}

$context = new Context(new HeavyTank());
$context->execute();

/**
数据对象映射-ORM
 */


/**
原型模式-clone[减少实例化，初始化的消耗]
 */
$proto_tank = new SuperTank();
$proto_tank->init();

$tiger1 = clone $proto_tank;
$tiger2 = clone $proto_tank;


/**
装饰器--坦克配件
 */
interface TankDecorator
{
    function beforeFire(){};
    function afterFire(){};
}

class Camouflage implements TankDecorator
{
    function beforeFire(){};
    function afterFire(){};
}

class Bincular implements TankDecorator
{
    function beforeFire(){};
    function afterFire(){};
}

class Tank
{
    protected $decorators;
    function addDecorators(TankDecorator $decorator)
    {
        $this->decorators = $decorator;
    }

    function beforeFire()
    {
        foreach ($this->decorators as $decorator) {
            $decorator->beforeFire();
        }
    }

    function afterFire()
    {
        $decorators = array_reverse($this->decorators);
        foreach ($decorators as $decorator) {
            $decorator->afterFire();
        }
    }

    function fire()
    {
        $this->beforeFire();
        echo 'fire';
        $this->afterFire();
    }
}

$tank = new Tank();
$tank->addDecorators(new Camouflage());
$tank->fire();

/**
迭代器
 */
class TaskList implements Iterator
{
    function current(){};
    function next(){};
    function valid(){};
    function rewind(){};
    function key(){};
}

/**
代理-proxy[数据库读写分离]
 */
interface TankProxy
{

}

class Proxy implements TankProxy
{
    public function fire()
    {
       echo 'use HeavyTank'; 
    }

    public function spy()
    {
        echo 'use LightTank';
    }
}

$proxy = new Proxy()
$proxy->fire();
$proxy->spy();












