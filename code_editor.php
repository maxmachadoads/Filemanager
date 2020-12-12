<?php
session_start();
$ApachePass = "Password for Apache User Here";
exec("echo \"$ApachePass\" | sudo -S chmod 0777 {$_SESSION['document_root']}/web");
if(isset($_SESSION['sys']) && isset($_SESSION['domain'])):
$act = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$act2 = filter_input_array(INPUT_GET, FILTER_DEFAULT);
if($act2['folder'] == ''):
    $folder = '';
else:
    $folder = $act2['folder'];
endif;

$arquivo = $_SESSION['document_root'] . $folder . '/' . $act2['file'];

if(isset($act['save'])):
    if(isset($act['editfile'])):
	if(file_put_contents($arquivo, $act['editfile'])):
             $msg = 'Arquivo Salvo com Exito!';
        endif;
    endif;
endif;

$myfile = htmlentities(file_get_contents($arquivo)); 


?>
<!DOCTYPE html>
<html lang="pt_BR">
    <head>
        <meta charset="UTF-8">
        <title>File Manager - By Max Machado</title>
            <link rel="stylesheet" href="assets/js/codemirror/codemirror.css">
            <link rel="stylesheet" href="assets/js/codemirror/addon/hint/show-hint.css">
            <script src="assets/js/codemirror/codemirror.js"></script>
            <script src="assets/js/codemirror/addon/hint/show-hint.js"></script>
            <script src="assets/js/codemirror/addon/hint/xml-hint.js"></script>
            <script src="assets/js/codemirror/addon/hint/javascript-hint.js"></script>
            <script src="assets/js/codemirror/addon/hint/anyword-hint.js"></script>
            <script src="assets/js/codemirror/addon/hint/sql-hint.js"></script>
            <script src="assets/js/codemirror/addon/hint/css-hint.js"></script>
            <script src="assets/js/codemirror/addon/hint/html-hint.js"></script>
            <script src="assets/js/codemirror/mode/php/php.js"></script>
            <script src="assets/js/codemirror/addon/edit/matchbrackets.js"></script>
            <script src="assets/js/codemirror/mode/htmlmixed/htmlmixed.js"></script>
            <script src="assets/js/codemirror/mode/xml/xml.js"></script>
            <script src="assets/js/codemirror/mode/javascript/javascript.js"></script>
            <script src="assets/js/codemirror/mode/css/css.js"></script>
            <script src="assets/js/codemirror/mode/clike/clike.js"></script>
            
            <script src="assets/js/codemirror/addon/selection/active-line.js"></script>
            
            
            <!-- Themes -->
            <link rel="stylesheet" href="assets/js/codemirror/lib/codemirror.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/3024-day.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/3024-night.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/abcdef.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/ambiance.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/ayu-dark.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/ayu-mirage.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/base16-dark.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/bespin.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/base16-light.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/blackboard.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/cobalt.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/colorforth.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/dracula.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/duotone-dark.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/duotone-light.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/eclipse.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/elegant.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/erlang-dark.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/gruvbox-dark.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/hopscotch.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/icecoder.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/isotope.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/lesser-dark.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/liquibyte.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/lucario.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/material.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/material-darker.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/material-palenight.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/material-ocean.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/mbo.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/mdn-like.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/midnight.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/monokai.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/moxer.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/neat.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/neo.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/night.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/nord.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/oceanic-next.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/panda-syntax.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/paraiso-dark.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/paraiso-light.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/pastel-on-dark.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/railscasts.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/rubyblue.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/seti.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/shadowfox.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/solarized.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/the-matrix.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/tomorrow-night-bright.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/tomorrow-night-eighties.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/ttcn.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/twilight.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/vibrant-ink.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/xq-dark.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/xq-light.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/yeti.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/idea.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/darcula.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/yonce.css">
            <link rel="stylesheet" href="assets/js/codemirror/theme/zenburn.css">
            
            
            
            <!-- Bootstrap and Fontawesom-->
            <link rel="stylesheet" type="text/css" href="assets/stylesheets/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="assets/stylesheets/fontawesome.css">
            <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    
    
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>-->
    
    </head>
    <body>
        <div class="bg-dark" style="position: absolute; width: 100%;">
             <form action="code_editor.php?folder=<?= $folder; ?>&file=<?=$act2['file'] ?>" method="post">
            <div class="col-12">                
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <a class="navbar-brand" href="#">Code Editor</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="nav nav-pills mr-auto">
                            <li class="nav-item">
                                <span class="nav-link active"><i class="fa fa-home" aria-hidden="true"></i>/<?php echo $folder . '/' . $act2['file'] ;?></span></a>
                            </li>

                        </ul>
			<?php if(isset($msg)): echo "<div class=\"nav-pills\"><span class=\"btn btn-success\">$msg</span></div>"; endif; ?>
                        <button type="submit" name="save" class="btn badge-secondary" style="margin: 4px 10px;">Salvar</button>
                        <span class="navbar-text">
                            <p>Themes: <select onchange="selectTheme()" id=select>
                                <option selected>default</option>
                                <option>3024-day</option>
                                <option>3024-night</option>
                                <option>abcdef</option>
                                <option>ambiance</option>
                                <option>ayu-dark</option>
                                <option>ayu-mirage</option>
                                <option>base16-dark</option>
                                <option>base16-light</option>
                                <option>bespin</option>
                                <option>blackboard</option>
                                <option>cobalt</option>
                                <option>colorforth</option>
                                <option>darcula</option>
                                <option>dracula</option>
                                <option>duotone-dark</option>
                                <option>duotone-light</option>
                                <option>eclipse</option>
                                <option>elegant</option>
                                <option>erlang-dark</option>
                                <option>gruvbox-dark</option>
                                <option>hopscotch</option>
                                <option>icecoder</option>
                                <option>idea</option>
                                <option>isotope</option>
                                <option>lesser-dark</option>
                                <option>liquibyte</option>
                                <option>lucario</option>
                                <option>material</option>
                                <option>material-darker</option>
                                <option>material-palenight</option>
                                <option>material-ocean</option>
                                <option>mbo</option>
                                <option>mdn-like</option>
                                <option>midnight</option>
                                <option>monokai</option>
                                <option>moxer</option>
                                <option>neat</option>
                                <option>neo</option>
                                <option>night</option>
                                <option>nord</option>
                                <option>oceanic-next</option>
                                <option>panda-syntax</option>
                                <option>paraiso-dark</option>
                                <option>paraiso-light</option>
                                <option>pastel-on-dark</option>
                                <option>railscasts</option>
                                <option>rubyblue</option>
                                <option>seti</option>
                                <option>shadowfox</option>
                                <option>solarized dark</option>
                                <option>solarized light</option>
                                <option>the-matrix</option>
                                <option>tomorrow-night-bright</option>
                                <option>tomorrow-night-eighties</option>
                                <option>ttcn</option>
                                <option>twilight</option>
                                <option>vibrant-ink</option>
                                <option>xq-dark</option>
                                <option>xq-light</option>
                                <option>yeti</option>
                                <option>yonce</option>
                                <option>zenburn</option>
                            </select>
                            </p>
                        </span>
                    </div>
                </nav>
            </div>
            <div class="bg-dark">           
                <textarea id="code" name="editfile"><?= trim($myfile); ?></textarea>            
            </div>
            </form>
        </div>
        <script>
            height = document.documentElement.clientHeight - 80;
            var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
            lineNumbers: true,
            matchBrackets: true,
            mode: "application/x-httpd-php",
            extraKeys: {"Ctrl-Space": "autocomplete"},
            indentUnit: 4,
            indentWithTabs: true
            });
            editor.setSize('100%', height);
            var input = document.getElementById("select");
            function selectTheme() {
              var theme = input.options[input.selectedIndex].textContent;
              editor.setOption("theme", theme);
              location.hash = "#" + theme;
            }
	    document.onload = selectTheme();
            var choice = (location.hash && location.hash.slice(1)) ||
                         (document.location.search &&
                          decodeURIComponent(document.location.search.slice(1)));
            if (choice) {
              input.value = choice;
              editor.setOption("theme", choice);
            }
            CodeMirror.on(window, "hashchange", function() {
              var theme = location.hash.slice(1);
              if (theme) { input.value = theme; selectTheme(); }
            });
        </script>
    </body>
</html>
<?php
exec("echo \"$ApachePass\" | sudo -S chmod 0711 {$_SESSION['document_root']}/web");
else:
    header("location: index.php");
endif;
?>