<?php
require_once('lib/nusoap.php');

date_default_timezone_set ( 'America/New_York' );
ini_set ( 'display_errors', 1 );

ini_set ( 'log_errors', 1 );

ini_set ( 'error_log', dirname ( __FILE__ ) . 'error_log.txt' );

error_reporting ( E_ALL );
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
        
        //echo file_get_contents($wsdl);
        //echo '<br>';
        //die();

        $loginarray = array
            (
                'login' => $username,
                'password' => $password, 
                'uri'=>"http://autotask.net/ATWS/v1_5/",
                'location'=>"https://webservices3.autotask.net/atservices/1.5/atws.asmx"
            );
        
        $client = new nusoap_client($wsdl, $loginarray);
        
        $err = $client->getError();
        echo 'do we have errors?' . $err;
        if ($err) {
                echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
                echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
                exit();
        }

        echo '<br>';
        
        //$func = $client->__getFunctions();
        
        
        //print_r($func);
        
        echo '<br>';
        
        return $client;
}
    


function getTickets(){
     $username = 'gbaney@asmgi.com';
     $password = 'stephenchen2';
     $ticketno = 'T20130623.0113';
     $client = connectToAPI($username, $password);     
     
     
     $xml = array('sXml' => "<queryxml>" .
             "<entity>Ticket</entity>" .
             "<query>" .
             "<field>id</field>" .
             "<expression op='equals'><field>" .
             $ticketno .
            "</expression></field></query>" .
             "</queryxml>");
     
     print_r ($xml);
     
     /*
     $xml = array('sXml' => "<queryxml>" .
             "<entity>Ticket</entity>" .
             "<query>" .
             "<field>id</field>" .
            "</query>" .
             "</queryxml>");
     */
     //$xml = "<queryxml><entity>Ticket</entity><query><field>id</field></query></queryxml>";
     
     $result = $client->call('query', $xml);
     //$result = $client->query($xml);
     //$result = $client->__soapCall('query', $xml);
     
    if ($client->fault) {
            echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>'; print_r($result); echo '</pre>';
    } else {
            $err = $client->getError();
            if ($err) {
                    echo '<h2>Error</h2><pre>' . $err . '</pre>';
            } else {
                    echo '<h2>Result</h2><pre>'; print_r($result); echo '</pre>';
            }
    }
    echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
    echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
    echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
         //$ticketso = $result->queryResult->EntityResults->Entity;
     
     //$ticketcount = count($ticketso);
     //return $ticketcount;
}


?>
