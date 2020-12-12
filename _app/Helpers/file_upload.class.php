<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of file_upload
 *
 * @author Max
 */
class file_upload {
    private $File;
    private $Type;
    private $Name;
    private $Basedir;
    private $uploadAllow;
    private $Error;
    private $Msg;
    private $Count = 1;
    
    
    public function __construct($basedir) {
        $this->Basedir = $basedir . '/';
    }
    
    public function loadfile(array $file) {
        $this->File = $file;
        
        $this->getName();
        $this->getType();
        $this->fileTypePermission();
        $this->checkFilePermission();
        
        if(!$this->Error):
            $this->ExecUpload();
        endif;
    }
    
    public function getMsg() {
        if(isset($this->Error)):
            return $this->Error;
        else:
            return $this->Msg;
        endif;
    }


    private function getName(){
        if($this->Name == null || $this->Name == ''):
            $file = explode('.', $this->File['name']);
            $this->Name = $this->Basedir . Check::name(basename($file[0])) . '.' . $file[1];
        endif;
        if(!file_exists($this->Name)):
            return true;
        else:
            $file = explode('.', $this->File['name']);
            $newName = Check::Name(basename($file[0])) . '-' . $this->Count . '.' . $file[1];
            $this->Name = $this->Basedir . $newName;
            $this->Count++;
            $this->Msg[0] = ["Já Existiam arquivo com mesmo nome, foi renomeado para: {$newName}!", UI_INFOR];
            $this->getName();
        endif;
        
    }
    
    private function getType(){
        $this->Type =  strtolower(pathinfo($this->Name,PATHINFO_EXTENSION));
    }
    
    private function fileTypePermission(){        
        /*
         * Examples of Extensions and How to Use
         * png, jpg, bmp, gif, php, html, htm, txt, asp, doc, pdf, mp3, wav
         * 
         *  $this->uploadAllow = array('png', 'jpg', 'php', 'txt', 'html', 'pdf');
         */ 
        $this->uploadAllow = array('all');
    }
    
    private function checkFilePermission() {
        if(count($this->uploadAllow) >= 1 && !in_array('all', $this->uploadAllow) ):
            foreach($this->uploadAllow as $allow):
                if($this->Type === $allow):
                    return true;
                else:
                    $this->Error[] = ['Tipo de arquivo invalido!', UI_ALERT];
                endif;
            endforeach;
        elseif(in_array('all', $this->uploadAllow)):
            return true;
        endif;
    }
    
    private function ExecUpload(){
        if(move_uploaded_file($this->File["tmp_name"], $this->Name)):
            $this->Msg[] = ['Arquivo Enviado com Sucesso!', UI_ACCEPT];
        else:
            $this->Error[] = ['Não foi possível enviaro arquivo!', UI_ALERT];
        endif;
    }    
}
