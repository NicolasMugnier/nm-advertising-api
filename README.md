# nm-advertising-api

Use sample :

```php
<?php

require_once dirname(__FILE__).'/vendor/autoload.php';

$associateTag = '';
$awsAccessKey = '';
$secretAccessKey = '';

$app = new \NicolasMugnier\AdvertisingApi\App\Application();

// ItemLookup
$response = $app->getContainer()->get('itemlookup_client')
    ->setAssociateTag($associateTag)
    ->setAwsAccessKey($awsAccessKey)
    ->setSecretAccessKey($secretAccessKey)
    ->setResponseGroup('Offers')
    ->setCondition('All')
    ->setMerchantId('All')
    ->setItemId('B01FNC924E')
    ->setIdType(\NicolasMugnier\AdvertisingApi\ItemLookup::kTypeASIN)
    ->search();
    
echo $response->getBody();

// BrowsenodeLookup
$response = $app->getContainer()->get('browsenodelookup_client')
    ->setAssociateTag($associateTag)
    ->setAwsAccessKey($awsAccessKey)
    ->setSecretAccessKey($secretAccessKey)
    ->setBrowseNodeId('340856031')
    ->search();
    
echo $response->getBody();
```
