DROP TABLE IF EXISTS `bak_#__xipt_applications`;
CREATE TABLE `bak_#__xipt_applications` SELECT * FROM `#__xipt_applications`;
TRUNCATE TABLE `#__xipt_applications`;
DROP TABLE IF EXISTS `au_#__xipt_applications`;
CREATE TABLE `au_#__xipt_applications` SELECT * FROM `#__xipt_applications`;
