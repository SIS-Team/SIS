<html>

<body>

<?php

$temp = explode("/", $_SERVER['REQUEST_URI']);
$temp = $temp[count($temp)-2];
echo $temp;
?>


</body>
</html>

