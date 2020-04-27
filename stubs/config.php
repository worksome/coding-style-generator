<?php

use Worksome\CodingStyleGenerator\Contracts\Group;
use Worksome\CodingStyleGenerator\Contracts\Property;
use Worksome\CodingStyleGenerator\Contracts\SubGroup;

return [
    'title' => 'Php Insights generated coding style',
    'description' => 'Auto generated coding style by PHP Insights',
    'groups' => [
        Group::GENERIC_PHP => [
            Property::DESCRIPTION => 'All the rules listed here applies in general to all PHP code.',
            'preset' => null,
            'groups' => [
                SubGroup::FUNCTIONS => [
                    Property::DESCRIPTION => 'These are the rules which are related to a function or method.',
                    'insights' => [
                        'Camel case naming' => [
                            Property::BAD_CODE => /** @lang PHP */ <<<BAD_CODE
                            function my_private_method() {
                                return 'private';
                            }
                            BAD_CODE,
                            Property::GOOD_CODE => /** @lang PHP */ <<<GOOD_CODE
                            function myPrivateMethod() {
                                return 'private';
                            }
                            GOOD_CODE,
                            Property::INSIGHT => \PHP_CodeSniffer\Standards\PSR1\Sniffs\Methods\CamelCapsMethodNameSniff::class ,
                            Property::DESCRIPTION => 'When creating a method the name should always be following camel case naming.',
                        ],
                        'Must declare return type' => [
                            Property::BAD_CODE => /** @lang PHP */ <<<BAD_CODE
                            function myMethod() {
                                return 'works';
                            }
                            BAD_CODE,
                            Property::GOOD_CODE => /** @lang PHP */ <<<GOOD_CODE
                            function myMethod(): string {
                                return 'works';
                            }
                            GOOD_CODE,
                            Property::INSIGHT => \SlevomatCodingStandard\Sniffs\TypeHints\ReturnTypeHintSniff::class,
                            Property::DESCRIPTION => 'Always add return types.',
                        ],
                        'Void return types' => [
                            Property::BAD_CODE => /** @lang PHP */ <<<BAD_CODE
                            function handle()
                            {
                                // Do something
                            }
                            BAD_CODE,
                            Property::GOOD_CODE => /** @lang PHP */ <<<GOOD_CODE
                            function handle(): void
                            {
                                // Do something
                            }
                            GOOD_CODE,
                            Property::INSIGHT => \PhpCsFixer\Fixer\FunctionNotation\VoidReturnFixer::class,
                            Property::DESCRIPTION => <<<DESC
                            If a method returns nothing, it should be indicated with `void`.  
                            This makes it more clear to the users of your code what your intention was when writing it.
                            DESC,
                        ],
                        'Required visibility' => [
                            Property::INSIGHT => \PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer::class,
                            Property::DESCRIPTION => <<<DESC
                            When defining a method, the visibility must be declared also.  
                            - `abstract` and `final` MUST be declared before the visibility
                            - `static` MUST be declared after the visibility.
                            DESC,
                            Property::BAD_CODE => /** @lang PHP */ <<<BAD_CODE
                            class Example
                            {
                                static final function works(): void
                                {
                                    // Work work...
                                }
                            }
                            BAD_CODE,
                            Property::GOOD_CODE => /** @lang PHP */ <<<GOOD_CODE
                            class Example
                            {
                                final public static function works(): void
                                {
                                    // Work work...
                                }
                            }
                            GOOD_CODE,
                        ],
                    ],
                ],
                SubGroup::CODE => [
                    'insights' => [
                        'Declare strict' => [
                            Property::INSIGHT => \SlevomatCodingStandard\Sniffs\TypeHints\DeclareStrictTypesSniff::class,
                            Property::DESCRIPTION => 'It is recommended to add `declare(strict_types=1)` as it can fix some unexpected results when type hinting.  
Without strict it allows type coercion, meaning `bool` will be casted to `int` for example.',
                        ],
                        'Trailing commas on arrays' => [
                            Property::INSIGHT => \SlevomatCodingStandard\Sniffs\Arrays\TrailingArrayCommaSniff::class,
                            Property::DESCRIPTION => <<<DESC
                            When defining an array, we should always have a trailing comma as long as the array is multiple lines.  
                            When dealing with single line arrays, it is not required, however is allowed.
                            DESC,
                            Property::BAD_CODE => /** @lang PHP */ <<<BAD_CODE
                            \$array = [
                                'test' => 'bad'
                            ];
                            BAD_CODE,
                            Property::GOOD_CODE => /** @lang PHP */ <<<GOOD_CODE
                            \$array = [
                                'test' => 'bad',
                            ];
                            
                            // Or
                            \$array = ['test' => 'bad'];
                            GOOD_CODE,
                        ],
                        'Max length of lines' => function ($configuration) {
                            $configuration = $configuration[\PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff::class] ?? [];
                            $absoluteLinLimit = $configuration['absoluteLineLimit'] ?? 80;
                            return [
                                Property::INSIGHT => \PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff::class,
                                Property::DESCRIPTION => <<<DESC
                                A line should not be longer than $absoluteLinLimit characters long.
                                DESC,
                            ];
                        },
                    ],
                ],
                SubGroup::DOCUMENTATION => [
                    'insights' => [
                        'No redundant @param phpdoc annotations' => [
                            Property::INSIGHT => \SlevomatCodingStandard\Sniffs\TypeHints\ParameterTypeHintSniff::class,
                            Property::DESCRIPTION => <<<DESC
                            If the native method declaration contains everything and the phpDoc does not add anything useful
                            then the annotation can be removed as it is redundant.
                            DESC,
                            Property::BAD_CODE => /** @lang PHP */ <<<BAD_CODE
                            /**
                             * @param User \$user
                             */
                            public function handle(User \$user): void
                            {
                                // Do something on the user
                            }
                            BAD_CODE,
                            Property::GOOD_CODE => /** @lang PHP */ <<<GOOD_CODE
                            public function handle(User \$user): void
                            {
                                // Do something on the user
                            }
                            GOOD_CODE,
                        ]
                    ],
                ],
            ],
        ],
        Group::LARAVEL => [
            'preset' => \NunoMaduro\PhpInsights\Application\Adapters\Laravel\Preset::getName(),
            'groups' => [
                SubGroup::FUNCTIONS => [
                    'insights' => [
                        'Disallow debug methods' => [
                            Property::INSIGHT => \PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\ForbiddenFunctionsSniff::class,
                            Property::DESCRIPTION => 'Usage of `dd`, `ddd`, `dump` and `tinker` is not allowed.',
                        ],
                    ],
                ],
            ],
        ],
    ],
];