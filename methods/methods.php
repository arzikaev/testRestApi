<?php


class methods
{
    public static function add($db, $queryData, $table)
    {
        if (empty($queryData['name']) || empty($queryData['key'])) {
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'no `name` or `key` passed'
            ];
            // echo json_encode($res);
            return $res;
        } else {
            // print_r($queryData);
            $name = $queryData['name'];
            $key = $queryData['key'];
            $date = (new DateTime('now'))->format('Y-m-d H:i:s');
            $new_date = date('Y-m-d H:i:s', strtotime('+7 hours', strtotime($date)));
            $createDate = $date;
            $updateDate = $date;
            $sql = "INSERT INTO $table (`name`, `key`, `created_at`, `updated_at`) VALUES ('$name', '$key', '$createDate', '$updateDate')";
            $db->query($sql);
            $result = $db->insert_id;
            //print_r($result);
            if (empty($result)) {
                http_response_code(404);
                $res = [
                    'status' => false,
                    'message' => 'item not found'
                ];
                echo json_encode($res);
                return $res;
            } else {

                return [
                    'id' => $result,
                    'status' => 'added item',
                    'messege' => 'added item id: ' . $result];
            }
        }
    }

    public static function getByID($db, $id, $table)
    {
        if (empty($id)) {
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'no `id` passed'
            ];
            // echo json_encode($res);
            return $res;
        } else {
            $sql = "SELECT * FROM $table WHERE  Item.id=$id";
            $item = $db->query($sql)->fetch_assoc();
            if (empty($item)) {
                http_response_code(404);
                $res = [
                    'status' => false,
                    'message' => 'item not found'
                ];
                // echo json_encode($res);
                return $res;
            } else {
                return [
                    'item' => $item,
                    'status' => 'item received',
                    'messege' => 'received an element'];
            }

        }
    }

    public static function update($db, $queryData, $table, $id)
    {
        print_r($queryData);
        // echo ' id: ';
        // print_r($id);
        if (empty($queryData) || empty($id)) {
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'no `name` or `key` or `id` passed'
            ];
            // echo json_encode($res);
            return $res;
        } else {
            $mappedQueryData = self::mapped_implode(', ', $queryData);
            $sql = "UPDATE " . $table . " SET " . $mappedQueryData . " WHERE Item.id=" . $id;
            echo ' sql: ';
            print_r($sql);
            $db->query($sql);
            return [
                'id' => $id,
                'status' => 'update item',
                'messege' => 'id: ' . $id . ' is update'
            ];
        }
    }

    public static function delete($db, $id, $table)
    {
        if (empty($id)) {
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'no `id` passed'
            ];
            // echo json_encode($res);
            return $res;
        } else {
            $sql = "DELETE FROM $table WHERE  Item.id=$id";
            $db->query($sql);
            return [
                'id' => $id,
                'status' => 'delete',
                'messege' => 'id: ' . $id . ' is delete'
            ];
        }
    }

    private
    static function mapped_implode($glue, $array, $symbol1 = "'", $symbol2 = "=", $symbol3 = "'")
    {
        return implode($glue, array_map(
                function ($k, $v) use ($symbol1, $symbol2, $symbol3) {
                    return '`' . $k . '`' . $symbol2 . $symbol1 . $v . $symbol3;
                },
                array_keys($array),
                array_values($array)
            )
        );
    }
}