Users API
=========

API endpoint is ``/api/users``.

Index of all users
---------------------

To browse all users available in the platform you can call the following GET request:

    GET /api/users/

###Parameters

| Parameter   |      Description      |
|----------|:-------------:|
| page | Number of the page, by default = 1 |
| limit |  Number of items to display per page  |

###Response

Response will contain a paginated list of users.


    STATUS: 200 OK



```json
{
   "page":1,
   "limit":10,
   "pages":2,
   "total":11,
   "_links":{
      "self":{
         "href":"\/api\/users\/?page=1&limit=10"
      },
      "first":{
         "href":"\/api\/users\/?page=1&limit=10"
      },
      "last":{
         "href":"\/api\/users\/?page=2&limit=10"
      },
      "next":{
         "href":"\/api\/users\/?page=2&limit=10"
      }
   },
   "_embedded":{
      "items":[
         {
            "id":2,
            "username":"user",
            "enabled":true,
            "salt":"gtxb3aamhwggs80soo48s4c84gkwsws",
            "password":"VcMHeZs4pAA3bOGohctTqR9V4fkMFqGziOR\/btZAMAi0Rt\/dCbG7ow5k5pSWgXmzczPsK1NfwWQqFTg5MIF3bg==",
            "locked":false,
            "roles":[
               "ROLE_API"
            ]
         }
      ]
   }
}
```


Getting a single user
------------------------

You can view a single user by executing the following request:

    GET /api/users/3

###Response

    STATUS: 200 OK


```json
{
   "id":1,
   "username":"user",
   "enabled":true,
   "salt":"mic3cmanwvkoccsggs0c4oo40w0ko0",
   "password":"0QuXg4ti8uonUPoWctFdwCvO\/+BFN1owe0tpYc4aCq37Ihg1LbR\/ZbMcLDgIY9vpkZgOFlpPhtLeVy+Gy5UfJQ==",
   "locked":false,
   "roles":[
      "ROLE_API"
   ]
}
```

Create an user
---------------

To create a new user, you can execute the following request:

    POST /api/users/

###Parameters

| Parameter   |      Description      |
|----------|:-------------:|
| username | Username of the user |
| plainPassword |  Password string  |

###Response

    STATUS: 201 CREATED

```json
{
   "id":1,
   "username":"user",
   "enabled":true,
   "salt":"mic3cmanwvkoccsggs0c4oo40w0ko0",
   "password":"0QuXg4ti8uonUPoWctFdwCvO\/+BFN1owe0tpYc4aCq37Ihg1LbR\/ZbMcLDgIY9vpkZgOFlpPhtLeVy+Gy5UfJQ==",
   "locked":false,
   "roles":[
      "ROLE_API"
   ]
}
```

Updating an user
------------------

You can update an existing business using PUT or PATCH method:


    PUT /api/users/92


    PATCH /api/users/92

###Parameters

| Parameter   |      Description      |
|----------|:-------------:|
| username | Username of the user |
| plainPassword |  Password string  |


###Response

    STATUS: 204 NO CONTENT
