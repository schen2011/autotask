<?php
//http://theninthnode.com/2010/11/autotask-getting-a-list-of-open-support-tickets-by-client-via-the-api/
//http://theninthnode.com/2010/11/connecting-to-autotask-with-php/
//$username = 'schenjobs@gmail.com';
//$password = 'password';    
//Get the ticket
echo 'Getting Started with trying to get the ticket';

$ticketno = getTickets();

echo 'how many tickets there' . $ticketno;

function connectToAPI($username, $password){
        echo '<br>connecting to API<br>';
        $wsdl = 'https://webservices3.autotask.net/atservices/1.5/atws.wsdl';
        
        echo file_get_contents($wsdl);
        die();

        $loginarray = array
            (
                'login' => $username,
                'password' => $password, 
                'uri'=>"http://autotask.net/ATWS/v1_5/",
                'location'=>"https://webservices3.autotask.net/atservices/1.5/atws.asmx"
            );
        $client = new SoapClient($wsdl, $loginarray);
        return $client;
}
    


function getTickets(){
     $username = 'gbaney@asmgi.com';
     $password = 'stephenchen1';
     $ticketno = 'T20130623.0113';
     $client = connectToAPI($username, $password);     
     $xml = array('sXml' => "<queryxml>" .
             "<entity>Ticket</entity>" .
             "<query>" .
             "<field>id</field>" .
             "<expression op='equals'>" .
             $ticketno .
            "</expression></field></query>" .
             "</queryxml>");
     
     $result = $client->query($xml);
     $ticketso = $result->queryResult->EntityResults->Entity;
     $ticketcount = count($ticketso);
     return $ticketcount;
}


?>
