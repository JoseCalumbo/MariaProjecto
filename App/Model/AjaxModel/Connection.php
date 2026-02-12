<?php  

namespace App\Model\AjaxModel;

use PDO;

class Connection{

    public static function connect(){
        
        $pdo = new PDO("mysql:host=localhost;dbname=bd_auxiliarmedico", "root", "");

        $pdo ->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        return $pdo;
    }
}