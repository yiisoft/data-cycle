<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

ini_set('memory_limit', '512M');

$root = __DIR__;
$finder = (new Finder())
    ->in([
        $root.'/src',
        $root.'/tests',
    ])
    ->exclude([
    ])    
    ->append([
        $root.'/public/index.php',
    ]);

return (new Config())
    ->setCacheFile(__DIR__ . '/runtime/cache/.php-cs-fixer.cache')
    ->setParallelConfig(ParallelConfigFactory::detect(
        // $filesPerProcess
        10, 
        // $processTimeout in seconds   
        200, 
        // $maxProcesses    
        10
    ))
    ->setRules([
        '@PER-CS2.0' => true,
    ])
    ->setFinder($finder);
