<?php
require 'addHistory.php';

class methods
{
    public static function add($db, $queryData, $table, $user)
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
            $sql = "INSERT INTO $table (`name`, `key`, `created_at`, `updated_at`) VALUES ('$name', '$key', '$new_date', '$new_date')";
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
                history::add($db, $result, $new_date, 'create item', $user);
                return [
                    'id' => $result,
                    'status' => 'added item',
                    'messege' => 'added item id: ' . $result];
            }
        }
    }

    public static function getByID($db, $id, $table)
    {
        print_r($id);

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

    public static function update($db, $queryData, $table, $id, $user)
    {
        // print_r($queryData);
        // echo ' id: ';
        //print_r($id);
        if (empty($queryData) || empty($id)) {
            http_response_code(404);
            $res = [
                'status' => false,
                'message' => 'no `name` or `key` or `id` passed'
            ];
            // echo json_encode($res);
            return $res;
        } else {
            $isItem = self::getByID($db, $id, $table);
            //print_r($isItem);
            if (empty($isItem)) {
                http_response_code(404);
                $res = [
                    'status' => false,
                    'message' => 'item not found'
                ];
                return $res;
            }
            $mappedQueryData = self::mapped_implode(', ', $queryData);
            $sql = "UPDATE " . $table . " SET " . $mappedQueryData . " WHERE Item.id=" . $id;
            echo ' sql: ';
            //print_r($sql);
            $db->query($sql);
            $comments = ' update item:';
            foreach ($queryData as $key => $value) {
                if ($key === 'updated_at') {
                    break;
                }
                $comments .= ' ' . $key . ' ' . $isItem['item'][$key] . ' -> ' . $queryData[$key] . ';';
            }
           // print_r($comments);
            history::add($db, $id, $queryData['updated_at'], $comments, $user);

            return [
                'id' => $id,
                'status' => 'update item',
                'messege' => 'id: ' . $id . ' is update'
            ];
        }
    }

    public static function delete($db, $id, $table, $user)
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
            $date = (new DateTime('now'))->format('Y-m-d H:i:s');
            $new_date = date('Y-m-d H:i:s', strtotime('+7 hours', strtotime($date)));

            $isItem = $isItem = self::getByID($db, $id, $table);
            if (empty($isItem)) {
                http_response_code(404);
                $res = [
                    'status' => false,
                    'message' => 'item not found'
                ];
                return $res;
            }
            $sql = "DELETE FROM $table WHERE  Item.id=$id";
            $db->query($sql);

            history::add($db, $id, $new_date, 'delete item', $user);

            return [
                'id' => $id,
                'status' => 'delete',
                'messege' => 'id: ' . $id . ' is delete'
            ];
        }
    }

    private static function mapped_implode($glue, $array)
    {
        return implode($glue, array_map(
                function ($k, $v) {
                    return "`" . $k . "`" . "='" . $v . "'";
                },
                array_keys($array),
                array_values($array)
            )
        );
    }
}