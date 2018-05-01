<?php
// Routes

use Firebase\JWT\JWT;
use Tuupola\Base62;

$app->post("/token",  function ($request, $response, $args) use ($container){
    /* Here generate and return JWT to the client. */
    //$valid_scopes = ["read", "write", "delete"]

  	$requested_scopes = $request->getParsedBody() ?: [];

    $now = new DateTime();
    $future = new DateTime("+2 minutes");
    $server = $request->getServerParams();
    $jti = (new Base62)->encode(random_bytes(16));
    $payload = [
        "iat" => $now->getTimeStamp(),
        "exp" => $future->getTimeStamp(),
        "jti" => $jti,
        "sub" => $server["PHP_AUTH_USER"]
    ];
    $secret = "123456789helo_secret";
    $token = JWT::encode($payload, $secret, "HS256");
    $data["token"] = $token;
    $data["expires"] = $future->getTimeStamp();
    return $response->withStatus(201)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});

$app->get("/secure",  function ($request, $response, $args) {

    $data = ["status" => 1, 'msg' => "This route is secure!"];

    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});

$app->get("/not-secure",  function ($request, $response, $args) {

    $data = ["status" => 1, 'msg' => "No need of token to access me"];

    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});

$app->post("/formData",  function ($request, $response, $args) {
    $data = $request->getParsedBody();

    $result = ["status" => 1, 'msg' => $data];

    // Request with status response
    return $this->response->withJson($result, 200);
});


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

$app->post("/usr/login",function(Request $request,Response $response){
    if(isTheseParametersAvailable(array('email','password')))
    {
        $key=$request->getParsedBody();
        $email=$key['email'];
        $password=$key['password'];
        if(loginUser($email,$password))
        {
            $user=getUser($email);
            $data["error"]=false;
            $data["message"]="Login Success";
            $data["data"]=[
                "id"=>$user['id'],
                "full_name"=>$user['full_name'],
                "gender"=>$user['gender'],
                "dob"=>$user['dob'],
                "image_url"=>"http://".$_SERVER['HTTP_HOST']."/billionsmile".$user['image_url'],
                "email"=>$user['email'],
                "token"=>$user['token'],
            ];
        }
        else
        {
            $data["error"]=true;
            $data["message"]="Invalid username or password"; 
        }
        
        return $response->withJson($data,200);
    }
});

$app->get("/usr/list",function(Request $request,Response $response){
    echo "User List";
});

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