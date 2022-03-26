-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 25-Mar-2022 às 23:01
-- Versão do servidor: 5.7.36
-- versão do PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dblocafarma`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cadastro_adm`
--

DROP TABLE IF EXISTS `tb_cadastro_adm`;
CREATE TABLE IF NOT EXISTS `tb_cadastro_adm` (
  `ID_ADM` int(11) NOT NULL AUTO_INCREMENT,
  `NOME_ADM` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `EMAIL_ADM` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `SENHA_ADM` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID_ADM`),
  UNIQUE KEY `EMAIL_ADM` (`EMAIL_ADM`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_cadastro_adm`
--

INSERT INTO `tb_cadastro_adm` (`ID_ADM`, `NOME_ADM`, `EMAIL_ADM`, `SENHA_ADM`) VALUES
(1, 'Gustavo', 'gustavoaqm11@gmail.com', 'MTIzNDU2Nzg=');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_codigos`
--

DROP TABLE IF EXISTS `tb_codigos`;
CREATE TABLE IF NOT EXISTS `tb_codigos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `data` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_faleconosco`
--

DROP TABLE IF EXISTS `tb_faleconosco`;
CREATE TABLE IF NOT EXISTS `tb_faleconosco` (
  `id_contato` int(11) NOT NULL AUTO_INCREMENT,
  `nome_contato` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `email_contato` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `assunto` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `msg_contato` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_contato`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_farmacia`
--

DROP TABLE IF EXISTS `tb_farmacia`;
CREATE TABLE IF NOT EXISTS `tb_farmacia` (
  `ID_FARM` int(11) NOT NULL AUTO_INCREMENT,
  `NOME_FARM` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `CNES_FARM` char(7) COLLATE utf8_unicode_ci NOT NULL,
  `CNPJ_FARM` char(18) COLLATE utf8_unicode_ci NOT NULL,
  `ENDERECO_FARM` text COLLATE utf8_unicode_ci NOT NULL,
  `TEL_FARM` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `GESTAO` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `ATENDE_SUS` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `EMAIL_FARM` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `SENHA_FARM` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID_FARM`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_farmacia`
--

INSERT INTO `tb_farmacia` (`ID_FARM`, `NOME_FARM`, `CNES_FARM`, `CNPJ_FARM`, `ENDERECO_FARM`, `TEL_FARM`, `GESTAO`, `ATENDE_SUS`, `EMAIL_FARM`, `SENHA_FARM`) VALUES
(3, 'Drogasil', '9758534', '61585865216758', 'Av. Francisco Prestes Maia, 1066 - Centro, São Bernardo do Campo - SP', '11995974297', 'Empresa', 'Não', 'atendimento@drogasil.com.br', 'MTIzNDU='),
(6, 'Ultrafarma', '0000000', '900000000000000', 'Rua Fagundes Dias, Vila da Saúde, Saúde, São Paulo, Região Sudeste, 04055-060, Brasil', '00000000000', 'Ultrafarma', 'Sim', 'mail@mail10.com', 'MTIzNDU2Nzg='),
(8, 'Drogaria Onofre', '0000000', '00000000000000', 'Drogaria Onofre, Avenida Francisco Prestes Maia, Nova Petrópolis, São Bernardo do Campo, São Paulo, Região Sudeste, 09777-240, Brasil', '00000000000', 'Onofre', 'Sim', 'mail10@gmail.com', 'MTIzNDU2Nzg=');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_medicamento_anvisa`
--

DROP TABLE IF EXISTS `tb_medicamento_anvisa`;
CREATE TABLE IF NOT EXISTS `tb_medicamento_anvisa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ID_FARM` int(11) DEFAULT NULL,
  `principio_ativo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cnpj` varchar(18) COLLATE utf8_unicode_ci DEFAULT NULL,
  `laboratorio` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codggrem` varchar(18) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ean` varchar(18) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `apresentacao` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `precofab` decimal(8,2) DEFAULT NULL,
  `precocomercial` decimal(8,2) DEFAULT NULL,
  `restricaohospitalar` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24894 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_medicamento_anvisa`
--

INSERT INTO `tb_medicamento_anvisa` (`id`, `ID_FARM`, `principio_ativo`, `cnpj`, `laboratorio`, `codggrem`, `ean`, `nome`, `apresentacao`, `precofab`, `precocomercial`, `restricaohospitalar`) VALUES
(3940, 3, 'BUTILBROMETO DE ESCOPOLAMINA; DIPIRONA SÓDICA', '60831658000177', 'BOEHRINGER INGELHEIM DO BRASIL QUÍMICA E FARMACÊUTICA LTDA.', '504500902113315', '7896026301428', 'BUSCOPAN COMPOSTO', '250 MG + 10 MG COM REV CT BL AL PLAS INC X 20', '8.81', '11.72', 'Não'),
(22071, 3, 'IBUPROFENO', '00923140000131', 'EMS SIGMA PHARMA LTDA', '531616201119112', '7894916142755', 'IBUPROFENO', '200 MG COM REV CT BL AL PLAS OPC X 20', '9.00', '11.97', 'Não'),
(140, 3, 'BROMIDRATO DE CITALOPRAM', '04301884000175', 'AUROBINDO PHARMA INDÚSTRIA FARMACÊUTICA LIMITADA', '500113070014706', '7898361884499', 'BROMIDRATO DE CITALOPRAM', '20 MG COM REV CT BL AL PVC/PVDC INC X 560 (EMB HOSP)', '1097.80', '0.00', 'Sim'),
(176, 3, 'CLORIDRATO DE VERAPAMIL', '56998701000116', 'ABBOTT LABORATÓRIOS DO BRASIL LTDA', '500201901112118', '7896255700382', 'CLORIDRATO DE VERAPAMIL', '120 MG COM REV LIB RETARD CT BL AL PLAS INC X 20', '18.85', '26.06', 'Não'),
(8535, 3, 'FUROSEMIDA', '17503475000101', 'FUNDAÇÃO EZEQUIEL DIAS - FUNED', '509901901119418', '7898287820298', 'FUNED-FUROSEMIDA', '40 MG COM CX 50 ENV KRAFT POLIET X 10 (EMB HOSP)', '0.00', '0.00', 'Sim'),
(24875, 3, 'Timomodulina', '60659463000191', 'ACHÉ LABORATÓRIOS FARMACÊUTICOS S.A.', '500504902115416', '7896658002397', 'LEUCOGEN', '80 MG CAP GEL MICROG CT BL AL PLAS INC X 20', '84.00', '117.00', 'Não'),
(24893, 8, 'dipirona', '00000000000000', 'onofre', '000000000000000', '0000000000000', 'Dorflex', '50 Comprimidos', '3.99', '7.99', 'Não');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_pedido`
--

DROP TABLE IF EXISTS `tb_pedido`;
CREATE TABLE IF NOT EXISTS `tb_pedido` (
  `ID_PED` int(11) NOT NULL AUTO_INCREMENT,
  `ID_FARM` int(11) NOT NULL,
  `NOME_USU` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `EMAIL_USU` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `NOME_MED` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `DESC_MED` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID_PED`),
  KEY `ID_FARM` (`ID_FARM`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

DROP TABLE IF EXISTS `tb_usuario`;
CREATE TABLE IF NOT EXISTS `tb_usuario` (
  `ID_USU` int(11) NOT NULL AUTO_INCREMENT,
  `NOME_USU` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `EMAIL_USU` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `CEP_USU` char(8) COLLATE utf8_unicode_ci NOT NULL,
  `SENHA_USU` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID_USU`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`ID_USU`, `NOME_USU`, `EMAIL_USU`, `CEP_USU`, `SENHA_USU`) VALUES
(6, 'Gustavo', 'gustavoaqm11@gmail.com', '09751000', 'MTIzNDU2Nzg=');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
