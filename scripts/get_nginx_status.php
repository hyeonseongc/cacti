#!/usr/bin/php
<?php
if ($argc<>3) {
	echo "Not enough parameters. Usage : $argv[0] [client|socket] hostname\n";
	exit(1);
}
$url="http://{$argv[2]}/nginx-status";

$contents = file_get_contents($url);

preg_match("/^Active connections:\s+(\d+)\s*/i", $contents, $a);
preg_match("/\s+(\d+)\s+(\d+)\s+(\d+)\s*/", $contents, $c);
preg_match("/Reading: (\d+) Writing: (\d+) Waiting: (\d+)\s*$/", $contents, $s);

switch($argv[1]) {
	case "client":
		print "nginx_active:{$a[1]} nginx_reading:{$s[1]} nginx_writing:{$s[2]} nginx_waiting:{$s[3]} ";
		break;
	case "socket":
		print "nginx_accepts:{$c[1]} nginx_handled:{$c[2]} nginx_requests:{$c[3]} ";
		break;
	default:
		print "error\n";
		exit(1);
}
?>
