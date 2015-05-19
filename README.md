### Status

[![Latest Version](https://img.shields.io/github/release/ellipsesynergie/api-response.svg?style=flat-square)](https://github.com/ellipsesynergie/api-response/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/ellipsesynergie/api-response.svg?style=flat-square)](https://travis-ci.org/ellipsesynergie/api-response)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/ellipsesynergie/api-response.svg?style=flat-square)](https://scrutinizer-ci.com/g/ellipsesynergie/api-response/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/ellipsesynergie/api-response.svg?style=flat-square)](https://scrutinizer-ci.com/g/ellipsesynergie/api-response)
[![Total Downloads](https://img.shields.io/packagist/dt/ellipsesynergie/api-response.svg?style=flat-square)](https://packagist.org/packages/ellipsesynergie/api-response)

Simple package to handle response properly in your API. This package use [Fractal](https://github.com/thephpleague/fractal)
and are based on [Build APIs You Won't Hate](https://leanpub.com/build-apis-you-wont-hate) book.

## Install

Via Composer

``` bash
$ composer require ellipsesynergie/api-response
```

## Requirements

The following versions of PHP are supported by this version.

* PHP 5.4
* PHP 5.5
* PHP 5.6
* PHP 7.0-dev
* HHVM

#### Install in Laravel 4
Unfortunately, since the release 0.9.0, Laravel 4 is no longer supported because `league/fractal@0.12` no longer support this version.

#### Install in Laravel 5
Once this operation completes, you need to add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

```php
EllipseSynergie\ApiResponse\Laravel\ResponseServiceProvider
```

#### Install in Lumen 5
Once this operation completes, you need to add the service provider. Open `bootstrap/app.php`, and register this provider.

```php
$app->register('EllipseSynergie\ApiResponse\Laravel\LumenServiceProvider');
```

You also need to uncomment the line `$app->withFacades();` in the file `bootstrap/app.php`

#### Install in your favorite framework or vanilla php
This package can be used in ANY framework or vanilla php. You simply need to extend `EllipseSynergie\ApiResponse\AbstractResponse` and implement the `withArray()` method in your custom class.
You can take a look at `EllipseSynergie\ApiResponse\Laravel\Response::withArray()` for a example.

If you have created a new implementation for a specific framework, i strongly recommend you to send a pull request to this repository.

You will also need to instantiate the response class with a fractal manager instance.
```php

// Instantiate the fractal manager
$manager = new \League\Fractal\Manager;

// Set the request scope if you need embed data
$manager->parseIncludes(explode(',', $_GET['include']));

// Instantiate the response object, replace the class name by your custom class
$response = new \EllipseSynergie\ApiResponse\AbstractResponse($manager);
```

For more option related to fractal manager, you can take a look at the [official website](http://fractal.thephpleague.com)

## Example inside Laravel or Lumen controller

``` php
<?php

use EllipseSynergie\ApiResponse\Contracts\Response;

class BookController extends Controller {

    /**
     * @param Response
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

##Ouput example

###One book
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

###Collection of books
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

###Error
```json
{
    "error": {
        "code": "GEN-NOT-FOUND",
        "http_code": 404,
        "message": "Book Not Found"
    }
}
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
