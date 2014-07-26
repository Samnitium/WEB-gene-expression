-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Lug 26, 2014 alle 21:29
-- Versione del server: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gene_expression`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `analysis`
--

CREATE TABLE IF NOT EXISTS `analysis` (
  `id` bigint(200) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `id_experiment` int(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `analysis_instance`
--

CREATE TABLE IF NOT EXISTS `analysis_instance` (
  `id_analysis` bigint(200) NOT NULL,
  `geneSymbol` varchar(40) NOT NULL,
  `p_value_string` varchar(30) NOT NULL,
  `p_value` double(30,30) NOT NULL,
  `foldChange` double NOT NULL,
  PRIMARY KEY (`id_analysis`,`geneSymbol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `experiment`
--

CREATE TABLE IF NOT EXISTS `experiment` (
  `id` bigint(200) NOT NULL AUTO_INCREMENT,
  `name` mediumtext NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `gene`
--

CREATE TABLE IF NOT EXISTS `gene` (
  `id` bigint(200) NOT NULL AUTO_INCREMENT,
  `geneSymbol` varchar(50) NOT NULL,
  `geneAssignment` longtext NOT NULL,
  `refSeq` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5541 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(200) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `type` varchar(15) NOT NULL,
  `code` varchar(60) NOT NULL,
  `account_activated` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `name`, `surname`, `type`, `code`, `account_activated`) VALUES
(3, 't.mazza@css-mendel.it', 'ciao', 'Tommaso', 'Mazza', 'superuser', '', 'Y');

-- --------------------------------------------------------

--
-- Struttura della tabella `viewpermission`
--

CREATE TABLE IF NOT EXISTS `viewpermission` (
  `id_user` bigint(200) NOT NULL,
  `id_experiment` bigint(200) NOT NULL,
  PRIMARY KEY (`id_user`,`id_experiment`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
