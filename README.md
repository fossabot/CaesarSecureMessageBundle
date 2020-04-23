# SecurityMessageBundle

## Installation
1. Install component via composer
```shell script
composer require 4xxi/security-message
```

2. Add configuration yaml into `config/routes/security_message.yaml` with following content:
```yaml
security_message_bundle:
  resource: '@SecurityMessageBundle/Controller/MessageController.php'
  prefix: /
  type: annotation

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
