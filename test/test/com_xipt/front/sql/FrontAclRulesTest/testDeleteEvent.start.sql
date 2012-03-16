TRUNCATE TABLE `#__xipt_aclrules`;;
INSERT INTO `#__xipt_aclrules` (`id`, `rulename`, `aclname`, `coreparams`, `aclparams`, `published`) VALUES
(7, 'delete event', 'deletevent', 'core_profiletype=2\ncore_display_message=PHA+WU9VIEFSRSBOT1QgQUxMT1dFRCBUTyBBQ0NFU1MgVEhJUyBSRVNPVVJDRTwvcD4=\nforce_to_redirect=0\ncore_redirect_url=index.php?option=com_community\n\n', '\n', 1);;


TRUNCATE TABLE `#__community_users`;;
INSERT INTO `#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`) VALUES
(62, '', 12, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(83, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(84, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(85, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(86, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_2.jpg', 'images/profiletype/avatar_2_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(87, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(79, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(80, '', 2, '0000-00-00 00:00:00', 'images/profiletype/avatar_2.jpg', 'images/profiletype/avatar_2_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(81, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=20\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0),
(82, '', 2, '0000-00-00 00:00:00', 'components/com_community/assets/default.jpg', 'components/com_community/assets/default_thumb.jpg', 0, 'notifyEmailSystem=1\nprivacyProfileView=10\nprivacyPhotoView=0\nprivacyFriendsView=0\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\nnotifyWallComment=0\n\n', 0, 0);;


TRUNCATE TABLE `#__community_events`;;
INSERT INTO `#__community_events` (`id`, `catid`, `contentid`, `type`, `title`, `location`, `description`, `creator`, `startdate`, `enddate`, `permission`, `avatar`, `thumb`, `invitedcount`, `confirmedcount`, `declinedcount`, `maybecount`, `wallcount`, `ticket`, `allowinvite`, `created`, `hits`, `published`, `latitude`, `longitude`) VALUES
(1, 2, 0, 'profile', 'myevent1', 'india', 'myevent', 82, '2014-06-24 21:00:00', '2014-06-24 22:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, '2014-06-24 04:32:11', 3, 1, 20.5937, 78.9629),
(2, 2, 0, 'profile', 'myevent2', 'india', 'myevent', 82, '2014-06-24 22:00:00', '2014-06-24 23:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, '2014-06-24 04:32:18', 1, 1, 20.5937, 78.9629),
(3, 2, 0, 'profile', 'My event12', 'Bhilwara', 'cgd', 83, '2014-06-30 04:00:00', '2014-07-02 04:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, '2014-06-24 04:40:27', 3, 1, 25.3463, 74.6364),
(4, 2, 0, 'profile', 'My event13', 'Bhilwara', 'fft', 84, '2014-06-29 04:00:00', '2014-06-30 04:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, '2014-06-24 04:42:08', 3, 1, 25.3463, 74.6364),
(12, 2, 0, 'profile', 'delete pt2', 'India', 'delete pt2', 83, '2014-06-29 22:00:00', '2014-06-30 08:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, '2014-06-24 08:58:50', 1, 1, 20.5937, 78.9629),
(11, 2, 0, 'profile', 'delete pt1', 'India', 'delete pt1', 82, '2014-06-24 20:00:00', '2014-06-24 21:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, '2014-06-24 08:57:04', 0, 1, 20.5937, 78.9629);;


DROP TABLE IF EXISTS `au_#__community_events` ;;
CREATE TABLE IF NOT EXISTS `au_#__community_events` SELECT * FROM `#__community_events`;;
TRUNCATE TABLE `au_#__community_events`;;
INSERT INTO `au_#__community_events` (`id`, `catid`, `contentid`, `type`, `title`, `location`, `description`, `creator`, `startdate`, `enddate`, `permission`, `avatar`, `thumb`, `invitedcount`, `confirmedcount`, `declinedcount`, `maybecount`, `wallcount`, `ticket`, `allowinvite`, `created`, `hits`, `published`, `latitude`, `longitude`) VALUES
(1, 2, 0, 'profile', 'myevent1', 'india', 'myevent', 82, '2010-06-24 21:00:00', '2010-06-24 22:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, '2010-06-24 04:32:11', 3, 1, 20.5937, 78.9629),
(2, 2, 0, 'profile', 'myevent2', 'india', 'myevent', 82, '2010-06-24 22:00:00', '2010-06-24 23:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, '2010-06-24 04:32:18', 1, 1, 20.5937, 78.9629),
(3, 2, 0, 'profile', 'My event12', 'Bhilwara', 'cgd', 83, '2010-06-30 04:00:00', '2010-07-02 04:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, '2010-06-24 04:40:27', 3, 1, 25.3463, 74.6364),
(4, 2, 0, 'profile', 'My event13', 'Bhilwara', 'fft', 84, '2010-06-29 04:00:00', '2010-06-30 04:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, '2010-06-24 04:42:08', 3, 1, 25.3463, 74.6364),
(12, 2, 0, 'profile', 'delete pt2', 'India', 'delete pt2', 83, '2010-06-29 22:00:00', '2010-06-30 08:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, '2010-06-24 08:58:50', 1, 1, 20.5937, 78.9629),
(11, 2, 0, 'profile', 'delete pt1', 'India', 'delete pt1', 82, '2014-06-24 20:00:00', '2014-06-24 21:00:00', 0, NULL, NULL, 0, 1, 0, 0, 0, 0, 0, '2014-06-24 08:57:04', 0, 1, 20.5937, 78.9629);;
