<?php

return [
    'name' => 'Pages',
    'controller' => 'PagesController',
    'actions' => 'get;index,post;store',
    'fields' => 'name,slug,summary,body,image,more_images,seo_title,meta_description,meta_keywords',
    'menu' => true,
    'author' => 'Mauro Lacerda - contato@maurolacerda.com.br'
];