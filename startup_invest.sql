# Host: localhost  (Version 5.5.5-10.3.16-MariaDB)
# Date: 2024-09-12 13:37:18
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "areas_formacao"
#

DROP TABLE IF EXISTS `areas_formacao`;
CREATE TABLE `areas_formacao` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

#
# Data for table "areas_formacao"
#

INSERT INTO `areas_formacao` VALUES (1,'Administração','2022-03-28 10:38:12','2022-03-28 10:38:12'),(2,'Finanças','2022-03-28 10:38:34','2022-03-28 10:38:34'),(3,'Economia','2022-03-28 10:41:33','2022-03-28 10:41:33');

#
# Structure for table "cargos_executivo"
#

DROP TABLE IF EXISTS `cargos_executivo`;
CREATE TABLE `cargos_executivo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sigla` varchar(255) NOT NULL DEFAULT '',
  `descricao` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

#
# Data for table "cargos_executivo"
#

INSERT INTO `cargos_executivo` VALUES (1,'CEO','Director Geral','2022-03-26 15:21:15','2022-03-26 15:21:15'),(2,'CTO','Diretor De Tecnologia','2022-03-26 15:21:49','2022-03-26 15:24:36'),(3,'CFO','Director Financeiro','2022-03-26 15:24:01','2022-03-26 15:24:01');

#
# Structure for table "certificados_formacao"
#

DROP TABLE IF EXISTS `certificados_formacao`;
CREATE TABLE `certificados_formacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='Para qualquer formação existe um certificado(licenciatura,doutoramento,fluencia em ingles)';

#
# Data for table "certificados_formacao"
#

INSERT INTO `certificados_formacao` VALUES (1,'Licenciatura','2022-03-28 10:33:37','2022-03-28 10:33:37'),(2,'Doutoramento','2022-03-28 10:33:54','2022-03-28 10:33:54'),(3,'Técnico','2022-03-28 10:34:55','2022-03-28 10:34:55'),(4,'lina','2022-03-30 14:50:52','2022-03-30 14:50:52'),(5,'lita','2022-03-30 14:50:59','2022-03-30 14:50:59');

#
# Structure for table "experiencia_membro_equipa"
#

DROP TABLE IF EXISTS `experiencia_membro_equipa`;
CREATE TABLE `experiencia_membro_equipa` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fk_membro_equipa` bigint(20) NOT NULL DEFAULT 0,
  `fk_funcao` bigint(20) NOT NULL DEFAULT 0,
  `fk_instituicao` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

#
# Data for table "experiencia_membro_equipa"
#

INSERT INTO `experiencia_membro_equipa` VALUES (1,5,1,1,'2024-03-06 16:26:28','2024-03-06 16:26:28'),(2,9,2,2,'2024-03-07 11:00:56','2024-03-07 11:00:56'),(3,10,3,3,'2024-03-07 11:09:21','2024-03-07 11:09:21'),(4,10,4,4,'2024-03-07 11:09:21','2024-03-07 11:09:21'),(5,16,5,5,'2024-03-07 19:03:35','2024-03-07 19:03:35'),(6,16,6,6,'2024-03-07 19:03:35','2024-03-07 19:03:35');

#
# Structure for table "fases_desenvolvimento"
#

DROP TABLE IF EXISTS `fases_desenvolvimento`;
CREATE TABLE `fases_desenvolvimento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

#
# Data for table "fases_desenvolvimento"
#

INSERT INTO `fases_desenvolvimento` VALUES (1,'Projecto-Operação','2022-02-16 14:29:12','2022-02-16 14:29:12'),(2,'Operação','2022-02-16 14:29:32','2022-02-16 14:29:32'),(3,'Tração','2022-02-16 14:29:55','2022-02-16 14:29:55');

#
# Structure for table "finalidades_investimento"
#

DROP TABLE IF EXISTS `finalidades_investimento`;
CREATE TABLE `finalidades_investimento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_rodada` int(11) NOT NULL DEFAULT 0,
  `item` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_att` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# Data for table "finalidades_investimento"
#


#
# Structure for table "formacao_membro_equipa"
#

DROP TABLE IF EXISTS `formacao_membro_equipa`;
CREATE TABLE `formacao_membro_equipa` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fk_membro_equipa` int(11) NOT NULL DEFAULT 0,
  `fk_area_formacao` bigint(20) NOT NULL DEFAULT 0,
  `fk_certificado_formacao` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

#
# Data for table "formacao_membro_equipa"
#

INSERT INTO `formacao_membro_equipa` VALUES (1,5,2,1,'2024-03-06 16:26:27','2024-03-06 16:26:27'),(2,6,2,1,'2024-03-07 06:04:14','2024-03-07 06:04:14'),(3,9,2,1,'2024-03-07 11:00:56','2024-03-07 11:00:56'),(4,9,3,2,'2024-03-07 11:00:56','2024-03-07 11:00:56'),(5,10,1,1,'2024-03-07 11:09:21','2024-03-07 11:09:21'),(6,10,3,2,'2024-03-07 11:09:21','2024-03-07 11:09:21'),(7,16,2,1,'2024-03-07 19:03:35','2024-03-07 19:03:35'),(8,16,3,2,'2024-03-07 19:03:35','2024-03-07 19:03:35');

#
# Structure for table "funcoes_experiencia"
#

DROP TABLE IF EXISTS `funcoes_experiencia`;
CREATE TABLE `funcoes_experiencia` (
  `id` bigint(1) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `outro` enum('yes','no') NOT NULL DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

#
# Data for table "funcoes_experiencia"
#

INSERT INTO `funcoes_experiencia` VALUES (1,'Gestor','yes','2024-03-06 16:26:28','2024-03-06 16:26:28'),(2,'Gestor','yes','2024-03-07 11:00:56','2024-03-07 11:00:56'),(3,'Gestor','yes','2024-03-07 11:09:21','2024-03-07 11:09:21'),(4,'Administrador','yes','2024-03-07 11:09:21','2024-03-07 11:09:21'),(5,'Gestor','yes','2024-03-07 19:03:35','2024-03-07 19:03:35'),(6,'Administrador','yes','2024-03-07 19:03:35','2024-03-07 19:03:35');

#
# Structure for table "instituicoes_experincia"
#

DROP TABLE IF EXISTS `instituicoes_experincia`;
CREATE TABLE `instituicoes_experincia` (
  `id` bigint(1) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `outro` enum('yes','no') NOT NULL DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

#
# Data for table "instituicoes_experincia"
#

INSERT INTO `instituicoes_experincia` VALUES (1,'BAI','no','2022-06-14 18:25:20','2022-07-05 09:48:27'),(2,'0','yes','2022-07-05 11:42:54','2022-07-05 11:42:54'),(3,'DIGITAL FACTORY','yes','2022-07-05 11:45:21','2022-07-05 11:45:21'),(4,'cc','yes','2022-07-05 12:04:15','2022-07-05 12:04:15'),(5,'BAI','yes','2022-08-01 15:54:17','2022-08-01 15:54:17'),(6,'AGT','yes','2022-08-01 15:55:27','2022-08-01 15:55:27'),(7,'BAI','yes','2022-08-01 15:55:27','2022-08-01 15:55:27');

#
# Structure for table "investidores"
#

DROP TABLE IF EXISTS `investidores`;
CREATE TABLE `investidores` (
  `fk_user` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome_completo` varchar(255) NOT NULL DEFAULT '',
  `bilhete_identidade` varchar(255) NOT NULL DEFAULT '',
  `foto` varchar(255) NOT NULL DEFAULT '',
  `video_investidor` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`fk_user`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COMMENT='Esta tabela consta os potenciais investidores/investidores na plataforma. Já a tabela investidores da startup, armazena pessoas que nvestiram de facto na startup';

#
# Data for table "investidores"
#

INSERT INTO `investidores` VALUES (2,'Joel Agostinho Martins','armazenamento/investidor/bilhete_identidade/bi_investidor0606030320242024090520.pdf','armazenamento/investidor/img/img_standard_investidor.png','armazenamento/investidor/videos/video_investidor0606030320242024090520.mp4','2024-03-06 09:05:22','2024-03-16 21:38:45'),(5,'Guilherme Miranda Martins Dos Santos','armazenamento/investidor/bilhete_identidade/bi_investidor0606030320242024092256.pdf','armazenamento/investidor/img/img_standard_investidor.png','armazenamento/investidor/videos/video_investidor0606030320242024092256.mp4','2024-03-06 09:23:51','2024-03-16 21:39:12'),(7,'outro','armazenamento/investidor/bilhete_identidade/bi_investidor0909030320242024094311.pdf','armazenamento/investidor/img/img_standard_investidor.png','armazenamento/investidor/videos/video_investidor0909030320242024094311.mp4','2024-03-09 21:43:12','2024-03-09 21:43:12'),(9,'ADÃO DE ALMÉIDA JOSÉ','armazenamento/investidor/bilhete_identidade/bi_investidor2424030320242024042818.pdf','armazenamento/investidor/img/img_standard_investidor.png','armazenamento/investidor/videos/video_investidor2424030320242024042818.mp4','2024-03-24 16:28:38','2024-03-24 16:28:38'),(13,'devolve','armazenamento/investidor/bilhete_identidade/bi_investidor0808040420242024112918.pdf','armazenamento/investidor/img/img_standard_investidor.png','armazenamento/investidor/videos/video_investidor0808040420242024112918.mp4','2024-04-08 11:29:29','2024-04-08 11:29:29'),(16,'Lucas Modric','armazenamento/investidor/bilhete_identidade/bi_investidor2323040420242024074047.pdf','armazenamento/investidor/img/img_standard_investidor.png','armazenamento/investidor/videos/video_investidor2323040420242024074047.mp4','2024-04-23 19:40:47','2024-04-23 19:40:47'),(18,'Fragoso Martins','armazenamento/investidor/bilhete_identidade/bi_investidor2323040420242024080447.pdf','armazenamento/investidor/img/img_standard_investidor.png','armazenamento/investidor/videos/video_investidor2323040420242024080447.mp4','2024-04-23 20:04:48','2024-04-23 20:04:48');

#
# Structure for table "investidores_da_startup"
#

DROP TABLE IF EXISTS `investidores_da_startup`;
CREATE TABLE `investidores_da_startup` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '',
  `nome` varchar(255) NOT NULL DEFAULT '',
  `sobrenome` varchar(255) DEFAULT NULL,
  `fk_startup` bigint(20) NOT NULL DEFAULT 0,
  `porcentagem_na_startup` int(11) NOT NULL DEFAULT 0,
  `tipo_entidade` enum('Física','Jurídica') NOT NULL DEFAULT 'Física',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COMMENT='Esta tabela consta os potenciais investidores/investidores na plataforma. Já a tabela investidores da startup, armazena pessoas que nvestiram de facto na startup';

#
# Data for table "investidores_da_startup"
#

INSERT INTO `investidores_da_startup` VALUES (18,'emis@hotmail.com','EMIS S.A',NULL,6,2,'Física','2024-03-20 12:55:36','2024-04-18 22:41:43'),(19,'bai@hotmail.com','BAI S.A',NULL,6,2,'Física','2024-03-20 12:55:36','2024-04-18 22:42:30'),(20,'sonangol@hotmail.com','SONANGOL',NULL,6,2,'Física','2024-03-20 12:55:36','2024-04-18 22:42:39'),(21,'emirates@hotmail.com','EMIRATES','',6,2,'Física','2024-03-20 12:55:36','2024-04-18 22:42:48'),(22,'unitel@hotmail.com','UNITEL S.A',NULL,6,2,'Física','2024-03-20 12:55:36','2024-04-18 22:42:56');

#
# Structure for table "membros_equipa_startup"
#

DROP TABLE IF EXISTS `membros_equipa_startup`;
CREATE TABLE `membros_equipa_startup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `sobrenome` varchar(255) NOT NULL DEFAULT '',
  `fk_startup` bigint(20) NOT NULL DEFAULT 0,
  `img` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

#
# Data for table "membros_equipa_startup"
#

INSERT INTO `membros_equipa_startup` VALUES (12,'Lucas','Modric',6,'armazenamento/startups/img/membros/img_standard_membro_equipa.png','2024-03-07 11:44:08','2024-03-07 11:44:08'),(16,'Guilherme','Dos Santos',6,'armazenamento/startups/img/membros/img_standard_membro_equipa.png','2024-03-07 19:03:35','2024-03-07 19:03:35');

#
# Structure for table "membrosequipa_cargosexecutivo_m_m"
#

DROP TABLE IF EXISTS `membrosequipa_cargosexecutivo_m_m`;
CREATE TABLE `membrosequipa_cargosexecutivo_m_m` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_cargo_executivo` int(11) NOT NULL DEFAULT 0,
  `fk_membro_equipa` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

#
# Data for table "membrosequipa_cargosexecutivo_m_m"
#

INSERT INTO `membrosequipa_cargosexecutivo_m_m` VALUES (10,1,12,'2024-03-07 11:44:08','2024-03-07 11:44:08'),(14,3,16,'2024-03-07 19:03:35','2024-03-07 19:03:35');

#
# Structure for table "mensagens"
#

DROP TABLE IF EXISTS `mensagens`;
CREATE TABLE `mensagens` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fk_remetente` bigint(20) NOT NULL DEFAULT 0,
  `fk_destinatario` bigint(20) NOT NULL DEFAULT 0,
  `conteudo` varchar(10000) NOT NULL DEFAULT '',
  `vista` enum('sim','nao') NOT NULL DEFAULT 'nao',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

#
# Data for table "mensagens"
#

INSERT INTO `mensagens` VALUES (1,2,6,'Boa tarde emp','sim','2024-04-23 17:36:43','2024-08-28 08:03:36'),(2,6,2,'tudo numa','sim','2024-04-23 17:36:59','2024-06-06 20:28:24');

#
# Structure for table "migrations"
#

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "migrations"
#


#
# Structure for table "notifications"
#

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `message` varchar(255) NOT NULL DEFAULT '',
  `fk_user_distination` bigint(20) NOT NULL DEFAULT 0,
  `fk_user_origin` bigint(20) NOT NULL DEFAULT 0,
  `tipo` enum('ver_pitch','foi_investido','talk_apos_pitch') NOT NULL DEFAULT 'ver_pitch',
  `status` enum('nao_visto','visto','clicado') NOT NULL DEFAULT 'nao_visto',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4;

#
# Data for table "notifications"
#

INSERT INTO `notifications` VALUES (1,'Investidor  deseja assistir vosso pitch!',6,2,'ver_pitch','clicado','2024-04-22 13:57:52','2024-04-22 13:58:09'),(2,'A startup startupInveste aceitou sua solicitação para ver o pitch.',2,6,'ver_pitch','clicado','2024-04-22 13:58:14','2024-04-22 14:10:25'),(3,'Investidor  deseja assistir vosso pitch!',6,2,'ver_pitch','clicado','2024-04-23 17:34:03','2024-04-23 17:34:16'),(4,'A startup startupInveste aceitou sua solicitação para ver o pitch.',2,6,'ver_pitch','clicado','2024-04-23 17:34:37','2024-04-23 17:36:16'),(5,'Investidor  deseja assistir vosso pitch!',6,2,'ver_pitch','clicado','2024-04-28 16:58:59','2024-04-28 17:01:10'),(6,'A startup startupInveste aceitou sua solicitação para ver o pitch.',2,6,'ver_pitch','visto','2024-04-28 17:01:13','2024-04-28 18:07:16'),(7,'Investidor  deseja assistir vosso pitch!',6,2,'ver_pitch','clicado','2024-04-29 11:05:15','2024-04-29 11:08:54'),(8,'A startup startupInveste aceitou sua solicitação para ver o pitch.',2,6,'ver_pitch','clicado','2024-04-29 11:08:58','2024-04-29 12:55:43'),(9,'Investidor  deseja assistir vosso pitch!',6,2,'ver_pitch','visto','2024-04-29 12:57:10','2024-05-04 21:28:24'),(10,'Investidor  deseja assistir vosso pitch!',6,2,'ver_pitch','clicado','2024-05-05 23:32:21','2024-05-05 23:32:30'),(11,'A startup startupInveste aceitou sua solicitação para ver o pitch.',2,6,'ver_pitch','visto','2024-05-05 23:32:34','2024-05-06 10:17:52'),(12,'Investidor  deseja assistir vosso pitch!',6,9,'ver_pitch','clicado','2024-05-06 01:23:53','2024-05-06 01:24:03'),(13,'A startup startupInveste aceitou sua solicitação para ver o pitch.',9,6,'ver_pitch','visto','2024-05-06 01:24:06','2024-05-06 01:30:49'),(14,'Investidor  deseja assistir vosso pitch!',23,9,'ver_pitch','clicado','2024-05-06 03:20:37','2024-05-06 03:20:46'),(15,'A startup teste aceitou sua solicitação para ver o pitch.',9,23,'ver_pitch','visto','2024-05-06 03:20:50','2024-05-06 03:27:40'),(16,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 07:13:57','2024-05-06 07:14:43'),(17,'A startup teste aceitou sua solicitação para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 07:14:46','2024-05-06 10:17:52'),(18,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 07:51:42','2024-05-06 07:51:52'),(19,'A startup teste aceitou sua solicitação para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 07:58:16','2024-05-06 10:17:52'),(20,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 11:20:47','2024-05-06 11:20:55'),(21,'A startup teste aceitou sua solicitação para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 11:21:00','2024-06-06 20:26:55'),(22,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 11:48:52','2024-05-06 11:49:01'),(23,'A startup teste aceitou sua solicitação para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 11:49:06','2024-06-06 20:26:55'),(24,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 11:56:47','2024-05-06 11:56:58'),(25,'A startup teste aceitou sua solicitação para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 11:57:01','2024-06-06 20:26:55'),(26,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 12:41:22','2024-05-06 12:41:34'),(27,'A startup teste aceitou sua solicitação para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 12:41:38','2024-06-06 20:26:55'),(28,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 13:54:33','2024-05-06 13:54:41'),(29,'A startup teste aceitou sua solicitação para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 13:54:46','2024-06-06 20:26:55'),(30,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 13:59:16','2024-05-06 13:59:25'),(31,'A startup teste aceitou sua solicitação para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 13:59:29','2024-06-06 20:26:55'),(32,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 14:04:22','2024-05-06 14:09:10'),(33,'A startup teste aceitou sua solicitação para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 14:09:14','2024-06-06 20:26:55'),(34,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 14:16:34','2024-05-06 14:16:46'),(35,'A startup teste aceitou sua solicitação para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 14:16:51','2024-06-06 20:26:55'),(36,'Investidor  deseja assistir vosso pitch!',23,2,'ver_pitch','clicado','2024-05-06 16:58:03','2024-05-06 16:58:20'),(37,'A startup teste aceitou sua solicitação para ver o pitch.',2,23,'ver_pitch','visto','2024-05-06 16:58:24','2024-06-06 20:26:55');

#
# Structure for table "permissoes_ver_pitch"
#

DROP TABLE IF EXISTS `permissoes_ver_pitch`;
CREATE TABLE `permissoes_ver_pitch` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fk_startup` bigint(20) NOT NULL DEFAULT 0,
  `fk_investidor` bigint(20) NOT NULL DEFAULT 0,
  `fk_rodada` bigint(11) NOT NULL DEFAULT 0,
  `data_permissao` datetime NOT NULL DEFAULT '1997-03-25 00:00:00',
  `estado` enum('espera','ignorado','ativo','vencido') NOT NULL DEFAULT 'espera' COMMENT 'pedido de permissão que fiquem em espera por 48h(com base a data de criação) será dado como ignorado. Para quem tiver permissão(ativo) tem 24h e depois estará vencido',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

#
# Data for table "permissoes_ver_pitch"
#

INSERT INTO `permissoes_ver_pitch` VALUES (1,6,2,1,'1997-03-25 00:00:00','vencido','2024-04-23 17:34:03','2024-07-04 20:43:21'),(2,6,2,16,'1997-03-25 00:00:00','vencido','2024-04-28 16:58:59','2024-07-04 20:43:21'),(3,6,2,17,'1997-03-25 00:00:00','vencido','2024-04-29 11:05:15','2024-07-04 20:43:21'),(4,6,2,15,'1997-03-25 00:00:00','vencido','2024-04-29 12:57:10','2024-07-04 20:43:21'),(5,6,2,26,'1997-03-25 00:00:00','vencido','2024-05-05 23:32:22','2024-07-04 20:43:21'),(6,6,9,26,'1997-03-25 00:00:00','vencido','2024-05-06 01:23:53','2024-07-04 20:43:21'),(7,23,9,27,'1997-03-25 00:00:00','vencido','2024-05-06 03:20:37','2024-05-06 16:56:57'),(8,23,2,27,'1997-03-25 00:00:00','vencido','2024-05-06 07:13:57','2024-05-06 16:56:57'),(9,23,2,28,'1997-03-25 00:00:00','vencido','2024-05-06 07:51:43','2024-05-06 16:56:57'),(10,23,2,29,'1997-03-25 00:00:00','vencido','2024-05-06 11:20:47','2024-05-06 16:56:57'),(11,23,2,30,'1997-03-25 00:00:00','vencido','2024-05-06 11:48:52','2024-05-06 16:56:57'),(12,23,2,31,'1997-03-25 00:00:00','vencido','2024-05-06 11:56:47','2024-05-06 16:56:57'),(13,23,2,32,'1997-03-25 00:00:00','vencido','2024-05-06 12:41:22','2024-05-06 16:56:57'),(14,23,2,34,'1997-03-25 00:00:00','vencido','2024-05-06 13:54:34','2024-05-06 16:56:57'),(15,23,2,35,'1997-03-25 00:00:00','vencido','2024-05-06 13:59:16','2024-05-06 16:56:57'),(16,23,2,36,'1997-03-25 00:00:00','vencido','2024-05-06 14:04:22','2024-05-06 16:56:57'),(17,23,2,43,'1997-03-25 00:00:00','vencido','2024-05-06 14:16:34','2024-05-06 16:56:57'),(18,23,2,47,'1997-03-25 00:00:00','ativo','2024-05-06 16:58:03','2024-05-06 16:58:24');

#
# Structure for table "rodadas_investidores"
#

DROP TABLE IF EXISTS `rodadas_investidores`;
CREATE TABLE `rodadas_investidores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_rodada` int(11) NOT NULL DEFAULT 0,
  `fk_investidor` int(11) NOT NULL DEFAULT 0,
  `valor_investido` float(12,2) NOT NULL DEFAULT 0.00,
  `acoes_adquirida` float(3,2) NOT NULL DEFAULT 0.00,
  `contrato_mutou` varchar(255) DEFAULT NULL,
  `status_contrato_investidor` smallint(6) DEFAULT NULL COMMENT '0-Validação pendente, 1-Assinatura pendente, 2- Contrato validado, 3-Contrato regeitado, 4-Contrato assinado',
  `status_contrato_startup` smallint(6) DEFAULT NULL COMMENT '1-Assinatura pendente, 4-Contrato assinado; Dado que é a startup quem submete o contrato, implica que já validou',
  `status_investimento` smallint(6) NOT NULL DEFAULT 0 COMMENT '0-Investimento captado, 1-Investimento reembolsado, 2-Investimento não reembolsado, 3-Investimento captado e aplicado',
  `contrato_mutou_aprovado` enum('aguarda','aprovado') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

#
# Data for table "rodadas_investidores"
#

INSERT INTO `rodadas_investidores` VALUES (1,26,2,5000000.00,0.30,NULL,NULL,NULL,2,NULL,'2024-08-14 21:00:54','2024-08-14 21:00:54'),(2,26,9,45000000.00,2.70,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:13','2024-08-11 19:05:13'),(3,27,9,2250000.00,1.50,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:13','2024-08-11 19:05:13'),(4,27,2,2250000.00,1.50,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:15','2024-08-11 19:05:15'),(5,28,2,1000000.00,0.67,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:15','2024-08-11 19:05:15'),(6,30,2,1000000.00,2.00,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:16','2024-08-11 19:05:16'),(7,31,2,17000000.00,1.50,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:17','2024-08-11 19:05:17'),(8,32,2,200000.00,1.00,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:17','2024-08-11 19:05:17'),(9,33,2,500000.00,1.50,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:18','2024-08-11 19:05:18'),(10,34,2,1000000.00,2.00,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:19','2024-08-11 19:05:19'),(11,35,2,900000.00,1.00,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:19','2024-08-11 19:05:19'),(12,36,2,950000.00,1.00,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:20','2024-08-11 19:05:20'),(13,43,2,999999.94,1.00,NULL,NULL,NULL,2,NULL,'2024-08-11 19:05:20','2024-08-11 19:05:20'),(14,60,2,11261250.00,9.99,'armazenamento/contratos/contract6602202408241028.pdf',NULL,NULL,0,NULL,'2024-08-24 11:12:28','2024-08-24 10:12:28');

#
# Structure for table "rodadas_investimento"
#

DROP TABLE IF EXISTS `rodadas_investimento`;
CREATE TABLE `rodadas_investimento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_startup` bigint(11) NOT NULL DEFAULT 0,
  `valor_objetivo` float(12,2) NOT NULL DEFAULT 0.00,
  `valor_objetivo_sem_taxa` float(12,2) NOT NULL DEFAULT 0.00,
  `valor_obtido` float(12,2) NOT NULL DEFAULT 0.00,
  `oferta_acoes` float(4,2) NOT NULL DEFAULT 0.00,
  `max_investidores` int(11) NOT NULL DEFAULT 0,
  `valor_minimo_investimento` float(12,2) NOT NULL DEFAULT 0.00,
  `estado` enum('aberta','fechada','anulada','sucedida') DEFAULT 'aberta',
  `data_limite` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4;

#
# Data for table "rodadas_investimento"
#

INSERT INTO `rodadas_investimento` VALUES (1,6,5000000.00,0.00,0.00,3.00,2,2500000.00,'fechada','2024-04-29 00:00:00','2024-04-22 13:57:21','2024-08-13 20:31:20'),(2,6,2.00,0.00,0.00,2.00,23,0.09,'anulada','2024-04-26 00:00:00','2024-04-23 19:26:49','2024-04-23 19:26:55'),(3,6,2.00,0.00,0.00,2.00,2,1.00,'anulada','2024-04-27 00:00:00','2024-04-23 19:28:33','2024-04-23 19:28:39'),(4,6,2.00,0.00,0.00,2.00,2,1.00,'anulada','2024-04-27 00:00:00','2024-04-23 19:28:52','2024-04-23 19:28:55'),(5,6,2.00,0.00,0.00,2.00,2,1.00,'anulada','2024-04-27 00:00:00','2024-04-23 19:29:03','2024-04-23 19:29:06'),(6,6,2.00,0.00,0.00,2.00,2,1.00,'anulada','2024-04-24 00:00:00','2024-04-23 19:29:41','2024-04-23 19:29:42'),(7,6,23.00,0.00,0.00,12.00,2,11.50,'anulada','2024-04-27 00:00:00','2024-04-23 19:30:11','2024-04-23 19:30:18'),(8,6,23.00,0.00,0.00,2.00,2,11.50,'anulada','2024-04-27 00:00:00','2024-04-23 19:30:37','2024-04-23 19:31:19'),(9,3,23456000.00,0.00,0.00,21.00,12,1.92,'anulada','2024-04-30 00:00:00','2024-04-23 19:31:11','2024-04-29 11:00:12'),(10,6,23.00,0.00,0.00,2.00,2,11.50,'anulada','2024-04-27 00:00:00','2024-04-23 19:31:30','2024-04-23 19:31:33'),(11,6,23.00,0.00,0.00,2.00,2,11.50,'anulada','2024-04-27 00:00:00','2024-04-23 19:31:52','2024-04-23 19:31:56'),(12,6,23.00,0.00,0.00,2.00,2,11.50,'anulada','2024-04-27 00:00:00','2024-04-23 19:32:06','2024-04-23 19:32:08'),(13,6,23.00,0.00,0.00,2.00,2,11.50,'anulada','2024-04-27 00:00:00','2024-04-23 19:32:17','2024-04-23 19:32:19'),(14,6,5000000.00,0.00,0.00,0.03,4,1250000.00,'anulada','2024-04-26 00:00:00','2024-04-26 15:02:48','2024-04-28 13:08:34'),(15,6,5000000000.00,0.00,0.00,2.00,1,5000000000.00,'anulada','2024-05-11 00:00:00','2024-04-29 12:23:21','2024-05-04 21:11:31'),(16,6,5345536512.00,0.00,0.00,3.33,14,381824032.00,'anulada','2024-05-11 00:00:00','2024-04-28 14:46:36','2024-04-28 18:07:51'),(17,6,50000000.00,0.00,0.00,2.00,3,16666667.00,'anulada','2024-05-11 00:00:00','2024-04-29 11:04:29','2024-04-29 11:32:55'),(18,6,5000000.00,0.00,0.00,2.00,2,2500000.00,'anulada','2024-05-06 00:00:00','2024-05-05 16:25:04','2024-05-05 16:25:38'),(19,6,500000000.00,0.00,0.00,2.00,6,83333336.00,'anulada','2024-05-06 00:00:00','2024-05-05 22:54:59','2024-05-05 22:55:04'),(20,6,500000.00,0.00,0.00,0.02,6,83333.33,'anulada','2024-05-06 00:00:00','2024-05-05 22:56:43','2024-05-05 22:56:44'),(21,6,43000000.00,0.00,0.00,3.00,3,14333333.00,'anulada','2024-06-01 00:00:00','2024-05-05 23:04:33','2024-05-05 23:05:04'),(22,6,4500.00,0.00,0.00,0.20,1,4500.00,'anulada','2024-05-06 00:00:00','2024-05-05 23:05:47','2024-05-05 23:05:57'),(23,6,40000.00,0.00,0.00,0.33,1,40000.00,'anulada','2024-05-06 00:00:00','2024-05-05 23:06:56','2024-05-05 23:13:15'),(24,6,5000000000.00,0.00,0.00,5.00,6,833333312.00,'anulada','2024-05-07 00:00:00','2024-05-05 23:27:40','2024-05-05 23:27:41'),(25,6,60000000.00,0.00,0.00,4.00,10,6000000.00,'anulada','2024-05-07 00:00:00','2024-05-05 23:29:44','2024-05-05 23:31:02'),(26,6,50000000.00,0.00,50000000.00,3.00,10,5000000.00,'anulada','2024-06-01 00:00:00','2024-05-05 23:32:03','2024-06-06 20:22:54'),(27,23,4500000.00,0.00,4500000.00,3.00,2,2250000.00,'anulada','2024-06-08 00:00:00','2024-05-06 03:17:54','2024-05-06 08:49:22'),(28,23,3000000.00,0.00,1000000.00,2.00,3,1000000.00,'anulada','2024-05-29 00:00:00','2024-05-06 07:51:32','2024-05-06 11:17:59'),(29,23,400000.00,0.00,0.00,1.00,2,200000.00,'anulada','2024-05-22 00:00:00','2024-05-06 11:20:35','2024-05-06 11:47:37'),(30,23,2500000.00,0.00,1000000.00,5.00,5,500000.00,'anulada','2024-05-31 00:00:00','2024-05-06 11:48:36','2024-05-06 11:55:25'),(31,23,34000000.00,0.00,17000000.00,3.00,2,17000000.00,'anulada','2024-05-31 00:00:00','2024-05-06 11:56:35','2024-05-06 12:11:47'),(32,23,1000000.00,0.00,200000.00,5.00,5,200000.00,'anulada','2024-06-07 00:00:00','2024-05-06 12:41:06','2024-05-06 12:47:43'),(33,23,1000000.00,0.00,500000.00,3.00,2,500000.00,'anulada','2024-06-07 00:00:00','2024-05-06 13:13:24','2024-05-06 13:52:46'),(34,23,1000000.00,0.00,1000000.00,2.00,2,500000.00,'anulada','2024-06-05 00:00:00','2024-05-06 13:54:09','2024-05-06 14:58:00'),(35,23,900000.00,0.00,900000.00,1.00,1,900000.00,'anulada','2024-06-06 00:00:00','2024-05-06 13:58:58','2024-05-06 15:03:03'),(36,23,950000.00,0.00,950000.00,1.00,1,950000.00,'anulada','2024-06-07 00:00:00','2024-05-06 14:04:14','2024-05-06 15:13:06'),(37,23,1000000.00,0.00,0.00,1.00,1,1000000.00,'anulada','2024-06-05 00:00:00','2024-05-06 14:14:28','2024-05-06 14:14:43'),(38,23,1000000.00,0.00,0.00,1.00,1,1000000.00,'anulada','2024-06-05 00:00:00','2024-05-06 14:15:19','2024-05-06 14:15:23'),(39,23,999999.94,0.00,0.00,1.00,1,999999.94,'anulada','2024-06-05 00:00:00','2024-05-06 14:15:31','2024-05-06 14:15:35'),(40,23,999999.94,0.00,0.00,1.00,1,999999.94,'anulada','2024-06-05 00:00:00','2024-05-06 14:15:42','2024-05-06 14:15:45'),(41,23,999999.94,0.00,0.00,1.00,1,999999.94,'anulada','2024-06-05 00:00:00','2024-05-06 14:15:57','2024-05-06 14:16:03'),(42,23,1000000.00,0.00,0.00,1.00,1,1000000.00,'anulada','2024-06-05 00:00:00','2024-05-06 14:16:12','2024-05-06 14:16:15'),(43,23,999999.94,0.00,999999.94,1.00,1,999999.94,'anulada','2024-06-05 00:00:00','2024-05-06 14:16:23','2024-05-06 16:54:04'),(44,23,5000000.00,0.00,0.00,2.00,1,5000000.00,'anulada','2024-06-01 00:00:00','2024-05-06 16:52:50','2024-05-06 16:54:43'),(45,23,400000.00,0.00,0.00,2.00,1,400000.00,'anulada','2024-05-31 00:00:00','2024-05-06 16:55:03','2024-05-06 16:55:46'),(46,23,5000000.00,0.00,0.00,2.00,1,5000000.00,'anulada','2024-06-06 00:00:00','2024-05-06 16:56:06','2024-05-06 16:56:57'),(47,23,3500000.00,0.00,3500000.00,2.00,1,3500000.00,'anulada','2024-05-30 00:00:00','2024-05-06 16:57:18','2024-08-01 12:52:12'),(48,6,5000000.00,0.00,0.00,10.00,3,1666666.62,'anulada','2024-06-20 00:00:00','2024-06-18 18:12:51','2024-06-18 18:14:03'),(49,6,500000.00,0.00,0.00,10.00,1,500000.00,'anulada','2024-06-20 00:00:00','2024-06-18 18:14:46','2024-06-18 18:14:52'),(50,6,500000.00,0.00,0.00,10.00,1,500000.00,'anulada','2024-06-20 00:00:00','2024-06-18 18:15:00','2024-06-18 18:15:13'),(51,6,4000000.00,0.00,0.00,10.00,1,4000000.00,'anulada','2024-06-21 00:00:00','2024-06-18 18:32:00','2024-06-18 18:32:23'),(52,6,4000.00,0.00,0.00,4.44,1,4000.00,'anulada','2024-06-21 00:00:00','2024-06-18 18:33:53','2024-06-18 18:34:21'),(53,6,6250000.00,5000000.00,0.00,10.00,1,6250000.00,'anulada','2024-07-05 00:00:00','2024-06-30 19:53:20','2024-06-30 20:07:32'),(54,6,8750000.00,7000000.00,0.00,10.00,3,2916666.75,'anulada','2024-07-04 00:00:00','2024-06-30 20:08:00','2024-06-30 20:41:15'),(55,6,5000000.00,4000000.00,0.00,1.00,1,5000000.00,'anulada','2024-07-04 00:00:00','2024-06-30 20:42:12','2024-06-30 20:50:27'),(56,6,6250000.00,5000000.00,0.00,10.00,1,6250000.00,'anulada','2024-07-10 00:00:00','2024-07-02 18:04:38','2024-07-02 18:06:36'),(57,6,62500.00,50000.00,0.00,10.00,1,62500.00,'anulada','2024-08-07 00:00:00','2024-07-02 18:41:57','2024-07-02 18:45:25'),(58,6,625000.00,500000.00,0.00,10.00,1,625000.00,'anulada','2024-07-04 00:00:00','2024-07-02 20:36:57','2024-07-02 20:37:04'),(59,6,0.09,0.07,0.00,0.07,1,0.09,'anulada','2024-07-10 00:00:00','2024-07-02 21:24:23','2024-07-02 21:27:36'),(60,6,11261250.00,9009000.00,11261250.00,44.55,1,11261250.00,'fechada','2024-09-20 01:00:00','2024-07-04 20:39:00','2024-08-14 21:00:37');

#
# Structure for table "setores_economico"
#

DROP TABLE IF EXISTS `setores_economico`;
CREATE TABLE `setores_economico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

#
# Data for table "setores_economico"
#

INSERT INTO `setores_economico` VALUES (1,'Saúde','2022-02-16 14:38:58','2022-02-16 14:38:58'),(2,'Educação','2022-02-16 14:39:10','2022-02-16 14:39:10'),(3,'Imóveis','2022-02-16 14:40:02','2022-02-16 14:40:02'),(4,'Mobilidade','2022-02-16 14:41:15','2022-02-16 14:41:15'),(5,'Logística','2022-04-25 20:03:04','2022-04-25 20:03:04'),(6,'Health','2024-04-28 12:38:27','2024-04-28 12:38:27'),(7,'Fintech','2024-05-06 01:40:13','2024-05-06 01:40:13');

#
# Structure for table "startups"
#

DROP TABLE IF EXISTS `startups`;
CREATE TABLE `startups` (
  `fk_user` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `nif` varchar(255) NOT NULL DEFAULT '',
  `fk_setor_economico` int(11) unsigned NOT NULL DEFAULT 0,
  `fk_fase_desenvolvimento` int(11) NOT NULL DEFAULT 0,
  `pitch_elevator` varchar(1000) NOT NULL DEFAULT '',
  `pitch_deck` varchar(255) DEFAULT '',
  `mvp` varchar(255) NOT NULL DEFAULT '',
  `logotipo` varchar(255) NOT NULL DEFAULT '',
  `estado_busca_invest` enum('sim','nao') NOT NULL DEFAULT 'nao',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`fk_user`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

#
# Data for table "startups"
#

INSERT INTO `startups` VALUES (3,'Oprivado','armazenamento/startups/nif/nif0606030320242024091459.pdf',4,1,'A##Oprivado##está construindo##software##para ajudar##influêncers digitais angolanos##\n        a##monetizarem com seus conteúdos##com##inclui sistemas de pagamento integrado','armazenamento/startups/pitch/pitch_3.mp4','armazenamento/startups/mvp/mvp0606030320242024091459.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-03-06 09:15:42','2024-04-29 11:00:12'),(4,'kubinga','armazenamento/startups/nif/nif0606030320242024091931.pdf',2,1,'A##kubinga##está construindo##serviço##para ajudar##taxistas angolanos##\n        a##monetizar##com##aplicativo e comodidade','','armazenamento/startups/mvp/mvp0606030320242024091931.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-03-06 09:20:27','2024-03-06 09:20:27'),(6,'startupInveste','armazenamento/startups/nif/nif0606030320242024092955.pdf',4,1,'A##startupInveste##está construindo##software##para ajudar##startups angolanas e investidores##\n        a##acessar financiamento e oportunidade de investir##com##comodidade e risco reduzido','armazenamento/startups/pitch/pitch_6.mp4','armazenamento/startups/mvp/mvp0606030320242024092955.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-03-06 09:30:42','2024-08-13 19:12:47'),(10,'Kubinga 2','armazenamento/startups/nif/nif0202040420242024120951.pdf',4,1,'A##Kubinga 2##está construindo##serviço de taxi##para ajudar##angolanos##\n        a##moverem-se##com##aplicação','','armazenamento/startups/mvp/mvp0202040420242024120953.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-02 11:10:22','2024-04-02 11:10:22'),(11,'kubeta','armazenamento/startups/nif/nif0808040420242024083819.pdf',2,1,'A##kubeta##está construindo##serviço##para ajudar##angolanos##\n        a##acessarem livros##com##à qualquer altura','','armazenamento/startups/mvp/mvp0808040420242024083820.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-08 08:38:21','2024-04-08 08:38:21'),(12,'bomba','armazenamento/startups/nif/nif0808040420242024084957.pdf',4,1,'A##bomba##está construindo##testesss##para ajudar##testeee##\n        a##testeeee##com##testeee','','armazenamento/startups/mvp/mvp0808040420242024084957.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-08 08:51:00','2024-04-08 08:51:00'),(14,'crypto','armazenamento/startups/nif/nif2323040420242024073551.pdf',2,1,'A##crypto##está construindo##uma aplicação web##para ajudar##Pessoas##\n        a##vivenciarem a inclusão financeira##com##rapidez e segurança','','armazenamento/startups/mvp/mvp2323040420242024073551.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-23 19:35:51','2024-04-23 19:35:51'),(15,'edukids','armazenamento/startups/nif/nif2323040420242024073812.pdf',2,1,'A##edukids##está construindo##Aplicação web##para ajudar##Encarregados de educação##\n        a##Monitorar o desempenho escolar de seus encarregandos##com##Com rapidez','','armazenamento/startups/mvp/mvp2323040420242024073812.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-23 19:38:12','2024-04-23 19:38:12'),(17,'nvidia','armazenamento/startups/nif/nif2323040420242024080326.pdf',2,1,'A##nvidia##está construindo##software##para ajudar##utilizadores de pcs##\n        a##aumentarem capacidade de processamento de seus pcs##com##baixo custo','','armazenamento/startups/mvp/mvp2323040420242024080326.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-23 20:03:26','2024-04-23 20:03:26'),(19,'lamina','armazenamento/startups/nif/nif2323040420242024080640.pdf',2,1,'A##lamina##está construindo##software##para ajudar##pessoas##\n        a##ajustar cargar horarias##com##aplicativo','','armazenamento/startups/mvp/mvp2323040420242024080640.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-23 20:06:41','2024-04-23 20:06:41'),(20,'onFly','armazenamento/startups/nif/nif2323040420242024083414.pdf',2,1,'A##onFly##está construindo##aeronave##para ajudar##pessoas##\n        a##locomoverem-se de forma rápida##com##baixo custo','','armazenamento/startups/mvp/mvp2323040420242024083414.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-23 20:34:14','2024-04-23 20:34:14'),(21,'kikolo','armazenamento/startups/nif/nif2727040420242024044223.pdf',4,1,'A##kikolo##está construindo##software##para ajudar##pessoas residentes em Angola##\n        a##comprar##com##aplicativo','','armazenamento/startups/mvp/mvp2727040420242024044224.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-27 16:42:24','2024-04-27 16:42:24'),(22,'happysaude','armazenamento/startups/nif/nif2828040420242024123826.pdf',6,3,'A##happysaude##está construindo##software##para ajudar##angolanos##\n        a##terem acesso a serviços de saúde##com##aplicativo e rapidez','','armazenamento/startups/mvp/mvp2828040420242024123826.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-28 12:38:27','2024-04-28 12:38:27'),(23,'teste','armazenamento/startups/nif/nif0606050520242024014013.pdf',7,1,'A##teste##está construindo##teste##para ajudar##teste##\n        a##teste##com##teste','armazenamento/startups/pitch/pitch_23.mp4','armazenamento/startups/mvp/mvp0606050520242024014013.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-05-06 01:40:13','2024-08-01 12:52:12');

#
# Structure for table "transactions"
#

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item_price` float(10,2) DEFAULT NULL,
  `order_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fk_payer` bigint(11) NOT NULL DEFAULT 0,
  `payment_source` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_source_card_last_digits` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_source_card_expiry` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_source_card_brand` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_status` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Data for table "transactions"
#

INSERT INTO `transactions` VALUES (1,'startupinveste03202406095403','startupInveste',5000000.00,'4SL66149UG8943948',2,'card','0004','2025-12','VISA','created','2024-05-06 01:14:11','2024-05-06 01:14:17'),(2,'startupinveste03202406095403','startupInveste',45000000.00,'76H51544CD701702N',9,NULL,NULL,NULL,NULL,'created','2024-05-06 01:25:36','2024-05-06 01:25:36'),(3,'startupinveste03202406095403','startupInveste',45000000.00,'14F61089H7184523A',9,NULL,NULL,NULL,NULL,'created','2024-05-06 01:25:48','2024-05-06 01:25:48'),(4,'startupinveste03202406095403','startupInveste',45000000.00,'9VM28362XV623730F',9,NULL,NULL,NULL,NULL,'created','2024-05-06 01:25:56','2024-05-06 01:25:56'),(5,'startupinveste03202406095403','startupInveste',45000000.00,'6NK54056UH758214H',9,NULL,NULL,NULL,NULL,'created','2024-05-06 01:26:08','2024-05-06 01:26:08'),(6,'startupinveste03202406095403','startupInveste',45000000.00,'1MY59494XT6982740',9,'card','0004','2026-12','VISA','created','2024-05-06 01:26:52','2024-05-06 01:26:58'),(7,'teste05202406011205','teste',2250000.00,'73X10988T1417954U',9,'card','0004','2025-12','VISA','created','2024-05-06 03:26:00','2024-05-06 03:26:05'),(8,'teste05202406011205','teste',2250000.00,'5E832999C54218253',2,'card','0004','2025-12','VISA','created','2024-05-06 07:15:32','2024-05-06 07:15:38'),(9,'teste05202406011205','teste',1000000.00,'6C247285GF7117338',2,'card','0004','2025-12','VISA','created','2024-05-06 07:58:56','2024-05-06 07:59:02'),(10,'teste05202406011205','teste',200000.00,'9CS13098D9590680U',2,NULL,NULL,NULL,NULL,'created','2024-05-06 11:22:07','2024-05-06 11:22:07'),(11,'teste05202406011205','teste',1000000.00,'0YL15319VB7063454',2,'card','0004','2025-12','VISA','created','2024-05-06 11:50:24','2024-05-06 11:50:29'),(12,'teste05202406011205','teste',17000000.00,'6U718275MG3593108',2,NULL,NULL,NULL,NULL,'created','2024-05-06 12:02:59','2024-05-06 12:02:59'),(13,'teste05202406011205','teste',17000000.00,'1XX21376Y52367418',2,'card','0004','2024-11','VISA','created','2024-05-06 12:04:55','2024-05-06 12:05:00'),(14,'teste05202406011205','teste',200000.00,'2RY16516WG2703748',2,'card','0004','2024-12','VISA','created','2024-05-06 12:42:06','2024-05-06 12:42:11'),(15,'teste05202406011205','teste',500000.00,'6H660930N24081454',2,'card','0004','2026-12','VISA','created','2024-05-06 13:14:36','2024-05-06 13:14:42'),(16,'teste05202406011205','teste',1000000.00,'3A3158988W549392P',2,'card','0004','2024-12','VISA','created','2024-05-06 13:55:21','2024-05-06 13:55:26'),(17,'teste05202406011205','teste',900000.00,'4VT77288LR2119455',2,'card','0004','2028-03','VISA','created','2024-05-06 14:00:43','2024-05-06 14:00:49'),(18,'teste05202406011205','teste',950000.00,'3BN01094FG558624E',2,'card','0004','2026-12','VISA','created','2024-05-06 14:09:45','2024-05-06 14:09:51'),(19,'teste05202406011205','teste',999999.94,'8YW767446A659274L',2,'card','0004','2027-12','VISA','created','2024-05-06 14:17:24','2024-05-06 14:17:31'),(20,'teste05202406011205','teste',3500000.00,'6C621692GA917135E',2,'card','0004','2024-12','VISA','created','2024-05-06 17:11:13','2024-05-06 17:11:18');

#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `estado` enum('espera','regeitado','aceite') NOT NULL DEFAULT 'espera',
  `tipo` enum('startup','investidor','admin') NOT NULL DEFAULT 'startup',
  `code_user` varchar(1000) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

#
# Data for table "users"
#

INSERT INTO `users` VALUES (1,'guiframart1@hotmail.com','$2y$10$CS.Jp7TK2f5H/8Dqjl3cze7DpX6kbMHO/ZhCfrIHfuSlDTU7m0t1G','aceite','admin','admin2024','2024-03-05 15:49:23','2024-03-06 10:22:17'),(2,'joel@hotmail.com','$2y$10$CS.Jp7TK2f5H/8Dqjl3cze7DpX6kbMHO/ZhCfrIHfuSlDTU7m0t1G','aceite','investidor','joel0606030320242024090521','2024-03-06 09:05:22','2024-03-06 11:04:13'),(3,'privado@hotmail.com','$2y$10$CS.Jp7TK2f5H/8Dqjl3cze7DpX6kbMHO/ZhCfrIHfuSlDTU7m0t1G','aceite','startup','oprivado03202406095803','2024-03-06 09:14:58','2024-03-06 11:04:14'),(4,'guitocode@hotmail.com','$2y$10$CS.Jp7TK2f5H/8Dqjl3cze7DpX6kbMHO/ZhCfrIHfuSlDTU7m0t1G','aceite','startup','kubinga03202406093003','2024-03-06 09:19:30','2024-03-06 11:04:15'),(5,'guiframart3@hotmail.com','$2y$10$4fiqDVj6G9run1h1ydX42.PELBC7DIGt9k.8/wuznuISfLqtkaRf2','aceite','investidor','guilherme0606030320242024092351','2024-03-06 09:23:51','2024-05-06 02:38:16'),(6,'startupinveste@hotmail.com','$2y$10$CS.Jp7TK2f5H/8Dqjl3cze7DpX6kbMHO/ZhCfrIHfuSlDTU7m0t1G','aceite','startup','startupinveste03202406095403','2024-03-06 09:29:54','2024-03-06 11:04:18'),(7,'outro@hotmail.com','$2y$10$W78EoocxvhPJzfyVDF1ac.ZsU8FGBtkdZAQv6yOG0d0XfHP9MzFGe','espera','investidor','outro0909030320242024094311','2024-03-09 21:43:11','2024-03-09 21:43:11'),(9,'adao@hotmail.com','$2y$10$CS.Jp7TK2f5H/8Dqjl3cze7DpX6kbMHO/ZhCfrIHfuSlDTU7m0t1G','aceite','investidor','adÃo de almÉida josÉ2424030320242024042838','2024-03-24 16:28:38','2024-03-24 17:32:01'),(10,'kubinga@hotmail.com','$2y$10$CJ8qc1vq9yKRLTSivqk0K.go0ZeiuIegXYVBuRCLdo32kmieTpNx2','espera','startup','kubinga 204202402125004','2024-04-02 11:09:51','2024-04-02 11:09:51'),(11,'kubeta@hotmail.com','$2y$10$DL0omAb8STLah4qBVeaCQ.543HXxoQnMjWEZX1RqEWmxhM6WUqqz6','espera','startup','kubeta04202408081604','2024-04-08 08:38:18','2024-04-08 08:38:18'),(12,'bomba@hotmail.com','$2y$10$i5U14XJoPnLWT.0a8qGHfeM1SHk1Kxa/ySHJ6PvuQGFhhWiduELgy','espera','startup','bomba04202408085604','2024-04-08 08:49:57','2024-04-08 08:49:57'),(13,'devolve@hotmail.com','$2y$10$adKAwP04xNmzS3kMhqoQmOwvwbTFFU4IRWbIVB4QXTccTeIgIUoaK','espera','investidor','devolve0808040420242024112927','2024-04-08 11:29:29','2024-04-08 11:29:29'),(14,'crypto','$2y$10$lte9olV24EXbek0vvb8qa..4B099Z6pfxLm/8fjnJD0iG/a96cwoK','espera','startup','crypto04202423075104','2024-04-23 19:35:51','2024-04-23 19:35:51'),(15,'edukids','$2y$10$SP5C3xH2QSjKTIHmoqyK1ekmzrQqHE5H0t/V25qtyMAeqTYzwBiKq','espera','startup','edukids04202423071204','2024-04-23 19:38:12','2024-04-23 19:38:12'),(16,'modric@hotmail.com','$2y$10$EIfRNRu92ibsUP8jmYtGZuRKM.weUe6NtMokEz6/UJ.VxRV9iAN1G','espera','investidor','lucas modric2323040420242024074047','2024-04-23 19:40:47','2024-04-23 19:40:47'),(17,'nvidia@hotmail.com','$2y$10$4FEoUFE.iZln9KgQb5.c8ukn24ROiuEm8NQsZGmBjLewHs7MmZL4O','espera','startup','nvidia04202423082604','2024-04-23 20:03:26','2024-04-23 20:03:26'),(18,'fragoso@hotmail.com','$2y$10$eNVXTtKKgtDblfWkBj0K2..WLzwMPVG5IggA9DVzU5VOMuiHUwzVG','espera','investidor','fragoso martins2323040420242024080448','2024-04-23 20:04:48','2024-04-23 20:04:48'),(19,'lamina@hotmail.com','$2y$10$eUU9oeUhB/6iIg44YLw64.Sckar85HjDOxzinF8Azz7mrrCdzsTiy','espera','startup','lamina04202423084004','2024-04-23 20:06:40','2024-04-23 20:06:40'),(20,'onfly@hotmail.com','$2y$10$NFpV1nm8nPEQLG2.Sf9nluDejDjE0kvEYy19oZS2qdTFc3ebL5t1i','espera','startup','onfly04202423081404','2024-04-23 20:34:14','2024-04-23 20:34:14'),(21,'kikolo@hotmail.com','$2y$10$.a/NB7ZUGuSLv5HTFXt5BeiyrlM7eQDeAmvm0K5F0sdt6F3GGCXla','espera','startup','kikolo04202427042204','2024-04-27 16:42:22','2024-04-27 16:42:22'),(22,'happysaude@hotmail.com','$2y$10$7W5XqP3JKeyM/5.5gjDcCumPyaR928O66OHZICxUcskcY/cygeqoq','espera','startup','happysaude04202428122504','2024-04-28 12:38:26','2024-04-28 12:38:26'),(23,'guiframart@hotmail.com','$2y$10$CS.Jp7TK2f5H/8Dqjl3cze7DpX6kbMHO/ZhCfrIHfuSlDTU7m0t1G','aceite','startup','teste05202406011205','2024-05-06 01:40:12','2024-05-06 04:12:30');

#
# Structure for table "websockets_statistics_entries"
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
# Data for table "websockets_statistics_entries"
#

