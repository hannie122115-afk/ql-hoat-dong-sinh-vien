-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2026 at 08:40 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ql-hoat-dong-sinh-vien`
--

-- --------------------------------------------------------

--
-- Table structure for table `cauhoidangky`
--

CREATE TABLE `cauhoidangky` (
  `Id` int(11) NOT NULL,
  `MaCauHoi` varchar(11) NOT NULL,
  `MaHoatDong` varchar(11) NOT NULL,
  `LoaiCauHoi` varchar(100) NOT NULL,
  `TenHienThi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cauhoidangky`
--

INSERT INTO `cauhoidangky` (`Id`, `MaCauHoi`, `MaHoatDong`, `LoaiCauHoi`, `TenHienThi`) VALUES
(178, 'CH0178', 'HD0070', 'MSSV', 'Mã số sinh viên'),
(179, 'CH0179', 'HD0070', 'HoTen', 'Họ tên'),
(180, 'CH0180', 'HD0070', 'TenNganh', 'Ngành'),
(181, 'CH0181', 'HD0070', 'Khoa', 'Khóa'),
(182, 'CH0182', 'HD0070', 'SoDienThoai', 'Số điện thoại'),
(183, 'CH0183', 'HD0070', 'custom', 'Bạn đã đọc hết những lưu ý trước khi đăng ký chưa?'),
(214, 'CH0214', 'HD0076', 'MSSV', 'Mã số sinh viên'),
(215, 'CH0215', 'HD0076', 'HoTen', 'Họ tên'),
(216, 'CH0216', 'HD0076', 'TenNganh', 'Ngành'),
(217, 'CH0217', 'HD0076', 'Khoa', 'Khóa'),
(218, 'CH0218', 'HD0076', 'SoDienThoai', 'Số điện thoại'),
(219, 'CH0219', 'HD0077', 'MSSV', 'Mã số sinh viên'),
(220, 'CH0220', 'HD0077', 'HoTen', 'Họ tên'),
(221, 'CH0221', 'HD0077', 'TenNganh', 'Ngành'),
(222, 'CH0222', 'HD0077', 'Khoa', 'Khóa'),
(223, 'CH0223', 'HD0077', 'SoDienThoai', 'Số điện thoại'),
(224, 'CH0224', 'HD0078', 'MSSV', 'Mã số sinh viên'),
(225, 'CH0225', 'HD0078', 'HoTen', 'Họ tên'),
(226, 'CH0226', 'HD0078', 'TenNganh', 'Ngành'),
(227, 'CH0227', 'HD0078', 'Khoa', 'Khóa'),
(228, 'CH0228', 'HD0078', 'SoDienThoai', 'Số điện thoại'),
(229, 'CH0229', 'HD0079', 'MSSV', 'Mã số sinh viên'),
(230, 'CH0230', 'HD0079', 'HoTen', 'Họ tên'),
(231, 'CH0231', 'HD0079', 'TenNganh', 'Ngành'),
(232, 'CH0232', 'HD0079', 'Khoa', 'Khóa'),
(233, 'CH0233', 'HD0080', 'MSSV', 'Mã số sinh viên'),
(234, 'CH0234', 'HD0080', 'HoTen', 'Họ tên'),
(235, 'CH0235', 'HD0080', 'SoDienThoai', 'Số điện thoại'),
(236, 'CH0236', 'HD0080', 'custom', 'Link kết nối với bạn qua Facebook:'),
(237, 'CH0237', 'HD0080', 'custom', 'Bạn đang là sinh viên Trường CĐ/ĐH nào?'),
(238, 'CH0238', 'HD0080', 'custom', 'Câu hỏi dành cho Ban Tổ chức *'),
(239, 'CH0239', 'HD0081', 'MSSV', 'Mã số sinh viên'),
(240, 'CH0240', 'HD0081', 'HoTen', 'Họ tên'),
(241, 'CH0241', 'HD0081', 'TenNganh', 'Ngành'),
(242, 'CH0242', 'HD0081', 'Khoa', 'Khóa'),
(243, 'CH0243', 'HD0082', 'MSSV', 'Mã số sinh viên'),
(244, 'CH0244', 'HD0082', 'HoTen', 'Họ tên'),
(245, 'CH0245', 'HD0082', 'TenNganh', 'Ngành'),
(246, 'CH0246', 'HD0083', 'MSSV', 'Mã số sinh viên'),
(247, 'CH0247', 'HD0083', 'HoTen', 'Họ tên'),
(248, 'CH0248', 'HD0083', 'TenNganh', 'Ngành'),
(249, 'CH0249', 'HD0083', 'Khoa', 'Khóa'),
(250, 'CH0250', 'HD0083', 'TenDonVi', 'Đơn vị trường'),
(251, 'CH0251', 'HD0083', 'SoDienThoai', 'Số điện thoại');

-- --------------------------------------------------------

--
-- Table structure for table `cautraloi`
--

CREATE TABLE `cautraloi` (
  `MSSV` varchar(10) NOT NULL,
  `MaHoatDong` varchar(11) NOT NULL,
  `MaCauHoi` varchar(11) NOT NULL,
  `NoiDung` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cautraloi`
--

INSERT INTO `cautraloi` (`MSSV`, `MaHoatDong`, `MaCauHoi`, `NoiDung`) VALUES
('B1234', 'HD0048', 'CH0087', 'B1234'),
('B1234', 'HD0048', 'CH0088', 'Nani'),
('B1234', 'HD0048', 'CH0089', 'DUNG'),
('B1234', 'HD0062', 'CH0153', 'B1234'),
('B1234', 'HD0062', 'CH0154', 'Nani'),
('B1234', 'HD0062', 'CH0155', 'Hệ thống Thông tin'),
('B1234', 'HD0062', 'CH0156', 'tui tra loi roi'),
('B1234', 'HD0063', 'CH0157', 'B1234'),
('B1234', 'HD0063', 'CH0158', 'Nani'),
('B1234', 'HD0063', 'CH0159', 'Hệ thống Thông tin'),
('B1234', 'HD0063', 'CH0160', 'tra loi ne'),
('B1234', 'HD0070', 'CH0178', 'B1234'),
('B1234', 'HD0070', 'CH0179', 'Nani'),
('B1234', 'HD0070', 'CH0180', 'Hệ thống Thông tin'),
('B1234', 'HD0070', 'CH0181', '49'),
('B1234', 'HD0070', 'CH0182', '0775812920'),
('B1234', 'HD0070', 'CH0183', 'roi');

-- --------------------------------------------------------

--
-- Table structure for table `chitietdiemrenluyen`
--

CREATE TABLE `chitietdiemrenluyen` (
  `MSSV` varchar(10) NOT NULL,
  `MaMucCongDiem` varchar(11) NOT NULL,
  `MaHoatDong` varchar(11) NOT NULL,
  `MaHocKy` varchar(100) NOT NULL,
  `DiemNhanDuoc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chitiettrangthai`
--

CREATE TABLE `chitiettrangthai` (
  `MaHoatDong` int(11) NOT NULL,
  `MaTrangThai` int(11) NOT NULL,
  `ThoiGian` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dangky`
--

CREATE TABLE `dangky` (
  `MSSV` varchar(10) NOT NULL,
  `MaHoatDong` varchar(11) NOT NULL,
  `DaDiemDanh` tinyint(1) NOT NULL DEFAULT 0,
  `DaCongDiem` tinyint(1) NOT NULL DEFAULT 0,
  `ThoiGianDangKy` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dangky`
--

INSERT INTO `dangky` (`MSSV`, `MaHoatDong`, `DaDiemDanh`, `DaCongDiem`, `ThoiGianDangKy`) VALUES
('B1234', 'HD0070', 0, 0, '2026-07-28 18:38:36');

-- --------------------------------------------------------

--
-- Table structure for table `donvi`
--

CREATE TABLE `donvi` (
  `IdDonVi` int(11) NOT NULL,
  `MaDonVi` varchar(11) NOT NULL,
  `TenDonVi` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donvi`
--

INSERT INTO `donvi` (`IdDonVi`, `MaDonVi`, `TenDonVi`) VALUES
(1, 'BK', 'Trường Bách khoa'),
(2, 'CN', 'Khoa Công nghệ'),
(3, 'CNSTP', 'Viện Công nghệ Sinh học và Thực phẩm'),
(4, 'CNTT', 'Trường Công nghệ Thông tin & Truyền thông'),
(5, 'CTU', 'Đại học Cần Thơ'),
(6, 'DBDT', 'Khoa Dự bị Dân tộc'),
(7, 'GDTC', 'Khoa Giáo dục Thể chất'),
(8, 'KHCT', 'Khoa Khoa học Chính trị'),
(9, 'KHTN', 'Trường Khoa học Tự nhiên'),
(10, 'KHXHNV', 'Khoa Khoa học Xã hội & Nhân văn'),
(11, 'KT', 'Trường Kinh tế'),
(12, 'LUAT', 'Khoa Luật'),
(13, 'MT', 'Khoa Môi trường & Tài nguyên Thiên nhiên'),
(14, 'NN', 'Trường Nông nghiệp'),
(15, 'NNG', 'Khoa Ngoại ngữ'),
(16, 'SDAH', 'Khoa Sau đại học'),
(17, 'SP', 'Trường Sư phạm'),
(18, 'TS', 'Trường Thủy sản');

-- --------------------------------------------------------

--
-- Table structure for table `hoatdong`
--

CREATE TABLE `hoatdong` (
  `Id` int(11) NOT NULL,
  `MaHoatDong` varchar(11) NOT NULL,
  `MaToChuc` varchar(11) NOT NULL,
  `MaMucCongDiem` varchar(11) NOT NULL,
  `MaHocKy` varchar(100) NOT NULL,
  `TenHoatDong` varchar(250) NOT NULL,
  `NgayTao` datetime NOT NULL DEFAULT current_timestamp(),
  `DiaDiem` varchar(250) NOT NULL,
  `DoiTuongThamGia` varchar(256) NOT NULL,
  `SoLuongToiDa` int(11) NOT NULL DEFAULT 10000000,
  `ThoiGianBatDau` datetime NOT NULL,
  `ThoiGianKetThuc` datetime NOT NULL,
  `DiemRenLuyen` int(11) NOT NULL,
  `NoiDungHoatDong` text NOT NULL,
  `AnhAvt` varchar(256) NOT NULL,
  `AnhBia` varchar(256) NOT NULL,
  `MaForm` varchar(256) NOT NULL,
  `TrangThaiForm` tinyint(1) NOT NULL DEFAULT 0,
  `LinkForm` text NOT NULL,
  `LinkQr` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hoatdong`
--

INSERT INTO `hoatdong` (`Id`, `MaHoatDong`, `MaToChuc`, `MaMucCongDiem`, `MaHocKy`, `TenHoatDong`, `NgayTao`, `DiaDiem`, `DoiTuongThamGia`, `SoLuongToiDa`, `ThoiGianBatDau`, `ThoiGianKetThuc`, `DiemRenLuyen`, `NoiDungHoatDong`, `AnhAvt`, `AnhBia`, `MaForm`, `TrangThaiForm`, `LinkForm`, `LinkQr`) VALUES
(70, 'HD0070', 'HMTN', 'IV.b', 'HK004', 'CHƯƠNG TRÌNH HIẾN MÁU TÌNH NGUYỆN \"SẮC ĐỎ THANH XUÂN\"] ', '2026-07-29 00:23:54', 'Sảnh Văn phòng Đoàn Đại học Cần Thơ – Khu II, Đại học Cần Thơ.', 'Mọi ', 10000, '2026-08-01 08:00:00', '2026-08-01 11:00:00', 10, 'Thanh xuân không chỉ được lưu giữ qua những kỷ niệm, mà còn được viết nên bằng những việc làm ý nghĩa.\nVới mong muốn lan tỏa tinh thần nhân ái và sự sẻ chia, CLB Hiến máu tình nguyện - Đại học Cần Thơ chính thức tổ chức chương trình hiến máu tình nguyện \"Sắc Đỏ Thanh Xuân\". Mỗi đơn vị máu được trao đi không chỉ là món quà vô giá dành cho người bệnh, mà còn thể hiện tinh thần nhân ái, sự sẻ chia và trách nhiệm cộng đồng.\nHãy cùng CLB HMTN tạo nên \"Sắc Đỏ Thanh Xuân\" bằng những hành động thiết thực. Mỗi giọt máu được trao đi là một nghĩa cử đẹp, góp phần mang đến hy vọng cho người bệnh và làm cho hành trình thanh xuân của mỗi người trở nên ý nghĩa hơn. \n???? Quyền lợi:\n- Được cộng 10 điểm rèn luyện mục IV.b HKI năm học 2026 - 2027\n- Được cấp giấy chứng nhận hiến máu tình nguyện có giá trị bồi hoàn máu\n- Được hỗ trợ chi phí đi lại và quà tặng đến từ bệnh viện\n- Được xác nhận 01 ngày tình nguyện trong tiêu chuẩn 4.2 (Tham gia ít nhất 03 ngày tình nguyện) trong tiêu chí \"Tình nguyện tốt\" của phong trào \"Sinh viên 5 tốt\" cấp Đại học Cần Thơ.\n- Được xác nhận 01 lần hiến máu trong tiêu chuẩn 4.3 (Tham gia ít nhất 02 lần hiến máu tình nguyện) trong tiêu chí \"Tình nguyện tốt\" của phong trào \"Sinh viên 5 tốt\" cấp Đại học Cần Thơ.\nNgoài ra còn được nhận một món quà handmade do chính CLB chuẩn bị ???? \n???? Một vài lưu ý trước khi hiến máu:\n❤️Ngủ đủ giấc, giữ sức khỏe và tinh thần tốt.\n❤️Ăn trước khi đi và uống đủ nước.\n❤️Mang theo CCCD hoặc thẻ sinh viên.\n❤️Không sử dụng đồ uống có cồn hoặc đồ uống chứa chất kích thích trước khi hiến máu.\nĐIỀU KIỆN THAM GIA HIẾN MÁU\n- Người khỏe mạnh, hoàn toàn tự nguyện hiến máu.\n- Tuổi: từ đủ 18 đến 60.\n- Cân nặng: ≥ 42 kg với nữ và ≥ 45kg với nam (đối với hiến 350ml cả nam và nữ đều từ 45kg trở lên)\n- Người khỏe mạnh mỗi lần hiến KHÔNG quá 9 ml/kg cân nặng.\n- Huyết sắc tố: ≥ 125g/l (đối với hiến 350ml).\n- KHÔNG bị nhiễm HIV và các bệnh lây truyền qua đường máu (viêm gan B, viêm gan C, giang mai…).\n- Đối với đã tham gia hiến máu từ lần thứ 2, phải cách lần hiến máu gần nhất trước đó 12 tuần hoặc lần hiến thành phần máu gần nhất trước đó 3 tuần\n- Phụ nữ KHÔNG có thai hoặc KHÔNG nuôi con nhỏ dưới 1 tuổi.\n- Phụ nữ đang KHÔNG trong giai đoạn hành kinh\nMọi thắc mắc xin liên hệ:\n????SĐT: 0388509572 – Trà Như (Chủ nhiệm)\n????Fanpage: Câu lạc bộ Hiến máu tình nguyện – Đại học Cần THơ.\n????Email: clbhienmaudhct@gmail.com\n#CLBHMTNDHCT\n#SacDoThanhXuan \n#HienMauTinhNguyen', '../assets/images/uploads/activity/1785259434_avt_hd1.jfif', '../assets/images/uploads/activity/1785259434_cover_hd1.jfif', '1IXrtdnQH3WpXVhEUq1jybm9HbRx_NDQz5iyksnxEQNE', 0, 'https://docs.google.com/forms/d/e/1FAIpQLScKn6YwVTIwU6JDWg7CpOPrFFrnpUVSWPX6krv5SdvPgcDA5g/viewform', 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=https%3A%2F%2Fdocs.google.com%2Fforms%2Fd%2Fe%2F1FAIpQLScKn6YwVTIwU6JDWg7CpOPrFFrnpUVSWPX6krv5SdvPgcDA5g%2Fviewform'),
(76, 'HD0076', 'HMTN', 'III.a', 'HK003', 'CHƯƠNG TRÌNH HIẾN MÁU TÌNH NGUYỆN \"TRAO GIỌT HỒNG – CHIA SỰ SỐNG\"', '2026-07-21 00:29:07', ' Sảnh Văn phòng Đoàn Đại học Cần Thơ – Khu II, Đại học Cần Thơ', 'Mọi người ', 2147483647, '2026-07-21 07:00:00', '2026-07-21 11:00:00', 10, 'Bạn có biết điều quý giá nhất của mỗi chúng ta là gì không?\nĐó chính là thời gian. Bởi thời gian không chờ đợi bất kỳ ai.\n???? Trong khi chúng ta đang học tập, làm việc và tận hưởng những khoảnh khắc của tuổi trẻ, thì ở đâu đó vẫn có những bệnh nhân đang từng ngày, từng giờ mong chờ một phép màu để được tiếp tục sống.\n???? Phép màu ấy đôi khi không đến từ những điều quá lớn lao, mà bắt đầu từ sự sẻ chia của mỗi chúng ta – một hành động nhỏ nhưng có thể mang đến hy vọng cho nhiều cuộc đời.\n✨ Chúng ta không thể níu giữ thời gian, nhưng chúng ta có thể khiến thời gian trở nên ý nghĩa hơn bằng cách trao đi những giọt máu hồng – trao đi cơ hội sống cho những người đang cần giúp đỡ.\n???? CLB Hiến máu tình nguyện – Đại học Cần Thơ trân trọng thông báo chương trình hiến máu tình nguyện với các nội dung như sau:\n???? Quyền lợi:\n- Được cộng 10 điểm rèn luyện mục IV.b HKIII năm học 2025 - 2026\n- Được cấp giấy chứng nhận hiến máu tình nguyện có giá trị bồi hoàn máu\n- Được hỗ trợ chi phí đi lại và quà tặng đến từ bệnh viện\n- Được xác nhận 01 ngày tình nguyện trong tiêu chuẩn 4.2 (Tham gia ít nhất 03 ngày tình nguyện) trong tiêu chí \"Tình nguyện tốt\" của phong trào \"Sinh viên 5 tốt\" cấp Đại học Cần Thơ.\n- Được xác nhận 01 lần hiến máu trong tiêu chuẩn 4.3 (Tham gia ít nhất 02 lần hiến máu tình nguyện) trong tiêu chí \"Tình nguyện tốt\" của phong trào \"Sinh viên 5 tốt\" cấp Đại học Cần Thơ.\n❤️ Hãy cùng chúng mình dành một chút thời gian quý báu của bản thân để trao giọt hồng – chia sự sống, tiếp tục lan tỏa yêu thương đến cộng đồng nhé!', '../assets/images/uploads/activity/1785259747_avt_hd2.jfif', '../assets/images/uploads/activity/1785259747_cover_hd2.jfif', '1JZ-UDbvtLC4Crus-mkLk7l1BTT_AdKncqIDxx7Eyu84', 0, 'https://docs.google.com/forms/d/e/1FAIpQLSfQo8cSG9P6lBkWIoblGpK7L12DrovCr2CIn5CVR2KgG5JbtQ/viewform', 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=https%3A%2F%2Fdocs.google.com%2Fforms%2Fd%2Fe%2F1FAIpQLSfQo8cSG9P6lBkWIoblGpK7L12DrovCr2CIn5CVR2KgG5JbtQ%2Fviewform'),
(77, 'HD0077', 'HMTN', 'III.a', 'HK003', 'CHƯƠNG TRÌNH HIẾN MÁU TÌNH NGUYỆN “GIỌT HỒNG NHÂN ÁI”', '2026-07-29 00:47:05', 'Sảnh Trường Khoa học Tự nhiên.', 'Mọi người ', 10000, '2026-06-16 07:00:00', '2026-06-16 23:00:00', 10, '????“Hiến máu hôm nay – Thắp sáng ngày mai”\n????Tuổi trẻ Đại học Cần Thơ đang ngày càng phát huy năng lực và lan tỏa tinh thần trách nhiệm trong đời sống học tập và rèn luyện. Trong đó, hoạt động hiến máu tình nguyện đã được duy trì và đang ngày càng đẩy mạnh. Đây là hoạt động tình nguyện mang theo một nghĩa cử cao đẹp , lan tỏa được tinh thần “tương thân tương ái” và hướng đến cộng đồng. Mỗi giọt máu được cho đi với một tấm lòng nhân ái, mang đến niềm tin và hy vọng đến cho những hoàn cảnh khó khăn.\n????Bên cạnh vai trò là một hoạt động tình nguyện, hiến máu còn mang lại giá trị tinh thần cho mỗi cá nhân khi thực hiện một hoạt động mang lại ý nghĩa lớn cho cộng đồng. Đồng thời thể hiện được tinh thần trách nhiệm của cá nhân đối với thực trạng nguồn máu dự trữ đang khan hiếm như hiện nay. Một hành động tuy nhỏ nhưng đang được xem là chiếc phao cứu sinh gửi đến cho những bệnh nhân đang ngày ngày đấu tranh giành lấy sự sống.\n✨Câu lạc bộ Hiến máu tình nguyện – Đại học Cần Thơ phối hợp cùng đơn vị Trường Khoa học Tự nhiên trân trọng thông báo chương trình hiến máu tình nguyện “Giọt hồng nhân ái” diễn ra vào ngày 16/6/2026 với các nội dung như sau:\n----------------------------\n❤ Lưu ý khi tham gia hiến máu:\n✔ Mang theo CMND/CCCD, thẻ sinh viên hoặc giấy tờ tùy thân có ảnh.\n✔ Ăn sáng nhẹ, ngủ đủ giấc và giữ tinh thần thoải mái trước khi hiến máu.\n-------------------\nMọi thắc mắc xin liên hệ:\n????SĐT: 0388509572 – Trà Như (Chủ nhiệm)\n????Fanpage: Câu lạc bộ Hiến máu tình nguyện – Đại học Cần THơ.\n????Email: clbhienmaudhct@gmail.com\n ❣ Mỗi giọt máu cho đi – Một cuộc đời ở lại\n????Rất mong nhận được sự quan tâm và tham gia từ quý Thầy/Cô, các bạn sinh viên và bạn đọc gần xa.', '../assets/images/uploads/activity/1785260825_avt_hd4.jfif', '../assets/images/uploads/activity/1785260825_cover_hd4.jfif', '1h4A3p5Qmo3_sDHzbdT-r0yyy7SE0FpfnKfe1TWJIJ9I', 0, 'https://docs.google.com/forms/d/e/1FAIpQLSf3k-goE6tRi9Iwrja8iE3rUeRC-wKZka2hNh0D6PzsBlUiJg/viewform', 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=https%3A%2F%2Fdocs.google.com%2Fforms%2Fd%2Fe%2F1FAIpQLSf3k-goE6tRi9Iwrja8iE3rUeRC-wKZka2hNh0D6PzsBlUiJg%2Fviewform'),
(78, 'HD0078', 'HMTN', 'III.a', 'HK003', 'CHƯƠNG TRÌNH HIẾN MÁU TÌNH NGUYỆN “SẮC HỒNG TÌNH NGUYỆN”', '2026-07-29 00:51:48', 'Sảnh Văn phòng Đoàn – Khu II – Đại học Cần Thơ.', 'Mọi người ', 10000, '2026-07-01 19:50:00', '2026-07-01 11:30:00', 10, '“Hiến máu cứu người – Trao đời sự sống”\nHiến máu không chỉ là hành động gửi trao đi yêu thương mà còn là một hoạt động nhân văn, mang ý nghĩa to lớn đến cho những cuộc đời kém may mắn. Đối với hiện trạng nguồn máu dự trữ đang thiếu hụt như hiện nay, mỗi giọt máu được trao đi được xem như chiếc phao cứu sinh gửi đến những hoàn cảnh khó khăn. Từ đó, thấy được rằng ở một nơi nào đó trong xã hội, vẫn còn những vòng tay yêu thương đang từng ngày vun đắp lên những hy vọng sống, mỗi giọt máu được cho đi đồng nghĩa với một cuộc đời đang âm thầm quay trở lại. Một hành động tuy nhỏ nhưng mang lại ý nghĩa lớn, lan tỏa lòng nhân ái, tinh thần trách nhiệm đến với cộng đồng và xã hội.\nCâu lạc bộ Hiến máu tình nguyện – Đại học Cần Thơ trân trọng thông báo chương trình hiến máu tình nguyện “SẮC HỒNG TÌNH NGUYỆN” ngày 01/7/2026 sắp tới với những nội dung như sau:\n----------------\nLưu ý khi tham gia hiến máu\nMang theo CMND/CCCD, thẻ sinh viên hoặc giấy tờ tùy thân có ảnh.\nĂn sáng nhẹ, ngủ đủ giấc và giữ tinh thần thoải mái trước khi hiến máu.\n------------------\nMỌI THẮC MẮC XIN LIÊN HỆ:\nSĐT: 0388509572 – Trà Như (Chủ nhiệm)\nFanpage: Câu lạc bộ Hiến máu tình nguyện – Đại học Cần Thơ.\nEmail: clbhienmaudhct@gmail.com\nMỗi giọt máu cho đi – Một cuộc đời ở lại.\nRất mong nhận được sự quan tâm và tham gia từ quý Thầy/Cô, các bạn sinh viên và bạn đọc gần xa.', '../assets/images/uploads/activity/1785261108_avt_hd3.jfif', '../assets/images/uploads/activity/1785261108_cover_hd3.jfif', '1HQgMpx2w7SmEKM7D71PSyQBIzoUEvt9OKMJUyBY7zjw', 0, 'https://docs.google.com/forms/d/e/1FAIpQLScf6pjbzoRecCOYLLyCyDa3k3V8jAFXLfiPMm3ix_BVXsrUbQ/viewform', 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=https%3A%2F%2Fdocs.google.com%2Fforms%2Fd%2Fe%2F1FAIpQLScf6pjbzoRecCOYLLyCyDa3k3V8jAFXLfiPMm3ix_BVXsrUbQ%2Fviewform'),
(79, 'HD0079', 'ECCIT', 'V.a', 'HK004', 'WORKSHOP: ENGLISH HACKS WITH TEAM GEMINI', '2026-07-29 01:00:32', 'Sảnh Văn phòng Đoàn – Khu II – Đại học Cần Thơ.', 'Mọi người ', 10000, '2026-08-07 00:59:00', '2026-08-14 00:59:00', 10, 'Một sân chơi năng động dành cho những ai muốn vừa luyện tiếng Anh, vừa khám phá cách học mới cùng Gemini AI. Không chỉ có thử thách giao tiếp, phản xạ và tư duy, chương trình còn mang đến những “English hacks” thú vị giúp việc học tiếng Anh trở nên nhanh hơn, sáng tạo hơn và bớt áp lực hơn bao giờ hết ✨\n???? Đặc biệt tại English Fair sẽ có 5 booth trò chơi với tổng cộng 125 phần quà hấp dẫn đang chờ bạn chinh phục! Vừa chơi, vừa học, vừa mang quà về thì ngại gì không tham gia nào ????\n????QUYỀN LỢI:\nCộng 2đ mục V.c và xét tiêu chí \"Hội nhập\" trong danh hiệu Sinh viên 5 tốt cho tất cả người tham gia đầy đủ. ', '../assets/images/uploads/activity/1785261632_avt_hd5.jpg', '../assets/images/uploads/activity/1785261632_cover_hd5.jpg', '17n90VKZAt1ifLD0RiHdjv4lig--ljVx9sadOx5HwlpA', 0, 'https://docs.google.com/forms/d/e/1FAIpQLSd17FsladT2mzEMLMdXD8NjIXDNH_9ywK1wvPV-R54uW8fzmA/viewform', 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=https%3A%2F%2Fdocs.google.com%2Fforms%2Fd%2Fe%2F1FAIpQLSd17FsladT2mzEMLMdXD8NjIXDNH_9ywK1wvPV-R54uW8fzmA%2Fviewform'),
(80, 'HD0080', 'DTN', 'V.c', 'HK003', 'KHAI MỞ SỨC MẠNH SÁNG TẠO CÙNG WORKSHOP 1: CREATIVE STUDIO', '2026-07-29 01:08:48', 'Phòng 106/C1, Khu II - Đại học Cần Thơ (Đường 3 Tháng 2, P. Ninh Kiều, TP. Cần Thơ)', 'Mọi người ', 10000, '2026-07-30 18:00:00', '2026-07-30 21:00:00', 2, 'Bạn đam mê sáng tạo nội dung? Bạn muốn nâng tầm tư duy và tối ưu hóa hiệu suất học tập, làm việc lên một tầm cao mới?\nĐừng bỏ lỡ cơ hội tham gia chuỗi sự kiện đặc biệt \"Cùng trở thành Google Student Ambassador Trainer\" với sự kiện khởi động cực cháy: CREATIVE STUDIO - ĐỘT PHÁ SÁNG TẠO, NÂNG CAO HIỆU SUẤT!\n???? DIỄN GIẢ: ThS. Trần Thị Huỳnh Hoa – Google Student Ambassador Trainer. Cô sẽ trực tiếp dẫn dắt và trao tay bạn những \"bí kíp\" đột phá hiệu suất làm việc đỉnh cao nhất!\n???? 4 ĐẶC QUYỀN KHÔNG THỂ BỎ LỠ:\n???? Kiến thức chuẩn Google: Cập nhật tư duy đỉnh cao và các công cụ hỗ trợ sáng tạo tối ưu nhất.\n????️ Thực hành thực chiến: Áp dụng ngay kiến thức tại chỗ, nói KHÔNG với lý thuyết suông.\n???? Cộng điểm rèn luyện: Tham dự sự kiện sẽ được Cộng 02 điểm rèn luyện/buổi vào mục V.c (tham gia hoạt động cấp trường - Học kỳ III, năm học 2025-2026)\n???? Chứng nhận & Quà tặng độc quyền: Nhận chứng nhận tham gia chương trình cùng bộ quà tặng siêu chất (Túi tote, bút Google,...)!\n✨ ĐẶC BIỆT: THAM DỰ HOÀN TOÀN MIỄN PHÍ!', '../assets/images/uploads/activity/1785262128_avt_hd5.jfif', '../assets/images/uploads/activity/1785262128_cover_hd5.jfif', '12sm5WwANslN87R8BEPF_J_6LlPzw4CAq4ChiFXtxm9I', 0, 'https://docs.google.com/forms/d/e/1FAIpQLScgByhrfW5krNExotSG4StfeRXK4rqijzikmqsspXGBfSo-lQ/viewform', 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=https%3A%2F%2Fdocs.google.com%2Fforms%2Fd%2Fe%2F1FAIpQLScgByhrfW5krNExotSG4StfeRXK4rqijzikmqsspXGBfSo-lQ%2Fviewform'),
(81, 'HD0081', 'DTN', 'V.c', 'HK003', 'THƯ MỜI THAM DỰ LỄ KHỞI ĐỘNG CHƯƠNG TRÌNH INSPIRE MEKONG 2026', '2026-07-29 01:11:53', 'Phòng 106/C1, Khu II - Đại học Cần Thơ (Đường 3 Tháng 2, P. Ninh Kiều, TP. Cần Thơ)', 'Mọi người ', 10000, '2026-07-30 20:09:00', '2026-07-31 11:30:00', 2, 'Khơi nguồn sáng tạo trẻ Đồng bằng sông Cửu Long – Thúc đẩy năng lực thích ứng và trao quyền hành động\n➵ Sau chuỗi hoạt động tuyển chọn và tập huấn ban đầu dành cho thanh niên và các đội thi, chương trình INSPIRE Mekong 2026 sẽ chính thức khởi động với sự tham gia của doanh nghiệp, chuyên gia, Viện/Trường, tổ chức phát triển, cơ quan truyền thông và cộng đồng đổi mới sáng tạo trong khu vực.\n???? Chương trình là dịp để các bên cùng gặp gỡ, kết nối và cập nhật các định hướng, hoạt động trọng tâm của INSPIRE Mekong 2026; đồng thời mở ra cơ hội trao đổi, hợp tác nhằm thúc đẩy các sáng kiến ứng dụng công nghệ, AI và STEM cho phát triển bền vững tại Đồng bằng sông Cửu Long.\n???? Thời gian: 08:30 – 11:30, Thứ Sáu ngày 31 tháng 7 năm 2026.\n???? Địa điểm: Tầng 4, Trung tâm học liệu, Đại học Cần Thơ.\n???? Hình thức: Trực tiếp.\n???? Nội dung chương trình:\n???? Tham quan không gian trưng bày mô hình và sản phẩm của 15 đội thi Cluster B.\n???? Gặp gỡ Ban Giám khảo, doanh nghiệp, chuyên gia và các tổ chức đồng hành cùng chương trình.\n???? Hai phiên trình bày của 15 đội thi, giới thiệu các giải pháp ứng dụng công nghệ, AI và STEM nhằm giải quyết các thách thức phát triển bền vững tại Đồng bằng sông Cửu Long.\n???? Giao lưu, kết nối giữa các đội thi, doanh nghiệp, nhà đầu tư và cộng đồng đổi mới sáng tạo. \n???? Lễ trao giải và vinh danh TOP 5 dự án xuất sắc của INSPIRE Mekong 2026.\n???? Giao lưu, kết nối giữa các đội thi, đối tác và cộng đồng đổi mới sáng tạo\n???? Quyền lợi khi tham gia:\n???? Được cộng 2 điểm rèn luyện theo quy định mục V.c tham gia hoạt động cấp trường\n???? Cơ hội kết nối với chuyên gia, doanh nghiệp, tổ chức phát triển và cộng đồng đổi mới sáng tạo trong khu vực\n???? Tham gia teabreak, giao lưu và mở rộng kết nối với sinh viên đến từ nhiều đơn vị, lĩnh vực khác nhau', '../assets/images/uploads/activity/1785262313_avt_hd6.jfif', '../assets/images/uploads/activity/1785262313_cover_hd6.jfif', '19Rzy6ynEsA5NvuJGa87kJiJ0xALOSdjMMS_s5xr4sd4', 0, 'https://docs.google.com/forms/d/e/1FAIpQLSdYien9ie4uXGPsA4RCH4DXH5OtFEFlM5LKTHAj4sh6RtxgXQ/viewform', 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=https%3A%2F%2Fdocs.google.com%2Fforms%2Fd%2Fe%2F1FAIpQLSdYien9ie4uXGPsA4RCH4DXH5OtFEFlM5LKTHAj4sh6RtxgXQ%2Fviewform'),
(82, 'HD0082', 'DTN', 'V.c', 'HK003', '[ĐĂNG KÝ XEM PHIM MIỄN PHÍ] CINETECH - MÙA HÈ SỐ 2026: CƠN MƯA THỊT VIÊN', '2026-07-29 01:15:07', 'Hội trường Rùa, Khu II - Đại học Cần Thơ', 'Mọi người ', 800, '2026-08-05 18:13:00', '2026-08-05 22:13:00', 2, '???? Điều gì sẽ xảy ra khi một nhà phát minh có thể khiến... thức ăn rơi từ trên bầu trời?\n???? Hãy tiếp tục đồng hành cùng \"Mùa hè số 2026\" trong Chương trình CINETECH - Chuỗi chiếu phim chủ đề Khoa học Công nghệ với bộ phim hoạt hình khoa học viễn tưởng nổi tiếng: Cơn Mưa Thịt Viên (Cloudy with a Chance of Meatballs).\n???? Lấy bối cảnh tại một thị trấn nhỏ, bộ phim kể về hành trình của một nhà phát minh trẻ với ước mơ sử dụng khoa học để thay đổi cuộc sống. Khi một phát minh tưởng chừng như kỳ diệu vượt ngoài tầm kiểm soát, những tình huống dở khóc dở cười liên tiếp xảy ra, mang đến nhiều bài học ý nghĩa về sáng tạo, trách nhiệm và tinh thần không ngừng đổi mới. Từ câu chuyện ấy, Mùa hè số 2026 mong muốn lan tỏa niềm đam mê khoa học, công nghệ, chuyển đổi số và trí tuệ nhân tạo đến với các bạn trẻ, khuyến khích tư duy sáng tạo và dám biến ý tưởng thành hiện thực.\n━━━━━━━━━━━━━━━━━━━━\n???? THÔNG TIN SỰ KIỆN CHIẾU PHIM:\n???? Quyền lợi: Cộng 02 điểm rèn luyện/buổi vào mục V.c (tham gia hoạt động cấp trường - Học kỳ III, năm học 2025 - 2026).\n???? Các bạn sinh viên chủ động truy cập https://1.org.vn/sqdkKv để tra cứu danh sách các hoạt động đã được cập nhật điểm danh. Thời gian cập nhật dự kiến từ 01 đến 03 ngày làm việc kể từ ngày tổ chức hoạt động.\n━━━━━━━━━━━━━━━━━━━━\n???? ???? VÉ XEM PHIM 0 ĐỒNG - ĐỔI SÁCH LẤY TÌNH YÊU THƯƠNG!\n????️ Chương trình hoàn toàn MIỄN PHÍ vé vào cửa! Tuy nhiên, thay vì mua vé, BTC thân mời các bạn khi đến xem phim hãy mang theo những quyển truyện tranh cũ hoặc sách cũ (KHÔNG BẮT BUỘC).\n???? Đặc biệt, tại sự kiện, BTC sẽ chuẩn bị sẵn những tấm thiệp xinh xắn để bạn tự tay ghi lại những lời chúc ấm áp nhất gửi kèm theo món quà của mình.\n❓ Những cuốn sách và truyện này sẽ đi về đâu?\n???? Truyện tranh: Sẽ được trao tận tay cho các bé bệnh nhi đang điều trị tại Bệnh viện Huyết học và các em nhỏ tại các mái ấm tình thương, mang đến niềm vui nhỏ bé xoa dịu nỗi đau.\n???? Sách cũ: Sẽ được đóng gói cẩn thận để gửi tặng cho các nhà hưu trí và bổ sung vào các tủ sách vùng biên giới, hải đảo.\n━━━━━━━━━━━━━━━━━━━━\n???? Hãy rủ ngay hội bạn thân cùng đến thưởng thức một bộ phim hoạt hình đầy sáng tạo, khám phá những ý tưởng khoa học thú vị, khơi nguồn cảm hứng đổi mới sáng tạo và cùng lan tỏa yêu thương qua những quyển sách cũ dành tặng cộng đồng. Hẹn gặp bạn tại CINETECH - Mùa hè số 2026 nhé!', '../assets/images/uploads/activity/1785262507_avt_hd7.jfif', '../assets/images/uploads/activity/1785262507_cover_hd7.jfif', '1vWfSwJ9uw_uiss7HlElqZFKHf4zYHpW_-WqIfH0-OIk', 0, 'https://docs.google.com/forms/d/e/1FAIpQLScKKng8mgHECKw2H6T7tHwfr-TcSM1TN7uN37jE4rDUUz5TNw/viewform', 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=https%3A%2F%2Fdocs.google.com%2Fforms%2Fd%2Fe%2F1FAIpQLScKKng8mgHECKw2H6T7tHwfr-TcSM1TN7uN37jE4rDUUz5TNw%2Fviewform'),
(83, 'HD0083', 'CHSVCR', 'V.c', 'HK003', '[TUYỂN TÌNH NGUYỆN VIÊN] HÀNH TRÌNH \"GIEO NẮNG YÊU THƯƠNG\"', '2026-07-29 01:33:57', 'Trường Tiểu học Lê Hồng Phong, phường Phú Lợi, Thành phố Cần Thơ (Sóc Trăng cũ).', 'Mọi người ', 100, '2026-08-06 08:31:00', '2026-08-06 20:32:00', 3, '???? KHI ĐÊM NHẠC KHÉP LẠI – HÀNH TRÌNH MANG NỤ CƯỜI ĐẾN CÁC EM NHỎ BẮT ĐẦU!\nHội trường Trường Sư Phạm trước đó đã tràn ngập những giai điệu thanh âm của sự tử tế. Nhờ vào sự ủng hộ nồng nhiệt từ những tấm vé của các bạn, số tiền quỹ thu được từ Đêm nhạc \"HOÀ ÂM HY VỌNG\" đã sẵn sàng để chuyển hóa thành những phần quà và những niềm vui thiết thực gửi đến các em nhỏ có hoàn cảnh khó khăn.\nNhưng để những \"tia nắng\" này thực sự chạm đến tay các em, tụi mình không thể đi một mình. Tụi mình cần bạn – những trái tim nhiệt huyết, không ngại khó và có cùng nhịp đập yêu thương!\nNội dung công việc:\n1. Ban Hậu cần & Điều phối:\n. Công việc: Chuẩn bị quà cáp, nhu yếu phẩm, phân chia đồ đạc và hỗ trợ quản lý các hoạt động, trò chơi cho các em nhỏ tại địa phương.\n2. Ban Quản trò & Tổ chức trò chơi:\n. Công việc: Lên ý tưởng và trực tiếp dẫn dắt các trò chơi tập thể, khuấy động không khí, mang lại tiếng cười cho các em nhỏ.\n3. Ban Truyền thông & Nhiếp ảnh:\n. Công việc: Ghi lại những khoảnh khắc, nụ cười của các em và các bạn TNV; \nYêu cầu: Biết sử dụng máy ảnh/điện thoại chụp ảnh tốt, có khả năng bắt trọn những khoảnh khắc xúc động.\nTrang phục: Lịch sự thoải mái.\n????QUYỀN LỢI KHI CÁC BẠN ĐỒNG HÀNH CÙNG TỤI MÌNH ????\n1. Được cộng 3 điểm rèn luyện vào mục IV.b\n2. Xét hoàn thành 1 ngày “Tình nguyện tốt” trong phong trào “Sinh viên 5 Tốt”.', '../assets/images/uploads/activity/1785263637_avt_hd7.jpg', '../assets/images/uploads/activity/1785263637_cover_hd7.jpg', '1P_iMjrLZQ3OzR0kkXIbmpW1LiXF6vVwoHWmpvzv_dQw', 0, 'https://docs.google.com/forms/d/e/1FAIpQLSc_HZXcpbzsawWOsfgYd69YhtTCUqQZ0uqgS0BMFo2ogPB3dQ/viewform', 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=https%3A%2F%2Fdocs.google.com%2Fforms%2Fd%2Fe%2F1FAIpQLSc_HZXcpbzsawWOsfgYd69YhtTCUqQZ0uqgS0BMFo2ogPB3dQ%2Fviewform');

-- --------------------------------------------------------

--
-- Table structure for table `hocky`
--

CREATE TABLE `hocky` (
  `MaHocKy` varchar(100) NOT NULL,
  `HocKy` int(1) NOT NULL,
  `NamHoc` varchar(50) NOT NULL,
  `ThoiGianBatDau` date DEFAULT NULL,
  `ThoiGianKetThuc` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hocky`
--

INSERT INTO `hocky` (`MaHocKy`, `HocKy`, `NamHoc`, `ThoiGianBatDau`, `ThoiGianKetThuc`) VALUES
('HK001', 1, '2025 - 2026', '2025-09-08', '2025-12-21'),
('HK002', 2, '2025 - 2026', '2025-12-29', '2026-04-26'),
('HK003', 3, '2025 - 2026', '2026-05-11', '2026-08-23'),
('HK004', 1, '2026 - 2027', '2026-09-07', '2026-12-20'),
('HK005', 2, '2026 - 2027', '2027-01-04', '2027-05-02'),
('HK006', 3, '2026 - 2027', '2027-05-17', '2027-08-29');

-- --------------------------------------------------------

--
-- Table structure for table `muccongdiemrenluyen`
--

CREATE TABLE `muccongdiemrenluyen` (
  `MaMucCongDiem` varchar(11) NOT NULL,
  `TenMucCongDiem` varchar(256) NOT NULL,
  `DiemToiDa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `muccongdiemrenluyen`
--

INSERT INTO `muccongdiemrenluyen` (`MaMucCongDiem`, `TenMucCongDiem`, `DiemToiDa`) VALUES
('II.a', 'Ý thức chấp hành các văn bản chỉ đạo của ngành, của cơ quan chỉ đạo cấp trên được thực hiện trong nhà trường.', 15),
('II.b', 'Ý thức chấp hành các nội quy, quy chế và các quy định khác được áp dụng trong nhà trường.', 20),
('III.a', 'Ý thức và hiệu quả tham gia các hoạt động rèn luyện về chính trị, xã hội, văn hóa, văn nghệ, thể thao.', 12),
('III.b', 'Ý thức tham gia các hoạt động công ích tình nguyện, công tác xã hội.', 8),
('III.c', 'Tham gia tuyên truyền, phòng chống tội phạm và các tệ nạn xã hội.', 24),
('IV.a', 'Ý thức chấp hành và tham gia tuyên truyền các chủ trương của Đảng, chính sách, pháp luật của Nhà nước trong cộng đồng.', 15),
('IV.b', 'Ý thức tham gia các hoạt động xã hội có thành tích được ghi nhận, biểu dương, khen thưởng.', 10),
('IV.c', 'Có tinh thần chia sẻ, giúp đỡ người thân, người có khó khăn, hoạn nạn.', 5),
('V.a', 'Ý thức, tinh thần thái độ, uy tín và hiệu quả công việc của người học được phân công nhiệm vụ quản lý lớp, các tổ chức Đảng, Đoàn thanh niên, Hội sinh viên và các tổ chức khác trong nhà trường.', 10),
('V.b', 'Kỹ năng tổ chức, quản lý lớp, quản lý các tổ chức Đảng, Đoàn thanh niên, Hội sinh viên và các tổ chức khác trong nhà trường.', 18),
('V.c', 'Hỗ trợ và tham gia tích cực vào các hoạt động chung của lớp, tập thể, khoa và nhà trường.', 8),
('V.d', 'Người học đạt được các thành tích đặc biệt trong học tập, rèn luyện.', 29);

-- --------------------------------------------------------

--
-- Table structure for table `nganh`
--

CREATE TABLE `nganh` (
  `IdNghanh` int(11) NOT NULL,
  `MaNganh` varchar(11) NOT NULL,
  `MaDonVi` varchar(10) NOT NULL,
  `TenNganh` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nganh`
--

INSERT INTO `nganh` (`IdNghanh`, `MaNganh`, `MaDonVi`, `TenNganh`) VALUES
(1, 'BK01', 'BK', 'Kỹ thuật Cơ khí (Cơ khí chế tạo máy, Cơ khí ô tô)'),
(2, 'BK02', 'BK', 'Kỹ thuật Cơ điện tử'),
(3, 'BK03', 'BK', 'Kỹ thuật Điện'),
(4, 'BK04', 'BK', 'Tự động hóa'),
(5, 'BK05', 'BK', 'Điện tử Viễn thông'),
(6, 'BK06', 'BK', 'Kỹ thuật Máy tính (Thiết kế vi mạch bán dẫn)'),
(7, 'BK07', 'BK', 'Kỹ thuật Y sinh'),
(8, 'BK08', 'BK', 'Kỹ thuật Xây dựng'),
(9, 'BK09', 'BK', 'Kỹ thuật Xây dựng Công trình Giao thông'),
(10, 'BK10', 'BK', 'Kỹ thuật Thủy lợi'),
(11, 'BK11', 'BK', 'Công nghệ Kỹ thuật Hóa học'),
(12, 'BK12', 'BK', 'Kỹ thuật Vật liệu'),
(13, 'BK13', 'BK', 'Quản lý Công nghiệp'),
(14, 'BK14', 'BK', 'Logistics và Quản lý chuỗi cung ứng'),
(15, 'CNSTP01', 'CNSTP', 'Ngành Công nghệ Sinh học'),
(16, 'CNSTP02', 'CNSTP', 'Ngành Công nghệ Sinh học Tiên tiến'),
(17, 'CNSTP03', 'CNSTP', 'Ngành Công nghệ Thực phẩm'),
(18, 'CNSTP04', 'CNSTP', 'Ngành Công nghệ Thực phẩm Chất lượng cao'),
(19, 'CNSTP05', 'CNSTP', 'Ngành Công nghệ Sau thu hoạch'),
(20, 'CNSTP06', 'CNSTP', 'Ngành Công nghệ Chế biến Thủy sản'),
(21, 'CNTT01', 'CNTT', 'Công nghệ Thông tin'),
(22, 'CNTT02', 'CNTT', 'Công nghệ Thông tin Chất lượng cao'),
(23, 'CNTT03', 'CNTT', 'Kỹ thuật Phần mềm'),
(24, 'CNTT04', 'CNTT', 'Kỹ thuật Phần mềm chương trình Chất lượng cao'),
(25, 'CNTT05', 'CNTT', 'Hệ thống Thông tin'),
(26, 'CNTT06', 'CNTT', 'Khoa học Máy tính'),
(27, 'CNTT07', 'CNTT', 'Mạng máy tính và Truyền thông dữ liệu'),
(28, 'CNTT08', 'CNTT', 'An toàn Thông tin'),
(29, 'CNTT09', 'CNTT', 'Truyền thông Đa phương tiện'),
(30, 'CNTT10', 'CNTT', 'Trí tuệ Nhân tạo'),
(31, 'KHCT01', 'KHCT', 'Chính trị học'),
(32, 'KHCT02', 'KHCT', 'Xã hội học'),
(33, 'KHCT03', 'KHCT', 'Triết học'),
(34, 'KHCT04', 'KHCT', 'Giáo dục Kinh tế và Pháp luật'),
(35, 'KHTN01', 'KHTN', 'Khoa học Dữ liệu'),
(36, 'KHTN02', 'KHTN', 'Toán Ứng dụng'),
(37, 'KHTN03', 'KHTN', 'Thống kê'),
(38, 'KHTN04', 'KHTN', 'Hóa học'),
(39, 'KHTN05', 'KHTN', 'Hóa dược'),
(40, 'KHTN06', 'KHTN', 'Sinh học'),
(41, 'KHTN07', 'KHTN', 'Vật lý Kỹ thuật'),
(42, 'KHXHNV01', 'KHXHNV', 'Văn học'),
(43, 'KHXHNV02', 'KHXHNV', 'Việt Nam học'),
(44, 'KHXHNV03', 'KHXHNV', 'Xã hội học'),
(45, 'KHXHNV04', 'KHXHNV', 'Quản trị thông tin - Thư viện'),
(46, 'KHXHNV05', 'KHXHNV', 'Chính trị học'),
(47, 'KHXHNV06', 'KHXHNV', 'Báo chí'),
(48, 'KHXHNV07', 'KHXHNV', 'Giáo dục Kinh tế và Pháp luật'),
(49, 'KT01', 'KT', 'Quản trị kinh doanh'),
(50, 'KT02', 'KT', 'Marketing'),
(51, 'KT03', 'KT', 'Kinh doanh quốc tế'),
(52, 'KT04', 'KT', 'Kinh doanh thương mại'),
(53, 'KT05', 'KT', 'Quản trị dịch vụ du lịch và lữ hành'),
(54, 'KT06', 'KT', 'Tài chính – Ngân hàng'),
(55, 'KT07', 'KT', 'Kế toán'),
(56, 'KT08', 'KT', 'Kiểm toán'),
(57, 'KT09', 'KT', 'Kinh tế học'),
(58, 'KT10', 'KT', 'Kinh tế nông nghiệp'),
(59, 'KT11', 'KT', 'Kinh tế tài nguyên thiên nhiên'),
(60, 'LUAT01', 'LUAT', 'Luật Hành chính'),
(61, 'LUAT02', 'LUAT', 'Luật Dân sự & Tố tụng dân sự'),
(62, 'LUAT03', 'LUAT', 'Luật Thương mại'),
(63, 'LUAT04', 'LUAT', 'Luật Kinh tế'),
(64, 'MT01', 'MT', 'Khoa học Môi trường'),
(65, 'MT02', 'MT', 'Kỹ thuật Môi trường'),
(66, 'MT03', 'MT', 'Quản lý Tài nguyên và Môi trường'),
(67, 'MT04', 'MT', 'Quản lý Đất đai'),
(68, 'MT05', 'MT', 'Kỹ thuật Cấp thoát nước'),
(69, 'NN01', 'NN', 'Khoa học cây trồng'),
(70, 'NN02', 'NN', 'Nông học'),
(71, 'NN03', 'NN', 'Bảo vệ thực vật'),
(72, 'NN04', 'NN', 'Công nghệ rau hoa quả và cảnh quan'),
(73, 'NN05', 'NN', 'Công nghệ giống cây trồng'),
(74, 'NN06', 'NN', 'Chăn nuôi'),
(75, 'NN07', 'NN', 'Thú y'),
(76, 'NN08', 'NN', 'Sinh học ứng dụng'),
(77, 'NNG01', 'NNG', 'Ngôn ngữ Anh'),
(78, 'NNG02', 'NNG', 'Ngôn ngữ Pháp'),
(79, 'NNG03', 'NNG', 'Phiên dịch - Biên dịch tiếng Anh'),
(80, 'NNG04', 'NNG', 'Sư phạm tiếng Anh'),
(81, 'NNG05', 'NNG', 'Sư phạm tiếng Pháp'),
(82, 'SP01', 'SP', 'Giáo dục Mầm non'),
(83, 'SP02', 'SP', 'Giáo dục Tiểu học'),
(84, 'SP03', 'SP', 'Giáo dục Công dân'),
(85, 'SP04', 'SP', 'Giáo dục Thể chất'),
(86, 'SP05', 'SP', 'Sư phạm Toán học'),
(87, 'SP06', 'SP', 'Sư phạm Tin học'),
(88, 'SP07', 'SP', 'Sư phạm Vật lý'),
(89, 'SP08', 'SP', 'Sư phạm Hoá học'),
(90, 'SP09', 'SP', 'Sư phạm Sinh học'),
(91, 'SP10', 'SP', 'Sư phạm Ngữ văn'),
(92, 'SP11', 'SP', 'Sư phạm Lịch sử'),
(93, 'SP12', 'SP', 'Sư phạm Địa lý'),
(94, 'SP13', 'SP', 'Sư phạm Khoa học Tự nhiên'),
(95, 'TS01', 'TS', 'Nuôi trồng thủy sản'),
(96, 'TS02', 'TS', 'Nuôi trồng thủy sản (Chương trình tiên tiến)'),
(97, 'TS03', 'TS', 'Bệnh học thủy sản'),
(98, 'TS04', 'TS', 'Quản lý thủy sản'),
(99, 'TS05', 'TS', 'Công nghệ chế biến thủy sản'),
(100, 'TS06', 'TS', 'Đảm bảo chất lượng và an toàn thực phẩm');

-- --------------------------------------------------------

--
-- Table structure for table `sinhvien`
--

CREATE TABLE `sinhvien` (
  `MSSV` varchar(10) NOT NULL,
  `MaTaiKhoan` int(11) NOT NULL,
  `MaDonVi` varchar(11) NOT NULL,
  `MaNganh` varchar(11) NOT NULL,
  `HoTen` varchar(250) NOT NULL,
  `Khoa` int(11) NOT NULL,
  `GioiTinh` tinyint(1) NOT NULL,
  `NgaySinh` date NOT NULL,
  `SoDienThoai` varchar(12) NOT NULL,
  `AnhDaiDien` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sinhvien`
--

INSERT INTO `sinhvien` (`MSSV`, `MaTaiKhoan`, `MaDonVi`, `MaNganh`, `HoTen`, `Khoa`, `GioiTinh`, `NgaySinh`, `SoDienThoai`, `AnhDaiDien`) VALUES
('B1234', 0, 'CNTT', 'CNTT05', 'Nani', 49, 0, '2026-07-09', '0775812920', '../assets/images/default/avt-user-default.webp');

-- --------------------------------------------------------

--
-- Table structure for table `taikhoandangnhap`
--

CREATE TABLE `taikhoandangnhap` (
  `MaTaiKhoan` int(11) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `MatKhau` varchar(100) NOT NULL,
  `Role` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taikhoandangnhap`
--

INSERT INTO `taikhoandangnhap` (`MaTaiKhoan`, `Email`, `MatKhau`, `Role`) VALUES
(0, 'nani123@gmail.com', '$2y$10$3gQU.xrlhnULxI10u4DB3.2uJmt5vuHRf.Z3U2NphmAVLGD0z6Go.', 0),
(1, 'clbhienmau@gmail.com', 'clbhienmau', 1),
(2, 'clbtienganh@gmail.com', 'clbtienganh', 1),
(3, 'admin@gmail.com', 'tuilaadmin', 2),
(4, 'doantn@gmail.com', 'doantn', 1),
(5, 'tlx@gmail.com', 'tlx', 1),
(6, 'chsvcairang@gmail.com', 'chsvcairang', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tochuc`
--

CREATE TABLE `tochuc` (
  `MaToChuc` varchar(11) NOT NULL,
  `MaTaiKhoan` int(11) NOT NULL,
  `MaDonVi` varchar(11) NOT NULL,
  `TenToChuc` varchar(250) NOT NULL,
  `NgayThanhLap` date NOT NULL,
  `MoTa` text NOT NULL,
  `AnhDaiDien` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tochuc`
--

INSERT INTO `tochuc` (`MaToChuc`, `MaTaiKhoan`, `MaDonVi`, `TenToChuc`, `NgayThanhLap`, `MoTa`, `AnhDaiDien`) VALUES
('CHSVCR', 6, 'CTU', 'Chi Hội Sinh Viên Cái Răng - Đại Học Cần Thơ', '2017-12-23', 'Nơi sinh viên Đại học Cần Thơ giải đáp các vấn đề học tập và tham gia các hoạt động tình nguyện trên địa bàn phường Cái Răng và phường Hưng Phú', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTSyTVgblnXt17rMW_8AVX8F73HW8NyVrSvjnppQOznFw&s'),
('DTN', 4, 'CTU', 'Đoàn TN - Hội SV Đại học Cần Thơ', '2015-03-18', '', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQtgCilKm5IoLex_m7600EtiRHpCcKdxRXDN8Oput_Pa9DZ3ivQtXb8QCvC&s=10'),
('ECCIT', 2, 'CTU', 'Câu lạc bộ Tiếng Anh Khoa Công nghệ Thông tin và Truyền thông Trường ĐHCT', '2016-06-14', 'ECCIT (English Club of College of Information and Technology CTU) là CLB Tiếng Anh trực thuộc Đoàn Trường Công nghệ thông tin và Truyền thông, Trường Đại học Cần Thơ.', ''),
('HMTN', 1, 'CTU', 'Câu lạc bộ Hiến Máu Tình Nguyện', '2016-06-14', 'abc', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQNXPYgi9gbPS8NNdoH35F9O8msT5-_fJVd0wa-W-fOoL6vNRtC8FgTYm5F&s=10'),
('TLX', 5, 'CTU', 'Câu lạc bộ Tương Lai Xanh - Đại học Cần Thơ', '2026-03-27', 'Vì nụ cười trẻ ', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5yxaFF6rA0WVvYAuxBzKlY6TmriTI7z4BM1KEkVvdPrWnQllLuYrBk-z2&s=10');

-- --------------------------------------------------------

--
-- Table structure for table `trangthai`
--

CREATE TABLE `trangthai` (
  `MaTrangThai` varchar(11) NOT NULL,
  `TenTrangThai` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trangthai`
--

INSERT INTO `trangthai` (`MaTrangThai`, `TenTrangThai`) VALUES
('TT01', 'Sắp diễn ra'),
('TT02', 'Đang diễn ra'),
('TT03', 'Đã kết thúc');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cauhoidangky`
--
ALTER TABLE `cauhoidangky`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `MaCauHoi` (`MaCauHoi`),
  ADD KEY `MaHoatDong` (`MaHoatDong`);

--
-- Indexes for table `cautraloi`
--
ALTER TABLE `cautraloi`
  ADD PRIMARY KEY (`MSSV`,`MaHoatDong`,`MaCauHoi`),
  ADD KEY `MSSV` (`MSSV`),
  ADD KEY `MaHD` (`MaHoatDong`),
  ADD KEY `MaCauHoi` (`MaCauHoi`);

--
-- Indexes for table `chitietdiemrenluyen`
--
ALTER TABLE `chitietdiemrenluyen`
  ADD KEY `sv_drl` (`MSSV`),
  ADD KEY `hk_drl` (`MaHocKy`),
  ADD KEY `mcr_drl` (`MaMucCongDiem`),
  ADD KEY `MaHoatDong` (`MaHoatDong`);

--
-- Indexes for table `chitiettrangthai`
--
ALTER TABLE `chitiettrangthai`
  ADD PRIMARY KEY (`MaHoatDong`,`MaTrangThai`),
  ADD KEY `MaHoatDong` (`MaHoatDong`),
  ADD KEY `MaTrangThai` (`MaTrangThai`);

--
-- Indexes for table `dangky`
--
ALTER TABLE `dangky`
  ADD PRIMARY KEY (`MSSV`,`MaHoatDong`),
  ADD KEY `MSSV` (`MSSV`),
  ADD KEY `MaHoatDong` (`MaHoatDong`);

--
-- Indexes for table `donvi`
--
ALTER TABLE `donvi`
  ADD PRIMARY KEY (`IdDonVi`),
  ADD UNIQUE KEY `MaDonVi` (`MaDonVi`);

--
-- Indexes for table `hoatdong`
--
ALTER TABLE `hoatdong`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `MaHoatDong` (`MaHoatDong`),
  ADD KEY `MaToChuc` (`MaToChuc`),
  ADD KEY `fk_mcdhd` (`MaMucCongDiem`),
  ADD KEY `fk_hkhd` (`MaHocKy`);

--
-- Indexes for table `hocky`
--
ALTER TABLE `hocky`
  ADD PRIMARY KEY (`MaHocKy`);

--
-- Indexes for table `muccongdiemrenluyen`
--
ALTER TABLE `muccongdiemrenluyen`
  ADD PRIMARY KEY (`MaMucCongDiem`);

--
-- Indexes for table `nganh`
--
ALTER TABLE `nganh`
  ADD PRIMARY KEY (`IdNghanh`),
  ADD UNIQUE KEY `MaNganh` (`MaNganh`),
  ADD KEY `MaDonVi` (`MaDonVi`);

--
-- Indexes for table `sinhvien`
--
ALTER TABLE `sinhvien`
  ADD PRIMARY KEY (`MSSV`),
  ADD KEY `MaTaiKhoan` (`MaTaiKhoan`),
  ADD KEY `MaNghanh` (`MaNganh`);

--
-- Indexes for table `taikhoandangnhap`
--
ALTER TABLE `taikhoandangnhap`
  ADD PRIMARY KEY (`MaTaiKhoan`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `tochuc`
--
ALTER TABLE `tochuc`
  ADD PRIMARY KEY (`MaToChuc`),
  ADD KEY `MaTaiKhoan` (`MaTaiKhoan`),
  ADD KEY `MaDonVi` (`MaDonVi`);

--
-- Indexes for table `trangthai`
--
ALTER TABLE `trangthai`
  ADD PRIMARY KEY (`MaTrangThai`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cauhoidangky`
--
ALTER TABLE `cauhoidangky`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT for table `donvi`
--
ALTER TABLE `donvi`
  MODIFY `IdDonVi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `hoatdong`
--
ALTER TABLE `hoatdong`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `nganh`
--
ALTER TABLE `nganh`
  MODIFY `IdNghanh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chitietdiemrenluyen`
--
ALTER TABLE `chitietdiemrenluyen`
  ADD CONSTRAINT `chitietdiemrenluyen_ibfk_1` FOREIGN KEY (`MaHoatDong`) REFERENCES `hoatdong` (`MaHoatDong`),
  ADD CONSTRAINT `hk_drl` FOREIGN KEY (`MaHocKy`) REFERENCES `hocky` (`MaHocKy`),
  ADD CONSTRAINT `mcr_drl` FOREIGN KEY (`MaMucCongDiem`) REFERENCES `muccongdiemrenluyen` (`MaMucCongDiem`),
  ADD CONSTRAINT `sv_drl` FOREIGN KEY (`MSSV`) REFERENCES `sinhvien` (`MSSV`);

--
-- Constraints for table `hoatdong`
--
ALTER TABLE `hoatdong`
  ADD CONSTRAINT `fk_hdtc` FOREIGN KEY (`MaToChuc`) REFERENCES `tochuc` (`MaToChuc`),
  ADD CONSTRAINT `fk_hkhd` FOREIGN KEY (`MaHocKy`) REFERENCES `hocky` (`MaHocKy`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
