<?php

namespace iiifx\cache\dependency;

use yii\base\InvalidConfigException;
use yii\caching\Dependency;
use yii\helpers\FileHelper;
use Yii;

/**
 * Class FolderDependency
 *
 * @author  Vitaliy IIIFX Khomenko <iiifx@yandex.com
 *
 * @package iiifx\cache\dependency
 */
class FolderDependency extends Dependency {

    /**
     * Path to folder
     *
     * @var string
     */
    public $folder;

    /**
     * @param \yii\caching\Cache $cache
     *
     * @return array|null
     *
     * @throws InvalidConfigException
     */
    protected function generateDependencyData ( $cache ) {
        if ( $this->folder === NULL ) {
            throw new InvalidConfigException( 'FolderDependency::$folder must be set' );
        }
        $this->folder = FileHelper::normalizePath( Yii::getAlias( $this->folder ) );
        if ( !is_dir( $this->folder ) ) {
            throw new InvalidConfigException( 'FolderDependency::$folder must be the path to the folder' );
        }
        if ( ( $stat = @stat( $this->folder ) ) ) {
            return [
                $stat[ 'atime' ],
                $stat[ 'mtime' ],
                $stat[ 'ctime' ],
            ];
        }
        return NULL;
    }

}
