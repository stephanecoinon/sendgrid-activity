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

## Usage

``` php
use StephaneCoinon\SendGridActivity\Requests\MessagesRequest;
use StephaneCoinon\SendGridActivity\SendGrid;

$api = new SendGrid('your API key here');
$messages = $api->request(
    (new MessagesRequest)
        ->limit(50)
        ->query('status="delivered"')
);
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