<html>
<style>
a:visited{color:green;display:none;visibility:hidden;font-size:3em}
a:active{color:red;}
a:link{color:red;}
a:hover{color:red;}

</style>
<base target="_blank">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
<h1>WAT IS DIT DAN?</h1>
<p>Top <?php echo $_GET['num']; ?> van dumpert van de afgelopen <?php echo $_GET['dagen']; ?> dagen</p>
<?php
$files=[];
if ($handle = opendir('/var/www/html/dumpert/')) {
   while (false !== ($entry = readdir($handle))) {
	$basename=basename($entry);
	if ( ! ($basename == '.' OR $basename =='..' OR pathinfo($entry,PATHINFO_EXTENSION) != 'html' OR strstr( $entry, "index" ) ) ){
	       $files[]="/var/www/html/dumpert/".$entry;
	}
   }
}
rsort($files);

$num=0;
foreach($files as $name){
	$basename=basename($name);
	$page=file_get_contents($name);
	preg_match_all("#\<a href=\"(http://www.dumpert.nl/mediabase/[^\"]*)\" class=\"dumpthumb\" title=\"([^\"]*)\">#",$page,$matches);

	$i=0;
	echo "<h3>".pathinfo($name,PATHINFO_FILENAME)." om 22u</h3>";
	foreach($matches[1] as $key){
		echo "<a href=\"$key\">".$matches[2][$i]."</a>, ";
		$i++;
		if($i==$_GET['num']){
			break;
		}
	}
	$num++;
	if($num == $_GET['dagen'] ){
		break;
	}
}

if($_GET['dagen']<=10){
	echo "<hr><a style=\"color:red\" href=indexmeer.html>meer!</a>";
}
?>
</body>
</html>
