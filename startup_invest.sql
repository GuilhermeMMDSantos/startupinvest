# Host: localhost  (Version 5.5.5-10.3.16-MariaDB)
# Date: 2024-04-29 10:37:07
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

INSERT INTO `mensagens` VALUES (1,2,6,'Boa tarde emp','sim','2024-04-23 17:36:43','2024-04-23 17:37:00'),(2,6,2,'tudo numa','sim','2024-04-23 17:36:59','2024-04-24 10:49:11');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

#
# Data for table "notifications"
#

INSERT INTO `notifications` VALUES (1,'Investidor  deseja assistir vosso pitch!',6,2,'ver_pitch','clicado','2024-04-22 13:57:52','2024-04-22 13:58:09'),(2,'A startup startupInveste aceitou sua solicitação para ver o pitch.',2,6,'ver_pitch','clicado','2024-04-22 13:58:14','2024-04-22 14:10:25'),(3,'Investidor  deseja assistir vosso pitch!',6,2,'ver_pitch','clicado','2024-04-23 17:34:03','2024-04-23 17:34:16'),(4,'A startup startupInveste aceitou sua solicitação para ver o pitch.',2,6,'ver_pitch','clicado','2024-04-23 17:34:37','2024-04-23 17:36:16'),(5,'Investidor  deseja assistir vosso pitch!',6,2,'ver_pitch','clicado','2024-04-28 16:58:59','2024-04-28 17:01:10'),(6,'A startup startupInveste aceitou sua solicitação para ver o pitch.',2,6,'ver_pitch','visto','2024-04-28 17:01:13','2024-04-28 18:07:16');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

#
# Data for table "permissoes_ver_pitch"
#

INSERT INTO `permissoes_ver_pitch` VALUES (1,6,2,1,'1997-03-25 00:00:00','vencido','2024-04-23 17:34:03','2024-04-28 18:07:51'),(2,6,2,16,'1997-03-25 00:00:00','vencido','2024-04-28 16:58:59','2024-04-28 18:07:51');

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
  `contrato_mutou_aprovacao` enum('aguarda','aprovado') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# Data for table "rodadas_investidores"
#


#
# Structure for table "rodadas_investimento"
#

DROP TABLE IF EXISTS `rodadas_investimento`;
CREATE TABLE `rodadas_investimento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_startup` bigint(11) NOT NULL DEFAULT 0,
  `valor_objetivo` float(12,2) NOT NULL DEFAULT 0.00,
  `valor_obtido` float(12,2) NOT NULL DEFAULT 0.00,
  `oferta_acoes` float(4,2) NOT NULL DEFAULT 0.00,
  `max_investidores` int(11) NOT NULL DEFAULT 0,
  `valor_minimo_investimento` float(12,2) NOT NULL DEFAULT 0.00,
  `estado` enum('aberta','fechada','anulada','sucedida') DEFAULT 'aberta',
  `data_limite` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

#
# Data for table "rodadas_investimento"
#

INSERT INTO `rodadas_investimento` VALUES (1,6,5000000.00,0.00,3.00,2,2500000.00,'anulada','2024-04-29 00:00:00','2024-04-22 13:57:21','2024-04-23 19:24:29'),(2,6,2.00,0.00,2.00,23,0.09,'anulada','2024-04-26 00:00:00','2024-04-23 19:26:49','2024-04-23 19:26:55'),(3,6,2.00,0.00,2.00,2,1.00,'anulada','2024-04-27 00:00:00','2024-04-23 19:28:33','2024-04-23 19:28:39'),(4,6,2.00,0.00,2.00,2,1.00,'anulada','2024-04-27 00:00:00','2024-04-23 19:28:52','2024-04-23 19:28:55'),(5,6,2.00,0.00,2.00,2,1.00,'anulada','2024-04-27 00:00:00','2024-04-23 19:29:03','2024-04-23 19:29:06'),(6,6,2.00,0.00,2.00,2,1.00,'anulada','2024-04-24 00:00:00','2024-04-23 19:29:41','2024-04-23 19:29:42'),(7,6,23.00,0.00,12.00,2,11.50,'anulada','2024-04-27 00:00:00','2024-04-23 19:30:11','2024-04-23 19:30:18'),(8,6,23.00,0.00,2.00,2,11.50,'anulada','2024-04-27 00:00:00','2024-04-23 19:30:37','2024-04-23 19:31:19'),(9,3,23456000.00,0.00,21.00,12,1.92,'aberta','2024-04-30 00:00:00','2024-04-23 19:31:11','2024-04-28 17:58:04'),(10,6,23.00,0.00,2.00,2,11.50,'anulada','2024-04-27 00:00:00','2024-04-23 19:31:30','2024-04-23 19:31:33'),(11,6,23.00,0.00,2.00,2,11.50,'anulada','2024-04-27 00:00:00','2024-04-23 19:31:52','2024-04-23 19:31:56'),(12,6,23.00,0.00,2.00,2,11.50,'anulada','2024-04-27 00:00:00','2024-04-23 19:32:06','2024-04-23 19:32:08'),(13,6,23.00,0.00,2.00,2,11.50,'anulada','2024-04-27 00:00:00','2024-04-23 19:32:17','2024-04-23 19:32:19'),(14,6,5000000.00,0.00,0.03,4,1250000.00,'anulada','2024-04-26 00:00:00','2024-04-26 15:02:48','2024-04-28 13:08:34'),(15,6,5000000000.00,0.00,0.02,1,5000000000.00,'anulada','2024-05-11 00:00:00','2024-04-28 14:23:21','2024-04-28 14:24:06'),(16,6,5345536512.00,0.00,3.33,14,381824032.00,'anulada','2024-05-11 00:00:00','2024-04-28 14:46:36','2024-04-28 18:07:51');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

#
# Data for table "setores_economico"
#

INSERT INTO `setores_economico` VALUES (1,'Saúde','2022-02-16 14:38:58','2022-02-16 14:38:58'),(2,'Educação','2022-02-16 14:39:10','2022-02-16 14:39:10'),(3,'Imóveis','2022-02-16 14:40:02','2022-02-16 14:40:02'),(4,'Mobilidade','2022-02-16 14:41:15','2022-02-16 14:41:15'),(5,'Logística','2022-04-25 20:03:04','2022-04-25 20:03:04'),(6,'Health','2024-04-28 12:38:27','2024-04-28 12:38:27');

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

#
# Data for table "startups"
#

INSERT INTO `startups` VALUES (3,'Oprivado','armazenamento/startups/nif/nif0606030320242024091459.pdf',4,1,'A##Oprivado##está construindo##software##para ajudar##influêncers digitais angolanos##\n        a##monetizarem com seus conteúdos##com##inclui sistemas de pagamento integrado','armazenamento/startups/pitch/pitch_3.mp4','armazenamento/startups/mvp/mvp0606030320242024091459.mp4','armazenamento/startups/img/img_standard_startup.png','sim','2024-03-06 09:15:42','2024-04-28 17:47:50'),(4,'kubinga','armazenamento/startups/nif/nif0606030320242024091931.pdf',2,1,'A##kubinga##está construindo##serviço##para ajudar##taxistas angolanos##\n        a##monetizar##com##aplicativo e comodidade','','armazenamento/startups/mvp/mvp0606030320242024091931.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-03-06 09:20:27','2024-03-06 09:20:27'),(6,'startupInveste','armazenamento/startups/nif/nif0606030320242024092955.pdf',4,1,'A##startupInveste##está construindo##software##para ajudar##startups angolanas e investidores##\n        a##acessar financiamento e oportunidade de investir##com##comodidade e risco reduzido','armazenamento/startups/pitch/pitch_6.mp4','armazenamento/startups/mvp/mvp0606030320242024092955.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-03-06 09:30:42','2024-04-28 18:07:51'),(10,'Kubinga 2','armazenamento/startups/nif/nif0202040420242024120951.pdf',4,1,'A##Kubinga 2##está construindo##serviço de taxi##para ajudar##angolanos##\n        a##moverem-se##com##aplicação','','armazenamento/startups/mvp/mvp0202040420242024120953.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-02 11:10:22','2024-04-02 11:10:22'),(11,'kubeta','armazenamento/startups/nif/nif0808040420242024083819.pdf',2,1,'A##kubeta##está construindo##serviço##para ajudar##angolanos##\n        a##acessarem livros##com##à qualquer altura','','armazenamento/startups/mvp/mvp0808040420242024083820.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-08 08:38:21','2024-04-08 08:38:21'),(12,'bomba','armazenamento/startups/nif/nif0808040420242024084957.pdf',4,1,'A##bomba##está construindo##testesss##para ajudar##testeee##\n        a##testeeee##com##testeee','','armazenamento/startups/mvp/mvp0808040420242024084957.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-08 08:51:00','2024-04-08 08:51:00'),(14,'crypto','armazenamento/startups/nif/nif2323040420242024073551.pdf',2,1,'A##crypto##está construindo##uma aplicação web##para ajudar##Pessoas##\n        a##vivenciarem a inclusão financeira##com##rapidez e segurança','','armazenamento/startups/mvp/mvp2323040420242024073551.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-23 19:35:51','2024-04-23 19:35:51'),(15,'edukids','armazenamento/startups/nif/nif2323040420242024073812.pdf',2,1,'A##edukids##está construindo##Aplicação web##para ajudar##Encarregados de educação##\n        a##Monitorar o desempenho escolar de seus encarregandos##com##Com rapidez','','armazenamento/startups/mvp/mvp2323040420242024073812.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-23 19:38:12','2024-04-23 19:38:12'),(17,'nvidia','armazenamento/startups/nif/nif2323040420242024080326.pdf',2,1,'A##nvidia##está construindo##software##para ajudar##utilizadores de pcs##\n        a##aumentarem capacidade de processamento de seus pcs##com##baixo custo','','armazenamento/startups/mvp/mvp2323040420242024080326.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-23 20:03:26','2024-04-23 20:03:26'),(19,'lamina','armazenamento/startups/nif/nif2323040420242024080640.pdf',2,1,'A##lamina##está construindo##software##para ajudar##pessoas##\n        a##ajustar cargar horarias##com##aplicativo','','armazenamento/startups/mvp/mvp2323040420242024080640.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-23 20:06:41','2024-04-23 20:06:41'),(20,'onFly','armazenamento/startups/nif/nif2323040420242024083414.pdf',2,1,'A##onFly##está construindo##aeronave##para ajudar##pessoas##\n        a##locomoverem-se de forma rápida##com##baixo custo','','armazenamento/startups/mvp/mvp2323040420242024083414.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-23 20:34:14','2024-04-23 20:34:14'),(21,'kikolo','armazenamento/startups/nif/nif2727040420242024044223.pdf',4,1,'A##kikolo##está construindo##software##para ajudar##pessoas residentes em Angola##\n        a##comprar##com##aplicativo','','armazenamento/startups/mvp/mvp2727040420242024044224.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-27 16:42:24','2024-04-27 16:42:24'),(22,'happysaude','armazenamento/startups/nif/nif2828040420242024123826.pdf',6,3,'A##happysaude##está construindo##software##para ajudar##angolanos##\n        a##terem acesso a serviços de saúde##com##aplicativo e rapidez','','armazenamento/startups/mvp/mvp2828040420242024123826.mp4','armazenamento/startups/img/img_standard_startup.png','nao','2024-04-28 12:38:27','2024-04-28 12:38:27');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Data for table "transactions"
#


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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

#
# Data for table "users"
#

INSERT INTO `users` VALUES (1,'guiframart1@hotmail.com','$2y$10$CS.Jp7TK2f5H/8Dqjl3cze7DpX6kbMHO/ZhCfrIHfuSlDTU7m0t1G','aceite','admin','admin2024','2024-03-05 15:49:23','2024-03-06 10:22:17'),(2,'joel@hotmail.com','$2y$10$CS.Jp7TK2f5H/8Dqjl3cze7DpX6kbMHO/ZhCfrIHfuSlDTU7m0t1G','aceite','investidor','joel0606030320242024090521','2024-03-06 09:05:22','2024-03-06 11:04:13'),(3,'privado@hotmail.com','$2y$10$CS.Jp7TK2f5H/8Dqjl3cze7DpX6kbMHO/ZhCfrIHfuSlDTU7m0t1G','aceite','startup','oprivado03202406095803','2024-03-06 09:14:58','2024-03-06 11:04:14'),(4,'guitocode@hotmail.com','$2y$10$CS.Jp7TK2f5H/8Dqjl3cze7DpX6kbMHO/ZhCfrIHfuSlDTU7m0t1G','aceite','startup','kubinga03202406093003','2024-03-06 09:19:30','2024-03-06 11:04:15'),(5,'guiframart@hotmail.com','$2y$10$4fiqDVj6G9run1h1ydX42.PELBC7DIGt9k.8/wuznuISfLqtkaRf2','aceite','investidor','guilherme0606030320242024092351','2024-03-06 09:23:51','2024-03-08 21:53:54'),(6,'startupinveste@hotmail.com','$2y$10$CS.Jp7TK2f5H/8Dqjl3cze7DpX6kbMHO/ZhCfrIHfuSlDTU7m0t1G','aceite','startup','startupinveste03202406095403','2024-03-06 09:29:54','2024-03-06 11:04:18'),(7,'outro@hotmail.com','$2y$10$W78EoocxvhPJzfyVDF1ac.ZsU8FGBtkdZAQv6yOG0d0XfHP9MzFGe','espera','investidor','outro0909030320242024094311','2024-03-09 21:43:11','2024-03-09 21:43:11'),(9,'adao@hotmail.com','$2y$10$CS.Jp7TK2f5H/8Dqjl3cze7DpX6kbMHO/ZhCfrIHfuSlDTU7m0t1G','aceite','investidor','adÃo de almÉida josÉ2424030320242024042838','2024-03-24 16:28:38','2024-03-24 17:32:01'),(10,'kubinga@hotmail.com','$2y$10$CJ8qc1vq9yKRLTSivqk0K.go0ZeiuIegXYVBuRCLdo32kmieTpNx2','espera','startup','kubinga 204202402125004','2024-04-02 11:09:51','2024-04-02 11:09:51'),(11,'kubeta@hotmail.com','$2y$10$DL0omAb8STLah4qBVeaCQ.543HXxoQnMjWEZX1RqEWmxhM6WUqqz6','espera','startup','kubeta04202408081604','2024-04-08 08:38:18','2024-04-08 08:38:18'),(12,'bomba@hotmail.com','$2y$10$i5U14XJoPnLWT.0a8qGHfeM1SHk1Kxa/ySHJ6PvuQGFhhWiduELgy','espera','startup','bomba04202408085604','2024-04-08 08:49:57','2024-04-08 08:49:57'),(13,'devolve@hotmail.com','$2y$10$adKAwP04xNmzS3kMhqoQmOwvwbTFFU4IRWbIVB4QXTccTeIgIUoaK','espera','investidor','devolve0808040420242024112927','2024-04-08 11:29:29','2024-04-08 11:29:29'),(14,'crypto','$2y$10$lte9olV24EXbek0vvb8qa..4B099Z6pfxLm/8fjnJD0iG/a96cwoK','espera','startup','crypto04202423075104','2024-04-23 19:35:51','2024-04-23 19:35:51'),(15,'edukids','$2y$10$SP5C3xH2QSjKTIHmoqyK1ekmzrQqHE5H0t/V25qtyMAeqTYzwBiKq','espera','startup','edukids04202423071204','2024-04-23 19:38:12','2024-04-23 19:38:12'),(16,'modric@hotmail.com','$2y$10$EIfRNRu92ibsUP8jmYtGZuRKM.weUe6NtMokEz6/UJ.VxRV9iAN1G','espera','investidor','lucas modric2323040420242024074047','2024-04-23 19:40:47','2024-04-23 19:40:47'),(17,'nvidia@hotmail.com','$2y$10$4FEoUFE.iZln9KgQb5.c8ukn24ROiuEm8NQsZGmBjLewHs7MmZL4O','espera','startup','nvidia04202423082604','2024-04-23 20:03:26','2024-04-23 20:03:26'),(18,'fragoso@hotmail.com','$2y$10$eNVXTtKKgtDblfWkBj0K2..WLzwMPVG5IggA9DVzU5VOMuiHUwzVG','espera','investidor','fragoso martins2323040420242024080448','2024-04-23 20:04:48','2024-04-23 20:04:48'),(19,'lamina@hotmail.com','$2y$10$eUU9oeUhB/6iIg44YLw64.Sckar85HjDOxzinF8Azz7mrrCdzsTiy','espera','startup','lamina04202423084004','2024-04-23 20:06:40','2024-04-23 20:06:40'),(20,'onfly@hotmail.com','$2y$10$NFpV1nm8nPEQLG2.Sf9nluDejDjE0kvEYy19oZS2qdTFc3ebL5t1i','espera','startup','onfly04202423081404','2024-04-23 20:34:14','2024-04-23 20:34:14'),(21,'kikolo@hotmail.com','$2y$10$.a/NB7ZUGuSLv5HTFXt5BeiyrlM7eQDeAmvm0K5F0sdt6F3GGCXla','espera','startup','kikolo04202427042204','2024-04-27 16:42:22','2024-04-27 16:42:22'),(22,'happysaude@hotmail.com','$2y$10$7W5XqP3JKeyM/5.5gjDcCumPyaR928O66OHZICxUcskcY/cygeqoq','espera','startup','happysaude04202428122504','2024-04-28 12:38:26','2024-04-28 12:38:26');

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

