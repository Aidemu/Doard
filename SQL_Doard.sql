/*
Navicat MySQL Data Transfer
Source Host     : localhost:3306
Source Database : doard
Target Host     : localhost:3306
Target Database : doard
Date: 2013-05-09 17:33:05
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for forum_categorie
-- ----------------------------
DROP TABLE IF EXISTS `forum_categorie`;
CREATE TABLE `forum_categorie` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_nom` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `cat_ordre` int(11) NOT NULL,
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `cat_ordre` (`cat_ordre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of forum_categorie
-- ----------------------------
INSERT INTO `forum_categorie` VALUES ('1', 'Général', '30');
INSERT INTO `forum_categorie` VALUES ('2', 'Jeux-Vidéos', '20');
INSERT INTO `forum_categorie` VALUES ('3', 'Autre', '10');

-- ----------------------------
-- Table structure for forum_forum
-- ----------------------------
DROP TABLE IF EXISTS `forum_forum`;
CREATE TABLE `forum_forum` (
  `forum_id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_cat_id` mediumint(8) NOT NULL,
  `forum_name` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `forum_desc` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `forum_ordre` mediumint(8) NOT NULL,
  `forum_last_post_id` int(11) NOT NULL,
  `forum_topic` mediumint(8) NOT NULL,
  `forum_post` mediumint(8) NOT NULL,
  `auth_view` tinyint(4) NOT NULL,
  `auth_post` tinyint(4) NOT NULL,
  `auth_topic` tinyint(4) NOT NULL,
  `auth_annonce` tinyint(4) NOT NULL,
  `auth_modo` tinyint(4) NOT NULL,
  PRIMARY KEY (`forum_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of forum_forum
-- ----------------------------
INSERT INTO `forum_forum` VALUES ('1', '1', 'Présentation', 'Nouveau sur le forum? Venez vous présenter ici !', '60', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `forum_forum` VALUES ('2', '1', 'Les News', 'Les news du site sont ici', '50', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `forum_forum` VALUES ('3', '1', 'Discussions générales', 'Ici on peut parler de tout sur tous les sujets', '40', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `forum_forum` VALUES ('4', '2', 'MMORPG', 'Parlez ici des MMORPG', '60', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `forum_forum` VALUES ('5', '2', 'Autres jeux', 'Forum sur les autres jeux', '50', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `forum_forum` VALUES ('6', '3', 'Loisir', 'Vos loisirs', '60', '4', '1', '4', '0', '0', '0', '0', '0');
INSERT INTO `forum_forum` VALUES ('7', '3', 'Délires', 'Décrivez ici tous vos délires les plus fous', '50', '0', '0', '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for forum_membres
-- ----------------------------
DROP TABLE IF EXISTS `forum_membres`;
CREATE TABLE `forum_membres` (
  `membre_id` int(11) NOT NULL AUTO_INCREMENT,
  `membre_pseudo` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `membre_mdp` varchar(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `membre_email` varchar(250) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `membre_msn` varchar(250) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `membre_siteweb` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `membre_avatar` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `membre_signature` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `membre_localisation` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `membre_inscrit` int(11) NOT NULL,
  `membre_derniere_visite` int(11) NOT NULL,
  `membre_rang` tinyint(4) DEFAULT '2',
  `membre_post` int(11) NOT NULL,
  PRIMARY KEY (`membre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of forum_membres
-- ----------------------------
INSERT INTO `forum_membres` VALUES ('1', 'Derezzed', 'd41d8cd98f00b204e9800998ecf8427e', 'craft.community0@gmail.com', '', '', '1367681434.png', '			La signature est limitée à 200 caractères', 'Toulouse', '1367681166', '1367681166', '2', '0');
INSERT INTO `forum_membres` VALUES ('2', 'noisia', 'd41d8cd98f00b204e9800998ecf8427e', 'venom_worldemu@live.fr', '', '', '1367684347.png', '						La signature est limitée à 200 caractères', '', '1367681786', '1367681786', '2', '4');

-- ----------------------------
-- Table structure for forum_post
-- ----------------------------
DROP TABLE IF EXISTS `forum_post`;
CREATE TABLE `forum_post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_createur` int(11) NOT NULL,
  `post_texte` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `post_time` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `post_forum_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of forum_post
-- ----------------------------
INSERT INTO `forum_post` VALUES ('1', '2', 'test', '1367682666', '1', '6');
INSERT INTO `forum_post` VALUES ('2', '2', 'dfgfdgfdgfdbfvb', '1367683162', '1', '6');
INSERT INTO `forum_post` VALUES ('3', '2', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam faucibus, velit id auctor venenatis, nisl est lobortis odio, sit amet ultricies nibh nulla sed risus. Nunc ac enim lorem, a volutpat tellus. Etiam viverra venenatis arcu nec molestie. Praesent feugiat, libero a congue gravida, lorem velit vulputate nibh, id auctor nulla dolor at velit. Curabitur lacinia hendrerit dignissim. Quisque risus mi, porttitor vitae viverra id, cursus a eros. Duis consectetur ante in lacus congue ut congue est dignissim. Etiam congue ullamcorper quam quis suscipit. Fusce eu massa faucibus risus consequat sagittis. Curabitur commodo adipiscing est a vehicula.\r\n\r\nSuspendisse sem risus, egestas ac cursus nec, aliquam sit amet ligula. Praesent faucibus lobortis urna nec dignissim. Aliquam erat volutpat. Nulla eu arcu dignissim elit tincidunt rhoncus. Donec lectus lorem, gravida ac malesuada sed, porta vel neque. Pellentesque tincidunt iaculis faucibus. Nam pellentesque rutrum purus sit amet tristique. Maecenas quis augue bibendum magna scelerisque tincidunt id eget augue. Sed pharetra dolor orci, tempus porta augue. Donec volutpat interdum rhoncus. Donec aliquet congue accumsan. Fusce sed mi sit amet lacus lobortis scelerisque et vitae elit. Vivamus et tortor vehicula tortor lacinia accumsan in at justo. Nulla a magna eget eros lacinia dignissim et sodales leo. Maecenas nibh leo, bibendum quis imperdiet vitae, pretium a mauris. Nullam diam magna, laoreet eu scelerisque non, porttitor sit amet ante.\r\n\r\nIn hac habitasse platea dictumst. Proin facilisis justo et mi congue ut semper massa luctus. Donec adipiscing sagittis lectus, commodo ultrices quam vestibulum sit amet. Donec quis consectetur metus. Curabitur eget consectetur eros. Phasellus consectetur vehicula arcu vitae porttitor. Nunc neque metus, laoreet nec laoreet at, fringilla vitae lorem. Vivamus egestas pretium velit id ullamcorper. Ut mollis pharetra eros sit amet rutrum. Vestibulum id orci ac justo lobortis ornare sit amet sit amet quam. In accumsan nunc vitae leo convallis commodo. Aliquam erat volutpat. Nam luctus nisi in tellus accumsan at cursus orci vestibulum. Maecenas porttitor consequat ipsum sed sodales. ', '1367683719', '1', '6');
INSERT INTO `forum_post` VALUES ('4', '2', '<p>Test <strong>EDITOR</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<blockquote>\r\n<p>ikjgdfbgdhjydrgf</p>\r\n</blockquote>\r\n\r\n<p>&nbsp;</p>\r\n', '1367685611', '1', '6');

-- ----------------------------
-- Table structure for forum_topic
-- ----------------------------
DROP TABLE IF EXISTS `forum_topic`;
CREATE TABLE `forum_topic` (
  `topic_id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) NOT NULL,
  `topic_titre` char(60) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `topic_createur` int(11) NOT NULL,
  `topic_vu` mediumint(8) NOT NULL,
  `topic_time` int(11) NOT NULL,
  `topic_genre` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `topic_last_post` int(11) NOT NULL,
  `topic_first_post` int(11) NOT NULL,
  `topic_post` mediumint(8) NOT NULL,
  PRIMARY KEY (`topic_id`),
  UNIQUE KEY `topic_last_post` (`topic_last_post`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of forum_topic
-- ----------------------------
INSERT INTO `forum_topic` VALUES ('1', '6', 'Test', '2', '30', '1367682666', 'Message', '4', '1', '3');
