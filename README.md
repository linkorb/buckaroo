# LinkORB\Buckaroo

API client for Buckaroo BPE 3.0 for PHP. PSR-0 compliant.

## WSDL

This class is designed to work with the following WSDL:

[https://checkout.buckaroo.nl/soap/?WSDL](https://checkout.buckaroo.nl/soap/?WSDL)

## Features

* PSR-0 compatible, works with composer and is registered on packagist.org
* Supports the TransactionRequests action
* Handles SOAP WSSEC, SSL thumbprints and signatures using PEM keys
* Stand-alone library, no external dependencies

## Installing

Check out [composer](http://www.getcomposer.org) for details about installing and running composer.

Then, add `linkorb/buckaroo` to your project's `composer.json`:

```json
{
    "require": {
        "linkorb/buckaroo": "1.*"
    }
}
```

## Try the example

There is a simple example in examples/example.php
To make it work, 
* Edit the `websiteKey` (currently defaults to CHANGEME)
* Put you private_key.pem file in examples/
* run `php example.php`

This will connect to Buckaroo, and send a test transaction. 
The response of the request will be displayed using var_dump().

## Contributing

Ready to build and improve on this repo? Excellent!
Go ahead and fork/clone this repo and we're looking forward to your pull requests!
Be sure to update the unit tests in tests/.

If you are unable to implement changes you like yourself, don't hesitate to
open a new issue report so that we or others may take care of it.

## Todo

* Add unit tests
* Need test refund, creditnote.
* Need recurring transaction.

## Done

* Support transaction request, invoiceinfo, refundinfo.

## License
Please check LICENSE.md for full license information


