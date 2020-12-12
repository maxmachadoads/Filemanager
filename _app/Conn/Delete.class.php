<?php
class Delete extends Conn {
    private $Tabela;
    private $Termos;
    private $Places;
    private $Result;
    
    /** @Var PDOStatement */
    private $Delete;
    
    /** @Var PDO */
    private $Conn;
    
    public function ExeDelete($Tabela, $Termos, $ParseString)
    {
        $this->Tabela = (string) $Tabela;
        $this->Termos = (string) $Termos;
        parse_str($ParseString, $this->Places);
        $this->getSyntax();
        $this->Execute();
    }
    
    public function getResult()
    {
        return $this->Result;
    }
    
    public function getRowCount()
    {
        return $this->Delete->rowCount();
    }
    
    public function setPlaces($ParseStrings)
    {
        parse_str($ParseStrings, $this->Places);
        $this->getSyntax();
        $this->Execute();
    }


    /**
     * ****************************************
     * *********** Pivate Methodos ************
     * ****************************************
     */
    
    private function Connect()
    {
        $this->Conn = parent::getConn();
        $this->Delete = $this->Conn->prepare($this->Delete);
    }
    
    private function getSyntax() 
    {
        $this->Delete = "DELETE FROM {$this->Tabela} {$this->Termos}";
    }
    
    private function Execute()
    {
        $this->Connect();
        try
        {
            $this->Delete->execute($this->Places);
            $this->Result = true;
        } 
        catch (PDOException $e)
        {
            $this->Result = null;
            UIErro("<br>Erro ao deletar:</b> {$e->getMessage()}", $e->getCode());
        }
    }
}
