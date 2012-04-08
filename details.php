<?php

$id = $_GET['id'];
if(!is_numeric($id)) {
	$id = 0;
}
require_once("mysql.php");

if($id > 0) {
	// get the details of this strategy
	$sql = "SELECT * FROM $tableBp s, $tableChap c, $tableObj o 
			WHERE s.id = $id 
				AND s.chapter = c.chapterNum
				AND s.objective = o.objectiveNum
				AND s.chapter = o.chapterNum";
	$result = mysql_query($sql, $mysql);
	$r = mysql_fetch_array($result);
}
if(mysql_num_rows($result) == 0) {
	$fail = 1;
	$message = "That ID doesn't exist.";
}
if($fail != 1) {
	//build the page
	$title = $r['chapter'].".".$r['objective'].".".$r['strategy'];
	$url = "http://stevevance.net/bikeplantracker/details.php?id=$id";
}

// view previous strategy
$sql = "SELECT * FROM $tableBp WHERE id < $id ORDER BY id DESC LIMIT 1";
$result = mysql_query($sql, $mysql);
$p = mysql_fetch_array($result);

// view next strategy
$sql = "SELECT * FROM $tableBp WHERE id > $id ORDER BY id ASC LIMIT 1";
$result = mysql_query($sql, $mysql);
$n = mysql_fetch_array($result);

// build next-previous links
$nextPrevious = "<p><a href='details.php?id=$p[id]'><< previous strategy</a> - <a href='details.php?id=$id'>this strategy</a> - <a href='details.php?id=$n[id]'>next strategy >></a></p>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Bike 2015 Plan Tracker - Details for Strategy<?php echo $title; ?>x</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<?php require_once("analytics.php"); ?>
</head>

<body>
<?php require_once("header.php"); ?>
<?php 
if($fail != 1) {
	//build the page
	echo "<h2>$r[strategyTitle]</h2><h3>Strategy $title Details</h3>";
	$table = "<table>";
	$table .= "<tr><td><a href='index.php?showChap=$r[chapter]' title='Show all strategies in Chapter $r[chapter]'>Chapter $r[chapter]</a></td><td>".$chapDir[$r['chapter']].": ".$r['chapDescription']."</td></tr>";
	$table .= "<tr><td><a href='index.php?showChap=$r[chapter]&showObj=$r[objective]' title='Show all strategies in Chapter $r[chapter] Objective $r[objective]'>Objective $r[objective]</td><td>$r[objectiveDescription]</td></tr>";
	$table .= "<tr><td><p><b>Strategy $r[strategy]</b></p></td><td><b><p>$r[strategyTitle]</p></b>";
	if(!empty($r['strategyBody'])) {
		$table .= "<p>$r[strategyBody]</p>";
	}
	if($r['seeInstead'] > 0) {
		$table .= "<p><a href='details.php?id=$r[seeInstead]'>See this strategy also</a></p>";
	}
	$table .= "</td></tr>";
	$table .= "<tr><td>Peformance Measure</td><td>$r[perfMeas]</td></tr>";
	$table .= "<tr><td>Tracker Notes</td><td>$r[note]</td></tr>";
	$table .= "</table>";

	echo $table;
	echo $nextPrevious;
	
	// get status updates for this objective
	$sql = "SELECT * FROM $tableStatus WHERE objective_id = '$id' ORDER BY timestamp";
	$result = mysql_query($sql, $mysql);
	if(mysql_num_rows($result) > 0) {
		$st = "<h2>Status Updates</h2>";
		$st .= "<table><tr><th>Date</th><th>Description</th><th>Contributor</th></tr>";
		while($s = mysql_fetch_assoc($result)) {
			$st .= "<tr><td>".date("m-d-Y",strtotime($s['timestamp']))."</td><td>".$s['status_description']."</td><td>".$s['status_contributor']."</td></tr>";
		}
		$st .= "</table>";
	} else {
		$st = "<p>There are no status updates at this time.</p>";
	}
	echo $st;
		
	
	echo "<p>Tracker notes are written by <a href='http://gridchicago.com/contact'>Grid Chicago</a> based on our own research and that from contributors.</p>"; 
	
	if(!empty($disqus_shortname)) {
	echo "<h2>Comments</h2>";
	?>
    <div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = '<?php echo $disqus_shortname; ?>'; // required: replace example with your forum shortname
	var disqus_identifier = '<?php echo $disqus_identifier; ?>';
	var disqus_url = '<?php echo $url; ?>';

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>
    <?php
	} // end comments section
} else {
	echo "<p>$message</p>";
}
?>
</body>
</html>