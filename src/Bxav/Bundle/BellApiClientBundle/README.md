Reseller Club Api Bundle
=============


Client for BellApiClient Http Api


Config
------

```yaml

bxav_bellapi_client:
    api:
        url: "%bellapi_client.api_url%"
        user_id: "%bellapi_client.user_id%"
        key: "%bellapi_client.api_key%"


```


Use
---

```php



```
Check Behat BellApiClientContext for used details



Test
----


Phpspec:
```yaml
#phpspec.yml
suites:
    bellapi:
        namespace: Bxav\Bundle\BellApiClientBundle
        spec_path: src/Bxav/Bundle/BellApiClientBundle
        
```        
 
 
Behat:

```yaml

#behat.yml
    suites:
         
          resellerclubbundle:
              contexts:
                - Bxav\Bundle\BellApiClientBundle\Behat\BellApiClientContext:
              filters:
                tags: "@resellerclub"
                
```

bin/behat --lang=en --suite=resellerclubbundle