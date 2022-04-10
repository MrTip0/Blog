# My blog
This is the repository of my personal blog  

### Build
clone this repository
create a keys.php file that has 2 functions  
getpublic() that return a public rsa key  
getprivate() that return a private rsa key  
getDBAccess() that returns an array with db data  
```php
<?php
function getprivate(){
    return <<<EOD
    -----BEGIN RSA PRIVATE KEY-----
    The private key
    -----END RSA PRIVATE KEY-----
    EOD;
} 
function getpublic() {
    return <<<EOD
    -----BEGIN PUBLIC KEY-----
    the public key
    -----END PUBLIC KEY-----
    EOD;
}
function getDBAccess() {
    return array(
        "host" => "localhost",
        "username" => "insert user here",
        "database" => "database name"
    );
}
?>
```
setup the database  
sh build.sh

once the server and the databases are online get the page /lib/gentables.php