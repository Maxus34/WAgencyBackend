<?php
$tokens = [
    '{id}' => '<id:\d+>',
];


return [
    'admin/category/<id:\d+>/childs/' => 'admin/child-category/',
    [
        'class'         => 'yii\rest\UrlRule',
        'controller'    => ['api/category'],
        'pluralize'     => false,
        'tokens' => $tokens,
        'extraPatterns' => []
    ],
];