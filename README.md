# ELIDEK
This repository contains the project developed for the Databases Course at ECE NTUA.

## Dependencies:

    • Apache Web Server
    • MySQL 
    • PHP

## Detailed application installation steps

The application is developed for **Linux OS** (user must have *sudo* privileges)

#### Comprehensive installation instructions for setting up the LAMP stack are available at the following link:
https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-20-04
 
#### Database installation
The **ELIDEK_DDL.sql** file contains the complete code to create the schema and define the necessary constraints, including *tables*, *triggers*, *views*, and *indexes*. The data will be populated using the **dummy_data.sql** file. Both files can be found in the `elidek_db` folder.
After downloading the files (assuming they are stored in the `db_directory`), open **MySQL** and then execute the following commands in the terminal:
```
mysql> source db_directory/ELIDEK_DDL.sql
mysql> source db_directory/dummy_data.sql
```

#### Apache localhost configuration
The final step before running the application is to copy all files from the `web_app` folder (from the GitHub repository) to the ```/var/www/html``` directory. If an **index.php** file already exists in that directory, it should be replaced with the new **index.php** file. Additionally, if there is an index.html file in the directory, it must be removed.
