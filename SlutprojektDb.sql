/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 5.7.31 : Database - handels
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `adminlogin` */

CREATE TABLE `adminlogin` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `hashedPswd` varchar(200) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

/*Data for the table `adminlogin` */

insert  into `adminlogin`(`id`,`username`,`hashedPswd`) values 
(1,'idk','$2y$10$L7TPTeWQJcb8rA3M7XIueuW65wharlouQ7FS2w4cAO1nQK2NgzDIq');

/*Table structure for table `company` */

CREATE TABLE `company` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `companyInfo` varchar(300) DEFAULT NULL,
  `externalUrl` varchar(200) DEFAULT NULL,
  `logoUrl` varchar(200) NOT NULL,
  `foodCheck` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=dec8;

/*Data for the table `company` */

insert  into `company`(`id`,`name`,`companyInfo`,`externalUrl`,`logoUrl`,`foodCheck`) values 
(1,'Company1','This is info about the test company','youtube.com','logo.url',0);

/*Table structure for table `competitions` */

CREATE TABLE `competitions` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `companyId` int(20) NOT NULL,
  `formUrl` varchar(200) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `companyId` (`companyId`),
  CONSTRAINT `competitions_ibfk_1` FOREIGN KEY (`companyId`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

/*Data for the table `competitions` */

/*Table structure for table `offers` */

CREATE TABLE `offers` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `companyId` int(20) NOT NULL,
  `offer` varchar(150) COLLATE utf8_swedish_ci NOT NULL,
  `price` int(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `companyId` (`companyId`),
  CONSTRAINT `offers_ibfk_1` FOREIGN KEY (`companyId`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

/*Data for the table `offers` */

/*Table structure for table `placement` */

CREATE TABLE `placement` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `companyId` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `companyId` (`companyId`),
  CONSTRAINT `placement_ibfk_1` FOREIGN KEY (`companyId`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

/*Data for the table `placement` */

/*Table structure for table `qrcodes` */

CREATE TABLE `qrcodes` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `randomId` varchar(20) COLLATE utf8_swedish_ci NOT NULL,
  `companyUrl` varchar(200) COLLATE utf8_swedish_ci NOT NULL,
  `qrName` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

/*Data for the table `qrcodes` */

insert  into `qrcodes`(`id`,`randomId`,`companyUrl`,`qrName`) values 
(1,'bFDOU','company.com','qr-1');

/*Table structure for table `qrscan` */

CREATE TABLE `qrscan` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `randomId` int(20) NOT NULL,
  `dateTime` datetime NOT NULL,
  `device` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_qr` (`randomId`),
  CONSTRAINT `FK_qr` FOREIGN KEY (`randomId`) REFERENCES `qrcodes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

/*Data for the table `qrscan` */

insert  into `qrscan`(`id`,`randomId`,`dateTime`,`device`) values 
(1,1,'2022-03-30 08:42:22','1');

/*Table structure for table `sponsors` */

CREATE TABLE `sponsors` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `logoUrl` varchar(200) COLLATE utf8_swedish_ci NOT NULL,
  `sponsorUrl` varchar(200) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

/*Data for the table `sponsors` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
