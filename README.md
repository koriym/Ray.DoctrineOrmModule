# Ray.DoctrineOrmModule

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kawanamiyuu/Ray.DoctrineOrmModule/badges/quality-score.png?b=1.x)](https://scrutinizer-ci.com/g/kawanamiyuu/Ray.DoctrineOrmModule/?branch=1.x)
[![Code Coverage](https://scrutinizer-ci.com/g/kawanamiyuu/Ray.DoctrineOrmModule/badges/coverage.png?b=1.x)](https://scrutinizer-ci.com/g/kawanamiyuu/Ray.DoctrineOrmModule/?branch=1.x)
[![Build Status](https://travis-ci.org/kawanamiyuu/Ray.DoctrineOrmModule.svg?branch=1.x)](https://travis-ci.org/kawanamiyuu/Ray.DoctrineOrmModule)

A [Doctrine ORM](https://github.com/doctrine/doctrine2) Module for [Ray.Di](https://github.com/ray-di/Ray.Di)

## Installation

### Composer install

```bash
$ composer require ray/doctrine-orm-module
```

### Module install

```php
use Ray\Di\AbstractModule;
use Ray\DoctrineOrmModule\DoctrineOrmModule;

class AppModule extends AbstractModule
{
    const ENTITY_PATHS = ['/path/to/Entity/'];

    protected function configure()
    {
        $params = [
            'driver'   => 'pdo_pgsql',
            'user'     => 'username',
            'password' => 'password',
            'host'     => '127.0.0.1'
            'port'     => '5432',
            'dbname'   => 'myapp_db'
        ];

        $this->install(new DoctrineOrmModule($params, self::ENTITY_PATHS));

        //// OR ////

        $params = [
            'url' => 'postgresql://username:password@127.0.0.1:5432/myapp_db'
        ];

        $this->install(new DoctrineOrmModule($params, self::ENTITY_PATHS));
    }
}
```

Learn more about [the database connection configuration](http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html).

## DI trait

 * [EntityManagerInject](https://github.com/kawanamiyuu/Ray.DoctrineOrmModule/blob/1.x/src/Inject/EntityManagerInject.php) for `Doctrine\ORM\EntityManagerInterface` interface

## Transaction management

Any method in the class marked with `@Transactional` is executed in a transaction.

```php
use Ray\DoctrineOrmModule\Annotation\Transactional;
use Ray\DoctrineOrmModule\Inject\EntityManagerInject;

/**
 * @Transactional
 */
class UserService
{
    use EntityManagerInject;

    public function foo()
    {
        // transaction is active
        $this->entityManager->...;
    }

    public function bar()
    {
        // transaction is active
        $this->entityManager->...;
    }
}
```

The method marked with `@Transactional` is executed in a transaction.

```php
use Ray\DoctrineOrmModule\Annotation\Transactional;
use Ray\DoctrineOrmModule\Inject\EntityManagerInject;

class UserService
{
    use EntityManagerInject;

    /**
     * @Transactional
     */
    public function foo()
    {
        // transaction is active
        $this->entityManager->...;
    }

    public function bar()
    {
        // transaction is not active
        $this->entityManager->...;
    }
}
```

## Logging queries

If you want to log queries, you additionally need to bind `Psr\Log\LoggerInterface` and install `SqlLoggerModule`.

```php
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Ray\Di\AbstractModule;
use Ray\DoctrineOrmModule\DoctrineOrmModule;

class AppModule extends AbstractModule
{
    protected function configure()
    {
        $this->install(new DoctrineOrmModule($params, $paths));

        $this->bind(LoggerInterface::class)->toInstance(new Logger('myapp'));
        $this->install(new SqlLoggerModule);
    }
}
```

## Demo

```bash
$ php docs/demo/run.php
// It works!
```

## Requirements

 * PHP 5.5+
 * hhvm
