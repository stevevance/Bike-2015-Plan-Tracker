<?php
require_once("mysql.php");

// completion statuses
$status = array(0=>array("Unbegun","red_circle","has yet to begin"),
1=>array("Completed","green_circle","is completed"),
2=>array("Completed after the deadline","green_circle","is completed but after the deadline"),
3=>array("In Progress","yellow_circle","is in progress"),
4=>array("Unknown Status","question_circle","has an unknown status")
);

// filter the query by chapter, or chapter and objective
$showChap = $_GET['showChap'];
$showObj = $_GET['showObj'];
if($showChap > 0 && $showChap < 9) {
	if(!empty($showObj) && is_numeric($showObj)) {
		$whereStatement = "chapter = $showChap AND objective = $showObj";
		$strategyTableTitle = "<h2>List of strategies in Chapter $showChap: $chapDir[$showChap], Objective $showObj</h2>";
		$theme = returnTheme($showChap,$showObj);
		$strategyTableTitle .= "<h3>Theme: $theme</h3>";
		$strategyTableTitle .= "<p><a href='index.php?showChap=$showChap'>Show all strategies in all Chapter $showChap objectives</a> - <a href='index.php'>Show all chapters</a>";
	} else {
		$whereStatement = "chapter = $showChap";
		$strategyTableTitle = "<h2>List of strategies in Chapter $showChap: $chapDir[$showChap]</h2>"; 
		$strategyTableTitle .= "<p><a href='index.php'>Show all strategies in all chapters</a>";
	}
} else {
	$whereStatement = "1=1";
	$addP = 1;
	$strategyTableTitle = "<h2>List of strategies in all chapters</h2>";
}

// filter the query by status
$statusFilter = $_GET['status'];
if(is_numeric($statusFilter) && $statusFilter < 5) {
	if($statusFilter == 1) {
		$whereStatement = "(status = 1 OR status = 2)";
	} else {
		$whereStatement = "status = $statusFilter";
	}
	$strategyTableTitle = "<h2>List of ".$status[$statusFilter][0]." strategies in all chapters</h2>";
	$strategyTableTitle .= "<p><a href='index.php'>Show all statuses</a>";
}

// QUERY select all strategies - use $whereStatement to filter the query
$sql = "SELECT * FROM $tableBp WHERE $whereStatement ORDER BY chapter, objective, strategy";
$result = mysql_query($sql, $mysql);
$recordsReturned = mysql_num_rows($result);
if($addP == 0) {
	$strategyTableTitle .= " - ";
} else {
	$strategyTableTitle .= "<p>";
}
$strategyTableTitle .= "Your search returned $recordsReturned strategies</p>";

// build the strategies table
$incTable = "<table id='strategiesTable'>";
$incTable .= "<thead><tr><th>Number</th><th>Status</th><th>Strategy</th><th>Deadlines</th><th>Performance Measures</th><th>Tracker Notes</th></tr></thead><tbody>";
while($r = mysql_fetch_assoc($result)) {
	$imageCode = "<a href='index.php?status=$r[status]'><img src='images/".$status[$r['status']][1].".png' alt='image of colored circle' title='This strategy ".$status[$r['status']][2].". Click to search for all strategies with the same status.'></a>";
	$incTable .= "<tr><td><a href='details.php?id=$r[id]'><b>$r[chapter].$r[objective].$r[strategy]</b></a></td>";
	$incTable .= "<td>".$imageCode." <span class='hidden'>".$status[$r['status']][0]."</span></td><td>$r[strategyTitle]</td><td>";
	if($r['deadline1'] > 0 || $r['deadline2'] > 0) {
		if($r['deadline1'] > 0) {
			$incTable .= "$r[deadline1]";
		} 
		if($r['deadline2'] > 0) {
			$incTable .= ", $r[deadline2]";
		}
	}
	$incTable .= "</td><td>$r[perfMeas]</td><td>$r[note]</td></tr>";
}
$incTable .= "</tbody></table>";
//

// count how many are completed, incomplete, and completed or partially completed
$sql = "SELECT status, COUNT(status) count FROM $tableBp GROUP BY status";
$result = mysql_query($sql, $mysql);
$totals = array();
while ($r = mysql_fetch_assoc($result)) {
    $totals[] = $r['count'];
}
$total_incomplete = $totals[0];
$total_completed = $totals[1];
$total_completedAfterDeadline = $totals[2];
$total_partiallyCompleted = $totals[3];
$total_unknownStatus = $totals[4];
$total_nonIncomplete = $total_completed+$total_completedAfterDeadline+$total_partiallyCompleted;
$total = $total_nonIncomplete+$total_incomplete+$total_unknownStatus;

// make a themes list
$sql = "SELECT * FROM $tableObj ORDER BY RAND() LIMIT 5";
$result = mysql_query($sql, $mysql);
$themeList = "<ul>";
$themeList .= "<li><a href='themes.php'>See all themes</a></li>";
while ($r = mysql_fetch_assoc($result)) {
	if(!empty($r['trackerTheme'])) {
		$theme = $r['trackerTheme'];
	} else {
		$theme = $r['objectiveDescription'];
	}
	$themeList .= "<li><a href='index.php?showChap=$r[chapterNum]&showObj=$r[objectiveNum]'>$theme</a></li>";
}
$themeList .= "</ul>";
//
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Bike 2015 Plan Tracker</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery/jquery.js"></script>
<script type="text/javascript" src="datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#strategiesTable').dataTable();
			} );
		</script>
<?php require_once("analytics.php"); ?>
<style type="text/css">
@import url("datatables/media/css/demo_page.css");
@import url("datatables/media/css/demo_table.css");
</style>
</head>

<body>
<?php require_once("header.php"); ?>

<div id="introductionBox">
<p>Check the status of the <?php echo $total; ?> strategies in Chicago's <a href='http://bike2015plan.org' target="_blank">Bike 2015 Plan</a>, which was approved by City Council in 2005. This is a product of <a href="http://gridchicago.com/2012/introducing-the-bike-2015-plan-tracker/" target="_blank">Grid Chicago</a>. Please submit corrections, updates, or insights in the comments.</p>
<p>A strategy is a thing someone or some agency (and not necessarily the City of Chicago) is supposed to do in order to reach the goals of the Bike 2015 Plan: reduce injuries and increase the number of trips by bike.</p>
<p>Tracker Notes describe the status of a strategy and are developed using information from any and all sources. </p>
</div>
<div id="chapterBox">
<h2>Explore a chapter</h2>
<?php echo $chapList; ?>
</div>
<div id="themeBox">
<h2>Explore themes</h2>
<?php echo $themeList; ?>
</div>
<div id="statusBox">
<h2>Statuses</h2>
    <ul>
    <li><a href='?status=4'><img src="images/question_circle17.png" /></a> <a href='?status=4'>Unknown status strategies</a>: 
	<?php echo $total_unknownStatus." (".round(($total_unknownStatus)/$total*100,1)."%)"; ?></li>
    <li><a href='?status=0'><img src="images/red_circle17.png" /></a> <a href='?status=0'>Unbegun strategies</a>: 
	<?php echo $total_incomplete." (".round(($total_incomplete)/$total*100,1)."%)"; ?></li>
    <li><a href='?status=3'><img src="images/yellow_circle17.png" /></a> <a href='?status=3'>In progress strategies</a>: 
	<?php echo $total_partiallyCompleted." (".round(($total_partiallyCompleted)/$total*100,1)."%)"; ?></li>
    <li><a href='?status=1'><img src="images/green_circle17.png" /></a> <a href='?status=1'>Completed strategies</a>: 
	<?php echo $total_completed+$total_completedAfterDeadline." (".round(($total_completed+$total_completedAfterDeadline)/$total*100,1)."%)"; ?></li>
     <li>Total strategies: <?php echo $total; ?></li>
    </ul>
</div>
<hr noshade="noshade" class="clear" />
<h2><?php echo $strategyTableTitle; ?></h2>
<?php
echo $incTable; 
?>
<h3 class='clear'>Created by <a href='http://stevevance.net'>Steven Vance</a> for <a href='http://gridchicago.com'>Grid Chicago</a> on January 29, 2012.</h3>
</body>
</html>