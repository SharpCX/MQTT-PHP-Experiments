# MQTT PHP Experiments

This repository contains a series of example scripts I have used in the past for
 monitoring various aspects of my computer use and environment and broadcast the
 details over MQTT to pachube. I no longer use them but have placed them to
 allow others to who are just starting out with the PHP MQTT API to get their foot
 in the door.

All scripts are designed to be run from the command line under linux.

## Warning

It should be noted that this is probably the most unreliable and unstable of the 
MQTT APIs available, much more reliable APIs can be found written in Python, Java,
 JS or C. Full details available here:

http://mqtt.org/wiki/

## Dependencies

All scripts are dependent on the PHP_SAM API maintained under a restrictive 
license by IBM.

The current web site is currently down but the library is still available:

http://pecl.php.net/package/sam 

Sometimes this install will fail, however it's not a problem as only the non 
compiled part is required for MQTT communication and can be extracted from the 
tar file.

## Scripts Included

### band.php

A script which gets the current bandwidth use from a BT 2wire homehub and 
 * sends it to the mqtt topic bandUp and bandDown.

The process of getting the data from the router was described more thoroughly here: 
http://chemicaloliver.net/hardware/internet-speed-monitoring-with-bt-2wire-homehub-1800hg/

### cpu.php

A small script to get the cpu usage from a linux host and post it to an MQTT topic.

### roomTemp.php

A script to get a temperature value from an attached arduino and post the value
 to the MQTT topic roomTemp. The arduino side of the system is simply a 1 wire 
temperature sensor which transmits the value over serial to the attached computer
 at regular intervals.

### recieve.php

This is an example of a script that receives MQTT messages on the topic roomTemp
 and posts them to pachube 