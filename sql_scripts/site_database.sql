-- SQL script to create the database and tables for the book borrowing system
CREATE TABLE userdata  (
  id int NOT NULL AUTO_INCREMENT,
  -- Username is a unique identifier for the user, but we will use email as the unique identifier for login purposes. However, it's still good to have a username for display purposes.
  username varchar(45) NOT NULL,
  -- Email is used for login and must be unique to prevent multiple accounts with the same email address.
  email varchar(45) NOT NULL,
  -- Password will be stored as a hashed value for security reasons. The length of 255 allows for various hashing algorithms.
  password varchar(255) NOT NULL,
  -- Verified indicates whether the user's email has been verified. This can be used to restrict access to certain features until the user confirms their email address.
  verified TINYINT(1) DEFAULT 0,
  -- Role can be used to differentiate between regular users and administrators. This allows for role-based access control in the application.
  role ENUM('user', 'admin') DEFAULT 'user',
  -- Token can be used for email verification. When a user registers, a unique token can be generated and sent to their email. The user can then click a link containing the token to verify their email address. This field can also be used for password reset tokens if needed.
  token VARCHAR(64),
  PRIMARY KEY (id),
  UNIQUE(email)
);

-- Table for password reset tokens
CREATE TABLE passwordresets(
  -- Id is optional here since we can use email as a unique identifier, but it's good practice to have a primary key
  id int AUTO_INCREMENT PRIMARY KEY,
  -- Email is used to identify the user requesting the reset
  email VARCHAR(255) NOT NULL,
  -- Token is a unique string that will be sent to the user's email for verification
  token VARCHAR(255) NOT NULL,
  -- Expiration time for the token to ensure it can't be used indefinitely
  expires_at DATETIME NOT NULL
);


CREATE TABLE books(
  -- Id is the primary key and auto-increments with each new book added to the database.
  id INT AUTO_INCREMENT,
  -- Name is the title of the book and is required for each entry. It has a maximum length of 255 characters.
  name VARCHAR(255) NOT NULL,
  -- Author is the name of the person who wrote the book. It is also required and has a maximum length of 255 characters.
  author VARCHAR(255),
  -- Description provides a brief summary of the book's content. It is optional and can be of variable length, so we use the TEXT data type.
  description text,
  -- Image is a URL to the book's cover image. It is optional and has a default value of a placeholder image if not provided. The maximum length is set to 255 characters to accommodate typical URL lengths.
  image VARCHAR(255) DEFAULT 'images/catalog/placeholder/placeholder.svg',
  -- Copies_available indicates how many copies of the book are currently available for borrowing. It is an integer and defaults to 1 if not specified.
  copies_available INT DEFAULT 1,
  -- Created_at is a timestamp that records when the book entry was created. It defaults to the current timestamp when a new record is inserted.
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

-- The borrowedbooks table tracks which users have borrowed which books, along with the relevant dates for borrowing and returning.
CREATE TABLE borrowedbooks(
  -- Id is the primary key for the table and auto-increments with each new borrowing record.
  id INT AUTO_INCREMENT,
  -- User_id is a foreign key that references the id in the userdata table. It indicates which user has borrowed the book. The ON DELETE CASCADE option ensures that if a user is deleted, all their borrowing records will also be deleted.
  user_id INT,
  -- Book_id is a foreign key that references the id in the books table. It indicates which book has been borrowed. The ON DELETE CASCADE option ensures that if a book is deleted, all borrowing records for that book will also be deleted.
  book_id INT,
  -- Borrowed_at records the date and time when the book was borrowed. It defaults to the current timestamp when a new record is inserted.
  borrowed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  -- Due_date indicates when the book is expected to be returned. It is a datetime field that can be set when the borrowing record is created or updated.
  due_date DATETIME,
  -- Returned_at records the date and time when the book was returned. It is optional and defaults to NULL until the book is returned.
  returned_at DATETIME DEFAULT NULL,

  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES userdata(id) ON DELETE CASCADE,
  FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);