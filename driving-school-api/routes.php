<?php

//import get and files
require_once "./config/database.php";
require_once "./modules/Get.php";
require_once "./modules/Post.php";
require_once "./modules/Patch.php";
require_once "./modules/Archive.php"; 
require_once "./modules/Auth.php";
$db = new Connection();
$pdo = $db->connect();

//Class instantiation
$post = new Post($pdo);
$get = new Get($pdo);
$patch = new Patch($pdo);
$archive = new Archive($pdo);
$auth = new Authentication($pdo);

//retrieved and endpoints and split
if(isset($_REQUEST['request'])){
    $request = explode("/", $_REQUEST['request']);
}
else{
    echo "URL does not exist.";
}

//get post put patch delete etc
//Request method - http request methods you will be using

switch($_SERVER['REQUEST_METHOD']){

    case "GET":
        if ($auth->isAuthorized()) {
            switch ($request[0]) {
    
                //case "car":
                    //echo json_encode($get->getCar(), JSON_PRETTY_PRINT);
                  // break;

                   case "car":
                    echo json_encode($get->getCar($request[1] ?? null));
        
                    break;
        
                    case "log":
                        echo json_encode($get->getLogs($request[1] ?? date("Y-m-d")));
                    break;

                    default:
                        http_response_code(401);
                        echo "This is invalid endpoint";
                    break;
               
                }
            }
            else{
                    echo "unauthorized";
            }
    
        break;

        case "POST":
            $body = json_decode(file_get_contents("php://input"));
            if ($request[0] === "login" || $request[0] === "signup") {
                if ($request[0] === "login") {
                    echo json_encode($auth->login($body));
                } elseif ($request[0] === "signup") {
                    echo json_encode($auth->addAccount($body));
                }
            } else if ($auth->isAuthorized()) {
                switch ($request[0]) {
                    case "postthis":
                        echo json_encode($post->postCar($body));
                        break;
        
                    default:
                        http_response_code(401);
                        echo "This is an invalid endpoint";
                        break;
                }
            } else {
                echo "Unauthorized";
            }
            break;
    
        case "DELETE":
            if ($auth->isAuthorized()) {
                switch($request[0]){
                    case "car":
                        echo json_encode($archive->deleteCar($request[1]));
                        break;
                    case "destroycar":
                        echo json_encode($archive->destroyCar($request[1]));
                        break;
                    case "account":
                        echo json_encode($archive->deleteAccount($request[1]));
                        break;
                    case "destroyaccount":
                        echo json_encode($archive->destroyAccount($request[1]));
                        break;
                    default:
                        http_response_code(401);
                        echo "This is an invalid endpoint";
                        break;
                }
            } else {
                echo "Unauthorized";
            }
            break;
    
        case "PATCH":
            $body = json_decode(file_get_contents("php://input"));
            if ($auth->isAuthorized()) {
                switch($request[0]){
                    case "car":
                        echo json_encode($patch->patchCar($body, $request[1]));
                        break;
                      
    
                    default:
                        http_response_code(401);
                        echo "This is an invalid endpoint";
                        break;
                }
            } else {
                echo "Unauthorized";
            }
            break;
    
        default:
            http_response_code(400);
            echo "Invalid Request Method.";
            break;
    }
    
    ?>