-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

--
-- Table `tl_references`
--
CREATE TABLE `tl_teaserpage` (
	`id` int(10) unsigned NOT NULL auto_increment,
	`pid` int(10) unsigned NOT NULL default '0',
	`sorting` int(10) unsigned NOT NULL default '0',
	`tstamp` int(10) unsigned NOT NULL default '0',
	`name` varchar(255) NOT NULL default '',
	`page` int(10) unsigned NOT NULL default '0',
	`image` varchar(255) NOT NULL default '',
	`description` text NOT NULL,
	PRIMARY KEY  (`id`),
	KEY `pid` (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;