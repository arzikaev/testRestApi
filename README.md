# testRestApi
is test work create RestAPI in PHP

Документация по api

    Сущность: "item"

Имеющиеся поля: 

    "id" (increment)

    "name" - (char 255)

    "key" - (char 25)

    "create_at" (datetime) - дата+время создания элемента 

    "update_at" (datetime) - дата+время изменения элемента


Для использования api, необходимо обратиться к серверу по типу:

    localhost/method?params, метод соединения "GET"

    где: localhos - имя хоста, method - название метода, params - параметры принимающие методом

Описание методов:

    1. add.item

    принимает следующие параметры:

    name - имя

    key - ключ
    
    Возвращает:
    
    json: {
              "id": 18,
              "status": "added item",
              "messege": "added item id: 18 in Database: `Item`"
          }
    
    
    2. get.item 
 
    принимает следующие параметры:
 
    id - id искомого элемента
 
    Возвращает: 
    
    json {
        "item": {
            "id": "12",
            "name": "test221",
            "key": "43412",
            "created_at": "2021-02-20 14:53:05",
            "updated_at": "2021-02-20 14:53:05"
        },
        "status": "item received",
        "messege": "received an element"
    }



    3. update.item

    принимает следующие параметры: 

    id - id обновляемого элемента
    name - имя(обновляемые данные)
    key - ключ(обновляемы данные)

    Возвращает: 
    json {
        "id": "12",
        "status": "update item",
        "messege": "id: 12 is update"
    }

    4. delete.item 

    принимает следующие параметры:

    id - id удаляемого элемента

    Возвращает:
    json {
            "id": "12",
            "status": "delete",
            "messege": "id: 12 is delete"
        }
    



