<?php
header('Content-Type: json/application');

require_once('methods/methods.php');

$method = $_GET['method'];
if (empty($method)) {
    http_response_code(404);
    $res = [
        'status' => false,
        'message' => 'method is not registered'
    ];
    echo json_encode($res);
    return $res;
}
//print_r($_GET);
$queryData = [];
$id = $_GET['id'];
if($_GET['name'])$queryData['name'] = $_GET['name'];
if($_GET['key'])$queryData['key'] = $_GET['key'];
$date = (new DateTime('now'))->format('Y-m-d H:i:s');
$new_date = date('Y-m-d H:i:s', strtotime('+7 hours', strtotime($date)));
if($_GET['method'] === 'update.item'&& $_GET['name'] || $_GET['method'] === 'update.item'&& $_GET['key'])$queryData['updated_at'] = $new_date;
$table = 'Item';
//echo ' queryData ';
//print_r($queryData);
$db = new mysqli('localhost', 'admin', '123456789', 'item');
if ($db->connect_errno) {
    printf("Не удалось подключиться: %s\n", $db->connect_error);
    exit();
}
$db->insert_id;
//print_r($_GET['key']);
switch ($method) {
    case 'add.item';//добавление
        $result = methods::add($db, $queryData, $table);
        break;
    case 'get.item';//получение
        $result = methods::getByID($db, $id, $table);
        break;
    case 'update.item';//обновление
        $result = methods::update($db, $queryData, $table, $id);
        break;
    case 'delete.item';//удаление
        $result = methods::delete($db, $id, $table);
        break;
}
//print_r(json_encode($result));
$db->close();

return json_encode($result);





