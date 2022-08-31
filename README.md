## Requirement
This project is to build application that allows a tradie to see their jobs with the information like Unique job identifier, Status: ("scheduled", "active", "invoicing", “to priced” or “completed”), creation date & time and general information like name and contact details of the client.

The tradie can also make notes for each job. A job can have any number of notes associated with 
them.The tradie should be able to perform below tasks.
• Filter and sort the list of jobs.
• Click on a job in the list to view their details and add/edit notes for that job.
• Change the status of a job.

## Author
* Sreenu Gantinapalli

## Pre-Requesites
* AWS Account Access
* EC2 Instance Creation
* RDS Database Instance Creation
* Same Security Group configuration in EC2 and RDS
* Docker Installation
* Docker Compose

## Technologies
* HTML
* CSS
* PHP 8.1.2
* AJAX
* JAVA SCRIPT

## Database
* mysql Ver 8.0.30-0ubuntu0.22.04.1 for Linux on x86_64 ((Ubuntu))

## Environment
* AWS
* RDS
* Ubuntu 5.15.0-1011-aws
* Docker

##Web Server
* Apache/2.4.52 (Ubuntu)

## Tools
* Github
* Visual Studio Code
* Git Bash
* Putty

## About the development

Use this URL (http://54.89.8.17:8000/jobs.php) to access the application, which is deployed using docker container.

	To fullfill the given requirement, A web based application is developed using PHP, Java Script, AJAX, AWS, Apache2, MYSQL and Docker
	Steps followed to develop web application using PHP and to deploy using Docker container.

	* Created EC2 Instance in AWS (EC2 Instance name: ec2-35-172-201-167.compute-1.amazonaws.com) using Ubuntu OS.
	* Created RDS Database Instance (RDS End Point : tradie-db.cmweadjdggsz.us-east-1.rds.amazonaws.com)
	* Configured same Security group in both EC2 and RDS Database Instance to talk to each other (name: DB-EC2-SG)
	* Logged in to EC2 instance via Putty
	* Installed Docker & Docker compose
		apt install docker.io -y
		apt install docker-compose
	* Created Docker file to install APACHE, PHP and MYSQL 	
	* Created YAML file : docker-compose.yaml to deploy the code files
	* Connected to MYSQL and Created 2 tables (jobs and notes) as per requirement by running below commands

			mysql -h tradie-db.cmweadjdggsz.us-east-1.rds.amazonaws.com -P 3306 -u mydb2022 -p
			show databases;
			use tradiejobs;
			show tables;
			
			mysql> show tables;
			+----------------------+
			| Tables_in_tradiejobs |
			+----------------------+
			| jobs                 |
			| notes                |
			+----------------------+

			
			mysql> describe jobs;
			+-------------------+--------------+------+-----+---------+-------+
			| Field             | Type         | Null | Key | Default | Extra |
			+-------------------+--------------+------+-----+---------+-------+
			| job_identifier    | varchar(50)  | NO   | PRI | NULL    |       |
			| status            | varchar(30)  | YES  |     | NULL    |       |
			| client_name       | varchar(40)  | YES  |     | NULL    |       |
			| client_email      | varchar(50)  | YES  |     | NULL    |       |
			| contact_details   | varchar(20)  | YES  |     | NULL    |       |
			| creation_datetime | timestamp    | NO   |     | NULL    |       |
			| address           | varchar(150) | YES  |     | NULL    |       |
			+-------------------+--------------+------+-----+---------+-------+
			
			mysql> describe notes;
			+-------------+--------------+------+-----+---------+----------------+
			| Field       | Type         | Null | Key | Default | Extra          |
			+-------------+--------------+------+-----+---------+----------------+
			| notes_id    | int          | NO   | PRI | NULL    | auto_increment |
			| description | varchar(500) | YES  |     | NULL    |                |
			| jobs_id     | varchar(50)  | YES  | MUL | NULL    |                |
			+-------------+--------------+------+-----+---------+----------------+
		
	* Developed below .php files to fullfill the given requirement 
	  1. jobs.php -> To list the jobs
	  2. notes.php -> to see specefic job details
	  3. updateStatus.php -> to update job status
	  4. updateDB.php -> to update job notes
	  5. createNotes.php -> to create new note for a job
	  6. config.ini -> to store db credentials
	  
	* Run the yaml file using below commands to execute Dockerfile and to create container and deploy the application
	  docker-compose up -d
	  
	* Below folder structure is maintained in Docker
	  /home/ubuntu/web_dev
	  - docker-compose.yaml
	  - php
		- Dockerfile
		- header.jpg
		- footer.jpg
		- jobs.php
		- updateDB.php
		- updateStatus.php
		- createNotes.php
		- config.ini
		- notes.php
	* To see the list of containers running run "docker ps -a"
	
	ubuntu@ip-172-31-16-188:~/web_dev/php$ docker ps -a
	CONTAINER ID   IMAGE         COMMAND                  CREATED       STATUS       PORTS                                                  NAMES
	2c7ad609e6c6   web_dev_web   "docker-php-entrypoi…"   2 hours ago   Up 2 hours   0.0.0.0:8000->80/tcp, :::8000->80/tcp                  php-2
	2e6fbc1bb0ea   mysql:8.0     "docker-entrypoint.s…"   2 hours ago   Up 2 hours   33060/tcp, 0.0.0.0:6034->3306/tcp, :::6034->3306/tcp   mysqldb-2

	* To go inside the containers(PHP and Mysql) run "docker exec -it <<containerid>> bash"
	
	PHP & Apache Container:
		ubuntu@ip-172-31-16-188:~/web_dev/php$ docker exec -it 2c7ad609e6c6 bash
		root@2c7ad609e6c6:/var/www/html# ls -lrt
		total 232
		-rwxrwxrwx 1 1000 1000   140 Aug 31 16:14 Dockerfile
		-rw-rw-r-- 1 1000  123 71477 Aug 31 19:37 header.jpg
		-rw-rw-r-- 1 1000  123 97126 Aug 31 19:41 footer.jpg
		-rwxrwxr-x 1 1000  123 11211 Aug 31 20:54 notes.php_bkp
		-rwxrwxr-x 1 1000 1000  6887 Aug 31 21:35 jobs.php
		-rwxrwxr-x 1 1000 1000   631 Aug 31 21:36 updateDB.php
		-rwxrwxr-x 1 1000 1000   637 Aug 31 21:36 updateStatus.php
		-rwxrwxr-x 1 1000 1000   841 Aug 31 21:37 createNotes.php
		-rwxr-xr-x 1 1000  123   140 Aug 31 21:40 config.ini
		-rwxrwxr-x 1 1000 1000 10774 Aug 31 21:42 notes.php
	
	Mysql Container:
	
		ubuntu@ip-172-31-16-188:~/web_dev/php$ docker exec -it 2e6fbc1bb0ea bash
		bash-4.4# mysql -h tradie-db.cmweadjdggsz.us-east-1.rds.amazonaws.com -P 3306 -u mydb2022 -p
		Enter password:
		Welcome to the MySQL monitor.  Commands end with ; or \g.
		Your MySQL connection id is 194
		Server version: 8.0.28 Source distribution

		Copyright (c) 2000, 2022, Oracle and/or its affiliates.

		Oracle is a registered trademark of Oracle Corporation and/or its
		affiliates. Other names may be trademarks of their respective
		owners.

		Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

		mysql> use tradiejobs
		Reading table information for completion of table and column names
		You can turn off this feature to get a quicker startup with -A

		Database changed
		mysql> show tables;
		+----------------------+
		| Tables_in_tradiejobs |
		+----------------------+
		| jobs                 |
		| notes                |
		+----------------------+
		2 rows in set (0.00 sec)

		mysql>
