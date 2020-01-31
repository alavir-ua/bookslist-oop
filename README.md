[![Open Source Love](https://badges.frapsoft.com/os/v1/open-source.svg?v=103)](https://github.com/ellerbrock/open-source-badges/)

# Simple demo MVC PHP bookstore  

## Getting Started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

## Prerequisites
What things you need to install the software.

- Git.
- PHP.
- MySQL.
- XAMPP (or another local server).
- IDE (or code editor).

## Install
Clone the git repository on your computer
```
$ git clone https://github.com/alavir-ua/bookslist.git
```
You can also download the entire repository as a zip file and unpack in on your computer if you do not have git.

Restore database from file db_dump.sql


## Set environment keys
1.Edit file /config/db_params.php according to your values.
```
'host' => 'DB_HOST',
'dbname' => 'DB_DATABASE',
'user' => 'DB_USERNAME',
'password' => 'DB_PASSWORD',
```
2.Edit file /config/smtp.php according to your values.
```
'host' => 'MAIL_HOST',
'smtp_name' => 'MAIL_USERNAME',
'password' => 'MAIL_PASSWORD',
'secure' => 'MAIL_ENCRYPTION',
'port' => 'MAIL_PORT',
'admin_mail' => 'MAIL_ADMIN',
```
## Run the application

Open a web browser and launch the application according to your settings.

## Links
[Live Demo](http://bookslist.is-best.net/)
