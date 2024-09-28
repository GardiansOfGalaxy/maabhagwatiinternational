#### Step 1: To download all required library
php composer.phar update

#### Step 2: To generate tmp, logs and app_local.php
php composer.phar install

####  Step 3 : Create new database in mysql from cms.sql file

####  Step 4: Update the username, password and database name in app_local.php for database connection

####  Step 5: Run Project

php bin/cake.php server

####  Step 6: Open below url in browser

http://localhost:8765/

####  Step 7: Enter below username and password

Email : admin@test.com
Password: admin@1234


#### Step 8 : To get token to access your site use below given details.

Url: http://localhost:8765/api/users/token.json
Method: POST
Post Data :
{
"username":"admin",
"password":"admin@1234"
}

Response:
{
"success": true,
"data": {
"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJteWFwcCIsInN1YiI6MSwiZXhwIjoxNjA5NzczOTkzfQ.02xrrQ-1oNnVeUCTvTiS1EpuoRQgQuTiNBuyEubW3uEvOoVA6TAnAykh0W-t2ge2CfaqbXdAslhAbGM7vQUeZpqeBJvsZQv7Hf7wsK3qN8aHV7bIB1MnZtPHUzgeX7p576Smdz73-eZmkRTvEMymA6jhv5g3IxWhiFUC3LXkaaU"
}
}

#### Step 9 : Make sure you generate your own jwt.key and jwt.pem file via below command

##### generate private key
openssl genrsa -out config/jwt.key 1024
##### generate public key
openssl rsa -in config/jwt.key -outform PEM -pubout -out config/jwt.pem
