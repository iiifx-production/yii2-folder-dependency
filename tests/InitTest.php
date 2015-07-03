<?php

use iiifx\cache\dependency\FolderDependency;

class InitTest extends PHPUnit_Framework_TestCase {

    public $failValues = [ ];

    public function setUp () {
        require_once __DIR__ . '/include/Yii.php';
        $this->failValues = [ TRUE, 1, 0.99, '', [ ], new \yii\base\Object(), fopen( __FILE__, 'r' ), NULL, function () {
        } ];
    }

    public function tearDown () {
    }

    /**
     * @expectedException yii\base\InvalidConfigException
     */
    public function testEmpty () {
        new FolderDependency();
    }

    public function testFailValues () {
        foreach ( $this->failValues as $value ) {
            $this->assertTrue( $this->isFailValue( $value ) );
        }
    }

    protected function isFailValue ( $value ) {
        try {
            new FolderDependency( [ 'folder' => $value ] );
        } catch ( Exception $e ) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * @expectedException yii\base\InvalidConfigException
     */
    public function testFailPath () {
        new FolderDependency( [ 'folder' => '/path/to/fail/directory-' . date( 'YmdHis' ) ] );
    }

    /**
     * @expectedException yii\base\InvalidConfigException
     */
    public function testFailFolder () {
        new FolderDependency( [ 'folder' => __FILE__ ] );
    }

    public function testSuccess1 () {
        try {
            new FolderDependency( [ 'folder' => __DIR__ ] );
        } catch ( Exception $e ) {
            $this->fail();
        }
    }

    public function testSuccess2 () {
        try {
            new FolderDependency( [ 'folder' => [ __DIR__, __DIR__ . '/../' ] ] );
        } catch ( Exception $e ) {
            $this->fail();
        }
    }

}
