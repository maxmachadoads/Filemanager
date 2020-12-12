<?php
if(!isset($_SESSION['sys']['userid'])):
    require_once './_app/Config.inc.php';
    $act2 = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    if(isset($act2['login'])):
        $login = new Login($act2);            
    endif;    
    
?>
<div class="container-fluid h-100" style="position: absolute; left: 0px;">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <div class="navbar navbar-brand">
                <?php
                if(isset($login) && $login->getMsg() != null):
                    foreach($login->getMsg() as $mensagem):
                        UIErro($mensagem[0], $mensagem[1]);
                    endforeach;
                endif;
                ?>
            <div>
            <div class="navbar navbar-expand-lg navbar-dark bg-dark rounded">
                <img src="assets/images/logo.png" style="max-height: 32px;">
                <span class="nav-link active navbar-brand">Ultratech Informática</span>
            </div>            
            <form action="index.php" method="post">
                <div class="form-group">
                    <input _ngcontent-c0="" class="form-control form-control-lg" name="username" placeholder="Username" type="text">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" name="password" placeholder="Password" type="password">
                </div>
                <div class="form-group">
                    <button class="btn btn-info btn-lg btn-block" name="login">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
else:
    header("location: index.php");
endif;