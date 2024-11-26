create database IF not exists dantist;
use dantist;

#drop table if exists patients;
#drop table if exists time_accessible;
#drop table if exists users;
#drop table if exists doctors;
#drop table if exists date_accessible;

##################
#Создание таблиц#
##################

create table if not exists users(
user_id int auto_increment primary key,
FIO varchar(128) not null, 
phone_number varchar(11) not null, 
email varchar(64));

create table if not exists time_accessible(
time_id integer auto_increment primary key, 
time_of_day time);

create table if not exists date_accessible(
date_id int auto_increment primary key, 
day_month varchar(5), 
time_id int not null,
constraint fk_time_id
foreign key(time_id) references time_accessible(time_id));

create table if not exists doctors(
doctor_id integer auto_increment primary key, 
FIO_doc varchar(128), 
specialisation varchar(32));

create table if not exists patients(
priem_id int auto_increment primary key,
patient_id integer not null unique, 
doctor_id int not null, 
date_id int not null, 
constraint fk_patient_id
foreign key(patient_id) references users(user_id),
constraint fk_date_id
foreign key(date_id) references date_accessible(date_id) on update cascade,
constraint fk_doctor_id
foreign key(doctor_id) references doctors(doctor_id));

#alter table users add column pass varchar(64);					#Добавление столбца с паролями
#alter table users add unique unique_id(phone_number, email);	#Теперь доступны только уникальные комбинации номера и почты 

##########
#Триггеры#
##########

drop trigger hash_pass; #Надо доделать
delimiter //

create trigger hash_pass
after insert on patients
for each row
begin
create table if not exists time_taken(taken_id int primary key auto_increment, doctor_id int, date_id int, time_id int);
insert into time_taken(doctor_id, date_id, time_id) values(NEW.doctor_id, New.date_id, New.time_id);
end; //
	
delimiter ;

##################
#Заполение таблиц#
##################

insert into time_accessible(time_of_day) values("10:00:00"), ("12:00:00"), ("14:00:00"), ("16:00:00"), ("18:00:00");
delete from time_accessible where time_id > 5;

#insert into users(FIO, phone_number, email) values 
#("Иван Иванович Дрозд", "89876543210", "mymail@mail.ru"), 
#("Пётр Сергеевич Конь", "81234567890", "notmymail@gmail.com"),
#("Дмитрий Александрович Петров", "89123456780", "rabochaya_pochta@yandex.ru");

#insert into date_accessible(day_month, time_id) values 
#("10.01", 4), ("10.01", 5), ("13.01", 2), ("13.01", 3), ("13.01", 4), ("14.01", 1), ("14.01", 2), ("14.01", 3), ("14.01", 4), ("14.01", 5);

#insert into doctors(FIO_doc, specialisation) values 
#("Александр Иванович Лекарев", "Терапевт"), ("Алексей Петрович Коновалов", "Хирург"), ("Сергей Викторович Зуболомов", "Ортодонт");

#insert into patients(patient_id, doctor_id, date_id) values (1, 1, 4), (2, 1, 10);
#update users set pass = "mYpAsS564№" where FIO like "%Пётр %";