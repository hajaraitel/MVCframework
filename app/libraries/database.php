<?php
/*
 * PDO database class
 * connect to db
 * create prepared statements
 * bind values
 * return rows and results
 */

class Database {
    private $host=DB_HOST;
    private $user=DB_USER;
    private $pass=DB_PASS;
    private $dbname=DB_NAME;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct()
    {
        $dsn='mysql:host='.$this->host.';dbname='.$this->dbname;
        $options=array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        //create PDO instance
        try{
            $this->dbh=new PDO($dsn,$this->user,$this->pass,$options);
        }catch(PDOException $e)
        {
            $this->error=$e->getMessage();
            echo $this->error; 
        }
    }

    public function query($sql)
    {
        $this->stmt=$this->dbh->prepare($sql);
    }

    //bind values to parameters
    public function bind($value,$param,$type=null)
    {
        if(is_null($type))
        {
            switch(true)
            {
                case is_int($type):
                    $type=PDO::PARAM_INT;
                    break;
                case is_bool($type):
                    $type=PDO::PARAM_BOOL;
                    break;
                case is_null($type):
                    $type=PDO::PARAM_NULL;
                    break;
                default:
                    $type=PDO::PARAM_STR;

            }
        }
        $this->stmt->bindValue($param,$value,$type);
    }

    //execute the query
    public function execute()
    {
        return $this->stmt->execute();
    }

    //get result set as array of objects
    public function getAll()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //get single object
    public function getObject()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function RowCount()
    {
        return $this->stmt->rowCount();
    }
}