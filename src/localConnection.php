<?php


namespace SintezCode\MODX;
use PDO;
use xPDO;
use xPDOConnection;

class localConnection extends xPDOConnection
{
    public function __construct(xPDO &$xpdo, $dsn = '', $username = '', $password = '', $options = array(), $driverOptions = array())
    {
        parent::__construct($xpdo,$dsn,$username,$password,$options,$driverOptions);
        $this->config['dbtype']='mysql';
    }

    public function connect($driverOptions = array())
    {
        $this->pdo= new PDO($this->config['dsn'], $this->config['username'], $this->config['password'], $this->config['driverOptions']);
        return true;
    }
}