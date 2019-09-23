<?php

$data = [];

$data['WEBSITE_ENV'] = empty(ini_get('WEBSITE_ENV')) ? 'development' : ini_get('WEBSITE_ENV');

$data['VUE_STATIC'] = [
    'js' => 'vue/js',
    'css' => 'vue/css',
    'img' => 'vue/img'
];

return $data;