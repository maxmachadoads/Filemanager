<?php
/**
 * Description of folder_zip
 * Essa classe eu peguei pronta do site https://www.codegrepper.com/code-examples/php/php+create+zip+from+folder+
 * @author php by Wild Weasel on May 09 2020
 */
class folder_zip extends ZipArchive{
    public function addDir($location, $name) 
    {
       $this->addEmptyDir($name);
       $this->addDirDo($location, $name);
    } 
 private function addDirDo($location, $name) 
    {
        $name .= '/';
        $location .= '/';
        $dir = opendir ($location);
        while ($file = readdir($dir))
        {
        if ($file == '.' || $file == '..') continue;
        $do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
        $this->$do($location . $file, $name . $file);
        }
    } 
}
