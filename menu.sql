SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', '0', '0', 'About us', '');
INSERT INTO `menu` VALUES ('2', '1', '1', 'Person 1', '');
INSERT INTO `menu` VALUES ('3', '2', '0', 'Person 2', '');
INSERT INTO `menu` VALUES ('4', '3', '0', 'My CV', '');
INSERT INTO `menu` VALUES ('5', '4', '4', 'Gallery', '');
INSERT INTO `menu` VALUES ('6', '5', '0', 'Contact us', '');
INSERT INTO `menu` VALUES ('7', '6', '6', 'My pictures', '');
INSERT INTO `menu` VALUES ('8', '7', '6', 'Contactinfo', '');
