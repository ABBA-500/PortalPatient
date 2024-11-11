use dantist;
select * from time_accessible; 
insert into time_accessible(time_of_day) values("10:00"), ("12:00"), ("14:00"), ("16:00"), ("18:00");
delete from time_accessible where time_id > 5;

alter table users
add unique(phone_number);
insert into users(FIO, phone_number, email) values 
("Иван Иванович Дрозд", "89876543210", "mymail@mail.ru"), 
("Пётр Сергеевич Конь", "81234567890", "notmymail@gmail.com"),
("Дмитрий Александрович Петров", "89123456780", "rabochaya_pochta@yandex.ru");
select * from users; 

select * from date_accessible; 
insert into date_accessible(day_month, time_id) values 
("10.01", 4), ("10.01", 5), ("13.01", 2), ("13.01", 3), ("13.01", 4), ("14.01", 1), ("14.01", 2), ("14.01", 3), ("14.01", 4), ("14.01", 5);

alter table doctors
add unique(FIO_doc);
insert into doctors(FIO_doc, specialisation) values 
("Александр Иванович Лекарев", "Терапевт"), ("Алексей Петрович Коновалов", "Хирург"), ("Сергей Викторович Зуболомов", "Ортодонт");
select FIO_doc from doctors; 

insert into patients(patient_id, doctor_id, date_id) values (1, 1, 4), (2, 1, 10);
desc patients;
select * from time_accessible; 
select * from users; 
select * from date_accessible; 
select * from doctors; 
select * from patients;
select FIO_doc from doctors where doctor_id = (select doctor_id from patients where priem_id = 2);
select time_of_day from time_accessible where time_id = (
select time_id from date_accessible where date_id = (
select date_id from patients where priem_id = 1));