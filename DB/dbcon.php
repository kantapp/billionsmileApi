<?php
    // error_reporting(0);
    date_default_timezone_set("Asia/kolkata");
    $servername="localhost";
    $username="root";
    $password="";
    $database="kantappc_billionsmile";

    $dbcon=new mysqli($servername,$username,$password,$database);
    if($dbcon->connect_error)
    {
        die("Failed To connect MySQL :".$dbcon->connect_error);
    }
    
    //Regeter New User
    function createUser($name,$gender,$dob,$imageb64,$email,$password)
    {
        global $dbcon;
        if(!isUserExist($email))
        {
            $pass=md5($password);
            $token=getApiKey();
            if($imageb64=="" && $gender=="male")
            {
                $imageUrl="/img/male.png";
            }
            else if($imageb64=="" && $gender=="female")
            {
                $imageUrl="/img/female.png";
            }
            else 
            {
                if(file_put_contents("../img/profile/$token.png",base64_decode($imageb64)))
                {

                    ;
                    

                    if(Thumbnail("../img/profile/$token.png","../img/profile/profile_$token.png"))
                    {
                        $imageUrl="/img/profile/profile_$token.png";
                    }  
                    else 
                    {
                        $imageUrl="/img/male.png";
                        unlink("../img/profile/$token.png");
                    } 
                    
                }
                
            }
            $stm=$dbcon->prepare("INSERT INTO `billionsmile_user` (`id`, `full_name`, `gender`, `dob`, `image_url`, `email`, `password`, `token`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");
            $stm->bind_param("sssssss",$name,$gender,$dob,$imageUrl,$email,$pass,$token);
            $result=$stm->execute();
            $stm->close();
            if($result)
            {
                return 0;
            }
            else {
                return 1;
            }
        }
        else {
            return 2;
        } 

        
    }

    function loginUser($email,$password)
    { 
        $pass=md5($password);
        global $dbcon;

        $stm=$dbcon->prepare("SELECT * FROM `billionsmile_user` WHERE email=? and password=?;");
        $stm->bind_param("ss",$email,$pass);
        $stm->execute();
        $stm->store_result();
        $num_rows=$stm->num_rows;
        $stm->close();
        return $num_rows>0;
    }

    function getUser($email)
    {
        global $dbcon;
        $stm=$dbcon->prepare("SELECT * FROM `billionsmile_user` WHERE email=?;");
        $stm->bind_param("s",$email);
        $stm->execute();
        $result=$stm->get_result()->fetch_assoc();
        $stm->close();
        return $result;
    }

    function isUserExist($email)
    {
        global $dbcon;
        $stm=$dbcon->prepare("SELECT * FROM `billionsmile_user` WHERE `email`= ?;");
        $stm->bind_param("s",$email);
        $stm->execute();
        $stm->store_result();
        $num_rows=$stm->num_rows;
        $stm->close();
        return $num_rows;
    }

    function isUserValid($token)
    {
        global $dbcon;
        $stm=$dbcon->prepare("SELECT `id`, `full_name`, `gender`, `dob`, `image_url`, `email`, `password`, `token` FROM `billionsmile_user` WHERE token=?;");
        $stm->bind_param("s",$token);
        $stm->execute();
        $result=$stm->get_result();
        $num_rows=$stm->num_rows;
        $stm->close();
        return $num_rows>0;

    }
    
    function getApiKey()
    {
        return md5(uniqid(rand(),true));
    }

    function isBase64($s)
    {
        return (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s);
    }

    

    function Thumbnail($url, $filename, $width = 150, $height = true) 
    {
        // download and create gd image
        $image = ImageCreateFromString(file_get_contents($url));
       
        if($image)
        {
            $height = $height === true ? (ImageSY($image) * $width / ImageSX($image)) : $height;
            $output = ImageCreateTrueColor($width, $height);
            ImageCopyResampled($output, $image, 0, 0, 0, 0, $width, $height, ImageSX($image), ImageSY($image));
            ImageJPEG($output, $filename, 90);
            return true;
        }
        else 
        {
            return false;
        }        
       
    }

    