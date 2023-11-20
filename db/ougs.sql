/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.5.5-10.4.28-MariaDB : Database - grading_system
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ougs` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `ougs`;

/*Table structure for table `admin_tbl` */

DROP TABLE IF EXISTS `admin_tbl`;

CREATE TABLE `admin_tbl` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `campus_id` int(11) DEFAULT NULL,
  `super_admin` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `email` (`email`),
  KEY `campus_id` (`campus_id`),
  CONSTRAINT `admin_tbl_ibfk_1` FOREIGN KEY (`campus_id`) REFERENCES `campus_tbl` (`campus_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `admin_tbl` */

insert  into `admin_tbl`(`admin_id`,`name`,`email`,`password`,`campus_id`,`super_admin`) values (2,'imran','imran@gmail.com','imran',1,0),(3,'ali','ali@gmail.com','ali',2,0),(7,'admin','admin@gmail.com','admin',NULL,1),(8,'wali','wali@gmail.com','wali',5,0);

/*Table structure for table `assigment_tbl` */

DROP TABLE IF EXISTS `assigment_tbl`;

CREATE TABLE `assigment_tbl` (
  `assigment_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `title` varchar(40) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `last_date` date DEFAULT NULL,
  PRIMARY KEY (`assigment_id`),
  KEY `course_id` (`course_id`),
  KEY `dept_id` (`description`),
  CONSTRAINT `assigment_tbl_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course_tbl` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `assigment_tbl` */

insert  into `assigment_tbl`(`assigment_id`,`course_id`,`title`,`description`,`last_date`) values (1,2,'assigment','c++ programs write 100 plus question on c++ i will wait for more option','2023-06-19'),(2,3,'abc','abc','2023-06-14'),(3,2,'nbb','c++ programs write 100 plus question on c++ i will wait for more option','2023-06-13'),(4,4,'aad','DASDSA','2023-07-02');

/*Table structure for table `attendance_tbl` */

DROP TABLE IF EXISTS `attendance_tbl`;

CREATE TABLE `attendance_tbl` (
  `student_course_id` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date` date NOT NULL,
  `status` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`student_course_id`,`date`),
  CONSTRAINT `attendance_tbl_ibfk_1` FOREIGN KEY (`student_course_id`) REFERENCES `student_course_tbl` (`student_course_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `attendance_tbl` */

insert  into `attendance_tbl`(`student_course_id`,`date`,`status`) values ('2023-06-17 21:45:02','2023-07-10','P'),('2023-06-17 21:45:02','2023-07-23','P'),('2023-06-17 21:45:02','2023-07-25','A'),('2023-07-01 20:42:11','2023-07-23','P'),('2023-07-10 12:31:22','2023-07-23','P'),('2023-07-10 12:31:22','2023-07-25','P'),('2023-07-10 12:31:26','2023-07-23','P'),('2023-07-22 20:57:15','2023-07-23','P'),('2023-07-22 20:57:15','2023-07-25','P'),('2023-07-22 20:57:19','2023-07-23','P');

/*Table structure for table `batch_tbl` */

DROP TABLE IF EXISTS `batch_tbl`;

CREATE TABLE `batch_tbl` (
  `batch_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_id` int(11) DEFAULT NULL,
  `batch_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`batch_id`),
  KEY `dept_id` (`dept_id`),
  CONSTRAINT `dept_tbl_ibfk_2` FOREIGN KEY (`dept_id`) REFERENCES `dept_tbl` (`dept_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `batch_tbl` */

insert  into `batch_tbl`(`batch_id`,`dept_id`,`batch_name`) values (1,1,'20 to 24'),(2,2,'20 to 24'),(3,3,'10'),(4,3,'12'),(5,1,'21 to 25'),(6,5,'23 to 27');

/*Table structure for table `campus_tbl` */

DROP TABLE IF EXISTS `campus_tbl`;

CREATE TABLE `campus_tbl` (
  `campus_id` int(11) NOT NULL AUTO_INCREMENT,
  `campus_name` varchar(30) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`campus_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `campus_tbl` */

insert  into `campus_tbl`(`campus_id`,`campus_name`,`address`,`contact`) values (1,'mingora campus','mingora','03103388069'),(2,'abc','abc','09876543'),(5,'aaa','dfsd','09876543');

/*Table structure for table `course_tbl` */

DROP TABLE IF EXISTS `course_tbl`;

CREATE TABLE `course_tbl` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `total_marks` varchar(20) DEFAULT NULL,
  `chr` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `semester` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`course_id`),
  KEY `batch_id` (`batch_id`),
  KEY `teacher_id` (`teacher_id`),
  CONSTRAINT `course_tbl_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batch_tbl` (`batch_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `course_tbl_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teacher_tbl` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `course_tbl` */

insert  into `course_tbl`(`course_id`,`title`,`batch_id`,`total_marks`,`chr`,`teacher_id`,`semester`) values (2,'c++',1,'100',4,1,'semester 2 '),(3,'dld',1,'100',3,1,'semester 2 '),(4,'urdu',2,'100',4,2,'semester 2'),(5,'urdu',1,'100',3,3,'semester 2 '),(6,'abc',2,'100',3,1,'semester 1'),(7,'English',1,'100',3,2,'semester 2 '),(8,'kp',5,'100',4,1,NULL),(9,'c',6,'100',3,9,'semester 1'),(10,'basic English',6,'100',2,2,'semester 1');

/*Table structure for table `dept_tbl` */

DROP TABLE IF EXISTS `dept_tbl`;

CREATE TABLE `dept_tbl` (
  `dept_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `campus_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`dept_id`),
  KEY `campus_id` (`campus_id`),
  CONSTRAINT `dept_tbl_ibfk_1` FOREIGN KEY (`campus_id`) REFERENCES `campus_tbl` (`campus_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dept_tbl` */

insert  into `dept_tbl`(`dept_id`,`title`,`campus_id`) values (1,'cs',1),(2,'urdu',1),(3,'abc',2),(4,'bbc',2),(5,'English',1);

/*Table structure for table `event_tbl` */

DROP TABLE IF EXISTS `event_tbl`;

CREATE TABLE `event_tbl` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`event_id`),
  KEY `dept_id` (`dept_id`),
  CONSTRAINT `event_tbl_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `dept_tbl` (`dept_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `event_tbl` */

insert  into `event_tbl`(`event_id`,`title`,`description`,`date`,`time`,`dept_id`) values (8,'final year','ggf','2023-06-19','15:59:00',1),(11,'Farewell Party','join the party and Enjoy','2023-06-19','09:01:00',1),(12,'Blood Donation ','join the party and Enjoyjoin the party and Enjoyjoin the party and Enjoyjoin the party and Enjoy','2023-06-12','18:44:00',1),(14,'abc','join the party and Enjoyjoin the party and Enjoyjoin the party and Enjoyjoin the party and Enjoy','2023-07-29','15:27:00',1),(15,'jsbdf','hbsdhs','2023-07-31','17:32:00',1),(16,'final yea','ggf','2023-07-31','06:33:00',1),(17,'abc','a sa','2023-07-31','03:31:00',2),(18,'ns nad','n a sa','2023-07-26','18:35:00',2),(19,'jbbjb','jbjb','2023-07-31','15:36:00',2),(20,'hvvh','hmnvjhv','2023-07-27','19:38:00',5),(21,'hvn','hvbjnvnb','2023-07-17','18:36:00',5);

/*Table structure for table `fee_details_tbl` */

DROP TABLE IF EXISTS `fee_details_tbl`;

CREATE TABLE `fee_details_tbl` (
  `fee_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`fee_details_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `fee_details_tbl` */

insert  into `fee_details_tbl`(`fee_details_id`,`title`,`description`) values (5,'Semester Fee','Now the Semester fee is 15000 submition Date in 15 july.'),(6,'Exame Fee','The Exame fee is 3000 submite your exame fee');

/*Table structure for table `grading_tbl` */

DROP TABLE IF EXISTS `grading_tbl`;

CREATE TABLE `grading_tbl` (
  `grade_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `grade` char(1) DEFAULT NULL,
  `marks` varchar(255) DEFAULT NULL,
  `campus_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`grade_id`),
  KEY `campus_id` (`campus_id`),
  CONSTRAINT `grading_tbl_ibfk_1` FOREIGN KEY (`campus_id`) REFERENCES `campus_tbl` (`campus_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `grading_tbl` */

insert  into `grading_tbl`(`grade_id`,`title`,`grade`,`marks`,`campus_id`) values (11,'Assigment','A','10',NULL),(14,'Quizz','A','5',NULL),(15,'Mid Term','A','25',NULL),(16,'Final Term','A','60',NULL);

/*Table structure for table `result_tbl` */

DROP TABLE IF EXISTS `result_tbl`;

CREATE TABLE `result_tbl` (
  `result_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_course_id` timestamp NULL DEFAULT NULL,
  `mid_marks` int(2) DEFAULT 0,
  `assigment_m` int(2) DEFAULT 0,
  `quizz_marks` int(2) DEFAULT 0,
  `final_marks` int(2) DEFAULT 0,
  `show_status` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`result_id`),
  KEY `student_course_id` (`student_course_id`),
  CONSTRAINT `result_tbl_ibfk_1` FOREIGN KEY (`student_course_id`) REFERENCES `student_course_tbl` (`student_course_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `result_tbl` */

insert  into `result_tbl`(`result_id`,`student_course_id`,`mid_marks`,`assigment_m`,`quizz_marks`,`final_marks`,`show_status`) values (1,'2023-06-17 21:45:02',25,10,5,55,1),(3,'2023-07-01 20:42:11',0,0,0,0,0),(4,'2023-07-10 12:31:22',20,8,4,54,1),(5,'2023-07-10 12:31:26',0,0,0,0,0),(6,'2023-07-10 12:31:30',0,0,0,0,0),(7,'2023-07-22 20:57:01',0,0,0,0,0),(8,'2023-07-22 20:57:15',0,0,0,0,0),(9,'2023-07-22 20:57:19',0,0,0,0,0),(10,'2023-07-25 21:15:58',0,0,0,0,0),(11,'2023-07-25 21:25:44',0,0,0,0,0),(12,'2023-07-25 21:25:46',0,0,0,0,0),(13,'2023-07-26 11:55:36',0,0,0,0,0);

/*Table structure for table `student_course_tbl` */

DROP TABLE IF EXISTS `student_course_tbl`;

CREATE TABLE `student_course_tbl` (
  `student_course_id` timestamp NOT NULL DEFAULT current_timestamp(),
  `course_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  PRIMARY KEY (`course_id`,`student_id`),
  KEY `course_id` (`course_id`),
  KEY `student_id` (`student_id`),
  KEY `student_course_id_idx` (`student_course_id`),
  CONSTRAINT `student_course_tbl_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course_tbl` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `student_course_tbl_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student_tbl` (`std_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `student_course_tbl` */

insert  into `student_course_tbl`(`student_course_id`,`course_id`,`student_id`) values ('2023-06-17 21:45:02',2,1),('2023-07-01 20:42:11',3,1),('2023-07-10 12:31:22',2,3),('2023-07-10 12:31:26',3,3),('2023-07-10 12:31:30',5,3),('2023-07-22 20:57:01',5,1),('2023-07-22 20:57:15',2,2),('2023-07-22 20:57:19',3,2),('2023-07-25 21:15:58',8,4),('2023-07-25 21:25:44',9,5),('2023-07-25 21:25:46',10,5),('2023-07-26 11:55:36',7,1);

/*Table structure for table `student_fee_tbl` */

DROP TABLE IF EXISTS `student_fee_tbl`;

CREATE TABLE `student_fee_tbl` (
  `fee_id` int(11) NOT NULL AUTO_INCREMENT,
  `std_id` int(11) DEFAULT NULL,
  `semester` varchar(50) DEFAULT NULL,
  `amount` varchar(100) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`fee_id`),
  KEY `std_id` (`std_id`),
  CONSTRAINT `student_fee_tbl_ibfk_1` FOREIGN KEY (`std_id`) REFERENCES `student_tbl` (`std_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `student_fee_tbl` */

insert  into `student_fee_tbl`(`fee_id`,`std_id`,`semester`,`amount`,`date`) values (19,1,'semester 1','5000','23-07-26'),(20,1,'semester 2','5000','23-07-26');

/*Table structure for table `student_tbl` */

DROP TABLE IF EXISTS `student_tbl`;

CREATE TABLE `student_tbl` (
  `std_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `campus_id` int(11) DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `semester` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`std_id`),
  UNIQUE KEY `email` (`email`),
  KEY `campus_id` (`campus_id`),
  KEY `batch_id` (`batch_id`),
  CONSTRAINT `student_tbl_ibfk_1` FOREIGN KEY (`campus_id`) REFERENCES `campus_tbl` (`campus_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `student_tbl_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batch_tbl` (`batch_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `student_tbl` */

insert  into `student_tbl`(`std_id`,`name`,`email`,`password`,`address`,`contact`,`campus_id`,`batch_id`,`semester`) values (1,'imran','imran@gmail.com','imran','mingora','03103388069',1,1,'semester 1'),(2,'ali','ali@gmail.com','ali','sa','0987654',1,1,'semester 2'),(3,'abc','abc@gmail.com','abc','abc','0987654245',1,1,'semester 3'),(4,'aa','aa@gmail.com','aa','swat','0987654245',1,5,'semester 3'),(5,'luqman','luqman@gmail.com','luqman','abc','0987654245',1,6,'semester 4'),(6,'samadk','samadk@gmail.com','sa','dfsd','09876543',1,1,'semester 1 ');

/*Table structure for table `teacher_tbl` */

DROP TABLE IF EXISTS `teacher_tbl`;

CREATE TABLE `teacher_tbl` (
  `teacher_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `campus_id` int(11) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`teacher_id`),
  UNIQUE KEY `email` (`email`),
  KEY `campus_id` (`campus_id`),
  KEY `teacher_tbl_ibfk_2` (`dept_id`),
  CONSTRAINT `teacher_tbl_ibfk_1` FOREIGN KEY (`campus_id`) REFERENCES `campus_tbl` (`campus_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `teacher_tbl_ibfk_2` FOREIGN KEY (`dept_id`) REFERENCES `dept_tbl` (`dept_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `teacher_tbl` */

insert  into `teacher_tbl`(`teacher_id`,`name`,`email`,`contact`,`password`,`campus_id`,`dept_id`) values (1,'imran','imran@gmail.com','0987654321','imran',1,1),(2,'ali','ali@gmail.com','0987654321','ali',1,2),(3,'wali','wali@gmail.com','098765432','wali',1,1),(8,'abc','abc@gmail.com','98765432','abc',1,3),(9,'nouman','nouman@gmail.com','098765432','nouman',1,5),(10,'samad','samad@gmail.com','0987654321','samad',1,2);

/*Table structure for table `time_tbl` */

DROP TABLE IF EXISTS `time_tbl`;

CREATE TABLE `time_tbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `start_time` varchar(255) DEFAULT NULL,
  `end_time` varchar(255) DEFAULT NULL,
  `campus_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `campus_id` (`campus_id`),
  CONSTRAINT `time_tbl_ibfk_1` FOREIGN KEY (`campus_id`) REFERENCES `campus_tbl` (`campus_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `time_tbl` */

insert  into `time_tbl`(`id`,`title`,`start_time`,`end_time`,`campus_id`) values (3,'class ist ','9:00','10:00',NULL),(4,'class 2nd','10:00','11:00',NULL),(5,'class 3rd','11:00','12:00',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
