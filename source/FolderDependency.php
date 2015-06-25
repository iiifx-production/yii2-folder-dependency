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
     * @var string[]
     */
    public $folder;

    /**
     * @inheritdoc
     *
     * @throws InvalidConfigException
     */
    public function init () {
        parent::init();
        if ( $this->folder === NULL ) {
            throw new InvalidConfigException( 'FolderDependency::$folder must be set' );
        }
        if ( !is_array( $this->folder ) ) {
            $this->folder = (array) $this->folder;
        }
        if ( !$this->folder ) {
            throw new InvalidConfigException( 'FolderDependency::$folder must be the path to the folder' );
        }
        foreach ( $this->folder as $i => $folder ) {
            $folder = FileHelper::normalizePath( Yii::getAlias( $folder ) );
            if ( !is_dir( $folder ) ) {
                throw new InvalidConfigException( 'FolderDependency::$folder must be the path to the folder' );
            }
            $this->folder[ $i ] = $folder;
        }
    }

    /**
     * @param \yii\caching\Cache $cache
     *
     * @return array|null
     */
    protected function generateDependencyData ( $cache ) {
        $result = [ ];
        foreach ( $this->folder as $folder ) {
            if ( ( $stat = @stat( $folder ) ) ) {
                $result[ ] = $stat[ 'atime' ] . '-' . $stat[ 'mtime' ] . '-' . $stat[ 'ctime' ];
            }
        }
        if ( $result ) {
            return implode( '/', $result );
        }
        return NULL;
    }

}
