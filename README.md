## Project file tree
```
project_root/
├── composer.json    	# Composer dependencies
├── composer.lock    	# Dependency versions
├── README.md        	# Project documentation
├── site/            	# Main application files
│   ├── css/         	# Stylesheets
│   ├── images/      	# Assets (logos, product images, etc.)
│   ├── include/     	# Shared components (footer, navbar)
├── sql/             	# Database schema
├── utils/           	# Utilities (diagrams, config files)
├── vendor/          	# Composer-managed dependencies
└── docs/            	# Documentation and guides
```

## PowerPoint
[[https://uofmacau-my.sharepoint.com/:p:/g/personal/dc22767_um_edu_mo/ERHar6QEt4lJkzUG4NDcF_cBRDq6JCI6EK1OTgCa6q_fKw?e=aNy0zj]]

## Project Report
[[]]

## Install Instrctions
### Configure composer
1. Install composer
2. Open terminal with this directory
3. Enter the following in the terminal
```
composer install
```

### Database
Ensure the following in the phpMyAdmain
```
servername = "localhost";
username = "root";
password = "";
```
If not, please config accordingly in [[site/connection.php]]
1. [[project_database.sql]] file is available for the initial setup for the database
2. In phpMyAdmain, create a database called 'goods'
3. Execute the [[project_database.sql]] script in the 'goods' database
