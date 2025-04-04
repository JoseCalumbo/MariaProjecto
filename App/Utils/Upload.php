<?php

namespace App\Utils;

class Upload{

    private $name;
    private $extension;
    private $type;
    private $tmpName;
    public $error;
    private $size;
    private $duplicates=0;

    public function __construct($file){
        $this->type=$file['type'];
        $this->tmpName=$file['tmp_name'];
        $this->error=$file['error'];
        $this->size=$file['size'];

        $info = pathinfo($file['name']);
        $this->name = $info['filename'];
       $this->extension = $info['extension'] ?? '';
    }

    public function getBaseName(){
        $extension = strlen($this->extension) ? '.'.$this->extension: '';

        //validacao da duplicacao
        $duplicates = $this->duplicates > 0 ? '-'.$this->duplicates: '';
        return $this->name.$duplicates.$extension;
    }


    private function getPossibleBaseName($dir,$overwrite){

        if($overwrite) return $this ->getBaseName();

        $basename = $this ->getBaseName();

        if(!file_exists($dir.'/'.$basename)){
            return $basename;
        }

        $this->duplicates++;

        return $this->getPossibleBaseName($dir,$overwrite);
    }

    /** metodo  para mover arquivo */
    public function upload($dir, $overwrite = true){
         
        if($this->error !=0) return false;

        $path = $dir.'/'.$this->getPossibleBaseName($dir,$overwrite); 

        return move_uploaded_file($this->tmpName,$path);
    }

}