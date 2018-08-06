<?php
namespace AdelineD\OC\P9\Model;

abstract class Model {
    
    private $bdd;
    
    // Execute a possibly prepared SQL request
    protected function executeQuery($sql, $params = null) {
        if ($params == null) {
            $result = $this->getBdd()->query($sql);    // direct execution
        }
        else {
            $result = $this->getBdd()->prepare($sql);  // prepare query
            $result->execute($params);
        }
        return $result;
    }

    // BDD connection
    private function getBdd(){
        if($this->bdd == null){
            $this->bdd = new \PDO('mysql:host=ftp.adeline-decarpentries.fr;dbname=adelined_p8;charset=utf8', 'adelined_p8', '&projet8%', array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        }
        return $this->bdd;
    }

}
