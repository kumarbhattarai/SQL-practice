--SQL used to create the database and tables.

CREATE TABLE members (
  member_id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE books (
  book_id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  author VARCHAR(100) NOT NULL,
  genre VARCHAR(50),
  copies_available INT NOT NULL DEFAULT 1 CHECK (copies_available >= 0)
);

CREATE TABLE loans (
  loan_id INT AUTO_INCREMENT PRIMARY KEY,
  member_id INT NOT NULL,
  book_id INT NOT NULL,
  loan_date DATE NOT NULL,
  due_date DATE NOT NULL,
  return_date DATE NULL,
  FOREIGN KEY (member_id) REFERENCES members(member_id),
  FOREIGN KEY (book_id) REFERENCES books(book_id)
);

INSERT INTO members (full_name, email) VALUES
('Ram Sharma','ram@mail.com'),('Sita Rai','sita@mail.com'),('Hari Thapa','hari@mail.com');

INSERT INTO books (title, author, genre, copies_available) VALUES
('Atomic Habits','James Clear','Self-help',3),('Basain','B.P. Koirala','Fiction',2),
('Clean Code','Robert Martin','Tech',1),('Palpasa Cafe','Narayan Wagle','Fiction',2);

INSERT INTO loans (member_id, book_id, loan_date, due_date, return_date) VALUES
(1,1,'2026-10-01','2026-10-15','2026-10-12'),
(1,3,'2026-10-20','2026-11-03',NULL),
(2,2,'2026-10-25','2026-11-08',NULL),
(2,1,'2026-09-01','2026-09-15','2026-09-20');