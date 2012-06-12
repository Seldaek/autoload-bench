<?php

namespace Seld\AutoloadBench\Builder;

use Seld\AutoloadBench\Builder;

class PSR0 extends Builder
{
    public function build($classes, $path)
    {
        $code = <<<'EOF'
<?php

$loader = new \Seld\AutoloadBench\Loader\PSR0();
$map = %s;

foreach ($map as $prefix => $path) {
    $loader->add($prefix, $path);
}

return $loader;
EOF
;

        $prefixes = array();
        foreach ($classes as $class) {
            $prefix = substr($class, 0, strpos($class, '\\'));
            $prefixes[$prefix] = $path;
        }

        file_put_contents($this->path.'/loader.php', sprintf($code, var_export($prefixes, true)));
    }
}
