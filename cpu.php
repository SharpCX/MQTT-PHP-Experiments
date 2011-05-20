<?php

/*
 * A small script to get the cpu usage from a linux host and post it to an MQTT topic 
 */


require('SAM/php_sam.php');

include('mqttConnect.php');

while ($conn)
{

    $cmd = "cat /proc/loadavg";
    $rawCpu = shell_exec($cmd);
    $result = preg_match("/^\d+.\d+/", $rawCpu, $cpu);
    
    if ($result == 1)
    {
        // var_dump($cpu);
        $msgCpu = new SAMMessage("$cpu[0]");
        $conn->send('topic://cpu', $msgCpu, array(SAM_TIMETOLIVE => 100));
        echo "sent";
        sleep(60);
    }
}
?>
