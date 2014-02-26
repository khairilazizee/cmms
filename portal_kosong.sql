-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jan 25, 2010 at 11:02 AM
-- Server version: 4.1.9
-- PHP Version: 4.3.10
-- 
-- Database: `portal_nkra`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `announcement`
-- 

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) NOT NULL default '',
  `activity` text NOT NULL,
  `active` char(1) NOT NULL default '',
  `startdate` date default NULL,
  `enddate` date default NULL,
  `ordering` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- 
-- Dumping data for table `announcement`
-- 

INSERT INTO `announcement` VALUES (13, 'PORTAL NKRA KPM 2010', 'Dalam pembangunan.', '1', '2009-04-14', '2010-12-14', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `blocks`
-- 

CREATE TABLE `blocks` (
  `id` int(11) NOT NULL auto_increment,
  `title` char(50) NOT NULL default '',
  `position` char(10) NOT NULL default '0',
  `name` char(50) NOT NULL default '',
  `image` char(50) NOT NULL default '',
  `public` char(1) NOT NULL default '',
  `active` char(1) NOT NULL default '',
  `ordering` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `blocks`
-- 

INSERT INTO `blocks` VALUES (1, 'Pengumuman', 'left', 'block-Pengumuman', '', '0', '1', 5);
INSERT INTO `blocks` VALUES (2, 'Login', 'center', 'block-Login', '', '1', '1', 1);
INSERT INTO `blocks` VALUES (3, 'Profil', 'left', 'block-Profil', '', '0', '1', 2);
INSERT INTO `blocks` VALUES (4, 'Pengenalan', 'center', 'block-Mesej', '', '1', '0', 3);
INSERT INTO `blocks` VALUES (6, 'Menu', 'left', 'block-Menu', '', '0', '1', 4);

-- --------------------------------------------------------

-- 
-- Table structure for table `content_category`
-- 

CREATE TABLE `content_category` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `fakulti` char(3) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `content_category`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `content_pages`
-- 

CREATE TABLE `content_pages` (
  `id` int(11) NOT NULL auto_increment,
  `category` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `content` text,
  `fakulti` char(3) default NULL,
  `ptj_only` char(1) NOT NULL default '0',
  `active` char(1) NOT NULL default '0',
  `public` char(1) NOT NULL default '0',
  `counter` int(11) NOT NULL default '0',
  `author` varchar(20) NOT NULL default '',
  `createddate` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `content_pages`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `menu`
-- 

CREATE TABLE `menu` (
  `id` int(11) NOT NULL auto_increment,
  `parent` int(11) NOT NULL default '0',
  `title` varchar(50) NOT NULL default '',
  `link` varchar(100) default NULL,
  `type` varchar(20) NOT NULL default '',
  `category` int(11) default NULL,
  `module` varchar(150) default NULL,
  `target_window` varchar(20) default NULL,
  `active` char(1) NOT NULL default '',
  `admin` char(1) NOT NULL default '0',
  `menupos` tinyint(4) NOT NULL default '0',
  `picture` varchar(50) default NULL,
  `description` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=142 ;

-- 
-- Dumping data for table `menu`
-- 

INSERT INTO `menu` VALUES (3, 0, 'Administrator', '', 'menu', 0, '', NULL, '1', '1', 1, '', '');
INSERT INTO `menu` VALUES (4, 3, 'Pengguna', 'admin.php?module=pengguna', 'modul', 0, 'pengguna', NULL, '1', '1', 2, '', '');
INSERT INTO `menu` VALUES (5, 3, 'Role', 'admin.php?module=role', 'modul', 0, 'role', NULL, '1', '1', 2, '', '');
INSERT INTO `menu` VALUES (6, 3, 'Blok', 'admin.php?module=block', 'modul', 0, 'block', NULL, '1', '1', 3, '', '');
INSERT INTO `menu` VALUES (7, 3, 'Modul', 'admin.php?module=module', 'modul', 0, 'module', NULL, '1', '1', 5, '', '');
INSERT INTO `menu` VALUES (8, 3, 'Menu Pengguna', 'admin.php?module=menu', 'modul', 0, 'menu', NULL, '1', '1', 8, '', '');
INSERT INTO `menu` VALUES (9, 3, 'Akses Menu', 'admin.php?module=akses_menu', 'modul', 0, 'akses_menu', NULL, '1', '1', 9, '', '');
INSERT INTO `menu` VALUES (10, 3, 'Berita', 'admin.php?module=adminnews', 'modul', 0, 'adminnews', NULL, '1', '1', 10, '', '');
INSERT INTO `menu` VALUES (11, 3, 'Pautan', 'admin.php?module=adminpautan', 'modul', 0, 'adminpautan', NULL, '1', '1', 11, '', '');
INSERT INTO `menu` VALUES (12, 3, 'Pengumuman', 'admin.php?module=pengumuman', 'modul', 0, 'pengumuman', NULL, '1', '1', 12, '', '');
INSERT INTO `menu` VALUES (13, 3, 'Kategori', 'admin.php?module=adminkategori', 'modul', 0, 'adminkategori', NULL, '1', '1', 13, '', '');
INSERT INTO `menu` VALUES (14, 3, 'Halaman', 'admin.php?module=adminhalaman', 'modul', 0, 'adminhalaman', NULL, '1', '1', 14, '', '');
INSERT INTO `menu` VALUES (15, 3, 'Pengurusan Fail', 'admin.php?module=filemanager', 'modul', 0, 'filemanager', '_top', '1', '1', 15, '', '');
INSERT INTO `menu` VALUES (16, 3, 'Muka Depan', 'admin.php?module=adminpanel', 'modul', 0, 'adminpanel', NULL, '1', '1', 1, '', '');
INSERT INTO `menu` VALUES (17, 3, 'Menu Admin', 'admin.php?module=menu_admin', 'modul', 0, 'akses_blok', NULL, '1', '1', 7, '', '');
INSERT INTO `menu` VALUES (20, 3, 'Aktiviti EMiS', 'admin.php?module=adminevent', 'modul', 0, 'adminevent', '_top', '1', '1', 17, '', '');
INSERT INTO `menu` VALUES (19, 3, 'Maklumat Am', 'admin.php?module=maklumat_am', 'modul', 0, 'maklumat_am', '_top', '1', '1', 16, '', '');
INSERT INTO `menu` VALUES (32, 3, 'Mesej', 'admin.php?module=adminmesej', 'modul', 0, 'adminmesej', '_top', '1', '1', 18, '', '');
INSERT INTO `menu` VALUES (92, 0, 'SELENGGARA', '', 'menu', 0, '', '_top', '1', '0', 7, '', '');
INSERT INTO `menu` VALUES (34, 3, 'Akses Modul', 'admin.php?module=akses_modul', 'modul', 0, 'akses_modul', '_top', '1', '1', 6, '', '');
INSERT INTO `menu` VALUES (35, 3, 'Perangkaan', 'admin.php?module=adminperangkaan', 'modul', 0, 'adminperangkaan', '_top', '1', '1', 21, '', '');
INSERT INTO `menu` VALUES (36, 3, 'Mesej 2', 'admin.php?module=adminmesej2', 'modul', 0, 'adminmesej2', '_top', '1', '1', 19, '', '');
INSERT INTO `menu` VALUES (37, 3, 'Statistik', 'admin.php?module=adminstatistik', 'modul', 0, 'adminstatistik', '_top', '1', '1', 22, '', '');
INSERT INTO `menu` VALUES (38, 3, 'Mesej 3', 'admin.php?module=adminmesej3', 'modul', 0, 'adminmesej3', '_top', '1', '1', 20, '', '');
INSERT INTO `menu` VALUES (95, 92, 'Muat Naik Borang', 'mainpage.php?module=MuatNaik', 'modul', 0, 'MuatNaik', '_top', '1', '0', 2, 'form.gif', '');
INSERT INTO `menu` VALUES (89, 0, 'HPS', '', 'menu', 0, '', '_top', '1', '0', 3, 'lecture.gif', '');
INSERT INTO `menu` VALUES (90, 89, 'Permohonan Kursus', 'mainpage.php?module=LuluskanPermohonan', 'modul', 0, 'LamanUtama', '_top', '1', '0', 1, 'soprt073.png', '');
INSERT INTO `menu` VALUES (39, 0, 'TAWARAN BARU PGB', '', 'menu', 0, '', '_top', '1', '0', 1, '', '');
INSERT INTO `menu` VALUES (40, 39, 'SKOR SKPM', 'mainpage.php?module=SKPM', 'modul', 0, 'SKPM', '_top', '1', '0', 1, 'AllDay.ru_10.png', '');
INSERT INTO `menu` VALUES (100, 98, 'Borang Penapisan Murid', 'mainpage.php?module=LINUS', 'modul', 0, 'LamanUtama', '_top', '1', '0', 1, 'F045.png', '');
INSERT INTO `menu` VALUES (98, 0, 'LINUS', '', 'menu', 0, '', '_top', '1', '0', 2, 'lecture.gif', 'FDSF');
INSERT INTO `menu` VALUES (104, 0, 'BANTUAN', '', 'menu', 0, '', '_top', '1', '0', 5, '', '');
INSERT INTO `menu` VALUES (105, 104, 'Soalan Lazim', 'mainpage.php?module=LamanUtama', 'modul', 0, 'LamanUtama', '_top', '1', '0', 3, 'info.gif', '');
INSERT INTO `menu` VALUES (106, 104, 'Panduan Pengguna', 'mainpage.php?module=LamanUtama', 'modul', 0, 'LamanUtama', '_top', '1', '0', 1, 'profil2.gif', '');
INSERT INTO `menu` VALUES (112, 92, 'Kemaskini Pengumuman', 'mainpage.php?module=EditPengumuman', 'modul', 0, 'EditPengumuman', '_top', '1', '0', 3, 'wireless2.gif', '');
INSERT INTO `menu` VALUES (115, 104, 'Muat Turun Borang', 'mainpage.php?module=MohonKursus&task=muat_turun', 'modul', 0, 'MohonKursus', '_top', '1', '0', 2, 'download.jpg', '');
INSERT INTO `menu` VALUES (116, 92, 'Akaun Pengguna', 'mainpage.php?module=PenggunaSistem', 'modul', 0, 'PenggunaSistem', '_top', '1', '0', 4, 'access.gif', '');
INSERT INTO `menu` VALUES (119, 0, 'LAPORAN', '', 'menu', 0, '', '_top', '1', '0', 6, '', '');
INSERT INTO `menu` VALUES (120, 119, 'Laporan Keseluruhan SKPM', 'mainpage.php?module=Laporan&task=laporan_skpm', 'modul', 0, 'LamanUtama', '_top', '1', '0', 1, 'cv.gif', '');
INSERT INTO `menu` VALUES (128, 92, 'Edit Pengenalan', 'mainpage.php?module=EditPengenalan', 'modul', 0, 'EditPengenalan', '_top', '1', '0', 5, 'cv3.gif', '');
INSERT INTO `menu` VALUES (132, 0, 'PRA-SEKOLAH', '', 'menu', 0, '', '_top', '1', '0', 4, 'lecture.gif', '');
INSERT INTO `menu` VALUES (133, 132, 'Senarai Pra-sekolah', 'mainpage.php?module=LamanUtama', 'modul', 0, 'LamanUtama', '_top', '1', '0', 1, 'soprt089.png', '');
INSERT INTO `menu` VALUES (134, 92, 'Senarai Sekolah', 'mainpage.php?module=Selenggara&task=list_sek', 'modul', 0, 'Selenggara', '_top', '1', '0', 1, 'lecture.gif', '');
INSERT INTO `menu` VALUES (135, 39, 'Cetak Perakuan', 'laporan.php?module=SKPM&laporan=cetak_perjanjian&displayframework=0', 'modul', 0, 'SKPM', '_top', '1', '0', 2, 'P002.png', '');
INSERT INTO `menu` VALUES (136, 98, 'Laporan', 'mainpage.php?module=LamanUtama', 'modul', 0, 'LamanUtama', '_top', '1', '0', 2, 'AllDay.ru_64.png', '');
INSERT INTO `menu` VALUES (137, 89, 'Laporan', 'mainpage.php?module=LamanUtama', 'modul', 0, 'LamanUtama', '_top', '1', '0', 2, 'AllDay.ru_64.png', '');
INSERT INTO `menu` VALUES (138, 132, 'Laporan', 'mainpage.php?module=LamanUtama', 'modul', 0, 'LamanUtama', '_top', '1', '0', 2, 'AllDay.ru_64.png', '');
INSERT INTO `menu` VALUES (139, 39, 'Kalkulator', 'mainpage.php?module=SKPM&task=kalkulator', 'modul', 0, 'LamanUtama', '_top', '1', '0', 3, 'P003.png', '');
INSERT INTO `menu` VALUES (140, 39, 'Pemantauan SKPM', 'mainpage.php?module=SKPM&task=list_sek', 'modul', 0, 'SKPM', '_top', '1', '0', 4, 'AllDay.ru_8.png', '');
INSERT INTO `menu` VALUES (141, 92, 'Kira Ranking Sekolah', 'mainpage.php?module=Ranking', 'modul', 0, 'Ranking', '_top', '1', '0', 6, '', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `menu_access`
-- 

CREATE TABLE `menu_access` (
  `role` int(11) NOT NULL default '0',
  `menu_id` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `menu_access`
-- 

INSERT INTO `menu_access` VALUES (2, 39);
INSERT INTO `menu_access` VALUES (2, 40);
INSERT INTO `menu_access` VALUES (5, 39);
INSERT INTO `menu_access` VALUES (4, 39);
INSERT INTO `menu_access` VALUES (10, 39);
INSERT INTO `menu_access` VALUES (7, 40);
INSERT INTO `menu_access` VALUES (7, 39);
INSERT INTO `menu_access` VALUES (10, 92);
INSERT INTO `menu_access` VALUES (10, 140);
INSERT INTO `menu_access` VALUES (7, 112);
INSERT INTO `menu_access` VALUES (7, 92);
INSERT INTO `menu_access` VALUES (7, 128);
INSERT INTO `menu_access` VALUES (7, 100);
INSERT INTO `menu_access` VALUES (7, 98);
INSERT INTO `menu_access` VALUES (5, 40);
INSERT INTO `menu_access` VALUES (7, 105);
INSERT INTO `menu_access` VALUES (7, 104);
INSERT INTO `menu_access` VALUES (7, 106);
INSERT INTO `menu_access` VALUES (7, 115);
INSERT INTO `menu_access` VALUES (2, 90);
INSERT INTO `menu_access` VALUES (2, 89);
INSERT INTO `menu_access` VALUES (2, 100);
INSERT INTO `menu_access` VALUES (2, 98);
INSERT INTO `menu_access` VALUES (10, 95);
INSERT INTO `menu_access` VALUES (2, 133);
INSERT INTO `menu_access` VALUES (2, 132);
INSERT INTO `menu_access` VALUES (10, 112);
INSERT INTO `menu_access` VALUES (10, 116);
INSERT INTO `menu_access` VALUES (10, 128);
INSERT INTO `menu_access` VALUES (9, 39);
INSERT INTO `menu_access` VALUES (9, 140);
INSERT INTO `menu_access` VALUES (9, 92);
INSERT INTO `menu_access` VALUES (9, 95);
INSERT INTO `menu_access` VALUES (9, 112);
INSERT INTO `menu_access` VALUES (9, 116);
INSERT INTO `menu_access` VALUES (9, 128);
INSERT INTO `menu_access` VALUES (10, 134);
INSERT INTO `menu_access` VALUES (4, 140);
INSERT INTO `menu_access` VALUES (3, 39);
INSERT INTO `menu_access` VALUES (3, 140);
INSERT INTO `menu_access` VALUES (5, 135);
INSERT INTO `menu_access` VALUES (5, 139);
INSERT INTO `menu_access` VALUES (10, 141);

-- --------------------------------------------------------

-- 
-- Table structure for table `message`
-- 

CREATE TABLE `message` (
  `id` int(11) NOT NULL default '0',
  `author` varchar(20) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `createddate` datetime NOT NULL default '0000-00-00 00:00:00',
  `content` text NOT NULL,
  `active` char(1) NOT NULL default '',
  `image` varchar(50) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `message`
-- 

INSERT INTO `message` VALUES (1, '', 'PORTAL NKRA KPM', '2006-07-01 01:08:59', '<div align="center"><font face="Arial"><u><strong><font size="3">MODUL YANG TERDAPAT DALAM PORTAL NKRA KPM.</font></strong></u></font><br />\r\n<div align="left"><br />\r\n<ol>\r\n    <li><font size="3">BAIAH PENGETUA</font></li>\r\n    <li><font size="3">LINUS</font></li>\r\n    <li><font size="3">SEKOLAH BERPRESTASI TINGGI</font></li>\r\n    <li><font size="3">TADIKA<br />\r\n    </font></li>\r\n</ol>\r\n</div>\r\n</div>', '1', 'about.gif');

-- --------------------------------------------------------

-- 
-- Table structure for table `module_access`
-- 

CREATE TABLE `module_access` (
  `role` int(11) NOT NULL default '0',
  `module_id` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `module_access`
-- 

INSERT INTO `module_access` VALUES (2, 2);
INSERT INTO `module_access` VALUES (2, 87);
INSERT INTO `module_access` VALUES (5, 2);
INSERT INTO `module_access` VALUES (5, 87);
INSERT INTO `module_access` VALUES (4, 2);
INSERT INTO `module_access` VALUES (4, 87);
INSERT INTO `module_access` VALUES (3, 2);
INSERT INTO `module_access` VALUES (3, 87);
INSERT INTO `module_access` VALUES (9, 2);
INSERT INTO `module_access` VALUES (9, 87);
INSERT INTO `module_access` VALUES (10, 2);
INSERT INTO `module_access` VALUES (10, 87);
INSERT INTO `module_access` VALUES (10, 88);
INSERT INTO `module_access` VALUES (10, 89);
INSERT INTO `module_access` VALUES (10, 90);
INSERT INTO `module_access` VALUES (10, 91);

-- --------------------------------------------------------

-- 
-- Table structure for table `modules`
-- 

CREATE TABLE `modules` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) NOT NULL default '',
  `displaytitle` char(1) NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `image` varchar(50) NOT NULL default '',
  `public` char(1) NOT NULL default '',
  `registered` char(1) NOT NULL default '0',
  `active` char(1) NOT NULL default '',
  `admin` char(1) NOT NULL default '0',
  `ordering` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=92 ;

-- 
-- Dumping data for table `modules`
-- 

INSERT INTO `modules` VALUES (2, 'Laman Utama', '0', 'LamanUtama', '', '0', '0', '1', '0', 2);
INSERT INTO `modules` VALUES (4, 'Role', '0', 'role', '', '0', '0', '1', '1', 1);
INSERT INTO `modules` VALUES (5, 'Aktiviti', '0', 'adminaktiviti', '', '0', '0', '1', '1', 2);
INSERT INTO `modules` VALUES (6, 'Berita', '0', 'adminnews', '', '0', '0', '1', '1', 3);
INSERT INTO `modules` VALUES (7, 'Muka Depan Admin', '0', 'adminpanel', '', '0', '0', '1', '1', 4);
INSERT INTO `modules` VALUES (8, 'Pautan', '0', 'adminpautan', '', '0', '0', '1', '1', 5);
INSERT INTO `modules` VALUES (9, 'Blok', '0', 'block', '', '0', '0', '1', '1', 6);
INSERT INTO `modules` VALUES (10, 'Akses Blok', '0', 'akses_blok', '', '0', '0', '1', '1', 7);
INSERT INTO `modules` VALUES (11, 'Akses Menu', '0', 'akses_menu', '', '0', '0', '1', '1', 8);
INSERT INTO `modules` VALUES (12, 'Akses Modul', '0', 'akses_modul', '', '0', '0', '1', '1', 9);
INSERT INTO `modules` VALUES (13, 'Menu', '0', 'menu', '', '0', '0', '1', '1', 10);
INSERT INTO `modules` VALUES (14, 'Modul', '0', 'module', '', '0', '0', '1', '1', 11);
INSERT INTO `modules` VALUES (15, 'Pengguna', '0', 'pengguna', '', '0', '0', '1', '1', 12);
INSERT INTO `modules` VALUES (16, 'Kategori Maklumat', '0', 'adminkategori', '', '0', '0', '1', '1', 13);
INSERT INTO `modules` VALUES (18, 'Muat Naik Dokumen', '0', 'filemanager', '', '0', '0', '1', '1', 15);
INSERT INTO `modules` VALUES (19, 'Halaman', '0', 'adminhalaman', '', '0', '0', '1', '1', 14);
INSERT INTO `modules` VALUES (20, 'Maklumat', '0', 'adminmaklumat', '', '0', '0', '1', '1', 16);
INSERT INTO `modules` VALUES (22, 'Mesej', '0', 'adminmesej', '', '0', '0', '1', '1', 17);
INSERT INTO `modules` VALUES (23, 'Menu Admin', '0', 'menu_admin', '', '0', '0', '1', '1', 18);
INSERT INTO `modules` VALUES (24, 'Pengumuman', '0', 'pengumuman', '', '0', '0', '1', '1', 19);
INSERT INTO `modules` VALUES (25, 'Maklumat Am', '0', 'maklumat_am', '', '0', '0', '1', '1', 20);
INSERT INTO `modules` VALUES (29, 'Admin Event', '0', 'adminevent', '', '0', '0', '1', '1', 21);
INSERT INTO `modules` VALUES (33, 'Perangkaan', '0', 'adminperangkaan', '', '0', '0', '1', '1', 22);
INSERT INTO `modules` VALUES (34, 'Mesej 2', '0', 'adminmesej2', '', '0', '0', '1', '1', 23);
INSERT INTO `modules` VALUES (35, 'Statistik', '0', 'adminstatistik', '', '0', '0', '1', '1', 24);
INSERT INTO `modules` VALUES (36, 'Mesej 3', '0', 'adminmesej3', '', '0', '0', '1', '1', 25);
INSERT INTO `modules` VALUES (87, 'SKPM', '0', 'SKPM', '', '0', '0', '1', '0', 3);
INSERT INTO `modules` VALUES (88, 'Pengenalan', '0', 'EditPengenalan', '', '0', '0', '1', '0', 4);
INSERT INTO `modules` VALUES (89, 'Selenggara', '0', 'Selenggara', '', '0', '0', '1', '0', 5);
INSERT INTO `modules` VALUES (90, 'Pengguna Sistem', '0', 'PenggunaSistem', '', '0', '0', '1', '0', 6);
INSERT INTO `modules` VALUES (91, 'Kira Ranking Sekolah', '0', 'Ranking', '', '0', '0', '1', '0', 7);

-- --------------------------------------------------------

-- 
-- Table structure for table `news`
-- 

CREATE TABLE `news` (
  `id` int(11) NOT NULL auto_increment,
  `author` varchar(20) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `content` text NOT NULL,
  `header` text,
  `public` char(1) NOT NULL default '',
  `active` char(1) NOT NULL default '',
  `frontpage` char(1) NOT NULL default '0',
  `counter` bigint(20) NOT NULL default '0',
  `startdate` date NOT NULL default '0000-00-00',
  `enddate` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=97 ;

-- 
-- Dumping data for table `news`
-- 

INSERT INTO `news` VALUES (92, 'admin', 'EMiS Portal', '2007-03-02 10:42:35', '<h1>Pengenalan</h1>\r\n<p>Pengumpulan Maklumat Asas (MAP) iaitu data jenis agregat atau bancian yang merangkumi maklumat profil sekolah, enrolmen, guru dan bukan guru merupakan salah satu tugas penting Bahagian Perancangan dan Penyelidikan Dasar Pendidikan (BPPDP) dalam menyokong fungsi utamanya membuat perancangan makro dan penyelidikan ke atas dasar dan program pendidikan yang dilaksanakan oleh KPM. Bermula pada tahun 1997, penggunaan aplikasi SMPP/EMIS MAP telah membolehkan pengisian data secara elektronik dibuat oleh guru data di peringkat sekolah.</p>\r\n<p>Sejajar dengan perkembangan teknologi komunikasi dan maklumat semasa, aplikasi SMPP/EMIS-MAP yang menggunakan platform MS Access telah dipertingkatkan menjadi sebuah aplikasi yang berdasarkan web iaitu EMIS Online. EMIS atas talian (OnLine) menyediakan data yang terkini, sahih, tepat dan berkualiti kepada pemutus dasar, perancang, penyelidik dan pengguna lain. Ia digunakan untuk mengumpul data asas pendidikan dan sistem ini merupakan satu usaha berterusan BPPDP untuk meningkatkan kualiti data dan memantapkan lagi pengurusan kutipan MAP bagi memenuhi keperluan maklumat di peringkat Kementerian. </p>\r\n<h2>Objektif EMIS On Line</h2>\r\n<p>&nbsp;</p>\r\n<ul>\r\n    <li>Mempertingkatkan keupayaan sistem supaya kerja pengemaskinian, pemprosesan, penganalisaan, pelaporan dan penyebaran maklumat menjadi lebih mudah. </li>\r\n    <li>Meluaskan cakupan maklumat bagi memenuhi dan menepati keperluan lebih ramai pengguna. </li>\r\n    <li>Menjadikan aplikasi lebih fleksibel dan mesra pengguna. </li>\r\n    <li>Menghasilkan maklumat yang lebih berkualiti mempunyai ciri-ciri releven, sahih, tepat dan bertepatan dengan masa yang diperlukan oleh pihak pengguna. </li>\r\n</ul>\r\n<p>Maklumat yang dipaparkan adalah berdasarkan kutipan <strong>data seperti 31 hb Januari 2006.</strong></p>', '<p align="left"><img height="89" hspace="2" width="180" align="left" vspace="10" border="2" alt="" src="/emisportal/doc/fckeditor/Image/emisbanner3_left.gif" /><br />\r\nPengumpulan Maklumat Asas (MAP) iaitu data jenis agregat atau bancian yang merangkumi maklumat profil sekolah, enrolmen, guru dan bukan guru merupakan salah satu tugas penting Bahagian Perancangan dan Penyelidikan Dasar Pendidikan (BPPDP) dalam menyokong fungsi utamanya membuat perancangan makro dan penyelidikan ke atas dasar dan program pendidikan yang dilaksanakan oleh KPM. <br />\r\n</p>\r\n<p>Bermula pada tahun 1997, penggunaan aplikasi SMPP/EMIS MAP telah membolehkan pengisian data secara elektronik dibuat oleh guru data di peringkat sekolah.</p>\r\n<p>Sejajar dengan perkembangan teknologi komunikasi dan maklumat semasa, aplikasi SMPP/EMIS-MAP yang menggunakan platform MS Access telah dipertingkatkan menjadi sebuah aplikasi yang berdasarkan web iaitu EMIS Online. EMIS atas talian (OnLine) menyediakan data yang terkini, sahih, tepat dan berkualiti kepada pemutus dasar, perancang, penyelidik dan pengguna lain. <br />\r\n</p>\r\n<p>Ia digunakan untuk mengumpul data asas pendidikan dan sistem ini merupakan satu usaha berterusan BPPDP untuk meningkatkan kualiti data dan memantapkan lagi pengurusan kutipan MAP bagi memenuhi keperluan maklumat di peringkat Kementerian. </p>', '1', '1', '1', 34, '2007-03-13', '2009-08-01');
INSERT INTO `news` VALUES (96, 'admin', 'fdafds', '2008-04-01 12:59:21', 'fdsaf', 'dsadas', '0', '0', '0', 0, '2008-04-01', '2009-04-01');

-- --------------------------------------------------------

-- 
-- Table structure for table `role`
-- 

CREATE TABLE `role` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `keterangan` varchar(100) default NULL,
  `defaultrole` char(1) NOT NULL default '0',
  `startup_module` varchar(30) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- 
-- Dumping data for table `role`
-- 

INSERT INTO `role` VALUES (1, 'Administrator', NULL, '0', NULL);
INSERT INTO `role` VALUES (2, 'PENGGUNA BIASA', NULL, '1', 'LamanUtama');

-- --------------------------------------------------------

-- 
-- Table structure for table `user`
-- 

CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `login` varchar(20) NOT NULL default '',
  `password` varchar(40) NOT NULL default '',
  `password2` varchar(40) default NULL,
  `role` int(11) NOT NULL default '0',
  `staff_no` varchar(8) NOT NULL default '',
  `nokp` varchar(12) NOT NULL default '',
  `nama` varchar(50) NOT NULL default '',
  `jawatan` varchar(50) default NULL,
  `email` varchar(50) default NULL,
  `telefon` varchar(12) default NULL,
  `handphone` varchar(12) default NULL,
  `faks` varchar(12) default NULL,
  `negeri` char(2) default NULL,
  `kodsek` varchar(7) default NULL,
  `kodppd` varchar(4) default NULL,
  `regdate` datetime default '0000-00-00 00:00:00',
  `lastlogin` datetime default '0000-00-00 00:00:00',
  `currentlogin` datetime default NULL,
  `bahagian` varchar(10) default NULL,
  `unit` varchar(10) default NULL,
  `organisasi` varchar(100) default NULL,
  `alamat1` varchar(60) default NULL,
  `alamat2` varchar(60) default NULL,
  `pekerjaan` varchar(30) default NULL,
  `activatecode` varchar(32) default NULL,
  `active` char(1) default NULL,
  PRIMARY KEY  (`id`,`login`),
  KEY `idx_login` (`login`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=43023 ;

-- 
-- Dumping data for table `user`
-- 

INSERT INTO `user` VALUES (1, 'admin', 'c030bfb8a65f90fdf4b3a499d650b37e', NULL, 1, '', '', 'Admin', NULL, NULL, NULL, NULL, NULL, 'D0', 'D02_00', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2009-05-20 11:44:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `visitor`
-- 

CREATE TABLE `visitor` (
  `total` bigint(20) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `visitor`
-- 

INSERT INTO `visitor` VALUES (1241);

-- --------------------------------------------------------

-- 
-- Table structure for table `weblinks`
-- 

CREATE TABLE `weblinks` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) NOT NULL default '',
  `link` varchar(50) NOT NULL default '',
  `target` varchar(10) NOT NULL default '_blank',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `weblinks`
-- 

