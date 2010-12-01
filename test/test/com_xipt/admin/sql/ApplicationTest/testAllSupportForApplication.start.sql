TRUNCATE TABLE `#__xipt_profiletypes`;;
INSERT INTO `#__xipt_profiletypes`  (`id`,`name`)  VALUES (1,'PROFILETYPE-1');;
INSERT INTO `#__xipt_profiletypes`  (`id`,`name`)  VALUES (2,'PROFILETYPE-2');;
INSERT INTO `#__xipt_profiletypes`  (`id`,`name`)  VALUES (3,'PROFILETYPE-3');;
INSERT INTO `#__xipt_profiletypes`  (`id`,`name`)  VALUES (4,'PROFILETYPE-4');;
INSERT INTO `#__xipt_profiletypes`  (`id`,`name`)  VALUES (5,'PROFILETYPE-5');;



TRUNCATE TABLE `#__plugins`;;

INSERT INTO `#__plugins` (`id`, `name`, `element`, `folder`, `access`, `ordering`, `published`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`) VALUES
(1, 'Authentication - Joomla', 'joomla', 'authentication', 0, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(2, 'Authentication - LDAP', 'ldap', 'authentication', 0, 2, 0, 1, 0, 0, '0000-00-00 00:00:00', 'host=\nport=389\nuse_ldapV3=0\nnegotiate_tls=0\nno_referrals=0\nauth_method=bind\nbase_dn=\nsearch_string=\nusers_dn=\nusername=\npassword=\nldap_fullname=fullName\nldap_email=mail\nldap_uid=uid\n\n'),
(3, 'Authentication - GMail', 'gmail', 'authentication', 0, 4, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(4, 'Authentication - OpenID', 'openid', 'authentication', 0, 3, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(5, 'User - Joomla!', 'joomla', 'user', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'autoregister=1\n\n'),
(6, 'Search - Content', 'content', 'search', 0, 1, 0, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\nsearch_content=1\nsearch_uncategorised=1\nsearch_archived=1\n\n'),
(7, 'Search - Contacts', 'contacts', 'search', 0, 3, 0, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(8, 'Search - Categories', 'categories', 'search', 0, 4, 0, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(9, 'Search - Sections', 'sections', 'search', 0, 5, 0, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(10, 'Search - Newsfeeds', 'newsfeeds', 'search', 0, 6, 0, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(11, 'Search - Weblinks', 'weblinks', 'search', 0, 2, 0, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(12, 'Content - Pagebreak', 'pagebreak', 'content', 0, 10000, 1, 1, 0, 0, '0000-00-00 00:00:00', 'enabled=1\ntitle=1\nmultipage_toc=1\nshowall=1\n\n'),
(13, 'Content - Rating', 'vote', 'content', 0, 4, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(14, 'Content - Email Cloaking', 'emailcloak', 'content', 0, 5, 0, 0, 0, 0, '0000-00-00 00:00:00', 'mode=1\n\n'),
(15, 'Content - Code Hightlighter (GeSHi)', 'geshi', 'content', 0, 5, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(16, 'Content - Load Module', 'loadmodule', 'content', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', 'enabled=1\nstyle=0\n\n'),
(17, 'Content - Page Navigation', 'pagenavigation', 'content', 0, 2, 1, 1, 0, 0, '0000-00-00 00:00:00', 'position=1\n\n'),
(18, 'Editor - No Editor', 'none', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(19, 'Editor - TinyMCE', 'tinymce', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', 'theme=advanced\ncleanup=1\ncleanup_startup=0\nautosave=0\ncompressed=0\nrelative_urls=1\ntext_direction=ltr\nlang_mode=0\nlang_code=en\ninvalid_elements=applet\ncontent_css=1\ncontent_css_custom=\nnewlines=0\ntoolbar=top\nhr=1\nsmilies=1\ntable=1\nstyle=1\nlayer=1\nxhtmlxtras=0\ntemplate=0\ndirectionality=1\nfullscreen=1\nhtml_height=550\nhtml_width=750\npreview=1\ninsertdate=1\nformat_date=%Y-%m-%d\ninserttime=1\nformat_time=%H:%M:%S\n\n'),
(20, 'Editor - XStandard Lite 2.0', 'xstandard', 'editors', 0, 0, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(21, 'Editor Button - Image', 'image', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(22, 'Editor Button - Pagebreak', 'pagebreak', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(23, 'Editor Button - Readmore', 'readmore', 'editors-xtd', 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(24, 'XML-RPC - Joomla', 'joomla', 'xmlrpc', 0, 7, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(25, 'XML-RPC - Blogger API', 'blogger', 'xmlrpc', 0, 7, 0, 1, 0, 0, '0000-00-00 00:00:00', 'catid=1\nsectionid=0\n\n'),
(27, 'System - SEF', 'sef', 'system', 0, 1, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(28, 'System - Debug', 'debug', 'system', 0, 2, 1, 0, 0, 0, '0000-00-00 00:00:00', 'queries=1\nmemory=1\nlangauge=1\n\n'),
(29, 'System - Legacy', 'legacy', 'system', 0, 3, 0, 1, 0, 0, '0000-00-00 00:00:00', 'route=0\n\n'),
(30, 'System - Cache', 'cache', 'system', 0, 4, 0, 1, 0, 0, '0000-00-00 00:00:00', 'browsercache=0\ncachetime=15\n\n'),
(31, 'System - Log', 'log', 'system', 0, 5, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(32, 'System - Remember Me', 'remember', 'system', 0, 6, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(33, 'System - Backlink', 'backlink', 'system', 0, 7, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(34, 'Azrul System Mambot', 'azrul.system', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(43, 'User - Jomsocial User', 'jomsocialuser', 'user', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(44, 'Walls', 'walls', 'community', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'cache=1'),
(37, 'Authorization - AEC Access', 'aecaccess', 'user', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(38, 'System - AEC ErrorHandler', 'aecerrorhandler', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(39, 'System - AEC Routing', 'aecrouting', 'system', 0, -1000, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(40, 'User - AEC User', 'aecuser', 'user', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(26, 'System - Zend Lib', 'zend', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(45, 'Feeds', 'feeds', 'community', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'position=content|sidebar-top|sidebar-bottom\n'),
(46, 'Groups', 'groups', 'community', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'cache=1\n'),
(47, 'Latest Photos', 'latestphoto', 'community', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'count=10\ncache=1\n'),
(48, 'My Articles', 'myarticles', 'community', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'limit=50\ncount=10\ncache=1\ndisplay_expired=1\n'),
(49, 'JomSocial User List', 'testing001', 'community', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'coreapp=1\n'),
(50, 'JomSocial User List', 'testing002', 'community', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(51, 'JSPT Community Plugin', 'xipt_community', 'community', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(52, 'JSPT System Plugin', 'xipt_system', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');;

TRUNCATE TABLE `#__xipt_applications`;;
DROP TABLE IF EXISTS `au_#__xipt_applications`;;
CREATE TABLE `au_#__xipt_applications` SELECT * FROM `#__xipt_applications`;;

INSERT INTO `au_#__xipt_applications` (`applicationid`, `profiletype`) VALUES
(44, 2),
(44, 3),
(44, 4),
(44, 5),
(45, 1),
(45, 3),
(45, 4),
(45, 5),
(46, 3),
(46, 4),
(46, 5),
(49, 2),
(49, 3),
(49, 4),
(49, 5),
(50, 1),
(50, 3),
(50, 4),
(50, 5);;
