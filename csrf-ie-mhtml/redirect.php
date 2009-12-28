<?php

$url = $_GET['url'];
$use_mhtml = $_GET['use_mhtml'];

if($use_mhtml) {
	$url = "mhtml:$url";
}

header("Location: $url");

