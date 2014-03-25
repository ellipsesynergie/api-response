### Status

[![Build Status](https://travis-ci.org/ellipsesynergie/api-response.png?branch=master)](https://travis-ci.org/ellipsesynergie/api-response)
[![Total Downloads](https://poser.pugx.org/ellipsesynergie/api-response/downloads.png)](https://packagist.org/packages/ellipsesynergie/api-response)
[![Latest Stable Version](https://poser.pugx.org/ellipsesynergie/api-response/v/stable.png)](https://packagist.org/packages/ellipsesynergie/api-response)


Simple package to handle response in your API


## Install

Via Composer

``` json
{
    "require": {
        "ellipsesynergie/api-response": "0.1.*"
    }
}
```

Update your packages with `composer update` or install with `composer install`.

### Laravel
Once this operation completes, you need to add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

```php
EllipseSynergie\ApiResponse\Laravel\ResponseServiceProvider
```


## Usage using Laravel service provider

``` php
// Return a item
return Response::api()->withItem($item, $transformer);

// Return a collection of resources
return Response::api()->withCollection($collection, $transformer);

//Return 404 error
return Response::api()->errorNotFound($collection, $transformer);

```


## Testing

``` bash
$ phpunit
```


## Credits

- [Maxime Beaudoin](https://github.com/maximebeaudoin)
- [Phil Sturgeon](https://github.com/philsturgeon)
- [All Contributors](https://github.com/ellipsesynergie/api-response/contributors)


## License

The MIT License (MIT). Please see [License File](https://github.com/ellipsesynergie/api-response/blob/master/LICENSE) for more information.
