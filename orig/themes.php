<?php
require_once("mysql.php");

// build themes list
$sql = "SELECT * FROM $tableObj o, $tableChap c WHERE o.chapterNum = c.chapterNum ORDER BY o.chapterNum, o.objectiveNum";
$result = mysql_query($sql, $mysql);
$chapter = 0;
$list = "<ul>";
while($r = mysql_fetch_assoc($result)) {
	if($chapter != $r['chapterNum']) {
		$list .= "</ul><h2>$r[chapName]</h2><ul>";
		$listOpen = 1;
	}
	$chapter = $r['chapterNum'];

	if(!empty($r['trackerTheme'])) {
		$theme = $r['trackerTheme'];
	} else {
		$theme = $r['objectiveDescription'];
	}
	$list .= "<li><a href='index.php?showChap=$r[chapterNum]&showObj=$r[objectiveNum]'>$theme</a></li>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Bike 2015 Plan Tracker - Themes</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<?php require_once("analytics.php"); ?>
</head>
<body>
<div id="logo">
<a href='index.php'><img src="images/logo.png" alt="bike 2015 plan tracker logo" /></a>
</div>
<h1>Themes</h1>
<?php
echo $list; 
?>
</body>
</html>