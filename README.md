BxMarket
========

What's that?
------------
BxMarket is an early-stage project which aims to provide a simple Marketplace system for services and in particular recurrent services.
This project is based on the Sylius project.

Contribution
------------
As the project is still in conception stage, contributors interested in it should contribute only on few points, like UI, enhancement, etc. Don't hesitate to contact me.


Install for dev
---------------

```
composer install

npm install

bower install

php app/console doctrine:database:create

php app/console doctrine:fixtures:load
```

Api
---
/api

To get secret and publid:

```
app:oauth-server:create-client
```

Doc
---

[doc](doc/)


/doc/api


Test
----

```
php app/console server:start
php bin/behat --suite=api


php bin/phpspec run
```

Security
--------

```
php app/console sylius:rbac:initialize
```