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

По умолчанию api доступен по адресу http://localhost:8080

Лог операций доступен по адресу http://localhost:8080/logs

#### Описание API

##### Регистрация пользователя

> <u>POST</u> /register

Пример тела запроса:

```json
{
  "name": "testUser",
  "email": "test@email.com",
  "password": "password",
  "password_confirmation": "password"
}
```

Пример тела ответа:

```json
{
  "name": "testUser",
  "email": "test@email.com",
  "updated_at": "2020-06-25 09:35:19",
  "created_at": "2020-06-25 09:35:19",
  "id": 1,
  "api_token": "rKAHw1TUHWCNwjVxgTllWqncY6xnAl"
}
```

##### Авторизация пользователя

> <u>POST</u> /login

Пример тела запроса:

```json
{
  "email": "test@email.com",
  "password": "password",
}
```

Пример тела ответа:

```json
{
  "id": 1,
  "name": "testUser",
  "email": "test@email.com",
  "email_verified_at": null,
  "created_at": "2020-06-25 09:35:19",
  "updated_at": "2020-06-25 09:35:19",
  "api_token": "rKAHw1TUHWCNwjVxgTllWqncY6xnAl"
}
```

##### Выход

> <u>POST</u> /logout

Ответ:

```json
"User logged out."
```

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

##### Поиск клиентов

> <u>GET</u> /api/clients/?searchBy={method}&name={name}&phone={phone}&email={email}

**method** - может принимать значения name|phone|email|all

Пример запроса:

<u>http://localhost:8080/api/clients?searchBy=**all**&name=**Absh**&phone=**+2556**&email=**brittany**</u>

Пример ответа:

```json
[
  {
    "id":2,
    "name":"Hailee Conn",
    "lastname":"Abshire",
    "created_at":"2020-06-24 16:01:25",
    "updated_at":"2020-06-24 16:01:25",
    "phones":[
      {
        "id":3,
        "phone":"+9583021014648"
      }
    ],
    "emails":[
      {
        "id":3,
        "email":"winifred25@wilderman.info"
      }
    ]
  },
  {
    "id":3,
    "name":"Mr. Consuelo Pfeffer III",
    "lastname":"Volkman",
    "created_at":"2020-06-24 16:01:25",
    "updated_at":"2020-06-24 16:01:25",
    "phones":[
      {
        "id":4,
        "phone":"+2556066805145"
      }
    ],
    "emails":[
      {
        "id":4,
        "email":"valentin36@ruecker.com"
      },
      {
        "id":5,
        "email":"koelpin.harry@runolfsdottir.com"
      }
    ]
  },
  {
    "id":4,
    "name":"Finn Grant",
    "lastname":"Will",
    "created_at":"2020-06-24 16:01:25",
    "updated_at":"2020-06-24 16:01:25",
    "phones":[
      {
        "id":5,
        "phone":"+5062728321852"
      },
      {
        "id":6,
        "phone":"+7890679620132"
      }
    ],
    "emails":[
      {
        "id":6,
        "email":"brittany.buckridge@bergnaum.net"
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

> ID телефонов и email-адресов обязательно должны принадлежать клиенту, а значения должны быть уникальными. ID телефона или email может отсутствовать, в этом случае будет добавлен новый элемент.

Пример тела ответа:

```json
{
  "id": 30,
  "name": "ChangedName",
  "lastname": "ChangedLastName",
  "created_at": "2020-06-24 17:37:49",
  "updated_at": "2020-06-24 18:41:24",
  "phones": [
    {
      "id": 43,
      "phone": "+79991322570"
    },
    {
      "id": 48,
      "phone": "+79991232574"
    }
  ],
  "emails": [
    {
      "id": 37,
      "email": "test1@email.com"
    }
  ]
}
```

##### Удаление клиента

> <u>DELETE</u> /api/clients/30

Ответ без тела. HTTP код 204.