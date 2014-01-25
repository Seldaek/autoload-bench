<?php

namespace Seld\AutoloadBench\Loader;

class Cdb
{
    private $cdb;

    public function __construct($dbfile)
    {
        $this->cdb = dba_open($dbfile, 'r-', 'cdb');
    }

    public function loadClass($name)
    {
        $file = dba_fetch($name, $this->cdb);

        if ($file !== false) {
            return true;
        }

        return false;
    }
}

