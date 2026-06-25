-- Guarantee the app container (a remote host from MariaDB's point of view)
-- can connect as root, regardless of image defaults.
CREATE USER IF NOT EXISTS 'root'@'%' IDENTIFIED BY 'root';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;
