CREATE TABLE sample (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username NVARCHAR(128),
    password NVARCHAR(32),
    salt NVARCHAR(255)
);
