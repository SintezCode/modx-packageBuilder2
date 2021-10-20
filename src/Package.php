<?php


namespace SintezCode\MODX;


/**
 * Class Package
 * @package SintezCode\MODX
 *
 * Use this class to create and update configuration of your package
 */
class Package
{
    /**
     * @var array|mixed
     */
    protected $config=[];

    /**
     * Package constructor.
     * @param array|string $config - array or JSON string or path to JSON file with package configuration
     */
    public function __construct($config=[])
    {
        if (is_scalar($config)) {
            if (file_exists($config)) $config = file_get_contents($config);
            $config=json_decode($config,true);
        }
        $this->config=$config?:[];
    }

    /**
     * @param string $path - path to package source files (resolvers, objects, etc.)
     */
    public function setDir(string $path){

    }

    /**
     * @param string $name - name of package
     */
    public function setName(string $name){

    }

    /**
     *
     */
    public function increaseVersion(){

    }

    /**
     * @return string
     */
    public function toJSON():string {
        return json_encode($this->config);
    }

    /**
     * @param string $path - path to file where you want save configuration
     * @return bool
     */
    public function saveTo(string $path):bool{
        return (bool)file_put_contents($path,$this->toJSON());
    }
}
