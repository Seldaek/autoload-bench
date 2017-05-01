<?php

namespace Seld\AutoloadBench\Builder;

use Seld\AutoloadBench\Builder;

class Krautoload extends Builder
{
    public function build($classes, $path)
    {
        // We assume it is all namespaces, no PEAR-like prefixes.
        $code = <<<'EOF'
<?php

$loader = new \Seld\AutoloadBench\Loader\Krautoload();
$map = %s;

foreach ($map as $prefix => $path) {
    $loader->addNamespacePSR0($prefix, $path);
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
