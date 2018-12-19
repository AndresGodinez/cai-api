<?php
/**
 * Default configuration for php-cs-fixer library
 * Copy at the project root as .php_cs file
 */

$finder = PhpCsFixer\Finder::create()
    ->exclude([
        "vendor",
        "tests",
        "scripts",
        "public",
    ])
    ->in(__DIR__)
;

return PhpCsFixer\Config::create()
    ->setUsingCache(false)
    ->setRules([
        "@PSR1" => true,
        "@PSR2" => true,
        "single_blank_line_at_eof" => false,
        "braces" => [
            "allow_single_line_closure" => true,
        ],
    ])
    ->setFinder($finder)
;