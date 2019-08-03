# PHP Client for SendGrid e-Mail Activity API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/stephanecoinon/sendgrid-activity.svg?style=flat-square)](https://packagist.org/packages/stephanecoinon/sendgrid-activity)
[![Build Status](https://img.shields.io/travis/stephanecoinon/sendgrid-activity/master.svg?style=flat-square)](https://travis-ci.org/stephanecoinon/sendgrid-activity)
[![Quality Score](https://img.shields.io/scrutinizer/g/stephanecoinon/sendgrid-activity.svg?style=flat-square)](https://scrutinizer-ci.com/g/stephanecoinon/sendgrid-activity)
[![Total Downloads](https://img.shields.io/packagist/dt/stephanecoinon/sendgrid-activity.svg?style=flat-square)](https://packagist.org/packages/stephanecoinon/sendgrid-activity)

Based on [SendGrid API v3](https://sendgrid.api-docs.io/v3.0/email-activity).

## Installation

You can install the package via composer:

```bash
composer require stephanecoinon/sendgrid-activity
```

This package is agnostic but also can integrate with Laravel (tested on 5.8 but should work >=5.5).

Just add your SendGrid API key in `.env`:

```
SENDGRID_API_KEY=your_API_key_here
```

Then update `config/services.php` and you're good to go:

```php
return [

    // ...

    'sendgrid' => [
        'key' => env('SENDGRID_API_KEY'),
    ],

];
```

## Usage

``` php
use StephaneCoinon\SendGridActivity\Requests\MessagesRequest;
use StephaneCoinon\SendGridActivity\SendGrid;

// First, get SendGrid API client instance
// In vanilla PHP
$api = new SendGrid('your API key here');
// Or in Laravel
$api = app(SendGrid::class);

// Fetch the message activity
$messages = $api->request(
    (new MessagesRequest)
        ->limit(50)
        ->query('status="delivered"')
);
// Note: $messages will be a \Illuminate\Support\Collection when in a Laravel app
```

### Testing

``` bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email me@stephanecoinon.co.uk instead of using the issue tracker.

## Credits

- [Stéphane Coinon](https://github.com/stephanecoinon)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## PHP Package Boilerplate

This package was generated using the [PHP Package Boilerplate](https://laravelpackageboilerplate.com).