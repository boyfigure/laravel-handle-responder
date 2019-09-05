
Laravel Responder is a package for building API responses,

# Installation

To get started, install the package through Composer:

```shell
composer require offspring/laravel-handle-responder
```


#### Publish Package Assets _(optional)_

You may additionally publish the package configuration and language file using the `vendor:publish` Artisan command:

```shell
php artisan vendor:publish --provider="Offspring\Responder\ResponderServiceProvider"
```

This will publish a `responder.php` configuration file in your `config` folder. It will also publish an `errors.php` file inside your `lang/en` folder which can be used for storing error messages.

#
```

####  Use `responder` Helper

If you're a fan of Laravel's `response` helper function, you may like the `responder` helper function:

```php
return responder()->success();
```
```php
return responder()->error();
```


### Building Responses

The `success` and `error` methods return a `SuccessResponseBuilder` and `ErrorResponseBuilder` respectively, which both extend an abstract `ResponseBuilder`, giving them common behaviors. They will be converted to JSON when returned from a controller, but you can explicitly create an instance of `Illuminate\Http\JsonResponse` with the `respond` method:

```php
return responder()->success()->respond();
```

```php
return responder()->error()->respond();
```

The status code is set to `200` by default, but can be changed by setting the first parameter. You can also pass a list of headers as the second argument:

```php
return responder()->success()->respond(201, ['x-foo' => true]);
```

```php
return responder()->error()->respond(404, ['x-foo' => false]);
```

***
_Consider always using the `respond` method for consistency's sake._
***

### Casting Response Data

Instead of converting the response to a `JsonResponse` using the `respond` method, you can cast the response data to a few other types, like an array:

```php
return responder()->success()->toArray();
```

```php
return responder()->error()->toArray();
```

### Decorating Response

A response decorator allows for last minute changes to the response before it's returned. The package comes with two response decorators out of the box adding a `status` and `success` field to the response output. The `decorators` key in the configuration file defines a list of all enabled response decorators:

```php
'decorators' => [
    \Offspring\Responder\Http\Responses\Decorators\StatusCodeDecorator::class,
    \Offspring\Responder\Http\Responses\Decorators\SuccessFlagDecorator::class,
],
```

You may disable a decorator by removing it from the list, or add your own decorator extending the abstract class `Flugg\Responder\Http\Responses\Decorators\ResponseDecorator`. You can also add additional decorators per response:

```php
return responder()->success()->decorator(ExampleDecorator::class)->respond();
```
```php
return responder()->error()->decorator(ExampleDecorator::class)->respond();
```

***

The package also ships with some situational decorators disabled by default, but which can be added to the decorator list: 
- `PrettyPrintDecorator` decorator will beautify the JSON output;

```php
\Offspring\Responder\Http\Responses\Decorators\PrettyPrintDecorator::class,
```

- `EscapeHtmlDecorator` decorator, based on the "sanitize input, escape output" concept, will escape HTML entities in all strings returned by your API. You can securely store input data "as is" (even malicious HTML tags) being sure that it will be outputted as un-harmful strings. Note that, using this decorator, printing data as text will result in the wrong representation and you must print it as HTML to retrieve the original value.

```php
\Offspring\Responder\Http\Responses\Decorators\EscapeHtmlDecorator::class,
```
