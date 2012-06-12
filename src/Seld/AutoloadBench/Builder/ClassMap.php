<?php

namespace Seld\AutoloadBench\Builder;

use Seld\AutoloadBench\Builder;

class ClassMap extends Builder
{
    public function build($classes, $path)
    {
        $code = '<?php return new \Seld\AutoloadBench\Loader\ClassMap(%s);';

        foreach ($classes as $class) {
            $map[$class] = $path.'/'.strtr($class, '\\', '/').'.php';
        }

        file_put_contents($this->path.'/loader.php', sprintf($code, var_export($map, true)));
    }
}
