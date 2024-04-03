CREATE TABLE Categories (
    Category_ID INT AUTO_INCREMENT PRIMARY KEY,
    Category_Name VARCHAR(255) NOT NULL
);

CREATE TABLE Subcategories (
    Subcategory_ID INT AUTO_INCREMENT PRIMARY KEY,
    Category_ID INT NOT NULL,
    Subcategory_Name VARCHAR(255) NOT NULL,
    FOREIGN KEY (Category_ID) REFERENCES Categories(Category_ID)
);

CREATE TABLE Sub_Subcategories (
    Sub_Subcategory_ID INT AUTO_INCREMENT PRIMARY KEY,
    Subcategory_ID INT NOT NULL,
    Sub_Subcategory_Name VARCHAR(255) NOT NULL,
    FOREIGN KEY (Subcategory_ID) REFERENCES Subcategories(Subcategory_ID)
);



CREATE TABLE Submissions (
    Submission_ID INT AUTO_INCREMENT PRIMARY KEY,
    User_ID INT NOT NULL,
    Category_ID INT NOT NULL,
    Subcategory_ID INT,
    Sub_Subcategory_ID INT,
    Title VARCHAR(255) NOT NULL,
    Date_Of_Submission DATETIME NOT NULL,
    Evidence_Attachment BLOB,
    Verified BOOLEAN NOT NULL,
    FOREIGN KEY (User_ID) REFERENCES user(User_ID),
    FOREIGN KEY (Category_ID) REFERENCES Categories(Category_ID),
    FOREIGN KEY (Subcategory_ID) REFERENCES Subcategories(Subcategory_ID),
    FOREIGN KEY (Sub_Subcategory_ID) REFERENCES Sub_Subcategories(Sub_Subcategory_ID)
);

INSERT INTO Categories (Category_Name) VALUES 
('A: Personal Particulars'), /*1*/
('B: Professional Achievements'), /*2*/
('C: Research and Development'),/*3*/
('D: Professional Consulatations'), /*4*/
('E: Research Outcomes'), /*5*/
('F: Professional Recognition'), /*6*/
('G: Services To Community'); /*7*/

INSERT INTO Subcategories (Category_ID, Subcategory_Name) VALUES
(1, 'A6: Professional Affilliations/Membership'), /*1*/
(2, 'B3: Operational and Development Responsibilities in MIROS'), /*2*/
(2, 'B4: Professional Experiences at International Level'),
(2, 'B5: Professional Experiences at National Level'),
(3, 'C1: Lead New Research Proposal'), /*5*/
(3, 'C2: Research or Development Projects'),
(3, 'C3: Research and Development Operations'),
(4, 'D1: Services to external parties'),
(5, 'E1: Guidelines/Manuals, Policy Papers and Products'),/*9*/







INSERT INTO Sub_Subcategories (Subcategory_ID, Sub_Subcategory_Name) VALUES
(2, 'B3 Committee (proper appointment by management)'),
(6, 'C2: Lead - Internal'),
(6, 'C2: Lead - External'),
(7, 'C3: Program - Lead'),
(7, 'C3: Program - Co'),
(8, 'D1: Commercial/Monetary'),
(8, 'D1: Commercial/Non-Monetary'),
(9, 'E1: Main Contributor: Guidelines/Manuals, Policy Papers (adopted by external parties)'),
(9, 'E1: Team Member: Guidelines/Manuals, Policy Papers (adopted by external parties)');

INSERT INTO Sections (SectionCode, SectionName) VALUES ('A', 'Personal Particulars');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('A6', 'Professional Affilliations/Membership', 'A');
INSERT INTO Sections (SectionCode, SectionName) VALUES ('B', 'Professional Achievements');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('B3', 'Operational and Development Responsibilities in MIROS', 'B');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('B3', 'Committee (proper appointment by management', 'B3');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('B4', 'Professional Experiences at International Level', 'B');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('B5', 'Professional Experiences at National Level', 'B');
INSERT INTO Sections (SectionCode, SectionName) VALUES ('C', 'Research and Development');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('C1', 'Lead New Research Proposal', 'C');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('C2', 'Research or Development Projects', 'C');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('C2', 'Lead - Internal', 'C2');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('C2', 'Lead - External', 'C2');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('C2', 'Co - Internal', 'C2');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('C2', 'Co - External', 'C2');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('C3', 'Research and Development Operations', 'C');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('C3', 'Program - Lead', 'C3');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('C3', 'Program - Co', 'C3');
INSERT INTO Sections (SectionCode, SectionName) VALUES ('D', 'Professional Consulatations');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('D1', 'Commercial/Monetary (initiate and do 
professional/consultation work)', 'D');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('D1', 'Commercial/Non-monetary (include meetings, workshop, emails)', 'D');
INSERT INTO Sections (SectionCode, SectionName) VALUES ('E', 'Research Outcomes');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('E1', 'Guidelines/Manuals, Policy Papers and 
Products', 'E');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E1', 'Main Contributor > Guidelines/Manuals, Policy Papers 
(adopted by external parties)', 'E1');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E1', 'Team Member > Guidelines/Manuals, Policy Papers 
(adopted by external parties)', 'E1');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E1', 'Products > Commercialised > Main Contributor', 'E1');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E1', 'Products > Commercialised > Team Member', 'E1');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E1', 'Enabling products (must be used by others 
and with documentations) > Main Contributor', 'E1');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E1', 'Enabling products (must be used by others 
and with documentations) > Team Member', 'E1');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('E2', 'Scientific Reports, Books and Proceedings', 'E');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E2', 'Authorship > Single author of book', 'E2');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E2', 'Authorship > Co-author of book', 'E2');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E2', 'Authorship > Single author of chapter', 'E2');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E2', 'Authorship > Co-author of chapter', 'E2');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E2', 'Editorship > Single Editor', 'E2');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E2', 'Editorship > Co-Editor', 'E2');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E2', 'Translation work > Single translator', 'E2');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E2', 'Translation work > Co-translator', 'E2');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('E3', 'International Journal with Citation 
Index/Impact Factor - accepted', 'E');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E3', 'Main/corresponding author', 'E3');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E3', 'Co - Author', 'E3');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('E4', 'National/Regional/Other International Journal - 
accepted', 'E');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E4', 'Main Author', 'E4');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E4', 'Co -Author', 'E4');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('E13', 'Patents, Copyrights and Trademarks', 'E');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E13', 'Patent granted principal inventor', 'E13');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E13', 'Patent granted co researcher', 'E13');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E13', 'Patent pending principal inventor', 'E13');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E13', 'Patent pending co', 'E13');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E13', 'Copyright registered', 'E13');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E13', 'Trademark registered', 'E13');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('E5', 'MIROS Scientific and Technical Publications (Requested & Initiated by MIROS)', 'E');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E5', 'Main Author', 'E5');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E5', 'Co - Author', 'E5');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('E6', 'MIROS and Other Scientific and Technical 
Publications (Requested/Initiated by External 
Parties)', 'E');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E6', 'Main Author', 'E6');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E6', 'Co - Author', 'E6');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('E7', 'Papers in Proceedings of International 
Conferences', 'E');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E7', 'Main Author', 'E7');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E7', 'Co - Author', 'E7');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('E8', 'Papers in Proceedings of National/Regional Conferences and Seminars', 'E');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E8', 'Main Author', 'E8');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E8', 'Co - Author', 'E8');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('E9', 'Research and Technical Articles in Bulletins/ 
Magazines and News Media/ Newsletter etc', 'E');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E9', 'Author', 'E9');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('E10', 'Guidelines, SOPs, Teaching/Training 
Modules and Others (internal use)', 'E');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E10', 'Main Author', 'E10');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E10', 'Co - Author', 'E10');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E10', 'Review', 'E10');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('E11', 'International Conference Presentations', 'E');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E11', 'Oral Presenter', 'E11');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E11', 'Poster Presenter', 'E11');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('E12', 'National Conference/Seminar/Working Group 
Presentations/Technical Committee/ Meeting', 'E');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E12', 'Oral Presenter', 'E12');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E12', 'Poster Presenter', 'E12');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('E14', 'Knowledge Dissemination', 'E');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E14', 'Poster/brochures/others', 'E14');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E14', 'Involvement in visit by delegates', 'E14');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E14', 'Exhibition - presenting/on duty', 'E14');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('E14', 'Talk/wacana', 'E14');
INSERT INTO Sections (SectionCode, SectionName) VALUES ('F', 'Professional Recognition');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('F3', 'Research and Project Supervision', 'F');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F3', 'Supervision for Thesis/Project > Doctor of Philosophy', 'F3');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F3', 'Supervision for Thesis/Project > Doctor of Philosophy (mixed mode)', 'F3');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F3', 'Supervision for Thesis/Project > Doctor of Philosophy (course work)', 'F3');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F3', 'Supervision for Thesis/Project > Master's', 'F3');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F3', 'Supervision for Thesis/Project > Master's (mixed mode)', 'F3');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F3', 'Supervision for Thesis/Project > Master's (course work)', 'F3');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F3', 'Supervision for Thesis/Project > Post-doctoral/Research Fellow', 'F3');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F3', 'Supervision for Thesis/Project > Industrial Training/Interns', 'F3');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F3', 'Assessor/Examiner', 'F3');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F3', 'Examiner for Thesis > Doctor of Philosophy', 'F3');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F3', 'Examiner for Thesis > Doctor of Philosophy (mixed mode)', 'F3');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F3', 'Examiner for Thesis > Doctor of Philosophy (course work)', 'F3');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F3', 'Examiner for Thesis > Master's', 'F3');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F3', 'Examiner for Thesis > Master's (mixed mode)', 'F3');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F3', 'Examiner for Thesis > Master's (course work)', 'F3');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F3', 'Examiner for Thesis > Assessor/Professional Examiner', 'F3');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('F4', 'Invited Speaker, Keynote Speaker, Session 
Chairman, Forum (Established External 
Events)', 'F');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F4', 'Local/institutional/departmental', 'F4');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F4', 'National', 'F4');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F4', 'International', 'F4');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F4', 'National (Safety Talk) - dalam Malaysia', 'F4');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('F5', 'Scientific and Technical Evaluation (including Research Proposal)', 'F');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F5', 'National', 'F5');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F5', 'International', 'F5');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F5', 'Internal', 'F5');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('F6', 'Others', 'F');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F6', 'Media Coverage's', 'F6');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('F6', 'Interviews', 'F6');
INSERT INTO Sections (SectionCode, SectionName) VALUES ('G', 'Services To Community');
INSERT INTO Items (ItemCode, ItemName, SectionCode) VALUES ('G1', 'Services to Community', 'G');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('G1', 'Institute/Community - e.g. residential areas', 'G1');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('G1', 'District', 'G1');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('G1', 'State', 'G1');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('G1', 'National', 'G1');
INSERT INTO SubItems (SubItemCode, SubItemName, ItemCode) VALUES ('G1', 'International', 'G1');