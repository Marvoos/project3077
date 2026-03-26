CREATE TABLE userdata  (
  id int NOT NULL AUTO_INCREMENT,
  username varchar(45) NOT NULL,
  email varchar(45) NOT NULL,
  password varchar(255) NOT NULL,
  verified TINYINT(1) DEFAULT 0,
  token VARCHAR(64),
  PRIMARY KEY (id),
  UNIQUE(email)
)
