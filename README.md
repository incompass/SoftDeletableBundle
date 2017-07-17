[![Build Status](https://travis-ci.org/incompass/SoftDeletableBundle.svg?branch=master)](https://travis-ci.org/incompass/SoftDeletableBundle)
[![Total Downloads](https://poser.pugx.org/incompass/soft-deletable-bundle/downloads.svg)](https://packagist.org/packages/incompass/soft-deletable-bundle)
[![Latest Stable Version](https://poser.pugx.org/incompass/soft-deletable-bundle/v/stable.svg)](https://packagist.org/packages/incompass/soft-deletable-bundle)

SoftDeletableBundle
===================

This bundle allows you to simply add ```use SoftDeleteTrait```
to a doctrine entity class to enable soft deletes.

Installation
------------

### Composer
```
composer require incompass/soft-deletable-bundle
```

Usage
-----

Add the SoftDeleteTrait trait to your doctrine entities.

```
use SoftDeleteTrait
```

Update your database schema
```
php bin/console doctrine:schema:update --force
```

Entities will now store a deleted_at date time when they are soft deleted.

Contributors
------------

Joe Mizzi (casechek/incompass)
Mike Bates (casechek/incompass)
