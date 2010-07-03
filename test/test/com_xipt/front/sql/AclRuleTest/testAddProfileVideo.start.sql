TRUNCATE TABLE `#__xipt_aclrules`;
INSERT INTO `#__xipt_aclrules` (`id`, `rulename`, `aclname`, `coreparams`, `aclparams`, `published`) VALUES
(8, 'aaa', 'addprofilevideo', 'core_profiletype=1\ncore_display_message=YOU ARE NOT ALLOWED TO ACCESS THIS RESOURCE\ncore_redirect_url=index.php?option=com_community\n\n', '\n', 1);


TRUNCATE TABLE `#__community_videos`;
INSERT INTO `#__community_videos` (`id`, `title`, `type`, `video_id`, `description`, `creator`, `creator_type`, `created`, `permissions`, `category_id`, `hits`, `published`, `featured`, `duration`, `status`, `thumb`, `path`, `groupid`, `filesize`, `storage`) VALUES
(1, 'Best Free Website Hosting: With FTP, PHP, and MySQL!', 'youtube', 'whPYvGuqviI', 'Free website hosting.\r\nhttp://www.podserver.info/\r\nHost your own message board forum, blog, CMS, image gallery, Commerce, wiki, and more. Unlike other free hosting plans, this includes full access to FTP, PHP, MySQL, Apache and Control Panel.\r\n\r\nFree web hosting services:\r\n• 300 MB disk space\r\n• 10 GB monthly transfer\r\n• 7 MySQL databases\r\n• Free 24/7 tech support and instant activation\r\n• FTP, file manager, MySQL, Ion Cube, Zend Optimizer, and Apache\r\n• PHP with ''safe_mode'' off and GD enabled\r\n• Password protect directories\r\n• Control panel and Fantastico® like automatic script installer\r\n• 6 Addon domains, 6 parked domains, and 6 sub-domains\r\n• Webmail, sendmail and POP email\r\n• Quad Xeon grid servers with multiple fiber optic connections\r\n\r\nMusic: Kevin MacLeod', 82, 'user', '2010-06-30 12:31:19', '0', 1, 1, 1, 0, 32, 'ready', 'images/videos/82/thumbs/J0i4ObyonoC.jpg', 'http://www.youtube.com/watch?v=whPYvGuqviI&feature=related', 0, 0, 'file'),
(2, 'Totally Free Hosting | Top 6 Best Hosting | Unlimited Domain', 'youtube', 'LUoR2CCD9h8', 'Host02.com, 000WebHost.com, 250 MB of Disk Space, 100 GB Bandwidth. Host your own domain (http://www.yourdomain.com) or Free YourDomainName.890m.com. cPanel Powered Hosting (you will love it). Over 500 website templates ready to download. Free POP3 Email Box with Webmail access. FTP and Web based File Manager. PHP, MySQL, Perl, CGI, Ruby. Absolutely no advertising, Unrestricted PHP5 support, Instant Setup.  Automated Scripts Installer (20 Popular Scripts). FTP Access and Web Based File Manager, 5 MySQL Databases with Full PHP Support, Zend & Curl Enabled, IMMEDIATE Activation.', 82, 'user', '2010-06-30 12:58:40', '0', 1, 5, 1, 0, 62, 'ready', 'images/videos/82/thumbs/BwX9cbcxxr1.jpg', 'http://www.youtube.com/watch?v=LUoR2CCD9h8&feature=related', 0, 0, 'file'),
(3, 'Top 10 Best Web Hosting Reviews - SCAMS EXPOSED', 'youtube', 'V8PidNJLrek', 'Are "HOST REVIEW" sites honest? Are they unbiased, impartial, and factual... or are they just after your money? How does a hosting company get on the "top 10" list? \r\n\r\nAmazingly most hosting reviews websites have one thing in common: They are getting paid by hosting companies for reviews (either directly in the form of advertising or indirectly via affiliate commissions) -- making their reviews extremely biased, one-sided, and highly questionable in terms of accuracy. They all promote the same group of companies. \r\n\r\nThe reason that the same hosting companies always make it to the "top" of the hosting comparison charts is because those companies, one way or another, pay to be listed there. These hosts include Host Monster, Blue Host, Lunar Pages, IX Webhosting, InMotionHosting, StartLogic, Host Pappa, Pow Web, etc. \r\n\r\nIt''s a well-known fact web hosting companies running their affiliate programs through Commission Junction offer among the highest affiliate commissions in the hosting industry. Thus "clever" PPC (pay per click) affiliate marketers decided: why not create websites with "top web hosting companies" lists and list these companies as "top"? \r\n\r\nHosting company reviews seldom base their "rating" on their quality of service (although many claim to). Instead, most of them rate a webhost on the *size* of the affiliate commission. Those web hosts offering the highest commissions usually get the top spots -- because those hosting companies pay the most money.\r\n\r\nSo the next time you''re looking for the best web hosting company (and you undoubtedly come across a "reviews" site), STOP AND THINK: What''s their true objective? Are they providing you with impartial, unprejudiced facts? Or are they simply selling you a bill of goods, deceptively packaged in a "Top-10" list bought and paid for in the Twilight Zone? Visit HOSTING-REVIEWS-EXPOSED.COM for more information.', 83, 'user', '2010-07-01 13:15:18', '0', 1, 0, 1, 0, 211, 'ready', 'images/videos/83/thumbs/wfrYZ4PD1D2.jpg', 'http://www.youtube.com/watch?v=V8PidNJLrek&feature=related', 0, 0, 'file'),
(4, 'The Price of Free Web Hosting', 'youtube', '9oTWvACXHY8', 'Why I am against using a free web host to start a serious, long-term Web business.\r\nGet $3 hosting at http://www.websitepalace.com', 84, 'user', '2010-07-01 13:16:53', '0', 1, 0, 1, 0, 680, 'ready', 'images/videos/84/thumbs/vq6e5tw0Tw9.jpg', 'http://www.youtube.com/watch?v=9oTWvACXHY8&feature=related', 0, 0, 'file');

TRUNCATE TABLE `#__core_acl_aro`;
INSERT INTO `#__core_acl_aro` (`id`, `section_value`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', '62', 0, 'Administrator', 0),
(31, 'users', '83', 0, 'regtest1789672', 0),
(28, 'users', '80', 0, 'regtest6208627', 0),
(32, 'users', '84', 0, 'regtest6461827', 0),
(35, 'users', '87', 0, 'regtest1674526', 0),
(33, 'users', '85', 0, 'regtest3843261', 0),
(34, 'users', '86', 0, 'regtest1504555', 0),
(29, 'users', '81', 0, 'regtest8635954', 0),
(27, 'users', '79', 0, 'regtest7046025', 0),
(30, 'users', '82', 0, 'regtest8774090', 0);

TRUNCATE TABLE`#__core_acl_groups_aro_map`;
INSERT INTO `#__core_acl_groups_aro_map` (`group_id`, `section_value`, `aro_id`) VALUES
(18, '', 27),
(18, '', 30),
(18, '', 33),
(20, '', 28),
(20, '', 31),
(20, '', 34),
(21, '', 29),
(21, '', 32),
(21, '', 35),
(25, '', 10);

