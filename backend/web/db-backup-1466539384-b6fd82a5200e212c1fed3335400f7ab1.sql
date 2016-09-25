DROP TABLE account;

CREATE TABLE `account` (
  `account_id` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `account_name` varchar(45) NOT NULL,
  `level_id` varchar(50) DEFAULT NULL,
  `company_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`account_id`),
  KEY `fk_account_levels1_idx` (`level_id`),
  KEY `fk_account_companies1_idx` (`company_id`),
  CONSTRAINT `account_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `levels` (`level_id`) ON DELETE SET NULL,
  CONSTRAINT `fk_account_companies1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO account VALUES("0dfd0fe1bb4b7c5c55b61b0eacba2","2015-07-27 13:50:38","","Account 2","3420d2b5c4d4a65755bf4cf248ec3","981227f13dd8e05c55b20db1e4080");
INSERT INTO account VALUES("f5becbe216f19a5655b2462de29d6","2015-07-24 16:05:33","","Account 1","3420d2b5c4d4a65755bf4cf248ec3","981227f13dd8e05c55b20db1e4080");



DROP TABLE account_permissions;

CREATE TABLE `account_permissions` (
  `user_role_id` varchar(50) NOT NULL,
  `module` varchar(250) NOT NULL,
  `crud` varchar(4) NOT NULL,
  PRIMARY KEY (`user_role_id`,`module`),
  CONSTRAINT `fk_account_permissions_user_roles_acc1` FOREIGN KEY (`user_role_id`) REFERENCES `account_role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE account_role;

CREATE TABLE `account_role` (
  `id` varchar(50) NOT NULL,
  `account_id` varchar(50) DEFAULT NULL,
  `user_role_name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_roles_account1_idx` (`account_id`),
  CONSTRAINT `fk_user_roles_account1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE attributes;

CREATE TABLE `attributes` (
  `id` varchar(50) NOT NULL,
  `attribute_type` enum('textfield','textarea','dropdown','checkbox') NOT NULL,
  `attribute_name` varchar(45) NOT NULL,
  `account_id` varchar(50) DEFAULT NULL,
  `company_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_account_attributes_account1_idx` (`account_id`),
  KEY `attributes_ibfk_1` (`company_id`),
  CONSTRAINT `attributes_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_account_attributes_account1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO attributes VALUES("00be7f62ca788aab55c371e867b67","textarea","textareadddd","0dfd0fe1bb4b7c5c55b61b0eacba2","981227f13dd8e05c55b20db1e4080");
INSERT INTO attributes VALUES("0442ab2f7ddb8b2555e5b7f3063e4","textfield","Modal","0dfd0fe1bb4b7c5c55b61b0eacba2","981227f13dd8e05c55b20db1e4080");
INSERT INTO attributes VALUES("077dca2a7155a95f55c34741de79a","textfield","Avon attr","","981227f13dd8e05c55b20db1e4080");
INSERT INTO attributes VALUES("722023d50e2b536155c1ee2ba4f0f","textfield","Attr1","0dfd0fe1bb4b7c5c55b61b0eacba2","981227f13dd8e05c55b20db1e4080");
INSERT INTO attributes VALUES("847123d37fcf94be55c340685b32b","textarea","Text area from account1","f5becbe216f19a5655b2462de29d6","981227f13dd8e05c55b20db1e4080");
INSERT INTO attributes VALUES("c083d4f143cba8de55c1ef2b93de5","checkbox","Checkbox attr","0dfd0fe1bb4b7c5c55b61b0eacba2","981227f13dd8e05c55b20db1e4080");
INSERT INTO attributes VALUES("ccc192c998924d6555c1f5ea71ca0","dropdown","dropdown","0dfd0fe1bb4b7c5c55b61b0eacba2","981227f13dd8e05c55b20db1e4080");
INSERT INTO attributes VALUES("e265a257c245350255c1f6259308b","dropdown","Dropdown","0dfd0fe1bb4b7c5c55b61b0eacba2","981227f13dd8e05c55b20db1e4080");



DROP TABLE brochures;

CREATE TABLE `brochures` (
  `brochure_id` varchar(50) NOT NULL,
  `description` varchar(45) NOT NULL,
  `leave_date` date NOT NULL,
  `expire_date` date NOT NULL,
  `location_id` varchar(50) DEFAULT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `company_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`brochure_id`),
  KEY `fk_brochures_locations1_idx` (`location_id`),
  KEY `fk_brochures_user` (`user_id`),
  KEY `company_id` (`company_id`),
  CONSTRAINT `brochures_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `fk_brochures_locations1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`location_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_brochures_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO brochures VALUES("19e23782b6197e4555e6eb541f69b","Company Brochure","2015-09-10","2015-09-25","5078f7af3252588455ba0414b0fcb","8edddc1faba4d40a55b61b0ee684c","981227f13dd8e05c55b20db1e4080");
INSERT INTO brochures VALUES("2accbd40485254d655ba0927413d7","Brochure for Coffee shop","2015-07-08","2015-08-31","5078f7af3252588455ba0414b0fcb","8edddc1faba4d40a55b61b0ee684c","981227f13dd8e05c55b20db1e4080");
INSERT INTO brochures VALUES("31855761e7ecbf3155e09eae77d22","Brochure for Beauty salon","2015-08-28","2015-08-06","77cebad63908ffac55e09e8b2be5b","51b467eb84c744c655b2462eb672e","981227f13dd8e05c55b20db1e4080");
INSERT INTO brochures VALUES("5f97c706fadae9b255e09ae83d747","Brochure in MAR Shopping","2015-08-21","2015-08-31","48f85136d26be1f455ba03df073c3","51b467eb84c744c655b2462eb672e","981227f13dd8e05c55b20db1e4080");
INSERT INTO brochures VALUES("7534486b021dabcf564489e1bafac","asff","2015-11-12","2015-11-20","77cebad63908ffac55e09e8b2be5b","8edddc1faba4d40a55b61b0ee684c","981227f13dd8e05c55b20db1e4080");
INSERT INTO brochures VALUES("8a7886b184064a4d55e6e5efa4b30","New Brochure","2015-09-10","2015-09-30","48f85136d26be1f455ba03df073c3","8edddc1faba4d40a55b61b0ee684c","981227f13dd8e05c55b20db1e4080");
INSERT INTO brochures VALUES("9c17088f5452ece755ba494093474","Brochure for coffe bar","2015-07-31","2015-09-01","df2da59781de58c955e09b146eac1","8edddc1faba4d40a55b61b0ee684c","981227f13dd8e05c55b20db1e4080");
INSERT INTO brochures VALUES("c5f6b98fc9515669564475ea4f61f","Date test","2015-11-13","2015-11-20","df2da59781de58c955e09b146eac1","8edddc1faba4d40a55b61b0ee684c","981227f13dd8e05c55b20db1e4080");



DROP TABLE categories;

CREATE TABLE `categories` (
  `category_id` varchar(50) NOT NULL,
  `category_name` varchar(45) NOT NULL,
  `parent_id` varchar(50) DEFAULT NULL,
  `company_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`category_id`),
  KEY `fk_categories_categories1_idx` (`parent_id`),
  KEY `company_id` (`company_id`),
  CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `fk_categories_categories1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO categories VALUES("14709a96655488ca55b74f481d299","Y","5fe939605c2dea2a55b74f385292f","981227f13dd8e05c55b20db1e4080");
INSERT INTO categories VALUES("258c6c0a86c7882c55b74f6d910de","ABC","","981227f13dd8e05c55b20db1e4080");
INSERT INTO categories VALUES("275a3eb6b2fc7fa755dd9dd6ce86e","L","775ddab7c016bd0055dd9dd6c48c3","981227f13dd8e05c55b20db1e4080");
INSERT INTO categories VALUES("27e43bcec541172355b74f7e894d9","C","258c6c0a86c7882c55b74f6d910de","981227f13dd8e05c55b20db1e4080");
INSERT INTO categories VALUES("3f1eac4bb35218de55e711269925d","WIDZEW","56294a4489bbf72f55e6edd58c508","981227f13dd8e05c55b20db1e4080");
INSERT INTO categories VALUES("53e8495f1b749ba555dd9dd6ce561","K","775ddab7c016bd0055dd9dd6c48c3","981227f13dd8e05c55b20db1e4080");
INSERT INTO categories VALUES("56294a4489bbf72f55e6edd58c508","RTS","","981227f13dd8e05c55b20db1e4080");
INSERT INTO categories VALUES("5fe939605c2dea2a55b74f385292f","XYZP","","981227f13dd8e05c55b20db1e4080");
INSERT INTO categories VALUES("6bccf1caa2bdba4855e6edd59bfe1","T","56294a4489bbf72f55e6edd58c508","981227f13dd8e05c55b20db1e4080");
INSERT INTO categories VALUES("775ddab7c016bd0055dd9dd6c48c3","JKL","","981227f13dd8e05c55b20db1e4080");
INSERT INTO categories VALUES("8e949ed6040d11b055e70e54b34c2","AB","258c6c0a86c7882c55b74f6d910de","981227f13dd8e05c55b20db1e4080");
INSERT INTO categories VALUES("b3bf5c58b42d8de855b74f5c3fa30","Z","5fe939605c2dea2a55b74f385292f","981227f13dd8e05c55b20db1e4080");
INSERT INTO categories VALUES("b9148eb5f3fe57d755e6edd59bc7f","R","56294a4489bbf72f55e6edd58c508","981227f13dd8e05c55b20db1e4080");
INSERT INTO categories VALUES("b927d796b0bba1aa55e71139b5a2f","A","258c6c0a86c7882c55b74f6d910de","981227f13dd8e05c55b20db1e4080");
INSERT INTO categories VALUES("c87b2778d7a408e355e70ea12eedb","AC","258c6c0a86c7882c55b74f6d910de","981227f13dd8e05c55b20db1e4080");
INSERT INTO categories VALUES("cf6987db56c0af2155b74f40e5c13","P","5fe939605c2dea2a55b74f385292f","981227f13dd8e05c55b20db1e4080");
INSERT INTO categories VALUES("d539f40f46ee134755dd9dd6ce2bf","J","775ddab7c016bd0055dd9dd6c48c3","981227f13dd8e05c55b20db1e4080");
INSERT INTO categories VALUES("d8005b41141cb7f855e6edd59c2af","S","56294a4489bbf72f55e6edd58c508","981227f13dd8e05c55b20db1e4080");
INSERT INTO categories VALUES("db08946b85686aca55e71153dd582","JK","775ddab7c016bd0055dd9dd6c48c3","981227f13dd8e05c55b20db1e4080");



DROP TABLE client_attributes;

CREATE TABLE `client_attributes` (
  `client_id` varchar(50) NOT NULL,
  `attribute_id` varchar(50) NOT NULL,
  `option_id` varchar(50) DEFAULT NULL,
  `attribute_value` longtext,
  PRIMARY KEY (`client_id`,`attribute_id`),
  KEY `fk_client_attributes_dropdown_options1_idx` (`option_id`),
  KEY `fk_client_attributes_account_attributes1_idx` (`attribute_id`),
  KEY `fk_client_attributes_clients1_idx` (`client_id`),
  CONSTRAINT `fk_client_attributes_account_attributes1` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_client_attributes_clients1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_client_attributes_dropdown` FOREIGN KEY (`option_id`) REFERENCES `dropdown_options` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO client_attributes VALUES("290c513dd097b9db55c377cf2749a","077dca2a7155a95f55c34741de79a","","");
INSERT INTO client_attributes VALUES("290c513dd097b9db55c377cf2749a","847123d37fcf94be55c340685b32b","","dasfsafsafasgewgewewg");
INSERT INTO client_attributes VALUES("3c37c92fa4dc8e9255c8b1697a16c","077dca2a7155a95f55c34741de79a","","fasfs");
INSERT INTO client_attributes VALUES("3c37c92fa4dc8e9255c8b1697a16c","847123d37fcf94be55c340685b32b","","fsafsa");
INSERT INTO client_attributes VALUES("47b7114868fe482655c3721aea86b","077dca2a7155a95f55c34741de79a","","dsas");
INSERT INTO client_attributes VALUES("47b7114868fe482655c3721aea86b","722023d50e2b536155c1ee2ba4f0f","","");
INSERT INTO client_attributes VALUES("47b7114868fe482655c3721aea86b","c083d4f143cba8de55c1ef2b93de5","","0");
INSERT INTO client_attributes VALUES("47b7114868fe482655c3721aea86b","ccc192c998924d6555c1f5ea71ca0","5f08295a17471e1755c1fb5ad5ae5","");
INSERT INTO client_attributes VALUES("47b7114868fe482655c3721aea86b","e265a257c245350255c1f6259308b","123","");
INSERT INTO client_attributes VALUES("56d94c2a4215d0e555ce07e597120","00be7f62ca788aab55c371e867b67","","");
INSERT INTO client_attributes VALUES("56d94c2a4215d0e555ce07e597120","0442ab2f7ddb8b2555e5b7f3063e4","","");
INSERT INTO client_attributes VALUES("56d94c2a4215d0e555ce07e597120","077dca2a7155a95f55c34741de79a","","");
INSERT INTO client_attributes VALUES("56d94c2a4215d0e555ce07e597120","722023d50e2b536155c1ee2ba4f0f","","");
INSERT INTO client_attributes VALUES("56d94c2a4215d0e555ce07e597120","c083d4f143cba8de55c1ef2b93de5","","0");
INSERT INTO client_attributes VALUES("56d94c2a4215d0e555ce07e597120","ccc192c998924d6555c1f5ea71ca0","5f08295a17471e1755c1fb5ad5ae5","");
INSERT INTO client_attributes VALUES("56d94c2a4215d0e555ce07e597120","e265a257c245350255c1f6259308b","123","");
INSERT INTO client_attributes VALUES("6a0d21ea0a91b2fa564527495164e","077dca2a7155a95f55c34741de79a","","Sup?");
INSERT INTO client_attributes VALUES("91dbf29a543e98d75617e3ff96bed","00be7f62ca788aab55c371e867b67","","");
INSERT INTO client_attributes VALUES("91dbf29a543e98d75617e3ff96bed","0442ab2f7ddb8b2555e5b7f3063e4","","");
INSERT INTO client_attributes VALUES("91dbf29a543e98d75617e3ff96bed","077dca2a7155a95f55c34741de79a","","");
INSERT INTO client_attributes VALUES("91dbf29a543e98d75617e3ff96bed","722023d50e2b536155c1ee2ba4f0f","","");
INSERT INTO client_attributes VALUES("91dbf29a543e98d75617e3ff96bed","c083d4f143cba8de55c1ef2b93de5","","0");
INSERT INTO client_attributes VALUES("91dbf29a543e98d75617e3ff96bed","ccc192c998924d6555c1f5ea71ca0","5f08295a17471e1755c1fb5ad5ae5","");
INSERT INTO client_attributes VALUES("91dbf29a543e98d75617e3ff96bed","e265a257c245350255c1f6259308b","1c8ee4a087b80c6b55c1fb3beacde","");
INSERT INTO client_attributes VALUES("cf0968de15993b0355c377b21c8f7","077dca2a7155a95f55c34741de79a","","a");
INSERT INTO client_attributes VALUES("cf0968de15993b0355c377b21c8f7","722023d50e2b536155c1ee2ba4f0f","","asgsagsgsa");
INSERT INTO client_attributes VALUES("cf0968de15993b0355c377b21c8f7","847123d37fcf94be55c340685b32b","","asfagsggssga");
INSERT INTO client_attributes VALUES("cf0968de15993b0355c377b21c8f7","c083d4f143cba8de55c1ef2b93de5","","1");
INSERT INTO client_attributes VALUES("cf0968de15993b0355c377b21c8f7","ccc192c998924d6555c1f5ea71ca0","5f08295a17471e1755c1fb5ad5ae5","");
INSERT INTO client_attributes VALUES("cf0968de15993b0355c377b21c8f7","e265a257c245350255c1f6259308b","826","");
INSERT INTO client_attributes VALUES("e0ddbf56e3fcad6255c372a8b7caf","077dca2a7155a95f55c34741de79a","","fsafsa");
INSERT INTO client_attributes VALUES("e0ddbf56e3fcad6255c372a8b7caf","722023d50e2b536155c1ee2ba4f0f","","I am awesom text attribute");
INSERT INTO client_attributes VALUES("e0ddbf56e3fcad6255c372a8b7caf","847123d37fcf94be55c340685b32b","","Acccount 1 attrhh");
INSERT INTO client_attributes VALUES("e0ddbf56e3fcad6255c372a8b7caf","c083d4f143cba8de55c1ef2b93de5","","1");
INSERT INTO client_attributes VALUES("e0ddbf56e3fcad6255c372a8b7caf","ccc192c998924d6555c1f5ea71ca0","5f08295a17471e1755c1fb5ad5ae5","");
INSERT INTO client_attributes VALUES("e0ddbf56e3fcad6255c372a8b7caf","e265a257c245350255c1f6259308b","1c8ee4a087b80c6b55c1fb3beacde","");



DROP TABLE clients;

CREATE TABLE `clients` (
  `id` varchar(50) NOT NULL,
  `company_id` varchar(50) DEFAULT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `client_name` varchar(50) NOT NULL,
  `client_email` varchar(50) NOT NULL,
  `client_phone` varchar(50) NOT NULL,
  `client_city` varchar(50) DEFAULT NULL,
  `client_country` varchar(50) DEFAULT NULL,
  `client_address` varchar(250) DEFAULT NULL,
  `client_postal_code` varchar(50) DEFAULT NULL,
  `NIF` varchar(12) DEFAULT NULL,
  `client_photo` varchar(250) DEFAULT NULL,
  `client_gender` tinyint(1) DEFAULT NULL,
  `client_birthdate` date DEFAULT NULL,
  `status` int(11) NOT NULL,
  `client_create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `client_update_time` timestamp NULL DEFAULT NULL,
  `card_id_number` varchar(15) DEFAULT NULL,
  `client_fb` varchar(250) DEFAULT NULL,
  `client_tw` varchar(250) DEFAULT NULL,
  `is_client_lead` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `user_id` (`user_id`),
  KEY `company_id_2` (`company_id`),
  KEY `user_id_2` (`user_id`),
  CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `clients_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO clients VALUES("02479101106993b15645f1f9dcaf0","f8988219854820eb56451750a9055","3018caefc14d65ec56451750c430a","firstname","","lastname","10-12-1990","","","","","","","","1","2015-11-13 21:21:45","","","","","1");
INSERT INTO clients VALUES("290c513dd097b9db55c377cf2749a","981227f13dd8e05c55b20db1e4080","51b467eb84c744c655b2462eb672e","Avon client1","ac@c.df","421421421","Lisbon","Portugal","Rua augusta 134","","122345","","0","2015-08-14","1","2015-09-17 18:29:48","2015-08-06 17:08:07","","","","0");
INSERT INTO clients VALUES("304f3004d23d79b25645f2147552f","f8988219854820eb56451750a9055","3018caefc14d65ec56451750c430a","lastname","","firstname","","","","","","","","","1","2015-11-13 21:22:12","","","","","1");
INSERT INTO clients VALUES("3a359edea833da0f55d1d50c0f981","981227f13dd8e05c55b20db1e4080","8edddc1faba4d40a55b61b0ee684c","Rowley","row@client.as","13412","Cork","Ireland","Backstreet 23","123-2415","1251662261","","","","1","2015-09-17 18:29:33","","213412","","","0");
INSERT INTO clients VALUES("3c37c92fa4dc8e9255c8b1697a16c","981227f13dd8e05c55b20db1e4080","51b467eb84c744c655b2462eb672e","John","trAV@p.p","41142","Matosinhos","Portugal","Rua Vasco da Gama 35","","5678","","","2015-08-04","1","2015-09-17 18:29:52","","","","","0");
INSERT INTO clients VALUES("3e2ea30b755c09b15645334c10aed","f8988219854820eb56451750a9055","3018caefc14d65ec56451750c430a","lastname","birthdate","firstname","","","","","","","","","1","2015-11-13 07:48:12","","","","","1");
INSERT INTO clients VALUES("47b7114868fe482655c3721aea86b","981227f13dd8e05c55b20db1e4080","a2d8d27b2028163455b20db206f6d","Peter New","peter@n.pt","123","Braga","Portugal","Avenida Libertade 1/2","1212","98766","","0","2015-08-02","1","2015-09-17 18:29:58","2015-08-06 16:41:30","","","","0");
INSERT INTO clients VALUES("56d94c2a4215d0e555ce07e597120","981227f13dd8e05c55b20db1e4080","8edddc1faba4d40a55b61b0ee684c","Christopher Blue","chris@blue.bl","71314214","Porto","Portugal","Avenida Liberdade 23","22-3456","12451512512","","","2015-06-18","1","2015-11-12 12:44:04","2015-11-12 19:43:55","213412","","","0");
INSERT INTO clients VALUES("6a0d21ea0a91b2fa564527495164e","f8988219854820eb56451750a9055","3018caefc14d65ec56451750c430a","John Doe","johndoe@nowhere.com","1234567","Porto","Portugal","12345 X street","21345","12345678","","0","2015-11-17","1","2015-11-13 06:56:57","","2134567","http://facebook.com/johndoe","http://twitter.com/johndoe","1");
INSERT INTO clients VALUES("8771d9fbcd1c4ad65617e75755815","981227f13dd8e05c55b20db1e4080","8edddc1faba4d40a55b61b0ee684c","Marge Simpson","marge@simpson.com","52125124","","","","","","","0","0000-00-00","1","2015-10-10 00:12:07","","","","","1");
INSERT INTO clients VALUES("91dbf29a543e98d75617e3ff96bed","981227f13dd8e05c55b20db1e4080","8edddc1faba4d40a55b61b0ee684c","Cristiano Ronaldo","ronaldo@cristiano.pt","5325","Madrid","Spain","xyz","142","123","","1","2015-10-15","1","2015-10-09 23:57:51","","1111","","","0");
INSERT INTO clients VALUES("938edd8e33fb00b45617e757481c0","981227f13dd8e05c55b20db1e4080","8edddc1faba4d40a55b61b0ee684c","Homer Simpson","homer@simpson.com","52125125","","","","","","","1","0000-00-00","1","2015-10-10 00:12:07","","","","","1");
INSERT INTO clients VALUES("ad6743307ee2180c5645334c1ed01","f8988219854820eb56451750a9055","3018caefc14d65ec56451750c430a","lastname","10-12-1990","firstname","","","","","","","","","1","2015-11-13 07:48:12","","","","","1");
INSERT INTO clients VALUES("adb78387d20fbff955db305687958","981227f13dd8e05c55b20db1e4080","8edddc1faba4d40a55b61b0ee684c","David Copperfield","copp@fie.ld","123453","Porto","Portugal","av.Boavista 12","3455-056","21512512","","","","1","2015-09-17 18:30:06","","sfdfds","","","0");
INSERT INTO clients VALUES("ade8b5b8e1b5616c55b61a8a5d511","981227f13dd8e05c55b20db1e4080","a2d8d27b2028163455b20db206f6d","Clara","client2@cl.com","421","Porto","Portugal","Rua Amial 12","123","4412142","company-director.jpg","0","2015-07-05","1","2015-09-17 18:30:09","2015-07-31 18:55:53","","","","0");
INSERT INTO clients VALUES("ba955170f922425f560d56a67ad10","981227f13dd8e05c55b20db1e4080","8edddc1faba4d40a55b61b0ee684c","Brad Pitt","brad@hollywood.com","123456789","New York","Murica","XYZ","412-34","41214","","","","1","2015-10-01 17:52:06","","12","","","0");
INSERT INTO clients VALUES("bf82558cf7541e635645f2148ba23","f8988219854820eb56451750a9055","3018caefc14d65ec56451750c430a","lastname","","firstname","","","","","","","","","1","2015-11-13 21:22:12","","","","","1");
INSERT INTO clients VALUES("cf0968de15993b0355c377b21c8f7","981227f13dd8e05c55b20db1e4080","51b467eb84c744c655b2462eb672e","John Attribute","tom@tom.tf","421124124","Maia","Portugal","Forum Maia 21","","865754","","1","2015-08-07","1","2015-09-17 18:30:12","2015-08-06 17:07:56","","","","0");
INSERT INTO clients VALUES("d072932adcfb721355b61a382505f","981227f13dd8e05c55b20db1e4080","51b467eb84c744c655b2462eb672e","John","client1@cl.com","111","Porto","Portugal","av Aliados 34","11","421412","","1","2015-07-07","1","2015-09-17 18:30:17","","","","","0");
INSERT INTO clients VALUES("d29c4c6a19e9489b5645f1f9cf94c","f8988219854820eb56451750a9055","3018caefc14d65ec56451750c430a","firstname","","lastname","birthdate","","","","","","","","1","2015-11-13 21:21:45","","","","","1");
INSERT INTO clients VALUES("e0ddbf56e3fcad6255c372a8b7caf","981227f13dd8e05c55b20db1e4080","a2d8d27b2028163455b20db206f6d","Tom Tomski","tom@tom.t","512121","Lisbon","Portugal","Rua augusta 12","","1244","","0","2015-08-21","1","2015-09-17 17:17:46","2015-08-06 17:08:25","","","","0");
INSERT INTO clients VALUES("f91548acefa0a84755c24787571ec","981227f13dd8e05c55b20db1e4080","8edddc1faba4d40a55b61b0ee684c","Tom Tomski","tom@tom.tas","412","Faro","Portugal","Rua Valente 269","","1111","","0","2015-08-05","0","2015-09-16 17:22:22","","","","","1");



DROP TABLE companies;

CREATE TABLE `companies` (
  `id` varchar(50) NOT NULL,
  `owner_id` varchar(50) DEFAULT NULL,
  `company_name` varchar(50) NOT NULL,
  `company_slug_name` varchar(50) NOT NULL,
  `company_legal_name` varchar(50) NOT NULL,
  `company_email` varchar(50) DEFAULT NULL,
  `company_url` varchar(50) DEFAULT NULL,
  `company_phone` varchar(50) DEFAULT NULL,
  `company_address` varchar(50) DEFAULT NULL,
  `company_postal_code` varchar(50) DEFAULT NULL,
  `company_vat` varchar(20) DEFAULT NULL,
  `company_currency` varchar(5) DEFAULT 'EUR',
  `status` tinyint(1) NOT NULL,
  `company_trial_end_time` timestamp NULL DEFAULT NULL,
  `company_create_time` timestamp NULL DEFAULT NULL,
  `company_update_time` timestamp NULL DEFAULT NULL,
  `company_delete_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`),
  KEY `owner_id_2` (`owner_id`),
  CONSTRAINT `companies_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO companies VALUES("271d0d59842b50bd5628e73c06f92","81b78d8257c4b7e95628e73c3918d","ColorElephant","colorelephant","ColorElephant, Lda","","","","","","","EUR","1","","2015-10-22 21:40:12","","");
INSERT INTO companies VALUES("981227f13dd8e05c55b20db1e4080","a2d8d27b2028163455b20db206f6d","Avon","avon","Avon","","","","","","","USD","1","","2015-07-24 12:04:33","","");
INSERT INTO companies VALUES("f8988219854820eb56451750a9055","3018caefc14d65ec56451750c430a","SignupForm[company_name]","signupform-company-name","SignupForm[company_legal_name]","","","","","","","EUR","1","","2015-11-13 05:48:48","","");



DROP TABLE companies_users;

CREATE TABLE `companies_users` (
  `company_id` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `user_role_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`company_id`,`user_id`),
  KEY `company_id` (`company_id`,`user_id`,`user_role_id`),
  KEY `user_role_id` (`user_role_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `companies_users_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `companies_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `companies_users_ibfk_3` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO companies_users VALUES("271d0d59842b50bd5628e73c06f92","81b78d8257c4b7e95628e73c3918d","");
INSERT INTO companies_users VALUES("981227f13dd8e05c55b20db1e4080","a2d8d27b2028163455b20db206f6d","");
INSERT INTO companies_users VALUES("f8988219854820eb56451750a9055","3018caefc14d65ec56451750c430a","");
INSERT INTO companies_users VALUES("981227f13dd8e05c55b20db1e4080","51b467eb84c744c655b2462eb672e","e2def69ae7ed23fe55b614bf5ec9b");
INSERT INTO companies_users VALUES("981227f13dd8e05c55b20db1e4080","8edddc1faba4d40a55b61b0ee684c","e2def69ae7ed23fe55b614bf5ec9b");



DROP TABLE dropdown_options;

CREATE TABLE `dropdown_options` (
  `id` varchar(50) NOT NULL,
  `attr_id` varchar(50) NOT NULL,
  `label` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dropdown_options_account_attributes1_idx` (`attr_id`),
  CONSTRAINT `fk_dropdown_options_account_attributes1` FOREIGN KEY (`attr_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO dropdown_options VALUES("123","e265a257c245350255c1f6259308b","ds");
INSERT INTO dropdown_options VALUES("1c8ee4a087b80c6b55c1fb3beacde","e265a257c245350255c1f6259308b","hgjk");
INSERT INTO dropdown_options VALUES("5f08295a17471e1755c1fb5ad5ae5","ccc192c998924d6555c1f5ea71ca0","sfsa");
INSERT INTO dropdown_options VALUES("6ea07aae9ae081ac55c21fb97eec3","ccc192c998924d6555c1f5ea71ca0","fsa");
INSERT INTO dropdown_options VALUES("826","e265a257c245350255c1f6259308b","dsa");



DROP TABLE goals;

CREATE TABLE `goals` (
  `goal_id` varchar(50) NOT NULL,
  `goal_type` enum('daily','weekly','monthly') NOT NULL,
  `goal_value` int(11) NOT NULL,
  `account_id` varchar(50) NOT NULL,
  `time_of_receive` datetime DEFAULT NULL,
  `start_date` date NOT NULL,
  PRIMARY KEY (`goal_id`),
  KEY `fk_goals_account1_idx` (`account_id`),
  CONSTRAINT `fk_goals_account1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO goals VALUES("086087f4545968d055db1a15cafb6","daily","100","f5becbe216f19a5655b2462de29d6","2015-10-29 13:35:11","0000-00-00");
INSERT INTO goals VALUES("25a430a5695ba04355db222baed3e","weekly","2000","0dfd0fe1bb4b7c5c55b61b0eacba2","","0000-00-00");
INSERT INTO goals VALUES("987b8190c187ba5155d703e310a3e","weekly","121","f5becbe216f19a5655b2462de29d6","2015-10-29 13:35:11","0000-00-00");
INSERT INTO goals VALUES("dd8b3ceef8d8985f55db1a256e5ef","monthly","300","f5becbe216f19a5655b2462de29d6","2015-10-29 13:40:03","0000-00-00");
INSERT INTO goals VALUES("df7abb69d99a66ca55db1e4682c89","daily","131","0dfd0fe1bb4b7c5c55b61b0eacba2","2015-11-12 16:27:33","0000-00-00");
INSERT INTO goals VALUES("f48fac0e43cff97755db2234752a4","monthly","3650","0dfd0fe1bb4b7c5c55b61b0eacba2","","0000-00-00");



DROP TABLE levels;

CREATE TABLE `levels` (
  `level_id` varchar(50) NOT NULL,
  `name` varchar(45) NOT NULL,
  `company_id` varchar(50) NOT NULL,
  PRIMARY KEY (`level_id`),
  KEY `fk_levels_companies1_idx` (`company_id`),
  CONSTRAINT `fk_levels_companies1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO levels VALUES("3420d2b5c4d4a65755bf4cf248ec3","LEVEL 3","981227f13dd8e05c55b20db1e4080");
INSERT INTO levels VALUES("41d687e2d071819a55bf4cc928f6f","LEVEL 1","981227f13dd8e05c55b20db1e4080");
INSERT INTO levels VALUES("84c0e45d5aacce4255bf4cdba38d6","LEVEL2","981227f13dd8e05c55b20db1e4080");



DROP TABLE levels_thresholds;

CREATE TABLE `levels_thresholds` (
  `level_id` varchar(50) NOT NULL,
  `threshold` int(11) NOT NULL,
  `commision_percent` int(11) NOT NULL,
  PRIMARY KEY (`level_id`),
  CONSTRAINT `fk_levels_tresholds_levels1` FOREIGN KEY (`level_id`) REFERENCES `levels` (`level_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO levels_thresholds VALUES("3420d2b5c4d4a65755bf4cf248ec3","2001","14");
INSERT INTO levels_thresholds VALUES("41d687e2d071819a55bf4cc928f6f","0","10");
INSERT INTO levels_thresholds VALUES("84c0e45d5aacce4255bf4cdba38d6","1001","12");



DROP TABLE locations;

CREATE TABLE `locations` (
  `location_id` varchar(50) NOT NULL,
  `location_name` varchar(45) NOT NULL,
  `city` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `postal_code` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`location_id`),
  KEY `fk_location_user` (`user_id`),
  CONSTRAINT `fk_location_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO locations VALUES("48f85136d26be1f455ba03df073c3","Coffee Bar 1","Porto","Portugal","","","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO locations VALUES("5078f7af3252588455ba0414b0fcb","Coffee shop1","Porto","Portugal","rua Amial","11111","124412","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO locations VALUES("77cebad63908ffac55e09e8b2be5b","Beauty Salon","Porto","Portugal","Av.Boavista","11112412","125626116","51b467eb84c744c655b2462eb672e");
INSERT INTO locations VALUES("df2da59781de58c955e09b146eac1","MAR Shopping","Porto","Portugal","","","","51b467eb84c744c655b2462eb672e");



DROP TABLE login_attempts;

CREATE TABLE `login_attempts` (
  `id` varchar(50) NOT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `attempt_password` varchar(250) NOT NULL,
  `attempt_status` tinyint(1) NOT NULL,
  `attempt_browser` varchar(250) DEFAULT NULL,
  `attempt_ip` varchar(250) DEFAULT NULL,
  `attempt_os` varchar(250) DEFAULT NULL,
  `attempt_device` varchar(250) DEFAULT NULL,
  `attempt_city` varchar(250) DEFAULT NULL,
  `attempt_country` varchar(250) DEFAULT NULL,
  `attempt_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_id_2` (`user_id`),
  CONSTRAINT `login_attempts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO login_attempts VALUES("019e9112ac7d147355dae87a0ebd7","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-08-24 11:48:42");
INSERT INTO login_attempts VALUES("0272f7798ce6002255c372d133719","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-06 16:44:33");
INSERT INTO login_attempts VALUES("02b324eb54e48e93564517701cb3a","3018caefc14d65ec56451750c430a","password","1","Chrome","","Linux","Desktop","","","2015-11-13 05:49:20");
INSERT INTO login_attempts VALUES("0353840812c58a9855cdf4a80abf9","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-08-14 16:01:12");
INSERT INTO login_attempts VALUES("0368cc53568485de55c371f9b3f22","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-06 16:40:57");
INSERT INTO login_attempts VALUES("0437ae7c267580db55b60e81c95a8","a2d8d27b2028163455b20db206f6d","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-27 12:57:05");
INSERT INTO login_attempts VALUES("06061d0fc790567155f9c5ce48619","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-09-16 21:41:02");
INSERT INTO login_attempts VALUES("0b180ca2eac3feba55e45fe787fbc","8edddc1faba4d40a55b61b0ee684c","qwerty","0","Chrome","94.60.142.48","Windows 8.1","Desktop","Portugal","","2015-08-31 16:08:39");
INSERT INTO login_attempts VALUES("11c5b29c1c91f36d55d1b95fcc1a4","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-17 12:37:19");
INSERT INTO login_attempts VALUES("131d5971859cda2655c3721016528","a2d8d27b2028163455b20db206f6d","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-06 16:41:20");
INSERT INTO login_attempts VALUES("132f4b2c4372694b55ca046727f07","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-11 16:19:19");
INSERT INTO login_attempts VALUES("13950219af7c3e6d560d1c6bc9659","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-10-01 13:43:39");
INSERT INTO login_attempts VALUES("154dd39612e45380564b783f6e5ea","81b78d8257c4b7e95628e73c3918d","qwerty","1","Chrome","77.54.143.226","Linux","Desktop","Portugal","","2015-11-18 01:55:59");
INSERT INTO login_attempts VALUES("16b2176d25fc76ee55c32890d3962","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-06 11:27:44");
INSERT INTO login_attempts VALUES("17f1f1f3429c9c6e5604073b0620a","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-09-24 16:22:51");
INSERT INTO login_attempts VALUES("1a227986859ea53f55fc21f46c1f1","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.61.73.163","Windows 8.1","Desktop","Portugal","","2015-09-18 16:38:44");
INSERT INTO login_attempts VALUES("1c5764ff0c8a9d7155b6168a977c6","a2d8d27b2028163455b20db206f6d","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-07-27 13:31:22");
INSERT INTO login_attempts VALUES("1ccfc3c655e9a4d455c8b564a5858","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-10 16:29:56");
INSERT INTO login_attempts VALUES("1f9559d24e47fe4055fac708b864f","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-09-17 15:58:32");
INSERT INTO login_attempts VALUES("22828ffe6df294ab56451ffa0b02a","3018caefc14d65ec56451750c430a","password","1","Chrome","77.54.143.226","Linux","Desktop","Portugal","","2015-11-13 06:25:46");
INSERT INTO login_attempts VALUES("231ed0dcac7926e655dde5b8ca9ea","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-08-26 18:13:44");
INSERT INTO login_attempts VALUES("237e1ac5d54e97eb564da0e738cc7","81b78d8257c4b7e95628e73c3918d","qwerty","1","Chrome","77.54.143.226","Linux","Desktop","Portugal","","2015-11-19 17:13:59");
INSERT INTO login_attempts VALUES("28ed66a22d82d43955bf81fb5aaa2","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-08-03 17:00:11");
INSERT INTO login_attempts VALUES("2907e0d19564812755ca06e40fcbc","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-11 16:29:56");
INSERT INTO login_attempts VALUES("296ba23f94283db9560113395624b","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.61.73.163","Windows 8.1","Desktop","Portugal","","2015-09-22 10:37:13");
INSERT INTO login_attempts VALUES("2bd155081b65eff855e0902ad5b90","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.142.48","Windows 8.1","Desktop","Portugal","","2015-08-28 18:45:30");
INSERT INTO login_attempts VALUES("2bdaa340342b1e6755c8c8dea715c","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-08-10 17:53:02");
INSERT INTO login_attempts VALUES("2d5c9a251173bf885628b2cf934c2","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","77.54.143.226","Windows 8.1","Desktop","Portugal","","2015-10-22 17:56:31");
INSERT INTO login_attempts VALUES("2e9cf68390aceb2c55c21ae2c1fb6","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-05 16:17:06");
INSERT INTO login_attempts VALUES("3070849db78a41ef55dc72709d1d4","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-25 15:49:36");
INSERT INTO login_attempts VALUES("30b53f2b3346272f55e42b034a03f","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.142.48","Windows 8.1","Desktop","Portugal","","2015-08-31 12:22:59");
INSERT INTO login_attempts VALUES("323e19abe1984d2755d21579a58fd","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-17 19:10:17");
INSERT INTO login_attempts VALUES("37d0d8fb8248d83455e592ce97ed3","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.142.48","Windows 8.1","Desktop","Portugal","","2015-09-01 13:58:06");
INSERT INTO login_attempts VALUES("381905505bd7d28155ddc839b7e19","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-26 16:07:53");
INSERT INTO login_attempts VALUES("39456752d181df4555b6501dedb78","a2d8d27b2028163455b20db206f6d","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-27 17:37:01");
INSERT INTO login_attempts VALUES("3d8c4abb097a9f6655bb6546c16e1","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-31 14:08:38");
INSERT INTO login_attempts VALUES("3d9551e9bba04db055e0921096f00","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.142.48","Windows 8.1","Desktop","Portugal","","2015-08-28 18:53:36");
INSERT INTO login_attempts VALUES("423270456f1c6cfd55d457dc28897","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-19 12:18:04");
INSERT INTO login_attempts VALUES("44b4a1e003069d0955cdcfc89c92d","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-08-14 13:23:52");
INSERT INTO login_attempts VALUES("45f48d0bcb840dc5564b76b1001f0","81b78d8257c4b7e95628e73c3918d","qwertyui","0","Chrome","77.54.143.226","Linux","Desktop","Portugal","","2015-11-18 01:49:21");
INSERT INTO login_attempts VALUES("47af616d3bc5ef0455d712b741427","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-21 13:59:51");
INSERT INTO login_attempts VALUES("47da0908e9e80cc455d1e9ce08375","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-17 16:03:58");
INSERT INTO login_attempts VALUES("4875a5c6761d598555cc7a0b95528","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-13 13:05:47");
INSERT INTO login_attempts VALUES("4aef338236f4813e55b60526ac85b","a2d8d27b2028163455b20db206f6d","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-27 12:17:10");
INSERT INTO login_attempts VALUES("4cae2d26509845b255ffe9b64b061","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.61.73.163","Windows 8.1","Desktop","Portugal","","2015-09-21 13:27:50");
INSERT INTO login_attempts VALUES("4d50d9f3ca238f815628e800063c3","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-10-22 21:43:28");
INSERT INTO login_attempts VALUES("510d819f2dffdfd05600198aa531f","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-09-21 16:51:54");
INSERT INTO login_attempts VALUES("513da19f8bbf244e55b61ce555c58","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-27 13:58:29");
INSERT INTO login_attempts VALUES("5211703f31d0779f55d209c840424","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-17 18:20:24");
INSERT INTO login_attempts VALUES("52c1ac41e4c51a0b56339b5376f2b","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","77.54.143.226","Windows 8.1","Desktop","Portugal","","2015-10-30 22:31:15");
INSERT INTO login_attempts VALUES("53bdc395865eb8b955c397dce2da7","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-06 19:22:36");
INSERT INTO login_attempts VALUES("540c0036f99984b355c4898f4a50c","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-07 12:33:51");
INSERT INTO login_attempts VALUES("550b03d14710f3b555ed9ade53477","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-09-07 16:10:38");
INSERT INTO login_attempts VALUES("56ca8736b460726556453303bb9b3","3018caefc14d65ec56451750c430a","password","1","Chrome","77.54.143.226","Linux","Desktop","Portugal","","2015-11-13 07:46:59");
INSERT INTO login_attempts VALUES("56d27616ad61eaba55e02854c5a2b","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-08-28 11:22:28");
INSERT INTO login_attempts VALUES("56f57156a16f713c55b6167c15577","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-07-27 13:31:08");
INSERT INTO login_attempts VALUES("59c43f6fc1321e9b55e091cfe6a22","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.142.48","Windows 8.1","Desktop","Portugal","","2015-08-28 18:52:31");
INSERT INTO login_attempts VALUES("5a5876c1d6c4514f561b86d271474","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.61.73.163","Windows 8.1","Desktop","Portugal","","2015-10-12 18:09:22");
INSERT INTO login_attempts VALUES("5e67c6bd4a0c0eae55fac8a332049","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.61.73.163","Windows 8.1","Desktop","Portugal","","2015-09-17 16:05:23");
INSERT INTO login_attempts VALUES("600ae5948899d194560a5c8516339","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.61.73.163","Windows 8.1","Desktop","Portugal","","2015-09-29 11:40:21");
INSERT INTO login_attempts VALUES("61047be5905e7838561b872e9268c","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.61.73.163","Windows 8.1","Desktop","Portugal","","2015-10-12 18:10:54");
INSERT INTO login_attempts VALUES("6596fd171252f58c56339aebe4caa","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","77.54.143.226","Windows 8.1","Desktop","Portugal","","2015-10-30 22:29:32");
INSERT INTO login_attempts VALUES("67bd675ffdeca14c55b64efa8fc4c","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-07-27 17:32:10");
INSERT INTO login_attempts VALUES("68453a3b1f97909255e45f9a1c51b","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.142.48","Windows 8.1","Desktop","Portugal","","2015-08-31 16:07:22");
INSERT INTO login_attempts VALUES("6a0039185fc5776555fa8fc3cda7f","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-09-17 12:02:43");
INSERT INTO login_attempts VALUES("6b260788f147505b5633bb5ed5096","a2d8d27b2028163455b20db206f6d","qwerty","1","Chrome","77.54.143.226","Windows 8.1","Desktop","Portugal","","2015-10-31 00:47:58");
INSERT INTO login_attempts VALUES("6c1b2f78d6e98ed255c3404375fd9","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-06 13:08:51");
INSERT INTO login_attempts VALUES("6d97c9dc75075d2c55dc3f7f3632c","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-08-25 12:12:15");
INSERT INTO login_attempts VALUES("6fb633e4fe3c4aef55b264d25832c","a2d8d27b2028163455b20db206f6d","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-24 18:16:18");
INSERT INTO login_attempts VALUES("70cb5ad54b7eac8d55e091f162cec","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.142.48","Windows 8.1","Desktop","Portugal","","2015-08-28 18:53:05");
INSERT INTO login_attempts VALUES("714500065026523e55b6188f108a1","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-27 13:39:59");
INSERT INTO login_attempts VALUES("7296e73300dbbfe95628e6d97f7db","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-10-22 21:38:33");
INSERT INTO login_attempts VALUES("72a37eaacc8a3b8f55b9ebb3b74ca","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-07-30 11:17:39");
INSERT INTO login_attempts VALUES("7319ab8f5498cefa562dfe30890ec","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-10-26 16:19:28");
INSERT INTO login_attempts VALUES("732b32bdb5d259cf55e45fedf0bd5","8edddc1faba4d40a55b61b0ee684c","qwerty1","1","Chrome","94.60.142.48","Windows 8.1","Desktop","Portugal","","2015-08-31 16:08:45");
INSERT INTO login_attempts VALUES("750da518b615dc06561b8cf0e7a79","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.61.73.163","Windows 8.1","Desktop","Portugal","","2015-10-12 18:35:28");
INSERT INTO login_attempts VALUES("776cb7dd935388db55b224c0d07f5","a2d8d27b2028163455b20db206f6d","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-24 13:42:56");
INSERT INTO login_attempts VALUES("7a3ba4a590d544b855d3662ecbbe8","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-18 19:06:54");
INSERT INTO login_attempts VALUES("7f5b210868c9425555ffd005ca855","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.61.73.163","Windows 8.1","Desktop","Portugal","","2015-09-21 11:38:13");
INSERT INTO login_attempts VALUES("7fe2b208a793205755b24e055a150","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-24 16:39:01");
INSERT INTO login_attempts VALUES("8057debc1f3214fd55fac17173b52","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-09-17 15:34:41");
INSERT INTO login_attempts VALUES("808c74fec5fea12f55d3622875a68","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-18 18:49:44");
INSERT INTO login_attempts VALUES("811b5636480ee7a955c36a7adae54","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-06 16:08:58");
INSERT INTO login_attempts VALUES("81ebeba9fd73051355e592c1f285a","8edddc1faba4d40a55b61b0ee684c","qwerty1","0","Chrome","94.60.142.48","Windows 8.1","Desktop","Portugal","","2015-09-01 13:57:54");
INSERT INTO login_attempts VALUES("8221ac0b1049470755ca06e4d90d0","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-11 16:29:56");
INSERT INTO login_attempts VALUES("83b5734b95887d10564da0fed1381","81b78d8257c4b7e95628e73c3918d","qwerty","1","Chrome","77.54.143.226","Linux","Desktop","Portugal","","2015-11-19 17:14:22");
INSERT INTO login_attempts VALUES("892a15798ad1d83055c8b0d80c3de","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-08-10 16:10:32");
INSERT INTO login_attempts VALUES("895c3618e932d513561b7cf462a17","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-10-12 17:27:16");
INSERT INTO login_attempts VALUES("8a956b66e0c7b31055b214755139c","a2d8d27b2028163455b20db206f6d","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-24 12:33:25");
INSERT INTO login_attempts VALUES("8ae6ed8b594975ea55e70b6268015","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-09-02 16:44:50");
INSERT INTO login_attempts VALUES("8b5267266142443355b61a4e385b3","a2d8d27b2028163455b20db206f6d","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-27 13:47:26");
INSERT INTO login_attempts VALUES("8c6e39b2d62ceedd561fdd5225d21","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-10-16 01:07:30");
INSERT INTO login_attempts VALUES("8d5c7d5d53addd0f561b816638eff","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-10-12 17:46:14");
INSERT INTO login_attempts VALUES("8e9d8d15be9023f055b64fc1d0457","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-27 17:35:29");
INSERT INTO login_attempts VALUES("9092225ada304b8155b64f685551b","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-27 17:34:00");
INSERT INTO login_attempts VALUES("92755e963121a1af55c36abf80485","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-06 16:10:07");
INSERT INTO login_attempts VALUES("9385ad194f56b6b8560d3ab12c3d4","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-10-01 15:52:49");
INSERT INTO login_attempts VALUES("95d9273b03fbf76155b60e1c6616b","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-27 12:55:24");
INSERT INTO login_attempts VALUES("96690347758f2a45563211fe2a6ee","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","77.54.143.226","Windows 8.1","Desktop","Portugal","","2015-10-29 18:33:02");
INSERT INTO login_attempts VALUES("980913d62eda889155b64f1dee5ed","a2d8d27b2028163455b20db206f6d","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-27 17:32:45");
INSERT INTO login_attempts VALUES("9853a0126446fee655d7133be7b0d","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-21 14:02:03");
INSERT INTO login_attempts VALUES("99ae512bd30a159155db1e3c7798a","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-24 15:38:04");
INSERT INTO login_attempts VALUES("9bc0119bc4d6400455f9e57f07430","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.21.27","Windows 8.1","Desktop","Portugal","","2015-09-16 23:56:15");
INSERT INTO login_attempts VALUES("9c1f7a2eb499a49555fabd1e939c7","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.61.73.163","Windows 8.1","Desktop","Portugal","","2015-09-17 15:16:14");
INSERT INTO login_attempts VALUES("9ccfdc1af09b71db5645f1c4243ee","3018caefc14d65ec56451750c430a","password","1","Chrome","","Linux","Desktop","","","2015-11-13 21:20:52");
INSERT INTO login_attempts VALUES("9e4fe9d082e90b6555c4cca918d6a","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-08-07 17:20:09");
INSERT INTO login_attempts VALUES("9f4a6e70ad51a8dc56453d4636633","3018caefc14d65ec56451750c430a","password","1","Chrome","77.54.143.226","Linux","Desktop","Portugal","","2015-11-13 08:30:46");
INSERT INTO login_attempts VALUES("9fa64de158b113405633a9787c4e7","a2d8d27b2028163455b20db206f6d","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-10-30 23:31:36");
INSERT INTO login_attempts VALUES("a02dacfa8700168255e87d7367d70","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.61.73.163","Windows 8.1","Desktop","Portugal","","2015-09-03 19:03:47");
INSERT INTO login_attempts VALUES("a2a6ff955ae07a9355b904e3c3b6f","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-29 18:52:51");
INSERT INTO login_attempts VALUES("a48181825ceb17a055ba500d3d5ac","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-07-30 18:25:49");
INSERT INTO login_attempts VALUES("a4a1d8eba696767355ccc7e656331","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-13 18:37:58");
INSERT INTO login_attempts VALUES("a6e26a826b010e1555e45f7c5f2d2","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.142.48","Windows 8.1","Desktop","Portugal","","2015-08-31 16:06:52");
INSERT INTO login_attempts VALUES("a6e8e42d66374379561fdeb00c59d","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Firefox","94.61.73.163","Windows 8.1","Desktop","Portugal","","2015-10-16 01:13:20");
INSERT INTO login_attempts VALUES("a72937dfbf2b9b4355e45f8b7c7b9","8edddc1faba4d40a55b61b0ee684c","qwert","0","Chrome","94.60.142.48","Windows 8.1","Desktop","Portugal","","2015-08-31 16:07:07");
INSERT INTO login_attempts VALUES("a938dd21d394b26d563239e1dd2a3","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-10-29 21:23:14");
INSERT INTO login_attempts VALUES("aa099e1240e014fd560d5641081e7","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-10-01 17:50:25");
INSERT INTO login_attempts VALUES("aedff00a481d941e55bf3cd8b378f","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-03 12:05:12");
INSERT INTO login_attempts VALUES("b10622bc26618d325620fccadf7ec","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","77.54.143.226","Windows 8.1","Desktop","Portugal","","2015-10-16 21:34:03");
INSERT INTO login_attempts VALUES("b12baca7fba0a22656446a2dc503c","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-11-12 17:30:05");
INSERT INTO login_attempts VALUES("b24b0c2d1a48f5ec55d5a5fe5bbcf","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-20 12:03:42");
INSERT INTO login_attempts VALUES("b567c0240f4811a655cb7bb4f036b","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-12 19:00:37");
INSERT INTO login_attempts VALUES("b6165fc00dcf98e055cdbcc6c77b6","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-14 12:02:46");
INSERT INTO login_attempts VALUES("b6a919b371c2ef0f5633a11c96e83","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","77.54.143.226","Windows 8.1","Desktop","Portugal","","2015-10-30 22:55:56");
INSERT INTO login_attempts VALUES("ba9a417faa927a1055b61a9b3fef3","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-27 13:48:43");
INSERT INTO login_attempts VALUES("bf5995faa0b0baf555d700f8aacf3","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-08-21 12:44:08");
INSERT INTO login_attempts VALUES("c03c28d2511893d255fac78fda5e1","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-09-17 16:00:47");
INSERT INTO login_attempts VALUES("c1757f1082f4fb7a55c340fdd0074","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-06 13:11:57");
INSERT INTO login_attempts VALUES("c499f440ec3660d95603c00f3ae87","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-09-24 11:19:11");
INSERT INTO login_attempts VALUES("c50f70f485840e6d55ca0587f0e55","8edddc1faba4d40a55b61b0ee684c","qwert","0","Firefox","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-11 16:24:07");
INSERT INTO login_attempts VALUES("c5d7f3541a52d5a555c3463e1b837","a2d8d27b2028163455b20db206f6d","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-06 13:34:22");
INSERT INTO login_attempts VALUES("c789a2d5caae0a3e55dd8f7607895","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-26 12:05:42");
INSERT INTO login_attempts VALUES("cd4550ace6aaac4855fbde1c4b919","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-09-18 11:49:16");
INSERT INTO login_attempts VALUES("cda8f51216b6519b55e45f946f256","8edddc1faba4d40a55b61b0ee684c","qwerty1","0","Chrome","94.60.142.48","Windows 8.1","Desktop","Portugal","","2015-08-31 16:07:16");
INSERT INTO login_attempts VALUES("d027dfd16f4d261855faa64334a0a","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-09-17 13:38:43");
INSERT INTO login_attempts VALUES("d0fb5e24f760aa5755ca059414f07","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Firefox","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-11 16:24:20");
INSERT INTO login_attempts VALUES("d282e51a0418bb08564da0e2153d5","81b78d8257c4b7e95628e73c3918d","qwertyui","0","Chrome","77.54.143.226","Linux","Desktop","Portugal","","2015-11-19 17:13:54");
INSERT INTO login_attempts VALUES("d2b2b6c92f6ffdf357698d4cdb43f","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","31.183.4.28","Windows 8.1","Desktop","Poland","Łódź","2016-06-21 20:54:04");
INSERT INTO login_attempts VALUES("d3ef274e4e54935255c340713fc79","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-06 13:09:37");
INSERT INTO login_attempts VALUES("d45634df96bb3f6255b653e11f751","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-27 17:53:05");
INSERT INTO login_attempts VALUES("dbe893ffa0c97a4d564b76b66bcca","81b78d8257c4b7e95628e73c3918d","qwerty","1","Chrome","77.54.143.226","Linux","Desktop","Portugal","","2015-11-18 01:49:26");
INSERT INTO login_attempts VALUES("df2a5f4f9cb393cf55b61ccc4a843","a2d8d27b2028163455b20db206f6d","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-27 13:58:04");
INSERT INTO login_attempts VALUES("df97e91edd81e21e5633bade0b76b","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-10-31 00:45:50");
INSERT INTO login_attempts VALUES("dfe420c62aebe1ce55d1d46bdb267","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-08-17 14:32:43");
INSERT INTO login_attempts VALUES("e07c7d783a39d10155e592c812f15","8edddc1faba4d40a55b61b0ee684c","qwerty11","0","Chrome","94.60.142.48","Windows 8.1","Desktop","Portugal","","2015-09-01 13:58:00");
INSERT INTO login_attempts VALUES("e22651bc87bf2b33562a1f9f3342c","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","77.54.143.226","Windows 8.1","Desktop","Portugal","","2015-10-23 19:53:03");
INSERT INTO login_attempts VALUES("e3460c3e2a03e3ee55e71999dbe81","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-09-02 17:45:29");
INSERT INTO login_attempts VALUES("e4e92d453b91a61c55d30319d38da","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-18 12:04:09");
INSERT INTO login_attempts VALUES("e5539ef750ba8c4f55d30334e5c36","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-18 12:04:36");
INSERT INTO login_attempts VALUES("e5b6e79708777435561b8485e88e3","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-10-12 17:59:33");
INSERT INTO login_attempts VALUES("e732583ab00d0d0b55c9de3021b4a","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-11 13:36:16");
INSERT INTO login_attempts VALUES("e8877eac705ecc825633b552a95b0","a2d8d27b2028163455b20db206f6d","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-10-31 00:22:10");
INSERT INTO login_attempts VALUES("ea7ddc72b77855de55c3641d29a78","a2d8d27b2028163455b20db206f6d","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-06 15:41:49");
INSERT INTO login_attempts VALUES("eb654d8733bc5ddc55c3461ea8888","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-06 13:33:50");
INSERT INTO login_attempts VALUES("ec5089f03691489555c1de5bbdba1","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-05 11:58:51");
INSERT INTO login_attempts VALUES("ecfb0e7a254bad4655e45f701963a","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.142.48","Windows 8.1","Desktop","Portugal","","2015-08-31 16:06:40");
INSERT INTO login_attempts VALUES("ededfa4418b1f79b55b7613b6bc14","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-28 13:02:19");
INSERT INTO login_attempts VALUES("f05e045de90082aa562a1efca140d","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","77.54.143.226","Windows 8.1","Desktop","Portugal","","2015-10-23 19:50:21");
INSERT INTO login_attempts VALUES("f0f18a89ee2a6e3255dc726fc0a73","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-25 15:49:35");
INSERT INTO login_attempts VALUES("f37f006c6e1143aa55f993d84aba8","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-09-16 18:07:52");
INSERT INTO login_attempts VALUES("f3f025d20816772f55e45f86d6acb","8edddc1faba4d40a55b61b0ee684c","qwerty1","0","Chrome","94.60.142.48","Windows 8.1","Desktop","Portugal","","2015-08-31 16:07:02");
INSERT INTO login_attempts VALUES("f4f3ec8ef9e013b056373807d495f","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","","Windows 8.1","Desktop","","","2015-11-02 17:16:39");
INSERT INTO login_attempts VALUES("f646950c249eb94e55b74bf9f2ca9","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-07-28 11:31:37");
INSERT INTO login_attempts VALUES("f8b4a274a3d1fdf655c340860ad01","51b467eb84c744c655b2462eb672e","qwerty","1","Chrome","94.60.47.138","Windows 8.1","Desktop","Portugal","","2015-08-06 13:09:58");
INSERT INTO login_attempts VALUES("f8e5a56bc87dae42560cfc4ae64e3","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.61.73.163","Windows 8.1","Desktop","Portugal","","2015-10-01 11:26:34");
INSERT INTO login_attempts VALUES("ffc0bd9aef3d4c3b5617aab446894","8edddc1faba4d40a55b61b0ee684c","qwerty","1","Chrome","94.61.73.163","Windows 8.1","Desktop","Portugal","","2015-10-09 19:53:24");



DROP TABLE product_subcategory;

CREATE TABLE `product_subcategory` (
  `product_id` varchar(50) NOT NULL,
  `category_id` varchar(50) NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`),
  KEY `fk_product_subcategory_products1_idx` (`product_id`),
  KEY `fk_product_subcategory_categories1_idx` (`category_id`),
  CONSTRAINT `fk_product_subcategory_categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_subcategory_products1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO product_subcategory VALUES("214697327796ed4155b898dd8c05f","14709a96655488ca55b74f481d299");
INSERT INTO product_subcategory VALUES("214697327796ed4155b898dd8c05f","b3bf5c58b42d8de855b74f5c3fa30");
INSERT INTO product_subcategory VALUES("3bac9b0f5759bed355bb4339d0611","27e43bcec541172355b74f7e894d9");
INSERT INTO product_subcategory VALUES("6881be8cc48fa3e9560d6fce06f2d","6bccf1caa2bdba4855e6edd59bfe1");
INSERT INTO product_subcategory VALUES("6881be8cc48fa3e9560d6fce06f2d","b9148eb5f3fe57d755e6edd59bc7f");
INSERT INTO product_subcategory VALUES("6a14236e6369a9e555b8f2bb8cf49","27e43bcec541172355b74f7e894d9");
INSERT INTO product_subcategory VALUES("6d37a583c8f091f555cdd092b45ee","27e43bcec541172355b74f7e894d9");
INSERT INTO product_subcategory VALUES("970f1566a9b0650d55b8f32df282e","14709a96655488ca55b74f481d299");
INSERT INTO product_subcategory VALUES("970f1566a9b0650d55b8f32df282e","cf6987db56c0af2155b74f40e5c13");
INSERT INTO product_subcategory VALUES("f6ec7b87e92122f155c084eb67fcb","27e43bcec541172355b74f7e894d9");
INSERT INTO product_subcategory VALUES("f7379b6dc378987055c0851e4bc83","cf6987db56c0af2155b74f40e5c13");



DROP TABLE products;

CREATE TABLE `products` (
  `product_id` varchar(50) NOT NULL,
  `product_code` varchar(150) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `product_price` float NOT NULL,
  `product_promotion_price` float DEFAULT NULL,
  `category_id` varchar(50) NOT NULL,
  `product_image` varchar(250) DEFAULT NULL,
  `expiry_date` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `company_id` varchar(50) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `fk_products_categories1_idx` (`category_id`),
  KEY `fk_products_company` (`company_id`),
  CONSTRAINT `fk_products_categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_products_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO products VALUES("214697327796ed4155b898dd8c05f","FP2015","First Product","10","","5fe939605c2dea2a55b74f385292f","perfumy-celebre-avon-25-zl.jpg","14","2015-07-29 11:11:57","2015-10-01 19:38:24","981227f13dd8e05c55b20db1e4080");
INSERT INTO products VALUES("2ab5e4295819fdfa55b8f4906ed04","SP210","Super Product","142","","258c6c0a86c7882c55b74f6d910de","images.jpg","10","2015-07-29 17:43:12","2015-08-04 12:36:43","981227f13dd8e05c55b20db1e4080");
INSERT INTO products VALUES("3bac9b0f5759bed355bb4339d0611","P1","Product 1","100","","258c6c0a86c7882c55b74f6d910de","perfumy-celebre-avon-25-zl.jpg","30","2015-07-31 11:43:21","2015-08-04 12:31:27","981227f13dd8e05c55b20db1e4080");
INSERT INTO products VALUES("3f26ad27e26b456355bf8443c883f","P345","Product 345","10","","258c6c0a86c7882c55b74f6d910de","images.jpg","90","2015-08-03 17:09:55","","981227f13dd8e05c55b20db1e4080");
INSERT INTO products VALUES("6881be8cc48fa3e9560d6fce06f2d","AW2015","Awesome Product","999","","56294a4489bbf72f55e6edd58c508","","12","2015-10-01 19:39:26","","981227f13dd8e05c55b20db1e4080");
INSERT INTO products VALUES("6a14236e6369a9e555b8f2bb8cf49","SP20","Some product","12","","258c6c0a86c7882c55b74f6d910de","perfumy-celebre-avon-25-zl.jpg","120","2015-07-29 17:35:23","2015-07-30 18:40:29","981227f13dd8e05c55b20db1e4080");
INSERT INTO products VALUES("6d37a583c8f091f555cdd092b45ee","EP2015","Extra Product","12","","258c6c0a86c7882c55b74f6d910de","images.jpg","7","2015-08-14 13:27:14","","981227f13dd8e05c55b20db1e4080");
INSERT INTO products VALUES("88adde97d0c9ebbb55b899bae9925","SP2015","SecondPRoduct","2","","258c6c0a86c7882c55b74f6d910de","288.jpg","50","2015-07-29 11:15:38","2015-07-30 18:40:59","981227f13dd8e05c55b20db1e4080");
INSERT INTO products VALUES("970f1566a9b0650d55b8f32df282e","21","Another One","12","","5fe939605c2dea2a55b74f385292f","288.jpg","12","2015-07-29 17:37:17","","981227f13dd8e05c55b20db1e4080");
INSERT INTO products VALUES("bb9337a3559ee61555bf7a046e8cb","tagSubCat","First Product with tagsSubcategory","100","","258c6c0a86c7882c55b74f6d910de","Avon_Outspoken_Fergie_1.jpg","20","2015-08-03 16:26:12","","981227f13dd8e05c55b20db1e4080");
INSERT INTO products VALUES("f6633434a6dea60655c085962e2c6","TP","Test product","100","","5fe939605c2dea2a55b74f385292f","Avon_Outspoken_Fergie_1.jpg","100","2015-08-04 11:27:50","2015-08-04 11:31:30","981227f13dd8e05c55b20db1e4080");
INSERT INTO products VALUES("f6ec7b87e92122f155c084eb67fcb","discount","Product with discount","100","","258c6c0a86c7882c55b74f6d910de","perfumy-celebre-avon-25-zl.jpg","20","2015-08-04 11:24:59","2015-08-26 16:28:45","981227f13dd8e05c55b20db1e4080");
INSERT INTO products VALUES("f7379b6dc378987055c0851e4bc83","without discount","Product without discount","100","","5fe939605c2dea2a55b74f385292f","288.jpg","10","2015-08-04 11:25:50","","981227f13dd8e05c55b20db1e4080");



DROP TABLE purchase_product;

CREATE TABLE `purchase_product` (
  `product_id` varchar(50) NOT NULL,
  `purchase_id` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_amount` float NOT NULL,
  `discount` float DEFAULT NULL,
  `send_alert` tinyint(1) DEFAULT NULL,
  `discount_type` varchar(40) NOT NULL DEFAULT '%',
  PRIMARY KEY (`purchase_id`,`product_id`),
  KEY `fk_purchase_product_products1_idx` (`product_id`),
  KEY `fk_purchase_product_purchases1_idx` (`purchase_id`),
  CONSTRAINT `fk_purchase_product_products1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_purchase_product_purchases1` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`purchase_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","16a57e1537062ea755c48a239a981","20","200","0","1","%");
INSERT INTO purchase_product VALUES("2ab5e4295819fdfa55b8f4906ed04","1c786016e8140e6855c082aa6f55b","10","0","12441","0","USD");
INSERT INTO purchase_product VALUES("6a14236e6369a9e555b8f2bb8cf49","1c786016e8140e6855c082aa6f55b","32","384","0","0","%");
INSERT INTO purchase_product VALUES("bb9337a3559ee61555bf7a046e8cb","2f8800d01faf9be155c48a1026afe","2","200","0","1","%");
INSERT INTO purchase_product VALUES("f6ec7b87e92122f155c084eb67fcb","2f8800d01faf9be155c48a1026afe","12","1200","0","1","%");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","304a28096b2a4df455fae72110258","21","210","","","");
INSERT INTO purchase_product VALUES("2ab5e4295819fdfa55b8f4906ed04","39620c2037913fb355ca13017bb4c","66","9372","0","0","%");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","3da2223e249e105f560a7b78102eb","10","85","15","0","USD");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","3f207e7bd97ca75655db30c864550","2","20","","","");
INSERT INTO purchase_product VALUES("970f1566a9b0650d55b8f32df282e","46e3762796a53f1455ce07e58c40e","12","144","0","1","%");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","4cf8721942763488560d56a678ad1","10","100","","1","");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","509cd3c14e9cac96560d2060eed49","10","90","10","0","USD");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","52fbe5f924918bd755cc7badb437a","1","10","","","");
INSERT INTO purchase_product VALUES("2ab5e4295819fdfa55b8f4906ed04","52fbe5f924918bd755cc7badb437a","2","284","","","");
INSERT INTO purchase_product VALUES("bb9337a3559ee61555bf7a046e8cb","559c8a21fc34973255fae6d175289","1","100","","0","");
INSERT INTO purchase_product VALUES("2ab5e4295819fdfa55b8f4906ed04","578c4c0e07c98df555e87e357df48","141","20022","","","");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","5c1ea28168f635ec55db05c7c283f","12","120","0","1","%");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","5f39d5c851c6720b55cb7bc289291","5","50","","","");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","6bec1950f4315651560a7b3723b45","10","90","10","0","%");
INSERT INTO purchase_product VALUES("bb9337a3559ee61555bf7a046e8cb","6d47e374a95c75ba55e87d8be751e","1","100","","","");
INSERT INTO purchase_product VALUES("f6ec7b87e92122f155c084eb67fcb","6e7adb0725d9ac2755c09dbe3ca61","100","5500","","","");
INSERT INTO purchase_product VALUES("f6ec7b87e92122f155c084eb67fcb","71afec5cbcd589f255c0a0145c947","100","5500","","","");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","8119c5f28ccf9df655fae76de1b12","10","100","","","");
INSERT INTO purchase_product VALUES("3bac9b0f5759bed355bb4339d0611","814f65d1f7db937255c096cd47a62","10","1000","","","");
INSERT INTO purchase_product VALUES("f6ec7b87e92122f155c084eb67fcb","814f65d1f7db937255c096cd47a62","10","550","","","");
INSERT INTO purchase_product VALUES("f7379b6dc378987055c0851e4bc83","814f65d1f7db937255c096cd47a62","20","2000","","","");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","821495a34e9e954155cddef42f41b","2","20","0","0","%");
INSERT INTO purchase_product VALUES("bb9337a3559ee61555bf7a046e8cb","8550ee0f0547d2ae55db21dcc3276","21","2100","","","");
INSERT INTO purchase_product VALUES("f7379b6dc378987055c0851e4bc83","8d6861a4d8f3cd9255db22035c1f4","21","2100","","","");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","9274ceeb78b4dead55db207a3443c","213","2130","","","");
INSERT INTO purchase_product VALUES("bb9337a3559ee61555bf7a046e8cb","92f65b1c070cf8d555ed9b1fad2d3","3","300","","","");
INSERT INTO purchase_product VALUES("970f1566a9b0650d55b8f32df282e","95a14358f30c1f5255db07ca20ef5","100","1200","0","1","%");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","99ef550d08bf521d55db1e646b3a1","123","1230","","","");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","9ced0cad3edf832855e4643bc4d5d","100","1000","","","");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","a20e12ba9be9e88c55d1d50c052ad","1","10","","","");
INSERT INTO purchase_product VALUES("2ab5e4295819fdfa55b8f4906ed04","a612bde13d2be83855c084722b6c7","10","1420","","","");
INSERT INTO purchase_product VALUES("970f1566a9b0650d55b8f32df282e","a612bde13d2be83855c084722b6c7","5","60","","","");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","ab6440cdb3969d6255c0d3624360e","9","90","","","");
INSERT INTO purchase_product VALUES("3bac9b0f5759bed355bb4339d0611","b1b94194d22bb5bb55c09754be6c9","10","1000","","","");
INSERT INTO purchase_product VALUES("f6ec7b87e92122f155c084eb67fcb","b1b94194d22bb5bb55c09754be6c9","100","5500","","","");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","b29b9f8a2a9bac8e55c098a990ed1","10","100","","","");
INSERT INTO purchase_product VALUES("3bac9b0f5759bed355bb4339d0611","b29b9f8a2a9bac8e55c098a990ed1","10","1000","","","");
INSERT INTO purchase_product VALUES("3f26ad27e26b456355bf8443c883f","b29b9f8a2a9bac8e55c098a990ed1","10","100","","","");
INSERT INTO purchase_product VALUES("6a14236e6369a9e555b8f2bb8cf49","b29b9f8a2a9bac8e55c098a990ed1","100","1200","","","");
INSERT INTO purchase_product VALUES("88adde97d0c9ebbb55b899bae9925","b29b9f8a2a9bac8e55c098a990ed1","100","200","","","");
INSERT INTO purchase_product VALUES("f7379b6dc378987055c0851e4bc83","b29b9f8a2a9bac8e55c098a990ed1","10","1000","","","");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","be1ebec6c3511e0055d37031e3e03","12","120","","","");
INSERT INTO purchase_product VALUES("970f1566a9b0650d55b8f32df282e","be1ebec6c3511e0055d37031e3e03","1","12","","","");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","c3a7a0b28a92141555c09924aacdc","103","1030","","","");
INSERT INTO purchase_product VALUES("f6ec7b87e92122f155c084eb67fcb","c3a7a0b28a92141555c09924aacdc","100","5500","","","");
INSERT INTO purchase_product VALUES("bb9337a3559ee61555bf7a046e8cb","c824eb6ed4d6197e55d713bc88cf7","1","100","","","");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","d3df776959c778de562e5e3fc05f0","3","30","0","0","%");
INSERT INTO purchase_product VALUES("2ab5e4295819fdfa55b8f4906ed04","d3df776959c778de562e5e3fc05f0","12","1704","0","0","%");
INSERT INTO purchase_product VALUES("3bac9b0f5759bed355bb4339d0611","d943115335bbc0df55c097aa15285","10","1000","","","");
INSERT INTO purchase_product VALUES("3f26ad27e26b456355bf8443c883f","d943115335bbc0df55c097aa15285","10","100","","","");
INSERT INTO purchase_product VALUES("f7379b6dc378987055c0851e4bc83","d943115335bbc0df55c097aa15285","100","10000","","","");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","df3b4c2784bedcd455e71af99b716","10","100","","","");
INSERT INTO purchase_product VALUES("3f26ad27e26b456355bf8443c883f","e07d8f931b5c76d455fae7aa3ca3c","10","100","","","");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","e515dc4d8a65bd2e55d1d3f17467e","1","10","","","");
INSERT INTO purchase_product VALUES("6d37a583c8f091f555cdd092b45ee","e6615eaea9841ca755db307976e46","12","144","","","");
INSERT INTO purchase_product VALUES("3bac9b0f5759bed355bb4339d0611","e76d2eb30f761ca055db305685113","123","12300","","","");
INSERT INTO purchase_product VALUES("2ab5e4295819fdfa55b8f4906ed04","ed7a7e69c4b7b5fb55c8b2f63c9a7","1","142","","","");
INSERT INTO purchase_product VALUES("214697327796ed4155b898dd8c05f","fdf8b66ef6e4d59c55e5d7ebc481d","1000","10000","","","");



DROP TABLE purchase_statuses;

CREATE TABLE `purchase_statuses` (
  `status_id` varchar(50) NOT NULL,
  `purchase_id` varchar(50) NOT NULL,
  `status` enum('contact','purchase','delivery') NOT NULL,
  `status_date` datetime NOT NULL,
  PRIMARY KEY (`status_id`),
  KEY `purchase_id` (`purchase_id`),
  CONSTRAINT `purchase_statuses_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`purchase_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO purchase_statuses VALUES("00271e3b9a59844b560d61e33c96c","46e3762796a53f1455ce07e58c40e","delivery","2015-10-01 18:40:03");
INSERT INTO purchase_statuses VALUES("05e1f2d6c85051fd5603fed3e3af4","52fbe5f924918bd755cc7badb437a","delivery","2015-09-24 15:46:59");
INSERT INTO purchase_statuses VALUES("0c422546d7fb2d395617f849a50eb","39620c2037913fb355ca13017bb4c","purchase","2015-10-09 19:24:25");
INSERT INTO purchase_statuses VALUES("0d0bf5a27b2d1900560d5f8076989","39620c2037913fb355ca13017bb4c","purchase","2015-10-01 18:29:52");
INSERT INTO purchase_statuses VALUES("0d380d13edbbe6d8560d6069a5379","52fbe5f924918bd755cc7badb437a","purchase","2015-10-01 18:33:45");
INSERT INTO purchase_statuses VALUES("0fe0bccf2c7b9656560d20614c0e2","509cd3c14e9cac96560d2060eed49","purchase","2015-10-01 14:00:33");
INSERT INTO purchase_statuses VALUES("1114","46e3762796a53f1455ce07e58c40e","purchase","2015-08-14 17:23:17");
INSERT INTO purchase_statuses VALUES("1175","c824eb6ed4d6197e55d713bc88cf7","purchase","2015-08-21 14:04:12");
INSERT INTO purchase_statuses VALUES("1227","e76d2eb30f761ca055db305685113","purchase","2015-08-24 16:55:18");
INSERT INTO purchase_statuses VALUES("1356","16a57e1537062ea755c48a239a981","purchase","2015-07-09 13:04:21");
INSERT INTO purchase_statuses VALUES("1437","6d47e374a95c75ba55e87d8be751e","purchase","2015-09-03 19:04:12");
INSERT INTO purchase_statuses VALUES("1666","c3a7a0b28a92141555c09924aacdc","purchase","2015-08-16 13:19:19");
INSERT INTO purchase_statuses VALUES("16b893b773cf92e8560d5f5a591ac","39620c2037913fb355ca13017bb4c","delivery","2015-10-01 18:29:14");
INSERT INTO purchase_statuses VALUES("1896","fdf8b66ef6e4d59c55e5d7ebc481d","purchase","2015-09-01 18:53:00");
INSERT INTO purchase_statuses VALUES("1c23a2853e58d952560d527c20d8a","1c786016e8140e6855c082aa6f55b","purchase","2015-10-01 17:34:20");
INSERT INTO purchase_statuses VALUES("1c7a7d699d80375e560d60607d46e","52fbe5f924918bd755cc7badb437a","delivery","2015-10-01 18:33:36");
INSERT INTO purchase_statuses VALUES("1ece25a598fbd802563213a193aba","2f8800d01faf9be155c48a1026afe","delivery","2015-10-29 13:40:01");
INSERT INTO purchase_statuses VALUES("2352","be1ebec6c3511e0055d37031e3e03","purchase","2015-08-18 19:49:38");
INSERT INTO purchase_statuses VALUES("256","df3b4c2784bedcd455e71af99b716","purchase","2015-09-02 17:51:21");
INSERT INTO purchase_statuses VALUES("2757","52fbe5f924918bd755cc7badb437a","purchase","2015-08-13 13:12:46");
INSERT INTO purchase_statuses VALUES("2af350a78a5a4d5a5600180ff40b3","3f207e7bd97ca75655db30c864550","contact","2015-09-21 16:45:35");
INSERT INTO purchase_statuses VALUES("2e870bd4fde3f46255ffeb2d2c87a","92f65b1c070cf8d555ed9b1fad2d3","contact","2015-09-21 13:34:05");
INSERT INTO purchase_statuses VALUES("300","e6615eaea9841ca755db307976e46","purchase","2015-08-24 16:55:53");
INSERT INTO purchase_statuses VALUES("30eeacf95df77448563212e74a88f","95a14358f30c1f5255db07ca20ef5","purchase","2015-10-29 13:36:55");
INSERT INTO purchase_statuses VALUES("3176","9274ceeb78b4dead55db207a3443c","purchase","2015-08-24 15:47:38");
INSERT INTO purchase_statuses VALUES("33223829d38bf034560d5f3009bf4","1c786016e8140e6855c082aa6f55b","delivery","2015-10-01 18:28:32");
INSERT INTO purchase_statuses VALUES("3331","b29b9f8a2a9bac8e55c098a990ed1","purchase","2015-09-21 11:57:26");
INSERT INTO purchase_statuses VALUES("3334","578c4c0e07c98df555e87e357df48","purchase","2015-09-03 19:07:01");
INSERT INTO purchase_statuses VALUES("3391","e515dc4d8a65bd2e55d1d3f17467e","purchase","2015-08-17 14:30:41");
INSERT INTO purchase_statuses VALUES("341","559c8a21fc34973255fae6d175289","purchase","2015-09-17 18:14:09");
INSERT INTO purchase_statuses VALUES("3414","ab6440cdb3969d6255c0d3624360e","purchase","2015-08-25 13:18:23");
INSERT INTO purchase_statuses VALUES("35b652edeab904c0560d5e137a310","1c786016e8140e6855c082aa6f55b","purchase","2015-10-01 18:23:47");
INSERT INTO purchase_statuses VALUES("3728","39620c2037913fb355ca13017bb4c","purchase","2015-08-11 17:21:37");
INSERT INTO purchase_statuses VALUES("38def0e8bb51ed9e560d5ead00149","1c786016e8140e6855c082aa6f55b","contact","2015-10-01 18:26:20");
INSERT INTO purchase_statuses VALUES("3b8250f3866f5cd0562f97ab04065","46e3762796a53f1455ce07e58c40e","delivery","2015-10-27 16:26:35");
INSERT INTO purchase_statuses VALUES("4079","a612bde13d2be83855c084722b6c7","purchase","2015-08-12 13:17:51");
INSERT INTO purchase_statuses VALUES("4180","6e7adb0725d9ac2755c09dbe3ca61","purchase","2015-08-02 13:13:51");
INSERT INTO purchase_statuses VALUES("469c573b141bdf0c562e5e40ec2d8","d3df776959c778de562e5e3fc05f0","purchase","2015-10-26 18:09:20");
INSERT INTO purchase_statuses VALUES("4735","b1b94194d22bb5bb55c09754be6c9","purchase","2015-08-21 13:18:59");
INSERT INTO purchase_statuses VALUES("486","8550ee0f0547d2ae55db21dcc3276","purchase","2015-08-24 15:53:33");
INSERT INTO purchase_statuses VALUES("4bee1d58fba62b84560d1f1badf79","1c786016e8140e6855c082aa6f55b","purchase","2015-10-01 13:55:07");
INSERT INTO purchase_statuses VALUES("4c0072e16a9d2928560d5f26c1269","1c786016e8140e6855c082aa6f55b","contact","2015-10-01 18:28:22");
INSERT INTO purchase_statuses VALUES("4ceb8616e2895bda562f57f84f0e8","304a28096b2a4df455fae72110258","purchase","2015-10-27 11:54:48");
INSERT INTO purchase_statuses VALUES("4dd9c7ffde7ff7f8560d6084e6afa","1c786016e8140e6855c082aa6f55b","delivery","2015-10-01 18:34:12");
INSERT INTO purchase_statuses VALUES("4e9fbf461406542156165f9ab63c3","1c786016e8140e6855c082aa6f55b","purchase","2015-10-08 14:20:42");
INSERT INTO purchase_statuses VALUES("5071","95a14358f30c1f5255db07ca20ef5","purchase","2015-08-24 14:02:18");
INSERT INTO purchase_statuses VALUES("5135","ed7a7e69c4b7b5fb55c8b2f63c9a7","purchase","2015-08-10 16:19:34");
INSERT INTO purchase_statuses VALUES("5547","5c1ea28168f635ec55db05c7c283f","purchase","2015-08-24 13:53:43");
INSERT INTO purchase_statuses VALUES("56a375c5bd04909b560d60454a36a","821495a34e9e954155cddef42f41b","delivery","2015-10-01 18:33:09");
INSERT INTO purchase_statuses VALUES("591578d014c029455617f8f9a1ec2","39620c2037913fb355ca13017bb4c","purchase","2015-10-09 19:27:21");
INSERT INTO purchase_statuses VALUES("5bf0953b6ce3c97b562e5e848ce5f","d3df776959c778de562e5e3fc05f0","purchase","2015-10-26 18:10:28");
INSERT INTO purchase_statuses VALUES("6489","71afec5cbcd589f255c0a0145c947","purchase","2015-09-21 11:57:40");
INSERT INTO purchase_statuses VALUES("673518232c18d37c5632138cd85d5","16a57e1537062ea755c48a239a981","delivery","2015-10-29 13:39:40");
INSERT INTO purchase_statuses VALUES("6874","9ced0cad3edf832855e4643bc4d5d","purchase","2015-08-31 16:27:08");
INSERT INTO purchase_statuses VALUES("6b77e159ce240914560d65102c9da","559c8a21fc34973255fae6d175289","purchase","2015-10-01 18:53:36");
INSERT INTO purchase_statuses VALUES("7636","5f39d5c851c6720b55cb7bc289291","purchase","2015-08-12 19:00:50");
INSERT INTO purchase_statuses VALUES("776","d943115335bbc0df55c097aa15285","purchase","2015-08-07 13:19:45");
INSERT INTO purchase_statuses VALUES("778b65f9a2f1dbef5632129822449","16a57e1537062ea755c48a239a981","purchase","2015-10-29 13:35:36");
INSERT INTO purchase_statuses VALUES("7794","821495a34e9e954155cddef42f41b","purchase","2015-08-14 14:28:36");
INSERT INTO purchase_statuses VALUES("7a2cff34754f59985617f85edf004","39620c2037913fb355ca13017bb4c","purchase","2015-10-09 19:24:46");
INSERT INTO purchase_statuses VALUES("8034","304a28096b2a4df455fae72110258","purchase","2015-09-17 18:15:29");
INSERT INTO purchase_statuses VALUES("810e525ff78fff65560d60fccd7e7","559c8a21fc34973255fae6d175289","delivery","2015-10-01 18:36:12");
INSERT INTO purchase_statuses VALUES("81b65856581fc5be5603e9904ae08","8550ee0f0547d2ae55db21dcc3276","contact","2015-09-24 14:16:16");
INSERT INTO purchase_statuses VALUES("8437","99ef550d08bf521d55db1e646b3a1","purchase","2015-08-24 15:38:44");
INSERT INTO purchase_statuses VALUES("8590","1c786016e8140e6855c082aa6f55b","purchase","2015-08-07 13:04:39");
INSERT INTO purchase_statuses VALUES("8780","2f8800d01faf9be155c48a1026afe","purchase","2015-08-06 13:05:45");
INSERT INTO purchase_statuses VALUES("8851","e07d8f931b5c76d455fae7aa3ca3c","purchase","2015-09-17 18:17:46");
INSERT INTO purchase_statuses VALUES("8940","92f65b1c070cf8d555ed9b1fad2d3","purchase","2015-09-07 16:11:44");
INSERT INTO purchase_statuses VALUES("8947","8d6861a4d8f3cd9255db22035c1f4","purchase","2015-08-24 15:54:11");
INSERT INTO purchase_statuses VALUES("8960","a20e12ba9be9e88c55d1d50c052ad","purchase","2015-08-17 14:35:24");
INSERT INTO purchase_statuses VALUES("8c0ead7eafcd1920560d60d43487a","578c4c0e07c98df555e87e357df48","purchase","2015-10-01 18:35:32");
INSERT INTO purchase_statuses VALUES("8c94ef0d60c1cd7e560a7b377f15e","6bec1950f4315651560a7b3723b45","purchase","2015-09-29 13:51:19");
INSERT INTO purchase_statuses VALUES("8e72fdd95680aea35628eec5a9e07","304a28096b2a4df455fae72110258","delivery","2015-10-22 16:12:21");
INSERT INTO purchase_statuses VALUES("905","3f207e7bd97ca75655db30c864550","purchase","2015-08-24 16:57:12");
INSERT INTO purchase_statuses VALUES("9462","814f65d1f7db937255c096cd47a62","purchase","2015-08-04 13:17:10");
INSERT INTO purchase_statuses VALUES("95ee593b7d578489560d56c552a91","4cf8721942763488560d56a678ad1","delivery","2015-10-01 17:52:37");
INSERT INTO purchase_statuses VALUES("95f9b783413c24f4560d60a946fae","1c786016e8140e6855c082aa6f55b","purchase","2015-10-01 18:34:49");
INSERT INTO purchase_statuses VALUES("9806","8119c5f28ccf9df655fae76de1b12","purchase","2015-09-17 18:16:46");
INSERT INTO purchase_statuses VALUES("a17e5367bd3bbfae560d56a6c5998","4cf8721942763488560d56a678ad1","purchase","2015-10-01 17:52:06");
INSERT INTO purchase_statuses VALUES("a2b2f55c8386b70b560d55553bff5","e07d8f931b5c76d455fae7aa3ca3c","delivery","2015-10-01 17:46:29");
INSERT INTO purchase_statuses VALUES("a444aa325e53c5c8560010b835067","1c786016e8140e6855c082aa6f55b","delivery","2015-09-21 16:14:16");
INSERT INTO purchase_statuses VALUES("a51990ee337b566c560d61d6aa1bb","559c8a21fc34973255fae6d175289","delivery","2015-10-01 18:39:50");
INSERT INTO purchase_statuses VALUES("a998a30485a16e69560d62de6ffd1","3da2223e249e105f560a7b78102eb","delivery","2015-10-01 18:44:14");
INSERT INTO purchase_statuses VALUES("a9ce2fb88ed93a3a560d5f4ecc7b7","1c786016e8140e6855c082aa6f55b","contact","2015-10-01 18:29:02");
INSERT INTO purchase_statuses VALUES("ac90bf475e0123fa560a735a48657","304a28096b2a4df455fae72110258","contact","2015-09-29 13:17:46");
INSERT INTO purchase_statuses VALUES("b0016d24fe7e8c09560d5fc5e0bd2","52fbe5f924918bd755cc7badb437a","contact","2015-10-01 18:31:01");
INSERT INTO purchase_statuses VALUES("b21b9ec796456f4456167938049b4","1c786016e8140e6855c082aa6f55b","purchase","2015-10-08 16:10:00");
INSERT INTO purchase_statuses VALUES("b24c90c7f3b0fb6a5601501838508","3f207e7bd97ca75655db30c864550","purchase","2015-09-22 14:56:56");
INSERT INTO purchase_statuses VALUES("b83342aac0eeaecc56014ff9b9c83","3f207e7bd97ca75655db30c864550","purchase","2015-09-22 14:56:25");
INSERT INTO purchase_statuses VALUES("c4e54f06277866205644afe40f8f5","92f65b1c070cf8d555ed9b1fad2d3","delivery","2015-11-12 16:27:32");
INSERT INTO purchase_statuses VALUES("c786f924d9185388560d60bfcec65","578c4c0e07c98df555e87e357df48","delivery","2015-10-01 18:35:11");
INSERT INTO purchase_statuses VALUES("c89c0de4fcbec02f5632127e0f511","16a57e1537062ea755c48a239a981","delivery","2015-10-29 13:35:10");
INSERT INTO purchase_statuses VALUES("ca2d6d428ff5ce20563212d28a5b8","5c1ea28168f635ec55db05c7c283f","purchase","2015-10-29 13:36:34");
INSERT INTO purchase_statuses VALUES("cac1878feb6fee91562f5586b202d","1c786016e8140e6855c082aa6f55b","delivery","2015-10-27 11:44:22");
INSERT INTO purchase_statuses VALUES("ceca8f554b7505ad562f9790d571b","46e3762796a53f1455ce07e58c40e","purchase","2015-10-27 16:26:08");
INSERT INTO purchase_statuses VALUES("dd1b8e34fe35b8625616602142626","1c786016e8140e6855c082aa6f55b","purchase","2015-10-08 14:22:57");
INSERT INTO purchase_statuses VALUES("e04fdfbb2ef03232563213b3bcac1","5c1ea28168f635ec55db05c7c283f","delivery","2015-10-29 13:40:19");
INSERT INTO purchase_statuses VALUES("e12def5d3c7ca892560d63161b650","3f207e7bd97ca75655db30c864550","delivery","2015-10-01 18:45:10");
INSERT INTO purchase_statuses VALUES("e15d1d2cee7cd917560d5fa6314e9","4cf8721942763488560d56a678ad1","contact","2015-10-01 18:30:30");
INSERT INTO purchase_statuses VALUES("f208369cd35020b0560d5e6f03c0d","1c786016e8140e6855c082aa6f55b","contact","2015-10-01 18:25:19");
INSERT INTO purchase_statuses VALUES("f399a067614c9d35563212bb79843","2f8800d01faf9be155c48a1026afe","purchase","2015-10-29 13:36:11");
INSERT INTO purchase_statuses VALUES("f3f7511819d3784f563213c44333b","95a14358f30c1f5255db07ca20ef5","delivery","2015-10-29 13:40:36");
INSERT INTO purchase_statuses VALUES("f44c0d8696e3c17b563739cb1b23c","821495a34e9e954155cddef42f41b","purchase","2015-11-02 11:24:11");
INSERT INTO purchase_statuses VALUES("f9239cca4963a8d4560a7b782eeac","3da2223e249e105f560a7b78102eb","purchase","2015-09-29 13:52:24");



DROP TABLE purchases;

CREATE TABLE `purchases` (
  `purchase_id` varchar(50) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `discount` float DEFAULT '0',
  `discount_type` varchar(40) NOT NULL DEFAULT '%',
  `brochure_id` varchar(50) DEFAULT NULL,
  `sum` float NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`purchase_id`),
  KEY `fk_purchases_clients1_idx` (`client_id`),
  KEY `fk_purchases_brochures1_idx` (`brochure_id`),
  KEY `fk_purchases_users1_idx` (`user_id`),
  CONSTRAINT `fk_purchases_brochures1` FOREIGN KEY (`brochure_id`) REFERENCES `brochures` (`brochure_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_purchases_clients1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_purchases_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO purchases VALUES("16a57e1537062ea755c48a239a981","cf0968de15993b0355c377b21c8f7","1","%","2accbd40485254d655ba0927413d7","198","2015-08-07 12:36:19","2015-10-29 13:35:35","51b467eb84c744c655b2462eb672e");
INSERT INTO purchases VALUES("1c786016e8140e6855c082aa6f55b","ade8b5b8e1b5616c55b61a8a5d511","12","Euro","2accbd40485254d655ba0927413d7","372","2015-08-04 11:15:22","2015-10-08 16:09:59","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("2f8800d01faf9be155c48a1026afe","cf0968de15993b0355c377b21c8f7","0","%","9c17088f5452ece755ba494093474","1400","2015-08-07 12:36:00","2015-10-29 13:36:10","51b467eb84c744c655b2462eb672e");
INSERT INTO purchases VALUES("304a28096b2a4df455fae72110258","290c513dd097b9db55c377cf2749a","0","","8a7886b184064a4d55e6e5efa4b30","210","2015-09-17 18:15:29","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("39620c2037913fb355ca13017bb4c","ade8b5b8e1b5616c55b61a8a5d511","10000000","Euro","2accbd40485254d655ba0927413d7","0","2015-08-11 17:21:37","2015-10-09 19:27:21","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("3da2223e249e105f560a7b78102eb","56d94c2a4215d0e555ce07e597120","","","31855761e7ecbf3155e09eae77d22","85","2015-09-29 13:52:24","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("3f207e7bd97ca75655db30c864550","adb78387d20fbff955db305687958","0","","2accbd40485254d655ba0927413d7","20","2015-08-24 16:57:12","2015-09-22 14:56:55","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("46e3762796a53f1455ce07e58c40e","56d94c2a4215d0e555ce07e597120","0","%","2accbd40485254d655ba0927413d7","144","2015-08-14 17:23:17","2015-10-27 16:26:08","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("4cf8721942763488560d56a678ad1","ba955170f922425f560d56a67ad10","0","%","2accbd40485254d655ba0927413d7","100","2015-10-01 17:52:06","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("509cd3c14e9cac96560d2060eed49","3c37c92fa4dc8e9255c8b1697a16c","0","%","5f97c706fadae9b255e09ae83d747","90","2015-10-01 14:00:32","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("52fbe5f924918bd755cc7badb437a","47b7114868fe482655c3721aea86b","2","","2accbd40485254d655ba0927413d7","288.12","2015-08-13 13:12:45","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("559c8a21fc34973255fae6d175289","290c513dd097b9db55c377cf2749a","0","%","8a7886b184064a4d55e6e5efa4b30","100","2015-09-17 18:14:09","2015-10-01 18:53:36","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("578c4c0e07c98df555e87e357df48","290c513dd097b9db55c377cf2749a","0","","2accbd40485254d655ba0927413d7","20022","2015-09-03 19:07:01","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("5c1ea28168f635ec55db05c7c283f","3a359edea833da0f55d1d50c0f981","0","%","2accbd40485254d655ba0927413d7","120","2015-08-24 13:53:43","2015-10-29 13:36:33","51b467eb84c744c655b2462eb672e");
INSERT INTO purchases VALUES("5f39d5c851c6720b55cb7bc289291","290c513dd097b9db55c377cf2749a","4","","9c17088f5452ece755ba494093474","48","2015-08-12 19:00:50","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("6bec1950f4315651560a7b3723b45","56d94c2a4215d0e555ce07e597120","","","2accbd40485254d655ba0927413d7","90","2015-09-29 13:51:19","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("6d47e374a95c75ba55e87d8be751e","3a359edea833da0f55d1d50c0f981","0","","5f97c706fadae9b255e09ae83d747","100","2015-09-03 19:04:11","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("6e7adb0725d9ac2755c09dbe3ca61","47b7114868fe482655c3721aea86b","10","","2accbd40485254d655ba0927413d7","4950","2015-08-04 13:10:54","2015-08-07 13:15:47","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("71afec5cbcd589f255c0a0145c947","47b7114868fe482655c3721aea86b","10","","2accbd40485254d655ba0927413d7","4950","2015-08-04 13:20:52","2015-09-21 11:57:40","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("8119c5f28ccf9df655fae76de1b12","cf0968de15993b0355c377b21c8f7","0","","5f97c706fadae9b255e09ae83d747","100","2015-09-17 18:16:45","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("814f65d1f7db937255c096cd47a62","d072932adcfb721355b61a382505f","","","2accbd40485254d655ba0927413d7","3550","2015-08-04 12:41:17","2015-08-07 13:17:31","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("821495a34e9e954155cddef42f41b","f91548acefa0a84755c24787571ec","10","%","2accbd40485254d655ba0927413d7","18","2015-08-14 14:28:36","2015-11-02 11:24:10","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("8550ee0f0547d2ae55db21dcc3276","d072932adcfb721355b61a382505f","","","2accbd40485254d655ba0927413d7","2100","2015-08-24 15:53:32","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("8d6861a4d8f3cd9255db22035c1f4","d072932adcfb721355b61a382505f","","","2accbd40485254d655ba0927413d7","2100","2015-08-24 15:54:11","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("9274ceeb78b4dead55db207a3443c","3a359edea833da0f55d1d50c0f981","","","2accbd40485254d655ba0927413d7","2130","2015-08-24 15:47:38","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("92f65b1c070cf8d555ed9b1fad2d3","cf0968de15993b0355c377b21c8f7","0","","31855761e7ecbf3155e09eae77d22","300","2015-09-07 16:11:43","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("95a14358f30c1f5255db07ca20ef5","ade8b5b8e1b5616c55b61a8a5d511","0","%","2accbd40485254d655ba0927413d7","1200","2015-08-24 14:02:18","2015-10-29 13:36:54","51b467eb84c744c655b2462eb672e");
INSERT INTO purchases VALUES("99ef550d08bf521d55db1e646b3a1","290c513dd097b9db55c377cf2749a","","","2accbd40485254d655ba0927413d7","1230","2015-08-24 15:38:44","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("9ced0cad3edf832855e4643bc4d5d","ade8b5b8e1b5616c55b61a8a5d511","0","","31855761e7ecbf3155e09eae77d22","1000","2015-08-31 16:27:07","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("a20e12ba9be9e88c55d1d50c052ad","3a359edea833da0f55d1d50c0f981","","","9c17088f5452ece755ba494093474","10","2015-08-17 14:35:24","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("a612bde13d2be83855c084722b6c7","ade8b5b8e1b5616c55b61a8a5d511","","","2accbd40485254d655ba0927413d7","1480","2015-08-04 11:22:58","2015-08-07 13:18:14","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("ab6440cdb3969d6255c0d3624360e","47b7114868fe482655c3721aea86b","","","2accbd40485254d655ba0927413d7","90","2015-08-04 16:59:46","2015-08-07 13:18:23","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("b1b94194d22bb5bb55c09754be6c9","290c513dd097b9db55c377cf2749a","","","9c17088f5452ece755ba494093474","6500","2015-08-04 12:43:32","2015-08-07 13:18:58","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("b29b9f8a2a9bac8e55c098a990ed1","d072932adcfb721355b61a382505f","0","","2accbd40485254d655ba0927413d7","3600","2015-08-04 12:49:13","2015-09-21 11:57:26","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("be1ebec6c3511e0055d37031e3e03","290c513dd097b9db55c377cf2749a","","","2accbd40485254d655ba0927413d7","132","2015-08-18 19:49:37","","51b467eb84c744c655b2462eb672e");
INSERT INTO purchases VALUES("c3a7a0b28a92141555c09924aacdc","e0ddbf56e3fcad6255c372a8b7caf","10","","2accbd40485254d655ba0927413d7","5877","2015-08-04 12:51:16","2015-08-07 13:19:18","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("c824eb6ed4d6197e55d713bc88cf7","290c513dd097b9db55c377cf2749a","","","2accbd40485254d655ba0927413d7","100","2015-08-21 14:04:12","2015-08-21 16:34:19","51b467eb84c744c655b2462eb672e");
INSERT INTO purchases VALUES("d3df776959c778de562e5e3fc05f0","290c513dd097b9db55c377cf2749a","10","%","2accbd40485254d655ba0927413d7","1560.6","2015-10-26 18:09:19","2015-10-26 18:10:27","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("d943115335bbc0df55c097aa15285","47b7114868fe482655c3721aea86b","","","2accbd40485254d655ba0927413d7","11100","2015-08-04 12:44:58","2015-08-07 13:35:05","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("df3b4c2784bedcd455e71af99b716","290c513dd097b9db55c377cf2749a","0","","19e23782b6197e4555e6eb541f69b","100","2015-09-02 17:51:21","","51b467eb84c744c655b2462eb672e");
INSERT INTO purchases VALUES("e07d8f931b5c76d455fae7aa3ca3c","e0ddbf56e3fcad6255c372a8b7caf","0","","5f97c706fadae9b255e09ae83d747","100","2015-09-17 18:17:46","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("e515dc4d8a65bd2e55d1d3f17467e","ade8b5b8e1b5616c55b61a8a5d511","","","9c17088f5452ece755ba494093474","10","2015-08-17 14:30:41","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("e6615eaea9841ca755db307976e46","adb78387d20fbff955db305687958","","","2accbd40485254d655ba0927413d7","144","2015-08-24 16:55:53","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("e76d2eb30f761ca055db305685113","adb78387d20fbff955db305687958","","","9c17088f5452ece755ba494093474","12300","2015-08-24 16:55:18","","8edddc1faba4d40a55b61b0ee684c");
INSERT INTO purchases VALUES("ed7a7e69c4b7b5fb55c8b2f63c9a7","3c37c92fa4dc8e9255c8b1697a16c","10","","2accbd40485254d655ba0927413d7","127.8","2015-08-10 16:19:34","2015-08-10 16:21:38","51b467eb84c744c655b2462eb672e");
INSERT INTO purchases VALUES("fdf8b66ef6e4d59c55e5d7ebc481d","3a359edea833da0f55d1d50c0f981","5","","2accbd40485254d655ba0927413d7","9500","2015-09-01 18:52:59","","8edddc1faba4d40a55b61b0ee684c");



DROP TABLE role_permissions;

CREATE TABLE `role_permissions` (
  `user_role_id` varchar(50) NOT NULL,
  `module` varchar(250) NOT NULL,
  `crud` varchar(4) NOT NULL,
  PRIMARY KEY (`user_role_id`,`module`),
  UNIQUE KEY `user_role_id` (`user_role_id`,`module`),
  CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO role_permissions VALUES("e2def69ae7ed23fe55b614bf5ec9b","clients","1111");



DROP TABLE settings;

CREATE TABLE `settings` (
  `user_id` varchar(50) NOT NULL,
  `date_format` varchar(10) NOT NULL DEFAULT 'd-m-Y',
  `time_format` tinyint(1) NOT NULL DEFAULT '0',
  `language` varchar(5) NOT NULL DEFAULT 'en-US',
  `timezone` varchar(50) NOT NULL DEFAULT 'Europe/Lisbon',
  `currency` varchar(5) NOT NULL DEFAULT 'EUR',
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`),
  KEY `timezone` (`timezone`),
  CONSTRAINT `users_settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO settings VALUES("3018caefc14d65ec56451750c430a","d-m-Y","0","en-US","Europe/Lisbon","EUR");
INSERT INTO settings VALUES("51b467eb84c744c655b2462eb672e","d-m-Y","0","en-US","Europe/Lisbon","USD");
INSERT INTO settings VALUES("81b78d8257c4b7e95628e73c3918d","d-m-Y","0","en-US","Europe/Lisbon","EUR");
INSERT INTO settings VALUES("8edddc1faba4d40a55b61b0ee684c","Y-d-m","0","en-US","Europe/Lisbon","USD");
INSERT INTO settings VALUES("a2d8d27b2028163455b20db206f6d","d-m-Y","0","en-US","Europe/Lisbon","EUR");



DROP TABLE user_account;

CREATE TABLE `user_account` (
  `user_id` varchar(50) NOT NULL,
  `account_id` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`,`account_id`),
  KEY `fk_user_account_account1_idx` (`account_id`),
  CONSTRAINT `fk_user_account_account1` FOREIGN KEY (`account_id`) REFERENCES `account` (`account_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_account_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO user_account VALUES("8edddc1faba4d40a55b61b0ee684c","0dfd0fe1bb4b7c5c55b61b0eacba2");
INSERT INTO user_account VALUES("51b467eb84c744c655b2462eb672e","f5becbe216f19a5655b2462de29d6");



DROP TABLE user_password_resets;

CREATE TABLE `user_password_resets` (
  `id` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `upr_old_password` varchar(250) DEFAULT NULL,
  `upr_token` varchar(250) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `upr_request_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upr_reset_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE user_roles;

CREATE TABLE `user_roles` (
  `id` varchar(50) NOT NULL,
  `company_id` varchar(50) DEFAULT NULL,
  `user_role_name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `company_id_2` (`company_id`),
  CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO user_roles VALUES("e2def69ae7ed23fe55b614bf5ec9b","981227f13dd8e05c55b20db1e4080","Purchaser");



DROP TABLE users;

CREATE TABLE `users` (
  `id` varchar(50) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  `user_photo` varchar(250) DEFAULT NULL,
  `user_photo_crop` varchar(250) DEFAULT NULL,
  `user_photo_cropped` varchar(250) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `user_verified` tinyint(1) DEFAULT NULL,
  `user_auth_key` varchar(50) NOT NULL,
  `user_create_time` datetime NOT NULL,
  `user_update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO users VALUES("3018caefc14d65ec56451750c430a","João","example@example.com","$2y$13$9b3kru0EViTet0/GovSG4OVUHFRt29dqLQRL3z06OV3nlfFD6BxSC","","","","1","0","ARg8Ixi0cn89jvqJe74a6siTfHAgYp1l","2015-11-12 17:22:28","2015-11-13 00:22:27");
INSERT INTO users VALUES("51b467eb84c744c655b2462eb672e","Account 1","a1@avon.com","$2y$13$QNz1sIfvzPOaCd8ZXWYaqOYg6.E5c70KbDjUX7PCAFVj7guvFuKHC","","","","1","0","5Uig6eGZlpdfg_Ku6Q6RfOJtHw0Ppv4K","2015-07-27 06:39:46","2015-07-27 07:39:46");
INSERT INTO users VALUES("81b78d8257c4b7e95628e73c3918d","João","joaopbgmagalhaes@gmail.com","$2y$13$YOvovHmcpkQoGxOXEmaXPOPabOUV31Z5CjPtyZatrY0bPeZ0rtuVu","","","","1","0","oxVok6kq0z8UkPsMRTs9e-9jhnUrLPEy","2015-10-22 15:40:12","");
INSERT INTO users VALUES("8edddc1faba4d40a55b61b0ee684c","Account 2","a2@avon.com","$2y$13$NrgVpyse4Wa3JH7/f/lbKeCjDyI44aRetTb3iv.HYWbadONIfiQjW","","","","1","0","F3PeMT1kuL133SWB7HxbHvPkxxmH95VT","2015-08-31 11:18:19","2015-07-27 07:58:18");
INSERT INTO users VALUES("a2d8d27b2028163455b20db206f6d","AvonUser","avon@avon.com","$2y$13$qMc1K7Bt1kC13d5fxaFL7Ogrk3w1UDg6AAikTInSunjp9l124hTnO","","","","1","1","bIiRkXa45FBAISk82GTey6PFuGufYMGz","2015-07-24 11:20:10","");



