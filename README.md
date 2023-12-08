# CPSC-332-Group-Project
## Fall 2023 Project Instructions

### Instructor: Hokseng Hun

#### Setup

Open the Shell from the XAMPP control panel and run: mysql --user=root --password=""

Within the mysql prompt, run GRANT ALL PRIVILEGES on *.* TO 'root'@'localhost'; FLUSH PRIVILEGES;

We need to point apached to our folder, pick one of 2:
1) Alias
Open the Apache Config file (httpd.conf) from XAMPP, and add an alias to the path where this project's cgi-bin folder lives.

Then, open the Apache Config file (httpd.conf), and add an alias to the directory.

2) Direct Copy
Find your default apache cgi-bin folder, make a copy into it so it's like

Alias /CPSC-332-Group-Project "directory to htdocs in sample code (using forward slash)"
<Directory "directory to htdocs in sample code (using forward slash)">
    AllowOverride All
    Require all granted
</Directory>


### Project Overview
Students are required to work in groups to develop a database application project, specifically an online survey application for a client. The project involves building an ER Diagram, Relational Model, normalizing the database, building a physical model, populating the database with sample data, and creating a demo application in PHP and MySQL.

### Client Business Requirements
The client, Academic Event Management Company (AEM), requires an online event management system that includes a database and a web application to manage events for multiple universities.

### Business Rules
1. The system must manage multiple events simultaneously with specific requirements for users, events, and abstracts.
2. Details on user registration, event information, organizer roles, reviewer roles, and abstract submission process.

### Submission Requirements
- SQL script for database creation.
- Sample data.
- Specific VIEWs to be created as per the guidelines.
- ER Diagram and Relational Model submission for Part A.
- Development files, presentation, and final report for Part B.

### Extra Credit Options
Opportunities for extra credit include additional functionalities and a professional website appearance.

### Grading and Peer Evaluation
Grades will be based on individual contributions as reviewed by group members. There are specific guidelines for grading and peer evaluations.

### Submission Method
All submissions must be made via Canvas. Email submissions will not be accepted.

### Project Parts
- **Part A**: ER Diagram and Relational Model [40 points]
- **Part B**: Development files, presentation, and final report [60 points]
- **Presentations**: [25 points] (No live presentation required, but submission must demonstrate functionality)
- **Extra Credit**: [5 points] for implementing optional features.

### Conclusion
This document provides a comprehensive guide for the project requirements, submission guidelines, and evaluation criteria.

