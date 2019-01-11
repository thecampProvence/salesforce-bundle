PHP Salesforce bundle
=====================

Symfony integration of [salesforce-client](https://github.com/WakeOnWeb/salesforce-client).

[![Build Status](https://api.travis-ci.org/WakeOnWeb/salesforce-bundle.svg)](https://travis-ci.org/WakeOnWeb/salesforce-bundle)

# Definition

## Salesforce bundle

```yaml
wakeonweb_salesforce:
    host: '%salesforce.host%'
    version: '%salesforce.version%'
    oauth:
        password_strategy:
            consumer_key: '%salesforce.consumer_key%'
            consumer_secret: '%salesforce.consumer_secret%'
            login: '%salesforce.login%'
            password: '%salesforce.password%'
            security_token: '%salesforce.security_token%'
```

## Guzzle client

Customize Guzzle client log messages format and content

Declare following services in services.yml

```yaml
services:
    salesforce.guzzle.client:
        class: GuzzleHttp\Client
        arguments: [ handler: "@salesforce.guzzle.handler_stack" ]

    salesforce.guzzle.handler_stack:
        class: GuzzleHttp\HandlerStack
        public: false
        factory: [ GuzzleHttp\HandlerStack, create ]
        calls:
            - [ push, [ "@salesforce.guzzle.logger" ] ]

    salesforce.guzzle.message_formatter:
        class: GuzzleHttp\MessageFormatter
        arguments:
            - 'Projection.Salesforce - "endpoint": {target} - "verb": {method} - "request": {req_body} - "response": {res_body}'

    salesforce.guzzle.logger:
        class: callback
        arguments: ["@logger", "@salesforce.guzzle.message_formatter"]
        factory: [GuzzleHttp\Middleware, log]
```

#Usage

```php
$client = $container->get('wow.salesforce.client');
// see salesforce-client api.
//$client-> ...
```
