Authorization
=============

This part of documentation is about authorization to the platform through API.


OAuth2
------
The platform has configured OAuth2 authorization. The authorization process is standard procedure. Authorize as admin and enjoy the API!


    User has to have ROLE_API role in order to access /api resources

###Create OAuth client


Use sylius command:

    php app/console sylius:oauth-server:create-client --grant-type="password" --grant-type="refresh_token" --grant-type="token"

You will receive client public id and client secret

####Example


    public id: 4fugw85qtim8c48s88g00s0gc040s4s4k8wk4kswowkksg0skw
    secret: s8tg7026wo0k0koco8o4wc0kwocowskgwkk0wowsgc8o4408c


    If you use Guzzle check out `OAuth2 plugin`__ and use Password Credentials.

https://github.com/commerceguys/guzzle-oauth2-plugin

###Obtain access token

Send the request with the following parameters

| Parameter   |      Description      |
|----------|:-------------:|
| client_id | Public client id |
| client_secret |  Client secret  |
| grant_type |  We will use 'password' to authorize as user  |
| username |  User name  |
| password |  User password  |

####Example



    GET /oauth/v2/token?client_id=4fugw85qtim8c48s88g00s0gc040s4s4k8wk4kswowkksg0skw&client_secret=s8tg7026wo0k0koco8o4wc0kwocowskgwkk0wowsgc8o4408c&grant_type=password&username=sylius@example.com&password=sylius

####Example response


```json
{
    "access_token": "MmE1YmJkMmVjNWI4YTUyZWU2OTM2NzljM2Y2N2FkMTVkMTQ2Y2ViYmZhNTQ4OTYzODVmN2UzMjEwNjU3NWUzMw",
    "expires_in": 3600,
    "token_type": "bearer",
    "scope": null,
    "refresh_token": "OGQyMWZhYzkzYTZlNWY2YjA5MzRjMTk2MTNkNjM2Y2Y5ODg3ZjRlZmVlY2IyMmY1OGZkNGMxMjAwZjRmZjlmZQ",
}
```

###Request for resource

Put access token in the request header


    Authorization: Bearer {access_token}

You can now access any resource you want under /api prefix

####Example


    GET /api/users/
    Authorization: Bearer Y2Y2NmNlNGExNzc1YmRiNzY3MDFlNmU0NjVjZjAxZjMwOTQ0MDZlODVhMTJlYTc4MDU3ZDFjMmExZjU3YTRkMQ


    You have to refresh your token after it expires

###Refresh token

Send request with the following parameters

| Parameter   |      Description      |
|----------|:-------------:|
| client_id | Public client id |
| client_secret |  Client secret  |
| grant_type |  'refresh_token'  |
| refresh_token |  Refresh token  |


####Example

    GET /oauth/v2/token?client_id=4fugw85qtim8c48s88g00s0gc040s4s4k8wk4kswowkksg0skw&client_secret=s8tg7026wo0k0koco8o4wc0kwocowskgwkk0wowsgc8o4408c&grant_type=refresh_token&refresh_token=YzYzNDYyZmFiN2QyYTk3OTM4ZTFjODA2ZWJkMDFiZmIwZjE2Yzc4MTBkZWFlYzM3ZDU4YTE5ODcwMTc3MTRlZQ

####Example response

You can now use new token to send requests

```json
{
    "access_token": "MmE1YmJkMmVjNWI4YTUyZWU2OTM2NzljM2Y2N2FkMTVkMTQ2Y2ViYmZhNTQ4OTYzODVmN2UzMjEwNjU3NWUzMw",
    "expires_in": 3600,
    "token_type": "bearer",
    "scope": null,
    "refresh_token": "OGQyMWZhYzkzYTZlNWY2YjA5MzRjMTk2MTNkNjM2Y2Y5ODg3ZjRlZmVlY2IyMmY1OGZkNGMxMjAwZjRmZjlmZQ",
}
```    
