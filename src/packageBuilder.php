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
    public $modx=null;
    public $config=[];

    /**
     * packageBuilder constructor.
     * @param modX $modx
     * @param array $config
     */
    public function __construct(modX &$modx, array $config=[]){
        $this->modx=$modx;
        $this->config=$config;


        $this->modx->loadClass('transport.modPackageBuilder','',false, true);
    }
}