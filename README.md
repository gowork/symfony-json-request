# JSON Request Bundle

Converts json request body to request array.

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
