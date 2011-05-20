<?php
require('SAM/php_sam.php');
error_reporting(0); 
include('mqttConnect.php');

require_once( 'pachube/pachube_functions.php' );

$api_key = "c1fc3113723e91e3b172355f4c7799fd4bb0e7eedef39968da009b16c0dbfa7f";

$pachube = new Pachube($api_key);

$url = "http://www.pachube.com/api/4217.csv";


   
  $subName = $conn->subscribe('topic://roomTemp');
  
 // $dbc=sqlite_open('logger') OR die();
$counter = 0;
  while($conn)
      {

        $msg = $conn->receive($subName,array(SAM_WAIT=>100));

      

      if ($msg->body=="")
      {
      //echo "no data";
      }
      else
      {
      $counter++;
      echo "\n".$msg->body."\n";
	if($counter==10)
	{
	      echo "saved\n";
	//	    sqlite_query($dbc, "INSERT INTO temp_rec (date, time,temp) VALUES (DATE('NOW'),TIME('NOW'),".floatval($msg->body).")");
	$data=floatval($msg->body);
	$update_status = $pachube->updatePachube ( $url, $data );
	echo $update_status;
	$counter=0;
	}
	    
      }
sleep(1);
  }
$conn->Disconnect();
?>
