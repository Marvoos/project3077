CREATE TABLE userdata  (
  id int NOT NULL AUTO_INCREMENT,
  username varchar(45) NOT NULL,
  email varchar(45) NOT NULL,
  password varchar(255) NOT NULL,
  verified TINYINT(1) DEFAULT 0,
  role ENUM('user', 'admin') DEFAULT 'user',
  token VARCHAR(64),
  PRIMARY KEY (id),
  UNIQUE(email)
);

CREATE TABLE passwordresets(
  id int AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL,
  token VARCHAR(255) NOT NULL,
  expires_at DATETIME NOT NULL
);

CREATE TABLE books(
  id INT AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  author VARCHAR(255),
  description text,
  image VARCHAR(255) DEFAULT 'images/catalog/placeholder/placeholder.svg',
  copies_available INT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

CREATE TABLE borrowedbooks(
  id INT AUTO_INCREMENT,
  user_id INT,
  book_id INT,
  borrowed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  due_date DATETIME,
  returned_at DATETIME DEFAULT NULL,

  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES userdata(id) ON DELETE CASCADE,
  FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);