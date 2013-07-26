<?php

namespace Seld\AutoloadBench;

class Generator
{
    protected $classes = [
        'FlattenExceptionTest', 'ClosureLoader', 'Hour2401Transformer',
        'WebProfilerBundle', 'MemcachedCache', 'ErrorHandlerTest',
        'ResolveInvalidReferencesPassTest', 'ListCommand', 'CustomNormalizerTest',
        'FixedFilterListener', 'functions', 'NativeProxy', 'FileCacheReaderTest',
        'EsiListener', 'ArgvInputTest', 'AddCacheWarmerPassTest',
        'NotifyPropertyChanged', 'MethodNotAllowedHttpException', 'PropertyPathTest',
        'ConfigurationTest', 'SecurityFactoryInterface', 'InteractiveLoginEvent',
        'ExecutableFinder', 'ValidationListener', 'TranslationDumperPass',
        'ResponseHeaderBag', 'NativeProxyTest', 'RealIteratorTestCase',
        'RedirectControllerTest', 'OutputFormatterInterface', 'UniqueEntity',
        'DateComparator', 'ContainerInterface', 'AbstractProfilerStorageTest',
        'IdentityTranslatorTest', 'SlotsHelperTest', 'CacheWarmerAggregateTest',
        'Serializer', 'TokenNotFoundException', 'FilesystemTest', 'EmailValidator',
        'DateTimeTestCase', 'ChromePhpHandler', 'CheckCircularReferencesPassTest',
        'FormEvents', 'BasicPermissionMapTest', 'StreamOutput', 'ChainLoader',
        'ProcessTest', 'CombinedSelectorNodeTest', 'Debugger', 'OptionsTest',
        'ProcessorTest', 'ConstraintTest', 'UserTest', 'MongoDbSessionHandler',
        'YearTransformer', 'DayTransformer', 'SessionInterface', 'PerformanceTest',
        'MaxLength', 'Package', 'validpattern', 'Foo3Command',
        'RetryAuthenticationEntryPoint', 'CollectionValidatorArrayTest', 'LocaleValidator',
        'ContainerAwareLoader', 'FileBagTest', 'ContainerAwareEventManagerTest',
        'ConstraintViolationList', 'Shell', 'PathPackage', 'ServerRunCommand',
        'ClassWithConstants', 'MessageSelector', 'RoleHierarchy',
        'SerializerAwareNormalizer', 'PropertyAccessDeniedException', 'DocParserTest',
        'UsernamePasswordToken', 'MergeTest', 'ObjectIdentityRetrievalStrategyTest',
        'MethodArgumentNotImplementedException', 'FormHelperDivLayoutTest',
        'AnonymousToken', 'UrlMatcherTest', 'AnonymousTokenTest',
        'MongoDbProfilerStorageTest', 'XPathExpr', 'PermissionGrantingStrategyInterface',
        'PHPDriverTest', 'TrueValidatorTest', 'FormExtensionTableLayoutTest',
    ];

    protected $namespaces = [
        'BrowserKit', 'Cms', 'Profiler', 'Extension', 'Authorization', 'FooBundle',
        'Event', 'Driver', 'Locale', 'Factory', 'RememberMe', 'EventListener',
        'DataCollector', 'Validator', 'Authentication', 'Pearlike', 'Dumper',
        'FrameworkBundle', 'Permission', 'Acl', 'Type', 'HttpFoundation', 'Mapping',
        'Generator', 'Normalizer', 'Flash', 'Namespaced', 'Doctrine', 'Http',
        'Test', 'Custom', 'CssSelector', 'SecurityBundle', 'Constraints',
        'Definition', 'CompilerPass', 'File', 'ExtensionAbsentBundle', 'Builder',
        'Templating', 'Form', 'Functional', 'ChoiceList', 'NamespaceCollision',
        'Controller', 'EventDispatcher', 'Attribute', 'Extractor', 'Handler',
        'FormTable', 'Exception', 'Fixtures', 'ExtensionPresentBundle',
        'BaseBundle', 'Asset', 'Swiftmailer', 'Debug', 'EntryPoint',
        'DataTransformer', 'Guess', 'Monolog', 'Collections', 'Propel1',
        'CacheWarmer', 'Twig', 'Field', 'StandardFormLogin', 'Encoder',
        'Annotations', 'CsrfProvider', 'Console', 'Logger', 'User',
        'WebProfilerBundle', 'Tester', 'Token', 'PrefixCollision', 'ParameterBag',
        'Config', 'Bridge', 'Logout', 'DateFormat', 'Core',
    ];

    public function generate($amount, $path, $sharedPrefix = '')
    {
        $classes = [];
        while ($amount--) {
            $class = $sharedPrefix . $this->generateName();
            $file = $path.'/'.strtr($class, '\\', '/').'.php';
            if (!is_dir(dirname($file))) {
                mkdir(dirname($file), 0777, true);
            }
            file_put_contents($file, $this->getBody($class));
            $classes[] = $class;
        }

        return $classes;
    }

    protected function generateName()
    {
        $name = [];
        $depth = rand(1, 5);

        foreach (array_rand($this->namespaces, rand(2, 5)) as $key) {
            $name[] = $this->namespaces[$key];
        }

        $name[] = $this->classes[array_rand($this->classes, 1)];

        return implode('\\', $name);
    }

    protected function getBody($class)
    {
        $pos = strrpos($class, '\\');

        return '<?php namespace '.substr($class, 0, $pos).';
            class '.substr($class, $pos+1).' {}
        ';
    }
}
