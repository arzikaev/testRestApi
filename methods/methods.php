<?php


class methods
{
    public static function add($db, $queryData)
    {
        echo 'add';
        print_r($queryData);
        $result = null;
        /*$name = $queryData['name'];
        $key = $queryData['key'];
        $createDate = date("Y-m-d H:i:s");
        $updateDate = date("Y-m-d H:i:s");
        $result = $db->query("INSERT INTO `Item`(`name`, `key`, `created_at`, `update_at`) VALUES (`$name`,`$key`,`$createDate`, `$updateDate`");
    */
        return $result;
    }

    public static function getItem($db, $id)
    {
        if (empty($id)) {
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'no `id` passed'
            ];
            echo json_encode($res);
            return $res;
        } else {
            $item = $db->query("SELECT * FROM `Item` WHERE id=`$id`");
            if($db->num_rows($item) > 0){
                http_response_code(404);
                $res = [
                    'status' => false,
                    'message' => 'item not found'
                ];
                echo json_encode($res);
                return $res;
            }else{
                $res = $db->fetch_assoc($item);
                print_r($res);
                return $res;
            }

        }
    }

    public static function update($db, $queryData)
    {
        echo 'update';
        print_r($queryData);
        $result = null;
        /* $id = $queryData['id'];
         $name = $queryData['name'];
         $key = $queryData['key'];
         $updateDate = date("Y-m-d H:i:s");
         $result = $db->query("UPDATE FROM `Item` SET `name`=`$name`, `key`=`$key`, `update_at`=`$updateDate` WHERE `id`=`$id`");
        */
        return $result;
    }

    public static function delete($db, $queryData)
    {
        echo 'delete';
        print_r($queryData);
        $result = null;
        /*$id=$queryData['id'];
        $result = $db->query("DELETE FROM `Item` WHERE `id`=`$id`");
    */
        return $result;
    }
}