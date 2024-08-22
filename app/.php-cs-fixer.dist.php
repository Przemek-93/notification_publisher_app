<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in([
        sprintf('%s/bin', __DIR__),
        sprintf('%s/config', __DIR__),
        sprintf('%s/public', __DIR__),
        sprintf('%s/src', __DIR__),
        sprintf('%s/tests', __DIR__),
    ])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'declare_strict_types' => true,
        'global_namespace_import' => false,
        'phpdoc_align' => false,
        'single_line_throw' => false,
    ])
    ->setFinder($finder)
    ;
