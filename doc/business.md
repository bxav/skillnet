Businesses API
=========

API endpoint is ``/api/businesses``.

Index of all businesses
---------------------

To browse all businesses available in the platform you can call the following GET request:

    GET /api/businesses/

###Parameters

| Parameter   |      Description      |
|----------|:-------------:|
| page | Number of the page, by default = 1 |
| limit |  Number of items to display per page  |

###Response

Response will contain a paginated list of channels.


    STATUS: 200 OK


```json
{
   "page":1,
   "limit":10,
   "pages":2,
   "total":11,
   "_links":{
      "self":{
         "href":"\/api\/businesses\/?page=1&limit=10"
      },
      "first":{
         "href":"\/api\/businesses\/?page=1&limit=10"
      },
      "last":{
         "href":"\/api\/businesses\/?page=2&limit=10"
      },
      "next":{
         "href":"\/api\/businesses\/?page=2&limit=10"
      }
   },
   "_embedded":{
      "items":[
         {
            "id":6,
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
         }
      ]
   }
}
```

Getting a single business
------------------------

You can view a single business by executing the following request:

    GET /api/businesses/3

###Response



    STATUS: 200 OK

```json
{
   "id":3,
   "name":"Jean CoifCoif",
   "website":"coif.com",
   "phone":"0669696969",
   "email":"marie-dupond@example.com",
   "description":"lorem",
   "disponibility_time_slot":20,
   "slug":"jean-coifcoif",
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
}
```

Create an business
---------------

To create a new business, you can execute the following request:

    POST /api/businesses/

###Parameters

| Parameter   |      Description      |
|----------|:-------------:|
| name | desc |
| website |  desc  |
| phone |  desc  |
| email |  desc  |
| description |  desc  |
| disponibilityTimeSlot |  desc  |

###Response

    STATUS: 201 CREATED

```json
{
   "id":3,
   "name":"Jean CoifCoif",
   "website":"coif.com",
   "phone":"0669696969",
   "email":"marie-dupond@example.com",
   "description":"lorem",
   "disponibility_time_slot":20,
   "slug":"jean-coifcoif",
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
}
```

Updating a business
------------------

You can update an existing business using PUT or PATCH method:


    PUT /api/businesses/92


    PATCH /api/businesses/92

###Parameters

| Parameter   |      Description      |
|----------|:-------------:|
| name | desc |
| website |  desc  |
| phone |  desc  |
| email |  desc  |
| description |  desc  |
| disponibilityTimeSlot |  desc  |

###Response


    STATUS: 204 NO CONTENT
