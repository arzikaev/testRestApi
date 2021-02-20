<?php
header('Content-Type: json/application');

require_once('methods/methods.php');

$queryData = [];

$queryData['id'] = $_GET['id'];
$queryData['name'] = $_GET['name'];
$queryData['key'] = $_GET['key'];

$db = new mysqli('localhost', 'admin', '123456789', 'item');

$methods = new methods();
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET';//добавление
        $result = $methods->add($db, $queryData);
        break;
    case 'POST';//получение
        $result = $methods->getItem($db, $queryData['id']);
        break;
    case 'PUT';//обновление
        $result = $methods->update($db, $queryData);
        break;
    case 'DELETE';//удаление
        $result = $methods->delete($db, $queryData);
        break;
}

print_r($result);
$db->close();





