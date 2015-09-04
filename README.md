Base Symfony
============

Install
-------

composer install

Api
---
/api

Basic http authentication


Doc
---
/doc/api

Test
----

php app/console server:start

bin/behat --suite=api

Translation
-----------

```
php app/console translation:extract fr --dir=./app/Resources/views --output-dir=./app/Resources/translations
```
