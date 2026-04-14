<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return (new Config())
    ->setRules([
        '@PSR12' => true,
        '@PhpCsFixer' => true,
        'array_indentation' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
        'no_whitespace_before_comma_in_array' => true,
        'whitespace_after_comma_in_array' => true,
        'array_syntax' => ['syntax' => 'short'],
        'binary_operator_spaces' => [
            'default' => 'single_space',
            'operators' => ['=>' => null],
        ],
        'multiline_whitespace_before_semicolons' => false,
        'phpdoc_trim' => false,
        'phpdoc_no_empty_return' => false,
        'phpdoc_types_order' => [
            'null_adjustment' => 'always_last',
            'sort_algorithm' => 'none',
        ],
        'single_line_comment_style' => false,
        'explicit_string_variable' => false,
        'return_assignment' => [
            'skip_named_var_tags' => true,
        ],
    ])
    ->setFinder(
        Finder::create()
            ->in([__DIR__.'/src', __DIR__.'/test'])
    );
