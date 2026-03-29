CREATE TABLE userdata  (
  id int NOT NULL AUTO_INCREMENT,
  username varchar(45) NOT NULL,
  email varchar(45) NOT NULL,
  password varchar(255) NOT NULL,
  verified TINYINT(1) DEFAULT 0,
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
