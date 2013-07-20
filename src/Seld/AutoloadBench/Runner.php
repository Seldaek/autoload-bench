<?php

namespace Seld\AutoloadBench;

class Runner
{
    protected $classes;
    protected $builders;

    public function __construct($path)
    {
        $this->path = $path;
        if (!is_writable($this->path)) {
            throw new \RuntimeException('Make sure '.$this->path.' is writable');
        }

        foreach (glob(__DIR__.'/Builder/*.php') as $file) {
            $name = basename($file, '.php');
            $this->builders[strtolower($name)] = $name;
        }

        foreach ($this->builders as $name => $class) {
            if (!is_dir($this->path.'/'.$name)) {
                mkdir($this->path.'/'.$name, 0777, true);
            }
            $class = __NAMESPACE__.'\\Builder\\'.$class;
            $instance = new $class($this->path.'/'.$name);
            if ($instance->enabled()) {
                $this->builders[$name] = $instance;
            } else {
                echo 'Skipped '.$name.' loader because it reports itself as disabled'.PHP_EOL;
                unset($this->builders[$name]);
            }
        }
    }

    public function prepare($numClasses, $sharedPrefix = '', $prefixMapLevel = 1)
    {
        $gen = new Generator;
        if (!is_dir($this->path.'/classes')) {
            mkdir($this->path.'/classes', 0777, true);
        }

        echo PHP_EOL;
        echo 'Generating '.$numClasses.' classes'.PHP_EOL;
        if (!empty($sharedPrefix)) {
            echo 'Shared prefix: ' . $sharedPrefix . PHP_EOL;
        }
        if (1 !== $prefixMapLevel) {
            echo 'Prefix level for PSR-0: ' . $prefixMapLevel . PHP_EOL;
        }
        $this->classes = $gen->generate($numClasses, $this->path.'/classes', $sharedPrefix);
        foreach ($this->builders as $name => $builder) {
            $builder->prepare($this->classes, $this->path.'/classes', $prefixMapLevel);
        }

        return $this;
    }

    public function run(array $series, $runs = 1)
    {
        $total = $runs * count($this->builders);

        echo 'Including classes'.PHP_EOL;
        foreach ($this->builders as $name => $builder) {
            $start = microtime(true);
            $mem = memory_get_usage();
            $loader = $builder->getLoader();
            $results[$name] = microtime(true) - $start;
            $memResults[$name] = memory_get_usage() - $mem;
            unset($loader);
        }

        $longestName = 0;
        foreach ($results as $name => $data) {
            $longestName = max(strlen($name), $longestName);
        }

        asort($results);
        foreach ($results as $name => $data) {
            echo '> '.$name.': '.str_repeat(' ', $longestName - strlen($name));
            echo sprintf('%.3fms', $data * 1000);
            echo '  memory use: '.round($memResults[$name]/1024, 1).'KB';
            echo PHP_EOL;
        }
        echo PHP_EOL;

        foreach ($series as $load) {
            $results = [];
            $toLoad = [];
            if ($load > 0) {
                foreach (array_rand($this->classes, $load) as $key) {
                    $toLoad[] = $this->classes[$key];
                }
                $expected = true;
            } else {
                foreach (array_rand($this->classes, abs($load)) as $key) {
                    $toLoad[] = '_FAIL_'.$this->classes[$key];
                }
                $expected = false;
            }

            echo 'Starting '.$total.' runs ('.($load > 0 ? $load : 'fail '.abs($load)).' classes)'.PHP_EOL;
            $run = 0;
            $iterations = 0;
            while ($iterations++ < $runs) {
                foreach ($this->builders as $name => $builder) {
                    $start = microtime(true);
                    $loader = $builder->getLoader();
                    foreach ($toLoad as $class) {
                        if ($expected !== $loaderResult = $loader->loadClass($class)) {
                            if (FALSE === $loaderResult) {
                                throw new \RuntimeException($name.' failed to load '.$class);
                            }
                            elseif (TRUE === $loaderResult) {
                                throw new \RuntimeException($name.' must not load '.$class);
                            }
                            else {
                                throw new \RuntimeException($name.' must return TRUE or FALSE.');
                            }
                        }
                    }
                    $results[$name]['runs'][$run] = microtime(true) - $start;

                    $run++;
                    if ($run > 0 && (($run-1) % 80) === 0) {
                        echo PHP_EOL;
                    }
                    echo '.';
                }
            }
            echo PHP_EOL.PHP_EOL;

            $fastest = PHP_INT_MAX;
            foreach ($results as $name => $data) {
                $results[$name]['avg'] = array_sum($data['runs']) / $runs;
                $fastest = min($fastest, $results[$name]['avg']);
            }

            uasort($results, function ($a, $b) {
                if ($a['avg'] === $b['avg']) {
                    return 0;
                }

                return $a['avg'] > $b['avg'] ? 1 : -1;
            });

            foreach ($results as $name => $data) {
                echo '> '.$name.': '.str_repeat(' ', $longestName - strlen($name));
                echo sprintf('%.6fms (%.2fx)', $data['avg'] * 1000, $data['avg'] / $fastest);
                echo PHP_EOL;
            }

            echo PHP_EOL;
        }

        return $this;
    }
}
