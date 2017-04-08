<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
	$root = "../itemphotos/";

	$absroot = "itemphotos/";

	if (isset($_REQUEST["postid"]))
	{
		$postid = $_REQUEST["postid"];

		$dir = $root . $postid;
		$dir_contents = scandir($dir);
		$array = array();

		//$realpath = realpath($dir);

		foreach ($dir_contents as $file)
		{
			$fileinfo = pathinfo($file);
			if($fileinfo['extension'] === 'jpg')
			{
				$array[] = $absroot . $postid . '/' . $file;
			}
		}

		echo json_encode($array, 64);
		//echo $array;
	}
	else
	{
		echo "{error : no post id}";
	}
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	if (isset($_POST["postid"]))
	{
		$postid = $_REQUEST["postid"];
		postImages($postid, $_POST["new"]);
	}
	else
	{
		echo "{error : no post id}";
	}
}

function postImages($postid, $new)
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

	if($_FILES['photo']['name'])
	{
		if(!$_FILES['photo']['error'])
		{
			$newname = tempnam($dir, "photo_");
			unlink($newname);
			$newname = $newname. ".jpg";
			move_uploaded_file($_FILES['photo']['tmp_name'], $newname);
		}
	}
	echo '<script> window.location.href="../listing.php?id=' . $postid . '"; </script>';
}


function console_log( $data ){
	echo '<script>';
	echo 'console.log('. json_encode( $data ) .')';
	echo '</script>';
}

?>
