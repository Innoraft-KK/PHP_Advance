<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <h2>Services We Offer</h2>
    <?php
    
    require 'vendor/autoload.php'; 
    use GuzzleHttp\Client;
   
    $client = new Client();
    $response = $client->request('GET', 'https://ir-dev-d9.innoraft-sites.com/jsonapi/node/services');
    $data = json_decode($response->getBody(), true);

    include 'class.php';
    for($x=12;$x<count($data['data']);$x++){
        
        $obj= new Service($x);
       
        if($x%2==0){
            $obj->rightInfo($x);
        }
        else{
            $obj->leftInfo($x);
        } 
    }
    ?>    
</body>
</html>
