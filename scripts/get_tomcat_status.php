#!/usr/bin/php
<?php
if ($argc<>6) {
	echo "Not enough parameters. Usage : get_tomcat_status.php <user> <password> <server> <port> <connector name to check>\n";
	exit(1);
}
$user=$argv[1];
$passwd=$argv[2];
$server=$argv[3];
$port=$argv[4];
$connector_to_check=$argv[5];

error_reporting(0);

$url="http://$user:$passwd@$server:$port/manager/status?XML=true";
$contents = file_get_contents($url);

$doc=new DomDocument();
$doc->loadXML($contents);

$ret='';

$nodes=$doc->getElementsByTagName("memory");
foreach ($nodes as $memory) {
	if ($memory->hasAttributes()) { 
        foreach ($memory->attributes as $attr) { 
			$ret .= $attr->nodeName.":".$attr->nodeValue." ";
        } 
    } 
}

$nodes=$doc->getElementsByTagName("connector");

$i=0;
foreach($nodes as $node) {
	if(str_replace('"', '', $nodes->item($i)->getAttribute('name')) == $connector_to_check) {
		// thread info
		$th = $nodes->item($i)->getElementsByTagName('threadInfo');
		foreach ($th as $threadInfo) {
			if ($threadInfo->hasAttributes()) { 
				foreach ($threadInfo->attributes as $attr)  
					$ret .= $attr->nodeName.":".$attr->nodeValue." ";
				}
			}
		}

		// request info
		$req = $nodes->item($i)->getElementsByTagName('requestInfo');
		foreach ($req as $requestInfo) {
			if ($requestInfo->hasAttributes()) { 
				foreach ($requestInfo->attributes as $attr) {
					$ret .= $attr->nodeName.":".$attr->nodeValue." ";
				}
			}
		}
	}
$i++;
}
echo $ret;
?>
