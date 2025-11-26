<?php
 = 'resources/views/home.blade.php';
 = file_get_contents();
 = [
    '?sltimas' => 'Últimas',
    'h?roes' => 'héroes',
    'pr??ximo' => 'próximo',
    'cap??tulo' => 'capítulo',
    'gu??as' => 'guías',
    'mos' => 'más',
    '?picos' => 'épicos',
    'Agn' => 'Aún',
    '??Vuelve pronto!' => '¡Vuelve pronto!',
    'bolet??n' => 'boletín',
    '?sltimos' => 'Últimos',
    'art??culos' => 'artículos',
    'Todav??a' => 'Todavía',
];
 = str_replace(array_keys(), array_values(), );
file_put_contents(, );

