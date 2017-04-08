<?php

//A list of stopwords - feel free to add any!!

$stopwords = array("a" => 1, "an" => 1, "the" => 1,
    "is" => 1, "am" => 1, "are" => 1, "was" => 1,
    "were" => 1, "this" => 1, "that" => 1, "these" => 1, "those" => 1,
    "food" => 1, "and" => 1, "my" => 1, "you" => 1, "but" => 1, "in" => 1, 
	"on" => 1, "at" => 1, "of" => 1, "to" => 1);


//filter stop words from a string - returns an array of filtered words
function filter_stops($words){
    global $stopwords;
    $f = array();
    $ch = 0;
    $wds = explode(" ",$words); //convert string to array
    foreach($wds as $wrd) {
	$wrd_lower = strtolower($wrd);
	if(!isset($stopwords[$wrd_lower])) {
		if(!in_array($wrd_lower,$f))
		{array_push($f, $wrd_lower);}
	}	    
    } 
    return($f);	
}

/**************************************************/
//extract keywords from post title and description - returns array of combined keywords from title and description

function getKeywords($title,$description){
	
	$key = array();
	$t = filter_stops($title);
	$d = filter_stops($description);
	foreach($t as $k){if(!in_array(strtolower($k),$key)){array_push($key,strtolower($k));}}
	foreach($d as $k){if(!in_array(strtolower($k),$key)){array_push($key,strtolower($k));}}
	return($key);
}	

/**************************************************/

$postkeys = getKeywords("Chicken Tikka","chicken chicken chicken"); //keywords for current post

//match keywords to past one month post keywords
function match($pastpost){
	$matches = array();
	global $postkeys;

	$pp = filter_stops($pastpost);

	foreach($postkeys as $k){
		$n = 0;
		foreach($pp as $p){
		  if(strcasecmp(strtolower($k),strtolower($p))==0)
			{$n = $n+1;}	
		}
		$m = array($k,$n); //each keyword and its associated no. of matches  
		array_push($matches,$m);		      
	}
	return $matches; //returns an array of matching keywords and no. of matches
}

//offer recommendations based on past postings
function recommend($pastpost){
	$recs = match($pastpost);
	print_r($recs);
	foreach ($recs as $m){
	  if($m[1]>=2){echo "You've had enough of ".$m[0]."!";}	
	}
}

recommend("Chicken");


?>
