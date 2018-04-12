<?php
if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

use Slim\Http\Request;
use Slim\Http\Response;
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../DB/dbcon.php';
session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';



$app->post("/usr/create",function(Request $request,Response $response)
{
    // return $response->withJson(createUser("Name","male","1992","","kanta1311@gmail.com","12345"), 200);
    if(isTheseParametersAvailable(array('name','gender','dob','email','password')))
    {
        $key=$request->getParsedBody();
        $name=$key["name"];
        $gender=$key["gender"];
        $dob=$key["dob"];
        $email=$key["email"];
        $password=$key["password"];
        $imageb64=$key["imageb64"];
        $result=createUser($name,$gender,$dob,$imageb64,$email,$password);

        if($result==0)
        {
            $data=["error"=>false,"message"=>"You are successfully registered"];
            return $response->withJson($data,201);
        }
        else if($result==1)
        {
            $data=["error"=>true,"message"=>"Oops! An error occurred while registereing"];
            return $response->withJson($data,200);
        }
        else if($result==2)
        {
            $data=["error"=>true,"message"=>"Sorry, this User  already existed"];
            return $response->withJson($data,200);
        }

        // return $response->withJson($result);

        
    }

});
// Run app
$app->run();


function isTheseParametersAvailable($required_fields)
{
    $error = false;
    $error_fields = "";
    $request_params = $_REQUEST;

    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        $response = array();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echo json_encode($response);
        return false;
    }
    return true;
}