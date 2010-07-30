

TRUNCATE TABLE `#__xipt_applications` ;;

INSERT INTO `#__xipt_applications` (`id`, `applicationid`, `profiletype`) VALUES
(1, 42, 4),
(2, 42, 3),
(3, 42, 1),
(4, 46, 1),
(5, 43, 3),
(6, 45, 2),
(7, 44, 2),
(8, 47, 2),
(9, 47, 3),
(10, 47, 4),
(11, 48, 1),
(12, 48, 3),
(13, 48, 4);;

TRUNCATE TABLE `#__plugins` ;;

INSERT INTO `#__plugins` (`id`, `name`, `element`, `folder`, `access`, `ordering`, `published`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`) VALUES
(1, 'Authentication - Joomla', 'joomla', 'authentication', 0, 1, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(2, 'Authentication - LDAP', 'ldap', 'authentication', 0, 2, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(3, 'Authentication - GMail', 'gmail', 'authentication', 0, 4, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(4, 'Authentication - OpenID', 'openid', 'authentication', 0, 3, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(5, 'User - Joomla!', 'joomla', 'user', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(6, 'Search - Content', 'content', 'search', 0, 1, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(7, 'Search - Contacts', 'contacts', 'search', 0, 3, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(8, 'Search - Categories', 'categories', 'search', 0, 4, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(9, 'Search - Sections', 'sections', 'search', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(10, 'Search - Newsfeeds', 'newsfeeds', 'search', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(11, 'Search - Weblinks', 'weblinks', 'search', 0, 2, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(12, 'Content - Pagebreak', 'pagebreak', 'content', 0, 10000, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(13, 'Content - Rating', 'vote', 'content', 0, 4, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(14, 'Content - Email Cloaking', 'emailcloak', 'content', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(15, 'Content - Code Hightlighter (GeSHi)', 'geshi', 'content', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(16, 'Content - Load Module', 'loadmodule', 'content', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(17, 'Content - Page Navigation', 'pagenavigation', 'content', 0, 2, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(18, 'Editor - No Editor', 'none', 'editors', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(19, 'Editor - TinyMCE', 'tinymce', 'editors', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(20, 'Editor - XStandard Lite 2.0', 'xstandard', 'editors', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(21, 'Editor Button - Image', 'image', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(22, 'Editor Button - Pagebreak', 'pagebreak', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(23, 'Editor Button - Readmore', 'readmore', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(24, 'XML-RPC - Joomla', 'joomla', 'xmlrpc', 0, 7, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(25, 'XML-RPC - Blogger API', 'blogger', 'xmlrpc', 0, 7, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(27, 'System - SEF', 'sef', 'system', 0, 1, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(28, 'System - Debug', 'debug', 'system', 0, 2, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(29, 'System - Legacy', 'legacy', 'system', 0, 3, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(30, 'System - Cache', 'cache', 'system', 0, 4, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(31, 'System - Log', 'log', 'system', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(32, 'System - Remember Me', 'remember', 'system', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(33, 'System - Backlink', 'backlink', 'system', 0, 7, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(34, 'Azrul System Mambot', 'azrul.system', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(35, 'System - Zend Lib', 'zend', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(37, 'Authorization - AEC Access', 'aecaccess', 'user', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(38, 'System - AEC ErrorHandler', 'aecerrorhandler', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(39, 'System - AEC Routing', 'aecrouting', 'system', 0, -1000, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(40, 'User - AEC User', 'aecuser', 'user', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(41, 'User - Jomsocial User', 'jomsocialuser', 'user', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(42, 'Walls', 'walls', 'community', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(43, 'Feeds', 'feeds', 'community', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(44, 'Groups', 'groups', 'community', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(45, 'Latest Photos', 'latestphoto', 'community', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(46, 'My Articles', 'myarticles', 'community', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(47, 'JomSocial User List', 'testing001', 'community', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(48, 'JomSocial User List', 'testing002', 'community', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(49, 'JSPT System Plugin', 'xipt_system', 'system', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(50, 'JSPT Community Plugin', 'xipt_community', 'community', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', '');;


