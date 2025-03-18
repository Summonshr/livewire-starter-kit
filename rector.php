<?php

declare(strict_types=1);

use RectorLaravel\Rector\ClassMethod\MigrateToSimplifiedAttributeRector;
use Rector\Arguments\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Arguments\Rector\ClassMethod\ReplaceArgumentDefaultValueRector;
use Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;
use Rector\CodeQuality\Rector\ClassMethod\ExplicitReturnNullRector;
use Rector\CodeQuality\Rector\FuncCall\ArrayMergeOfNonArraysToSimpleArrayRector;
use Rector\CodeQuality\Rector\FuncCall\CallUserFuncWithArrowFunctionToInlineRector;
use Rector\CodeQuality\Rector\FuncCall\ChangeArrayPushToArrayAssignRector;
use Rector\CodeQuality\Rector\Identical\FlipTypeControlToUseExclusiveTypeRector;
use Rector\CodeQuality\Rector\If_\CombineIfRector;
use Rector\CodeQuality\Rector\If_\CompleteMissingIfElseBracketRector;
use Rector\CodeQuality\Rector\NullsafeMethodCall\CleanupUnneededNullsafeOperatorRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\Assign\RemoveUnusedVariableAssignRector;
use Rector\DeadCode\Rector\Foreach_\RemoveUnusedForeachKeyRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector;
use RectorLaravel\Rector\BooleanNot\AvoidNegatedCollectionContainsOrDoesntContainRector;
use RectorLaravel\Rector\Class_\ModelCastsPropertyToCastsMethodRector;
use RectorLaravel\Rector\Class_\UnifyModelDatesWithCastsRector;
use RectorLaravel\Rector\ClassMethod\AddGenericReturnTypeToRelationsRector;
use RectorLaravel\Rector\ClassMethod\AddParentBootToModelClassMethodRector;
use RectorLaravel\Rector\Coalesce\ApplyDefaultInsteadOfNullCoalesceRector;
use RectorLaravel\Rector\Empty_\EmptyToBlankAndFilledFuncRector;
use RectorLaravel\Rector\FuncCall\NotFilledBlankFuncCallToBlankFilledFuncCallRector;
use RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector;
use RectorLaravel\Rector\If_\AbortIfRector;
use RectorLaravel\Rector\If_\ThrowIfRector;
use RectorLaravel\Rector\MethodCall\AssertSeeToAssertSeeHtmlRector;
use RectorLaravel\Rector\MethodCall\AssertStatusToAssertMethodRector;
use RectorLaravel\Rector\MethodCall\AvoidNegatedCollectionFilterOrRejectRector;
use RectorLaravel\Rector\MethodCall\EloquentOrderByToLatestOrOldestRector;
use RectorLaravel\Rector\MethodCall\EloquentWhereRelationTypeHintingParameterRector;
use RectorLaravel\Rector\MethodCall\EloquentWhereTypeHintClosureParameterRector;
use RectorLaravel\Rector\MethodCall\RedirectBackToBackHelperRector;
use RectorLaravel\Rector\MethodCall\RedirectRouteToToRouteHelperRector;
use RectorLaravel\Rector\MethodCall\ReverseConditionableMethodCallRector;
use RectorLaravel\Rector\MethodCall\UnaliasCollectionMethodsRector;
use RectorLaravel\Rector\MethodCall\WhereToWhereLikeRector;
use RectorLaravel\Rector\StaticCall\EloquentMagicMethodToQueryBuilderRector;
use RectorLaravel\Rector\StaticCall\RouteActionCallableRector;
use RectorLaravel\Set\LaravelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/routes',
        __DIR__ . '/resources',
        __DIR__ . '/tests',
    ])
    ->withSets([
        LaravelSetList::LARAVEL_110,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::ARRAY_STR_FUNCTIONS_TO_STATIC_CALL,
        LaravelSetList::LARAVEL_ARRAYACCESS_TO_METHOD_CALL,
        LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_COLLECTION,
        LaravelSetList::LARAVEL_IF_HELPERS,
        LaravelSetList::LARAVEL_LEGACY_FACTORIES_TO_CLASSES,
        LevelSetList::UP_TO_PHP_82,
        SetList::EARLY_RETURN,
        SetList::INSTANCEOF,
    ])->withSkip([
        ClosureToArrowFunctionRector::class,
        DeclareStrictTypesRector::class,
    ])
    ->withRules([
        AbortIfRector::class,
        AddGenericReturnTypeToRelationsRector::class,
        ApplyDefaultInsteadOfNullCoalesceRector::class,
        ArgumentAdderRector::class,
        ArrayMergeOfNonArraysToSimpleArrayRector::class,
        AssertSeeToAssertSeeHtmlRector::class,
        AssertStatusToAssertMethodRector::class,
        AvoidNegatedCollectionContainsOrDoesntContainRector::class,
        AvoidNegatedCollectionFilterOrRejectRector::class,
        CallUserFuncWithArrowFunctionToInlineRector::class,
        ChangeArrayPushToArrayAssignRector::class,
        CleanupUnneededNullsafeOperatorRector::class,
        CombineIfRector::class,
        CompleteDynamicPropertiesRector::class,
        CompleteMissingIfElseBracketRector::class,
        EloquentMagicMethodToQueryBuilderRector::class,
        EloquentOrderByToLatestOrOldestRector::class,
        AddParentBootToModelClassMethodRector::class,
        EloquentWhereRelationTypeHintingParameterRector::class,
        EloquentWhereTypeHintClosureParameterRector::class,
        EmptyToBlankAndFilledFuncRector::class,
        MigrateToSimplifiedAttributeRector::class,
        ExplicitReturnNullRector::class,
        FlipTypeControlToUseExclusiveTypeRector::class,
        ModelCastsPropertyToCastsMethodRector::class,
        NotFilledBlankFuncCallToBlankFilledFuncCallRector::class,
        RedirectBackToBackHelperRector::class,
        RedirectRouteToToRouteHelperRector::class,
        RemoveDumpDataDeadCodeRector::class,
        RemoveUnusedForeachKeyRector::class,
        RemoveUnusedVariableAssignRector::class,
        ReplaceArgumentDefaultValueRector::class,
        RouteActionCallableRector::class,
        ThrowIfRector::class,
        UnaliasCollectionMethodsRector::class,
        UnifyModelDatesWithCastsRector::class,
    ])
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        earlyReturn: true,
        strictBooleans: true,
        naming: true,
        instanceOf: true,
        carbon: true,
        rectorPreset: true,
        symfonyCodeQuality: true,
    )
    ->withImportNames()
    ->withMemoryLimit('2048M');
