-- Use Database
/* USE ics325sp2409; */

use gradebook;

DROP TABLE IF EXISTS course_feedbacks;
DROP TABLE IF EXISTS grades;
DROP TABLE IF EXISTS assessments;
DROP TABLE IF EXISTS enrollments;
DROP TABLE IF EXISTS grade_categories;
DROP TABLE IF EXISTS course_assignments;
DROP TABLE IF EXISTS courses;
DROP TABLE IF EXISTS auth_table;
DROP TABLE IF EXISTS professors;
DROP TABLE IF EXISTS students;

-- Create tables
CREATE TABLE students (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    firstName VARCHAR(50) NOT NULL, 
    lastName VARCHAR(50) NOT NULL, 
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20), 
    photoUrl VARCHAR(255) DEFAULT 'default.png'
);

CREATE TABLE professors (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    firstName VARCHAR(50) NOT NULL, 
    lastName VARCHAR(50) NOT NULL, 
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NULL,
    photoUrl VARCHAR(255) DEFAULT 'default.png'
);

-- The default password is metro1234
CREATE TABLE auth_table (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    studentId INT,
    professorId INT,
    username VARCHAR(50) NOT NULL UNIQUE, 
    password_hash VARCHAR(255) NOT NULL DEFAULT '$2y$10$etD1bnpMWpdMnPdG0bGqTuwRDP2T1L7i4hze6DPAhbGqvvSDzlbzG', 
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
); 

CREATE TABLE courses (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    courseId VARCHAR(10) NOT NULL, 
    courseTitle VARCHAR(50) NOT NULL, 
    courseDescription VARCHAR(255) NOT NULL,
    credits INT NOT NULL DEFAULT 3
);

CREATE TABLE course_assignments (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    professorId INT NOT NULL,
    courseId INT NOT NULL
);

CREATE TABLE grade_categories (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    courseAssignmentId INT NOT NULL,
    categoryName VARCHAR(50) NOT NULL, 
    maxObtainable INT NOT NULL
);

CREATE TABLE enrollments (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    studentId INT NOT NULL, 
    courseAssignmentId INT NOT NULL,
    enrollment_status BOOLEAN DEFAULT false
);

CREATE TABLE assessments (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    enrollmentId INT NOT NULL, 
    assessmentItemName VARCHAR(50) NOT NULL,
    gradeCategoryId INT NOT NULL, 
    dueDate DATE NOT NULL,
    assessment_question VARCHAR(50) NULL
);

CREATE TABLE grades (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    assessmentId INT NOT NULL,
    student_submission VARCHAR(50) NULL,
    assessment_feedback VARCHAR(50) NULL,
    score INT NOT NULL DEFAULT 0,
    initial BOOLEAN DEFAULT true
);

CREATE TABLE course_feedbacks (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    enrollmentId INT NOT NULL, 
    notes VARCHAR(200) NOT NULL
);


-- Add foreign key constraints 
ALTER TABLE auth_table ADD FOREIGN KEY (studentId) REFERENCES students(id);
ALTER TABLE auth_table ADD FOREIGN KEY (professorId) REFERENCES professors(id);
ALTER TABLE course_assignments ADD FOREIGN KEY (professorId) REFERENCES professors(id);
ALTER TABLE course_assignments ADD FOREIGN KEY (courseId) REFERENCES courses(id);
ALTER TABLE enrollments ADD FOREIGN KEY (studentId) REFERENCES students(id);
ALTER TABLE enrollments ADD FOREIGN KEY (courseAssignmentId) REFERENCES course_assignments(id);
ALTER TABLE assessments ADD FOREIGN KEY (enrollmentId) REFERENCES enrollments(id);
ALTER TABLE assessments ADD FOREIGN KEY (gradeCategoryId) REFERENCES grade_categories(id);
ALTER TABLE grades ADD FOREIGN KEY (assessmentId) REFERENCES assessments(id);
ALTER TABLE grade_categories ADD FOREIGN KEY (courseAssignmentId) REFERENCES course_assignments(id);
ALTER TABLE course_feedbacks ADD FOREIGN KEY (enrollmentId) REFERENCES enrollments(id);

-- View for student enrollment to see registered classes
DROP VIEW IF EXISTS vw_studentEnrollments;

CREATE VIEW vw_studentEnrollments AS
SELECT e.id AS `enrollId`, s.id AS `studentId`, c.courseId AS `courseId`, c.courseTitle AS `courseTitle`, c.courseDescription AS `courseDescription`, p.firstName AS `profFirstName`, p.lastName AS `profLastName`, p.email AS `profEmail`, e.enrollment_status AS `enrollStatus`
FROM students s INNER JOIN enrollments e                ON s.id = e.studentId
                INNER JOIN course_assignments ca        ON e.courseAssignmentId = ca.id
                INNER JOIN professors p                 ON ca.professorId = p.id
                INNER JOIN courses c                    ON ca.courseId = c.id;

-- View to see all classes available for enrollment
DROP VIEW IF EXISTS vw_availableEnrollments;

CREATE VIEW vw_availableEnrollments AS
SELECT ca.id AS `caId`, c.courseId AS `courseId`, c.courseTitle AS `courseTitle`, c.courseDescription AS `courseDescription`, p.firstName AS `profFirstName`, p.lastName AS `profLastName`, p.email AS `profEmail`
FROM course_assignments ca  INNER JOIN professors p on ca.professorId = p.id
                            INNER JOIN courses c on ca.courseId = c.id;


-- View to see all grades
/* DROP VIEW IF EXISTS vw_allGrades;

CREATE VIEW vw_allGrades AS
SELECT e.enrollmentId AS `enrollmentId`, s.firstName AS `studentsFirstName` , s.lastName AS `studentsLastName`, p.firstName AS `professorsFirstName`, p.lastName AS `professorsLastName`, c.courseId AS `courseId`, c.courseTitle AS `courseTitle`, gc.categoryName AS `gradeCategory`, gi.gradeItemName AS `gradeItemName`, gc.maxObtainable AS `maxObtainable`, g.score AS `score`
FROM grades g   INNER JOIN grade_items gi ON g.gradeItemId = gi.id
				INNER JOIN grade_categories gc ON gi.gradeCategoryId = gc.id
                INNER JOIN enrollments e ON g.enrollmentId = e.id
                INNER JOIN course_assignments ca ON gi.courseAssignmentId = ca.id
                INNER JOIN courses c ON ca.courseId = c.id
                INNER JOIN students s ON e.studentId = s.id
                INNER JOIN professors p ON ca.professorId = p.id
ORDER BY s.firstName, s.lastName, c.courseId, gc.categoryName, gi.gradeItemName; */
-- Insert into students table
INSERT INTO students (firstName, lastName, email, phone) VALUES 
('John', 'Doe', 'john.doe@example.com', '123-456-7890'),
('Alice', 'Smith', 'alice.smith@example.com', '987-654-3210'),
('Michael', 'Johnson', 'michael.johnson@example.com', NULL),
('Emily', 'Brown', 'emily.brown@example.com', '555-123-4567'),
('Daniel', 'Taylor', 'daniel.taylor@example.com', NULL),
('Sarah', 'Martinez', 'sarah.martinez@example.com', '444-555-6666'),
('Matthew', 'Anderson', 'matthew.anderson@example.com', '777-888-9999'),
('Jessica', 'Wilson', 'jessica.wilson@example.com', '111-222-3333'),
('Andrew', 'Thomas', 'andrew.thomas@example.com', '333-444-5555'),
('Olivia', 'Garcia', 'olivia.garcia@example.com', NULL),
('Emma', 'Gonzalez', 'emma.gonzalez@example.com', '555-123-4567'),
('James', 'Wang', 'james.wang@example.com', '555-987-6543'),
('Sophia', 'Kim', 'sophia.kim@example.com', NULL),
('William', 'Chen', 'william.chen@example.com', '555-456-7890'),
('Emily', 'Liu', 'emily.liu@example.com', '555-789-1234'),
('Michael', 'Gupta', 'michael.gupta@example.com', NULL),
('Hannah', 'Patel', 'hannah.patel@example.com', '555-321-6547'),
('Daniel', 'Lee', 'daniel.lee@example.com', '555-654-9870'),
('Ava', 'Singh', 'ava.singh@example.com', NULL),
('Jackson', 'Nguyen', 'jackson.nguyen@example.com', '555-876-5432');


-- Insert into professors table
INSERT INTO professors (firstName, lastName, email, phone) VALUES 
('Professor', 'Smith', 'prof.smith@example.com', '555-555-5555'),
('Dr.', 'Johnson', 'dr.johnson@example.com', '666-666-6666'),
('Professor', 'Brown', 'prof.brown@example.com', NULL),
('Dr.', 'Martinez', 'dr.martinez@example.com', '777-777-7777'),
('Professor', 'Anderson', 'prof.anderson@example.com', '888-888-8888'),
('Dr.', 'Wilson', 'dr.wilson@example.com', '999-999-9999'),
('Professor', 'Taylor', 'prof.taylor@example.com', NULL),
('Dr.', 'Thomas', 'dr.thomas@example.com', NULL),
('Professor', 'Garcia', 'prof.garcia@example.com', '111-111-1111'),
('Dr.', 'Miller', 'dr.miller@example.com', '222-222-2222'),
('Emma', 'Gonzalez', 'emma.gonzalez@example.com', '555-123-4567'),
('James', 'Wang', 'james.wang@example.com', '555-987-6543'),
('Sophia', 'Kim', 'sophia.kim@example.com', NULL),
('William', 'Chen', 'william.chen@example.com', '555-456-7890'),
('Emily', 'Liu', 'emily.liu@example.com', '555-789-1234'),
('Michael', 'Gupta', 'michael.gupta@example.com', NULL),
('Hannah', 'Patel', 'hannah.patel@example.com', '555-321-6547'),
('Daniel', 'Lee', 'daniel.lee@example.com', '555-654-9870'),
('Ava', 'Singh', 'ava.singh@example.com', NULL),
('Jackson', 'Nguyen', 'jackson.nguyen@example.com', '555-876-5432');



-- Insert into auth_table table
INSERT INTO auth_table (studentId, professorId, username) VALUES 
(1, NULL, 'john_doe'),
(NULL, 1, 'prof_smith'),
(2, NULL, 'alice_smith'),
(NULL, 2, 'dr_johnson'),
(3, NULL, 'michael_johnson'),
(NULL, 3, 'prof_brown'),
(4, NULL, 'emily_brown'),
(NULL, 4, 'dr_martinez'),
(5, NULL, 'daniel_taylor'),
(NULL, 5, 'prof_anderson'),
(11, NULL, 'emma_gonzalez'),
(12, NULL, 'james_wang'),
(13, NULL, 'sophia_kim'),
(14, NULL, 'william_chen'),
(15, NULL, 'emily_liu'),
(NULL, 11, 'prof_gonzalez'),
(NULL, 12, 'prof_wang'),
(NULL, 13, 'prof_kim'),
(NULL, 14, 'prof_chen'),
(NULL, 15, 'prof_liu');


-- Insert into courses table
INSERT INTO courses (courseId, courseTitle, courseDescription) VALUES 
('CSCI101', 'Introduction to Computer Science', 'An introductory course covering basic concepts of computer science.'),
('MATH201', 'Calculus I', 'A foundational course in calculus covering limits, derivatives, and integrals.'),
('ENG102', 'Composition II', 'A course focusing on advanced writing skills and critical thinking.'),
('HIST202', 'World History II', 'A survey of world history from the Renaissance to the present.'),
('PHYS301', 'Physics Mechanics', 'A course covering classical mechanics and Newtonian physics.'),
('CHEM201', 'Organic Chemistry', 'An introduction to the principles of organic chemistry.'),
('ART101', 'Art Appreciation', 'An exploration of various art forms and their cultural significance.'),
('ECON202', 'Macroeconomics', 'An analysis of economic principles at the national level.'),
('PSYC101', 'Introduction to Psychology', 'An overview of the fundamental concepts and theories in psychology.'),
('BIOL101', 'Biology I', 'An introduction to the principles of biology and the scientific method.'),
('CSCI202', 'Data Structures', 'A course covering advanced data structures and algorithms.'),
('PHIL101', 'Introduction to Philosophy', 'An exploration of major philosophical questions and theories.'),
('BUS101', 'Introduction to Business', 'An overview of basic business concepts and practices.'),
('ENG201', 'Creative Writing', 'A workshop-style course focusing on creative writing techniques.'),
('HIST101', 'World History I', 'A survey of world history from prehistoric times to the Renaissance.'),
('CHEM101', 'General Chemistry', 'An introduction to the principles of general chemistry.'),
('PHYS101', 'Physics I', 'A course covering basic principles of mechanics and thermodynamics.'),
('MATH101', 'College Algebra', 'A course covering algebraic techniques and applications.'),
('PSYC201', 'Developmental Psychology', 'An examination of human psychological development across the lifespan.'),
('SOC101', 'Introduction to Sociology', 'An overview of sociological concepts and theories.');


-- Insert into course_assignments table
INSERT INTO course_assignments (professorId, courseId) VALUES 
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(20, 20);


-- Insert into grade_categories table
INSERT INTO grade_categories (courseAssignmentId, categoryName, maxObtainable) VALUES
(1, 'Homework', 100),
(1, 'Quizzes', 50),
(1, 'Midterm', 200),
(1, 'Final Exam', 300),
(1, 'Projects', 150),
(1, 'Participation', 50),
(1, 'Lab Reports', 100),
(1, 'Essays', 100),
(1, 'Presentations', 150),
(1, 'Attendance', 50),
(2, 'Homework', 100),
(2, 'Quizzes', 50),
(2, 'Midterm', 200),
(2, 'Final Exam', 300),
(2, 'Projects', 150),
(2, 'Participation', 50),
(2, 'Lab Reports', 100),
(2, 'Essays', 100),
(2, 'Presentations', 150),
(2, 'Attendance', 50);


-- Insert into enrollments table
INSERT INTO enrollments (studentId, courseAssignmentId) VALUES 
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(20, 20);

-- Insert into assessments table
insert into assessments (enrollmentId, assessmentItemName, gradeCategoryId, dueDate) values 
(1, "Homework 1", 1, '2024-01-01'),
(1, "Homework 2", 1, '2024-01-08'),
(1, "Quiz 1", 2, '2024-01-01'),
(1, "Quiz 2", 2, '2024-01-12'),
(1, "Quiz 3", 2, '2024-01-20'),
(1, "Project Part 1", 5, '2024-01-12');

-- Insert into grades table
INSERT INTO grades (assessmentID, student_submission, assessment_feedback, score) VALUES
(1, "1 submission", "good job", 100),
(2, "1 submission", "needs improvement", 75),
(3, "1 submission", "good", 48),
(6, "1 submission", "nice work", 130);

-- Insert into grade_items table
/* INSERT INTO grade_items (gradeItemName, gradeCategoryId, courseAssignmentId)
SELECT CONCAT(gc.categoryName, ' ', (FLOOR(RAND() * 10) + 1)) AS gradeItemName,
       gc.id AS gradeCategoryId,
       (FLOOR(RAND() * 10) + 1) AS courseAssignmentId
FROM grade_categories gc
CROSS JOIN (
    SELECT n FROM (
        SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION 
        SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10
    ) AS nums
) AS rand_nums
LIMIT 50;
 */

-- Insert into grades table
/* INSERT INTO grades (enrollmentId, gradeItemId, score)
SELECT e.id AS enrollmentId, gi.id AS gradeItemId, FLOOR(RAND() * 101) AS score
FROM enrollments e
CROSS JOIN grade_items gi
ORDER BY RAND()
LIMIT 200; */

-- Query scenarios
-- 1 -- 
-- This query is used to display student details to on the student welcome page and profile page
SELECT firstName, lastName, email, phone, photoUrl 
FROM students 
WHERE id = 1;

-- 2 --
-- This query is used to display the courses a student is currently enrolled in
SELECT enrollId, studentId, courseId, courseTitle, courseDescription, profFirstName, profLastName, profEmail, enrollStatus 
FROM vw_studentEnrollments 
WHERE studentId = 1;

-- 3 --
-- This query is used to display the courses a student is not currently enrolled
SELECT caId, courseId, courseTitle, courseDescription, profFirstName, profLastName, profEmail 
FROM vw_availableEnrollments 
WHERE courseId NOT IN (SELECT courseId from vw_studentEnrollments WHERE studentId = 1);


-- 4 --
-- This query is used to display the assignments on the assignment pages
select a.assessmentItemName as assignmentName, gc.categoryName, g.student_submission, g.score, gc.maxObtainable as maxScore, DATE_FORMAT(a.dueDate, "%M %d %Y" ) as dueDate from grade_categories gc 
INNER JOIN assessments a on a.gradeCategoryId = gc.id 
INNER JOIN grades g on g.assessmentId = a.id 
where enrollmentId = 1; 

-- 5 --
-- This query is used on the sign up page to check if a username exists
SELECT id FROM auth_table WHERE username = "john_doe";
select * from auth_table;


--Triggers--
-- Trigger to update enrollment status to true when a student enrolls in a course
-- This trigger ensures that the enrollment_status of a specific enrollment is set to 'true' when it is created
DELIMITER $$
CREATE TRIGGER trg_updateEnrollmentStatus AFTER INSERT ON enrollments
FOR EACH ROW
BEGIN
    UPDATE enrollments SET enrollment_status = true WHERE id = NEW.id;
END$$
DELIMITER ;

-- Trigger to validate new grade entry against the max obtainable score for that grade category
-- This trigger ensures that a new grade does not exceed the maximum score allowed for the related grade category
DELIMITER $$
CREATE TRIGGER trg_validateGrade BEFORE INSERT ON grades
FOR EACH ROW
BEGIN
    DECLARE maxScore INT;
    SELECT maxObtainable INTO maxScore
    FROM grade_categories gc
    JOIN assessments a ON a.gradeCategoryId = gc.id
    WHERE a.id = NEW.assessmentId;
    
    IF NEW.score > maxScore THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: Grade exceeds maximum score for this category.';
    END IF;
END$$
DELIMITER ;