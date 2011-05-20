<?php
/*
 * A small script which recieved the data on the roomTemp topic and broadcasts 
 * it to pachube
 * 
 * @author Oliver Smith 2009
 */


require('SAM/php_sam.php');
error_reporting(0);
include('mqttConnect.php');

require_once( 'pachube/pachube_functions.php' );

$api_key = "<your pachube API key>";

$pachube = new Pachube($api_key);

$url = "<your pachube feed>";

$subName = $conn->subscribe('topic://roomTemp');

$counter = 0;
while ($conn)
{

    $msg = $conn->receive($subName, array(SAM_WAIT => 100));



    if ($msg->body == "")
    {
        //echo "no data";
    }
    else
    {
        $counter++;
        echo "\n" . $msg->body . "\n";
        if ($counter == 10)
        {
            echo "saved\n";

            $data = floatval($msg->body);
            $update_status = $pachube->updatePachube($url, $data);

            echo $update_status;
            $counter = 0;
        }
    }
    sleep(1);
}
$conn->Disconnect();
?>
