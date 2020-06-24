### Test app

#### Задание:
```text
Написать приложение на laravel, реализующее базовый API для работы с клиентами. 
У клиента есть имя, фамилия, один или более номеров телефона, один или более почтовых ящиков. 
Нужно сделать пять методов: добавления, просмотра, изменения, удаления, поиска клиента. 
Поиск осуществляется в четырех вариантах: по имени и фамилии, телефону, почте или по всем 
предыдущим опциям одновременно. Тип поиска передается в параметре запроса. 
Доступ к API осуществляется по токену. 
Необходимо вести лог всех операций через API с сохранением авторства.
```

#### Локальное развертывание проекта:
```bash
docker-compose build # сборка
docker-compose up -d # запуск контейнеров
docker-compose exec app chmod -R 777 storage # фикс прав
docker-compose exec app php artisan migrate # накатываем миграции
docker-compose exec app php artisan db:seed # заполнение данными
```

#### Описание API

##### Получение списка клиентов

> <u>GET</u> /api/clients

Пример тела ответа: 

```json
[
  {
    "id":1,
    "name":"Clotilde Bednar",
    "lastname":"Cole",
    "created_at":"2020-06-24 15:23:30",
    "updated_at":"2020-06-24 15:23:30",
    "phones":[
      {
        "id":1,
        "client_id":1,
        "phone":"+3195531126232"
      }
    ],
    "emails":[
      {
        "id":1,
        "client_id":1,
        "email":"margot.lakin@collins.com"
      }
    ]
  },
  {
    "id":2,
    "name":"Mrs. Kelsi Lind",
    "lastname":"Wunsch",
    "created_at":"2020-06-24 15:23:30",
    "updated_at":"2020-06-24 15:23:30",
    "phones":[
      {
        "id":2,
        "client_id":2,
        "phone":"+3278282084911"
      }
    ],
    "emails":[
      {
        "id":2,
        "client_id":2,
        "email":"jessy.dare@bosco.net"
      },
      {
        "id":3,
        "client_id":2,
        "email":"ward.kari@hotmail.com"
      }
    ]
  }
]
```



##### Создание клиента

> <u>POST</u> /api/clients

Пример тела запроса:

```json
{
  "name": "TestName",
  "lastname": "TestLastName",
  "phones": [
    {
      "phone": "+79991322570"
    }, 
    {
      "phone": "+79991122572"
    }
  ],
  "emails": [
    {
      "email": "test1@email.com"
    }
  ]
} 
```

Пример тела ответа: 

```json
{
  "id":30,
  "name":"TestName",
  "lastname":"TestLastName",
  "created_at":"2020-06-24 17:37:49",
  "updated_at":"2020-06-24 17:37:49",
  "phones":[
    {
      "id":39,
      "client_id":30,
      "phone":"+79991322570"
    },
    {
      "id":40,
      "client_id":30,
      "phone":"+79991122572"
    }
  ],
  "emails":[
    {
      "id":32,
      "client_id":30,
      "email":"test1@email.com"
    }
  ]
}
```



##### Изменение клиента

> <u>PUT</u> /api/clients/{id}

ID - идентификатор изменяемого клиента.

Пример тела запроса:

```json
{
  "name": "ChangedName",
  "lastname": "ChangedLastName",
  "phones": [
    {
      "id": 39,
      "phone": "+79991322570"
    }, 
    {
      "id": 40,
      "phone": "+79991122572"
    }
  ],
  "emails": [
    {
      "id": 32,
      "email": "test1@email.com"
    }
  ]
} 
```

Id телефонов и email-адресов обязательно должны принадлежать клиенту, а значения должны быть уникальными.