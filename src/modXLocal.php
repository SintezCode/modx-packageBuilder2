<?php

declare(strict_types=1);

namespace SintezCode;

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
        'log_target'=>'ECHO'
    ];

    /**
     * Imitate config loading.
     * @return array|null
     */
    public function getConfig()
    {
        if (!$this->_initialized || !is_array($this->config) || empty ($this->config)) {
            $this->_config= $this->config;
            if (!$this->_loadConfig()) {
                $this->log(modX::LOG_LEVEL_FATAL, "Could not load core MODX configuration!");
                return null;
            }
        }
        return $this->config;
    }

    /**
     * Imitate config loading.
     * @param string $configPath
     * @param array $data
     * @param null $driverOptions
     * @return array
     */
    protected function loadConfig($configPath = '', $data = array(), $driverOptions = null) {
        return [
            xPDO::OPT_CACHE_KEY => 'default',
            xPDO::OPT_CACHE_HANDLER => 'xPDOFileCache',
            xPDO::OPT_CACHE_PATH => MODX_CORE_PATH . 'cache/',
            xPDO::OPT_HYDRATE_FIELDS => true,
            xPDO::OPT_HYDRATE_RELATED_OBJECTS => true,
            xPDO::OPT_HYDRATE_ADHOC_FIELDS => true,
            xPDO::OPT_CONNECTIONS => [
                [
                    'dsn' => 'mysql:host=localhost;dbname=local;charset=utf8',
                    'username' => 'local',
                    'password' => 'local',
                    'options' => [xPDO::OPT_CONN_MUTABLE => true],
                    'driverOptions' => [],
                ]
            ]
        ];
    }

    /**
     * Imitate config loading.
     * @return bool
     */
    protected function _loadConfig() {
        $this->config=[
            'dbtype'=>'mysql',
            xPDO::OPT_CACHE_PATH => MODX_CORE_PATH . 'cache/',
            xPDO::OPT_CACHE_FORMAT=>xPDOCacheManager::CACHE_PHP
        ];
        $this->_systemConfig = $this->config;
        return true;
    }

    /**
     * Imitate getting objects from DB
     * @param string $className
     * @param null $criteria
     * @param bool $cacheFlag
     * @return bool|object|null
     */
    public function getObject($className, $criteria= null, $cacheFlag= true){
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

    /**
     * Get local system option before.
     * @param string $key
     * @param null $options
     * @param null $default
     * @param bool $skipEmpty
     * @return array|mixed|string|null
     */
    public function getOption($key, $options = null, $default = null, $skipEmpty = false){
        if($options==null){
            $options=$this->systemOptions;
        }
        return parent::getOption($key, $options , $default, $skipEmpty);
    }
}