Beauty Booking Engine
=====================

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
app:oauth-server:create-client --grant-type=password
```

Doc
---
/doc/api

Test
----

```
php app/console server:start
php bin/behat --suite=api # Possible suites (web, api)


php bin/phpspec run
```

Translation
-----------

```
php app/console translation:extract fr --dir=./app/Resources/views --output-dir=./app/Resources/translations
```


Security
--------

```
php app/console sylius:rbac:initialize
```