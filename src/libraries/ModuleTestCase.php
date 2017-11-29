<?php

/**
 * Class ModuleTestCase
 * Base class for Model test cases
 */
trait ModuleTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->CI->router->locate($this->moduleToLoad());
    }

    protected function &loadModule()
    {
        return $this->setModule(join('/', $this->moduleToLoad()));
    }

    protected function &setModule($module)
    {
        if (class_exists('Modules')) {
            Modules::$registry = array();
            CIUnit::$controller = Modules::load($module);
        }

        $this->CI = &CIUnit::get_controller();

        return CIUnit::get_controller();
    }

    protected abstract function moduleToLoad();
}
