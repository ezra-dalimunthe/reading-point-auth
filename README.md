# READING POINT AUTH

This is example of authentication service. 

## Instalation (to be updated)

The application is using mariadb dbms that run on docker host as I dont want to run a mariadb in a docker container since this application is for education purpose. For that, you need to create a new blank database on mariadb instance (prefered name : __reading_point_auth__ ), mariadb user (prefered name : __'reading_point_auth_user'@'%'__) with password __unpri2022__. 

### prepare the database.

1. Login to database server
```
$ sudo mysql -uroot -p
```
2. Create database (after successful login to mariadb)
```
MariaDB [(none)]> CREATE DATABASE reading_point_auth;
```
3. Create user
```
MariaDB [(none)]> CREATE USER reading_point_auth_user@'%' IDENTIFIED BY 'unpri2022';
```
4. Grant access to reading_point_auth 
```
MariaDB [(none)]> GRANT ALL PRIVILEGES ON reading_point_auth.* TO reading_point_auth_user@'%' ;
```
5. Flush privileges
```
MariaDB [(none)]> FLUSH PRIVILEGES;
```

### Build image and run container

1. Clone repository 
   
```
$ git clone https://github.com/ezra-dalimunthe/reading-point-auth
```

2. Make sure you are on root folder
   
```
$ cd reading-point-auth
```

4. Run docker-compose

```
$ docker-compose up --build -d
```

5. Install library (if docker-compose run succesfully,the created  container name is __reading-point-auth-service__)

```
$ docker exec -it reading-point-auth-service composer install
```

6. Run database migration

```
$ docker exec -it reading-point-auth-service php artisan migrate
```

7. Open browser and navigate to http://127.0.0.1:8906/api/docs

8. Use Swagger UI to test the end points.

