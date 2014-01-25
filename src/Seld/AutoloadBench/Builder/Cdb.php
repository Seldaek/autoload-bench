<?php

namespace Seld\AutoloadBench\Builder;

use Seld\AutoloadBench\Builder;

class Cdb extends Builder
{
    protected function build($classes, $path)
    {
        $dbfile = $this->path . '/loader.cdb';

        $cdb = dba_open($dbfile, 'n', 'cdb');

        foreach ($classes as $class) {
            dba_insert($class, $path.'/'.strtr($class, '\\', '/').'.php', $cdb);
        }

        dba_close($cdb);

        $code = '<?php return new \Seld\AutoloadBench\Loader\Cdb(\'%s\');';

        file_put_contents($this->path.'/loader.php', sprintf($code, $dbfile));
    }

    public function enabled()
    {
        return extension_loaded('dba') && in_array('cdb', dba_handlers());
    }
}

