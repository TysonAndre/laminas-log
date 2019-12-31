# PSR-3 Logger Interface compatibility

[PSR-3 Logger Interface](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md)
is a standards recommendation defining a common interface for logging
libraries. The `laminas-log` component predates it, and has minor
incompatibilities, but starting with version 2.6 provides the following
compatibility features:

- PSR logger adapter
- PSR logger writer
- PSR placeholder processor

## PsrLoggerAdapter

`Laminas\Log\PsrLoggerAdapter` wraps `Laminas\Log\LoggerInterface`, allowing it to be used
anywhere `Psr\Log\LoggerInterface` is expected.

```php
$laminasLogLogger = new Laminas\Log\Logger;

$psrLogger = new Laminas\Log\PsrLoggerAdapter($laminasLogLogger);
$psrLogger->log(Psr\Log\LogLevel::INFO, 'We have a PSR-compatible logger');
```

## PSR-3 log writer

`Laminas\Log\Writer\Psr` allows log messages and extras to be forwared to any
PSR-3 compatible logger. As with any log writer, this has the added benefit
that your filters can be used to limit forwarded messages.

The writer needs a `Psr\Logger\LoggerInterface` instance to be useful, and
falls back to `Psr\Log\NullLogger` if none is provided. There are three ways to
provide the PSR logger instance to the log writer:

```php
// Via constructor parameter:
$writer = new Laminas\Log\Writer\Psr($psrLogger);

// Via option:
$writer = new Laminas\Log\Writer\Psr(['logger' => $psrLogger]);

// Via setter injection:
$writer = new Laminas\Log\Writer\Psr();
$writer->setLogger($psrLogger);
```

## PSR-3 placeholder processor

`Laminas\Log\Processor\PsrPlaceholder` adds support for [PSR-3 message placeholders](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md#12-message).
Placeholder names correspond to keys in the "extra" array passed when logging
a message.

Values can be of arbitrary type, including all scalars, and objects
implementing `__toString`; objects not capable of string serialization will
result in the fully-qualified class name being substituted.

```php
$logger = new Laminas\Log\Logger;
$logger->addProcessor(new Laminas\Log\Processor\PsrPlaceholder);

$logger->info('User with email {email} registered', ['email' => 'user@example.org']);
// logs message 'User with email user@example.org registered'
```

## Usage with laminas-servicemanager

For usage with laminas-servicemanager, read the [`PsrLoggerAbstractServiceFactory`
documentation](service-manager.md#psrloggerabstractservicefactory).
