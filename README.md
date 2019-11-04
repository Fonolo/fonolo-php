<a href="https://fonolo.com" target="_blank"><img src="https://portal.fonolo.com/static/1.0/images/fonolo_logo_large.png"/></a>

# PHP Client Library

The official PHP binding for the Fonolo Call-Back Service.

## Prerequisites

Before using this library, you must have:

* A Fonolo Account; visit [fonolo.com](https://fonolo.com/) for more details.
* a valid Fonolo Account SID and Auth Token, available from the [Fonolo Portal](https://portal.fonolo.com/)
* PHP >= 5.4
* The PHP JSON extension

## Installation

```
composer require fonolo/sdk
```

## Quickstart

### Start a new Fonolo Call-Back:

```php
<?php

$client = new Fonolo\Client(<account sid>, <auth token>);
try
{
    $res = $client->callback->start(array(

        'fc_number' => '14163662500',
        'fc_option' => 'CO529c5278b2cefeabc984506e785d8cb0'
    ));

} catch(Fonolo\Exceptions\FonoloException $e)
{
    echo $e->getMessage();
}

?>
```

That will output a PHP object that looks like this:

```
stdClass Object
(
    [head] => stdClass Object
        (
            [status] => 200
            [message] => Call started successfully.
        )

    [data] => stdClass Object
        (
            [sid] => CA8b3a9802f271e076069c1844a9d5d7f6
            [status] => /3.0/call/CA8b3a9802f271e076069c1844a9d5d7f6/status.json
        )

)
```

## Documentation

Full API documentation is available from the [Fonolo developer site.][fonolo dev site]

## Release History

### v1.0.2
* Added support for the pending call-backs view (/pending endpoint)

### v1.0.1
* Added support for the realtime and scheduled call-backs view.
* Added support for the timezones endpoint.

### v1.0.0
* Initial release.

[fonolo dev site]:  https://fonolo.com/help/api/
