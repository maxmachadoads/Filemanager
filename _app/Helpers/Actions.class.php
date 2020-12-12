<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Actions
 *
 * @author Max
 */
class Actions {
    private $Path;
    private $Error;
    private $Msg;
    private $Zip;

    public function __construct($path) {
        $this->Path = $path;
    }
    
    public function getMsg() {
        if(isset($this->Error)):
            return $this->Error;
        else:
            return $this->Msg;
        endif;
    }

    public function newFolder($new){
        if(!is_dir($this->Path . '/' . $new)):
            if(mkdir($this->Path . '/' . $new)):
                $this->Msg[] = ['Pasta criada com Sucesso!', UI_ACCEPT];
            else:
                $this->Error[] = ['Não foi possível Criar Pasta!', UI_ALERT];
            endif;
        else:
            $this->Error[] = ['Essa pasta já Existe!', UI_ALERT];
        endif;
    }
    
    public function newFile($new) {
        if(!file_exists($this->Path . '/' . $new)):
            if(fopen($this->Path . '/' . $new, "w")):
                $this->Msg[] = ['Arquivo criado com Sucesso!', UI_ACCEPT];
            else:
                $this->Error[] = ['Não foi possível Criar Arquivo!', UI_ALERT];
            endif;
        else:
            $this->Error[] = ['Já Existe um arquivo com esse nome!', UI_ALERT];
        endif;
    }

    public function Rename($old, $new) {
        if(rename($this->Path . $old, $this->Path . $new)):
            $this->Msg[] = ['Renomeado com Sucesso!', UI_ACCEPT];
        else:
            $this->Error[] = ['Não foi possível renomear!', UI_ALERT];
        endif;
    }
    
    public function delete($obj) {
        
        if(is_dir($this->Path . '/' . $obj)):
              $this->removeDir($this->Path . '/' . $obj);
        else:
            if(unlink($this->Path . '/' . $obj)):
                $this->Msg[] = ['Arquivo Excluido com Sucesso!!', UI_ACCEPT];
            else:
                $this->Error[] = ['Não foi possível Excluir o Arquivo!', UI_ALERT];
            endif;            
        endif;
    }
    
    private function removeDir($dir) {
        $this->Msg[] = ["$dir Excluido com Sucesso!!", UI_ACCEPT];
        if( is_dir( $dir ) )
        {
            $files = glob( $dir . '*', GLOB_MARK ); 
            foreach( $files as $file )
            {
                $this->removeDir( $file );      
            }
            @rmdir( $dir );
        } 
        elseif( is_file( $dir ) ) 
        {
            unlink( $dir );  
        }
    }
    
    public function download($file) {

	$path   = $this->Path . '/' . $file;  
	$contentType = mime_content_type( $path  );
        header('Content-Description: File Transfer');
        header('Cache-Control: public');
        header('Content-Type: ' . $contentType . '');
        header("Content-Transfer-Encoding: binary");
        header('Content-Disposition: attachment; filename='. basename($path));
        header('Content-Length: '.filesize($path));
        ob_clean(); 
        flush();
        readfile($path);
        exit;
    }

    public function download_zip($name){	

        $n = explode('.', $name);
        $n = $n[0] . '.zip';
        $type = 'file';
	//echo $this->Path;
  	
        $zip = new ZipArchive;
        $tmp_file = $this->Path . $n;
        if ($zip->open($tmp_file,  ZipArchive::CREATE)) {
            
            $zip->addFile($this->Path . $name, $name);                
            $zip->close();

            header('Content-disposition: attachment; filename=' . $n . '');
            header('Content-type: application/zip');
            readfile($tmp_file);
	    unlink($tmp_file);
	    $this->Msg = ['Arquivo gerado com sucesso!', UI_ACEPT];

        } else {
            echo 'Failed!';
        }
   }    	  
}