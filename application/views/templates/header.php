<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $title ?></title>
<link href="/assets/css/styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/js/jquery/jquery.js"></script>
<script type="text/javascript" src="/assets/js/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#strategiesTable').dataTable();
			} );
		</script>
<style type="text/css">
@import url("/assets/js/datatables/media/css/demo_page.css");
@import url("/assets/js/datatables/media/css/demo_table.css");
</style>
</head>

<body>

<?php if (isset($user['user'])) : ?>
<strong>Logged in as <?php print_r($user['user']) ?> | <?php echo anchor('users/logout', 'logout') ?></strong>

<?php else : ?>

<strong><?php echo anchor('users/login', 'login') ?></strong>

<?php endif; ?>
