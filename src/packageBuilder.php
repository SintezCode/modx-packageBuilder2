<?php

declare(strict_types=1);

namespace SintezCode;

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
        $this->config['component']['modelPath']=$this->config['component']['modelPath']?:($this->config['component']['core'].'model/');
        $this->config['component']['schemaPath']=$this->config['component']['schemaPath']?:($this->config['component']['modelPath'].'schema/');
        $this->config['component']['servicePath']=$this->config['component']['servicePath']?:($this->config['component']['modelPath'].$this->config['component']['namespace'].'/');

        $this->modx->loadClass('transport.modPackageBuilder','',false, true);
    }
}