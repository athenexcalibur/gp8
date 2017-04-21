<?php

// get a list of images for the postid paramater
if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
	$root = "../itemphotos/";

	$absroot = "itemphotos/";

	if (isset($_REQUEST["postid"]))
	{
		$postid = $_REQUEST["postid"];

		// the image folder for the post
		$dir = $root . $postid;
		$dir_contents = scandir($dir);
		$array = array();

		// check all the files in the post's image folder:
		foreach ($dir_contents as $file)
		{
			$fileinfo = pathinfo($file);
			// if the file is a jpg, add it to the list
			if($fileinfo['extension'] === 'jpg')
			{
				$array[] = $absroot . $postid . '/' . $file;
			}
		}

		echo json_encode($array, 64);
	}
	else
	{
		echo "{error : no post id}";
	}
}

// add new images to the postid parameter from $_FILES (uploaded files)
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
	//path to post's images
	$root = "../itemphotos/";
	$dir = $root . $postid;

	//if a new listing, create image folder - if the folder already exists then delete it to clear out the old images and recreate it
	if($new)
	{
		if(file_exists($dir))
		{
			rmdir($dir);
		}
		mkdir($dir);
	}
	// if not a new listing (adding more images to an existing listing), only create the folder if it doesnt exist
	else
	{
		if(!file_exists($dir))
		{
			mkdir($dir);
		}
	}

	// check photos are available
	if (isset($_FILES['photo']))
	{
			$filesuploaded = $_FILES['photo'];
			// iterate through all the files uploaded
			foreach($filesuploaded["tmp_name"] as $currentfile)
			{
				// make a new file with a random, unique name to store the image in
				$newname = tempnam($dir, "photo_");
				// delete the file if it already exists
				unlink($newname);
				$newname = $newname. ".jpg";
				// copy the image from the temporary file to the local file
				move_uploaded_file($currentfile, $newname);
			}
	}

	// after completed, redirect back
	echo '<script> window.location.href="../listing.php?id=' . $postid . '"; </script>';
}

?>
