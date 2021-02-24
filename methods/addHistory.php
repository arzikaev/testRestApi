<?php

class History
{
    public static function add($db, $item_id, $modifyDate, $comments, $user = '0')
    {
        $sql = "INSERT INTO `history`(`modify`, `comments`, `users`, `item_id`) VALUES ('$modifyDate', '$comments', '$user', '$item_id')";
       // print_r($sql);
        $db->query($sql);
    }

    public static function getHistoryByItemID($db, $item_id, $dateFrom = null, $dateTo = null)
    {
        $sql = "SELECT * FROM `history` WHERE  `item_id`=$item_id";
        //print_r($sql);
        $result= $db->query($sql)->fetch_ALL(MYSQLI_ASSOC);
        if (empty($result)) {
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'item not found'
            ];
            // echo json_encode($res);
            return $res;
        } else {
            return [
                'item' => $item_id,
                'history' => $result,
                'status' => 'item received',
                'messege' => 'received an element'];
        }
    }
}