<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	if (isset($_REQUEST["postid"]))
	{
		$postid = $_REQUEST["postid"];
		postImages($postid, $_REQUEST["url"]);
	}
	else
	{
		echo "{error : no post id}";
	}
}

function postImages($postid, $url)
{
	$root = "../itemphotos/";
	$dir = $root . $postid;
	if($new)
	{
		if(file_exists($dir))
		{
			rmdir($dir);
		}
		mkdir($dir);
	}
	else
	{
		if(!file_exists($dir))
		{
			mkdir($dir);
		}
	}

	$newname = tempnam($dir, "photo_");
	unlink($newname);
	$newname = $newname. ".jpg";
	copy($url, $newname);
}


function console_log( $data ){
	echo '<script>';
	echo 'console.log('. json_encode( $data ) .')';
	echo '</script>';
}

?>
