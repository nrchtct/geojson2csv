<?php

include("convert.php");

if (@$_FILES["geojson"]):

	// get file and name
	$filecontent = file_get_contents($_FILES['geojson']['tmp_name']);
	$filename = $_FILES["geojson"]["name"];

	// parse json
	$json = json_decode($filecontent, true);

	// convert json to csv
	$csv = convert($json);

	// return csv to be downloaded
	header('Content-type: text/csv');
	header("Content-Disposition: attachment;filename=".$filename.".csv");
	
	echo $csv;

else:
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>GeoJSON2CSV</title>
</head>
<body>

<p>Convert GeoJSON to CSV</p>
	
<form enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST" accept-charset="utf-8">

<!-- <input type="hidden" name="MAX_FILE_SIZE" value="3000000" /> -->

<p><input name="geojson" type="file" /></p>

<p><input type="submit" value="Convert"></p>
</form>
	
</body>
</html>
<?php
endif;
?>