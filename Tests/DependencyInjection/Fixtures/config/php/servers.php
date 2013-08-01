<?php

$container->loadFromExtension('lit_group_gearman', [
    'servers' => [
        '10.0.0.1:4703',
        '10.0.0.2:4703',
    ]
]);