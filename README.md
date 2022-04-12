# api-response

[![Latest Version](https://img.shields.io/github/release/ellipsesynergie/api-response.svg?style=flat-square)](https://github.com/ellipsesynergie/api-response/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
![Api Response Tests](https://github.com/ellipsesynergie/api-response/actions/workflows/run-test.yml/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/ellipsesynergie/api-response.svg?style=flat-square)](https://packagist.org/packages/ellipsesynergie/api-response)

Simple package to handle response properly in your API. This package uses [Fractal](https://github.com/thephpleague/fractal)
and is based on [Build APIs You Won't Hate](https://leanpub.com/build-apis-you-wont-hate) book.

## Install

Via Composer

``` bash
$ composer require ellipsesynergie/api-response
```

## Requirements

The following versions of PHP are supported by this version:

&gt;= PHP 7.4

### Install in Laravel
Add this following service provider to your `config/app.php` file.

```php
EllipseSynergie\ApiResponse\Laravel\ResponseServiceProvider::class
```

### Install in Lumen

Because of the request object change ([see reference](https://laravel-news.com/request-object-changes-in-lumen-5-4)) you can no longer access `Request` object properly in Service provider. To be convenient, we have created a middleware to be used for parsing the `include` parameter.

Register this service provider to your `bootstrap/app.php` file.

```php
$app->register('EllipseSynergie\ApiResponse\Laravel\LumenServiceProvider');
```

Register the global middleware `bootstrap/app.php` file.

```php
$app->middleware([
    'EllipseSynergie\ApiResponse\Laravel\Middleware\ParseInclude'
]);
```

### Install in your favorite framework or vanilla php

This package can be used in _any_ framework or vanilla php. You simply need to extend `EllipseSynergie\ApiResponse\AbstractResponse` and implement the `withArray()` method in your custom class.
You can take a look at `EllipseSynergie\ApiResponse\Laravel\Response::withArray()` for an example.

You will also need to instantiate the response class with a fractal manager instance.

```php
// Instantiate the fractal manager
$manager = new \League\Fractal\Manager;

// Set the request scope if you need embed data
$manager->parseIncludes(explode(',', $_GET['include']));

// Instantiate the response object, replace the class name by your custom class
$response = new \EllipseSynergie\ApiResponse\AbstractResponse($manager);
```

For more options related to the fractal manager, you can take a look at the [official Fractal website](http://fractal.thephpleague.com)

## Example inside Laravel or Lumen controller

```php
<?php

use EllipseSynergie\ApiResponse\Contracts\Response;

class BookController extends Controller {

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
    * Example returning collection
    */
    public function index()
    {
        //Get all books
        $books = Book::all();
    
        // Return a collection of $books
        return $this->response->withCollection($books, new BookTransformer);
    }

    /**
    * Example returning collection with custom key
    */
    public function index()
    {
        //Get all books
        $books = Book::all();
        
        //Custom key
        $customKey = 'books';
    
        // Return a collection of books
        return $this->response->withCollection($books, new BookTransformer, $customKey);
    }

    /**
    * Example returning collection with paginator
    */
    public function index()
    {
        //Get all books
        $books = Book::paginate(15);
       
       // Return a collection of $books with pagination
       return $this->response->withPaginator(
           $books,
           new BookTransformer
       );
    }

    /**
    * Example returning collection with paginator with custom key and meta
    */
    public function index()
    {
        //Get all books
        $books = Book::paginate(15);
        
        //Custom key
        $customKey = 'books';
        
        //Custom meta
        $meta = [
            'category' => 'fantasy'
        ];
       
       // Return a collection of $books with pagination
       return $this->response->withPaginator(
           $books,
           new BookTransformer,
           $customKey,
           $meta
       );
    }

    /**
    * Example returning item
    */
    public function show($id)
    {
        //Get the book
        $book = Book::find($id);
    
        // Return a single book
        return $this->response->withItem($book, new BookTransformer);
    }

    /**
    * Example returning item with a custom key and meta
    */
    public function showWithCustomKeyAndMeta($id)
    {
        //Get the book
        $book = Book::find($id);
        
        //Custom key
        $customKey = 'book';
        
        //Custom meta
        $meta = [
            'readers' => $book->readers
        ];
    
        // Return a single book
        return $this->response->withItem($book, new BookTransformer, $customKey, $meta);
    }
    
    /**
    * Example resource not found
    */
    public function delete($id)
    {
        //Try to get the book
        $book = Book::find($id);

        //Book not found sorry !
        if(!$book){
            return $this->response->errorNotFound('Book Not Found');
        }
    }
    
    /**
    * Example method not implemented
    */
    public function whatAreYouTryingToDo()
    {
        return $this->response->errorMethodNotAllowed("Please don't try this again !");
    }
}
```

## Ouput example

### One book

```json
{
    "data": {
        "id": 1,
        "title": "My name is Bob!.",
        "created_at": {
            "date": "2014-03-25 18:54:18",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "updated_at": {
            "date": "2014-03-25 18:54:18",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "deleted_at": null
    }
}
```

### Collection of books

```json
{
    "data": [
        {
           "id": 1,
           "title": "My name is Bob!",
           "created_at": {
               "date": "2014-03-25 18:54:18",
               "timezone_type": 3,
               "timezone": "UTC"
           },
           "updated_at": {
               "date": "2014-03-25 18:54:18",
               "timezone_type": 3,
               "timezone": "UTC"
           },
           "deleted_at": null
        },
        {
           "id": 2,
           "title": "Who's your dady ?",
           "created_at": {
               "date": "2014-03-26 18:54:18",
               "timezone_type": 3,
               "timezone": "UTC"
           },
           "updated_at": {
               "date": "2014-03-26 18:54:18",
               "timezone_type": 3,
               "timezone": "UTC"
           },
           "deleted_at": null
        }
    ]
}
```

### Error
```json
{
    "error": {
        "code": "GEN-NOT-FOUND",
        "http_code": 404,
        "message": "Book Not Found"
    }
}
```


## Testing the package

``` bash
$ phpunit
```

## Testing within Laravel

According to the issue [#31](https://github.com/ellipsesynergie/api-response/issues/31), we have found some problem when it's time to test the `include` query parameter value.
If you want to resolve this issue in your test, you must use the trait `EllipseSynergie\ApiResponse\Testing\Laravel\AddTestingSupportForInclude`. To replace the `call` method from `Illuminate\Foundation\Testing\Concerns\MakesHttpRequests::call`

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Maxime Beaudoin](https://github.com/maximebeaudoin)
- [Phil Sturgeon](https://github.com/philsturgeon)
- [All Contributors](https://github.com/ellipsesynergie/api-response/contributors)


## License

The MIT License (MIT). Please see [License File](https://github.com/ellipsesynergie/api-response/blob/master/LICENSE) for more information.
