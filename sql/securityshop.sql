SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `security_shop` ;
CREATE SCHEMA IF NOT EXISTS `security_shop` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `security_shop` ;

-- -----------------------------------------------------
-- Table `security_shop`.`roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `security_shop`.`roles` ;

CREATE  TABLE IF NOT EXISTS `security_shop`.`roles` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `security_shop`.`members`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `security_shop`.`members` ;

CREATE  TABLE IF NOT EXISTS `security_shop`.`members` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `role_id` INT(2) NOT NULL ,
  `name` VARCHAR(20) NOT NULL ,
  `lastname` VARCHAR(40) NOT NULL ,
  `email` VARCHAR(40) NOT NULL ,
  `phone` VARCHAR(10) NULL ,
  `login` VARCHAR(30) NOT NULL ,
  `password` VARCHAR(77) NOT NULL ,
  `salt` VARCHAR(32) NOT NULL ,
  `pwd` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_role_id`
    FOREIGN KEY (`role_id` )
    REFERENCES `security_shop`.`roles` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_role_id_idx` ON `security_shop`.`members` (`role_id` ASC) ;


-- -----------------------------------------------------
-- Table `security_shop`.`orders`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `security_shop`.`orders` ;

CREATE  TABLE IF NOT EXISTS `security_shop`.`orders` (
  `order_id` INT NOT NULL AUTO_INCREMENT ,
  `member_id` INT NOT NULL ,
  `datetime` DATETIME NOT NULL ,
  PRIMARY KEY (`order_id`) ,
  CONSTRAINT `fk_member_id`
    FOREIGN KEY (`member_id` )
    REFERENCES `security_shop`.`members` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_member_id_idx` ON `security_shop`.`orders` (`member_id` ASC) ;


-- -----------------------------------------------------
-- Table `security_shop`.`products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `security_shop`.`products` ;

CREATE  TABLE IF NOT EXISTS `security_shop`.`products` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(70) NOT NULL ,
  `description` TEXT NOT NULL ,
  `stock` SMALLINT(6) NOT NULL ,
  `price` DOUBLE NOT NULL ,
  PRIMARY KEY (`id`) );


-- -----------------------------------------------------
-- Table `security_shop`.`order_items`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `security_shop`.`order_items` ;

CREATE  TABLE IF NOT EXISTS `security_shop`.`order_items` (
  `id` INT(10) NOT NULL AUTO_INCREMENT ,
  `order_id` INT(10) NOT NULL ,
  `product_id` INT(10) NOT NULL ,
  `quantity` INT(10) NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_order_id`
    FOREIGN KEY (`order_id` )
    REFERENCES `security_shop`.`orders` (`order_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_id`
    FOREIGN KEY (`product_id` )
    REFERENCES `security_shop`.`products` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_product_id_idx` ON `security_shop`.`order_items` (`product_id` ASC) ;

CREATE INDEX `fk_order_id_idx` ON `security_shop`.`order_items` (`order_id` ASC) ;

USE `security_shop` ;

SET SQL_MODE = '';
GRANT USAGE ON *.* TO shop_admin;
 DROP USER shop_admin;
SET SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';
CREATE USER 'shop_admin' IDENTIFIED BY '123456789';

GRANT CREATE, DELETE, SELECT, UPDATE, INSERT, INDEX, ALTER ON TABLE security_shop.* TO 'shop_admin';
SET SQL_MODE = '';
GRANT USAGE ON *.* TO shop_user;
 DROP USER shop_user;
SET SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';
CREATE USER 'shop_user' IDENTIFIED BY '987654321';

GRANT INSERT, SELECT, UPDATE ON TABLE security_shop.* TO 'shop_user';

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `security_shop`.`roles`
-- -----------------------------------------------------
START TRANSACTION;
USE `security_shop`;
INSERT INTO `security_shop`.`roles` (`id`, `name`) VALUES (1, 'user');
INSERT INTO `security_shop`.`roles` (`id`, `name`) VALUES (2, 'admin');

COMMIT;

-- -----------------------------------------------------
-- Data for table `security_shop`.`members`
-- -----------------------------------------------------
START TRANSACTION;
USE `security_shop`;
INSERT INTO `security_shop`.`members` (`id`, `role_id`, `name`, `lastname`, `email`, `phone`, `login`, `password`, `salt`, `pwd`) VALUES (1, 1, 'David', 'Andresen', 'glorymanutd08@gmail.com', '60878082', 'davand', 'sha256:1000:1hRrzKe6BJ9UdZPgsLR6i9rNX8RuX/ih:5hDVGyss/VeEFezRN/Nwj3jPMdU/y0eQ', '1hRrzKe6BJ9UdZPgsLR6i9rNX8RuX/ih', '0000');
INSERT INTO `security_shop`.`members` (`id`, `role_id`, `name`, `lastname`, `email`, `phone`, `login`, `password`, `salt`, `pwd`) VALUES (2, 1, 'Vilmantas', 'Badgonas', 'motiejus.b@gmail.com', '61735989', 'vilbad', 'sha256:1000:XEage4UqTgsTg+BM5F41TWRd2tBelMhQ:DisDwFWMeE5dlqQVsQ+S1q1l8DQlR7Bp', 'XEage4UqTgsTg+BM5F41TWRd2tBelMhQ', '1111');
INSERT INTO `security_shop`.`members` (`id`, `role_id`, `name`, `lastname`, `email`, `phone`, `login`, `password`, `salt`, `pwd`) VALUES (3, 1, 'Beaver', 'Douglas', 'dob@kea.dk', '', 'beadou', 'sha256:1000:rPJVaGm24htPXIw+53VwBCmrXFArRAaW:/7BGZDZbuHU784DK3Wuwm65CsfDhCuwo', 'rPJVaGm24htPXIw+53VwBCmrXFArRAaW', '2222');
INSERT INTO `security_shop`.`members` (`id`, `role_id`, `name`, `lastname`, `email`, `phone`, `login`, `password`, `salt`, `pwd`) VALUES (4, 1, 'Thomas', 'Hansen', 'thbh@kea.dk', '35863116', 'thohan', 'sha256:1000:4zWwhxQcUuefT4kv4y5jXLwvNPpug3aR:BtWNAJZ3YjVKpu0DQTxtkb4RW9uvqjVI', '4zWwhxQcUuefT4kv4y5jXLwvNPpug3aR', '3333');
INSERT INTO `security_shop`.`members` (`id`, `role_id`, `name`, `lastname`, `email`, `phone`, `login`, `password`, `salt`, `pwd`) VALUES (5, 1, 'Nicolas', 'Buch', 'nicolas@lickmysheep.com', '26886152', 'nicbuc', 'sha256:1000:kIrE+0qDm9cUeX32tW/WraMqnjB7hrvp:Kn3Mik3RtwKjTPptugCfnN1XyWz+hOhk', 'kIrE+0qDm9cUeX32tW/WraMqnjB7hrvp', '4444');
INSERT INTO `security_shop`.`members` (`id`, `role_id`, `name`, `lastname`, `email`, `phone`, `login`, `password`, `salt`, `pwd`) VALUES (6, 1, 'Semir', 'Catovic', 'semco_cato@hotmail.com', '50567219', 'semcat', 'sha256:1000:Qq67Lx9dHj9gQRLUjxxMJYWpUlw4NtiF:N5ns88s0KQb+HjqracMbs/gbWOFaeBGk', 'Qq67Lx9dHj9gQRLUjxxMJYWpUlw4NtiF', '5555');
INSERT INTO `security_shop`.`members` (`id`, `role_id`, `name`, `lastname`, `email`, `phone`, `login`, `password`, `salt`, `pwd`) VALUES (7, 1, 'Iulian', 'Drug', 'iulian.d.urb@gmail.com', '', 'iuldru', 'sha256:1000:Z/9DXdCb0cLl94yBEzE8pzl1PHs7Iykj:39B7+WKdiGToBySILz9/4+mMpuhPL0S+', 'Z/9DXdCb0cLl94yBEzE8pzl1PHs7Iykj', '6666');
INSERT INTO `security_shop`.`members` (`id`, `role_id`, `name`, `lastname`, `email`, `phone`, `login`, `password`, `salt`, `pwd`) VALUES (8, 2, 'Jon', 'Eikholm', 'jone@kea.dk', '26352573', 'joneik', 'sha256:1000:rEyS3jqXOywHeK/ymb4ScaU9Ju8MKnKQ:+56pT7mtEsqv7GW133bnMg/W4nLfVeSz', 'rEyS3jqXOywHeK/ymb4ScaU9Ju8MKnKQ', '7777');

COMMIT;

-- -----------------------------------------------------
-- Data for table `security_shop`.`orders`
-- -----------------------------------------------------
START TRANSACTION;
USE `security_shop`;
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (1, 2, '2003-01-06');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (2, 1, '2003-01-09');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (3, 5, '2003-01-10');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (4, 6, '2003-01-29');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (5, 6, '2003-01-31');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (6, 4, '2003-02-11');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (7, 7, '2003-02-17');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (8, 8, '2003-02-24');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (9, 6, '2003-03-03');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (10, 8, '2003-03-10');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (11, 6, '2003-03-18');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (12, 4, '2003-03-25');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (13, 3, '2003-03-24');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (14, 8, '2003-03-26');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (15, 1, '2003-04-01');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (16, 3, '2003-04-04');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (17, 5, '2003-04-11');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (18, 8, '2003-04-16');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (19, 7, '2003-04-21');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (20, 7, '2003-04-28');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (21, 6, '2003-04-29');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (22, 5, '2003-05-07');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (23, 3, '2003-05-08');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (24, 8, '2003-05-20');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (25, 1, '2003-05-21');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (26, 4, '2003-05-21');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (27, 5, '2003-05-28');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (28, 8, '2003-06-03');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (29, 7, '2003-06-06');
INSERT INTO `security_shop`.`orders` (`order_id`, `member_id`, `datetime`) VALUES (30, 4, '2003-06-12');

COMMIT;

-- -----------------------------------------------------
-- Data for table `security_shop`.`products`
-- -----------------------------------------------------
START TRANSACTION;
USE `security_shop`;
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (1, '1969 Harley Davidson Ultimate Chopper', 'This replica features working kickstand, front suspension, gear-shift lever, footbrake lever, drive chain, wheels and steering. All parts are particularly delicate due to their precise scale and require special care and attention.', 7933, 48.81);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (2, '1952 Alpine Renault 1300', 'Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.', 7305, 98.58);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (3, '1996 Moto Guzzi 1100i', 'Official Moto Guzzi logos and insignias, saddle bags located on side of motorcycle, detailed engine, working steering, working suspension, two leather seats, luggage rack, dual exhaust pipes, small saddle bag located on handle bars, two-tone paint with chrome accents, superior die-cast detail , rotating wheels , working kick stand, diecast metal with plastic parts and baked enamel finish.', 6625, 68.99);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (4, '2003 Harley-Davidson Eagle Drag Bike', 'Model features, official Harley Davidson logos and insignias, detachable rear wheelie bar, heavy diecast metal with resin parts, authentic multi-color tampo-printed graphics, separate engine drive belts, free-turning front fork, rotating tires and rear racing slick, certificate of authenticity, detailed engine, display stand\r\r\n, precision diecast replica, baked enamel finish, 1:10 scale model, removable fender, seat and tank cover piece for displaying the superior detail of the v-twin engine', 5582, 91.02);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (5, '1972 Alfa Romeo GTA', 'Features include: Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.', 3252, 85.68);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (6, '1962 LanciaA Delta 16V', 'Features include: Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.', 6791, 103.42);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (7, '1968 Ford Mustang', 'Hood, doors and trunk all open to reveal highly detailed interior features. Steering wheel actually turns the front wheels. Color dark green.', 68, 95.34);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (8, '2001 Ferrari Enzo', 'Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.', 3619, 95.59);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (9, '1958 Setra Bus', 'Model features 30 windows, skylights & glare resistant glass, working steering system, original logos', 1579, 77.9);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (10, '2002 Suzuki XREO', 'Official logos and insignias, saddle bags located on side of motorcycle, detailed engine, working steering, working suspension, two leather seats, luggage rack, dual exhaust pipes, small saddle bag located on handle bars, two-tone paint with chrome accents, superior die-cast detail , rotating wheels , working kick stand, diecast metal with plastic parts and baked enamel finish.', 9997, 66.27);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (11, '1969 Corvair Monza', '1:18 scale die-cast about 10\" long doors open, hood opens, trunk opens and wheels roll', 6906, 89.14);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (12, '1968 Dodge Charger', '1:12 scale model of a 1968 Dodge Charger. Hood, doors and trunk all open to reveal highly detailed interior features. Steering wheel actually turns the front wheels. Color black', 9123, 75.16);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (13, '1969 Ford Falcon', 'Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.', 1049, 83.05);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (14, '1970 Plymouth Hemi Cuda', 'Very detailed 1970 Plymouth Cuda model in 1:12 scale. The Cuda is generally accepted as one of the fastest original muscle cars from the 1970s. This model is a reproduction of one of the orginal 652 cars built in 1970. Red color.', 5663, 31.92);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (15, '1957 Chevy Pickup', '1:12 scale die-cast about 20\" long Hood opens, Rubber wheels', 6125, 55.7);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (16, '1969 Dodge Charger', 'Detailed model of the 1969 Dodge Charger. This model includes finely detailed interior and exterior features. Painted in red and white.', 7323, 58.73);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (17, '1940 Ford Pickup Truck', 'This model features soft rubber tires, working steering, rubber mud guards, authentic Ford logos, detailed undercarriage, opening doors and hood,  removable split rear gate, full size spare mounted in bed, detailed interior with opening glove box', 2613, 58.33);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (18, '1993 Mazda RX-7', 'This model features, opening hood, opening doors, detailed engine, rear spoiler, opening trunk, working steering, tinted windows, baked enamel finish. Color red.', 3975, 83.51);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (19, '1937 Lincoln Berline', 'Features opening engine cover, doors, trunk, and fuel filler cap. Color black', 8693, 60.62);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (20, '1936 Mercedes-Benz 500K Special Roadster', 'This 1:18 scale replica is constructed of heavy die-cast metal and has all the features of the original: working doors and rumble seat, independent spring suspension, detailed interior, working steering system, and a bifold hood that reveals an engine so accurate that it even includes the wiring. All this is topped off with a baked enamel finish. Color white.', 8635, 24.26);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (21, '1965 Aston Martin DB5', 'Die-cast model of the silver 1965 Aston Martin DB5 in silver. This model includes full wire wheels and doors that open with fully detailed passenger compartment. In 1:18 scale, this model measures approximately 10 inches/20 cm long.', 9042, 65.96);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (22, '1980s Black Hawk Helicopter', '1:18 scale replica of actual Army\'s UH-60L BLACK HAWK Helicopter. 100% hand-assembled. Features rotating rotor blades, propeller blades and rubber wheels.', 5330, 77.27);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (23, '1917 Grand Touring Sedan', 'This 1:18 scale replica of the 1917 Grand Touring car has all the features you would expect from museum quality reproductions: all four doors and bi-fold hood opening, detailed engine and instrument panel, chrome-look trim, and tufted upholstery, all topped off with a factory baked-enamel finish.', 2724, 86.7);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (24, '1948 Porsche 356-A Roadster', 'This precision die-cast replica features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent spring suspension as well as factory baked enamel finish.', 8826, 53.9);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (25, '1995 Honda Civic', 'This model features, opening hood, opening doors, detailed engine, rear spoiler, opening trunk, working steering, tinted windows, baked enamel finish. Color yellow.', 9772, 93.89);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (26, '1998 Chrysler Plymouth Prowler', 'Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.', 4724, 101.51);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (27, '1911 Ford Town Car', 'Features opening hood, opening doors, opening trunk, wide white wall tires, front door arm rests, working steering system.', 540, 33.3);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (28, '1964 Mercedes Tour Bus', 'Exact replica. 100+ parts. working steering system, original logos', 8258, 74.86);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (29, '1932 Model A Ford J-Coupe', 'This model features grille-mounted chrome horn, lift-up louvered hood, fold-down rumble seat, working steering system, chrome-covered spare, opening doors, detailed and wired engine', 9354, 58.48);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (30, '1926 Ford Fire Engine', 'Gleaming red handsome appearance. Everything is here the fire hoses, ladder, axes, bells, lanterns, ready to fight any inferno.', 2018, 24.92);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (31, 'P-51-D Mustang', 'Has retractable wheels and comes with a stand', 992, 49);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (32, '1936 Harley Davidson El Knucklehead', 'Intricately detailed with chrome accents and trim, official die-struck logos and baked enamel finish.', 4357, 24.23);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (33, '1928 Mercedes-Benz SSK', 'This 1:18 replica features grille-mounted chrome horn, lift-up louvered hood, fold-down rumble seat, working steering system, chrome-covered spare, opening doors, detailed and wired engine. Color black.', 548, 72.56);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (34, '1999 Indy 500 Monte Carlo SS', 'Features include opening and closing doors. Color: Red', 8164, 56.76);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (35, '1913 Ford Model T Speedster', 'This 250 part reproduction includes moving handbrakes, clutch, throttle and foot pedals, squeezable horn, detailed wired engine, removable water, gas, and oil cans, pivoting monocle windshield, all topped with a baked enamel red finish. Each replica comes with an Owners Title and Certificate of Authenticity. Color red.', 4189, 60.78);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (36, '1934 Ford V8 Coupe', 'Chrome Trim, Chrome Grille, Opening Hood, Opening Doors, Opening Trunk, Detailed Engine, Working Steering System', 5649, 34.35);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (37, '1999 Yamaha Speed Boat', 'Exact replica. Wood and Metal. Many extras including rigging, long boats, pilot house, anchors, etc. Comes with three masts, all square-rigged.', 4259, 51.61);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (38, '18th Century Vintage Horse Carriage', 'Hand crafted diecast-like metal horse carriage is re-created in about 1:18 scale of antique horse carriage. This antique style metal Stagecoach is all hand-assembled with many different parts.\r\r\n\r\r\nThis collectible metal horse carriage is painted in classic Red, and features turning steering wheel and is entirely hand-finished.', 5992, 60.74);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (39, '1903 Ford Model A', 'Features opening trunk,  working steering system', 3913, 68.3);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (40, '1992 Ferrari 360 Spider red', 'his replica features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent spring suspension as well as factory baked enamel finish.', 8347, 77.9);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (41, '1985 Toyota Supra', 'This model features soft rubber tires, working steering, rubber mud guards, authentic Ford logos, detailed undercarriage, opening doors and hood, removable split rear gate, full size spare mounted in bed, detailed interior with opening glove box', 7733, 57.01);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (42, 'Collectable Wooden Train', 'Hand crafted wooden toy train set is in about 1:18 scale, 25 inches in total length including 2 additional carts, of actual vintage train. This antique style wooden toy train model set is all hand-assembled with 100% wood.', 6450, 67.56);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (43, '1969 Dodge Super Bee', 'This replica features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent spring suspension as well as factory baked enamel finish.', 1917, 49.05);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (44, '1917 Maxwell Touring Car', 'Features Gold Trim, Full Size Spare Tire, Chrome Trim, Chrome Grille, Opening Hood, Opening Doors, Opening Trunk, Detailed Engine, Working Steering System', 7913, 57.54);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (45, '1976 Ford Gran Torino', 'Highly detailed 1976 Ford Gran Torino \"Starsky and Hutch\" diecast model. Very well constructed and painted in red and white patterns.', 9127, 73.49);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (46, '1948 Porsche Type 356 Roadster', 'This model features working front and rear suspension on accurately replicated and actuating shock absorbers as well as opening engine cover, rear stabilizer flap,  and 4 opening doors.', 8990, 62.16);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (47, '1957 Vespa GS150', 'Features rotating wheels , working kick stand. Comes with stand.', 7689, 32.95);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (48, '1941 Chevrolet Special Deluxe Cabriolet', 'Features opening hood, opening doors, opening trunk, wide white wall tires, front door arm rests, working steering system, leather upholstery. Color black.', 2378, 64.58);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (49, '1970 Triumph Spitfire', 'Features include opening and closing doors. Color: White.', 5545, 91.92);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (50, '1932 Alfa Romeo 8C2300 Spider Sport', 'This 1:18 scale precision die cast replica features the 6 front headlights of the original, plus a detailed version of the 142 horsepower straight 8 engine, dual spares and their famous comprehensive dashboard. Color black.', 6553, 43.26);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (51, '1904 Buick Runabout', 'Features opening trunk,  working steering system', 8290, 52.66);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (52, '1940s Ford truck', 'This 1940s Ford Pick-Up truck is re-created in 1:18 scale of original 1940s Ford truck. This antique style metal 1940s Ford Flatbed truck is all hand-assembled. This collectible 1940\'s Pick-Up truck is painted in classic dark green color, and features rotating wheels.', 3128, 84.76);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (53, '1939 Cadillac Limousine', 'Features completely detailed interior including Velvet flocked drapes,deluxe wood grain floor, and a wood grain casket with seperate chrome handles', 6645, 23.14);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (54, '1957 Corvette Convertible', '1957 die cast Corvette Convertible in Roman Red with white sides and whitewall tires. 1:18 scale quality die-cast with detailed engine and underbvody. Now you can own The Classic Corvette.', 1249, 69.93);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (55, '1957 Ford Thunderbird', 'This 1:18 scale precision die-cast replica, with its optional porthole hardtop and factory baked-enamel Thunderbird Bronze finish, is a 100% accurate rendition of this American classic.', 3209, 34.21);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (56, '1970 Chevy Chevelle SS 454', 'This model features rotating wheels, working streering system and opening doors. All parts are particularly delicate due to their precise scale and require special care and attention. It should not be picked up by the doors, roof, hood or trunk.', 1005, 49.24);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (57, '1970 Dodge Coronet', '1:24 scale die-cast about 18\" long doors open, hood opens and rubber wheels', 4074, 32.37);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (58, '1997 BMW R 1100 S', 'Detailed scale replica with working suspension and constructed from over 70 parts', 7003, 60.86);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (59, '1966 Shelby Cobra 427 S/C', 'This diecast model of the 1966 Shelby Cobra 427 S/C includes many authentic details and operating parts. The 1:24 scale model of this iconic lighweight sports car from the 1960s comes in silver and it\'s own display case.', 8197, 29.18);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (60, '1928 British Royal Navy Airplane', 'Official logos and insignias', 3627, 66.74);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (61, '1939 Chevrolet Deluxe Coupe', 'This 1:24 scale die-cast replica of the 1939 Chevrolet Deluxe Coupe has the same classy look as the original. Features opening trunk, hood and doors and a showroom quality baked enamel finish.', 7332, 22.57);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (62, '1960 BSA Gold Star DBD34', 'Detailed scale replica with working suspension and constructed from over 70 parts', 15, 37.32);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (63, '18th century schooner', 'All wood with canvas sails. Many extras including rigging, long boats, pilot house, anchors, etc. Comes with 4 masts, all square-rigged.', 1898, 82.34);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (64, '1938 Cadillac V-16 Presidential Limousine', 'This 1:24 scale precision die cast replica of the 1938 Cadillac V-16 Presidential Limousine has all the details of the original, from the flags on the front to an opening back seat compartment complete with telephone and rifle. Features factory baked-enamel black finish, hood goddess ornament, working jump seats.', 2847, 20.61);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (65, '1962 Volkswagen Microbus', 'This 1:18 scale die cast replica of the 1962 Microbus is loaded with features: A working steering system, opening front doors and tailgate, and famous two-tone factory baked enamel finish, are all topped of by the sliding, real fabric, sunroof.', 2327, 61.34);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (66, '1982 Ducati 900 Monster', 'Features two-tone paint with chrome accents, superior die-cast detail , rotating wheels , working kick stand', 6840, 47.1);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (67, '1949 Jaguar XK 120', 'Precision-engineered from original Jaguar specification in perfect scale ratio. Features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent spring suspension as well as factory baked enamel finish.', 2350, 47.25);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (68, '1958 Chevy Corvette Limited Edition', 'The operating parts of this 1958 Chevy Corvette Limited Edition are particularly delicate due to their precise scale and require special care and attention. Features rotating wheels, working streering, opening doors and trunk. Color dark green.', 2542, 15.91);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (69, '1900s Vintage Bi-Plane', 'Hand crafted diecast-like metal bi-plane is re-created in about 1:24 scale of antique pioneer airplane. All hand-assembled with many different parts. Hand-painted in classic yellow and features correct markings of original airplane.', 5942, 34.25);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (70, '1952 Citroen-15CV', 'Precision crafted hand-assembled 1:18 scale reproduction of the 1952 15CV, with its independent spring suspension, working steering system, opening doors and hood, detailed engine and instrument panel, all topped of with a factory fresh baked enamel finish.', 1452, 72.82);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (71, '1982 Lamborghini Diablo', 'This replica features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent spring suspension as well as factory baked enamel finish.', 7723, 16.24);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (72, '1912 Ford Model T Delivery Wagon', 'This model features chrome trim and grille, opening hood, opening doors, opening trunk, detailed engine, working steering system. Color white.', 9173, 46.91);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (73, '1969 Chevrolet Camaro Z28', '1969 Z/28 Chevy Camaro 1:24 scale replica. The operating parts of this limited edition 1:24 scale diecast model car 1969 Chevy Camaro Z28- hood, trunk, wheels, streering, suspension and doors- are particularly delicate due to their precise scale and require special care and attention.', 4695, 50.51);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (74, '1971 Alpine Renault 1600s', 'This 1971 Alpine Renault 1600s replica Features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent spring suspension as well as factory baked enamel finish.', 7995, 38.58);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (75, '1937 Horch 930V Limousine', 'Features opening hood, opening doors, opening trunk, wide white wall tires, front door arm rests, working steering system', 2902, 26.3);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (76, '2002 Chevy Corvette', 'The operating parts of this limited edition Diecast 2002 Chevy Corvette 50th Anniversary Pace car Limited Edition are particularly delicate due to their precise scale and require special care and attention. Features rotating wheels, poseable streering, opening doors and trunk.', 9446, 62.11);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (77, '1940 Ford Delivery Sedan', 'Chrome Trim, Chrome Grille, Opening Hood, Opening Doors, Opening Trunk, Detailed Engine, Working Steering System. Color black.', 6621, 48.64);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (78, '1956 Porsche 356A Coupe', 'Features include: Turnable front wheels; steering function; detailed interior; detailed engine; opening hood; opening trunk; opening doors; and detailed chassis.', 6600, 98.3);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (79, 'Corsair F4U ( Bird Cage)', 'Has retractable wheels and comes with a stand. Official logos and insignias.', 6812, 29.34);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (80, '1936 Mercedes Benz 500k Roadster', 'This model features grille-mounted chrome horn, lift-up louvered hood, fold-down rumble seat, working steering system and rubber wheels. Color black.', 2081, 21.75);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (81, '1992 Porsche Cayenne Turbo Silver', 'This replica features opening doors, superb detail and craftsmanship, working steering system, opening forward compartment, opening rear trunk with removable spare, 4 wheel independent spring suspension as well as factory baked enamel finish.', 6582, 69.78);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (82, '1936 Chrysler Airflow', 'Features opening trunk,  working steering system. Color dark green.', 4710, 57.46);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (83, '1900s Vintage Tri-Plane', 'Hand crafted diecast-like metal Triplane is Re-created in about 1:24 scale of antique pioneer airplane. This antique style metal triplane is all hand-assembled with many different parts.', 2756, 36.23);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (84, '1961 Chevrolet Impala', 'This 1:18 scale precision die-cast reproduction of the 1961 Chevrolet Impala has all the features-doors, hood and trunk that open; detailed 409 cubic-inch engine; chrome dashboard and stick shift, two-tone interior; working steering system; all topped of with a factory baked-enamel finish.', 7869, 32.33);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (85, '1980’s GM Manhattan Express', 'This 1980’s era new look Manhattan express is still active, running from the Bronx to mid-town Manhattan. Has 35 opeining windows and working lights. Needs a battery.', 5099, 53.93);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (86, '1997 BMW F650 ST', 'Features official die-struck logos and baked enamel finish. Comes with stand.', 178, 66.92);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (87, '1982 Ducati 996 R', 'Features rotating wheels , working kick stand. Comes with stand.', 9241, 24.14);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (88, '1954 Greyhound Scenicruiser', 'Model features bi-level seating, 50 windows, skylights & glare resistant glass, working steering system, original logos', 2874, 25.98);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (89, '1950\'s Chicago Surface Lines Streetcar', 'This streetcar is a joy to see. It has 80 separate windows, electric wire guides, detailed interiors with seats, poles and drivers controls, rolling and turning wheel assemblies, plus authentic factory baked-enamel finishes (Green Hornet for Chicago and Cream and Crimson for Boston).', 8601, 26.72);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (90, '1996 Peterbilt 379 Stake Bed with Outrigger', 'This model features, opening doors, detailed engine, working steering, tinted windows, detailed interior, die-struck logos, removable stakes operating outriggers, detachable second trailer, functioning 360-degree self loader, precision molded resin trailer and trim, baked enamel finish on cab', 814, 33.61);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (91, '1928 Ford Phaeton Deluxe', 'This model features grille-mounted chrome horn, lift-up louvered hood, fold-down rumble seat, working steering system', 136, 33.02);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (92, '1974 Ducati 350 Mk3 Desmo', 'This model features two-tone paint with chrome accents, superior die-cast detail , rotating wheels , working kick stand', 3341, 56.13);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (93, '1930 Buick Marquette Phaeton', 'Features opening trunk,  working steering system', 7062, 27.06);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (94, 'Diamond T620 Semi-Skirted Tanker', 'This limited edition model is licensed and perfectly scaled for Lionel Trains. The Diamond T620 has been produced in solid precision diecast and painted with a fire baked enamel finish. It comes with a removable tanker and is a perfect model to add authenticity to your static train or car layout or to just have on display.', 1016, 68.29);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (95, '1962 City of Detroit Streetcar', 'This streetcar is a joy to see. It has 99 separate windows, electric wire guides, detailed interiors with seats, poles and drivers controls, rolling and turning wheel assemblies, plus authentic factory baked-enamel finishes (Green Hornet for Chicago and Cream and Crimson for Boston).', 1645, 37.49);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (96, '2002 Yamaha YZR M1', 'Features rotating wheels , working kick stand. Comes with stand.', 600, 34.17);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (97, 'The Schooner Bluenose', 'All wood with canvas sails. Measures 31 1/2 inches in Length, 22 inches High and 4 3/4 inches Wide. Many extras.\r\r\nThe schooner Bluenose was built in Nova Scotia in 1921 to fish the rough waters off the coast of Newfoundland. Because of the Bluenose racing prowess she became the pride of all Canadians. Still featured on stamps and the Canadian dime, the Bluenose was lost off Haiti in 1946.', 1897, 34);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (98, 'American Airlines: B767-300', 'Exact replia with official logos and insignias and retractable wheels', 5841, 51.15);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (99, 'The Mayflower', 'Measures 31 1/2 inches Long x 25 1/2 inches High x 10 5/8 inches Wide\r\r\nAll wood with canvas sail. Extras include long boats, rigging, ladders, railing, anchors, side cannons, hand painted, etc.', 737, 43.3);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (100, 'HMS Bounty', 'Measures 30 inches Long x 27 1/2 inches High x 4 3/4 inches Wide. \r\r\nMany extras including rigging, long boats, pilot house, anchors, etc. Comes with three masts, all square-rigged.', 3501, 39.83);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (101, 'America West Airlines B757-200', 'Official logos and insignias. Working steering system. Rotating jet engines', 9653, 68.8);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (102, 'The USS Constitution Ship', 'All wood with canvas sails. Measures 31 1/2\" Length x 22 3/8\" High x 8 1/4\" Width. Extras include 4 boats on deck, sea sprite on bow, anchors, copper railing, pilot houses, etc.', 7083, 33.97);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (103, '1982 Camaro Z28', 'Features include opening and closing doors. Color: White. \r\r\nMeasures approximately 9 1/2\" Long.', 6934, 46.53);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (104, 'ATA: B757-300', 'Exact replia with official logos and insignias and retractable wheels', 7106, 59.33);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (105, 'F/A 18 Hornet 1/72', '10\" Wingspan with retractable landing gears.Comes with pilot', 551, 54.4);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (106, 'The Titanic', 'Completed model measures 19 1/2 inches long, 9 inches high, 3inches wide and is in barn red/black. All wood and metal.', 1956, 51.09);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (107, 'The Queen Mary', 'Exact replica. Wood and Metal. Many extras including rigging, long boats, pilot house, anchors, etc. Comes with three masts, all square-rigged.', 5088, 53.63);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (108, 'American Airlines: MD-11S', 'Polished finish. Exact replia with official logos and insignias and retractable wheels', 8820, 36.27);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (109, 'Boeing X-32A JSF', '10\" Wingspan with retractable landing gears.Comes with pilot', 4857, 32.77);
INSERT INTO `security_shop`.`products` (`id`, `name`, `description`, `stock`, `price`) VALUES (110, 'Pont Yacht', 'Measures 38 inches Long x 33 3/4 inches High. Includes a stand.\r\r\nMany extras including rigging, long boats, pilot house, anchors, etc. Comes with 2 masts, all square-rigged', 414, 33.3);

COMMIT;
