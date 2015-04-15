<pre>
     _                 _                   _       _ 
 ___(_)_ __ ___  _ __ | | ___  _ __     __| | ___ (_)
/ __| | '_ ` _ \| '_ \| |/ _ \| '_ \   / _` |/ _ \| |
\__ \ | | | | | | |_) | | (_) | | | | | (_| | (_) | |
|___/_|_| |_| |_| .__/|_|\___/|_| |_|  \__,_|\___/|_|
                |_|                                  
</pre>

# Simplon Doi

A simple double opt-in verification w/ injectable DB and Email handler.

-------------------------------------------------

### Intro

One of my projects has a process for ```email verification``` and another one for ```password reset```. In both cases I am generating a token, save it to the database and send an email to the user to verify the request. Both scenarios use independent setups since one has been implemented in the very beginning and the other one a couple of months later.

Now I have to implement another process which requires a certain group of users to confirm an ```email address```. Therefore, it's time to ```refactor``` and align our implementations to one unified solution.

```Simplon Doi``` has a flexible setup. It will leave it up to you how to interact with your database and sending out emails. The only thing it takes care of is its ```core``` functionality.

A sample implementation can be found within the [included test folder](https://github.com/fightbulc/simplon_doi/tree/master/test).

-------------------------------------------------

### Install

Get the package via [Composer](http://getcomposer.org):

```json
{
    "require": {
        "simplon/doi": "*"
    }
}
```

You will also need the following table in your database. ```Table name``` and ```type of database``` is up to you. The following example is based on ```MySQL```:

```sql
CREATE TABLE `simplon_doi` (
  `token` varchar(40) NOT NULL DEFAULT '',
  `connector` char(4) NOT NULL DEFAULT '',
  `connector_data_json` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  UNIQUE KEY `token_status` (`token`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

-------------------------------------------------

### Quick Example

#### Creating a Doi

The following steps create a ```Doi```, save it to the database and send an email to the given address:

```php
require __DIR__ . '/vendor/autoload.php';

// Doi instance with database handler
$doi = new \Simplon\Doi\Doi(
    new \Sample\Handler\SampleDatabaseHandler()
);

// set custom connector data (needs at least an email field)
$sampleConnectorDataVo = (new \Sample\SampleConnectorDataVo())
    ->setEmail('tom@hamburg.de')
    ->setFirstname('Tom')
    ->setLastname('Berger');

// create data
$createVo = (new \Simplon\Doi\Vo\DoiCreateVo())
    ->setConnector('EMVAL')
    ->setConnectorDataVo($sampleConnectorDataVo);

// create entry in database
$doiDataVo = $doi->create($createVo);
```

Now you have all related data within ```$doiDataVo``` and its up to you how you want to push the Doi-URL to the user.

### Sending Doi via email

Doi can also take care of sending an email to the user with all relevant data. For this you need to make use of the ```DoiEmailInterface```.
Following an example of how to send an email.

```php
// we use $doiDataVo from above
$doi->sendEmail(
    new \Sample\Handler\SampleEmailHandler(),
    $doiDataVo
);

// you also have the possibility to resend an email
$doi->resendEmail(
    new \Sample\Handler\SampleEmailHandler(),
    $doiToken
);
```

#### Validating a Doi

If the user comes back via a callback link you could use the following code to validate the ```Doi```:

```php
require __DIR__ . '/vendor/autoload.php';

// Doi instance w/ our handlers
$doi = new \Simplon\Doi\Doi(
    new \Sample\Handler\SampleDatabaseHandler(),
    new \Sample\Handler\SampleEmailHandler()
);

// get token from GET param
$token = $_GET['token']; // Pqb2UgtHG0MgIDgI

// validate
$doiDataVo = $doi->validate($token); // throws DoiException or returns DoiDataVo
```

-------------------------------------------------

### Setup: Database handler

-------------------------------------------------

### Setup: Email handler

-------------------------------------------------

# License

Cirrus is freely distributable under the terms of the MIT license.

Copyright (c) 2015 Tino Ehrich ([tino@bigpun.me](mailto:tino@bigpun.me))

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
