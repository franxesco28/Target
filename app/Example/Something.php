<?php

namespace App\Example;

interface IService {

}

class Service1 implements IService {

}

class Service2 implements IService {

}

class Service3 implements IService {

}

class Something {

    private Service1 $prop1;

    public function __construct(IService $service_1){

    }

    /**
     * @param Service1 $prop1
     */
    public function setProp1(Service1 $prop1): void{
        $this->prop1 = $prop1;
    }

}


$p = new Something(new Service1());
$p = new Something(new Service2());
$p = new Something(new Service3());

//Something-> Service (class)
//Something-> IService (interface) <- Service1 # D- Dependency inversion
