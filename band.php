<?php
/*
 * A script which gets the current bandwidth use from a bt 2wire homehub and 
 * sends it to the mqtt topic bandUp and bandDown
 * 
 * 
 * @author Oliver Smith 2009
 * @copyright Oliver Smith 2009
 */

require('SAM-1.1.0/php_sam.php');
error_reporting(0);
echo '1';


$conn = new SAMConnection();

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "http://10.1.1.100/base/web/speedmeter/speedmeter_data");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$ih = 1;

$conn->connect(SAM_MQTT, array(SAM_HOST => 'http://182.92.192.146/',
    SAM_PORT => 1883));

while ($conn)
{
    $result = curl_exec($curl);

    $cleanResult = preg_replace('/.+\?>/', "", $result);
    trim($cleanResult);
    $cleanedResult = '<?xml version="1.0"?><root>' . $cleanResult . "</root>";

    $oXML = simplexml_load_string($cleanedResult);

    if (strlen($oXML->tw_bb_in_speed) < 2)
    {
        $oXML->tw_bb_in_speed = "000" . $oXML->tw_bb_in_speed;
    }
    else if (strlen($oXML->tw_bb_in_speed) < 3)
    {
        $oXML->tw_bb_in_speed = "00" . $oXML->tw_bb_in_speed;
    }
    else if (strlen($oXML->tw_bb_in_speed) < 4)
    {
        $oXML->tw_bb_in_speed = "0" . $oXML->tw_bb_in_speed;
    }

    if (strlen($oXML->tw_bb_out_speed) < 2)
    {
        $oXML->tw_bb_out_speed = "000" . $oXML->tw_bb_out_speed;
    }
    else if (strlen($oXML->tw_bb_out_speed) < 3)
    {
        $oXML->tw_bb_out_speed = "00" . $oXML->tw_bb_out_speed;
    }
    else if (strlen($oXML->tw_bb_out_speed) < 4)
    {
        $oXML->tw_bb_out_speed = "0" . $oXML->tw_bb_out_speed;
    }

    echo "Download Speed = " . $oXML->tw_bb_in_speed . " ";
    echo "Upload Speed = " . $oXML->tw_bb_out_speed;
    echo "\n";


    $output = $oXML->tw_bb_in_speed;
    $output1 = $oXML->tw_bb_out_speed;



    $msgUp = new SAMMessage("$output1");

    //var_dump($msgUp);

    $msgDown = new SAMMessage("$output");

    $conn->send('topic://bandUp', $msgUp);

    $conn->send('topic://bandDown', $msgDown);

    echo "sent";
    sleep(30);
}
?>
