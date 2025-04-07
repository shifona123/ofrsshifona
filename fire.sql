CREATE TABLE reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    mobile VARCHAR(20) NOT NULL,
    incident_type ENUM('Building Fire', 'Forest Fire', 'Vehicle Fire', 'Other') NOT NULL,
    description TEXT NOT NULL,
    latitude DECIMAL(10,8) NOT NULL,
    longitude DECIMAL(11,8) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO reports (name, mobile, incident_type, description, latitude, longitude) 
VALUES 
('John Doe', '1234567890', 'Building Fire', 'Fire at downtown apartment.', 37.7749, -122.4194),
('Alice Smith', '9876543210', 'Forest Fire', 'Wildfire spreading near the hills.', 34.0522, -118.2437);



CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admins (username, password) VALUES ('andrew', 'andrew2008');

CREATE TABLE fire_reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    report_title VARCHAR(255) NOT NULL,
    status ENUM('New', 'Assigned', 'On The Way', 'Completed', 'In Progress') NOT NULL DEFAULT 'New',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO fire_reports (report_title, status) 
VALUES 
('Building Fire at Downtown', 'New'),
('Forest Fire near Highway', 'Assigned'),
('Vehicle Fire on Main Street', 'On The Way'),
('Warehouse Fire in Industrial Area', 'Completed'),
('Residential Fire in Suburbs', 'In Progress');


CREATE TABLE fire_teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_name VARCHAR(255) NOT NULL,
    leader_name VARCHAR(255) NOT NULL,
    leader_contact VARCHAR(20) NOT NULL,
    team_members TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO fire_teams (team_name, leader_name, leader_contact, team_members) 
VALUES 
('Alpha Squad', 'John Doe', '9876543210', 'Alice, Bob, Charlie, David'),
('Bravo Team', 'Emma Watson', '9123456789', 'Ethan, Olivia, Liam, Sophia'),
('Charlie Unit', 'Michael Brown', '9988776655', 'Daniel, Ava, Jacob, Isabella'),
('Delta Force', 'Sarah Johnson', '9090909090', 'Noah, Mia, Lucas, Emily'),
('Echo Rescue', 'William Smith', '9871234567', 'James, Charlotte, Benjamin, Amelia');


CREATE TABLE IF NOT EXISTS fire_alerts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    mobile VARCHAR(15) NOT NULL,
    location TEXT NOT NULL,
    message TEXT NOT NULL,
    reporting_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO fire_alerts (name, mobile, location, message) VALUES
('John Doe', '9876543210', 'New York, NY', 'Fire in apartment building, urgent help needed.'),
('Alice Smith', '8765432109', 'Los Angeles, CA', 'Warehouse fire, spreading rapidly.'),
('Bob Johnson', '7654321098', 'Chicago, IL', 'Kitchen fire in restaurant, smoke everywhere.');


CREATE TABLE IF NOT EXISTS fire_control_teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_name VARCHAR(255) NOT NULL,
    contact_number VARCHAR(15) NOT NULL,
    status ENUM('Available', 'Busy') DEFAULT 'Available'
);
INSERT INTO fire_control_teams (team_name, contact_number, status) VALUES
('Team Alpha', '1234567890', 'Available'),
('Team Bravo', '0987654321', 'Available'),
('Team Charlie', '1122334455', 'Available');

CREATE TABLE IF NOT EXISTS assigned_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fire_alert_id INT NOT NULL,
    team_id INT NOT NULL,
    assigned_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (fire_alert_id) REFERENCES fire_alerts(id) ON DELETE CASCADE,
    FOREIGN KEY (team_id) REFERENCES fire_control_teams(id) ON DELETE CASCADE
);

CREATE TABLE website_settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    logo VARCHAR(255) NOT NULL
);
INSERT INTO website_settings (id, title, logo) VALUES (1, 'OFRS', 'uploads/default_logo.png');

