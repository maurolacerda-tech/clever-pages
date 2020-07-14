# clever-pages
Módulo de criação de páginas do CMS da cleverweb.com.br

## Instalação
```
composer require maurolacerda-tech/clever-pages:dev-master
```
```
php artisan migrate
```

## Opcionais
Você poderá públicar os arquivos de visualização padrão em seu diretório views/vendor/Page

```
php artisan vendor:publish --provider="Modules\Pages\Providers\PageServiceProvider" --tag=views
```


Para públicar os arquivos de configurações.

```
php artisan vendor:publish --provider="Modules\Pages\Providers\PageServiceProvider" --tag=config
```

