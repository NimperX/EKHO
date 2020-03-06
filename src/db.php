<?php

$host = 'localhost';
$user = 'root';
$pass = '';

$q = [];
$q[1] = "CREATE TABLE IF NOT EXISTS `complaint` ( `comp_id` int(5) NOT NULL, `name` varchar(255) DEFAULT NULL, `complain` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$q[2] = "CREATE TABLE IF NOT EXISTS `customer` (  `c_id` int(8) NOT NULL,  `firstname` varchar(50) NOT NULL,  `lastname` varchar(50) NOT NULL,  `email` varchar(255) NOT NULL, `password` VARCHAR(255) NOT NULL,  `contactno` varchar(12) NOT NULL,  `nic_passport` varchar(12) NOT NULL,  `cc_no` varchar(16) NOT NULL,  `exp_date` varchar(10) NOT NULL,  `cvv` int(3) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$q[3] = "CREATE TABLE IF NOT EXISTS `employee` (  `emp_id` int(4) NOT NULL,  `firstname` varchar(50) NOT NULL,  `lastname` varchar(50) NOT NULL,  `username` varchar(100) NOT NULL,  `password` varchar(255) NOT NULL,  `nic` varchar(12) NOT NULL,  `contactno` int(10) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$q[4] = "CREATE TABLE IF NOT EXISTS `event` (  `e_id` int(5) NOT NULL,  `event_type` varchar(100) NOT NULL,  `date` date NOT NULL,  `no_of_seats` int(4) NOT NULL,  `advance` int(8) DEFAULT NULL,  `balance` int(8) DEFAULT NULL,  `c_id` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$q[5] = "CREATE TABLE IF NOT EXISTS `event_facility` (  `id` int(5) NOT NULL,  `e_id` int(4) NOT NULL,  `f_id` int(4) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$q[6] = "CREATE TABLE IF NOT EXISTS `facility` (  `f_id` int(4) NOT NULL,  `facility` varchar(255) NOT NULL,  `amount` int(8) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$q[7] = "CREATE TABLE IF NOT EXISTS `room` (  `r_id` int(5) NOT NULL, `room_name` VARCHAR(50) NOT NULL, `AC` tinyint(1) NOT NULL,  `room_size` int(1) NOT NULL,  `Amount` int(11) NOT NULL,  `other_features` text) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$q[8] = "CREATE TABLE IF NOT EXISTS `room_book` (  `id` int(5) NOT NULL,  `r_id` int(5) NOT NULL,  `c_id` int(8) NOT NULL,  `duration_from` date NOT NULL,  `duration_to` date NOT NULL,  `ordered_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  `amount` int(8) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$q[9] = "CREATE TABLE IF NOT EXISTS `sale` (  `s_id` int(6) NOT NULL,  `date_time` datetime NOT NULL,  `total` int(8) NOT NULL,  `emp_id` int(4) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$q[10] = "CREATE TABLE IF NOT EXISTS `sale_facility` (  `id` int(5) NOT NULL,  `s_id` int(6) NOT NULL,  `f_id` int(4) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$q[11] = "ALTER TABLE `complaint`  ADD PRIMARY KEY (`comp_id`);";
$q[12] = "ALTER TABLE `customer`  ADD PRIMARY KEY (`c_id`);";
$q[13] = "ALTER TABLE `employee`  ADD PRIMARY KEY (`emp_id`),  ADD UNIQUE KEY `UsernameUnique` (`username`);";
$q[14] = "ALTER TABLE `event`  ADD PRIMARY KEY (`e_id`),  ADD KEY `c_id` (`c_id`);";
$q[15] = "ALTER TABLE `event_facility`  ADD PRIMARY KEY (`id`),  ADD KEY `e_id` (`e_id`),  ADD KEY `f_id` (`f_id`);";
$q[16] = "ALTER TABLE `facility`  ADD PRIMARY KEY (`f_id`);";
$q[17] = "ALTER TABLE `room`  ADD PRIMARY KEY (`r_id`);";
$q[18] = "ALTER TABLE `room_book`  ADD PRIMARY KEY (`id`),  ADD KEY `r_id` (`r_id`),  ADD KEY `c_id` (`c_id`);";
$q[19] = "ALTER TABLE `sale`  ADD PRIMARY KEY (`s_id`),  ADD KEY `emp_id` (`emp_id`);";
$q[20] = "ALTER TABLE `sale_facility`  ADD PRIMARY KEY (`id`),  ADD KEY `s_id` (`s_id`),  ADD KEY `f_id` (`f_id`);";
$q[21] = "ALTER TABLE `complaint`  MODIFY `comp_id` int(5) NOT NULL AUTO_INCREMENT;";
$q[22] = "ALTER TABLE `customer`  MODIFY `c_id` int(8) NOT NULL AUTO_INCREMENT;";
$q[23] = "ALTER TABLE `employee`  MODIFY `emp_id` int(4) NOT NULL AUTO_INCREMENT;";
$q[24] = "ALTER TABLE `event`  MODIFY `e_id` int(5) NOT NULL AUTO_INCREMENT;";
$q[25] = "ALTER TABLE `event_facility`  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;";
$q[26] = "ALTER TABLE `facility`  MODIFY `f_id` int(4) NOT NULL AUTO_INCREMENT;";
$q[27] = "ALTER TABLE `room`  MODIFY `r_id` int(5) NOT NULL AUTO_INCREMENT;";
$q[28] = "ALTER TABLE `room_book`  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;";
$q[29] = "ALTER TABLE `sale`  MODIFY `s_id` int(6) NOT NULL AUTO_INCREMENT;";
$q[30] = "ALTER TABLE `sale_facility`  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;";
$q[31] = "ALTER TABLE `event`  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `customer` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE;";
$q[32] = "ALTER TABLE `event_facility`  ADD CONSTRAINT `event_facility_ibfk_1` FOREIGN KEY (`e_id`) REFERENCES `event` (`e_id`) ON DELETE CASCADE ON UPDATE CASCADE,  ADD CONSTRAINT `event_facility_ibfk_2` FOREIGN KEY (`f_id`) REFERENCES `facility` (`f_id`) ON DELETE NO ACTION ON UPDATE CASCADE;";
$q[33] = "ALTER TABLE `room_book`  ADD CONSTRAINT `room_book_ibfk_1` FOREIGN KEY (`r_id`) REFERENCES `room` (`r_id`) ON UPDATE CASCADE,  ADD CONSTRAINT `room_book_ibfk_2` FOREIGN KEY (`c_id`) REFERENCES `customer` (`c_id`) ON UPDATE CASCADE;";
$q[34] = "ALTER TABLE `sale`  ADD CONSTRAINT `sale_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`) ON UPDATE CASCADE;";
$q[35] = "ALTER TABLE `sale_facility`  ADD CONSTRAINT `sale_facility_ibfk_1` FOREIGN KEY (`s_id`) REFERENCES `sale` (`s_id`) ON UPDATE CASCADE,  ADD CONSTRAINT `sale_facility_ibfk_2` FOREIGN KEY (`f_id`) REFERENCES `facility` (`f_id`) ON UPDATE CASCADE;";
$q[36] = "INSERT INTO `room`(`room_name`, `AC`, `room_size`, `Amount`, `other_features`) 
          VALUES('Deluxe', '1', '2', '12000', 'Air-conditioned rooms,Flat-screen satellite,TV,Wardrobe,Safe,Desk,Hairdryer,Telephone,Bottled water,Rain-shower facilities,Minibar'),
                ('Deluxe', '1', '3', '15000', 'Air-conditioned rooms,Flat-screen satellite,TV,Wardrobe,Safe,Desk,Hairdryer,Telephone,Bottled water,Rain-shower facilities,Minibar'),
                ('Deluxe', '1', '2', '12000', 'Air-conditioned rooms,Flat-screen satellite,TV,Wardrobe,Safe,Desk,Hairdryer,Telephone,Bottled water,Rain-shower facilities'),
                ('Deluxe Lake View', '1', '2', '15000', 'Air-conditioned rooms,Flat-screen satellite,TV,Wardrobe,Safe,Desk,Hairdryer,Telephone,Bottled water,Rain-shower facilities,Minibar'),
                ('Deluxe Lake View', '1', '3', '18000', 'Air-conditioned rooms,Flat-screen satellite,TV,Wardrobe,Safe,Desk,Hairdryer,Telephone,Bottled water,Rain-shower facilities,Minibar'),
                ('Suites', '0', '3', '11000', 'Additional living spaces,En-suite dining facilities,Sofa bed,Flat-screen satellite TV,Wardrobe,Safe,Desk,Hairdryer,Telephone,Bottled water'),
                ('Suites', '0', '3', '11000', 'Additional living spaces,En-suite dining facilities,Sofa bed,Flat-screen satellite TV,Wardrobe,Safe,Desk,Hairdryer,Telephone,Bottled water');";
$q[37] = "INSERT INTO `facility` (`facility`, `amount`)
          VALUES ('Pool', '5000'),
                 ('Mini Bar', '5000'),
                 ('External Room', '5000'),
                 ('Dance Floor', '2000'),
                 ('DJ Music', '12000')";
$q[38] = "INSERT INTO `employee` (`emp_id`, `firstname`, `lastname`, `username`, `password`, `nic`, `contactno`) VALUES (NULL, 'Hotel', 'Manager', 'manager', 'manager@123', '123456789V', '0712345678');";
$q[39] = "COMMIT;";

$mysqli  = new mysqli($host,$user,$pass) or die('Error while connecting to database');

if(!mysqli_connect_errno()){
    $mysqli->select_db('ekho');
    if($mysqli->errno){
        $mysqli->query('CREATE DATABASE IF NOT EXISTS `ekho` CHARACTER SET utf8 COLLATE utf8_general_ci;');
        $mysqli->select_db('ekho');
        for($i=1;$i<=39;$i++){
            $mysqli->query($q[$i]);
            if($mysqli->errno) die('Error occured : '.$mysqli->error);
        }
    }
}

?>