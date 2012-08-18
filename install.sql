-- phpMyAdmin SQL Dump
-- version OVH
-- http://www.phpmyadmin.net
--
-- Client: mysql5-15.pro
-- Généré le : Sam 18 Août 2012 à 15:01
-- Version du serveur: 5.0.51
-- Version de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `straswebtest`
--

-- --------------------------------------------------------

--
-- Structure de la table `bumrang_entries`
--

CREATE TABLE IF NOT EXISTS `bumrang_entries` (
  `num` smallint(6) NOT NULL auto_increment,
  `id` varchar(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `date1` date NOT NULL,
  `date2` date NOT NULL,
  `extend` tinyint(4) NOT NULL default '0',
  `other1` varchar(100) NOT NULL,
  `other2` varchar(100) NOT NULL,
  `other3` varchar(100) NOT NULL,
  `other4` varchar(100) NOT NULL,
  PRIMARY KEY  (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=107 ;
