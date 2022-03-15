[![Build Status](https://api.travis-ci.com/ndlaprovidence/self-feedback1.svg?branch=main)](https://travis-ci.com/ndlaprovidence/self-feedback1)

# __**Feedback self**__

### This software was created by IT student's who have an advanced technician's certificate in programming,and you can use for free this software who is under MIT licence

#### this one use the framework symfony on composer with language PHP
---------------------------
## **Installation**

 1. In a first time you should clone the github repository at : [Feedback self](https://github.com/ndlaprovidence/self-feedback1 "software of rating")

1. In php.ini activate the extension :
 >- PDO_mysql
 >- gd2
 >- fileinfo 
3. On the computer install nodeJS at :   [NodeJS](https://nodejs.org)

1. Do composer install 

1. Execute in directory of project :
>- npm install
>- npm run build

6. Edit the file with the name .ENV
>- In the document you write the needed database informations

7. Edit adresse.php with the domaine name of your web site :
>- In /src you can find the fille with the name adresse-sample.php
>- copy and rename this file in adresse.php and write the domaine name with / in end
>- Like this : www.exemple.com/

8. Run the commands below :
>- php bin/console doctrine:database:create
>- php bin/console make:migration
>- php bin/console doctrine:migrations:migrate

9. Do the command for created the default user :
>- php bin/console doctrine:fixtures:load

10. Enjoy the software !


