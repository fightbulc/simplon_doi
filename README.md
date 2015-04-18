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

```Simplon Doi``` has a flexible setup. It will leave it up to you how to interact with your database. The only thing it takes care of is its ```core``` functionality: creation and validation of a double opt-in process.

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
  `token` varchar(6) NOT NULL DEFAULT '',
  `connector` char(6) NOT NULL DEFAULT '',
  `data_json` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  UNIQUE KEY `token_status` (`token`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

-------------------------------------------------

### Quick Example

#### Creating a Doi

The following steps create a ```Doi``` and save it to the database:

```php
require __DIR__ . '/vendor/autoload.php';

// Doi instance with database handler
$doi = new \Simplon\Doi\Doi(
    new \Sample\Handler\SampleDatabaseHandler()
);

// connecor is an identifier for your internal reference
$connector = 'NL'; // max. 6 chars

// data connected to this doi
$data = [
    'email'     => 'tom@hamburg.de',
    'firstName' => 'Tom',
    'lastName'  => 'Berger',
];
    
// create entry in database
$doiDataVo = $doi->create($connector, $data); // 56,800,235,584 possible tokens
```

Now you have all related data within ```$doiDataVo```. Now you need to let your user know. Probably you will send an email which includes a link which points back to your app.
The app needs to handle the request and pass on the ```TOKEN``` to the validation process.

```php
// THE FOLLOWING PART MUST FIT YOUR EMAIL SOLUTION
// SIMPLON\DOI DOES NOT OFFER ANY SOLUTION TO THIS

// build callback url
$callbackUrl = 'https://yourapp.com?token='  . $doiDataVo->getToken();

// email and your message
$userEmail = $doiDataVo->getContentDataArray()['email]);
$text = 'Dear user, please confirm by clicking on the following link: ' . $callbackUrl;

$email = new MyEmailSolution();
$email->send($userEmail, $text);
```

#### Validating a Doi

If the user comes back via a callback link you could use the following code to validate the ```Doi```:

```php
require __DIR__ . '/vendor/autoload.php';

// Doi instance with database handler
$doi = new \Simplon\Doi\Doi(
    new \Sample\Handler\SampleDatabaseHandler()
);

// get token from GET param
$token = $_GET['token']; // Pqb2UgtHG0MgIDgI

// validate
$doiDataVo = $doi->validate($token); // throws DoiException or returns DoiDataVo
```

#### Validation options

```php
// validation has to be within a given time frame
$doiDataVo = $doi->validate($token, 2); // has to be within 2 hours; default: 24 hours

// figure how much time is left until token expires
$doiDataVo->getTimeOutLeft(); // returns amount in seconds
$doiDataVo->getTimeOutLeft(2); // run against time limit of 2 hours

// is token timed out?
$doiDataVo->isTimedOut(); // returns true/false
$doiDataVo->isTimedOut(2); // run against time limit of 2 hours

// is this token still usable? takes time and state of token into account
$doiDataVo->isUsable(); // true if state is 0 and not timed out
$doiDataVo->isUsable(2); // run against time limit of 2 hours
```

-------------------------------------------------

### Setup: Database handler

A very rough abstraction of a sample database handler.

```php
class SampleDatabaseHandler implements DoiDatabaseInterface
{
    /**
     * @var string
     */
    private $databaseName = 'testing';

    /**
     * @var string
     */
    private $tableName = 'simplon_doi';

    /**
     * @return resource
     */
    private $dbh;

    /**
     * @param DoiDataVoInterface $doiDataVo
     *
     * @return bool
     */
    public function save(DoiDataVoInterface $doiDataVo)
    {
    	// write data to database
    }

    /**
     * @param $token
     *
     * @return bool|(DoiDataVo
     */
    public function fetch($token)
    {
    	// fetch data from database
    }

    /**
     * @param DoiDataVoInterface $doiDataVo
     *
     * @return bool
     */
    public function update(DoiDataVoInterface $doiDataVo)
    {
    	// update data on existing entry
    }

    /**
     * @return resource
     */
    private function getDbh()
    {
        if ($this->dbh === null)
        {
            $this->dbh = mysql_connect('localhost', 'rootuser', 'rootuser');
            mysql_query('use ' . $this->databaseName, $this->dbh);
        }

        return $this->dbh;
    }
}
```

-------------------------------------------------

# License

Cirrus is freely distributable under the terms of the MIT license.

Copyright (c) 2015 Tino Ehrich ([tino@bigpun.me](mailto:tino@bigpun.me))

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
