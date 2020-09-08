CREATE DATABASE subcall;
CREATE TABLE subcall.account(
number INT AUTO_INCREMENT PRIMARY KEY,
mail_address VARCHAR(100),
name VARCHAR(30),
pass VARCHAR(64),
bone VARCHAR(10),
country VARCHAR(10),
gender VARCHAR(3),
image VARCHAR(300));

CREATE TABLE subcall.friendlist(
user_number INT,
friend_number INT,
flag BOOLEAN DEFAULT 0);

INSERT INTO subcall.account(mail_address,name,pass)VALUES
('aaa@gmail.com','testA','07480fb9e85b9396af06f006cf1c95024af2531c65fb505cfbd0add1e2f31573'),
('bbb@gmail.com','testB','07480fb9e85b9396af06f006cf1c95024af2531c65fb505cfbd0add1e2f31573'),
('ccc@gmail.com','testC','07480fb9e85b9396af06f006cf1c95024af2531c65fb505cfbd0add1e2f31573'),
('ddd@gmail.com','testD','07480fb9e85b9396af06f006cf1c95024af2531c65fb505cfbd0add1e2f31573'),
('eee@gmail.com','testE','07480fb9e85b9396af06f006cf1c95024af2531c65fb505cfbd0add1e2f31573');

CREATE TABLE subcall.Invitation(
inv_id INT AUTO_INCREMENT PRIMARY KEY,
host_name VARCHAR(30),
inv_name VARCHAR(30),
room_name VARCHAR(20));


パスワード:Test1234
