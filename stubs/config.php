<?php

use Worksome\CodingStyleGenerator\Contracts\Group;
use Worksome\CodingStyleGenerator\Contracts\Property;
use Worksome\CodingStyleGenerator\Contracts\SubGroup;
return [
    'title' => 'Php Insights generated coding style',
    'description' => 'Auto generated coding style by PHP Insights',
    'groups' => [
        Group::GENERIC_PHP => [
            'groups' => [
                SubGroup::FUNCTIONS => [
                    'insights' => [
                        \PHP_CodeSniffer\Standards\PSR1\Sniffs\Methods\CamelCapsMethodNameSniff::class => [
                            'badCode' => /** @lang PHP */ <<<BAD_CODE
                            function my_private_method() {
                                return 'private';
                            }
                            BAD_CODE,
                            'goodCode' => /** @lang PHP */ <<<GOOD_CODE
                            function myPrivateMethod() {
                                return 'private';
                            }
                            GOOD_CODE,
                            'title' => 'Camel case naming',
                            'description' => 'When creating a method the name should always be following camel case naming.',
                        ],
                        \SlevomatCodingStandard\Sniffs\TypeHints\ReturnTypeHintSniff::class => [
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
                            Property::TITLE => 'Must declare return type',
                            Property::DESCRIPTION => 'Always add return types.',
                        ],
                        \PhpCsFixer\Fixer\FunctionNotation\VoidReturnFixer::class => [
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
                            Property::TITLE => 'Void return types',
                            Property::DESCRIPTION => <<<DESC
                            If a method returns nothing, it should be indicated with `void`.  
                            This makes it more clear to the users of your code what your intention was when writing it.
                            DESC,
                        ],
                    ],
                ],
                SubGroup::CODE => [
                    'insights' => [
                        \SlevomatCodingStandard\Sniffs\TypeHints\DeclareStrictTypesSniff::class => [
                            'title' => 'Declare strict',
                            'description' => 'It is recommended to add `declare(strict_types=1)` as it can fix some unexpected results when type hinting.  
Without strict it allows type coercion, meaning `bool` will be casted to `int` for example.',
                        ],
                        \SlevomatCodingStandard\Sniffs\Arrays\TrailingArrayCommaSniff::class => [
                            Property::TITLE => 'Trailing commas on arrays',
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
                        \PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff::class => function ($configuration) {
                            $absoluteLinLimit = $configuration['absoluteLineLimit'] ?? 80;
                            return [
                                Property::TITLE => 'Max length of lines',
                                Property::DESCRIPTION => <<<DESC
                                A line should not be longer than $absoluteLinLimit characters long.
                                DESC,
                            ];
                        },
                    ],
                ],
                SubGroup::DOCUMENTATION => [
                    'insights' => [
                        \SlevomatCodingStandard\Sniffs\TypeHints\ParameterTypeHintSniff::class => [
                            Property::TITLE => 'No redundant @param phpdoc annotations',
                            Property::DESCRIPTION => <<<DESC
                            If the native method declaration contains everything and the phpDoc does not add anything useful
                            then the annotation can be removed as it is redundant.
                            DESC,
                            Property::BAD_CODE => /** @lang PHP */ <<<BAD_CODE
                            /**
                             * @param User $user
                             */
                            public function handle(User $user): void
                            {
                                // Do something on the user
                            }
                            BAD_CODE,
                            Property::GOOD_CODE => /** @lang PHP */ <<<GOOD_CODE
                            public function handle(User $user): void
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
            'groups' => [
                SubGroup::FUNCTIONS => [
                    'insights' => [
                        \PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\ForbiddenFunctionsSniff::class => [
                            'title' => 'Disallow debug methods',
                            'description' => 'Usage of `dd`, `ddd`, `dump` and `tinker` is not allowed.',
                        ],
                    ],
                ],
            ],
        ],
    ],
];