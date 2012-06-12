<?php

namespace Seld\AutoloadBench;

abstract class Builder
{
    protected $path;
    protected $instance;

    public function __construct($path)
    {
        $this->path = $path;
    }

    abstract public function build($classes, $path);

    public function enabled()
    {
        return true;
    }

    public function getLoader()
    {
        if (!$this->instance) {
            $this->instance = require $this->path.'/loader.php';
        }

        return $this->instance;
    }
}
