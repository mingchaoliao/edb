# Admin Document

## Installation

### Server Requirements

 - PHP >= 7.0.0
   - OpenSSL PHP Extension
   - PDO PHP Extension
   - Mbstring PHP Extension
   - Tokenizer PHP Extension
   - XML PHP Extension
 - [composer](https://getcomposer.org/)
 - Apache Web Server
   - this project is configured for Apache web server. It is possible to deploy this project to a Nginx web server. If you are using Nginx, the following directive in your site configuration will direct all requests to the `index.php` front controller:
       ```bash
       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }
       ```
 - MySQL >= 5.6
 
### Download Application Package

clone project folder to local machine (server)

```bash
git clone https://github.com/mingchaoliao/edb.git edb-src
```

get into project folder

```bash
cd edb-src
```

make `artisan` executable

```bash
chmod 777 artisan
```

download dependencies

```bash
composer update
```

### Configuration

make a copy of `.env.example` and name it to `.env`

```bash
cp .env.example .env
```

generate application key (do not re-generate key for server migration)

```bash
php artisan key:generate
```

create database in MySQL (user `root` account, or account with certain privilege)

```sql
DREATE DATABASE <database name>;
```

open `.env` file

 - change `DB_HOST` to the MySQL server address (ip address)
 - change `DB_DATABASE` to the name of database created in previous step
 - change `DB_USERNAME` to the database user name you wanted to use
   - if you want to create a new database user (using `root` account)
     - create user
       ```sql
       CREATE USER '<username>'@'localhost' IDENTIFIED BY '<password>';
       ```
     - grant user with access to the application database
       ```sql
       GRANT ALL PRIVILEGES ON <database name created in previous step> . * TO '<username created in previous step>'@'localhost';
       ```
     - reload all the privileges
       ```sql
       FLUSH PRIVILEGES;
       ```
 - change `DB_PASSWORD` to password of corresponding user
 - change `APP_ADMIN_NAME` to one of administrator name
 - change `APP_ADMIN_EMAIL` to email of administrator
 - change `DUMP_BINARY_PATH` to path of directory which contains binay file: mysqldump, in ubuntu, it's in `/usr/bin`

```bash
APP_ENV=local
APP_KEY=<application key generated from previous step>
APP_DEBUG=false
APP_LOG_LEVEL=debug
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=<server host name / IP address, e.g. loclhost>
DB_PORT=3306
DB_DATABASE=<database name>
DB_USERNAME=<database username>
DB_PASSWORD=<database password>

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

APP_ADMIN_NAME=<admin name>
APP_ADMIN_EMAIL=<admin email>

DUMP_BINARY_PATH=<path of directory which contains binay file: mysqldump, in ubuntu, it's in /usr/bin>
```

### Create Database Table With Pre-filled Data

```bash
php artisan migrate
```

note: after executing this command, a default super administrator account have been created.

 - email: `admin@localhost`
 - password: same as value of `APP_KEY` in `.env` file

### Make Current User Have Access To Application Folder (For Apache Web Server)

get current user

```bash
whoami
```

figure out default group for web content (in Ubuntu and Debian is `www-data`)

add current user to web group
```bash
sudo usermod -a -G www-data <current user>
sudo chgrp -R www-data /var/www
sudo chmod -R g+w /var/www
sudo find /var/www -type d -exec chmod 2775 {} \;
sudo find /var/www -type f -exec chmod ug+rw {} \;
```

### Create Symlink For Accessing Application

```bash
ln -s /path/to/edb-src/public /path/to/application_name
```

## Database Management

Warning: modifying raw databse is not recommended. Modifying ONLY when necessary !

### Tables

 - `migrations`: used to manage table migrations
   - DANGER: DO NOT MODIFY THIS TABLE !
 - password_resets
   - used to reset user password
   - Note: this table is currently not being used
   - DANGER: DO NOT MODIFY THIS TABLE !
 - `requests`: store creation/modification requests (requested by contributors) which need administrators/researchers to approve/deny
 - `roles`: store user roles
   - 1 -> administrator
   - 2 -> researcher
   - 3 -> contributor
   - 4 -> guest
   - DANGER: DO NOT MODIFY THIS TABLE !
 - `schemes`: store schema of species 
   - DANGER: DO NOT MODIFY THIS TABLE !
 - `species`: store species data (with version)
 - `users`: store user information
   - Warning: Do not delete user. Instead, changing has_deleted to 1
   
## Feature List

 - Login Required
 - User can view all species and view all unapproved species
 - User can use the Search bar to Search by Species Name
 - User can use the Advanced Search to Search by other fields
 - User can create new species by clicking “Actions”, and click “Add Species” (the new species will not be approved)
 - User can delete species without approval
 - User can view the history of each field by clicking “Show History Buttons”, and click the history button icon that appears next to each field
 - User can view changes to species made by Contributor by clicking “Actions” and click “Approval Page” and click “View”
 - User can approve changes to species made by Contributor by clicking “Actions” and click “Approval Page” and click “Approve”
 - User can deny changes to species made by Contributor by clicking “Actions” and click “Approval Page” and click “Deny”
 - User can edit their name, email, and password by clicking on their name in the top right corner, and click “Profile”
 - User can change name, password and security role for each user by clicking “Actions” and click “User Management” and click "Edit" button for a specific user, or click “Delete” to soft remove that user
 - User can import data by clicking “Actions” and click “Data Import” and upload a file using the instructions on the page
 - User can backup data by clicking “Actions” and click “Backup” and click “Create New Backup”
 - User can view an Administrator Document by clicking “Docs” and click “Admin Document”
   
## Miami SSO (CAS)

Any **https** service with a domain name ending in **muohio.edu** or **miamioh.edu** can use CAS for single-sign on without further configuration on the CAS server.  If the service is not https/miamioh, Please contact university IT for help.