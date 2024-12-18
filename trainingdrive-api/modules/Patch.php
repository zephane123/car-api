<?php
class Patch{

    protected $pdo;

    public function __construct(\PDO $pdo){
        $this->pdo = $pdo;
    }


    public function patchUser($body, $id){
        $values = [];
        $errmsg = "";
        $code = 0;


        foreach($body as $value){
            array_push($values, $value);
        }

        array_push($values, $id);
        
        try{
            $sqlString = "UPDATE user_tbl SET fname=?, lname=?, email=?, no=?, package=? WHERE no = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute($values);
          
            $code = 200;
            $data = null;

            return array("data"=>$data, "code"=>$code);
        }
        catch(\PDOException $e){
            $errmsg = $e->getMessage();
            $code = 400;
        }

        
        return array("errmsg"=>$errmsg, "code"=>$code);

    }

    public function archiveUser($id){
        
        $errmsg = "";
        $code = 0;
        
        try{
            $sqlString = "UPDATE user_tbl SET isdeleted=1 WHERE user_id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute([$id]);

            $code = 200;
            $data = null;

            return array("data"=>$data, "code"=>$code);
        }
        catch(\PDOException $e){
            $errmsg = $e->getMessage();
            $code = 400;
        }

        
        return array("errmsg"=>$errmsg, "code"=>$code);

    }

    public function patchAccount($body, $id){
        $values = [];
        $errmsg = "";
        $code = 0;


        foreach($body as $value){
            array_push($values, $value);
        }

        array_push($values, $id);
        
        try{
            $sqlString = "UPDATE accounts_tbl SET username=?, password=?, isdeleted=? WHERE id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute($values);

            $code = 200;
            $data = null;

            return array("data"=>$data, "code"=>$code);
        }
        catch(\PDOException $e){
            $errmsg = $e->getMessage();
            $code = 400;
        }

        
        return array("errmsg"=>$errmsg, "code"=>$code);

    }

    public function archiveAccount($id){
        
        $errmsg = "";
        $code = 0;
        
        try{
            $sqlString = "UPDATE accounts_tbl SET isdeleted=1 WHERE id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute([$id]);

            $code = 200;
            $data = null;

            return array("data"=>$data, "code"=>$code);
        }
        catch(\PDOException $e){
            $errmsg = $e->getMessage();
            $code = 400;
        }

        
        return array("errmsg"=>$errmsg, "code"=>$code);

    }

    
}

?>
