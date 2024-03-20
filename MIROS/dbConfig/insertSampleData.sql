INSERT INTO User (First_Name, Last_Name, Date_of_birth, Email, PasswordHash, Role, Reports_To) VALUES 
('Alice', 'Smith', '1985-04-12 00:00:00', 'alice.smith@email.com', 'hash1', 'Research Officer', NULL),
('Bob', 'Johnson', '1978-07-24 00:00:00', 'bob.johnson@email.com', 'hash2', 'Supervisor', 1),
('Cara', 'Davis', '1990-11-15 00:00:00', 'cara.davis@email.com', 'hash3', 'Top Manager', 2);

INSERT INTO Session (Session_ID, User_ID, Log_in_time, Is_Active, Log_out_time, Session_Token) VALUES 
(1, 1, NOW(), TRUE, NULL, 'token1'),
(2, 2, NOW(), FALSE, NOW(), 'token2');

INSERT INTO Password_Reset_Tokens (Token_ID, User_ID, Reset_Token, Creation_Date, Expiration_Date, Is_Used) VALUES 
(1, 1, 'resetToken1', NOW(), NOW() + INTERVAL 1 DAY, FALSE),
(2, 3, 'resetToken2', NOW(), NOW() + INTERVAL 1 HOUR, FALSE);

INSERT INTO Submission_Type (Submission_Type_ID, Submission_type, Weighting) VALUES 
(1, 'type1', 10),
(2, 'type2', 20),
(3, 'type3', 30);

INSERT INTO Submissions (Submission_ID, User_ID, Submission_Type_ID, Title, Date_Of_Submission, Deadline, Publication_URL) VALUES 
(1, 1, 1, 'Title 1', '2024-03-01 00:00:00', '2024-03-31 00:00:00', 'example.com/pub1'),
(2, 2, 2, 'Title 2', '2024-03-05 00:00:00', '2024-04-05 00:00:00', 'example.com/pub2');

INSERT INTO Targets (Target_ID, User_ID, Submission_Type_ID, Title, Date_Of_Submission, Deadline, Publication_URL) VALUES 
(1, 3, 3, 'Target Title 1', '2024-04-01 00:00:00', '2024-05-01 00:00:00', 'example.com/target1'),
(2, 1, 2, 'Target Title 2', '2024-04-15 00:00:00', '2024-06-15 00:00:00', 'example.com/target2');

INSERT INTO Submission_Verification (Verification_ID, Submission_ID, User_ID, Verification_Date, Status) VALUES 
(1, 1, 2, '2024-03-20 00:00:00', 'Pending verification'),
(2, 2, 3, '2024-03-25 00:00:00', 'Verification successful');
