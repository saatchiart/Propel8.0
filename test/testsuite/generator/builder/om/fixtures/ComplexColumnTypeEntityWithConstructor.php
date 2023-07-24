<?php

class ComplexColumnTypeEntityWithConstructor extends BaseComplexColumnTypeEntityWithConstructor
{
    public function __construct()
    {
        parent::__construct();

        $this->setTags(
            ['foo', 'bar']
        );
    }
}
