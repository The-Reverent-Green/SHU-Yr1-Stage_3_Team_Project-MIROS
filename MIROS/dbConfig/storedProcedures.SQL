DELIMITER $$
CREATE PROCEDURE CreateTables()
BEGIN
    CREATE TABLE User (
        User_ID INT AUTO_INCREMENT PRIMARY KEY,
        First_Name VARCHAR(256),
        Last_Name VARCHAR(256),
        Date_of_birth DATETIME,
        Email VARCHAR(256) UNIQUE,
        PasswordHash VARCHAR(256),
        Role ENUM('Research Officer', 'Supervisor', 'Top Manager'),
        Reports_To INT,
        FOREIGN KEY (Reports_To) REFERENCES User(User_ID)
    );

    CREATE TABLE Session (
        Session_ID INT PRIMARY KEY,
        User_ID INT,
        Log_in_time DATETIME,
        Is_Active BOOLEAN,
        Log_out_time DATETIME,
        Session_Token VARCHAR(256),
        FOREIGN KEY (User_ID) REFERENCES User(User_ID)
    );

    CREATE TABLE Password_Reset_Tokens (
        Token_ID INT PRIMARY KEY,
        User_ID INT,
        Reset_Token VARCHAR(256),
        Creation_Date DATETIME,
        Expiration_Date DATETIME,
        Is_Used BOOLEAN,
        FOREIGN KEY (User_ID) REFERENCES User(User_ID)
    );

    CREATE TABLE Submission_Type (
        Submission_Type_ID INT PRIMARY KEY,
        Submission_type ENUM('type1', 'type2', 'type3'), -- @George, What submission types should be included, and how many are there?
        Weighting INT
    );

    CREATE TABLE Submissions (
        Submission_ID INT PRIMARY KEY,
        User_ID INT,
        Submission_Type_ID INT,
        Title VARCHAR(256),
        Date_Of_Submission DATETIME,
        Deadline DATETIME,
        Publication_URL VARCHAR(256),
        Evidence_attachment BLOB,
        FOREIGN KEY (User_ID) REFERENCES User(User_ID),
        FOREIGN KEY (Submission_Type_ID) REFERENCES Submission_Type(Submission_Type_ID)
    );

    CREATE TABLE Targets (
        Target_ID INT PRIMARY KEY,
        User_ID INT,
        Submission_Type_ID INT,
        Title VARCHAR(256),
        Date_Of_Submission DATETIME,
        Deadline DATETIME,
        Publication_URL VARCHAR(256),
        Evidence_attachment BLOB,
        FOREIGN KEY (User_ID) REFERENCES User(User_ID),
        FOREIGN KEY (Submission_Type_ID) REFERENCES Submission_Type(Submission_Type_ID)
    );

    CREATE TABLE Submission_Verification (
        Verification_ID INT PRIMARY KEY,
        Submission_ID INT,
        User_ID INT,
        Verification_Date DATETIME,
        Status ENUM('Pending verification', 'Verification successful', 'Verification denied'),
        FOREIGN KEY (Submission_ID) REFERENCES Submissions(Submission_ID),
        FOREIGN KEY (User_ID) REFERENCES User(User_ID)
    );
END$$

CREATE PROCEDURE InsertSampleData()
BEGIN
    -- Insert into User table
    INSERT INTO User (First_Name, Last_Name, Date_of_birth, Email, PasswordHash, Role, Reports_To) VALUES 
    ('Alice', 'Smith', '1985-04-12 00:00:00', 'alice.smith@email.com', 'hash1', 'Research Officer', NULL),
    ('Bob', 'Johnson', '1978-07-24 00:00:00', 'bob.johnson@email.com', 'hash2', 'Supervisor', 1),
    ('Cara', 'Davis', '1990-11-15 00:00:00', 'cara.davis@email.com', 'hash3', 'Top Manager', 2);

    -- Insert into Session table
    INSERT INTO Session (User_ID, Log_in_time, Is_Active, Log_out_time, Session_Token) VALUES 
    (1, NOW(), TRUE, NULL, 'token1'),
    (2, NOW(), FALSE, NOW(), 'token2');

    -- Insert into Password_Reset_Tokens table
    INSERT INTO Password_Reset_Tokens (User_ID, Reset_Token, Creation_Date, Expiration_Date, Is_Used) VALUES 
    (1, 'resetToken1', NOW(), NOW() + INTERVAL 1 DAY, FALSE),
    (3, 'resetToken2', NOW(), NOW() + INTERVAL 1 HOUR, FALSE);

    -- Insert into Submission_Type table
    INSERT INTO Submission_Type (Submission_type, Weighting) VALUES 
    ('type1', 10),
    ('type2', 20),
    ('type3', 30);

    -- Insert into Submissions table
    INSERT INTO Submissions (User_ID, Submission_Type_ID, Title, Date_Of_Submission, Deadline, Publication_URL) VALUES 
    (1, 1, 'Title 1', '2024-03-01 00:00:00', '2024-03-31 00:00:00', 'example.com/pub1'),
    (2, 2, 'Title 2', '2024-03-05 00:00:00', '2024-04-05 00:00:00', 'example.com/pub2');

    -- Insert into Targets table
    INSERT INTO Targets (User_ID, Submission_Type_ID, Title, Date_Of_Submission, Deadline, Publication_URL) VALUES 
    (3, 3, 'Target Title 1', '2024-04-01 00:00:00', '2024-05-01 00:00:00', 'example.com/target1'),
    (1, 2, 'Target Title 2', '2024-04-15 00:00:00', '2024-06-15 00:00:00', 'example.com/target2');

    -- Insert into Submission_Verification table
    INSERT INTO Submission_Verification (Submission_ID, User_ID, Verification_Date, Status) VALUES 
    (1, 2, '2024-03-20 00:00:00', 'Pending verification'),
    (2, 3, '2024-03-25 00:00:00', 'Verification successful');
END$$
DELIMITER ;