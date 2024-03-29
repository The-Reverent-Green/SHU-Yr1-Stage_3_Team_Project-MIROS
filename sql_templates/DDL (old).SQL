CREATE TABLE IF NOT EXISTS Users (
    User_ID INT AUTO_INCREMENT PRIMARY KEY,
    First_Name VARCHAR(256),
    Last_Name VARCHAR(256),
    Date_of_birth DATETIME,
    Email VARCHAR(256) UNIQUE,
    PasswordHash VARCHAR(256),
    Status ENUM('Active', 'Deactivated') NOT NULL DEFAULT 'Active',
    Role ENUM('Research Officer', 'Supervisor', 'Top Manager'),
    Creation_date DATETIME,j
    Reports_To INT,
    FOREIGN KEY (Reports_To) REFERENCES User(User_ID)
);

CREATE TABLE Session (
    Session_ID INT AUTO_INCREMENT PRIMARY KEY,
    User_ID INT,
    Log_in_time DATETIME,
    Is_Active BOOLEAN,
    Log_out_time DATETIME,
    Session_Token VARCHAR(256),
    FOREIGN KEY (User_ID) REFERENCES User(User_ID)
);

CREATE TABLE Password_Reset_Tokens (
    Token_ID INT AUTO_INCREMENT PRIMARY KEY,
    User_ID INT,
    Reset_Token VARCHAR(256),
    Creation_Date DATETIME,
    Expiration_Date DATETIME,
    Is_Used BOOLEAN,
    FOREIGN KEY (User_ID) REFERENCES User(User_ID)
);

CREATE TABLE Submission_Type (
    Submission_Type_ID INT AUTO_INCREMENT PRIMARY KEY,
    Submission_type ENUM('type1', 'type2', 'type3'), -- For @George, What submission types should be included, and how many are there?
    Weighting INT
);

CREATE TABLE Submissions (
    Submission_ID INT AUTO_INCREMENT PRIMARY KEY,
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
    Target_ID INT AUTO_INCREMENT PRIMARY KEY,
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
    Verification_ID INT AUTO_INCREMENT PRIMARY KEY,
    Submission_ID INT,
    User_ID INT,
    Verification_Date DATETIME,
    Status ENUM('Pending verification', 'Verification successful', 'Verification denied'),
    FOREIGN KEY (Submission_ID) REFERENCES Submissions(Submission_ID),
    FOREIGN KEY (User_ID) REFERENCES User(User_ID)
);

CREATE TABLE Contact (
    Message_ID INT AUTO_INCREMENT PRIMARY KEY,
    Contact_Name VARCHAR(255) NOT NULL,
    Contact_Email VARCHAR(255) NULL,
    User_ID INT NULL, -- must have either contact email or user_id
    Subject VARCHAR(255) NOT NULL,
    Message TEXT NOT NULL,
    Contact_Date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    Status ENUM('New', 'In Progress', 'Resolved') NOT NULL DEFAULT 'New',
    FOREIGN KEY (User_ID) REFERENCES User(User_ID)
);
