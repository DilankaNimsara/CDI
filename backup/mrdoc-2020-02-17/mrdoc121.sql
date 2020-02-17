#
# TABLE STRUCTURE FOR: autobackup
#

DROP TABLE IF EXISTS `autobackup`;

CREATE TABLE `autobackup` (
  `id` varchar(1) NOT NULL,
  `action` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `autobackup` (`id`, `action`) VALUES ('1', 'false');


#
# TABLE STRUCTURE FOR: backup
#

DROP TABLE IF EXISTS `backup`;

CREATE TABLE `backup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(50) DEFAULT NULL,
  `backup_name_file` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

INSERT INTO `backup` (`id`, `date`, `backup_name_file`) VALUES (4, '2020-01-16', 'mrdoc-2020-01-16.zip');
INSERT INTO `backup` (`id`, `date`, `backup_name_file`) VALUES (5, '2020-01-17', 'mrdoc-2020-01-17.zip');
INSERT INTO `backup` (`id`, `date`, `backup_name_file`) VALUES (6, '2020-01-20', 'mrdoc-2020-01-20.zip');
INSERT INTO `backup` (`id`, `date`, `backup_name_file`) VALUES (7, '2020-01-22', 'mrdoc-2020-01-22.zip');
INSERT INTO `backup` (`id`, `date`, `backup_name_file`) VALUES (8, '2020-02-12', 'mrdoc-2020-02-12.zip');
INSERT INTO `backup` (`id`, `date`, `backup_name_file`) VALUES (9, '2020-02-13', 'mrdoc-2020-02-13.zip');
INSERT INTO `backup` (`id`, `date`, `backup_name_file`) VALUES (10, '2020-02-14', 'mrdoc-2020-02-14.zip');
INSERT INTO `backup` (`id`, `date`, `backup_name_file`) VALUES (11, '2020-02-15', 'mrdoc-2020-02-15.zip');
INSERT INTO `backup` (`id`, `date`, `backup_name_file`) VALUES (12, '2020-02-16', 'mrdoc-2020-02-16.zip');


#
# TABLE STRUCTURE FOR: bit
#

DROP TABLE IF EXISTS `bit`;

CREATE TABLE `bit` (
  `subject_code` varchar(10) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `year` varchar(10) NOT NULL,
  `semester` varchar(10) NOT NULL,
  PRIMARY KEY (`subject_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `bit` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('BIT1101', 'subject1', '1', '1sem');


#
# TABLE STRUCTURE FOR: category_data
#

DROP TABLE IF EXISTS `category_data`;

CREATE TABLE `category_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO `category_data` (`id`, `category`) VALUES (3, 'information_system');
INSERT INTO `category_data` (`id`, `category`) VALUES (4, 'computer_science');
INSERT INTO `category_data` (`id`, `category`) VALUES (5, 'software_engineering');


#
# TABLE STRUCTURE FOR: commentst
#

DROP TABLE IF EXISTS `commentst`;

CREATE TABLE `commentst` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(250) DEFAULT NULL,
  `commit` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO `commentst` (`id`, `filename`, `commit`) VALUES (1, 'bitBIT123dilanka21321.pdf', ' 333');
INSERT INTO `commentst` (`id`, `filename`, `commit`) VALUES (2, 'bitBIT123dilanka21321.pdf', ' aaaaaaaaaaaaaa');
INSERT INTO `commentst` (`id`, `filename`, `commit`) VALUES (3, 'bitBIT123dilanka21321.pdf', ' aaaaaaa');
INSERT INTO `commentst` (`id`, `filename`, `commit`) VALUES (4, 'bitBIT123dilanka21321.pdf', ' aaa');
INSERT INTO `commentst` (`id`, `filename`, `commit`) VALUES (5, 'bitBIT123dilanka21321.pdf', ' vbbb');
INSERT INTO `commentst` (`id`, `filename`, `commit`) VALUES (6, 'bitBIT123dilanka21321.pdf', ' ccc');
INSERT INTO `commentst` (`id`, `filename`, `commit`) VALUES (7, 'bitBIT123dilanka21321.pdf', ' ccc');
INSERT INTO `commentst` (`id`, `filename`, `commit`) VALUES (9, 'information_system1111dilanka322.pdf', 'there is an error');
INSERT INTO `commentst` (`id`, `filename`, `commit`) VALUES (10, 'information_system1111dilanka322.pdf', ' sadada');
INSERT INTO `commentst` (`id`, `filename`, `commit`) VALUES (11, 'bitBIT123dilanka21321.pdf', 'first test comment first test comment first test comment first test comment first test comment first test comment first test comment first test comment first test comment first test comment ');
INSERT INTO `commentst` (`id`, `filename`, `commit`) VALUES (12, 'information_system1111dilanka322.pdf', ' test 1 ');
INSERT INTO `commentst` (`id`, `filename`, `commit`) VALUES (13, 'khxfbw.pdf', ' 1');
INSERT INTO `commentst` (`id`, `filename`, `commit`) VALUES (14, 'SCS4225undhead.pdf', ' comment\r\n');


#
# TABLE STRUCTURE FOR: computer_science
#

DROP TABLE IF EXISTS `computer_science`;

CREATE TABLE `computer_science` (
  `subject_code` varchar(10) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `year` varchar(10) NOT NULL,
  `semester` varchar(10) NOT NULL,
  PRIMARY KEY (`subject_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('ENH1201', 'Enhancement I', '1', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('ENH1202', 'Enhancement II', '1', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('ENH2201', 'Enhancement III ', '2', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('ENH3201', 'ndustry Placement/ Industry Project', '3', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS1201', 'Data Structures and Algorithms I ', '1', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS1202', 'Programming Using C ', '1', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS1203', 'Database I', '1', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS1204', 'Discrete Mathematics I', '1', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS1205', 'Computer Systems', '1', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS1206', 'Laboratory I', '1', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS1207', 'Software Engineering I', '1', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS1208', 'Data Structures and Algorithms II', '1', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS1209', 'Object Oriented Programming', '1', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS1210', 'Software Engineering II', '1', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS1211', 'Mathematical Methods I', '1', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS1212', 'Foundation of Computer Science', '1', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS1213', 'Probability and Statistics', '1', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS1214', 'Operating Systems I', '1', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS2201', 'Data Structures and Algorithms III', '2', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS2202', 'Group Project I', '2', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS2203', 'Software Engineering III', '2', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS2204', 'Functional Programming', '2', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS2205', 'Computer Networks I', '2', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS2206', 'Mathematical Methods II', '2', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS2207', 'Programming Language Concepts', '2', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS2208', 'Rapid Application Development', '2', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS2209', 'Database II', '2', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS2210', 'Discrete Mathematics II', '2', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS2211', 'Laboratory II', '2', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS2212', 'Automata Theory', '2', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS2213', 'Electronics and Physical Computing', '2', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS2214', 'Information System Security', '2', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS3201', 'Machine Learning and Neural Computing', '3', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS3202', 'Advanced Computer Architecture', '3', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS3203', 'Middleware Architecture', '3', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS3204', 'Management', '3', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS3205', 'Computer Graphics I', '3', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS3206', 'Graph Theory', '3', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS3207', 'Software Quality Assurance', '3', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS3208', 'Software Project Management', '3', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS3209', 'Human Computer Interaction', '3', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS3210', 'Systems and Network Administration', '3', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS3211', 'Compiler Theory', '3', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS3212', 'Mobile Application Development', '3', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS3213', 'Game Development', '3', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS3214', 'Group Project II ', '3', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS3215', 'Professional Practice', '3', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS3216', 'Research Methods', '3', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS3217', 'Natural Algorithms', '4', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4201', 'Ethical Issues and Legal Aspects in IT', '4', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4202', 'Cognitive Robotics', '4', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4204', 'Data Analytics', '4', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4205', 'Computer Networks II ', '4', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4206', 'Computer Graphics II', '4', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4207', 'Image Processing and Computer Vision', '4', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4208', 'Theory of Computation', '4', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4209', 'Natural Language Processing', '4', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4210', 'Parallel Computing', '4', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4212', 'Formal methods and Software Verification', '4', '1sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4213', 'Digital Forensics', '4', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4214', 'Natural Algorithms', '4', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4215', 'Computational Biology', '4', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4216', 'Advanced Topics in Mathematics', '4', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4217', 'Embedded Systems', '4', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4219', 'Distributed Systems II', '4', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4220', 'Data Structures and Algorithms IV', '4', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4222', 'Logic Programming', '4', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4224', 'Final Year Project in Computer Science* ', '4', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4225', 'Philosophy of Science', '4', '2sem');
INSERT INTO `computer_science` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4226', 'Intelligent Systems', '3', '2sem');


#
# TABLE STRUCTURE FOR: cyber_security
#

DROP TABLE IF EXISTS `cyber_security`;

CREATE TABLE `cyber_security` (
  `subject_code` varchar(10) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `year` varchar(10) NOT NULL,
  `semester` varchar(10) NOT NULL,
  PRIMARY KEY (`subject_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `cyber_security` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('cyb1101', 'subject1', '1', '1sem');


#
# TABLE STRUCTURE FOR: external
#

DROP TABLE IF EXISTS `external`;

CREATE TABLE `external` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `external` (`id`, `category`) VALUES (2, 'bit');


#
# TABLE STRUCTURE FOR: fileupload
#

DROP TABLE IF EXISTS `fileupload`;

CREATE TABLE `fileupload` (
  `file_name` varchar(250) NOT NULL,
  `date_created` varchar(30) NOT NULL,
  `category` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `semester` varchar(30) NOT NULL,
  `academic_year` varchar(70) NOT NULL,
  `subject_code` varchar(70) NOT NULL,
  `author` varchar(10) NOT NULL,
  `comment` varchar(250) NOT NULL,
  `lecturer` varchar(250) NOT NULL,
  `doc_type` varchar(250) NOT NULL,
  PRIMARY KEY (`file_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `fileupload` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('2032File314.pdf', '2020-02-14 (07:21:39pm)', 'null', 0, 'null', '2032', 'null', 'admin', ' ', 'null', 'other');
INSERT INTO `fileupload` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('BIT1101pstlec.pdf', '2020-02-17 (08:31:41am)', 'bit', 1, '1sem', '2018', 'BIT1101', 'admin', ' pstlec', 'pstlec', 'external');
INSERT INTO `fileupload` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('BIT1101undhead.pdf', '2020-02-15 (07:42:13pm)', 'bit', 1, '1sem', '2010', 'BIT1101', 'admin', ' test ext undhead', 'undhead', 'external');
INSERT INTO `fileupload` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('cyb1101pstccmba.pdf', '2020-02-17 (09:39:02am)', 'cyber_security', 1, '1sem', '2015', 'cyb1101', 'admin', ' 000', 'pstccmba', 'post_graduate');
INSERT INTO `fileupload` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('File047.pdf', '2020-02-14 (07:19:42pm)', 'null', 0, 'null', '2020', 'null', 'admin', ' s', 'null', 'other');
INSERT INTO `fileupload` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('hogbqu.pdf', '2020-02-14 (07:14:14pm)', 'null', 0, 'null', '2016', 'null', 'admin', ' ', 'null', 'other');
INSERT INTO `fileupload` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('IS1101pstlec.pdf', '2020-02-14 (09:01:33pm)', 'information_system', 1, '1sem', '2015', 'IS1101', 'admin', ' test1\r\n', 'pstlec', 'under_graduate');
INSERT INTO `fileupload` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('kzetcp.pdf', '2020-02-14 (07:05:16pm)', 'null', 0, 'null', '2013', 'null', 'admin', 'less attendence', 'null', 'other');
INSERT INTO `fileupload` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('Less_Attendance.pdf', '2020-02-14 (07:23:23pm)', 'null', 0, 'null', '2011', 'null', 'admin', ' ', 'null', 'other');
INSERT INTO `fileupload` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('MBA1101admin.pdf', '2020-02-16 (08:58:06am)', 'mba', 1, '1sem', '2017', 'MBA1101', 'admin', ' sad', 'admin', 'post_graduate');
INSERT INTO `fileupload` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('NSC1101qac.pdf', '2020-02-15 (11:05:15pm)', 'ncs_cord', 1, '1sem', '2016', 'NSC1101', 'admin', ' good', 'qac', 'post_graduate');
INSERT INTO `fileupload` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('SCS1201dilanka.pdf', '2020-02-15 (08:43:05pm)', 'computer_science', 1, '1sem', '2013', 'SCS1201', 'admin', ' 3', 'admin', 'under_graduate');
INSERT INTO `fileupload` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('SCS1201undhead.pdf', '2020-02-13 (08:44:55pm)', 'computer_science', 1, '1sem', '2019/2020', 'SCS1201', 'admin', ' test\r\n', 'undhead', 'under_graduate');
INSERT INTO `fileupload` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('SCS1202exthead2015.pdf', '2020-02-17 (09:50:15am)', 'computer_science', 1, '1sem', '2015', 'SCS1202', 'admin', ' hbn', 'exthead', 'under_graduate');
INSERT INTO `fileupload` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('SCS1206undhead.pdf', '2020-02-14 (05:34:37pm)', 'computer_science', 1, '1sem', '21013', 'SCS1206', 'admin', ' ', 'undhead', 'under_graduate');
INSERT INTO `fileupload` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('SCS2209undccse.pdf', '2020-02-14 (09:03:22pm)', 'computer_science', 2, '2sem', '2011', 'SCS2209', 'admin', ' 12', 'undccse', 'under_graduate');
INSERT INTO `fileupload` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('SCS2210psthead.pdf', '2020-02-16 (09:55:46pm)', 'computer_science', 2, '2sem', '2014', 'SCS2210', 'admin', ' -', 'psthead', 'under_graduate');
INSERT INTO `fileupload` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('SCS4221qac.pdf', '2020-02-17 (09:32:58am)', 'software_engineering', 4, '2sem', '1996', 'SCS4221', 'admin', ' web', 'qac', 'under_graduate');
INSERT INTO `fileupload` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('SCS4225undhead.pdf', '2020-02-13 (09:17:50pm)', 'software_engineering', 4, '2sem', '2019/2020', 'SCS4225', 'admin', ' ', 'undhead', 'under_graduate');


#
# TABLE STRUCTURE FOR: information_system
#

DROP TABLE IF EXISTS `information_system`;

CREATE TABLE `information_system` (
  `subject_code` varchar(10) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `year` varchar(10) NOT NULL,
  `semester` varchar(10) NOT NULL,
  PRIMARY KEY (`subject_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `information_system` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('IS1101', 'Programming and Problem Solving', '1', '1sem');


#
# TABLE STRUCTURE FOR: mba
#

DROP TABLE IF EXISTS `mba`;

CREATE TABLE `mba` (
  `subject_code` varchar(10) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `year` varchar(10) NOT NULL,
  `semester` varchar(10) NOT NULL,
  PRIMARY KEY (`subject_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mba` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('MBA1101', 'subject1', '1', '1sem');


#
# TABLE STRUCTURE FOR: messages
#

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(255) NOT NULL,
  `receiver` varchar(255) DEFAULT NULL,
  `msg` varchar(1000) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO `messages` (`id`, `sender`, `receiver`, `msg`, `date`, `time`) VALUES (1, 'sj', 'to_all', ' asad', '2020-01-16', '01:29:19pm');
INSERT INTO `messages` (`id`, `sender`, `receiver`, `msg`, `date`, `time`) VALUES (2, 'dilanka', 'to_all_heads', ' sfs', '2020-02-13', '07:32:53pm');
INSERT INTO `messages` (`id`, `sender`, `receiver`, `msg`, `date`, `time`) VALUES (3, 'dilanka', 'to_all', ' aa', '2020-02-13', '07:35:56pm');
INSERT INTO `messages` (`id`, `sender`, `receiver`, `msg`, `date`, `time`) VALUES (4, 'undhead', 'to_all_undergraduates', ' 333', '2020-02-13', '07:36:37pm');
INSERT INTO `messages` (`id`, `sender`, `receiver`, `msg`, `date`, `time`) VALUES (5, 'undlec', 'to_undergraduate_head', ' sads', '2020-02-13', '07:37:07pm');
INSERT INTO `messages` (`id`, `sender`, `receiver`, `msg`, `date`, `time`) VALUES (6, 'pstlec', 'to_postgraduate_head', ' asdasd', '2020-02-17', '09:30:18am');


#
# TABLE STRUCTURE FOR: mis
#

DROP TABLE IF EXISTS `mis`;

CREATE TABLE `mis` (
  `subject_code` varchar(10) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `year` varchar(10) NOT NULL,
  `semester` varchar(10) NOT NULL,
  PRIMARY KEY (`subject_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mis` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('MIS1101', 'subject1', '1', '1sem');


#
# TABLE STRUCTURE FOR: mit
#

DROP TABLE IF EXISTS `mit`;

CREATE TABLE `mit` (
  `subject_code` varchar(10) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `year` varchar(10) NOT NULL,
  `semester` varchar(10) NOT NULL,
  PRIMARY KEY (`subject_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mit` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('MIT1101', 'subject1', '1', '1sem');


#
# TABLE STRUCTURE FOR: ncs_cord
#

DROP TABLE IF EXISTS `ncs_cord`;

CREATE TABLE `ncs_cord` (
  `subject_code` varchar(10) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `year` varchar(10) NOT NULL,
  `semester` varchar(10) NOT NULL,
  PRIMARY KEY (`subject_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ncs_cord` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('NSC1101', 'subject1', '1', '1sem');


#
# TABLE STRUCTURE FOR: pin
#

DROP TABLE IF EXISTS `pin`;

CREATE TABLE `pin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(250) NOT NULL,
  `actiontype` varchar(250) NOT NULL,
  `code` varchar(5) NOT NULL,
  `msg` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: postgraduate
#

DROP TABLE IF EXISTS `postgraduate`;

CREATE TABLE `postgraduate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO `postgraduate` (`id`, `category`) VALUES (2, 'mba');
INSERT INTO `postgraduate` (`id`, `category`) VALUES (3, 'mit');
INSERT INTO `postgraduate` (`id`, `category`) VALUES (4, 'mis');
INSERT INTO `postgraduate` (`id`, `category`) VALUES (5, 'cyber_security');
INSERT INTO `postgraduate` (`id`, `category`) VALUES (6, 'ncs_cord');


#
# TABLE STRUCTURE FOR: software_engineering
#

DROP TABLE IF EXISTS `software_engineering`;

CREATE TABLE `software_engineering` (
  `subject_code` varchar(10) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `year` varchar(10) NOT NULL,
  `semester` varchar(10) NOT NULL,
  PRIMARY KEY (`subject_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `software_engineering` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4203', 'Database III', '4', '1sem');
INSERT INTO `software_engineering` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4212', 'Formal methods and Software Verification', '4', '1sem');
INSERT INTO `software_engineering` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4221', 'Software Engineering IV', '4', '2sem');
INSERT INTO `software_engineering` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4223', 'Final Year Project in Software Engineering*', '4', '1sem');
INSERT INTO `software_engineering` (`subject_code`, `subject_name`, `year`, `semester`) VALUES ('SCS4225', 'Philosophy of Science', '4', '2sem');


#
# TABLE STRUCTURE FOR: trash
#

DROP TABLE IF EXISTS `trash`;

CREATE TABLE `trash` (
  `file_name` varchar(250) NOT NULL,
  `date_created` varchar(30) NOT NULL,
  `category` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `semester` varchar(30) NOT NULL,
  `academic_year` varchar(70) NOT NULL,
  `subject_code` varchar(70) NOT NULL,
  `author` varchar(10) NOT NULL,
  `comment` varchar(250) NOT NULL,
  `lecturer` varchar(250) NOT NULL,
  `doc_type` varchar(250) NOT NULL,
  PRIMARY KEY (`file_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `trash` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('1101admin.pdf', '2020-02-16 (08:59:21am)', 'cyber_security', 1, '1sem', '2014', '1101', 'admin', ' a', 'admin', 'post_graduate');
INSERT INTO `trash` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('1101undlec.pdf', '2020-02-15 (08:50:31pm)', 'cyber_security', 1, '1sem', '2030', '1101', 'dilanka', ' 36363', 'undlec', 'post_graduate');
INSERT INTO `trash` (`file_name`, `date_created`, `category`, `year`, `semester`, `academic_year`, `subject_code`, `author`, `comment`, `lecturer`, `doc_type`) VALUES ('BIT1101pstccncs.pdf', '2020-02-15 (10:21:35pm)', 'bit', 1, '1sem', '2050', 'BIT1101', 'dilanka', ' asadas', 'pstccncs', 'external');


#
# TABLE STRUCTURE FOR: user
#

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `type` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `post` varchar(100) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `user` (`username`, `password`, `type`, `email`, `post`, `course_name`) VALUES ('admin', '25d55ad283aa400af464c76d713c07ad', 'qac', 'dilankanimsara105@gmail.com', 'qac_head', '');
INSERT INTO `user` (`username`, `password`, `type`, `email`, `post`, `course_name`) VALUES ('extccbit', '25d55ad283aa400af464c76d713c07ad', 'external', 'extccbit@gmail.com', 'course_coordinator', 'bit');
INSERT INTO `user` (`username`, `password`, `type`, `email`, `post`, `course_name`) VALUES ('exthead', '25d55ad283aa400af464c76d713c07ad', 'external', 'exthead@gmail.com', 'head_of_course', '');
INSERT INTO `user` (`username`, `password`, `type`, `email`, `post`, `course_name`) VALUES ('extlec', '25d55ad283aa400af464c76d713c07ad', 'external', 'extlec@gmail.com', 'lecturer', '');
INSERT INTO `user` (`username`, `password`, `type`, `email`, `post`, `course_name`) VALUES ('hdinstitute', '25d55ad283aa400af464c76d713c07ad', 'head_of_institute', 'hdinstitute@gmail.com', 'head_of_institute', '');
INSERT INTO `user` (`username`, `password`, `type`, `email`, `post`, `course_name`) VALUES ('pstccmba', '25d55ad283aa400af464c76d713c07ad', 'post_graduate', 'pstccmba@gmail.com', 'course_coordinator', 'mba');
INSERT INTO `user` (`username`, `password`, `type`, `email`, `post`, `course_name`) VALUES ('pstccmis', '25d55ad283aa400af464c76d713c07ad', 'post_graduate', 'pstccmis@gmail.com', 'course_coordinator', 'mis');
INSERT INTO `user` (`username`, `password`, `type`, `email`, `post`, `course_name`) VALUES ('pstccncs', '25d55ad283aa400af464c76d713c07ad', 'post_graduate', 'pstccncs@gmail.com', 'course_coordinator', 'ncs_cord');
INSERT INTO `user` (`username`, `password`, `type`, `email`, `post`, `course_name`) VALUES ('pstcybercc', '25d55ad283aa400af464c76d713c07ad', 'post_graduate', 'pstcybercc@gmail.com', 'course_coordinator', 'cyber_security');
INSERT INTO `user` (`username`, `password`, `type`, `email`, `post`, `course_name`) VALUES ('psthead', '25d55ad283aa400af464c76d713c07ad', 'post_graduate', 'psthead@gmail.com', 'head_of_course', '');
INSERT INTO `user` (`username`, `password`, `type`, `email`, `post`, `course_name`) VALUES ('pstlec', '25d55ad283aa400af464c76d713c07ad', 'post_graduate', 'pstlec@gmail.com', 'lecturer', '');
INSERT INTO `user` (`username`, `password`, `type`, `email`, `post`, `course_name`) VALUES ('qac', '25d55ad283aa400af464c76d713c07ad', 'qac', 'qac@gmail.com', 'qac', '');
INSERT INTO `user` (`username`, `password`, `type`, `email`, `post`, `course_name`) VALUES ('undcccs', '25d55ad283aa400af464c76d713c07ad', 'under_graduate', 'undcccs@gmail.com', 'course_coordinator', 'computer_science');
INSERT INTO `user` (`username`, `password`, `type`, `email`, `post`, `course_name`) VALUES ('undccis', '25d55ad283aa400af464c76d713c07ad', 'under_graduate', 'undccis@gmail.com', 'course_coordinator', 'information_system');
INSERT INTO `user` (`username`, `password`, `type`, `email`, `post`, `course_name`) VALUES ('undccse', '25d55ad283aa400af464c76d713c07ad', 'under_graduate', 'undccse@gmail.com', 'course_coordinator', 'software_engineering');
INSERT INTO `user` (`username`, `password`, `type`, `email`, `post`, `course_name`) VALUES ('undhead', '25d55ad283aa400af464c76d713c07ad', 'under_graduate', 'undhead@gmail.com', 'head_of_course', '');
INSERT INTO `user` (`username`, `password`, `type`, `email`, `post`, `course_name`) VALUES ('undlec', '25d55ad283aa400af464c76d713c07ad', 'under_graduate', 'undle@gmail.com', 'lecturer', '');


