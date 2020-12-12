<?php
if(!isset($_SESSION['sys'])){
    session_start();
}
if(isset($_SESSION['sys']) && isset($_SESSION['domain'])):
require './_app/Config.inc.php';
//Get POST values
$act2 = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if(!isset($_SESSION['document_root']) || isset($act2['domainchange'])):
    $i = (isset($act2['domainchange']) ? $act2['domainchange'] : 0);
    $_SESSION['document_root'] = $_SESSION['domain'][$i]['document_root'] . '/';
    if($_SESSION['domain'][$i]['ssl'] == 's'):
        $_SESSION['url'] = 'https://' . $_SESSION['domain'][$i]['domain'];
    else:
        $_SESSION['url'] = 'http://' . $_SESSION['domain'][$i]['domain'];
    endif;    
endif;
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="margin-bottom: 10px;">
    <a class="navbar-brand" href="#">File Manager</a>
    <label for="domainchange" class="text-light" style="margin: 0px 4px;"> Selecione o Domínio: </label>
    <select class="form-control col-md-4" id="domainchange" name="domainchange" onchange="actions(this, '', 'changedomain')">
	<?php
	$selected = '';
	$i = 0;
	foreach($_SESSION['domain'] as $domain):
	    if($_SESSION['document_root'] == $domain['document_root'] . '/'):
                $selected = ' selected="selected"';
            else:
                $selected = '';
            endif;
	?>
	<option value="<?= $i; ?>"<?= $selected; ?>><?= $domain['domain']; ?></option>
	<?php
	    $i++;
	endforeach;
        ?>
    </select>
</nav>
<?php
exec("echo \"M3g@l1v3\" | sudo -S chmod 0777 {$_SESSION['document_root']}/web", $out);
// Dir Base
$base = $_SESSION['document_root'];

$dir = $base;
$path = '';
//Checks whether a folder has been opened
if(isset($act2['folder']) || isset($_GET['folder'])):
    if(isset($act2['folder'])):
        $folder = $act2['folder'];
        $verifica = explode('/', $folder);
    else:
        $folder = $_GET['folder'];
        $verifica = explode('/', $folder);
    endif;
    
    if(!in_array('..', $verifica)):
        $path = $folder;
    endif;    
endif;
//Set Full Path
$fullpath = $base . $path;
//Upload
if(isset($act2['upload'])):
    $action = new file_upload($_POST['upload_dir']);
    $action->loadfile($_FILES['file_uploaded']);
endif;
 //Download File Normal
if(isset($_GET['download'])):
    $action = new Actions($fullpath);
    $action->download($_GET['file']);

endif;
//Download as Zip
if(isset($_GET['download_zip'])):
    $action = new Actions($fullpath);
    $action->download_zip($_GET['file']);
endif;

if(isset($_GET['download_folder_zip'])):
    $the_folder = $fullpath;
     
    
    $zip_file_name = $fullpath . '/' . $_GET['folder'] . '.zip';

    $za = new folder_zip;
    $res = $za->open($zip_file_name, ZipArchive::CREATE);
    if($res === TRUE) 
    {
        $za->addDir($the_folder, basename($the_folder));
        $za->close();
	header('Content-disposition: attachment; filename=' . $_GET['folder'] . '');
        header('Content-type: application/zip');
        readfile($zip_file_name);
	unlink($zip_file_name);

    }
    else{
        echo 'Could not create a zip archive';
    }

endif;




//Actions
if(isset($act2['action']) && $act2['action'] == true):
    $action = new Actions($fullpath);
    //Action IF Rename
    if(isset($act2['rename'])):
        $action->Rename($act2['rename'], $act2['newname']);
    //Action IF New Folder or File
    elseif(isset($act2['new'])):
        //IF New Folder
        if(isset($act2['type']) && $act2['type'] == 'folder'):
            $action->newFolder($act2['new']);
        //IF New File
        elseif(isset($act2['type']) && $act2['type'] == 'file'):
            $action->newFile($act2['new']);
        endif;
    //Delete File OR Folder
    elseif(isset($act2['delete'])):
        $action->delete($act2['delete']);
    endif;
endif;
//Tipos Editaveis
$editaveis = ['html', 'txt', 'js', 'css', 'php'];

            ?>
            <div class="container">
                <div class="form-group row">
                    <div class="col-xs-3">
                        <input type="text" placeholder="name | name.ext" id="newitem" value="" class="form-control col-xs-2" />
                    </div>
                    <div class="col-xs-3">
                        <button class="btn btn-success" type="button"  onclick="actions('folder', '<?= $path; ?>', 'new')">New Folder</button>
                    </div>
                    <div class="col-xs-3">
                        <button class="btn btn-primary" type="button" onclick="actions('file', '<?= $path; ?>', 'new')">New File</button>
                    </div>
                </div>
                <div class="form-group row">        
                    <form action="index.php" method="post" enctype="multipart/form-data">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                 <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01" name="file_uploaded" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label" for="inputGroupFile01">Escolha um Arquivo</label>
                            </div>
                            <button type="submit" class="btn btn-secondary col-xs-2" name="upload">Eviar</button>
                            <input type="hidden" name="folder" value="<?= $path; ?>">
                            <input type="hidden" name="upload_dir" value="<?= $fullpath; ?>">
                        </div>
                    </form>
                </div>
            </div>
            <div id="confirm" style="margin: 10px 0px;"></div>
            <p></p>
            <div>
                <?php 
                if(isset($action) && $action->getMsg() != null):
                    foreach ($action->getMsg() as $mensagem):
                        UIErro($mensagem[0], $mensagem[1]);
                    endforeach;                
                endif;
                ?>
                <span><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i></a></span>
<?php

//Checks whether the path has been added
if($path != ''):
    $dir = $dir.'/'.$path;
    $results = scandir($dir);
//Creates bread crumbs
    $breadcrumbs = explode('/', $path);
    $url = '';
    foreach($breadcrumbs as $breadcrumb):
        if($url == ''):
            $url = $breadcrumb;
        else:
            $url = $url . '/' . $breadcrumb;
        endif;
        
?>
            <span> / <a href="#" onclick="actions('<?= $url; ?>', '<?= $path; ?>', 'abrir')"><?= $breadcrumb; ?></a></span>
<?php
    endforeach;
else:
    $results = scandir($dir);
endif;

?>


                <p class="fieldset-legend">Diretórios</p>
                <div class="table-wrapper marginTop15">
                    <table class="table">
                        <thead class="dark form-group-sm">
                            <tr>
                                <th class="tiny-col" data-column="active">Name</th>
                                <th class="tiny-col" data-column="remote_access">Size</th>
                                <th class="tiny-col" data-column="remote_access">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
<?php

//Reads the current directory and filters by folder and files
foreach($results as $result):
if($result != '.'):
    if(is_dir($dir.'/'.$result)):
	if($dir == $base):
	    if($result != '..'):
	       $folders[] = $result;
            endif;
	else:
	    $folders[] = $result;
        endif;
    else:
        $files[] = $result;
    endif;
endif;
endforeach;
//
foreach($folders as $folder):
    if($path != ''):
	if($folder == '..'):
            $np = explode('/', $path);
            if(count($np) >= 2):
                $url = '';
	    for($i = 0; $i < count($np) - 1; $i++):
                if($i == 0): $url = $url . $np[$i];
                else: $url = $url . '/' . $np[$i];
                endif;
            endfor;
            else:
                $url = '';
            endif;
        else:
            $url = $path.'/'.$folder;
        endif;
    else:
        $url = $folder;
    endif;


?>
                            <tr>
                                <td><a href="#" onclick="actions('<?= $url; ?>', '<?= $path; ?>', 'abrir')"><i class="fa fa-folder" aria-hidden="true"></i> <?= $folder; ?></a></td>
                                <td><a href="#">Folder</a></td>
                                <td>
<?php
if($path != ''):
?>
                                    <a href="#" onclick="actions('<?= $folder; ?>', '<?= $path; ?>', 'renomear')"><i class="fa fa-edit" title="Renomear"></i></a>
                                    <a href="#" onclick="actions('<?= $folder; ?>', '<?= $path; ?>', 'deletar')"><i class="fa fa-trash" aria-hidden="true" title="Delete"></i></a>
<?php
endif;
?>
                                    <a href="?folder=<?= $path; ?>/&download_folder_zip=true&folder=<?= $folder; ?>"><i class="fa fa-file-archive-o" aria-hidden="true" title="Download Zip"></i></a>
                                </td>
                            </tr>
<?php
endforeach;

function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}
if(isset($files)):
foreach($files as $file):
$size = filesize($dir.'/'.$file);
$size = formatSizeUnits($size);
$type = pathinfo($file, PATHINFO_EXTENSION);

?>
                            <tr>
				<?php
				if(in_array($type, $editaveis)):
			        ?>
				<td><a href="code_editor.php?folder=<?= $path; ?>&file=<?= $file; ?>" target="_blank"><i class="fa fa-file-code-o" aria-hidden="true"></i> <?= $file; ?></a></td>
				<?php
				else:
				?>
				<td><a href="#"><i class="fa fa-file-o" aria-hidden="true"></i> <?= $file; ?></a></td>
				<?php
				endif;
				?> 
                                
                                <td><a href="#"><?= $size; ?></a></td>
                                <td>
                                    <a href="#" onclick="actions('<?= $file; ?>', '<?= $path; ?>', 'renomear')"><i class="fa fa-edit" title="Renomear"></i></a>
 				    <a href="#" onclick="actions('<?= $file; ?>', '<?= $path; ?>', 'deletar')"><i class="fa fa-trash" aria-hidden="true" title="Deletar"></i></a>
                                    <a href="?folder=<?= $path; ?>/&download_zip=true&file=<?= $file; ?>"><i class="fa fa-file-archive-o" aria-hidden="true" title="Download Zip"></i></a>
                                    <a href="?folder=<?= $path; ?>/&download=true&file=<?= $file; ?>"><i class="fa fa-download" aria-hidden="true" title="Download"></i></a>
                                    <a href="<?php echo $_SESSION['url']  . '/' . $file; ?>" target="_blank"><i class="fa fa-link" aria-hidden="true" title="Abrir"></i></a>
				                                  
                                 </td>
                            </tr>
<?php
endforeach;
endif;



?>

                        </tbody>
                    </table>
                </div>
            </div>

<?php
exec("echo \"M3g@l1v3\" | sudo -S chmod 0711 {$_SESSION['document_root']}/web");
else:
header("location: index.php");
endif;