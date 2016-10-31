-- MySQL dump 10.13  Distrib 5.7.9, for linux-glibc2.5 (x86_64)
--
-- Host: 127.0.0.1    Database: aha
-- ------------------------------------------------------
-- Server version	5.6.16

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `article_tag`
--

DROP TABLE IF EXISTS `article_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `tag_id` int(10) NOT NULL COMMENT '标签ID',
  `article_id` int(10) NOT NULL COMMENT '文章ID',
  PRIMARY KEY (`id`),
  KEY `tag_id` (`tag_id`),
  KEY `article_id` (`article_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='文章和标签映射表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_tag`
--

LOCK TABLES `article_tag` WRITE;
/*!40000 ALTER TABLE `article_tag` DISABLE KEYS */;
INSERT INTO `article_tag` VALUES (4,1,3),(12,1,6),(8,4,5),(11,4,4),(10,4,6),(16,1,7),(14,1,4),(15,5,4),(17,5,6),(18,5,7);
/*!40000 ALTER TABLE `article_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(80) COLLATE utf8_unicode_ci NOT NULL COMMENT '标题',
  `thumbnail` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '缩略图',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  `slug` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '网址缩略名',
  `user_id` int(12) DEFAULT NULL COMMENT '文章编辑用户id',
  `category_id` int(10) NOT NULL COMMENT '文章分类id',
  `deleted_at` datetime DEFAULT NULL COMMENT '被软删除时间',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='内容数据（文章/单页）表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES (3,'测试',NULL,'```\r\necho \'Hi Laravel!\';\r\n\r\n\r\n```',NULL,1,1,'2016-05-23 02:21:29','2015-11-19 08:38:40','2016-05-23 02:21:29'),(4,'风从田野上吹过',NULL,'我请求成为天空的孩子\r\n\r\n即使它收回我内心的翅膀\r\n\r\n走过田野，冬意弥深\r\n\r\n风挂落了日子的一些颜色\r\n\r\n酒杯倒塌，无人扶起\r\n\r\n我醉在远方\r\n\r\n姿势泛黄\r\n\r\n麦子孤独地绿了\r\n\r\n容我没有意外地抵达下一个春\r\n\r\n总有个影子立在田头\r\n\r\n我想抽烟\r\n\r\n红高粱回家以后\r\n\r\n有多少土色柔情于我\r\n\r\n生存坐在香案上\r\n\r\n我的爱恨\r\n\r\n生怕提起\r\n\r\n风把我越吹越低\r\n\r\n低到泥里，获取水分\r\n\r\n我希望成为天空的孩子\r\n\r\n仿佛\r\n\r\n也触手可及',NULL,1,1,NULL,'2015-11-19 12:05:31','2015-11-19 13:40:49'),(5,'芒果笔记啊',NULL,'这是芒果笔记的内容\r\n\r\nhttp://note.mango.im',NULL,1,1,NULL,'2015-11-19 13:18:23','2016-08-29 02:43:29'),(6,'我是标题111',NULL,'反对反对方',NULL,1,1,NULL,'2016-05-25 04:29:38','2016-08-26 09:29:18'),(7,'测试添加文章',NULL,'测试文章添加',NULL,1,4,NULL,'2016-08-29 03:59:54','2016-08-29 03:59:54');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `pid` int(10) DEFAULT '0' COMMENT '父级ID',
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL COMMENT '分类名称',
  `slug` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '网址缩略名',
  `sort` int(6) unsigned DEFAULT '0' COMMENT '分类排序,数字越大排名靠前',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='分类表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,0,'生活','',0),(4,0,'技术','',0);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2014_04_24_110151_create_oauth_scopes_table',2),('2014_04_24_110304_create_oauth_grants_table',2),('2014_04_24_110403_create_oauth_grant_scopes_table',2),('2014_04_24_110459_create_oauth_clients_table',2),('2014_04_24_110557_create_oauth_client_endpoints_table',2),('2014_04_24_110705_create_oauth_client_scopes_table',2),('2014_04_24_110817_create_oauth_client_grants_table',2),('2014_04_24_111002_create_oauth_sessions_table',2),('2014_04_24_111109_create_oauth_session_scopes_table',2),('2014_04_24_111254_create_oauth_auth_codes_table',2),('2014_04_24_111403_create_oauth_auth_code_scopes_table',2),('2014_04_24_111518_create_oauth_access_tokens_table',2),('2014_04_24_111657_create_oauth_access_token_scopes_table',2),('2014_04_24_111810_create_oauth_refresh_tokens_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_token_scopes`
--

DROP TABLE IF EXISTS `oauth_access_token_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_access_token_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `access_token_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_access_token_scopes_access_token_id_index` (`access_token_id`),
  KEY `oauth_access_token_scopes_scope_id_index` (`scope_id`),
  CONSTRAINT `oauth_access_token_scopes_access_token_id_foreign` FOREIGN KEY (`access_token_id`) REFERENCES `oauth_access_tokens` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_access_token_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_token_scopes`
--

LOCK TABLES `oauth_access_token_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_access_token_scopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_access_token_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `session_id` int(10) unsigned NOT NULL,
  `expire_time` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_access_tokens_id_session_id_unique` (`id`,`session_id`),
  KEY `oauth_access_tokens_session_id_index` (`session_id`),
  CONSTRAINT `oauth_access_tokens_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth_access_tokens` VALUES ('15rfOOdg88WSgGwMViSB1DrXN7V8Jk7gjXPJsC5x',28,1473133368,'2016-08-30 03:42:48','2016-08-30 03:42:48'),('2Uc3JCc2qxVqiNiWA7kVsXp9HfNq1R1LCuXfOy5y',1,1470054228,'2016-07-25 12:23:48','2016-07-25 12:23:48'),('6Dy2gD8t1eTP2HLwg7mMzFmbD848DZqodZsWgB4g',21,1473132766,'2016-08-30 03:32:46','2016-08-30 03:32:46'),('6NplbdtNbsJ5LReORzOB6tDIpmX5aZS1Cw16GQc0',13,1470822994,'2016-08-03 09:56:34','2016-08-03 09:56:34'),('AY2jTu7wXS3ZlVciEk0hMxHeOE6PHAE1g2hdztx7',27,1473133167,'2016-08-30 03:39:27','2016-08-30 03:39:27'),('bLgRQkzpVyUA8IBtFXdjT18leS7bycnR5njFvXMf',3,1470054409,'2016-07-25 12:26:49','2016-07-25 12:26:49'),('BOA3XI7nyovPVemxACE3KnZ5dtS8QBsUyfTDNsTc',23,1473132884,'2016-08-30 03:34:44','2016-08-30 03:34:44'),('bpkiZxsyOfV6DqzOKl70T8glO3qgOJgfmLczdPDd',25,1473133089,'2016-08-30 03:38:09','2016-08-30 03:38:09'),('ceYE7Bvv0is1oX5Kk7fPa6CXsYiq6SLG0POAfyug',38,1473146484,'2016-08-30 07:21:24','2016-08-30 07:21:24'),('ddy6Ko5ciE7sxUT0g3sXWALnDa39mOTBY8UYnCU3',6,1470819692,'2016-08-03 09:01:32','2016-08-03 09:01:32'),('DraxkQtcXiVuAxrguNo7BGNFaWdEB0eq0BYtPBRS',20,1473132393,'2016-08-30 03:26:33','2016-08-30 03:26:33'),('FnXg1Hmyo9sDEjTQlKLLtiupCwQYX9Nqhq4lsaLr',30,1473133556,'2016-08-30 03:45:56','2016-08-30 03:45:56'),('fSs26D322psbARipI3k4D3eLN9btjJ1QtXez81E5',29,1473133484,'2016-08-30 03:44:44','2016-08-30 03:44:44'),('glcgfVFQPbPvRBWm5fMNrFaS8ABsXYjHUcG6sHhZ',24,1473132905,'2016-08-30 03:35:05','2016-08-30 03:35:05'),('HlubxyCkCeVVHkKuOGbxKFYWrvU0pDlGbm1m2I3r',8,1470819816,'2016-08-03 09:03:36','2016-08-03 09:03:36'),('jyNQhK7EsRvmf6O1mkGesQ3xQEHBS6TVMwXDt05H',22,1473132833,'2016-08-30 03:33:53','2016-08-30 03:33:53'),('L4ffrzden3YnA71rqiqOopsfd3R7PP1nJZAeBEEM',17,1472472868,'2016-08-22 12:14:28','2016-08-22 12:14:28'),('LbhJLo6hBpeNphwdMvmOD5BeIKxhTZCNKPh7YDnM',5,1470818908,'2016-08-03 08:48:28','2016-08-03 08:48:28'),('M4LYY3GJazTd58c1er8l5z5028VeikOy8E9dm4uU',33,1473133702,'2016-08-30 03:48:22','2016-08-30 03:48:22'),('mhZijIJ9H09ERkyXHgf1G3DODTLXtqQZHUNE9Vb6',2,1470054398,'2016-07-25 12:26:38','2016-07-25 12:26:38'),('MlzWTfbtIeeQKh4oky3CB5xl4FS1UJnsLrLIlcuO',15,1470822998,'2016-08-03 09:56:38','2016-08-03 09:56:38'),('okXVUIrU3iDfylYidzYSBeBHrFNFIiUfh7jXNvqw',40,1473146670,'2016-08-30 07:24:30','2016-08-30 07:24:30'),('ORLVggyAkD7g89UgmEheOyYvxs9uFPHmVF3f0N0Z',4,1470818715,'2016-08-03 08:45:15','2016-08-03 08:45:15'),('P2v5tpkbRL5nucIdLl4VcvA0w8gCwN82WAmDTSNB',18,1472472979,'2016-08-22 12:16:19','2016-08-22 12:16:19'),('p9gJOe30BJ64PmtLLAc2RIlvhWLd2ZBToLiiL1oK',10,1470819944,'2016-08-03 09:05:44','2016-08-03 09:05:44'),('pDt9bxucN6kJDOcfkIJ5YBsuSfa0oCrGIRi1BaYE',26,1473133134,'2016-08-30 03:38:54','2016-08-30 03:38:54'),('pjfzn5qSNhRbQBviINfr66vhBemDL0gE9P0NrGzB',37,1473146448,'2016-08-30 07:20:48','2016-08-30 07:20:48'),('PQlW1T4ent3B2CUnYQl56oZji0wNFGayzg2Pzn7V',11,1470820979,'2016-08-03 09:22:59','2016-08-03 09:22:59'),('Qrs6sCWgvCmVDfqGaKvCRDYOqsysWBOScoMxqLer',19,1472561018,'2016-08-23 12:43:38','2016-08-23 12:43:38'),('qSDASbcbA5rXOiJK5Ewj0AwDCTCh62vVHbkPtM5G',35,1473135344,'2016-08-30 04:15:44','2016-08-30 04:15:44'),('r3MHTBpUq93QoOcFhz0n5XjssZPvKmcrWNfeqyaB',36,1473135417,'2016-08-30 04:16:57','2016-08-30 04:16:57'),('rHlH36p5KH0mXojCqxQefT70i16gB9py2CwVrQby',7,1470819815,'2016-08-03 09:03:35','2016-08-03 09:03:35'),('sDKR0IIOmPZ2ZjYTsAunlN3Bf9SjfRLwnruD8UFW',12,1470821448,'2016-08-03 09:30:48','2016-08-03 09:30:48'),('SdPe9ugdpulhfJh9jwzfSGX3grLSdWIwgyNdDPNz',14,1470822996,'2016-08-03 09:56:36','2016-08-03 09:56:36'),('tZMgL9NZMlW2UXpsSRsD6xYE2fOlPK9aOxxJpOtW',9,1470819817,'2016-08-03 09:03:37','2016-08-03 09:03:37'),('V5NiFFdXIUAWLz0YvzZXaVJf87azWVK9E1Szggt1',39,1473146657,'2016-08-30 07:24:17','2016-08-30 07:24:17'),('vKp2aZ7rLeg1U9LkIqgPOtcXb7i9v7kIQMqwrwv9',34,1473133716,'2016-08-30 03:48:36','2016-08-30 03:48:36'),('Vr71OLDKUhrOSoaeDEMxN8L0wKCU43b0b5jEXGQ8',31,1473133588,'2016-08-30 03:46:28','2016-08-30 03:46:28'),('vWu2QwXUDKHzxpIUJn98IjBBeANXBlp0vdEwXIWc',16,1472465969,'2016-08-22 10:19:29','2016-08-22 10:19:29'),('yjtXr3UrLMmAUC18fNJp9iRBD4gVt7IuvgF6kHNf',32,1473133631,'2016-08-30 03:47:11','2016-08-30 03:47:11');
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_code_scopes`
--

DROP TABLE IF EXISTS `oauth_auth_code_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_auth_code_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `auth_code_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_auth_code_scopes_auth_code_id_index` (`auth_code_id`),
  KEY `oauth_auth_code_scopes_scope_id_index` (`scope_id`),
  CONSTRAINT `oauth_auth_code_scopes_auth_code_id_foreign` FOREIGN KEY (`auth_code_id`) REFERENCES `oauth_auth_codes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_auth_code_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_code_scopes`
--

LOCK TABLES `oauth_auth_code_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_code_scopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_code_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `session_id` int(10) unsigned NOT NULL,
  `redirect_uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expire_time` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_session_id_index` (`session_id`),
  CONSTRAINT `oauth_auth_codes_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_client_endpoints`
--

DROP TABLE IF EXISTS `oauth_client_endpoints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_client_endpoints` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `redirect_uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_client_endpoints_client_id_redirect_uri_unique` (`client_id`,`redirect_uri`),
  CONSTRAINT `oauth_client_endpoints_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_client_endpoints`
--

LOCK TABLES `oauth_client_endpoints` WRITE;
/*!40000 ALTER TABLE `oauth_client_endpoints` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_client_endpoints` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_client_grants`
--

DROP TABLE IF EXISTS `oauth_client_grants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_client_grants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `grant_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_client_grants_client_id_index` (`client_id`),
  KEY `oauth_client_grants_grant_id_index` (`grant_id`),
  CONSTRAINT `oauth_client_grants_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `oauth_client_grants_grant_id_foreign` FOREIGN KEY (`grant_id`) REFERENCES `oauth_grants` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_client_grants`
--

LOCK TABLES `oauth_client_grants` WRITE;
/*!40000 ALTER TABLE `oauth_client_grants` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_client_grants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_client_scopes`
--

DROP TABLE IF EXISTS `oauth_client_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_client_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_client_scopes_client_id_index` (`client_id`),
  KEY `oauth_client_scopes_scope_id_index` (`scope_id`),
  CONSTRAINT `oauth_client_scopes_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_client_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_client_scopes`
--

LOCK TABLES `oauth_client_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_client_scopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_client_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_clients` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `secret` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_clients_id_secret_unique` (`id`,`secret`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` VALUES ('f3d259ddd3ed8ff3843839b','4c7f6f8fa93d59c45502c0ae8c4a95b','Main website','2015-05-12 21:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_grant_scopes`
--

DROP TABLE IF EXISTS `oauth_grant_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_grant_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `grant_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_grant_scopes_grant_id_index` (`grant_id`),
  KEY `oauth_grant_scopes_scope_id_index` (`scope_id`),
  CONSTRAINT `oauth_grant_scopes_grant_id_foreign` FOREIGN KEY (`grant_id`) REFERENCES `oauth_grants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_grant_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_grant_scopes`
--

LOCK TABLES `oauth_grant_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_grant_scopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_grant_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_grants`
--

DROP TABLE IF EXISTS `oauth_grants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_grants` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_grants`
--

LOCK TABLES `oauth_grants` WRITE;
/*!40000 ALTER TABLE `oauth_grants` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_grants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `access_token_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `expire_time` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`access_token_id`),
  UNIQUE KEY `oauth_refresh_tokens_id_unique` (`id`),
  CONSTRAINT `oauth_refresh_tokens_access_token_id_foreign` FOREIGN KEY (`access_token_id`) REFERENCES `oauth_access_tokens` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_scopes`
--

DROP TABLE IF EXISTS `oauth_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_scopes` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_scopes`
--

LOCK TABLES `oauth_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_scopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_session_scopes`
--

DROP TABLE IF EXISTS `oauth_session_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_session_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` int(10) unsigned NOT NULL,
  `scope_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_session_scopes_session_id_index` (`session_id`),
  KEY `oauth_session_scopes_scope_id_index` (`scope_id`),
  CONSTRAINT `oauth_session_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_session_scopes_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_session_scopes`
--

LOCK TABLES `oauth_session_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_session_scopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_session_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_sessions`
--

DROP TABLE IF EXISTS `oauth_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_sessions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `owner_type` enum('client','user') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `owner_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_redirect_uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_sessions_client_id_owner_type_owner_id_index` (`client_id`,`owner_type`,`owner_id`),
  CONSTRAINT `oauth_sessions_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_sessions`
--

LOCK TABLES `oauth_sessions` WRITE;
/*!40000 ALTER TABLE `oauth_sessions` DISABLE KEYS */;
INSERT INTO `oauth_sessions` VALUES (1,'f3d259ddd3ed8ff3843839b','user','2',NULL,'2016-07-25 12:23:48','2016-07-25 12:23:48'),(2,'f3d259ddd3ed8ff3843839b','user','2',NULL,'2016-07-25 12:26:38','2016-07-25 12:26:38'),(3,'f3d259ddd3ed8ff3843839b','user','2',NULL,'2016-07-25 12:26:49','2016-07-25 12:26:49'),(4,'f3d259ddd3ed8ff3843839b','user','2',NULL,'2016-08-03 08:45:15','2016-08-03 08:45:15'),(5,'f3d259ddd3ed8ff3843839b','user','2',NULL,'2016-08-03 08:48:28','2016-08-03 08:48:28'),(6,'f3d259ddd3ed8ff3843839b','user','2',NULL,'2016-08-03 09:01:32','2016-08-03 09:01:32'),(7,'f3d259ddd3ed8ff3843839b','user','2',NULL,'2016-08-03 09:03:35','2016-08-03 09:03:35'),(8,'f3d259ddd3ed8ff3843839b','user','2',NULL,'2016-08-03 09:03:36','2016-08-03 09:03:36'),(9,'f3d259ddd3ed8ff3843839b','user','2',NULL,'2016-08-03 09:03:37','2016-08-03 09:03:37'),(10,'f3d259ddd3ed8ff3843839b','user','2',NULL,'2016-08-03 09:05:44','2016-08-03 09:05:44'),(11,'f3d259ddd3ed8ff3843839b','user','2',NULL,'2016-08-03 09:22:59','2016-08-03 09:22:59'),(12,'f3d259ddd3ed8ff3843839b','user','2',NULL,'2016-08-03 09:30:48','2016-08-03 09:30:48'),(13,'f3d259ddd3ed8ff3843839b','user','2',NULL,'2016-08-03 09:56:34','2016-08-03 09:56:34'),(14,'f3d259ddd3ed8ff3843839b','user','2',NULL,'2016-08-03 09:56:36','2016-08-03 09:56:36'),(15,'f3d259ddd3ed8ff3843839b','user','2',NULL,'2016-08-03 09:56:38','2016-08-03 09:56:38'),(16,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-22 10:19:29','2016-08-22 10:19:29'),(17,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-22 12:14:28','2016-08-22 12:14:28'),(18,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-22 12:16:19','2016-08-22 12:16:19'),(19,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-23 12:43:38','2016-08-23 12:43:38'),(20,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 03:26:33','2016-08-30 03:26:33'),(21,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 03:32:46','2016-08-30 03:32:46'),(22,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 03:33:53','2016-08-30 03:33:53'),(23,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 03:34:44','2016-08-30 03:34:44'),(24,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 03:35:05','2016-08-30 03:35:05'),(25,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 03:38:09','2016-08-30 03:38:09'),(26,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 03:38:54','2016-08-30 03:38:54'),(27,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 03:39:27','2016-08-30 03:39:27'),(28,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 03:42:48','2016-08-30 03:42:48'),(29,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 03:44:44','2016-08-30 03:44:44'),(30,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 03:45:56','2016-08-30 03:45:56'),(31,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 03:46:28','2016-08-30 03:46:28'),(32,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 03:47:11','2016-08-30 03:47:11'),(33,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 03:48:22','2016-08-30 03:48:22'),(34,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 03:48:36','2016-08-30 03:48:36'),(35,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 04:15:44','2016-08-30 04:15:44'),(36,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 04:16:57','2016-08-30 04:16:57'),(37,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 07:20:48','2016-08-30 07:20:48'),(38,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 07:21:24','2016-08-30 07:21:24'),(39,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 07:24:17','2016-08-30 07:24:17'),(40,'f3d259ddd3ed8ff3843839b','user','4',NULL,'2016-08-30 07:24:30','2016-08-30 07:24:30');
/*!40000 ALTER TABLE `oauth_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (16,6),(20,5),(20,6),(21,5);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cid` int(10) unsigned DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (5,'admin.user.manage','用户管理','','2016-05-27 09:14:31','2016-08-29 06:17:00',0,'fa-user'),(6,'admin.permission.index','权限列表','','2016-05-27 09:15:01','2016-05-28 04:35:05',5,NULL),(7,'admin.permission.create','添加权限','','2016-05-27 09:15:22','2016-05-27 09:15:22',5,NULL),(8,'admin.permission.edit','修改权限','','2016-05-27 09:15:34','2016-05-27 09:15:34',5,NULL),(9,'admin.permission.destroy ','删除权限','','2016-05-27 09:15:56','2016-05-27 09:15:56',5,NULL),(11,'admin.user.index','用户列表','','2016-05-27 10:55:55','2016-05-27 10:55:55',5,NULL),(12,'admin.user.create','添加用户','','2016-05-27 10:56:10','2016-05-27 10:56:10',5,NULL),(13,'admin.user.edit','编辑用户','','2016-05-27 10:56:26','2016-05-27 10:56:26',5,NULL),(14,'admin.user.destroy','删除用户','','2016-05-27 10:56:44','2016-05-27 10:56:44',5,NULL),(15,'admin.role.index','角色列表','','2016-05-27 10:57:35','2016-05-27 10:57:35',5,NULL),(16,'admin.role.create','添加角色','','2016-05-27 10:57:53','2016-05-27 10:57:53',5,NULL),(17,'admin.role.edit','编辑角色','','2016-05-27 10:58:13','2016-05-27 10:58:13',5,NULL),(18,'admin.role.destroy','删除角色','','2016-05-27 10:58:48','2016-05-27 10:58:48',5,NULL),(19,'admin.article.manage','文章管理','','2016-08-23 10:27:02','2016-08-31 02:58:00',0,'fa-sliders'),(20,'admin.article.index','文章列表','','2016-08-23 10:28:14','2016-08-23 10:28:14',19,NULL),(21,'admin.article.edit','文章编辑','','2016-08-25 09:13:03','2016-08-25 09:13:13',19,NULL);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (2,5),(6,5);
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (5,'测试角色','测试角色','这是测试角色','2016-08-22 12:20:23','2016-08-29 04:17:11'),(6,'角色添加','角色添加','角色添加','2016-08-29 06:30:17','2016-08-29 06:30:17');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL COMMENT '标签名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='标签表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (1,'标签'),(4,'芒果'),(5,'诗');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin@admin.com','$2y$10$66x80Mfjhj4dLCRtmvmSHOPDDtoXoSjJ5zo92nfFqmcPPX7Go/yoW','VjzdZuNkxuHCtJVk2Cbz2UFbCD508UwJGGWZwoXHrof6URgGor1uYqLD3IJf','2016-05-25 05:56:33','2016-08-31 02:59:51'),(2,'test','test@admin.com','$2y$10$66x80Mfjhj4dLCRtmvmSHOPDDtoXoSjJ5zo92nfFqmcPPX7Go/yoW','01sLEmEDAQzph5xwO4Lq3kLEUNn8b4BjnJArvAnZ2iozZOSfkrElAcM0Uid3','2016-05-25 05:56:33','2016-08-29 04:21:02'),(4,'tester','test@test.com','$2y$10$2T8Ilx.YbSOlKEBo3ACOvu/Qd6zDHTbjtyKXi.LzcefOQXGD7ClIG',NULL,'2016-08-22 10:17:57','2016-08-22 10:17:57'),(6,'adduser','adduser@admin.com','$2y$10$aqqfxzySll.jUCPheCuUGuJcixUEHkbKe6N5wnGHa2WY0KtHRyN02',NULL,'2016-08-29 04:31:02','2016-08-29 06:09:39');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-08-31 14:08:09
