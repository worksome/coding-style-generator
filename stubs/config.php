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
                            'badCode' => /** @lang PHP */ <<<BAD_CODE
                            function myMethod() {
                                return 'works';
                            }
                            BAD_CODE,
                            'goodCode' => /** @lang PHP */ <<<GOOD_CODE
                            function myMethod(): string {
                                return 'works';
                            }
                            GOOD_CODE,
                            'title' => 'Must declare return type',
                            'description' => 'Always add return types.',
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