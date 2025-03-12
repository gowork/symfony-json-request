# JSON Request Bundle

Converts json request body to request array.

**Starting from Symfony 6.3 there is native [$request->getPayload()](https://symfony.com/blog/new-in-symfony-6-3-request-payload) method that can be used instead of this package**

## Install

```shell
composer require gowork/symfony-json-request
```

## Setup bundle

```php
<?php
public function registerBundles(): array
{
    $bundles = [
        // ...
        new GW\SymfonyJsonRequest\SymfonyJsonRequestBundle(),
    ];
    ...
}
```

## Usage

When sending request with json body and `application/json` content type, this bundle converts json keys to symfony request keys:

```php
<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

public function controllerAction(Request $request): Response
{
    $content = (string)$request->request->get('content');
}
```

```shell
curl 'controller/path' \
  -H 'Accept: application/json, text/plain, */*' \
  -H 'Content-Type: application/json;charset=UTF-8' \
  --data-binary '{"content"s:"test","nick":"test"}'
```
