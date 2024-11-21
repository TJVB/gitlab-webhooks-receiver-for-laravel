<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\Arrays\ArrayIndentSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterCastSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\ForbiddenFunctionsSniff;
use PhpCsFixer\Fixer\ClassNotation\FinalClassFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitConstructFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDedicateAssertFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer;
use SlevomatCodingStandard\Sniffs\Classes\ClassConstantVisibilitySniff;
use SlevomatCodingStandard\Sniffs\Classes\ClassStructureSniff;
use SlevomatCodingStandard\Sniffs\Classes\MethodSpacingSniff;
use SlevomatCodingStandard\Sniffs\Commenting\EmptyCommentSniff;
use SlevomatCodingStandard\Sniffs\Functions\StaticClosureSniff;
use SlevomatCodingStandard\Sniffs\Functions\StrictCallSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\ReferenceUsedNamesOnlySniff;
use SlevomatCodingStandard\Sniffs\Namespaces\UnusedUsesSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\UselessAliasSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\UseSpacingSniff;
use SlevomatCodingStandard\Sniffs\Variables\DisallowSuperGlobalVariableSniff;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])

    ->withPreparedSets(
        psr12: true,
        cleanCode: true,
    )
    ->withConfiguredRule(UnusedUsesSniff::class, [
        'searchAnnotations' => true,
    ])
    ->withConfiguredRule(ForbiddenFunctionsSniff::class, [
        'forbiddenFunctions' => [
            'sizeof' => 'count', //keep the default option
            'delete' => 'unset', //keep the default option
            'dump' => null, //debug statement
            'dd' => null, //debug statement
            'var_dump' => null, //debug statement
            'print_r' => null, //debug statement
            'exit' => null,
        ],
    ])
    ->withConfiguredRule(ClassStructureSniff::class, [
        'groups' => [
            'uses',
            'constants',
            'enum cases',
            'properties',
            'constructor',
            'static constructors',
            'destructor',
            'magic methods',
            'all public methods',
            'all protected methods',
            'all private methods',
        ],
    ])
    ->withConfiguredRule(ReferenceUsedNamesOnlySniff::class, [
        'searchAnnotations' => true,
        'allowFullyQualifiedNameForCollidingClasses' => true,
    ])
    ->withRules([
        ArrayIndentSniff::class,
        SpaceAfterCastSniff::class,
        StaticClosureSniff::class,
        DisallowSuperGlobalVariableSniff::class,
        ClassConstantVisibilitySniff::class,
        DeclareStrictTypesFixer::class,
        NoExtraBlankLinesFixer::class,
//        FinalClassFixer::class,
        MethodSpacingSniff::class,
        UselessAliasSniff::class,
        EmptyCommentSniff::class,
        UseSpacingSniff::class,
        StrictCallSniff::class,
        PhpUnitConstructFixer::class,
        PhpUnitDedicateAssertFixer::class,
    ])
    ;
