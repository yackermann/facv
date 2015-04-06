Kreved.co - The notice board
====

## Vagrant
### Includes
 * Ubuntu Server 14.04.1
 * PHP 5.5.9
 * MySQL
    + PHPMyAdmin
 * Apache 2

### Reqiurements

 * [VirtualBox](https://www.virtualbox.org/wiki/Downloads)
 * [Vagrant](https://www.vagrantup.com/downloads.html)

### Installation
 
 * Install [VirtualBox](https://www.virtualbox.org/wiki/Downloads) and [Vagrant](https://www.vagrantup.com/downloads.html).
 * `git clone` this repository.
 * `vagrant up` to build a dev environment. This might take 5min - 10min, so make your self a cup of tea, and enjoy.

### Development

 * You php code goes to `www` folder
 * Navigate to [http://192.168.55.55](http://192.168.55.55) to access server.
 * PHPMyAdmin [http://192.168.55.55/phpmyadmin](http://192.168.55.55/phpmyadmin).
 * If you need to tweak Ubuntu server `vagrant ssh`.
 * Have fun.

## API

### `adverts.php`
 + Requests: 
 + Response:
    + MIME: `application/json`
    + Structure:
    ```js
    {
        "status": 200/404,
        "adverts": [
            {
                "id": Integer,
                "title": String,
                "text": String,
                "startDate": Date,
                "endDate": Date,
                "categoryId": Integer,
                "image": String,
                "email": String,
                "phone": String
            },
            ...
        ]
    }
    ```

### Server API responses 

#### General responses
 + 200 - OK

#### Adverts responses
 + 412 - Validation failed
 + 429 - Client reached maximum adverts per day
 
#### Authentication
 + 511 - Username and/or password are wrong

#### Server errors
##### SQL
 + 500 - SQL error
 + 503 - Error while connecting to SQL server
