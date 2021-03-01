<?php

declare(strict_types=1);

namespace SintezCode\MODX;

use modX;
use xPDO;
use xPDOCacheManager;

/**
 * This is the class extends modX for locally building packages.
 *
 *
 */
class modXLocal extends modX
{
    /**
     * Local system options.
     * @var array
     */
    protected $systemOptions=[
        'core_path'=>MODX_CORE_PATH,
        'log_target'=>'ECHO',
        'error_handler_path'=>MODX_CORE_PATH.'model/modx/error/'
    ];

    protected function loadConfig($configPath = '', $data = array(), $driverOptions = null)
    {
        if (!defined('MODX_CONFIG_KEY')) {
            define('MODX_CONFIG_KEY', 'config');
        }
        global $config_options;

        return array_merge([
            xPDO::OPT_CACHE_KEY => 'default',
            xPDO::OPT_CACHE_HANDLER => 'xPDOFileCache',
            xPDO::OPT_CACHE_PATH => MODX_CORE_PATH . 'cache/',
            xPDO::OPT_HYDRATE_FIELDS => true,
            xPDO::OPT_HYDRATE_RELATED_OBJECTS => true,
            xPDO::OPT_HYDRATE_ADHOC_FIELDS => true,
        ],
            $config_options?:[
                xPDO::OPT_TABLE_PREFIX => '',
                'dbtype'=>'mysql',
                'dbname'=>'local',
            ],
            $data?:[]
        );
    }

    public function &getConnection(array $options = array())
    {
        if(!$this->connection){
            $this->connection=new  localConnection(
                $this,
                'mysql:host=localhost;dbname=local;charset=utf8','','',
                [xPDO::OPT_CONN_MUTABLE => true]
            );
        }
        return $this->connection;
    }

    public function getConfig()
    {
        if (!$this->_initialized || !is_array($this->config) || empty ($this->config)) {
            if (!defined('MODX_PROCESSORS_PATH'))
                define('MODX_PROCESSORS_PATH', MODX_CORE_PATH . 'model/modx/processors/');
            if (!isset ($this->config['processors_path']))
                $this->config['processors_path'] = MODX_PROCESSORS_PATH;
            $this->_config = $this->config;
            if (!$this->_loadConfig()) {
                $this->log(modX::LOG_LEVEL_FATAL, "Could not load core MODX configuration!");
                return null;
            }
        }
        return $this->config;
    }

    protected function _loadConfig()
    {
        $this->config = array_merge($this->config, [
            xPDO::OPT_CACHE_PATH => MODX_CORE_PATH . 'cache/',
            xPDO::OPT_CACHE_FORMAT=>xPDOCacheManager::CACHE_PHP
        ]);
        $this->_systemConfig = $this->config;
        return true;
    }

    public function getObject($className, $criteria= null, $cacheFlag= true)
    {
        switch(true){
            case $className=='modContext':{
                $ctx=$this->newObject('modContext',[
                    'key'=>'mgr','name'=>'Manager','rank'=>0
                ]);
                $ctx->set('key','mgr');
                return $ctx;
            }
            case $className=='modWorkspace':{
                return $this->newObject('modWorkspace',[
                    'path'=>MODX_CORE_PATH
                ]);
            }
            case $className=='modNamespace':{
                return false;
            }
            default:
                return parent::getObject($className, $criteria, $cacheFlag);
        }
    }

    public function getOption($key, $options = null, $default = null, $skipEmpty = false)
    {
        if($options==null){
            $options=$this->systemOptions;
        }
        return parent::getOption($key, $options , $default, $skipEmpty);
    }

    protected function _loadExtensionPackages($options = null)
    {

    }
}