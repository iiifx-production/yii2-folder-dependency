# Yii2 Folder Dependency

FolderDependency - дополнительная зависимость для фреймворка Yii2, которая позволяет сбрасывать кэш при обнаружении изменений папки или содержащихся в ней файлов.

[![Latest Version on Packagist][ico-version]][link-packagist] [![Build Status][ico-travis]][link-travis] [![Software License][ico-license]](LICENSE.md) [![Total Downloads][ico-downloads]][link-downloads]

## Установка

Используя Composer:

``` bash
$ composer require iiifx-production/yii2-folder-dependency
```

или добавить в composer.json, в секцию require:

``` json
    "iiifx-production/yii2-folder-dependency": "0.1.*@stable"
```

## Использование

``` php
use iiifx\cache\dependency\FolderDependency;

$cache = Yii::$app->cache;

# Проверяем наличие кэша
if ( ( $cachedData = $cache->get( 'some-cache-key' ) ) === FALSE ) {

    # Кэша нет, подготавливаем данные
    $cachedData = [ /* .. */ ];

    # Создаем зависимость для кэша
    $folderDependency = new FolderDependency( [
        'folder' => '/path/to/folder'
    ] );

    # Кэшируем данные
    $cache->set( 'some-cache-key', $cachedData, 0, $folderDependency );

}

# Пользуемся данными
var_export( $cachedData );
```

В данном примере кэш будет создан при первом запросе. При последующих запросах будут использоваться закэшариванные данные, пока папка folder или размещенные в ней файлы не изменятся. Любое изменение файла внутри folder будет обнаружено и кэш потеряет свою актуальность.
Не имеет значения какое количество файлов будет содержать folder, это никак не повлияет на производительность. Зависимость проверяет лишь папку, не затрагивая файлы, который в ней содержаться.


Для создания зависимости от нескольких папок пути можно передать списком:

``` php
$foldersDependency = new FolderDependency( [
    'folder' => [
        '/path/to/folder1',
        '/path/to/folder2',
        '/path/to/folder3',
    ]
] );
```

В этом случае кэш потеряет свою актуальность при изменении любой папки или любого файла внутри папок.

## !!! Важно !!!

Зависимость не обнаружит изменения во вложенных папках, которые размещены внутри указанных в folder.

Флаг reusable по умолчанию установлен в TRUE.

## Тесты

В данный момент не реализованы.

## Лизценция

[![Software License][ico-license]](LICENSE.md)

[ico-version]: https://img.shields.io/packagist/v/iiifx-production/yii2-folder-dependency.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/iiifx-production/yii2-folder-dependency.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/thephpleague/:package_name/master.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/iiifx-production/yii2-folder-dependency
[link-downloads]: https://packagist.org/packages/iiifx-production/yii2-folder-dependency
[link-travis]: https://travis-ci.org/iiifx-production/yii2-folder-dependency

[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/iiifx-production/yii2-folder-dependency/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

