<?php

namespace Seld\AutoloadBench\Builder;

use Seld\AutoloadBench\Builder;

class APC extends Builder
{
    protected function build($classes, $path)
    {
        if (function_exists('apc_clear_cache')) {
            apc_clear_cache('user');
        }
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
