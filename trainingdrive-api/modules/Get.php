<?php
include_once "Common.php";

class Get extends Common{

    protected $pdo;

    public function __construct(\PDO $pdo){
        $this->pdo = $pdo;
    }
    
    public function getLogs($date){
        $filename = "./logs/" . $date . ".log";
        
        // $file = file_get_contents("./logs/$filename");
        // $logs = explode(PHP_EOL, $file);

        
        $logs = array();
        try{
            $file = new SplFileObject($filename);
            while(!$file->eof()){
                array_push($logs, $file->fgets());
            }
            $remarks = "success";
            $message = "Successfully retrieved logs.";
        }
        catch(Exception $e){
            $remarks = "failed";
            $message = $e->getMessage();
        }
        

        return $this->generateResponse(array("logs"=>$logs), $remarks, $message, 200);
    }


    public function getUser($id){
        
        $condition = "isdeleted = 0";
        if($id != null){
            $condition .= " AND user_id=" . $id; 
        }

        $result = $this->getDataByTable('user_tbl', $condition, $this->pdo);
        if($result['code'] == 200){
            return $this->generateResponse($result['data'], "success", "Successfully retrieved records.", $result['code']);
        }
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }
    
    public function getAccount($id){
        $condition = "isdeleted = 0";
        if($id != null){
            $condition .= " AND id=" . $id; 
        }

        $result = $this->getDataByTable('accounts_tbl', $condition, $this->pdo);

        if($result['code'] == 200){
            return $this->generateResponse($result['data'], "success", "Successfully retrieved records.", $result['code']);
        }
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }

    public function getPayments($userId = null){
        $condition = "";
        if ($userId) {
            $condition = "WHERE p.user_id = " . intval($userId);
        }
    
        $sql = "SELECT p.id, u.fname, u.lname, pk.package_name, p.payment_amount, p.payment_date
                FROM payment_tbl p
                JOIN user_tbl u ON p.user_id = u.id
                JOIN package_tbl pk ON p.package_id = pk.id
                $condition";
    
        $result = $this->getDataBySQL($sql, $this->pdo);
    
        if ($result['code'] == 200) {
            return $this->generateResponse($result['data'], "success", "Successfully retrieved payment history.", $result['code']);
        }
        return $this->generateResponse(null, "failed", $result['errmsg'], $result['code']);
    }
    
    
    
}
?>
