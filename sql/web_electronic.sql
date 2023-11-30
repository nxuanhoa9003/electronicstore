-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2023 at 07:24 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `electrostore`
--

-- --------------------------------------------------------

--
-- Table structure for table `tableadmin`
--

CREATE TABLE `tableadmin` (
  `adminID` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `passWord` varchar(100) NOT NULL,
  `adminName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tableadmin`
--

INSERT INTO `tableadmin` (`adminID`, `userName`, `passWord`, `adminName`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Hoà Ngô');

-- --------------------------------------------------------

--
-- Table structure for table `tableattributescategory`
--

CREATE TABLE `tableattributescategory` (
  `orderID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `attributeName` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tableattributescategory`
--

INSERT INTO `tableattributescategory` (`orderID`, `categoryID`, `attributeName`) VALUES
(1, 1, 'Loại máy--Công suất làm lạnh--Phạm vi làm lạnh hiệu quả--Lọc bụi, kháng khuẩn, khử mùi--Công nghệ tiết kiệm điện--Làm lạnh nhanh--Tiện ích--Tiêu thụ điện--Dàn lạnh--Dàn nóng--Hãng'),
(2, 2, 'Loại tủ--Dung tích sử dụng--Công nghệ tiết kiệm điện--Công nghệ làm lạnh--Công nghệ kháng khuẩn khử mùi--Công nghệ bảo quản thực phẩm--Tiện ích--Kích thước - Khối lượng--Hãng--Nơi sản xuất--Năm ra mắt'),
(3, 3, 'Loại máy--Khối lượng giặt--Kiểu động cơ--Công nghệ giặt--Tiện ích--Kích thước - Khối lượng--Bảng điều khiển--Hãng'),
(4, 4, 'Màn hình--RAM--ROM--Hệ điều hành--Camera sau--Camera trước--Chip--Pin--Hãng');

-- --------------------------------------------------------

--
-- Table structure for table `tablecatrgory`
--

CREATE TABLE `tablecatrgory` (
  `categoryID` int(11) NOT NULL,
  `categoryName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tablecatrgory`
--

INSERT INTO `tablecatrgory` (`categoryID`, `categoryName`) VALUES
(1, 'Điều hoà'),
(2, 'Tủ lạnh'),
(3, 'Máy giặt'),
(4, 'Điện thoại');

-- --------------------------------------------------------

--
-- Table structure for table `tablecustomer`
--

CREATE TABLE `tablecustomer` (
  `customerID` int(11) NOT NULL,
  `userCode` int(11) NOT NULL,
  `FullName` varchar(256) NOT NULL,
  `NumberPhone` int(11) NOT NULL,
  `Email` varchar(256) NOT NULL,
  `Address` varchar(256) NOT NULL,
  `Note` text NOT NULL,
  `ModePay` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tablecustomer`
--

INSERT INTO `tablecustomer` (`customerID`, `userCode`, `FullName`, `NumberPhone`, `Email`, `Address`, `Note`, `ModePay`) VALUES
(1, 123, 'Ngô Xuân Hòa', 987654321, 'hoa@gmail.com', 'hà nội 2', '12345678', 1),
(2, 123, 'Nguyễn Văn B', 12345678, 'hoa_meta222@pretreer.com', 'hoàng mai', '1234567890', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tableorder`
--

CREATE TABLE `tableorder` (
  `orderID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `productAmount` int(11) NOT NULL,
  `ItemCode` varchar(100) NOT NULL,
  `customerID` int(11) NOT NULL,
  `orderDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tableorder`
--

INSERT INTO `tableorder` (`orderID`, `productID`, `productAmount`, `ItemCode`, `customerID`, `orderDate`, `status`) VALUES
(1, 4, 1, '6298', 1, '2023-11-23 17:08:54', 4),
(2, 11, 1, '6298', 1, '2023-11-21 17:44:17', 0),
(3, 13, 2, '3187', 2, '2023-11-18 13:50:57', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tableproducts`
--

CREATE TABLE `tableproducts` (
  `product_ID` int(11) NOT NULL,
  `category_ID` int(11) NOT NULL,
  `product_Name` varchar(255) NOT NULL,
  `product_Price` int(50) NOT NULL,
  `product_PromotionalPrice` int(100) NOT NULL,
  `percent_discounted` float NOT NULL,
  `product_Active` int(11) NOT NULL,
  `product_Hot` int(11) NOT NULL,
  `product_Quatity` int(11) NOT NULL,
  `detailProduct` text NOT NULL,
  `image_1` varchar(50) NOT NULL,
  `image_2` varchar(50) NOT NULL,
  `image_3` varchar(50) NOT NULL,
  `postTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tableproducts`
--

INSERT INTO `tableproducts` (`product_ID`, `category_ID`, `product_Name`, `product_Price`, `product_PromotionalPrice`, `percent_discounted`, `product_Active`, `product_Hot`, `product_Quatity`, `detailProduct`, `image_1`, `image_2`, `image_3`, `postTime`) VALUES
(4, 3, 'Samsung Inverter 8Kg', 7650000, 6840000, 10, 1, 1, 6, 'Cửa trước, Lồng ngang, Có Inverter\\---\\8 Kg, Từ 3 - 5 người\\---\\Truyền động gián tiếp (dây Curoa)\\---\\Giặt nước nóng\\---\\Hẹn giờ giặt Khóa trẻ em Vệ sinh lồng giặt\\---\\Cao 83.7 cm - Ngang 59.5 cm - Sâu 49.3 cm - Nặng 58 kg\\---\\Song ngữ Anh - Việt, có nút xoay, màn hình hiển thị\\---\\Samsung', 'mgSS_1.jpg', 'mgSS_2.jpg', 'mgSS_3.jpg', '2023-08-13 17:42:16'),
(5, 3, 'LG AI DD Inverter 12kg', 8050000, 5990000, 25, 1, 0, 4, 'Cửa trước Lồng ngang, Có Inverter\\---\\12 Kg, Trên 7 người\\---\\Truyền động trực tiếp\\---\\Công nghệ AI DD bảo vệ sợi vải, Công nghệ giặt hơi nước Steam+, Công nghệ TurboWash360\\---\\Cho phép điều khiển máy giặt từ xa qua ứng dụng LG ThinQ, Khóa trẻ emThêm đồ trong khi giặt, Tự khởi động lại khi có điện, Tự động phân bổ nước giặt\\---\\Cao 84 cm - Ngang 59 cm - Sâu 60.7 cm - Nặng 70 kg\\---\\Song ngữ Anh - Việt có nút xoay, cảm ứng và màn hình hiển thị\\---\\LG', 'mgLG_1.jpg', 'mgLG_2.jpg', 'mgLG_3.jpg', '2023-09-23 17:42:16'),
(6, 3, 'Electrolux UltimateCare 300 Inverter 10kg', 6990000, 3990000, 42, 1, 0, 6, 'Cửa trước Lồng ngang, Có Inverter\\---\\10 Kg, Từ 5 - 7 người\\---\\Truyền động gián tiếp (dây Curoa)\\---\\Công nghệ Hygienic Care giúp loại bỏ vi khuẩn, Giặt nước nóng\\---\\Chỉnh số vòng vắt, Giặt sơKhóa trẻ em, Thêm đồ trong khi giặt, Trì hoãn kết thúc, Xả thêm\\---\\Cao 85 cm - Ngang 60 cm - Sâu 70 cm - Nặng 72 kg\\---\\Song ngữ Anh - Việt có nút xoay, cảm ứng và màn hình hiển thị\\---\\Electrolux', 'mgEL_1.jpg', 'mgEL_2.jpg', 'mgEL_3.jpg', '2023-10-14 17:42:16'),
(7, 2, 'Toshiba Inverter 511 lít', 10000000, 8500000, 15, 1, 1, 5, 'Multi Door\\---\\511 lít - 4 - 5 người\\---\\Chế độ kỳ nghỉ tiết kiệm điện, Origin Inverter\\---\\Công nghệ 2 dàn lạnh độc lập, Tấm hợp kim giữ nhiệt Alloy Cooling\\---\\Công nghệ PureBio kết hợp tia Plasma\\---\\Giữ nguyên hương vị với Flexible Zone, Tăng cường dưỡng chất với Moisture Zone\\---\\Bảng điều khiển bên ngoài, Chuông báo khi quên đóng cửaChế độ cấp đông nhanh, Có khóaLàm lạnh nhanh, Ngăn giữ hương vị không cần rã đông Flexible Zone\\---\\Cao 189.8 cm - Rộng 83.3 cm - Sâu 64.8 cm - Nặng 107 kg\\---\\Toshiba\\---\\Trung Quốc\\---\\2020', 'tl_tsb_1.jpg', 'tl_tsb_2.jpg', 'tl_tsb_3.jpg', '2023-11-23 17:42:16'),
(8, 2, 'LG Inverter 217 Lít', 8500000, 6500000, 23, 1, 0, 8, 'Ngăn đá trên\\---\\217 lít - 2 - 3 người\\---\\Inverter\\---\\Linear Cooling\\---\\Bộ lọc than hoạt tính\\---\\Linear Cooling\\---\\\\---\\Cao 144.5 cm - Rộng 55.5 cm - Sâu 63.7 cm - Nặng 46 kg\\---\\LG\\---\\Việt Nam\\---\\2022', 'tl_lg_1.jpg', 'tl_lg_2.jpg', 'tl_lg_3.jpg', '2023-10-23 17:42:16'),
(9, 2, 'Aqua Inverter 456 lít ', 9860000, 6480000, 34, 1, 1, 4, 'Multi Door\\---\\456 lít - 4 - 5 người\\---\\Twin Inverter\\---\\Làm lạnh gián tiếp\\---\\Công nghệ T.ABT kháng khuẩn khử mùi thông minh\\---\\Công nghệ cân bằng độ ẩm HCS, Làm lạnh đa chiều giúp thực phẩm tươi ngon\\---\\Bảng điều khiển cảm ứng bên ngoài cửa tủ, Chế độ kỳ nghỉ, Có khóaNgăn khô và ẩm riêng biệt, Thiết kế hộc tủ có thể kéo ra hoàn toàn khi mở cửa ở 90 độ\\---\\Cao 180.4 cm - Rộng 83.3 cm - Sâu 65.8 cm - Nặng 105 kg\\---\\Aqua\\---\\Thái Lan\\---\\2022', 'tl_aqua_1.jpg', 'tl_aqua_2.jpg', 'tl_aqua_3.jpg', '2023-11-23 17:42:16'),
(10, 1, 'Panasonic Inverter 1 HP', 5300000, 4500000, 15, 1, 0, 15, '1 chiều (chỉ làm lạnh), Có Inverter\\---\\1 HP - 9.040 BTU\\---\\Dưới 15m² (từ 30 đến 45m³)\\---\\Nanoe-G lọc bụi mịn PM 2.5\\---\\ECO tích hợp A.I, Inverter\\---\\Powerful\\---\\Chế độ ngủ đêm Sleep cho người già, trẻ nhỏ. Chức năng khử ẩm. Chức năng tự chẩn đoán lỗiDàn nóng phủ lớp BlueFin chóng ăn mòn. Hoạt động siêu êm Quiet. Hẹn giờ bật tắt máy. Tự khởi động lại khi có điện\\---\\0.8 kW/h, 5 sao (Hiệu suất năng lượng 4.84)\\---\\Dài 77.9 cm - Cao 29 cm - Dày 20.9 cm - Nặng 8 kg\\---\\Dài 72.7 cm - Cao 51.1 cm - Dày 26.6 cm - Nặng 18 kg\\---\\Panasonic', 'dh_pana_1.jpg', 'dh_pana_2.jpg', 'dh_pana_3.jpg', '2023-11-23 17:42:16'),
(11, 1, 'Daikin Inverter 1 HP', 6200000, 5500000, 11, 1, 1, 10, '1 chiều (chỉ làm lạnh), Có Inverter\\---\\1 HP - 9.200 BTU\\---\\Dưới 15m² (từ 30 đến 45m³)\\---\\Lưới lọc bụi, phin lọc chống mốc. Phin lọc Enzyme Blue tích hợp lọc bụi mịn PM2.5\\---\\Inverter, Mắt thần thông minh\\---\\Powerful\\---\\Chức năng chống ẩm mốc kết hợp công nghệ Streamer, Cảm biến khử ẩm Humidity SensorHoạt động siêu êm Quiet, Hẹn giờ bật tắt máy, Luồng gió thoải mái Coanda 3D, Tùy chọn mua thêm bộ điều khiển không dây Daikin Mobile, Tự khởi động lại khi có điện\\---\\0.7 kW/h5 sao (Hiệu suất năng lượng 6.28)\\---\\Dài 83.5 cm - Cao 28.5 cm - Dày 24 cm - Nặng 11 kg\\---\\Dài 75 cm - Cao 55 cm - Dày 30 cm - Nặng 22 kg\\---\\Daikin', 'dh_daikin_1.jpg', 'dh_daikin_2.jpg', 'dh_daikin_3.jpg', '2023-11-23 17:42:16'),
(12, 1, 'Funiki Inverter 1.5 HP', 5860000, 3260000, 44, 1, 0, 8, '1 chiều (chỉ làm lạnh), Có Inverter\\---\\1.5 HP - 12.000 BTU\\---\\Từ 15 - 20m² (từ 40 đến 60 m³)\\---\\Lưới lọc Nano AgLưới lọc Vitamin C + Active Carbon\\---\\Eco, Inverter\\---\\Turbo\\---\\Chức năng tự làm sạch, Kết nối App qua Wifi\\---\\1.03 kW/h, 5 sao (Hiệu suất năng lượng 4.66)\\---\\Dài 80.5 cm - Cao 29.5 cm - Dày 20.5 cm - Nặng 8.9 kg\\---\\Dài 72 cm - Cao 49.5 cm - Dày 27 cm - Nặng 21.7 kg\\---\\Funiki', 'dh_funiki_1.jpg', 'dh_funiki_2.jpg', 'dh_funiki_3.jpg', '2023-11-09 17:42:16'),
(13, 4, ' iPhone X', 23000000, 18400000, 20, 1, 0, 12, 'OLED5.8\\---\\3 GB\\---\\64 GB\\---\\IOS\\---\\2 camera 12 MP\\---\\7 MP\\---\\Apple A11 Bionic\\---\\2716 mAh\\---\\Iphone', 'IPX_1.jpg', 'IPX_2.jpg', 'IPX_3.jpg', '2023-11-23 17:42:16');

-- --------------------------------------------------------

--
-- Table structure for table `tableshoppingcart`
--

CREATE TABLE `tableshoppingcart` (
  `shoppingCart_id` int(11) NOT NULL,
  `category_ID` int(11) NOT NULL,
  `product_ID` int(11) NOT NULL,
  `userCode` int(11) NOT NULL,
  `productName` varchar(250) NOT NULL,
  `productPrice` int(11) NOT NULL,
  `productImage` varchar(100) NOT NULL,
  `productQuantity` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tableslider`
--

CREATE TABLE `tableslider` (
  `slider_ID` int(11) NOT NULL,
  `slider_Image` varchar(100) NOT NULL,
  `slider_Active` int(11) NOT NULL DEFAULT 1,
  `slider_Caption1` text NOT NULL,
  `captionHighlights` text NOT NULL,
  `slider_Caption2` text NOT NULL,
  `category_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tableslider`
--

INSERT INTO `tableslider` (`slider_ID`, `slider_Image`, `slider_Active`, `slider_Caption1`, `captionHighlights`, `slider_Caption2`, `category_ID`) VALUES
(1, 'b1.jpg', 1, 'Get flat 10% Cashback', 'The <span>Big</span> Sale', 'The Big Sale', 1),
(2, 'b2.jpg', 1, 'advanced Wireless earbuds', 'Best <span>Headphone</span>', 'Best Headphone', 3),
(3, 'b3.jpg', 1, 'Get flat 10% Cashback', 'New <span>Standard</span>', 'New Standard', 4),
(4, 'b4.jpg', 1, 'Get Now 40% Discount', 'Today <span>Discount</span>', 'Today Discount', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tabletransaction`
--

CREATE TABLE `tabletransaction` (
  `transaction_id` int(11) NOT NULL,
  `product_ID` int(11) NOT NULL,
  `productName` varchar(150) NOT NULL,
  `customerID` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `productPrice` int(11) NOT NULL,
  `transactionCode` varchar(100) NOT NULL,
  `transactionDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabletransaction`
--

INSERT INTO `tabletransaction` (`transaction_id`, `product_ID`, `productName`, `customerID`, `amount`, `productPrice`, `transactionCode`, `transactionDate`) VALUES
(1, 4, 'Samsung Inverter 8Kg', 1, 1, 6840000, '6298', '2023-11-11 05:09:47'),
(2, 11, 'Daikin Inverter 1 HP', 1, 1, 5500000, '6298', '2023-11-11 05:09:47'),
(3, 13, ' iPhone X', 2, 2, 18400000, '3187', '2023-11-11 05:14:08');

-- --------------------------------------------------------

--
-- Table structure for table `tableuser`
--

CREATE TABLE `tableuser` (
  `userID` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `userCode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tableuser`
--

INSERT INTO `tableuser` (`userID`, `username`, `email`, `password`, `userCode`) VALUES
(1, 'hoadainhan', 'hoa@gmail.com', 'e034fb6b66aacc1d48f445ddfb08da98', 123),
(3, 'hoadainhana', 'hoaa@gmail.com', 'a906449d5769fa7361d7ecc6aa3f6d28', 480),
(2, 'hoa', 'hop@gmail.com', 'd266f2f31cf903c870027659030e967e', 5678);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tableadmin`
--
ALTER TABLE `tableadmin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `tableattributescategory`
--
ALTER TABLE `tableattributescategory`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `FK_CategoryAtbID` (`categoryID`);

--
-- Indexes for table `tablecatrgory`
--
ALTER TABLE `tablecatrgory`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `tablecustomer`
--
ALTER TABLE `tablecustomer`
  ADD PRIMARY KEY (`customerID`),
  ADD KEY `FK_usercode` (`userCode`);

--
-- Indexes for table `tableorder`
--
ALTER TABLE `tableorder`
  ADD PRIMARY KEY (`orderID`);

--
-- Indexes for table `tableproducts`
--
ALTER TABLE `tableproducts`
  ADD PRIMARY KEY (`product_ID`),
  ADD KEY `FK_Categoryid` (`category_ID`);

--
-- Indexes for table `tableshoppingcart`
--
ALTER TABLE `tableshoppingcart`
  ADD PRIMARY KEY (`shoppingCart_id`);

--
-- Indexes for table `tableslider`
--
ALTER TABLE `tableslider`
  ADD PRIMARY KEY (`slider_ID`);

--
-- Indexes for table `tabletransaction`
--
ALTER TABLE `tabletransaction`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `tableuser`
--
ALTER TABLE `tableuser`
  ADD PRIMARY KEY (`userCode`),
  ADD UNIQUE KEY `userID` (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tableadmin`
--
ALTER TABLE `tableadmin`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tableattributescategory`
--
ALTER TABLE `tableattributescategory`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tablecatrgory`
--
ALTER TABLE `tablecatrgory`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tablecustomer`
--
ALTER TABLE `tablecustomer`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `tableorder`
--
ALTER TABLE `tableorder`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tableproducts`
--
ALTER TABLE `tableproducts`
  MODIFY `product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tableshoppingcart`
--
ALTER TABLE `tableshoppingcart`
  MODIFY `shoppingCart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `tableslider`
--
ALTER TABLE `tableslider`
  MODIFY `slider_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tabletransaction`
--
ALTER TABLE `tabletransaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tableuser`
--
ALTER TABLE `tableuser`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tableattributescategory`
--
ALTER TABLE `tableattributescategory`
  ADD CONSTRAINT `FK_CategoryAtbID` FOREIGN KEY (`categoryID`) REFERENCES `tablecatrgory` (`categoryID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tablecustomer`
--
ALTER TABLE `tablecustomer`
  ADD CONSTRAINT `FK_usercode` FOREIGN KEY (`userCode`) REFERENCES `tableuser` (`userCode`);

--
-- Constraints for table `tableproducts`
--
ALTER TABLE `tableproducts`
  ADD CONSTRAINT `FK_Categoryid` FOREIGN KEY (`category_ID`) REFERENCES `tablecatrgory` (`categoryID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
