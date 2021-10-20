<?php

declare(strict_types=1);

namespace SintezCode\MODX;

use modX;

/**
 * This is the MODX packages builder class.
 *
 * It can be used to build packages without installed MODX and database.
 *
 */
class packageBuilder{
    /**
     * @var modX|null
     */
    protected $modx=null;
    /**
     * @var array
     * build configuration
     */
    protected $config=[];
    /**
     * @var mixed
     * package configuration
     */
    protected $package;

    /**
     * packageBuilder constructor.
     * @param modX $modx
     * @param string $package - JSON or path to JSON file with package configuration
     * @param array $config
     */
    public function __construct(modX &$modx, string $package, array $config=[]){
        $this->modx=$modx;
        $this->config=$config;

        if(file_exists($package))$package=file_get_contents($package);
        /*TODO
            Тут должна быть валидация $package по json-схеме
            https://github.com/justinrainbow/json-schema
            https://habr.com/ru/post/158927/
        */
        $this->package=json_decode($package,true);

        $this->modx->loadClass('transport.modPackageBuilder','',false, true);
    }

    /**
     *
     */
    public function build():bool{

        return true;
    }
}
