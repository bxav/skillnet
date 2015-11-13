Employees API
=========

API endpoint is ``/api/employees``.

Index of all employees
---------------------

To browse all employees available in the platform you can call the following GET request:

    GET /api/employees/

###Parameters

| Parameter   |      Description      |
|----------|:-------------:|
| page | Number of the page, by default = 1 |
| limit |  Number of items to display per page  |

###Response

Response will contain a paginated list of employees.


    STATUS: 200 OK


```json
{
   "page":1,
   "limit":10,
   "pages":1,
   "total":1,
   "_links":{
      "self":{
         "href":"\/api\/employees\/?page=1&limit=10"
      },
      "first":{
         "href":"\/api\/employees\/?page=1&limit=10"
      },
      "last":{
         "href":"\/api\/employees\/?page=1&limit=10"
      }
   },
   "_embedded":{
      "items":[
         {
            "id":4,
            "user":{
               "id":6,
               "username":"marie",
               "enabled":true,
               "salt":"dk0wwlsqx4gsgog88kwg4ok4cccwwcc",
               "password":"fqN3ZZmJz5PqGXSemOSZ77Azi8sPPr\/bzscwaOzN7wYni\/blFlpYMC159cALmvk69npVLRGgHDb+fgZi+KZJKw==",
               "locked":false,
               "roles":[
                  "ROLE_API"
               ]
            },
            "first_name":"marie",
            "last_name":"dupond",
            "business":{
               "id":3,
               "name":"Haircut Master",
               "disponibility_time_slot":15,
               "slug":"haircut-master",
               "working_days":{
                  "monday":[

                  ],
                  "tuesday":[

                  ],
                  "wednesday":[

                  ],
                  "thursday":[

                  ],
                  "friday":[

                  ],
                  "saturday":[

                  ],
                  "sunday":[

                  ]
               }
            },
            "working_days":{
               "monday":[

               ],
               "tuesday":[

               ],
               "wednesday":[

               ],
               "thursday":[

               ],
               "friday":[

               ],
               "saturday":[

               ],
               "sunday":[

               ]
            },
            "_links":{
               "self":{
                  "href":"\/api\/employees\/4"
               }
            }
         }
      ]
   }
}
```

Getting a single employee
------------------------

You can view a single employee by executing the following request:

    GET /api/employees/3

###Response

    STATUS: 200 OK

```json
{
   "id":1,
   "user":{
      "id":2,
      "username":"marie",
      "enabled":true,
      "salt":"iyqlhi156y8ss0ggokc4sg8scss0ckw",
      "password":"pOFr77P+s6hPLrBielgR7WO62HiVjYgsAyBVfBnlr\/l6SoxfypbAQTi6v6eR7HA\/wzl08ZRpI+eruThlf93cRQ==",
      "locked":false,
      "roles":[
         "ROLE_API"
      ]
   },
   "first_name":"marie",
   "last_name":"dupond",
   "business":{
      "id":1,
      "name":"Haircut Master",
      "disponibility_time_slot":15,
      "slug":"haircut-master",
      "working_days":{
         "monday":[

         ],
         "tuesday":[

         ],
         "wednesday":[

         ],
         "thursday":[

         ],
         "friday":[

         ],
         "saturday":[

         ],
         "sunday":[

         ]
      }
   },
   "working_days":{
      "monday":[

      ],
      "tuesday":[

      ],
      "wednesday":[

      ],
      "thursday":[

      ],
      "friday":[

      ],
      "saturday":[

      ],
      "sunday":[

      ]
   },
   "_links":{
      "self":{
         "href":"\/api\/employees\/1"
      }
   }
}
```

Create an employee
---------------

To create a new employee, you can execute the following request:

    POST /api/employees/

###Parameters

| Parameter   |      Description      |
|----------|:-------------:|
| firstName | Firstname of the employee |
| lastName |  Lastname of the employee  |
| user |  The id of the user  |
| business |  The id of the business  |

###Response

    STATUS: 201 CREATED

```json
{
   "id":1,
   "user":{
      "id":2,
      "username":"marie",
      "enabled":true,
      "salt":"iyqlhi156y8ss0ggokc4sg8scss0ckw",
      "password":"pOFr77P+s6hPLrBielgR7WO62HiVjYgsAyBVfBnlr\/l6SoxfypbAQTi6v6eR7HA\/wzl08ZRpI+eruThlf93cRQ==",
      "locked":false,
      "roles":[
         "ROLE_API"
      ]
   },
   "first_name":"marie",
   "last_name":"dupond",
   "business":{
      "id":1,
      "name":"Haircut Master",
      "disponibility_time_slot":15,
      "slug":"haircut-master",
      "working_days":{
         "monday":[

         ],
         "tuesday":[

         ],
         "wednesday":[

         ],
         "thursday":[

         ],
         "friday":[

         ],
         "saturday":[

         ],
         "sunday":[

         ]
      }
   },
   "working_days":{
      "monday":[

      ],
      "tuesday":[

      ],
      "wednesday":[

      ],
      "thursday":[

      ],
      "friday":[

      ],
      "saturday":[

      ],
      "sunday":[

      ]
   },
   "_links":{
      "self":{
         "href":"\/api\/employees\/1"
      }
   }
}
```

Updating an employee
------------------

You can update an existing business using PUT or PATCH method:


    PUT /api/employees/92


    PATCH /api/employees/92

###Parameters

| Parameter   |      Description      |
|----------|:-------------:|
| firstName | Firstname of the employee |
| lastName |  Lastname of the employee  |
| user |  The id of the user  |
| business |  The id of the business  |


###Response


    STATUS: 204 NO CONTENT


Index of all employee services
------------------------

To browse all orders for specific user, you can do the following call:

    GET /api/employees/14/services/

###Parameters

| Parameter   |      Description      |
|----------|:-------------:|
| page | Number of the page, by default = 1 |
| limit |  Number of items to display per page  |
