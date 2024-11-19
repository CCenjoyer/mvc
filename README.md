# MVC Repo

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/CCenjoyer/mvc/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/CCenjoyer/mvc/?branch=main) [![Code Coverage](https://scrutinizer-ci.com/g/CCenjoyer/mvc/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/CCenjoyer/mvc/?branch=main) [![Build Status](https://scrutinizer-ci.com/g/CCenjoyer/mvc/badges/build.png?b=main)](https://scrutinizer-ci.com/g/CCenjoyer/mvc/build-status/main) [![Code Intelligence Status](https://scrutinizer-ci.com/g/CCenjoyer/mvc/badges/code-intelligence.svg?b=main)](https://scrutinizer-ci.com/code-intelligence)

![Glider](public/img/glider.svg)

## About
- This repository provides a website utilizing Composer as a dependency manager and Symfony as a PHP web application framework.

- Source:
This project was created following this article:
https://github.com/dbwebb-se/mvc/tree/main/example/symfony


## Project Setup Instructions

Thank you for checking out my Symfony project! Follow the steps below to set it up on your local machine.

### Requirements:
- npm >= 10.1.0
- PHP >= 8.3.4
- Composer >= 2.2.6

### Installation Steps:

1. **Clone the project repository from GitHub:**
- bash
git clone https://github.com/ccenjoyer/mvc.git

2. **Navigate to the project directory:**
- bash
cd your-symfony-project


3. **Install dependencies using Composer:**
- bash
composer install
composer require symfony/webpack-encore-bundle
npm install

4. **While in project directory:**
- bash
php -S localhost:8888 -t public

- Project should now be available on localport 8888,
http://127.0.0.1:8888/


### Problems
For any clarification of the installation process you may want to check out the original instructions for the site:
https://github.com/dbwebb-se/mvc/tree/main/example/symfony