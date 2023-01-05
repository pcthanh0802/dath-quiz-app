# Online Quiz Application

## Introduction

This application is the Programming Integration Project of group 2 guided by Mr. Trương Tuấn Anh. Our group consists of the following members:

1. Phạm Hữu Đức (2052452)
2. Nguyễn Viết Hòa (2052486)
3. Phạm Thị Thái Minh (2052174)
4. Phạm Châu Thanh (2052254)

## Installation tutorial

Since we do not deploy this web application on a remote host server, please follow this step in order to run our work locally on your computer:

1. Download and install XAMPP
2. Download the source code from our Github repository (Download ZIP), extract the ZIP file, change the folder name to quizApp and move it into xampp/htdocs folder **(The source code folder must be stored here to run, other directories are not allowed.)**
3. Open XAMPP control panel.
4. Click "Config" of MySQL, then click my.ini. A text editor appears on the screen. Change the port from 3306 to **3307** (use Ctrl+H, fill the find part with "3306" and the replace with part with "3307"), save the file and close it.
5. Click "Config" of Apache, choose phpMyAdmin. A text editor appears on the screen. Change the '127.0.0.1' to 'localhost:3307' in `$cfg['Servers'][$i]['host']` (right under the line "`/* Bind to the localhost ipv4 address and tcp */`")
6. Click "Start" for Apache and MySQL, then click "Admin" button of MySQL to go to its dashboard
7. Create a database and named it "quizApp"
8. Import db.sql file to create the database
9. Open your web browser and type http://localhost/quizApp/index.php in the url bar to start the quiz app
10. Log in to start using
    - Try **username: admin** and **password: Admin0123** to log in admin page.
    - Try **username: hihihi** and **password: hihihi** to log in player page.
      You can also create new account to log in by insert new record into **account table** in database.

**Note:** role = 1 means admin, role = 0 means player.

**If you have correctly followed the above steps then the web app should run perfectly fine on your computer.**
