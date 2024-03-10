CREATE TABLE User (
    User_ID INT PRIMARY KEY,
    First_Name TEXT,
    Last_Name TEXT,
    Date_of_birth DATETIME,
    Email TEXT UNIQUE,
    PasswordHash TEXT,
    Role ENUM('role1', 'role2', 'role3'), -- Replace 'role1', 'role2', 'role3' with actual roles.
    Reports_To INT,
    FOREIGN KEY (Reports_To) REFERENCES User(User_ID)
);

CREATE TABLE Session (
    Session_ID INT PRIMARY KEY,
    User_ID INT,
    Log_in_time DATETIME,
    Is_Active BOOLEAN,
    Log_out_time DATETIME,
    Session_Token VARCHAR(255),
    FOREIGN KEY (User_ID) REFERENCES User(User_ID)
);

CREATE TABLE Password_Reset_Tokens (
    Token_ID INT PRIMARY KEY,
    User_ID INT,
    Reset_Token TEXT,
    Creation_Date DATETIME,
    Expiration_Date DATETIME,
    Is_Used BOOLEAN,
    FOREIGN KEY (User_ID) REFERENCES User(User_ID)
);

CREATE TABLE Submission_Type (
    Submission_Type_ID INT PRIMARY KEY,
    Submission_type ENUM('type1', 'type2', 'type3'), -- @George, What submission types should be included?
    Weighting INT
);

CREATE TABLE Submissions (
    Submission_ID INT PRIMARY KEY,
    User_ID INT,
    Submission_Type_ID INT,
    Title TEXT,
    Date_Of_Submission DATETIME,
    Deadline DATETIME,
    Publication_URL TEXT,
    Evidence_attachment BLOB,
    FOREIGN KEY (User_ID) REFERENCES User(User_ID),
    FOREIGN KEY (Submission_Type_ID) REFERENCES Submission_Type(Submission_Type_ID)
);

CREATE TABLE Targets (
    Target_ID INT PRIMARY KEY,
    User_ID INT,
    Submission_Type_ID INT,
    Title TEXT,
    Date_Of_Submission DATETIME,
    Deadline DATETIME,
    Publication_URL TEXT,
    Evidence_attachment BLOB,
    FOREIGN KEY (User_ID) REFERENCES User(User_ID),
    FOREIGN KEY (Submission_Type_ID) REFERENCES Submission_Type(Submission_Type_ID)
);

CREATE TABLE Submission_Verification (
    Verification_ID INT PRIMARY KEY,
    Submission_ID INT,
    User_ID INT,
    Verification_Date DATETIME,
    Status ENUM('status tpye 1', 'status tpye 2', 'status tpye 3'), -- @George, What Statuses should be included?
    FOREIGN KEY (Submission_ID) REFERENCES Submissions(Submission_ID),
    FOREIGN KEY (User_ID) REFERENCES User(User_ID)
);
