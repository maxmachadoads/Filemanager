<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author Max
 */
class Login {
    private $UserName;
    private $Password;
    private $Error;
    private $Msg;
    private $Result;


    public function __construct(array $dados) {
        $this->UserName = $dados['username'];
        $this->Password = $dados['password'];
        
       
        $this->checkForm();
        $this->verificarDados();
    }
    
    //Retorna Situação
    public function getMsg() {
        if(isset($this->Error)):
            return $this->Error;
        else:
            return $this->Msg;
        endif;
    }
      
    //Verifica se os campos foram preenchidos
    private function checkForm() {
        if($this->UserName == '' || $this->UserName == null):
            $this->Error[] = ["Favor preencher o campo username!", UI_ALERT];
        endif;
        
        if($this->Password == '' || $this->Password == null):
            $this->Error[] = ["Favor preencher o campo password!", UI_ALERT];
        endif;

    }
    
    private function verificarDados() {
        $svrDados = new Read();
        //Pega a senha do banco de dados para usar como SALT na verificação
        $svrDados->FullRead('SELECT userid, username, default_group, passwort FROM sys_user WHERE username = :username', ['username' => $this->UserName]);
        if($svrDados->getRowCount() === 1):
            if(crypt($this->Password, $svrDados->getResult()[0]['passwort']) == $svrDados->getResult()[0]['passwort']):
                $this->Result['sys'] = $svrDados->getResult()[0];        
                $this->Msg[] = ["Login Efetuado com Sucesso!", UI_ACCEPT];
                $this->userDomains();
            else:
                $this->Error[] = ["Usuário ou senha incorreto!", UI_ALERT];
            endif;
        else:
            $this->Error[] = ["Usuário ou senha incorreto!", UI_ALERT];
        endif;
    }
    
    private function userDomains(){
        $read = new Read();
        $read->FullRead('SELECT sys_groupid, domain, document_root, web_domain.ssl FROM web_domain WHERE sys_groupid = :user', ['user' => $this->Result['sys']['default_group']]);
        if($read->getRowCount() > 0):
            $this->Result['domain'] = $read->getResult();
            $this->setSession();
	else:
            $this->Error[] = ["Usuário ainda não possui domínio!", UI_ALERT];
        endif;
    }
    
    private function setSession(){
        $_SESSION = $this->Result;
        echo "<script>setTimeout(window.location='". BASE ."filemanager/index.php', 4000)</script>";
    }

}
