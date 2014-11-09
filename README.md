### Status

[![Build Status](https://travis-ci.org/ellipsesynergie/api-response.png?branch=master)](https://travis-ci.org/ellipsesynergie/api-response)
[![Total Downloads](https://poser.pugx.org/ellipsesynergie/api-response/downloads.png)](https://packagist.org/packages/ellipsesynergie/api-response)
[![Latest Stable Version](https://poser.pugx.org/ellipsesynergie/api-response/v/stable.png)](https://packagist.org/packages/ellipsesynergie/api-response)

Simple package to handle response properly in your API. This package use [Fractal](https://github.com/thephpleague/fractal)
and are based on [Build APIs You Won't Hate](https://leanpub.com/build-apis-you-wont-hate) book.

## Install

Via Composer

``` json
{
    "require": {
        "ellipsesynergie/api-response": "0.7.*"
    }
}
```

Update your packages with `composer update` or install with `composer install`.

#### Install in Laravel 4
Once this operation completes, you need to add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

```php
EllipseSynergie\ApiResponse\Laravel\ResponseServiceProvider
```

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


## Example inside Laravel controller

``` php
<?php

class BookController extends Controller {

    /**
    * Example returning collection
    */
    public function index()
    {
        //Get all books
        $books = Book::all();
    
        // Return a collection of $books
        return Response::api()->withCollection($books, new BookTransformer);
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
        return Response::api()->withCollection($books, new BookTransformer, $customKey);
    }

    /**
    * Example returning collection with paginator
    */
    public function index()
    {
        //Get all books
        $books = Book::paginate(15);
       
       // Return a collection of $books with pagination
       return \Response::api()->withPaginator(
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
            'category' = 'fantasy'
        ];
       
       // Return a collection of $books with pagination
       return \Response::api()->withPaginator(
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
        return Response::api()->withItem($book, new BookTransformer);
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
            'readers' = $book->readers
        ];
    
        // Return a single book
        return Response::api()->withItem($book, new BookTransformer, $customKey, $meta);
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
            return Response::api()->errorNotFound('Book Not Found');
        }
    }
    
    /**
    * Example method not implemented
    */
    public function whatAreYouTryingToDo()
    {
        return Response::errorMethodNotAllowed("Please don't try this again !");
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
