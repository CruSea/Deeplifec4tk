<?php
namespace Messaging;

return array(
    'controllers' => array(
        'invokables' => array(
            'Messaging\Controller\Messaging' => 'Messaging\Controller\MessagingController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'messaging' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/messaging[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Messaging\Controller\Messaging',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Doctrine config
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        ),

        'configuration' => array(
            'orm_default' => array(
                'datetime_functions' => array(
                    'date' => 'DoctrineExtensions\Query\Mysql\Date',
                    'date_format' => 'DoctrineExtensions\Query\Mysql\DateFormat',
                    'dateadd' => 'DoctrineExtensions\Query\Mysql\DateAdd',
                    'datediff' => 'DoctrineExtensions\Query\Mysql\DateDiff',
                    'day' => 'DoctrineExtensions\Query\Mysql\Day',
                    'dayname' => 'DoctrineExtensions\Query\Mysql\DayName',
                    'last_day' => 'DoctrineExtensions\Query\Mysql\LastDay',
                    'minute' => 'DoctrineExtensions\Query\Mysql\Minute',
                    'second' => 'DoctrineExtensions\Query\Mysql\Second',
                    'strtodate' => 'DoctrineExtensions\Query\Mysql\StrToDate',
                    'time' => 'DoctrineExtensions\Query\Mysql\Time',
                    'timestampadd' => 'DoctrineExtensions\Query\Mysql\TimestampAdd',
                    'timestampdiff' => 'DoctrineExtensions\Query\Mysql\TimestampDiff',
                    'week' => 'DoctrineExtensions\Query\Mysql\Week',
                    'weekday' => 'DoctrineExtensions\Query\Mysql\WeekDay',
                    'year' => 'DoctrineExtensions\Query\Mysql\Year',
                ),
                'numeric_functions' => array(
                    'acos' => 'DoctrineExtensions\Query\Mysql\Acos',
                    'asin' => 'DoctrineExtensions\Query\Mysql\Asin',
                    'atan2' => 'DoctrineExtensions\Query\Mysql\Atan2',
                    'atan' => 'DoctrineExtensions\Query\Mysql\Atan',
                    'cos' => 'DoctrineExtensions\Query\Mysql\Cos',
                    'cot' => 'DoctrineExtensions\Query\Mysql\Cot',
                    'hour' => 'DoctrineExtensions\Query\Mysql\Hour',
                    'pi' => 'DoctrineExtensions\Query\Mysql\Pi',
                    'power' => 'DoctrineExtensions\Query\Mysql\Power',
                    'quarter' => 'DoctrineExtensions\Query\Mysql\Quarter',
                    'rand' => 'DoctrineExtensions\Query\Mysql\Rand',
                    'round' => 'DoctrineExtensions\Query\Mysql\Round',
                    'sin' => 'DoctrineExtensions\Query\Mysql\Sin',
                    'std' => 'DoctrineExtensions\Query\Mysql\Std',
                    'tan' => 'DoctrineExtensions\Query\Mysql\Tan',
                ),
                'string_functions' => array(
                    'binary' => 'DoctrineExtensions\Query\Mysql\Binary',
                    'char_length' => 'DoctrineExtensions\Query\Mysql\CharLength',
                    'concat_ws' => 'DoctrineExtensions\Query\Mysql\ConcatWs',
                    'countif' => 'DoctrineExtensions\Query\Mysql\CountIf',
                    'crc32' => ' DoctrineExtensions\Query\Mysql\Crc32',
                    'degrees' => 'DoctrineExtensions\Query\Mysql\Degrees',
                    'field' => 'DoctrineExtensions\Query\Mysql\Field',
                    'find_in_set' => 'DoctrineExtensions\Query\Mysql\FindInSet',
                    'group_concat' => 'DoctrineExtensions\Query\Mysql\GroupConcat',
                    'ifelse' => 'DoctrineExtensions\Query\Mysql\IfElse',
                    'ifnull' => 'DoctrineExtensions\Query\Mysql\IfNull',
                    'match_against' => 'DoctrineExtensions\Query\Mysql\MatchAgainst',
                    'md5' => 'DoctrineExtensions\Query\Mysql\Md5',
                    'month' => 'DoctrineExtensions\Query\Mysql\Month',
                    'monthname' => 'DoctrineExtensions\Query\Mysql\MonthName',
                    'nullif' => 'DoctrineExtensions\Query\Mysql\NullIf',
                    'radians' => 'DoctrineExtensions\Query\Mysql\Radians',
                    'regexp' => 'DoctrineExtensions\Query\Mysql\Regexp',
                    'replace' => 'DoctrineExtensions\Query\Mysql\Replace',
                    'sha1' => 'DoctrineExtensions\Query\Mysql\Sha1',
                    'sha2' => 'DoctrineExtensions\Query\Mysql\Sha2',
                    'soundex' => 'DoctrineExtensions\Query\Mysql\Soundex',
                    'uuid_short' => 'DoctrineExtensions\Query\Mysql\UuidShort',
                ),

            )
        ),

    )
);