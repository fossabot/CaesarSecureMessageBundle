# SecurityMessageBundle

## Installation
1. Install component via composer
```shell script
composer require 4xxi/security-message
```

2. Add component into `config/bundles.php` with following content:
```php
return [
//.............
Caesar\SecurityMessageBundle\SecurityMessageBundle::class => ['all' => true],
//.............
];
```

3. Add the configuration yaml into `config/routes/security_message.yaml` with following content:
```yaml
security_message_bundle:
  resource: '@SecurityMessageBundle/Controller/MessageController.php'
  prefix: /
  type: annotation
```

4. Implement `Caesar/SecurityMessageBundle/Service/ClientInterface.php`

5. Add the configuration yaml into `config/packages/security_message.yaml` with following content:
```yaml
security_message:
  client: <Class that implemented ClientInterface>
```
## Usage
####Create new message:
POST /message with
```json
{
  "message": "string",
  "secondsLimit": 20,
  "requestsLimit": 20
}
```
####Get message
GET /message/{id} 
