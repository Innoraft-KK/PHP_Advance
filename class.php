<?php
require 'vendor/autoload.php'; 
use GuzzleHttp\Client;

/**
*Service Class
*This class represents a Service that fetches data from an API endpoint using Guzzle HTTP client library.
*/
class Service {

/**
*@var int $numb - a number property of the Service object.
*/

public $numb;    

/**
* Service constructor.
*@param int $x - a number parameter to set the $numb property of the Service object.
*/

 function __construct($x){
    $this->numb=$x; 
}

/**
    *api_data Method
    *This method fetches data from an API endpoint using Guzzle HTTP client library.
    *@param string $url - a string parameter representing the URL of the API endpoint.
    *@return array - an associative array representing the data fetched from the API endpoint.
*/

function api_data($url)
{
    $client = new Client();
    $response = $client->request('GET', $url);
    $data = json_decode($response->getBody(), true);
    return $data;
}

/**
*displayTitle Method
*This method fetches the title of a Service object from an API endpoint using the api_data method.
*@param int $x - an integer parameter representing the index of the Service object in the data fetched from the API endpoint.
*@return string - a string representing the title of the Service object.
*/

function displayTitle($x){
    $data=$this->api_data('https://ir-dev-d9.innoraft-sites.com/jsonapi/node/services');
    $ser_title=$data['data'][$x]['attributes']['title'];
    /* echo $ser_title; */
    return $ser_title;
}

/**
    *main_Img Method
    *This method fetches the main image URL of a Service object from an API endpoint using the api_data method.
    *@param int $x - an integer parameter representing the index of the Service object in the data fetched from the API endpoint.
    *@return string - a string representing the URL of the main image of the Service object.
*/

function main_Img($x){
    $data=$this->api_data('https://ir-dev-d9.innoraft-sites.com/jsonapi/node/services');
    $img=$data['data'][$x]['relationships']['field_image']['links']['related']['href'];
    $imgLink =$this->api_data($img);
    
    $img_arr = $imgLink['data']['attributes']['uri']['url'];
    return $img_arr;
}

/**
* content Method
* This method fetches the content of a Service object from an API endpoint using the api_data method.
* @param int $x - an integer parameter representing the index of the Service object in the data fetched from the API endpoint.
* @return string - a string representing the content of the Service object.
*/

function content($x){
    $data=$this->api_data('https://ir-dev-d9.innoraft-sites.com/jsonapi/node/services');
    $sublist=$data['data'][$x]['attributes']['field_services']['processed'];
    return $sublist;
}

/**
*displayIcons Method
*This method fetches the URLs of the icons of a Service object from an API endpoint using the api_data method, and returns them as HTML elements.
*@param int $x - an integer parameter representing the index of the Service object in the data fetched from the API endpoint.
*@return string - a string representing the HTML elements of the icons of the Service object.
*/

function displayIcons($x){
    $data=$this->api_data('https://ir-dev-d9.innoraft-sites.com/jsonapi/node/services');
    $iconuri = $data['data'][$x]['relationships']['field_service_icon']['links']['related']['href'];
    $iconLink = $this->api_data($iconuri);
    $icons=[];
    for($y=0; $y<count($iconLink['data']); $y++) {
        $thumbnailuri = $iconLink['data'][$y]['relationships']['thumbnail']['links']['related']['href'];
        $data4 = $this->api_data($thumbnailuri);
        $icons[] = $data4['data']['attributes']['uri']['url'];
    }

    $str='';
    foreach($icons as $icon){
        $str.="<div class='icon-img'><img src='https://ir-dev-d9.innoraft-sites.com.$icon'></div>";
    }
    return $str;
}

/**
*Display the right side information for a service.
*@param $x int The ID of the service to display.
*@return void
*/

function rightInfo($x){
    $title=$this->displayTitle($x);
    $img_src='https://ir-dev-d9.innoraft-sites.com'.$this->main_Img($x);
    $content=$this->content($x);
    $iconList=$this->displayIcons($x);
    //echo "<h3>$title</h3>";
    echo "
        <div class='service'>
         <h3>$title</h3>
                <div class='service-div'>
                    <div class='main-img'>
                    <img src=$img_src>
                    </div>
                    <div>";
                echo $content;
                echo "<div class='icon-div'>";
                echo $iconList;
                echo "</div></div></div>";

}

/**
*Display the left side information for a service.
*@param $x int The ID of the service to display.
*@return void
*/
function leftInfo($x){
    $title=$this->displayTitle($x);
    $img_src='https://ir-dev-d9.innoraft-sites.com'.$this->main_Img($x);
    $content=$this->content($x);
    $iconList=$this->displayIcons($x);
   
    echo "
        <div class='service'>
         <h3>$title</h3>
                <div class='service-div'>";
           
        echo"<div>
                 $content
                <div class='icon-div'>
                $iconList
                </div>
                </div>";
            echo "<div class='main-img'>
                    <img src=$img_src>
                </div> 
                </div>";
    }
}
?>