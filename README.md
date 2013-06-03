# PHP Autoloader Benchmark

This is a simple benchmarking tool that compares a few autoloading strategies.

## Usage

    composer install
    php -d apc.enable_cli=1 bin/bench

## Motivation

While [other benchmarks](http://mwop.net/blog/245-Autoloading-Benchmarks.html)
exist already, I needed one that could be run very easily, and that focused on
what IMO is the only differenciator amongst autoloading scripts: the time it takes
to locate a file for a given class name. I have no interest in APC or actually
loading a class, that's PHP's job.

If you figure out a faster way than ClassMap, or manage to optimize it in
any way, please contribute it.

## License (MIT)

> Copyright (c) 2012 Jordi Boggiano
>
> Permission is hereby granted, free of charge, to any person obtaining a copy
> of this software and associated documentation files (the "Software"), to deal
> in the Software without restriction, including without limitation the rights
> to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
> copies of the Software, and to permit persons to whom the Software is furnished
> to do so, subject to the following conditions:
>
> The above copyright notice and this permission notice shall be included in all
> copies or substantial portions of the Software.
>
> THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
> IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
> FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
> AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
> LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
> OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
> THE SOFTWARE.
