<?php
class Archive{

    protected $pdo;

    public function __construct(\PDO $pdo){
        $this->pdo = $pdo;
    }




    public function deleteCar($id) {
        $errmsg = "";
        $code = 0;
    
        try {
            $sqlString = "UPDATE car_tbl SET isdeleted = 1 WHERE id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute([$id]);
    
            if ($sql->rowCount() > 0) {
                $code = 200; 
                $data = ["message" => "Enrollee marked as deleted successfully"];
            } else {
                $code = 404; 
                $data = ["error" => "Enrollee not found or already marked as deleted"];
            }
    
            return array("data" => $data, "code" => $code);
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 400; 
    
            return array("errmsg" => $errmsg, "code" => $code);
        }
    }
    public function destroyCar($id) {
        $errmsg = "";
        $code = 0;
    
        try {
            $sqlString = "DELETE FROM car_tbl WHERE id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute([$id]);
    
            if ($sql->rowCount() > 0) {
                $code = 200; 
                $data = ["message" => "Player deleted successfully"];
            } else {
                $code = 404; 
                $data = ["error" => "Player not found"];
            }
    
            return array("data" => $data, "code" => $code);
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 400; 
    
            return array("errmsg" => $errmsg, "code" => $code);
        }
    }
    public function deleteAccount($id) {
        $errmsg = "";
        $code = 0;
    
        try {
            $sqlString = "UPDATE accounts_tbl SET isdeleted = 1 WHERE id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute([$id]);
    
            if ($sql->rowCount() > 0) {
                $code = 200; 
                $data = ["message" => "Player marked as deleted successfully"];
            } else {
                $code = 404; 
                $data = ["error" => "Player not found or already marked as deleted"];
            }
    
            return array("data" => $data, "code" => $code);
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 400; 
    
            return array("errmsg" => $errmsg, "code" => $code);
        }
    }
    public function destroyAccount($id) {
        $errmsg = "";
        $code = 0;
    
        try {
            $sqlString = "DELETE FROM accounts_tbl WHERE id = ?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute([$id]);
    
            if ($sql->rowCount() > 0) {
                $code = 200; 
                $data = ["message" => "Player deleted successfully"];
            } else {
                $code = 404; 
                $data = ["error" => "Player not found"];
            }
    
            return array("data" => $data, "code" => $code);
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 400; 
    
            return array("errmsg" => $errmsg, "code" => $code);
        }
    }
}

?>
