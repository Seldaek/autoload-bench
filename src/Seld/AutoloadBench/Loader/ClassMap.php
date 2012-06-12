<?php

namespace Seld\AutoloadBench\Loader;

class ClassMap
{
    private $map;

    public function __construct(array $map)
    {
        $this->map = $map;
    }

    public function loadClass($name)
    {
        if (isset($this->map[$name])) {
            $file = $this->map[$name];

            return true;
        }

        return false;
    }
}
