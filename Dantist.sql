create database IF not exists dantist;
use dantist;

#drop table if exists patients;

#drop table if exists users;

create table if not exists users(
user_id int auto_increment primary key,
FIO varchar(128) not null, 
phone_number varchar(11) not null, 
email varchar(64)
);

drop table if exists date_accessible;

create table if not exists date_accessible(
date_id int primary key, 
day_month varchar(5), 
day_name varchar(11), 
time_id int not null);

#drop table if exists doctors;

create table if not exists doctors(
doctor_id integer auto_increment primary key, 
FIO_doc varchar(128), 
specialisation varchar(32),
date_id int not null);

#drop table if exists time_accessible;

create table if not exists time_accessible(
time_id integer auto_increment primary key, 
time_of_day time);

create table if not exists patients(
priem_id int auto_increment primary key,
patient_id integer not null unique, 
doctor_id int not null, 
date_id int not null, 
time_id int not null,
constraint fk_patient_id
foreign key(patient_id) references users(user_id),
constraint fk_date_id
foreign key(date_id) references date_accessible(date_id),
constraint fk_doctor_id
foreign key(doctor_id) references doctors(doctor_id),
constraint fk_time_id
foreign key(time_id) references time_accessible(time_id));

#insert into date_accessible(date_id, day_month, day_name) values (1, "01.01", "wednesday");

#alter table patients 
#add constraint fk_date_id
#foreign key(date_id) references date_accessible(date_id);
