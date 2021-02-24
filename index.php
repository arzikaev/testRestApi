<?php
header('Content-Type: json/application');

require_once('methods/methods.php');
require_once('methods/addHistory.php');
require_once('auth/auth.php');

//собираем данные
$arLinks = explode('/', $_REQUEST['links']);
$token = $arLinks[0];
$method = $arLinks[1];
$id = $_REQUEST['id'];
$queryData = [];
if ($_REQUEST['name']) $queryData['name'] = $_REQUEST['name'];
if ($_REQUEST['key']) $queryData['key'] = $_REQUEST['key'];
$date = (new DateTime('now'))->format('Y-m-d H:i:s');
$new_date = date('Y-m-d H:i:s', strtotime('+7 hours', strtotime($date)));
if ($_REQUEST['method'] === 'update.item' && $_REQUEST['name'] || $_REQUEST['method'] === 'update.item' && $_REQUEST['key']) $queryData['updated_at'] = $new_date;
$table = 'Item';

//авторизация
$auth = new auth();
$db = new mysqli($auth->host, $auth->login, $auth->pass, $auth->dbase);
if ($db->connect_errno) {
    printf("Не удалось подключиться: %s\n", $db->connect_error);
    exit();
}

//валидация токена
$user = $auth->verifyToken($db, $token);
if (empty($user)) {
    http_response_code(401);
    $res = [
        'status' => false,
        'message' => 'auth token is not registered'
    ];
    echo json_encode($res);
    return $res;
}

//валидация метода
if (empty($method)) {
    http_response_code(404);
    $res = [
        'status' => false,
        'message' => 'method is not registered'
    ];
    echo json_encode($res);
    return $res;
}

//запуск метода
switch ($method) {
    case 'add.item';//добавление
        $result = methods::add($db, $queryData, $table, $user);
        break;
    case 'get.item';//получение
        $result = methods::getByID($db, $id, $table);
        break;
    case 'update.item';//обновление
        $result = methods::update($db, $queryData, $table, $id, $user);
        break;
    case 'delete.item';//удаление
        $result = methods::delete($db, $id, $table, $user);
        break;
    case 'gethistory.item';//получение истории изменений
        $result = history::getHistoryByItemID($db, $id);
        break;
}

//возращаем результат выполнения метода
print_r(json_encode($result));
$db->close();

return json_encode($result);





