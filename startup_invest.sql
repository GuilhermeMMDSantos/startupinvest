# SQL-Front 5.1  (Build 4.16)

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;


# Host: 127.0.0.1    Database: startup_invest
# ------------------------------------------------------
# Server version 5.5.5-10.1.32-MariaDB

#
# Source for table areas_formacao
#

DROP TABLE IF EXISTS `areas_formacao`;
CREATE TABLE `areas_formacao` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table areas_formacao
#

INSERT INTO `areas_formacao` VALUES (1,'Administra??o','2022-03-28 10:38:12','2022-03-28 10:38:12');
INSERT INTO `areas_formacao` VALUES (2,'Finan?as','2022-03-28 10:38:34','2022-03-28 10:38:34');
INSERT INTO `areas_formacao` VALUES (3,'Economia','2022-03-28 10:41:33','2022-03-28 10:41:33');

#
# Source for table cargos_executivo
#

DROP TABLE IF EXISTS `cargos_executivo`;
CREATE TABLE `cargos_executivo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sigla` varchar(255) NOT NULL DEFAULT '',
  `descricao` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table cargos_executivo
#

INSERT INTO `cargos_executivo` VALUES (1,'CEO','Director Geral','2022-03-26 15:21:15','2022-03-26 15:21:15');
INSERT INTO `cargos_executivo` VALUES (2,'CTO','Diretor De Tecnologia','2022-03-26 15:21:49','2022-03-26 15:24:36');
INSERT INTO `cargos_executivo` VALUES (3,'CFO','Director Financeiro','2022-03-26 15:24:01','2022-03-26 15:24:01');

#
# Source for table certificados_formacao
#

DROP TABLE IF EXISTS `certificados_formacao`;
CREATE TABLE `certificados_formacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='Para qualquer forma??o existe um certificado(licenciatura,doutoramento,fluencia em ingles)';

#
# Dumping data for table certificados_formacao
#

INSERT INTO `certificados_formacao` VALUES (1,'Licenciatura','2022-03-28 10:33:37','2022-03-28 10:33:37');
INSERT INTO `certificados_formacao` VALUES (2,'Doutoramento','2022-03-28 10:33:54','2022-03-28 10:33:54');
INSERT INTO `certificados_formacao` VALUES (3,'T?cnico','2022-03-28 10:34:55','2022-03-28 10:34:55');
INSERT INTO `certificados_formacao` VALUES (4,'lina','2022-03-30 14:50:52','2022-03-30 14:50:52');
INSERT INTO `certificados_formacao` VALUES (5,'lita','2022-03-30 14:50:59','2022-03-30 14:50:59');

#
# Source for table experiencia_membro_equipa
#

DROP TABLE IF EXISTS `experiencia_membro_equipa`;
CREATE TABLE `experiencia_membro_equipa` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fk_membro_equipa` bigint(20) NOT NULL DEFAULT '0',
  `fk_funcao` bigint(20) NOT NULL DEFAULT '0',
  `fk_instituicao` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table experiencia_membro_equipa
#

INSERT INTO `experiencia_membro_equipa` VALUES (1,5,1,1,'2024-03-06 16:26:28','2024-03-06 16:26:28');
INSERT INTO `experiencia_membro_equipa` VALUES (2,9,2,2,'2024-03-07 11:00:56','2024-03-07 11:00:56');
INSERT INTO `experiencia_membro_equipa` VALUES (3,10,3,3,'2024-03-07 11:09:21','2024-03-07 11:09:21');
INSERT INTO `experiencia_membro_equipa` VALUES (4,10,4,4,'2024-03-07 11:09:21','2024-03-07 11:09:21');
INSERT INTO `experiencia_membro_equipa` VALUES (5,16,5,5,'2024-03-07 19:03:35','2024-03-07 19:03:35');
INSERT INTO `experiencia_membro_equipa` VALUES (6,16,6,6,'2024-03-07 19:03:35','2024-03-07 19:03:35');

#
# Source for table fases_desenvolvimento
#

DROP TABLE IF EXISTS `fases_desenvolvimento`;
CREATE TABLE `fases_desenvolvimento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table fases_desenvolvimento
#

INSERT INTO `fases_desenvolvimento` VALUES (1,'Projecto-Opera??o','2022-02-16 14:29:12','2022-02-16 14:29:12');
INSERT INTO `fases_desenvolvimento` VALUES (2,'Opera??o','2022-02-16 14:29:32','2022-02-16 14:29:32');
INSERT INTO `fases_desenvolvimento` VALUES (3,'Tra??o','2022-02-16 14:29:55','2022-02-16 14:29:55');

#
# Source for table finalidades_investimento
#

DROP TABLE IF EXISTS `finalidades_investimento`;
CREATE TABLE `finalidades_investimento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_rodada` int(11) NOT NULL DEFAULT '0',
  `item` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_att` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table finalidades_investimento
#


#
# Source for table formacao_membro_equipa
#

DROP TABLE IF EXISTS `formacao_membro_equipa`;
CREATE TABLE `formacao_membro_equipa` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fk_membro_equipa` int(11) NOT NULL DEFAULT '0',
  `fk_area_formacao` bigint(20) NOT NULL DEFAULT '0',
  `fk_certificado_formacao` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table formacao_membro_equipa
#

INSERT INTO `formacao_membro_equipa` VALUES (1,5,2,1,'2024-03-06 16:26:27','2024-03-06 16:26:27');
INSERT INTO `formacao_membro_equipa` VALUES (2,6,2,1,'2024-03-07 06:04:14','2024-03-07 06:04:14');
INSERT INTO `formacao_membro_equipa` VALUES (3,9,2,1,'2024-03-07 11:00:56','2024-03-07 11:00:56');
INSERT INTO `formacao_membro_equipa` VALUES (4,9,3,2,'2024-03-07 11:00:56','2024-03-07 11:00:56');
INSERT INTO `formacao_membro_equipa` VALUES (5,10,1,1,'2024-03-07 11:09:21','2024-03-07 11:09:21');
INSERT INTO `formacao_membro_equipa` VALUES (6,10,3,2,'2024-03-07 11:09:21','2024-03-07 11:09:21');
INSERT INTO `formacao_membro_equipa` VALUES (7,16,2,1,'2024-03-07 19:03:35','2024-03-07 19:03:35');
INSERT INTO `formacao_membro_equipa` VALUES (8,16,3,2,'2024-03-07 19:03:35','2024-03-07 19:03:35');

#
# Source for table funcoes_experiencia
#

DROP TABLE IF EXISTS `funcoes_experiencia`;
CREATE TABLE `funcoes_experiencia` (
  `id` bigint(1) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `outro` enum('yes','no') NOT NULL DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table funcoes_experiencia
#

INSERT INTO `funcoes_experiencia` VALUES (1,'Gestor','yes','2024-03-06 16:26:28','2024-03-06 16:26:28');
INSERT INTO `funcoes_experiencia` VALUES (2,'Gestor','yes','2024-03-07 11:00:56','2024-03-07 11:00:56');
INSERT INTO `funcoes_experiencia` VALUES (3,'Gestor','yes','2024-03-07 11:09:21','2024-03-07 11:09:21');
INSERT INTO `funcoes_experiencia` VALUES (4,'Administrador','yes','2024-03-07 11:09:21','2024-03-07 11:09:21');
INSERT INTO `funcoes_experiencia` VALUES (5,'Gestor','yes','2024-03-07 19:03:35','2024-03-07 19:03:35');
INSERT INTO `funcoes_experiencia` VALUES (6,'Administrador','yes','2024-03-07 19:03:35','2024-03-07 19:03:35');

#
# Source for table instituicoes_experincia
#

DROP TABLE IF EXISTS `instituicoes_experincia`;
CREATE TABLE `instituicoes_experincia` (
  `id` bigint(1) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `outro` enum('yes','no') NOT NULL DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table instituicoes_experincia
#

INSERT INTO `instituicoes_experincia` VALUES (1,'BAI','no','2022-06-14 18:25:20','2022-07-05 09:48:27');
INSERT INTO `instituicoes_experincia` VALUES (2,'0','yes','2022-07-05 11:42:54','2022-07-05 11:42:54');
INSERT INTO `instituicoes_experincia` VALUES (3,'DIGITAL FACTORY','yes','2022-07-05 11:45:21','2022-07-05 11:45:21');
INSERT INTO `instituicoes_experincia` VALUES (4,'cc','yes','2022-07-05 12:04:15','2022-07-05 12:04:15');
INSERT INTO `instituicoes_experincia` VALUES (5,'BAI','yes','2022-08-01 15:54:17','2022-08-01 15:54:17');
INSERT INTO `instituicoes_experincia` VALUES (6,'AGT','yes','2022-08-01 15:55:27','2022-08-01 15:55:27');
INSERT INTO `instituicoes_experincia` VALUES (7,'BAI','yes','2022-08-01 15:55:27','2022-08-01 15:55:27');

#
# Source for table investidores
#

DROP TABLE IF EXISTS `investidores`;
CREATE TABLE `investidores` (
  `fk_user` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome_completo` varchar(255) NOT NULL DEFAULT '',
  `bilhete_identidade` varchar(255) NOT NULL DEFAULT '',
  `foto` varchar(255) NOT NULL DEFAULT '',
  `video_investidor` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fk_user`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COMMENT='Esta tabela consta os potenciais investidores/investidores na plataforma. J? a tabela investidores da startup, armazena pessoas que nvestiram de facto na startup';

#
# Dumping data for table investidores
#

INSERT INTO `investidores` VALUES (2,'Joel Agostinho Martins','armazenamento/investidor/bilhete_identidade/bi_investidor0606030320242024090520.pdf','armazenamento/investidor/img/img_standard_investidor.png','armazenamento/investidor/videos/video_investidor0606030320242024090520.mp4','2024-03-06 09:05:22','2024-03-16 21:38:45');
INSERT INTO `investidores` VALUES (5,'Guilherme Miranda Martins Dos Santos','armazenamento/investidor/bilhete_identidade/bi_investidor0606030320242024092256.pdf','armazenamento/investidor/img/img_standard_investidor.png','armazenamento/investidor/videos/video_investidor0606030320242024092256.mp4','2024-03-06 09:23:51','2024-03-16 21:39:12');
INSERT INTO `investidores` VALUES (7,'outro','armazenamento/investidor/bilhete_identidade/bi_investidor0909030320242024094311.pdf','armazenamento/investidor/img/img_standard_investidor.png','armazenamento/investidor/videos/video_investidor0909030320242024094311.mp4','2024-03-09 21:43:12','2024-03-09 21:43:12');
INSERT INTO `investidores` VALUES (9,'AD?O DE ALM?IDA JOS?','armazenamento/investidor/bilhete_identidade/bi_investidor2424030320242024042818.pdf','armazenamento/investidor/img/img_standard_investidor.png','armazenamento/investidor/videos/video_investidor2424030320242024042818.mp4','2024-03-24 16:28:38','2024-03-24 16:28:38');
INSERT INTO `investidores` VALUES (13,'devolve','armazenamento/investidor/bilhete_identidade/bi_investidor0808040420242024112918.pdf','armazenamento/investidor/img/img_standard_investidor.png','armazenamento/investidor/videos/video_investidor0808040420242024112918.mp4','2024-04-08 11:29:29','2024-04-08 11:29:29');
INSERT INTO `investidores` VALUES (16,'Lucas Modric','armazenamento/investidor/bilhete_identidade/bi_investidor2323040420242024074047.pdf','armazenamento/investidor/img/img_standard_investidor.png','armazenamento/investidor/videos/video_investidor2323040420242024074047.mp4','2024-04-23 19:40:47','2024-04-23 19:40:47');
INSERT INTO `investidores` VALUES (18,'Fragoso Martins','armazenamento/investidor/bilhete_identidade/bi_investidor2323040420242024080447.pdf','armazenamento/investidor/img/img_standard_investidor.png','armazenamento/investidor/videos/video_investidor2323040420242024080447.mp4','2024-04-23 20:04:48','2024-04-23 20:04:48');

#
# Source for table investidores_da_startup
#

DROP TABLE IF EXISTS `investidores_da_startup`;
CREATE TABLE `investidores_da_startup` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '',
  `nome` varchar(255) NOT NULL DEFAULT '',
  `sobrenome` varchar(255) DEFAULT NULL,
  `fk_startup` bigint(20) NOT NULL DEFAULT '0',
  `porcentagem_na_startup` int(11) NOT NULL DEFAULT '0',
  `tipo_entidade` enum('F?sica','Jur?dica') NOT NULL DEFAULT 'F?sica',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COMMENT='Esta tabela consta os potenciais investidores/investidores na plataforma. J? a tabela investidores da startup, armazena pessoas que nvestiram de facto na startup';

#
# Dumping data for table investidores_da_startup
#

INSERT INTO `investidores_da_startup` VALUES (18,'emis@hotmail.com','EMIS S.A',NULL,6,2,'','2024-03-20 12:55:36','2024-04-18 22:41:43');
INSERT INTO `investidores_da_startup` VALUES (19,'bai@hotmail.com','BAI S.A',NULL,6,2,'','2024-03-20 12:55:36','2024-04-18 22:42:30');
INSERT INTO `investidores_da_startup` VALUES (20,'sonangol@hotmail.com','SONANGOL',NULL,6,2,'','2024-03-20 12:55:36','2024-04-18 22:42:39');
INSERT INTO `investidores_da_startup` VALUES (21,'emirates@hotmail.com','EMIRATES','',6,2,'','2024-03-20 12:55:36','2024-04-18 22:42:48');
INSERT INTO `investidores_da_startup` VALUES (22,'unitel@hotmail.com','UNITEL S.A',NULL,6,2,'','2024-03-20 12:55:36','2024-04-18 22:42:56');

#
# Source for table membros_equipa_startup
#

DROP TABLE IF EXISTS `membros_equipa_startup`;
CREATE TABLE `membros_equipa_startup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `sobrenome` varchar(255) NOT NULL DEFAULT '',
  `fk_startup` bigint(20) NOT NULL DEFAULT '0',
  `img` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table membros_equipa_startup
#

INSERT INTO `membros_equipa_startup` VALUES (12,'Lucas','Modric',6,'armazenamento/startups/img/membros/img_standard_membro_equipa.png','2024-03-07 11:44:08','2024-03-07 11:44:08');
INSERT INTO `membros_equipa_startup` VALUES (16,'Guilherme','Dos Santos',6,'armazenamento/startups/img/membros/img_standard_membro_equipa.png','2024-03-07 19:03:35','2024-03-07 19:03:35');

#
# Source for table membrosequipa_cargosexecutivo_m_m
#

DROP TABLE IF EXISTS `membrosequipa_cargosexecutivo_m_m`;
CREATE TABLE `membrosequipa_cargosexecutivo_m_m` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_cargo_executivo` int(11) NOT NULL DEFAULT '0',
  `fk_membro_equipa` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table membrosequipa_cargosexecutivo_m_m
#

INSERT INTO `membrosequipa_cargosexecutivo_m_m` VALUES (10,1,12,'2024-03-07 11:44:08','2024-03-07 11:44:08');
INSERT INTO `membrosequipa_cargosexecutivo_m_m` VALUES (14,3,16,'2024-03-07 19:03:35','2024-03-07 19:03:35');

#
# Source for table mensagens
#

DROP TABLE IF EXISTS `mensagens`;
CREATE TABLE `mensagens` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fk_remetente` bigint(20) NOT NULL DEFAULT '0',
  `fk_destinatario` bigint(20) NOT NULL DEFAULT '0',
  `conteudo` varchar(10000) NOT NULL DEFAULT '',
  `vista` enum('sim','nao') NOT NULL DEFAULT 'nao',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table mensagens
#

INSERT INTO `mensagens` VALUES (1,2,6,'Boa tarde emp','sim','2024-04-23 17:36:43','2024-09-16 22:21:51');
INSERT INTO `mensagens` VALUES (2,6,2,'tudo numa','sim','2024-04-23 17:36:59','2024-06-06 20:28:24');

#
# Source for table migrations
#

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Dumping data for table migrations
#


#
# Source for table notifications
#

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `message` varchar(255) NOT NULL DEFAULT '',
  `fk_user_distination` bigint(20) NOT NULL DEFAULT '0',
  `fk_user_origin` bigint(20) NOT NULL DEFAULT '0',
  `tipo` enum('ver_pitch','foi_investido','talk_apos_pitch') NOT NULL DEFAULT 'ver_pitch',
  `status` enum('nao_visto','visto','clicado') NOT NULL DEFAULT 'nao_visto',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table notifications
#

INSERT INTO `notifications` VALUES (1,'Investidor  deseja assistir vosso pitch!',6,2,'ver_pitch','clicado','2024-04-22 13:57:52','2024-04-22 13:58:09');
INSERT INTO `notifications` VALUES (2,'A startup startupInveste aceitou sua solicita??o para ver o pitch.',2,6,'ver_pitch','clicado','2024-04-22 13:58:14','2024-04-22 14:10:25');
INSERT INTO `notifications` VALUES (3,'Investidor  deseja assistir vosso pitch!',6,2,'ver_pitch','clicado','2024-04-23 17:34:03','2024-04-23 17:34:16');
INSERT INTO `notifications` VALUES (4,'A startup startupInveste aceitou sua solicita??o para ver o pitch.',2,6,'ver_pitch','clicado','2024-04-23 17:34:37','2024-04-23 17:36:16');
INSERT INTO `notifications` VALUES (5,'Investidor  deseja assistir vosso pitch!',6,2,'ver_pitch','clicado','2024-04-28 16:58:59','2024-04-28 17:01:10');
INSERT INTO `notifications` VALUES (6,'A startup startupInveste aceitou sua solicita??o para ver o pitch.',2,6,'ver_pitch','visto','2024-04-28 17:01:13','2024-04-28 18:07:16');
INSERT INTO `notifications` VALUES (7,'Investidor  deseja assistir vosso pitch!',6,2,'ver_pitch','clicado','2024-04-29 11:05:15','2024-04-29 11:08:54');
INSERT INTO `notifications` VALUES (8,'A startup startupInveste aceitou sua solicita??o para ver o pitch.',2,6,'ver_pitch','clicado','2024-04-29 11:08:58','2024-04-29 12:55:43');
INSERT INTO `notifications` VALUES (9,'Investidor  deseja assistir vosso pitch!',6,2,'ver_pitch','visto','2024-04-29 12:57:10','2024-05-04 21:28:24');
INSERT INTO `notifications` VALUES (10,'Investidor  deseja assistir vosso pitch!',6,2,'ver_pitch','clicado','2024-05-05 23:32:21','2024-05-05 23:32:30');
INSERT INTO `notifications` VALUES (11,'A startup startupInveste aceitou sua solicita??o para ver o pitch.',2,6,'ver_pitch','visto','2024-05-05 23:32:34','2024-05-06 10:17:52');
INSERT INTO `notifications` VALUES (12,'Investidor  deseja assistir vosso pitch!',6,9,'ver_pitch','clicado','2024-05-06 01:23:53','2024-05-06 01:24:03');
INSERT INTO `notifications` VALUES (13,'A startup startupInveste aceitou sua solicita??o para ver o pitch.',9,6,'ver_pitch','visto','2024-05-06 01:24:06','2024-05-06 01:30:49');
INSERT INTO `notifications` VALUES (14,'Investidor  deseja assistir vosso pitch!',23,9,'ver_pitch','clicado','2024-05-06 03:20:37','2024-05-06 03:20:46');
INSERT INTO `notifications` VALUES (15,'A startup teste aceitou sua solicita??o para ver o pitch.',9,23,'ver_pitch','visto','2024-05-06 03:20:50','2024-05-06 03:27:40');
INSERT INTO `notifications` VALUES (16,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 07:13:57','2024-05-06 07:14:43');
INSERT INTO `notifications` VALUES (17,'A startup teste aceitou sua solicita??o para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 07:14:46','2024-05-06 10:17:52');
INSERT INTO `notifications` VALUES (18,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 07:51:42','2024-05-06 07:51:52');
INSERT INTO `notifications` VALUES (19,'A startup teste aceitou sua solicita??o para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 07:58:16','2024-05-06 10:17:52');
INSERT INTO `notifications` VALUES (20,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 11:20:47','2024-05-06 11:20:55');
INSERT INTO `notifications` VALUES (21,'A startup teste aceitou sua solicita??o para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 11:21:00','2024-06-06 20:26:55');
INSERT INTO `notifications` VALUES (22,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 11:48:52','2024-05-06 11:49:01');
INSERT INTO `notifications` VALUES (23,'A startup teste aceitou sua solicita??o para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 11:49:06','2024-06-06 20:26:55');
INSERT INTO `notifications` VALUES (24,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 11:56:47','2024-05-06 11:56:58');
INSERT INTO `notifications` VALUES (25,'A startup teste aceitou sua solicita??o para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 11:57:01','2024-06-06 20:26:55');
INSERT INTO `notifications` VALUES (26,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 12:41:22','2024-05-06 12:41:34');
INSERT INTO `notifications` VALUES (27,'A startup teste aceitou sua solicita??o para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 12:41:38','2024-06-06 20:26:55');
INSERT INTO `notifications` VALUES (28,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 13:54:33','2024-05-06 13:54:41');
INSERT INTO `notifications` VALUES (29,'A startup teste aceitou sua solicita??o para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 13:54:46','2024-06-06 20:26:55');
INSERT INTO `notifications` VALUES (30,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 13:59:16','2024-05-06 13:59:25');
INSERT INTO `notifications` VALUES (31,'A startup teste aceitou sua solicita??o para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 13:59:29','2024-06-06 20:26:55');
INSERT INTO `notifications` VALUES (32,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 14:04:22','2024-05-06 14:09:10');
INSERT INTO `notifications` VALUES (33,'A startup teste aceitou sua solicita??o para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 14:09:14','2024-06-06 20:26:55');
INSERT INTO `notifications` VALUES (34,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 14:16:34','2024-05-06 14:16:46');
INSERT INTO `notifications` VALUES (35,'A startup teste aceitou sua solicita??o para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 14:16:51','2024-06-06 20:26:55');
INSERT INTO `notifications` VALUES (36,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 16:58:03','2024-05-06 16:58:20');
INSERT INTO `notifications` VALUES (37,'A startup teste aceitou sua solicita??o para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 16:58:24','2024-06-06 20:26:55');

#
# Source for table permissoes_ver_pitch
#

DROP TABLE IF EXISTS `permissoes_ver_pitch`;
CREATE TABLE `permissoes_ver_pitch` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fk_startup` bigint(20) NOT NULL DEFAULT '0',
  `fk_investidor` bigint(20) NOT NULL DEFAULT '0',
  `fk_rodada` bigint(11) NOT NULL DEFAULT '0',
  `data_permissao` datetime NOT NULL DEFAULT '1997-03-25 00:00:00',
  `estado` enum('espera','ignorado','ativo','vencido') NOT NULL DEFAULT 'espera' COMMENT 'pedido de permiss?o que fiquem em espera por 48h(com base a data de cria??o) ser? dado como ignorado. Para quem tiver permiss?o(ativo) tem 24h e depois estar? vencido',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table permissoes_ver_pitch
#

INSERT INTO `permissoes_ver_pitch` VALUES (1,6,2,1,'1997-03-25','vencido','2024-04-23 17:34:03','2024-07-04 20:43:21');
INSERT INTO `permissoes_ver_pitch` VALUES (2,6,2,16,'1997-03-25','vencido','2024-04-28 16:58:59','2024-07-04 20:43:21');
INSERT INTO `permissoes_ver_pitch` VALUES (3,6,2,17,'1997-03-25','vencido','2024-04-29 11:05:15','2024-07-04 20:43:21');
INSERT INTO `permissoes_ver_pitch` VALUES (4,6,2,15,'1997-03-25','vencido','2024-04-29 12:57:10','2024-07-04 20:43:21');
INSERT INTO `permissoes_ver_pitch` VALUES (5,6,2,26,'1997-03-25','vencido','2024-05-05 23:32:22','2024-07-04 20:43:21');
INSERT INTO `permissoes_ver_pitch` VALUES (6,6,9,26,'1997-03-25','vencido','2024-05-06 01:23:53','2024-07-04 20:43:21');
INSERT INTO `permissoes_ver_pitch` VALUES (7,23,9,27,'1997-03-25','vencido','2024-05-06 03:20:37','2024-05-06 16:56:57');
INSERT INTO `permissoes_ver_pitch` VALUES (8,23,2,27,'1997-03-25','vencido','2024-05-06 07:13:57','2024-05-06 16:56:57');
INSERT INTO `permissoes_ver_pitch` VALUES (9,23,2,28,'1997-03-25','vencido','2024-05-06 07:51:43','2024-05-06 16:56:57');
INSERT INTO `permissoes_ver_pitch` VALUES (10,23,2,29,'1997-03-25','vencido','2024-05-06 11:20:47','2024-05-06 16:56:57');
INSERT INTO `permissoes_ver_pitch` VALUES (11,23,2,30,'1997-03-25','vencido','2024-05-06 11:48:52','2024-05-06 16:56:57');
INSERT INTO `permissoes_ver_pitch` VALUES (12,23,2,31,'1997-03-25','vencido','2024-05-06 11:56:47','2024-05-06 16:56:57');
INSERT INTO `permissoes_ver_pitch` VALUES (13,23,2,32,'1997-03-25','vencido','2024-05-06 12:41:22','2024-05-06 16:56:57');
INSERT INTO `permissoes_ver_pitch` VALUES (14,23,2,34,'1997-03-25','vencido','2024-05-06 13:54:34','2024-05-06 16:56:57');
INSERT INTO `permissoes_ver_pitch` VALUES (15,23,2,35,'1997-03-25','vencido','2024-05-06 13:59:16','2024-05-06 16:56:57');
INSERT INTO `permissoes_ver_pitch` VALUES (16,23,2,36,'1997-03-25','vencido','2024-05-06 14:04:22','2024-05-06 16:56:57');
INSERT INTO `permissoes_ver_pitch` VALUES (17,23,2,43,'1997-03-25','vencido','2024-05-06 14:16:34','2024-05-06 16:56:57');
INSERT INTO `permissoes_ver_pitch` VALUES (18,23,2,47,'1997-03-25','ativo','2024-05-06 16:58:03','2024-05-06 16:58:24');

#
# Source for table rodadas_investidores
#

DROP TABLE IF EXISTS `rodadas_investidores`;
CREATE TABLE `rodadas_investidores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_rodada` int(11) NOT NULL DEFAULT '0',
  `fk_investidor` int(11) NOT NULL DEFAULT '0',
  `valor_investido` float(12,2) NOT NULL DEFAULT '0.00',
  `acoes_adquirida` float(3,2) NOT NULL DEFAULT '0.00',
  `contrato_mutou` varchar(255) DEFAULT NULL,
  `status_contrato_investidor` smallint(6) DEFAULT '1' COMMENT '1-Assinatura pendente, 2-Contrato regeitado, 3-Contrato assinado',
  `status_contrato_startup` smallint(6) DEFAULT '1' COMMENT '1-Assinatura pendente, 2-Contrato assinado; Dado que a startup quem submete o contrato, implica que j? validou',
  `status_investimento` smallint(6) NOT NULL DEFAULT '0' COMMENT '0-Investimento captado, 1-Investimento reembolsado, 2-Investimento n?o reembolsado, 3-Investimento captado e aplicado',
  `contrato_mutou_aprovado` enum('aguarda','aprovado') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table rodadas_investidores
#

INSERT INTO `rodadas_investidores` VALUES (1,26,2,5000000,0.3,NULL,NULL,NULL,2,NULL,'2024-08-14 21:00:54','2024-08-14 21:00:54');
INSERT INTO `rodadas_investidores` VALUES (2,26,9,45000000,2.7,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:13','2024-08-11 19:05:13');
INSERT INTO `rodadas_investidores` VALUES (3,27,9,2250000,1.5,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:13','2024-08-11 19:05:13');
INSERT INTO `rodadas_investidores` VALUES (4,27,2,2250000,1.5,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:15','2024-08-11 19:05:15');
INSERT INTO `rodadas_investidores` VALUES (5,28,2,1000000,0.67,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:15','2024-08-11 19:05:15');
INSERT INTO `rodadas_investidores` VALUES (6,30,2,1000000,2,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:16','2024-08-11 19:05:16');
INSERT INTO `rodadas_investidores` VALUES (7,31,2,17000000,1.5,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:17','2024-08-11 19:05:17');
INSERT INTO `rodadas_investidores` VALUES (8,32,2,200000,1,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:17','2024-08-11 19:05:17');
INSERT INTO `rodadas_investidores` VALUES (9,33,2,500000,1.5,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:18','2024-08-11 19:05:18');
INSERT INTO `rodadas_investidores` VALUES (10,34,2,1000000,2,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:19','2024-08-11 19:05:19');
INSERT INTO `rodadas_investidores` VALUES (11,35,2,900000,1,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:19','2024-08-11 19:05:19');
INSERT INTO `rodadas_investidores` VALUES (12,36,2,950000,1,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:20','2024-08-11 19:05:20');
INSERT INTO `rodadas_investidores` VALUES (13,43,2,999999.94,1,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:20','2024-08-11 19:05:20');
INSERT INTO `rodadas_investidores` VALUES (14,60,2,11261250,9.99,'armazenamento/contratos/contract6602202408241028333333333333.pdf',1,2,0,NULL,'2024-09-16 03:53:19','2024-09-16 10:53:19');

#
# Source for table rodadas_investimento
#

DROP TABLE IF EXISTS `rodadas_investimento`;
CREATE TABLE `rodadas_investimento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_startup` bigint(11) NOT NULL DEFAULT '0',
  `valor_objetivo` float(12,2) NOT NULL DEFAULT '0.00',
  `valor_objetivo_sem_taxa` float(12,2) NOT NULL DEFAULT '0.00',
  `valor_obtido` float(12,2) NOT NULL DEFAULT '0.00',
  `oferta_acoes` float(4,2) NOT NULL DEFAULT '0.00',
  `max_investidores` int(11) NOT NULL DEFAULT '0',
  `valor_minimo_investimento` float(12,2) NOT NULL DEFAULT '0.00',
  `estado` enum('aberta','fechada','anulada','sucedida') DEFAULT 'aberta',
  `data_limite` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table rodadas_investimento
#

INSERT INTO `rodadas_investimento` VALUES (1,6,5000000,0,0,3,2,2500000,'fechada','2024-04-29','2024-04-22 13:57:21','2024-08-13 20:31:20');
INSERT INTO `rodadas_investimento` VALUES (2,6,2,0,0,2,23,0.09,'anulada','2024-04-26','2024-04-23 19:26:49','2024-04-23 19:26:55');
INSERT INTO `rodadas_investimento` VALUES (3,6,2,0,0,2,2,1,'anulada','2024-04-27','2024-04-23 19:28:33','2024-04-23 19:28:39');
INSERT INTO `rodadas_investimento` VALUES (4,6,2,0,0,2,2,1,'anulada','2024-04-27','2024-04-23 19:28:52','2024-04-23 19:28:55');
INSERT INTO `rodadas_investimento` VALUES (5,6,2,0,0,2,2,1,'anulada','2024-04-27','2024-04-23 19:29:03','2024-04-23 19:29:06');
INSERT INTO `rodadas_investimento` VALUES (6,6,2,0,0,2,2,1,'anulada','2024-04-24','2024-04-23 19:29:41','2024-04-23 19:29:42');
INSERT INTO `rodadas_investimento` VALUES (7,6,23,0,0,12,2,11.5,'anulada','2024-04-27','2024-04-23 19:30:11','2024-04-23 19:30:18');
INSERT INTO `rodadas_investimento` VALUES (8,6,23,0,0,2,2,11.5,'anulada','2024-04-27','2024-04-23 19:30:37','2024-04-23 19:31:19');
INSERT INTO `rodadas_investimento` VALUES (9,3,23456000,0,0,21,12,1.92,'anulada','2024-04-30','2024-04-23 19:31:11','2024-04-29 11:00:12');
INSERT INTO `rodadas_investimento` VALUES (10,6,23,0,0,2,2,11.5,'anulada','2024-04-27','2024-04-23 19:31:30','2024-04-23 19:31:33');
INSERT INTO `rodadas_investimento` VALUES (11,6,23,0,0,2,2,11.5,'anulada','2024-04-27','2024-04-23 19:31:52','2024-04-23 19:31:56');
INSERT INTO `rodadas_investimento` VALUES (12,6,23,0,0,2,2,11.5,'anulada','2024-04-27','2024-04-23 19:32:06','2024-04-23 19:32:08');
INSERT INTO `rodadas_investimento` VALUES (13,6,23,0,0,2,2,11.5,'anulada','2024-04-27','2024-04-23 19:32:17','2024-04-23 19:32:19');
INSERT INTO `rodadas_investimento` VALUES (14,6,5000000,0,0,0.03,4,1250000,'anulada','2024-04-26','2024-04-26 15:02:48','2024-04-28 13:08:34');
INSERT INTO `rodadas_investimento` VALUES (15,6,5000000000,0,0,2,1,5000000000,'anulada','2024-05-11','2024-04-29 12:23:21','2024-05-04 21:11:31');
INSERT INTO `rodadas_investimento` VALUES (16,6,5345536512,0,0,3.33,14,381824032,'anulada','2024-05-11','2024-04-28 14:46:36','2024-04-28 18:07:51');
INSERT INTO `rodadas_investimento` VALUES (17,6,50000000,0,0,2,3,16666667,'anulada','2024-05-11','2024-04-29 11:04:29','2024-04-29 11:32:55');
INSERT INTO `rodadas_investimento` VALUES (18,6,5000000,0,0,2,2,2500000,'anulada','2024-05-06','2024-05-05 16:25:04','2024-05-05 16:25:38');
INSERT INTO `rodadas_investimento` VALUES (19,6,500000000,0,0,2,6,83333336,'anulada','2024-05-06','2024-05-05 22:54:59','2024-05-05 22:55:04');
INSERT INTO `rodadas_investimento` VALUES (20,6,500000,0,0,0.02,6,83333.33,'anulada','2024-05-06','2024-05-05 22:56:43','2024-05-05 22:56:44');
INSERT INTO `rodadas_investimento` VALUES (21,6,43000000,0,0,3,3,14333333,'anulada','2024-06-01','2024-05-05 23:04:33','2024-05-05 23:05:04');
INSERT INTO `rodadas_investimento` VALUES (22,6,4500,0,0,0.2,1,4500,'anulada','2024-05-06','2024-05-05 23:05:47','2024-05-05 23:05:57');
INSERT INTO `rodadas_investimento` VALUES (23,6,40000,0,0,0.33,1,40000,'anulada','2024-05-06','2024-05-05 23:06:56','2024-05-05 23:13:15');
INSERT INTO `rodadas_investimento` VALUES (24,6,5000000000,0,0,5,6,833333312,'anulada','2024-05-07','2024-05-05 23:27:40','2024-05-05 23:27:41');
INSERT INTO `rodadas_investimento` VALUES (25,6,60000000,0,0,4,10,6000000,'anulada','2024-05-07','2024-05-05 23:29:44','2024-05-05 23:31:02');
INSERT INTO `rodadas_investimento` VALUES (26,6,50000000,0,50000000,3,10,5000000,'anulada','2024-06-01','2024-05-05 23:32:03','2024-06-06 20:22:54');
INSERT INTO `rodadas_investimento` VALUES (27,23,4500000,0,4500000,3,2,2250000,'anulada','2024-06-08','2024-05-06 03:17:54','2024-05-06 08:49:22');
INSERT INTO `rodadas_investimento` VALUES (28,23,3000000,0,1000000,2,3,1000000,'anulada','2024-05-29','2024-05-06 07:51:32','2024-05-06 11:17:59');
INSERT INTO `rodadas_investimento` VALUES (29,23,400000,0,0,1,2,200000,'anulada','2024-05-22','2024-05-06 11:20:35','2024-05-06 11:47:37');
INSERT INTO `rodadas_investimento` VALUES (30,23,2500000,0,1000000,5,5,500000,'anulada','2024-05-31','2024-05-06 11:48:36','2024-05-06 11:55:25');
INSERT INTO `rodadas_investimento` VALUES (31,23,34000000,0,17000000,3,2,17000000,'anulada','2024-05-31','2024-05-06 11:56:35','2024-05-06 12:11:47');
INSERT INTO `rodadas_investimento` VALUES (32,23,1000000,0,200000,5,5,200000,'anulada','2024-06-07','2024-05-06 12:41:06','2024-05-06 12:47:43');
INSERT INTO `rodadas_investimento` VALUES (33,23,1000000,0,500000,3,2,500000,'anulada','2024-06-07','2024-05-06 13:13:24','2024-05-06 13:52:46');
INSERT INTO `rodadas_investimento` VALUES (34,23,1000000,0,1000000,2,2,500000,'anulada','2024-06-05','2024-05-06 13:54:09','2024-05-06 14:58:00');
INSERT INTO `rodadas_investimento` VALUES (35,23,900000,0,900000,1,1,900000,'anulada','2024-06-06','2024-05-06 13:58:58','2024-05-06 15:03:03');
INSERT INTO `rodadas_investimento` VALUES (36,23,950000,0,950000,1,1,950000,'anulada','2024-06-07','2024-05-06 14:04:14','2024-05-06 15:13:06');
INSERT INTO `rodadas_investimento` VALUES (37,23,1000000,0,0,1,1,1000000,'anulada','2024-06-05','2024-05-06 14:14:28','2024-05-06 14:14:43');
INSERT INTO `rodadas_investimento` VALUES (38,23,1000000,0,0,1,1,1000000,'anulada','2024-06-05','2024-05-06 14:15:19','2024-05-06 14:15:23');
INSERT INTO `rodadas_investimento` VALUES (39,23,999999.94,0,0,1,1,999999.94,'anulada','2024-06-05','2024-05-06 14:15:31','2024-05-06 14:15:35');
INSERT INTO `rodadas_investimento` VALUES (40,23,999999.94,0,0,1,1,999999.94,'anulada','2024-06-05','2024-05-06 14:15:42','2024-05-06 14:15:45');
INSERT INTO `rodadas_investimento` VALUES (41,23,999999.94,0,0,1,1,999999.94,'anulada','2024-06-05','2024-05-06 14:15:57','2024-05-06 14:16:03');
INSERT INTO `rodadas_investimento` VALUES (42,23,1000000,0,0,1,1,1000000,'anulada','2024-06-05','2024-05-06 14:16:12','2024-05-06 14:16:15');
INSERT INTO `rodadas_investimento` VALUES (43,23,999999.94,0,999999.94,1,1,999999.94,'anulada','2024-06-05','2024-05-06 14:16:23','2024-05-06 16:54:04');
INSERT INTO `rodadas_investimento` VALUES (44,23,5000000,0,0,2,1,5000000,'anulada','2024-06-01','2024-05-06 16:52:50','2024-05-06 16:54:43');
INSERT INTO `rodadas_investimento` VALUES (45,23,400000,0,0,2,1,400000,'anulada','2024-05-31','2024-05-06 16:55:03','2024-05-06 16:55:46');
INSERT INTO `rodadas_investimento` VALUES (46,23,5000000,0,0,2,1,5000000,'anulada','2024-06-06','2024-05-06 16:56:06','2024-05-06 16:56:57');
INSERT INTO `rodadas_investimento` VALUES (47,23,3500000,0,3500000,2,1,3500000,'anulada','2024-05-30','2024-05-06 16:57:18','2024-08-01 12:52:12');
INSERT INTO `rodadas_investimento` VALUES (48,6,5000000,0,0,10,3,1666666.62,'anulada','2024-06-20','2024-06-18 18:12:51','2024-06-18 18:14:03');
INSERT INTO `rodadas_investimento` VALUES (49,6,500000,0,0,10,1,500000,'anulada','2024-06-20','2024-06-18 18:14:46','2024-06-18 18:14:52');
INSERT INTO `rodadas_investimento` VALUES (50,6,500000,0,0,10,1,500000,'anulada','2024-06-20','2024-06-18 18:15:00','2024-06-18 18:15:13');
INSERT INTO `rodadas_investimento` VALUES (51,6,4000000,0,0,10,1,4000000,'anulada','2024-06-21','2024-06-18 18:32:00','2024-06-18 18:32:23');
INSERT INTO `rodadas_investimento` VALUES (52,6,4000,0,0,4.44,1,4000,'anulada','2024-06-21','2024-06-18 18:33:53','2024-06-18 18:34:21');
INSERT INTO `rodadas_investimento` VALUES (53,6,6250000,5000000,0,10,1,6250000,'anulada','2024-07-05','2024-06-30 19:53:20','2024-06-30 20:07:32');
INSERT INTO `rodadas_investimento` VALUES (54,6,8750000,7000000,0,10,3,2916666.75,'anulada','2024-07-04','2024-06-30 20:08:00','2024-06-30 20:41:15');
INSERT INTO `rodadas_investimento` VALUES (55,6,5000000,4000000,0,1,1,5000000,'anulada','2024-07-04','2024-06-30 20:42:12','2024-06-30 20:50:27');
INSERT INTO `rodadas_investimento` VALUES (56,6,6250000,5000000,0,10,1,6250000,'anulada','2024-07-10','2024-07-02 18:04:38','2024-07-02 18:06:36');
INSERT INTO `rodadas_investimento` VALUES (57,6,62500,50000,0,10,1,62500,'anulada','2024-08-07','2024-07-02 18:41:57','2024-07-02 18:45:25');
INSERT INTO `rodadas_investimento` VALUES (58,6,625000,500000,0,10,1,625000,'anulada','2024-07-04','2024-07-02 20:36:57','2024-07-02 20:37:04');
INSERT INTO `rodadas_investimento` VALUES (59,6,0.09,0.07,0,0.07,1,0.09,'anulada','2024-07-10','2024-07-02 21:24:23','2024-07-02 21:27:36');
INSERT INTO `rodadas_investimento` VALUES (60,6,11261250,9009000,11261250,44.55,1,11261250,'fechada','2024-09-20 01:00:00','2024-07-04 20:39:00','2024-08-14 21:00:37');

#
# Source for table setores_economico
#

DROP TABLE IF EXISTS `setores_economico`;
CREATE TABLE `setores_economico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table setores_economico
#

INSERT INTO `setores_economico` VALUES (1,'Sa?de','2022-02-16 14:38:58','2022-02-16 14:38:58');
INSERT INTO `setores_economico` VALUES (2,'Educa??o','2022-02-16 14:39:10','2022-02-16 14:39:10');
INSERT INTO `setores_economico` VALUES (3,'Im?veis','2022-02-16 14:40:02','2022-02-16 14:40:02');
INSERT INTO `setores_economico` VALUES (4,'Mobilidade','2022-02-16 14:41:15','2022-02-16 14:41:15');
INSERT INTO `setores_economico` VALUES (5,'Log?stica','2022-04-25 20:03:04','2022-04-25 20:03:04');
INSERT INTO `setores_economico` VALUES (6,'Health','2024-04-28 12:38:27','2024-04-28 12:38:27');
INSERT INTO `setores_economico` VALUES (7,'Fintech','2024-05-06 01:40:13','2024-05-06 01:40:13');

#
# Source for table startups
#

DROP TABLE IF EXISTS `startups`;
CREATE TABLE `startups` (
  `fk_user` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `nif` varchar(255) NOT NULL DEFAULT '',
  `fk_setor_economico` int(11) unsigned NOT NULL DEFAULT '0',
  `fk_fase_desenvolvimento` int(11) NOT NULL DEFAULT '0',
  `pitch_elevator` varchar(1000) NOT NULL DEFAULT '',
  `pitch_deck` varchar(255) DEFAULT '',
  `mvp` varchar(255) NOT NULL DEFAULT '',
  `logotipo` varchar(255) NOT NULL DEFAULT '',
  `estado_busca_invest` enum('sim','nao') NOT NULL DEFAULT 'nao',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fk_user`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table startups
#

INSERT INTO `startups` VALUES (3,'Oprivado','armazenamento/startups/nif/nif0606030320242024091459.pdf',4,1,'A##Oprivado##est? construindo##software##para ajudar##influ?ncers digitais angolanos##\n        a##monetizarem com seus conte?dos##com##inclui sistemas de pagamento integrado','armazenamento/startups/pitch/pitch_3.mp4','armazenamento/startups/mvp/mvp0606030320242024091459.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-03-06 09:15:42','2024-04-29 11:00:12');
INSERT INTO `startups` VALUES (4,'kubinga','armazenamento/startups/nif/nif0606030320242024091931.pdf',2,1,'A##kubinga##est? construindo##servi?o##para ajudar##taxistas angolanos##\n        a##monetizar##com##aplicativo e comodidade','','armazenamento/startups/mvp/mvp0606030320242024091931.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-03-06 09:20:27','2024-03-06 09:20:27');
INSERT INTO `startups` VALUES (6,'startupInveste','armazenamento/startups/nif/nif0606030320242024092955.pdf',4,1,'A##startupInveste##est? construindo##software##para ajudar##startups angolanas e investidores##\n        a##acessar financiamento e oportunidade de investir##com##comodidade e risco reduzido','armazenamento/startups/pitch/pitch_6.mp4','armazenamento/startups/mvp/mvp0606030320242024092955.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-03-06 09:30:42','2024-08-13 19:12:47');
INSERT INTO `startups` VALUES (10,'Kubinga 2','armazenamento/startups/nif/nif0202040420242024120951.pdf',4,1,'A##Kubinga 2##est? construindo##servi?o de taxi##para ajudar##angolanos##\n        a##moverem-se##com##aplica??o','','armazenamento/startups/mvp/mvp0202040420242024120953.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-02 11:10:22','2024-04-02 11:10:22');
INSERT INTO `startups` VALUES (11,'kubeta','armazenamento/startups/nif/nif0808040420242024083819.pdf',2,1,'A##kubeta##est? construindo##servi?o##para ajudar##angolanos##\n        a##acessarem livros##com##? qualquer altura','','armazenamento/startups/mvp/mvp0808040420242024083820.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-08 08:38:21','2024-04-08 08:38:21');
INSERT INTO `startups` VALUES (12,'bomba','armazenamento/startups/nif/nif0808040420242024084957.pdf',4,1,'A##bomba##est? construindo##testesss##para ajudar##testeee##\n        a##testeeee##com##testeee','','armazenamento/startups/mvp/mvp0808040420242024084957.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-08 08:51:00','2024-04-08 08:51:00');
INSERT INTO `startups` VALUES (14,'crypto','armazenamento/startups/nif/nif2323040420242024073551.pdf',2,1,'A##crypto##est? construindo##uma aplica??o web##para ajudar##Pessoas##\n        a##vivenciarem a inclus?o financeira##com##rapidez e seguran?a','','armazenamento/startups/mvp/mvp2323040420242024073551.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-23 19:35:51','2024-04-23 19:35:51');
INSERT INTO `startups` VALUES (15,'edukids','armazenamento/startups/nif/nif2323040420242024073812.pdf',2,1,'A##edukids##est? construindo##Aplica??o web##para ajudar##Encarregados de educa??o##\n        a##Monitorar o desempenho escolar de seus encarregandos##com##Com rapidez','','armazenamento/startups/mvp/mvp2323040420242024073812.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-23 19:38:12','2024-04-23 19:38:12');
INSERT INTO `startups` VALUES (17,'nvidia','armazenamento/startups/nif/nif2323040420242024080326.pdf',2,1,'A##nvidia##est? construindo##software##para ajudar##utilizadores de pcs##\n        a##aumentarem capacidade de processamento de seus pcs##com##baixo custo','','armazenamento/startups/mvp/mvp2323040420242024080326.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-23 20:03:26','2024-04-23 20:03:26');
INSERT INTO `startups` VALUES (19,'lamina','armazenamento/startups/nif/nif2323040420242024080640.pdf',2,1,'A##lamina##est? construindo##software##para ajudar##pessoas##\n        a##ajustar cargar horarias##com##aplicativo','','armazenamento/startups/mvp/mvp2323040420242024080640.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-23 20:06:41','2024-04-23 20:06:41');
INSERT INTO `startups` VALUES (20,'onFly','armazenamento/startups/nif/nif2323040420242024083414.pdf',2,1,'A##onFly##est? construindo##aeronave##para ajudar##pessoas##\n        a##locomoverem-se de forma r?pida##com##baixo custo','','armazenamento/startups/mvp/mvp2323040420242024083414.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-23 20:34:14','2024-04-23 20:34:14');
INSERT INTO `startups` VALUES (21,'kikolo','armazenamento/startups/nif/nif2727040420242024044223.pdf',4,1,'A##kikolo##est? construindo##software##para ajudar##pessoas residentes em Angola##\n        a##comprar##com##aplicativo','','armazenamento/startups/mvp/mvp2727040420242024044224.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-27 16:42:24','2024-04-27 16:42:24');
INSERT INTO `startups` VALUES (22,'happysaude','armazenamento/startups/nif/nif2828040420242024123826.pdf',6,3,'A##happysaude##est? construindo##software##para ajudar##angolanos##\n        a##terem acesso a servi?os de sa?de##com##aplicativo e rapidez','','armazenamento/startups/mvp/mvp2828040420242024123826.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-28 12:38:27','2024-04-28 12:38:27');
INSERT INTO `startups` VALUES (23,'teste','armazenamento/startups/nif/nif0606050520242024014013.pdf',7,1,'A##teste##est? construindo##teste##para ajudar##teste##\n        a##teste##com##teste','armazenamento/startups/pitch/pitch_23.mp4','armazenamento/startups/mvp/mvp0606050520242024014013.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-05-06 01:40:13','2024-08-01 12:52:12');

#
# Source for table transactions
#

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item_price` float(10,2) DEFAULT NULL,
  `order_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fk_payer` bigint(11) NOT NULL DEFAULT '0',
  `payment_source` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_source_card_last_digits` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_source_card_expiry` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_source_card_brand` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_status` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Dumping data for table transactions
#

INSERT INTO `transactions` VALUES (1,'startupinveste03202406095403','startupInveste',5000000,'4SL66149UG8943948',2,'card','0004','2025-12','VISA','created','2024-05-06 01:14:11','2024-05-06 01:14:17');
INSERT INTO `transactions` VALUES (2,'startupinveste03202406095403','startupInveste',45000000,'76H51544CD701702N',9,NULL,NULL,NULL,NULL,'created','2024-05-06 01:25:36','2024-05-06 01:25:36');
INSERT INTO `transactions` VALUES (3,'startupinveste03202406095403','startupInveste',45000000,'14F61089H7184523A',9,NULL,NULL,NULL,NULL,'created','2024-05-06 01:25:48','2024-05-06 01:25:48');
INSERT INTO `transactions` VALUES (4,'startupinveste03202406095403','startupInveste',45000000,'9VM28362XV623730F',9,NULL,NULL,NULL,NULL,'created','2024-05-06 01:25:56','2024-05-06 01:25:56');
INSERT INTO `transactions` VALUES (5,'startupinveste03202406095403','startupInveste',45000000,'6NK54056UH758214H',9,NULL,NULL,NULL,NULL,'created','2024-05-06 01:26:08','2024-05-06 01:26:08');
INSERT INTO `transactions` VALUES (6,'startupinveste03202406095403','startupInveste',45000000,'1MY59494XT6982740',9,'card','0004','2026-12','VISA','created','2024-05-06 01:26:52','2024-05-06 01:26:58');
INSERT INTO `transactions` VALUES (7,'teste05202406011205','teste',2250000,'73X10988T1417954U',9,'card','0004','2025-12','VISA','created','2024-05-06 03:26:00','2024-05-06 03:26:05');
INSERT INTO `transactions` VALUES (8,'teste05202406011205','teste',2250000,'5E832999C54218253',2,'card','0004','2025-12','VISA','created','2024-05-06 07:15:32','2024-05-06 07:15:38');
INSERT INTO `transactions` VALUES (9,'teste05202406011205','teste',1000000,'6C247285GF7117338',2,'card','0004','2025-12','VISA','created','2024-05-06 07:58:56','2024-05-06 07:59:02');
INSERT INTO `transactions` VALUES (10,'teste05202406011205','teste',200000,'9CS13098D9590680U',2,NULL,NULL,NULL,NULL,'created','2024-05-06 11:22:07','2024-05-06 11:22:07');
INSERT INTO `transactions` VALUES (11,'teste05202406011205','teste',1000000,'0YL15319VB7063454',2,'card','0004','2025-12','VISA','created','2024-05-06 11:50:24','2024-05-06 11:50:29');
INSERT INTO `transactions` VALUES (12,'teste05202406011205','teste',17000000,'6U718275MG3593108',2,NULL,NULL,NULL,NULL,'created','2024-05-06 12:02:59','2024-05-06 12:02:59');
INSERT INTO `transactions` VALUES (13,'teste05202406011205','teste',17000000,'1XX21376Y52367418',2,'card','0004','2024-11','VISA','created','2024-05-06 12:04:55','2024-05-06 12:05:00');
INSERT INTO `transactions` VALUES (14,'teste05202406011205','teste',200000,'2RY16516WG2703748',2,'card','0004','2024-12','VISA','created','2024-05-06 12:42:06','2024-05-06 12:42:11');
INSERT INTO `transactions` VALUES (15,'teste05202406011205','teste',500000,'6H660930N24081454',2,'card','0004','2026-12','VISA','created','2024-05-06 13:14:36','2024-05-06 13:14:42');
INSERT INTO `transactions` VALUES (16,'teste05202406011205','teste',1000000,'3A3158988W549392P',2,'card','0004','2024-12','VISA','created','2024-05-06 13:55:21','2024-05-06 13:55:26');
INSERT INTO `transactions` VALUES (17,'teste05202406011205','teste',900000,'4VT77288LR2119455',2,'card','0004','2028-03','VISA','created','2024-05-06 14:00:43','2024-05-06 14:00:49');
INSERT INTO `transactions` VALUES (18,'teste05202406011205','teste',950000,'3BN01094FG558624E',2,'card','0004','2026-12','VISA','created','2024-05-06 14:09:45','2024-05-06 14:09:51');
INSERT INTO `transactions` VALUES (19,'teste05202406011205','teste',999999.94,'8YW767446A659274L',2,'card','0004','2027-12','VISA','created','2024-05-06 14:17:24','2024-05-06 14:17:31');
INSERT INTO `transactions` VALUES (20,'teste05202406011205','teste',3500000,'6C621692GA917135E',2,'card','0004','2024-12','VISA','created','2024-05-06 17:11:13','2024-05-06 17:11:18');

#
# Source for table users
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `estado` enum('espera','regeitado','aceite') NOT NULL DEFAULT 'espera',
  `tipo` enum('startup','investidor','admin') NOT NULL DEFAULT 'startup',
  `code_user` varchar(1000) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

#
# Dumping data for table users
#

INSERT INTO `users` VALUES (1,'guiframart1@hotmail.com','$2y$10$CS.Jp7TK2f5H/8Dqjl3cze7DpX6kbMHO/ZhCfrIHfuSlDTU7m0t1G','aceite','admin','admin2024','2024-03-05 15:49:23','2024-03-06 10:22:17');
INSERT INTO `users` VALUES (2,'joel@hotmail.com','$2y$10$CS.Jp7TK2f5H/8Dqjl3cze7DpX6kbMHO/ZhCfrIHfuSlDTU7m0t1G','aceite','investidor','joel0606030320242024090521','2024-03-06 09:05:22','2024-03-06 11:04:13');
INSERT INTO `users` VALUES (3,'privado@hotmail.com','$2y$10$CS.Jp7TK2f5H/8Dqjl3cze7DpX6kbMHO/ZhCfrIHfuSlDTU7m0t1G','aceite','startup','oprivado03202406095803','2024-03-06 09:14:58','2024-03-06 11:04:14');
INSERT INTO `users` VALUES (4,'guitocode@hotmail.com','$2y$10$CS.Jp7TK2f5H/8Dqjl3cze7DpX6kbMHO/ZhCfrIHfuSlDTU7m0t1G','aceite','startup','kubinga03202406093003','2024-03-06 09:19:30','2024-03-06 11:04:15');
INSERT INTO `users` VALUES (5,'guiframart3@hotmail.com','$2y$10$4fiqDVj6G9run1h1ydX42.PELBC7DIGt9k.8/wuznuISfLqtkaRf2','aceite','investidor','guilherme0606030320242024092351','2024-03-06 09:23:51','2024-05-06 02:38:16');
INSERT INTO `users` VALUES (6,'startupinveste@hotmail.com','$2y$10$CS.Jp7TK2f5H/8Dqjl3cze7DpX6kbMHO/ZhCfrIHfuSlDTU7m0t1G','aceite','startup','startupinveste03202406095403','2024-03-06 09:29:54','2024-03-06 11:04:18');
INSERT INTO `users` VALUES (7,'outro@hotmail.com','$2y$10$W78EoocxvhPJzfyVDF1ac.ZsU8FGBtkdZAQv6yOG0d0XfHP9MzFGe','espera','investidor','outro0909030320242024094311','2024-03-09 21:43:11','2024-03-09 21:43:11');
INSERT INTO `users` VALUES (9,'adao@hotmail.com','$2y$10$CS.Jp7TK2f5H/8Dqjl3cze7DpX6kbMHO/ZhCfrIHfuSlDTU7m0t1G','aceite','investidor','ad?o de alm?ida jos?2424030320242024042838','2024-03-24 16:28:38','2024-03-24 17:32:01');
INSERT INTO `users` VALUES (10,'kubinga@hotmail.com','$2y$10$CJ8qc1vq9yKRLTSivqk0K.go0ZeiuIegXYVBuRCLdo32kmieTpNx2','espera','startup','kubinga 204202402125004','2024-04-02 11:09:51','2024-04-02 11:09:51');
INSERT INTO `users` VALUES (11,'kubeta@hotmail.com','$2y$10$DL0omAb8STLah4qBVeaCQ.543HXxoQnMjWEZX1RqEWmxhM6WUqqz6','espera','startup','kubeta04202408081604','2024-04-08 08:38:18','2024-04-08 08:38:18');
INSERT INTO `users` VALUES (12,'bomba@hotmail.com','$2y$10$i5U14XJoPnLWT.0a8qGHfeM1SHk1Kxa/ySHJ6PvuQGFhhWiduELgy','espera','startup','bomba04202408085604','2024-04-08 08:49:57','2024-04-08 08:49:57');
INSERT INTO `users` VALUES (13,'devolve@hotmail.com','$2y$10$adKAwP04xNmzS3kMhqoQmOwvwbTFFU4IRWbIVB4QXTccTeIgIUoaK','espera','investidor','devolve0808040420242024112927','2024-04-08 11:29:29','2024-04-08 11:29:29');
INSERT INTO `users` VALUES (14,'crypto','$2y$10$lte9olV24EXbek0vvb8qa..4B099Z6pfxLm/8fjnJD0iG/a96cwoK','espera','startup','crypto04202423075104','2024-04-23 19:35:51','2024-04-23 19:35:51');
INSERT INTO `users` VALUES (15,'edukids','$2y$10$SP5C3xH2QSjKTIHmoqyK1ekmzrQqHE5H0t/V25qtyMAeqTYzwBiKq','espera','startup','edukids04202423071204','2024-04-23 19:38:12','2024-04-23 19:38:12');
INSERT INTO `users` VALUES (16,'modric@hotmail.com','$2y$10$EIfRNRu92ibsUP8jmYtGZuRKM.weUe6NtMokEz6/UJ.VxRV9iAN1G','espera','investidor','lucas modric2323040420242024074047','2024-04-23 19:40:47','2024-04-23 19:40:47');
INSERT INTO `users` VALUES (17,'nvidia@hotmail.com','$2y$10$4FEoUFE.iZln9KgQb5.c8ukn24ROiuEm8NQsZGmBjLewHs7MmZL4O','espera','startup','nvidia04202423082604','2024-04-23 20:03:26','2024-04-23 20:03:26');
INSERT INTO `users` VALUES (18,'fragoso@hotmail.com','$2y$10$eNVXTtKKgtDblfWkBj0K2..WLzwMPVG5IggA9DVzU5VOMuiHUwzVG','espera','investidor','fragoso martins2323040420242024080448','2024-04-23 20:04:48','2024-04-23 20:04:48');
INSERT INTO `users` VALUES (19,'lamina@hotmail.com','$2y$10$eUU9oeUhB/6iIg44YLw64.Sckar85HjDOxzinF8Azz7mrrCdzsTiy','espera','startup','lamina04202423084004','2024-04-23 20:06:40','2024-04-23 20:06:40');
INSERT INTO `users` VALUES (20,'onfly@hotmail.com','$2y$10$NFpV1nm8nPEQLG2.Sf9nluDejDjE0kvEYy19oZS2qdTFc3ebL5t1i','espera','startup','onfly04202423081404','2024-04-23 20:34:14','2024-04-23 20:34:14');
INSERT INTO `users` VALUES (21,'kikolo@hotmail.com','$2y$10$.a/NB7ZUGuSLv5HTFXt5BeiyrlM7eQDeAmvm0K5F0sdt6F3GGCXla','espera','startup','kikolo04202427042204','2024-04-27 16:42:22','2024-04-27 16:42:22');
INSERT INTO `users` VALUES (22,'happysaude@hotmail.com','$2y$10$7W5XqP3JKeyM/5.5gjDcCumPyaR928O66OHZICxUcskcY/cygeqoq','espera','startup','happysaude04202428122504','2024-04-28 12:38:26','2024-04-28 12:38:26');
INSERT INTO `users` VALUES (23,'guiframart@hotmail.com','$2y$10$CS.Jp7TK2f5H/8Dqjl3cze7DpX6kbMHO/ZhCfrIHfuSlDTU7m0t1G','aceite','startup','teste05202406011205','2024-05-06 01:40:12','2024-05-06 04:12:30');

#
# Source for table websockets_statistics_entries
#

DROP TABLE IF EXISTS `websockets_statistics_entries`;
CREATE TABLE `websockets_statistics_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peak_connection_count` int(11) NOT NULL,
  `websocket_message_count` int(11) NOT NULL,
  `api_message_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Dumping data for table websockets_statistics_entries
#


/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
