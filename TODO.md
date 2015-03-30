# TODO

## Frontend

- Layout | I.P. (Niemand)
    + ~~categories tabs~~
    + ~~new item form(anonymous)~~
    + ~~alerts~~

- App    | I.P. (Niemand)
    + ~~app layout~~
    + ~~JSON API~~
    + ~~models~~
    + New advert submit
        * ~~Form~~
        * ~~Fields~~
        * ~~Client-side validation~~
        * Image upload
        * ~~POST sender~~
        * ~~Alerts~~
        * Captcha
    
    + Front end search 

- ~~Localization | I.P. (Niemand)~~
    + ~~Language detection~~
    + ~~Language set~~
    + ~~Translation arrays (JSON)~~

## Backend

 - JSON REST | I.P. (Niemand)
    - adverts.php | I.P. (Niemand)
        + ~~MySQL~~
        + ~~Categories~~
        + ~~Response Codes~~
        + ~~Timestamp sort~~
        + ~~Caching~~ CANCELED
            * ~~Pre-generate caching~~
            * ~~Cache revision number - not re-request same content.~~
    
    - post        | I.P. (Niemand)
        + ~~POST Handler~~
        + ~~SQL `add` class~~
        + ~~Server side validation~~

 - Image
    - uploading | I.P. (Fulton)
        - hashing name(MD5)
        - autoconvert($image => jpg)

 - ~~I.P. Bind~~
     + ~~Create table for ip addresses~~m     + ~~Create IP class~~
     + ~~Add restriction~~

 - Authentication
     + Login | Challenge-Response
         * Client
             - HASH(Salt, Password) POST
         * Server 
             - Login form
             - ~~Password table~~
             - ~~SQL~~
             - ~~HASH~~
     + ~~Registration~~ | Canceled

 - ~~Error Codes~~

 - Central config

## General

 - **.htaccess**
    - Request rewrite
    - Restrict folder view(no listing)

 - hating | I.P. (Fulton, Niemand)
     - JavaScript
     - PHP        | Niemand Done