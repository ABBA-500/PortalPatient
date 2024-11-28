use dantist;
#1. **Получение списка всех пациентов с их врачами и доступными датами приема:**
   SELECT 
       u.FIO AS patient_name, 
       d.FIO_doc AS doctor_name, 
       da.day_month 
   FROM 
       patients p
   JOIN 
       users u ON p.patient_id = u.user_id
   JOIN 
       doctors d ON p.doctor_id = d.doctor_id
   JOIN 
       date_accessible da ON p.date_id = da.date_id;
#2. **Подсчет количества пациентов для каждого врача:**
   SELECT 
       d.FIO_doc, 
       COUNT(p.patient_id) AS patient_count 
   FROM 
       doctors d
   LEFT JOIN 
       patients p ON d.doctor_id = p.doctor_id
   GROUP BY 
       d.FIO_doc;
#3. **Получение списка всех врачей, которые не имеют назначений:**
   SELECT 
       d.FIO_doc, 
       d.specialisation 
   FROM 
       doctors d
   LEFT JOIN 
       patients p ON d.doctor_id = p.doctor_id
   WHERE 
       p.patient_id IS NULL;
#4. **Получение информации о пациенте и его назначениях по номеру телефона:**
   SELECT 
       u.FIO AS patient_name, 
       d.FIO_doc AS doctor_name, 
       da.day_month 
   FROM 
       users u
   JOIN 
       patients p ON u.user_id = p.patient_id
   JOIN 
       doctors d ON p.doctor_id = d.doctor_id
   JOIN 
       date_accessible da ON p.date_id = da.date_id
   WHERE 
       u.phone_number like '89%';
#5. **Получение всех врачей с их специализациями и количеством записей на прием:**
   SELECT 
       d.FIO_doc, 
       d.specialisation, 
       COUNT(p.patient_id) AS appointment_count 
   FROM 
       doctors d
   LEFT JOIN 
       patients p ON d.doctor_id = p.doctor_id
   GROUP BY 
       d.FIO_doc, d.specialisation;
#6. **Получение списка всех пациентов, которые записаны на прием к врачу с определенной специализацией:**
   SELECT 
       u.FIO AS patient_name 
   FROM 
       patients p
   JOIN 
       users u ON p.patient_id = u.user_id
   JOIN 
       doctors d ON p.doctor_id = d.doctor_id
   WHERE 
       d.specialisation = 'Терапевт';
#7. **Получение информации о всех пользователях, которые записаны на прием в определенный день:**
    SELECT 
        u.FIO AS patient_name, 
        d.FIO_doc AS doctor_name 
    FROM 
        patients p
    JOIN 
        users u ON p.patient_id = u.user_id
    JOIN 
        doctors d ON p.doctor_id = d.doctor_id
    JOIN 
        date_accessible da ON p.date_id = da.date_id
    WHERE 
        da.day_month = '14.01';