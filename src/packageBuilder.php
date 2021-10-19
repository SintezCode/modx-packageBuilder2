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
    protected $modx=null;
    protected $config=[];
    protected $package;

    /**
     * packageBuilder constructor.
     * @param modX $modx
     * @param array $config
     */
    public function __construct(modX &$modx, Package $package, array $config=[]){
        $this->modx=$modx;
        $this->package=$package;
        $this->config=$config;


        $this->modx->loadClass('transport.modPackageBuilder','',false, true);
    }

    public function build(){

    }
}
