TRUNCATE TABLE `#__payplans_app`;;

INSERT INTO `#__payplans_app` (`app_id`, `title`, `type`, `description`, `core_params`, `app_params`, `ordering`, `published`) VALUES
(1, 'Admin Payment', 'adminpay', 'Through this application Admin can create payment from back-end. There is no either way to create payment from back-end. This application can not be created, changed and deleted. And can not be used for fron-end payment.', 'applyAll=1\n\n', '\n', 1, 1),
(2, 'PROFILETYPE-2', 'xiprofiletype', '', 'applyAll=0\n\n', 'on_status=0\nxiprofiletype=2\n\n', 2, 1);;