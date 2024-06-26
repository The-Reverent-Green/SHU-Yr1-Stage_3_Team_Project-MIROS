/* 
    1) Create an account through the register user page.
    2) Have admin assign the "Top Manager" Role to your account.
    3) Run the SQL commands below to populate your database tables.
    4) Sign-in to your account and access the newly populated tables through the nav bar.
*/

INSERT INTO `user` 
(`User_ID`, `Username`, `First_Name`, `Last_Name`, `Date_of_birth`, `Email`, `PasswordHash`, `Status`, `ROLE`, `account_status`) VALUES
(14, 'Officer1', 'Joe', 'Hilton', '2003-04-05', 'joe@miros.my', '1234', 'Active', 'Research Officer', 'active'),
(15, 'Officer2', 'Bob', 'Mallard', '1988-11-29', 'bob@miros.my', '1234', 'Active', 'Research Officer', 'active'),
(16, 'Officer3', 'Peter', 'Crocket', '1967-03-19', 'peter@miros.my', '1234', 'Active', 'Research Officer', 'active'),
(17, 'Officer4', 'Dave', 'Yannis', '2001-05-05', 'dave@miros.my', '1234', 'Active', 'Research Officer', 'active'),
(18, 'Officer5', 'Jenny', 'Barber', '1998-07-28', 'jenny@miros.my', '1234', 'Active', 'Research Officer', 'active'),
(19, 'Officer6', 'Karen', 'Cellers', '2005-12-12', 'karen@miros.my', '1234', 'Active', 'Research Officer', 'active'),
(20, 'Officer7', 'Rebecca', 'Myles', '1987-08-12', 'rebecca@miros.my', '1234', 'Active', 'Research Officer', 'active'),
(21, 'Officer8', 'Thomas', 'Phillips', '1993-09-21', 'thomas@miros.my', '1234', 'Active', 'Research Officer', 'active'),
(22, 'Officer9', 'Ella', 'Boyden', '2000-07-26', 'ella@miros.my', '1234', 'Active', 'Research Officer', 'active'),
(23, 'Officer10', 'Harry', 'Yellow', '1966-01-22', 'harry@miros.my', '1234', 'Active', 'Research Officer', 'active'),
(24, 'Officer11', 'John', 'Delta', '1985-07-11', 'john@miros.my', '1234', 'Active', 'Research Officer', 'active'),
(25, 'Officer12', 'Francis', 'Gardener', '1978-06-11', 'francis@miros.my', '1234', 'Active', 'Research Officer', 'active'),
(26, 'Officer13', 'Lucy', 'Tipton', '1998-08-08', 'lucy@miros.my', '1234', 'Active', 'Research Officer', 'active'),
(27, 'Officer14', 'Millie', 'Musgraves', '2002-10-25', 'millie@miros.my', '1234', 'Active', 'Research Officer', 'active'),
(28, 'Officer15', 'Sarah', 'Grifton', '1991-09-14', 'sarah@miros.my', '1234', 'Active', 'Research Officer', 'active'),
(30, 'Supervisor1', 'Reece', 'Reinhart', '1982-02-27', 'reece@miros.my', '1234', 'Active', 'Supervisor', 'active'),
(31, 'Supervisor2', 'Daniel', 'Tillerson', '1988-11-02', 'daniel@miros.my', '1234', 'Active', 'Supervisor', 'active'),
(32, 'Supervisor3', 'Rosie', 'Hellers', '2003-11-29', 'rosie@miros.my', '1234', 'Active', 'Supervisor', 'active'),
(33, 'Supervisor4', 'Kate', 'Beckett', '1993-04-26', 'kate@miros.my', '1234', 'Active', 'Supervisor', 'active'),
(34, 'Supervisor5', 'Leanne', 'Kilbride', '2004-07-22', 'leanne@miros.my', '1234', 'Active', 'Supervisor', 'active');
    
INSERT INTO `submissions`
(`Submission_ID`, `User_ID`, `Title`, `Date_Of_Submission`, `Deadline`, `Publication_URL`, `Evidence_attachment`) VALUES
(1, 21, 'General road safety in Malaysia', '2024/03/21', '2024/12/31', '', ''),
(2, 25, 'Keeping roads clear going forward ', '2024/02/02', '2024/12/31', '', ''),
(3, 17, 'Road safety: A reflective account', '2024/02/22', '2024/12/31', '', ''),
(4, 14, 'A quantative survey of potholes', '2024/01/26', '2024/12/31', '', ''),
(5, 17, 'Specific road safety in Malaysia', '2024/01/11', '2024/12/31', '', ''),
(6, 28, 'Integration of different road types', '2024/03/06', '2024/12/31', '', ''),
(7, 26, 'Are road crossings truly effective?', '2024/03/08', '2024/12/31', '', ''),
(8, 22, 'Increasing road size despite government cutbacks', '2024/02/24', '2024/12/31', '', ''),
(9, 19, 'Motoring in the age of electricity', '2024/03/21', '2024/12/31', '', ''),
(10, 18, 'Rising cost of concrete', '2024/03/17', '2024/12/31', '', ''),
(11, 24, 'Malaysian madness: are roads really necessary?', '2024/01/29', '2024/12/31', '', ''),
(12, 24, 'Speed-zones in proximity to schools', '2024/01/04', '2024/12/31', '', ''),
(13, 27, 'Wild weather and even wilder roads', '2024/02/25', '2024/12/31', '', ''),
(14, 19, 'Hill gradients and possible problems that may arise', '2024/02/02', '2024/12/31', '', ''),
(15, 15, 'Brakes breaks bones', '2024/01/07', '2024/12/31', '', ''),
(16, 16, 'Are Malaysian road layouts the most efficient?', '2024/01/19', '2024/12/31', '', ''),
(17, 21, 'Driving us all mad: A Paramedics story', '2024/03/05', '2024/12/31', '', ''),
(18, 20, 'Pandemics, Paramedics and potholes', '2024/03/19', '2024/12/31', '', ''),
(19, 24, 'Parking ticket price increase, cause for concern?', '2024/01/11', '2024/12/31', '', ''),
(20, 23, 'A study of car horns and their decibel levels', '2024/02/17', '2024/12/31', '', '');

INSERT INTO `targets`
(`Target_ID`, `User_ID`, `Title`, `Date_Of_Submission`, `Deadline`, `Publication_URL`, `Evidence_attachment`) VALUES
(1, 21, 'General road safety in Malaysia', '2024/03/21', '2024/12/31', '', ''),
(2, 25, 'Keeping roads clear going forward ', '2024/02/02', '2024/12/31', '', ''),
(3, 17, 'Road safety: A reflective account', '2024/02/22', '2024/12/31', '', ''),
(4, 14, 'A quantative survey of potholes', '2024/01/26', '2024/12/31', '', ''),
(5, 17, 'Specific road safety in Malaysia', '2024/01/11', '2024/12/31', '', ''),
(6, 28, 'Integration of different road types', '2024/03/06', '2024/12/31', '', ''),
(7, 26, 'Are road crossings truly effective?', '2024/03/08', '2024/12/31', '', ''),
(8, 22, 'Increasing road size despite government cutbacks', '2024/02/24', '2024/12/31', '', ''),
(9, 19, 'Motoring in the age of electricity', '2024/03/21', '2024/12/31', '', ''),
(10, 18, 'Rising cost of concrete', '2024/03/17', '2024/12/31', '', ''),
(11, 24, 'Malaysian madness: are roads really necessary?', '2024/01/29', '2024/12/31', '', ''),
(12, 24, 'Speed-zones in proximity to schools', '2024/01/04', '2024/12/31', '', ''),
(13, 27, 'Wild weather and even wilder roads', '2024/02/25', '2024/12/31', '', ''),
(14, 19, 'Hill gradients and possible problems that may arise', '2024/02/02', '2024/12/31', '', ''),
(15, 15, 'Brakes breaks bones', '2024/01/07', '2024/12/31', '', ''),
(16, 16, 'Are Malaysian road layouts the most efficient?', '2024/01/19', '2024/12/31', '', ''),
(17, 21, 'Driving us all mad: A Paramedics story', '2024/03/05', '2024/12/31', '', ''),
(18, 20, 'Pandemics, Paramedics and potholes', '2024/03/19', '2024/12/31', '', ''),
(19, 24, 'Parking ticket price increase, cause for concern?', '2024/01/11', '2024/12/31', '', ''),
(20, 23, 'A study of car horns and their decibel levels', '2024/02/17', '2024/12/31', '', '');

ALTER TABLE `user` ADD `Last_Log_In` DATETIME;