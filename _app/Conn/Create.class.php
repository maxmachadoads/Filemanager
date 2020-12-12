<?php
class Create extends Conn {
    private $Tabela;
    private $Dados;
    private $Result;
    
    /** @Var PDOStatement */
    private $Create;
    
    /** @Var PDO */
    private $Conn;
    
    public function ExeCreate($Tabela, array $Dados)
    {
        $this->Tabela = (string) $Tabela;
        $this->Dados = $Dados;
        
        $this->getSyntax();
        $this->Execute();
    }
    
    public function getResult()
    {
        return $this->Result;
    }


    /**
     * ****************************************
     * *********** Pivate Methodos ************
     * ****************************************
     */
    
    private function Connect()
    {
        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($this->Create);
    }
    
    private function getSyntax() 
    {
        $Fields = implode(', ', array_keys($this->Dados));
        $Places = ':' . implode(', :', array_keys($this->Dados));
        $this->Create = "INSERT INTO {$this->Tabela} ({$Fields}) VALUES ({$Places})";
    }
    
    private function Execute()
    {
        $this->Connect();
        try
        {
            $this->Create->execute($this->Dados);
            $this->Result = $this->Conn->lastInsertId();
        } 
        catch (PDOException $e) 
        {
            $this->Result = null;
            UIErro("<br>Erro ao cadastrar:</b> {$e->getMessage()}", $e->getCode());

        }
    }
}
