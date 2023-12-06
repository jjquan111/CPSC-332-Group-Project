USE cybermagicians;

LOAD DATA INFILE '../../htdocs/CPSC-332-Group-Project/Data/user.csv' INTO TABLE user
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n' -- or \r\n
IGNORE 1 LINES
(userID,email,Fname,Lname,institution,phoneNum,type,password);