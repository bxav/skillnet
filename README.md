Beauty Booking Engine
=====================

Install for dev
---------------

```
composer install

npm install

bower install

php app/console doctrine:database:create

php app/console doctrine:database:create
```

Api
---
/api

Basic http authentication


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
