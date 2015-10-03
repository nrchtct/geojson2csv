<?php

function convert($json) {

	$csv = "id,latitude,longitude,name";

	for ($i=0; $i < count($json["features"]); $i++) { 
		$f = $json["features"][$i];
	
		// get point locations
		if ($f["geometry"]["type"]=="Point") {
			$lat = $f["geometry"]["coordinates"][1];
			$lng = $f["geometry"]["coordinates"][0];
		}
		// average points of polygon (not very proper!)
		else if ($f["geometry"]["type"]=="Polygon") {
			// avg
			$lat = 0;
			$lng = 0;	
			for ($j=0; $j < count($f["geometry"]["coordinates"][0]); $j++) {
				$p = $f["geometry"]["coordinates"][0][$j];			
				$lat = $lat + $p[1];
				$lng = $lng + $p[0];
			}
			$lat = round($lat/count($f["geometry"]["coordinates"][0]), 7);
			$lng = round($lng/count($f["geometry"]["coordinates"][0]), 7);
		}
	
		// insert point/polygon average into csv
		if ( $f["geometry"]["type"]=="Point" || $f["geometry"]["type"]=="Polygon") {
			$id = $f["id"];		
			$name = str_replace(",", " ", @$f["properties"]["name"]);
			$name = preg_replace("/[^[:alnum:][:space:]]/u", '', $name);
			if ($name=="") $name = "n/a";			
			$csv = $csv . "\n" . $id . "," . $lat . "," . $lng . "," . $name;
		}
	}

	return $csv;
}

?>