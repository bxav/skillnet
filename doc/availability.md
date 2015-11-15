Availabilities API
=========

API endpoint is ``/api/availabilities``.

Index of all availabilities
---------------------

To browse all availabilities available in the platform you can call the following GET request:

    GET /api/availabilities/

###Parameters

| Parameter   |      Description      |
|----------|:-------------:|
| page | Number of the page, by default = 1 |
| limit |  Number of items to display per page  |
| service | The id of the service  |
| date | Date of the availabilities |

###Response

Response will contain a paginated list of availabilities.


    STATUS: 200 OK


```json
{
   "page":1,
   "limit":10,
   "pages":1,
   "total":1,
   "_links":{
      "self":{
         "href":"\/api\/availabilities\/?date=2042-01-01&service=1&page=1&limit=10"
      },
      "first":{
         "href":"\/api\/availabilities\/?date=2042-01-01&service=1&page=1&limit=10"
      },
      "last":{
         "href":"\/api\/availabilities\/?date=2042-01-01&service=1&page=1&limit=10"
      }
   },
   "_embedded":{
      "items":[
      ]
   }
}
```
