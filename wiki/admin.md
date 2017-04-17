# For Administrators

## Installation

#### Server Requirements

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
 
#### Download Application Package

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

#### Configuration

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

#### Create Database Table With Pre-filled Data

```bash
php artisan migrate
```

<p style="color: #B61E2E;">note: after executing this command, a default super administrator account have been created.</p>

 - email: `admin@localhost`
 - password: same as value of `APP_KEY` in `.env` file

#### Make Current User Have Access To Application Folder (For Apache Web Server)

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

#### Create Symlink For Accessing Application

```bash
ln -s /path/to/edb-src/public /path/to/application_name
```

## Database Management

<p style="color: yellow;">Warning: modifying raw databse is not recommended. Modifying ONLY when necessary !</p>

#### Tables

 - `migrations`: used to manage table migrations
   - <p style="color: red;">DANGER: DO NOT MODIFY THIS TABLE !</p>
 - password_resets
   - used to reset user password
   - <p style="color: yellow;">Note: this table is currently not being used</p>
   - <p style="color: red;">DANGER: DO NOT MODIFY THIS TABLE !</p>
 - `requests`: store creation/modification requests (requested by contributors) which need administrators/researchers to approve/deny
 - `roles`: store user roles
   - 1 -> administrator
   - 2 -> researcher
   - 3 -> contributor
   - 4 -> guest
   - <p style="color: red;">DANGER: DO NOT MODIFY THIS TABLE !</p>
 - `schemes`: store schema of species 
   - <p style="color: red;">DANGER: DO NOT MODIFY THIS TABLE !</p>
 - `species`: store species data (with version)
 - `users`: store user information
   - <p style="color: yellow;">Warning: Do not delete user. Instead, changing has_deleted to 1</p>
   
## Miami SSO (CAS)

Any **https** service with a domain name ending in **muohio.edu** or **miamioh.edu** can use CAS for single-sign on without further configuration on the CAS server.  If the service is not https/muohio/miamioh, needs to be forced to use two-factor authentication, or needs other attributes besides username, it must be added to CAS Service Management by one of following IT people:
 - Michael Beck ([beckmd@miamioh.edu](mailto:beckmd@miamioh.edu))
 - Duane Drake ([draked@miamioh.edu](draked@miamioh.edu))
 - Don Kidd ([kidddw@miamioh.edu](kidddw@miamioh.edu))
 