<?php

namespace Seld\AutoloadBench\Loader;

class APC
{
    private $map;

    public function __construct(array $map)
    {
        $this->map = $map;
    }

    public function loadClass($name)
    {
        if ($class = apc_fetch($name)) {
            return true;
        }

        if (isset($this->map[$name])) {
            apc_store($name, $file = $this->map[$name]);

            return true;
        }

        return false;
    }
}
