USE cybermagicians;


INSERT INTO user(userID,email,Fname,Lname,institution,phoneNum,type,password) VALUES ('1','cmurton0@angelfire.com','Cissiee','Murton','orci pede venenatis','5529219980','tristique tortor eu','cZ0!_U>GY>');
INSERT INTO user(userID,email,Fname,Lname,institution,phoneNum,type,password) VALUES ('2','tesby1@npr.org','Tomi','Esby','eleifend donec','9287698405','augue aliquam','uB0{&19f|=LFRZp');
INSERT INTO user(userID,email,Fname,Lname,institution,phoneNum,type,password) VALUES ('3','kdomican2@shop-pro.jp','Karalee','Domican','donec posuere metus','7421020114','consequat varius integer','tB5(6>IxE&');
INSERT INTO user(userID,email,Fname,Lname,institution,phoneNum,type,password) VALUES ('4','mrippingale3@admin.ch','Marcelia','Rippingale','rutrum nulla tellus','6507598372','in tempus sit','pL2<y5|<k4m0"RgC');
INSERT INTO user(userID,email,Fname,Lname,institution,phoneNum,type,password) VALUES ('5','bfarnill4@i2i.jp','Bobbie','Farnill','adipiscing molestie','4996849867','ligula vehicula consequat','aV2&$>=,gv');
INSERT INTO user(userID,email,Fname,Lname,institution,phoneNum,type,password) VALUES ('6','gcaldecot5@cargocollective.com','Gail','Caldecot','ultrices enim','6307958414','duis bibendum felis','sM0<>CRLI5JQ~<>');
INSERT INTO user(userID,email,Fname,Lname,institution,phoneNum,type,password) VALUES ('7','kogavin6@noaa.gov','Katleen','O''Gavin','nulla mollis molestie','2101547470','orci luctus et','eD6!''*w<,%+');
INSERT INTO user(userID,email,Fname,Lname,institution,phoneNum,type,password) VALUES ('8','astratten7@ezinearticles.com','Alyse','Stratten','integer pede justo','3426935442','tortor risus dapibus','yA1}|IT&ZrG8dQ=v');
INSERT INTO user(userID,email,Fname,Lname,institution,phoneNum,type,password) VALUES ('9','ebarrand8@amazon.de','Estel','Barrand','id luctus','2368094526','ipsum dolor','tP3|Az0CxrA');
INSERT INTO user(userID,email,Fname,Lname,institution,phoneNum,type,password) VALUES ('10','gportugal9@scientificamerican.com','Genevra','Portugal','est phasellus sit','9534034900','eget','aY1)b8/4SR7WvU');

INSERT INTO venue(venID,address,venueName) VALUES (1,'51 Stephen Center','Eayo');
INSERT INTO venue(venID,address,venueName) VALUES (2,'95253 Morning Lane','Zoonoodle');
INSERT INTO venue(venID,address,venueName) VALUES (3,'11082 Spenser Circle','Realpoint');
INSERT INTO venue(venID,address,venueName) VALUES (4,'40056 Amoth Drive','Chatterbridge');

INSERT INTO university(uniID,uniName) VALUES (1,'Santa Barbara City College');
INSERT INTO university(uniID,uniName) VALUES (2,'Cal State Fullerton');
INSERT INTO university(uniID,uniName) VALUES (3,'UC Irvine');
INSERT INTO university(uniID,uniName) VALUES (4,'UC Los Angeles');

INSERT INTO sponsor(sponsorID,sponsorName) VALUES (1,'Riffpedia');
INSERT INTO sponsor(sponsorID,sponsorName) VALUES (2,'Babbleset');
INSERT INTO sponsor(sponsorID,sponsorName) VALUES (3,'Kazio');
INSERT INTO sponsor(sponsorID,sponsorName) VALUES (4,'Zooxo');

INSERT INTO keynote_speaker(speakerID,speakerName) VALUES (1,'Johnny');

INSERT INTO _event(eventID,eventName,published,description,startTime,endTime,capacity,eventType,uniID,venID,sponsorID,organizerID,speakerID) VALUES (1,'Veribet','Fully-configurable','Integer a nibh. In quis justo. Maecenas rhoncus aliquam lacus.','6/24/2023','7/6/2023',5779,'modular',3,4,4,5,1);
INSERT INTO _event(eventID,eventName,published,description,startTime,endTime,capacity,eventType,uniID,venID,sponsorID,organizerID,speakerID) VALUES (2,'Flexidy','Compatible','Praesent id massa id nisl venenatis lacinia.','8/15/2023','5/27/2023',716,'Cloned',2,4,3,5,1);
INSERT INTO _event(eventID,eventName,published,description,startTime,endTime,capacity,eventType,uniID,venID,sponsorID,organizerID,speakerID) VALUES (3,'Stringtough','Mandatory','Morbi ut odio. Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim.','9/3/2023','3/17/2023',9133,'Optional',2,2,1,4,1);
