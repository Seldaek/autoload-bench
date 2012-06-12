<?php

namespace Seld\AutoloadBench\Builder;

use Seld\AutoloadBench\Builder;

class APC extends Builder
{
    public function build($classes, $path)
    {
        $code = '<?php return new \Seld\AutoloadBench\Loader\APC(%s);';

        foreach ($classes as $class) {
            $map[$class] = $path.'/'.strtr($class, '\\', '/').'.php';
        }

        file_put_contents($this->path.'/loader.php', sprintf($code, var_export($map, true)));
    }

    public function enabled()
    {
        return extension_loaded('apc');
    }
}
