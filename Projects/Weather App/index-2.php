<?php
header('Access-Control-Allow-Origin: *');

date_default_timezone_set('Asia/Kathmandu');

//Connects to the database server and selects the database created in this case db2060358

$mysqli = new mysqli("localhost","root","","db2060358");
if ($mysqli -> connect_errno) {
echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
exit();
}

include('data-import.php'); //importing data-import.php to index.php and checking data is present and fresh

//runs an SQL statement that selects the last record in the 'weather' table

$sql = "SELECT *
FROM weather
WHERE city = '{$_GET['city']}'
AND weather_when >= DATE_SUB(NOW(), INTERVAL 5 SECOND)
ORDER BY weather_when DESC limit 1";
$result = $mysqli -> query($sql);

//gets data and converts to JSON

$row = $result -> fetch_assoc();
print json_encode($row);

$result -> free_result();
$mysqli -> close();


?>
