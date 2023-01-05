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
3. Open XAMPP control panel and turn on Apache and MySQL
4. Click "Admin" button of MySQL to go to its dashboard
5. Create a database and named it "quizApp"
6. Import db.sql file to create the database
7. Open your web browser and type http://localhost/quizApp/index.php in the url bar to start the quiz app
8. Log in to start using
   - Try **username: admin** and **password: Admin0123** to log in admin page.
   - Try **username: hihihi** and **password: hihihi** to log in player page.
     You can also create new account to log in by insert new record into **account table** in database.

**Note:** role = 1 means admin, role = 0 means player.

**If you have correctly followed the above steps then the web app should run perfectly fine on your computer.**
