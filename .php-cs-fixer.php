<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        'declare_strict_types' => true,
        'no_closing_tag' => true,
        'single_blank_line_at_eof' => true,
        'array_syntax' => ['syntax' => 'short'],
        'array_indentation' => true,
        'binary_operator_spaces' => ['default' => 'single_space'],
        'concat_space' => ['spacing' => 'one'],
        'unary_operator_spaces' => true,
        'blank_line_after_namespace' => true,
        'blank_line_after_opening_tag' => true,
        'no_extra_blank_lines' => true,
        'no_unused_imports' => true,
        'single_import_per_statement' => true,
        'ordered_imports' => [
            'imports_order' => ['class', 'function', 'const'],
            'sort_algorithm' => 'alpha',
        ],
        'return_type_declaration' => ['space_before' => 'one'],
        'strict_param' => true,
        'no_trailing_whitespace' => true,
        'no_whitespace_in_blank_line' => true,
        'new_with_braces' => true,
        'cast_spaces' => ['space' => 'single'],
    ])
    ->setFinder($finder)
    ->setIndent("\t")
    ->setLineEnding("\n");