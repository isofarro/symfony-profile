<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?php 
		if (!include_slot('title')): 
			echo "Isofarro";
		endif;
	?></title>
	<?php include_metas() ?>
	
	<link rel="shortcut icon" href="/favicon.ico" />
</head>
<body>

<div id="page">
	<div id="head">
		<h1>Isofarro</h1>
	</div>
	<?php echo $sf_content ?>
	<div id="foot">
		<p>Copyright &copy; 2009 Isofarro</p>
	</div>
</div>


</body>
</html>