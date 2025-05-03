<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
;


return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'declare_strict_types' => true,
        'concat_space' => ['spacing' => 'one'],
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder);
