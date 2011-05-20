<?php
require('SAM/php_sam.php');
error_reporting(0); 
include('mqttConnect.php');

$initSerial = "stty -F /dev/ttyUSB0 cs8 9600 ignbrk -brkint -icrnl -imaxbel -opost -onlcr -isig -icanon -iexten -echo -echoe -echok -echoctl -echoke noflsh -ixon -crtscts -clocal -hupcl";
$initre=shell_exec($initSerial);
//$conn->SetDebug(TRUE);

        while($conn)
        {
	    
            $cmd = "cat /dev/ttyUSB0|head -n 1";
            $temp=shell_exec($cmd);
            //echo $temp;
            //sleep(1);
            $temp=floatval($temp);

            $msgTemp = new SAMMessage("$temp");

            //var_dump($msgTemp);

            $conn->send('topic://roomTemp', $msgTemp, array(SAM_TIMETOLIVE=>1000));
	    
	    

            echo "sent";

            sleep(60);

        }

?>
