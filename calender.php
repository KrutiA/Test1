<html>
<head>   
<link href="cal.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php
error_reporting(0);
require_once 'calender1.php';
$calendar = new Calendar();
echo $calendar->show();
?>
</body>
</html>
