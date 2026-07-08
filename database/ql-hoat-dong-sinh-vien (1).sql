-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2026 at 07:11 PM
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
(50, 'HD0050', 'HD0037', 'mssv', 'Mã số sinh viên'),
(51, 'HD0051', 'HD0037', 'custom', 'aaaaaaaaaaaa'),
(52, 'CH0052', 'HD0043', 'MSSV', 'Mã số sinh viên'),
(53, 'CH0053', 'HD0043', 'HoTen', 'Họ tên'),
(54, 'CH0054', 'HD0043', 'TenNganh', 'Nghành'),
(55, 'CH0055', 'HD0043', 'Khoa', 'Khóa'),
(56, 'CH0056', 'HD0043', 'TenDonVi', 'Đơn vị trường'),
(57, 'CH0057', 'HD0043', 'GioiTinh', 'Giới tính'),
(58, 'CH0058', 'HD0043', 'SoDienThoai', 'Số điện thoại'),
(59, 'CH0059', 'HD0043', 'custom', 'cau hoi 1'),
(60, 'CH0060', 'HD0043', 'custom', 'cau hoi 2'),
(61, 'CH0061', 'HD0043', 'custom', 'cau hoi 3');

-- --------------------------------------------------------

--
-- Table structure for table `cautraloi`
--

CREATE TABLE `cautraloi` (
  `MSSV` varchar(10) NOT NULL,
  `MaHD` int(11) NOT NULL,
  `MaCauHoi` int(11) NOT NULL,
  `NoiDung` text NOT NULL
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
  `MaHoatDong` int(11) NOT NULL,
  `TrangThaiDK` tinyint(1) NOT NULL,
  `DaDiemDanh` tinyint(1) NOT NULL,
  `DaCongDiem` tinyint(1) NOT NULL,
  `ThoiGian` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `TenHoatDong` varchar(250) NOT NULL,
  `NgayTao` datetime NOT NULL DEFAULT current_timestamp(),
  `DiaDiem` varchar(250) NOT NULL,
  `DoiTuongThamGia` varchar(256) NOT NULL,
  `SoLuongToiDa` int(11) NOT NULL DEFAULT 10000000,
  `ThoiGianBatDau` datetime NOT NULL,
  `ThoiGianKetThuc` datetime NOT NULL,
  `DiemRenLuyen` int(11) NOT NULL,
  `NoiDungHD` text NOT NULL,
  `AnhAvt` varchar(256) NOT NULL,
  `AnhBia` varchar(256) NOT NULL,
  `Token` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hoatdong`
--

INSERT INTO `hoatdong` (`Id`, `MaHoatDong`, `MaToChuc`, `MaMucCongDiem`, `TenHoatDong`, `NgayTao`, `DiaDiem`, `DoiTuongThamGia`, `SoLuongToiDa`, `ThoiGianBatDau`, `ThoiGianKetThuc`, `DiemRenLuyen`, `NoiDungHD`, `AnhAvt`, `AnhBia`, `Token`) VALUES
(1, 'HD001', 'HMTN', '0', 'Xuân tình nguyện 2026', '2026-01-10 00:00:00', 'Khu dân cư An Bình', '', 100, '2026-02-15 07:00:00', '2026-02-15 11:30:00', 5, 'Tham gia hỗ trợ người dân và vệ sinh môi trường địa phương', '', '', ''),
(2, 'HD002', 'HMTN', '0', 'Hiến máu nhân đạo', '2026-03-01 00:00:00', 'Hội trường Rùa', '', 50, '2026-04-12 07:30:00', '2026-04-12 11:00:00', 10, 'Phối hợp cùng bệnh viện tổ chức ngày hội hiến máu tình nguyện', '', '', ''),
(3, 'HD003', 'HMTN', '0', 'Ngày hội môi trường xanh', '2026-06-10 00:00:00', 'Sân trường', '', 100, '2026-06-22 07:00:00', '2026-06-22 11:30:00', 8, 'Ra quân thu gom rác và trồng cây trong khuôn viên trường', '', '', ''),
(4, 'HD004', 'HMTN', '0', 'Workshop Kỹ năng lãnh đạo', '2026-06-15 00:00:00', 'Phòng C201', '', 20, '2026-06-22 13:30:00', '2026-06-22 17:00:00', 6, 'Chia sẻ kỹ năng lãnh đạo, quản lý nhóm và giải quyết xung đột', '', '', ''),
(5, 'HD005', 'HMTN', '0', 'Tiếp sức mùa thi 2026', '2026-06-18 00:00:00', 'Cổng trường', '', 30, '2026-07-01 06:00:00', '2026-07-07 17:00:00', 15, 'Hỗ trợ thí sinh và phụ huynh trong kỳ thi tuyển sinh', '', '', ''),
(6, 'HD006', 'HMTN', '0', 'Trung thu yêu thương', '2026-06-20 00:00:00', 'Nhà văn hóa thiếu nhi', '', 40, '2026-09-20 18:00:00', '2026-09-20 21:00:00', 10, 'Tổ chức vui chơi và trao quà cho trẻ em có hoàn cảnh khó khăn', '', '', ''),
(7, 'HD007', 'ECCIT', '0', 'English Speaking Club: Daily Communication', '2026-03-01 00:00:00', 'Phòng E201', '', 50, '2026-04-05 18:00:00', '2026-04-05 20:00:00', 5, 'Buổi sinh hoạt nâng cao kỹ năng giao tiếp tiếng Anh hằng ngày', '', '', ''),
(8, 'HD008', 'ECCIT', '0', 'English Debate Contest 2026', '2026-04-10 00:00:00', 'Hội trường lớn', '', 20, '2026-05-15 18:30:00', '2026-05-15 21:00:00', 10, 'Cuộc thi tranh biện bằng tiếng Anh dành cho sinh viên', '', '', ''),
(9, 'HD009', 'ECCIT', '0', 'English Movie Night', '2026-06-15 00:00:00', 'Phòng đa phương tiện', '', 50, '2026-06-22 18:00:00', '2026-06-22 20:30:00', 5, 'Xem phim tiếng Anh và thảo luận nội dung sau buổi chiếu', '', '', ''),
(10, 'HD010', 'ECCIT', '0', 'IELTS Speaking Workshop', '2026-06-18 00:00:00', 'Phòng B305', '', 30, '2026-06-22 08:00:00', '2026-06-22 11:30:00', 8, 'Chia sẻ kinh nghiệm và thực hành kỹ năng IELTS Speaking', '', '', ''),
(11, 'HD011', 'ECCIT', '0', 'English Camp 2026', '2026-06-20 00:00:00', 'Khu du lịch Mỹ Khánh', '', 40, '2026-07-12 07:00:00', '2026-07-13 17:00:00', 15, 'Trại hè giao tiếp tiếng Anh kết hợp hoạt động nhóm', '', '', ''),
(12, 'HD012', 'ECCIT', '0', 'Talk Show: English for Career Development', '2026-06-21 00:00:00', 'Hội trường A', '', 70, '2026-08-10 18:30:00', '2026-08-10 21:00:00', 10, 'Giao lưu với diễn giả về việc ứng dụng tiếng Anh trong công việc', '', '', ''),
(13, 'HD013', 'HMTN', '0', 'Tập huấn kỹ năng chăm sóc người hiến máu', '2026-07-15 00:00:00', 'Phòng họp Đội tình nguyện', '', 60, '2026-07-26 14:00:00', '2026-07-26 17:00:00', 5, 'Trang bị kiến thức xử lý các trường hợp chóng mặt, ngất xỉu sau hiến máu.', '', '', ''),
(14, 'HD014', 'HMTN', '0', 'Ngày hội Hiến máu khẩn cấp đợt dịch hè', '2026-08-01 00:00:00', 'Bệnh viện Huyết học', '', 100, '2026-08-08 07:30:00', '2026-08-08 11:00:00', 15, 'Đáp ứng nhu cầu nhóm máu O đang khan hiếm trầm trọng tại bệnh viện.', '', '', ''),
(15, 'HD015', 'HMTN', '0', 'Truyền thông Online: Nhận thức về hiến tiểu cầu', '2026-08-10 00:00:00', 'Nền tảng Zoom / Facebook Live', '', 500, '2026-08-18 19:30:00', '2026-08-18 21:00:00', 5, 'Chia sẻ kiến thức chuyên sâu về hiến tiểu cầu và sự khác biệt với hiến máu toàn phần.', '', '', ''),
(16, 'HD016', 'HMTN', '0', 'Sự kiện: Trung thu hồng cho em', '2026-08-25 00:00:00', 'Viện Nhi Trung ương', '', 80, '2026-09-05 15:00:00', '2026-09-05 20:00:00', 8, 'Tổ chức phá cỗ và tặng quà cho các bệnh nhi cần truyền máu định kỳ.', '', '', ''),
(17, 'HD017', 'HMTN', '0', 'Ngày hội hiến máu Chào tân sinh viên', '2026-09-01 00:00:00', 'Nhà thi đấu đa năng', '', 600, '2026-09-15 07:00:00', '2026-09-15 16:30:00', 15, 'Sự kiện lớn nhất quý III nhằm lan tỏa tinh thần tình nguyện đến khóa mới.', '', '', ''),
(18, 'HD018', 'HMTN', '0', 'Giao lưu các CLB Hiến máu tình nguyện cụm', '2026-10-02 00:00:00', 'Hội trường lớn Tòa nhà C', '', 120, '2026-10-10 08:00:00', '2026-10-10 12:00:00', 5, 'Chia sẻ mô hình hoạt động hiệu quả giữa các trường đại học lân cận.', '', '', ''),
(19, 'HD019', 'HMTN', '0', 'Chiến dịch Giọt hồng mùa đông đợt 1', '2026-10-20 00:00:00', 'Sảnh chính khu hiệu bộ', '', 300, '2026-11-05 07:30:00', '2026-11-05 16:00:00', 10, 'Chuỗi sự kiện hiến máu chuẩn bị lượng máu dự trữ cho dịp cuối năm.', '', '', ''),
(20, 'HD020', 'HMTN', '0', 'Gala tổng kết hoạt động hiến máu năm 2026', '2026-11-25 00:00:00', 'Trung tâm sự kiện', '', 200, '2026-12-15 18:00:00', '2026-12-15 21:30:00', 5, 'Vinh danh các tập thể, cá nhân có đóng góp xuất sắc trong phong trào hiến máu.', '', '', ''),
(42, 'HD0042', 'HMTN', 'MCD_D1_02', 'AAAAAAAAAAAAAAAAAAA', '2026-07-08 19:45:49', 'C1', 'all sinh vien', 10, '2026-07-10 19:45:00', '2026-07-11 19:45:00', 2, 'ccccccccccc', '../assets/images/uploads/activity/1783514749_avt_405776173_776660461140059_3826706856496512655_n.jpg', '../assets/images/uploads/activity/1783514749_cover_404006390_776651024474336_8292191653665842130_n.jpg', ''),
(43, 'HD0043', 'HMTN', 'MCD_D1_01', 'HOAT DONG 1', '2026-07-08 23:31:53', 'C1', 'Tat ca sinh vien', 15, '2026-07-15 23:30:00', '2026-07-17 23:30:00', 2, 'ffffffffffffffffffffffffffffffffffffffffffff', '../assets/images/uploads/activity/1783528313_avt_405776173_776660461140059_3826706856496512655_n.jpg', '../assets/images/uploads/activity/1783528313_cover_404006390_776651024474336_8292191653665842130_n.jpg', '');

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
('MCD_D1_01', 'Tham gia các CLB học thuật, hoạt động nghiên cứu khoa học, cuộc thi học thuật cấp Khoa/Trường', 5),
('MCD_D1_02', 'Đạt kết quả học tập loại Giỏi, Xuất sắc hoặc có tiến bộ vượt bậc so với học kỳ trước', 5),
('MCD_D1_03', 'Thành viên đội tuyển tham gia các kỳ thi Olympic, học sinh giỏi cấp Quốc gia/Quốc tế', 10),
('MCD_D2_01', 'Chấp hành nghiêm túc các văn bản pháp luật, nội quy nhà trường và quy chế nội ngoại trú', 15),
('MCD_D2_02', 'Tham gia đầy đủ các buổi sinh hoạt công dân đầu năm, cuối khóa và các buổi sinh hoạt lớp', 10),
('MCD_D3_01', 'Tham gia các hoạt động tình nguyện: Tiếp sức mùa thi, Mùa hè xanh, Hiến máu nhân đạo', 10),
('MCD_D3_02', 'Tham gia các hoạt động văn nghệ, thể thao, ngày hội việc làm do Khoa hoặc Trường tổ chức', 5),
('MCD_D3_03', 'Đạt giải thưởng tại các cuộc thi văn nghệ, thể thao, hội thao cấp Trường trở lên', 5),
('MCD_D4_01', 'Tham gia tuyên truyền pháp luật, giữ gìn trật tự an toàn giao thông, bảo vệ môi trường', 5),
('MCD_D4_02', 'Có thành tích xuất sắc được cơ quan có thẩm quyền biểu dương, khen thưởng về hoạt động xã hội', 10),
('MCD_D5_01', 'Hoàn thành tốt nhiệm vụ Ban cán sự lớp (Lớp trưởng, Lớp phó), Ban chấp hành Chi đoàn/Chi hội', 10),
('MCD_D5_02', 'Hoàn thành tốt nhiệm vụ thuộc Ban chấp hành Đoàn trường, Hội sinh viên trường, Chủ nhiệm CLB', 10);

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
(3, 'admin@gmail.com', 'tuilaadmin', 2);

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
('ECCIT', 2, 'CTU', 'Câu lạc bộ Tiếng Anh', '2016-06-14', 'abc', ''),
('HMTN', 1, 'CTU', 'Câu lạc bộ Hiến Máu Tình Nguyện', '2016-06-14', 'abc', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQNXPYgi9gbPS8NNdoH35F9O8msT5-_fJVd0wa-W-fOoL6vNRtC8FgTYm5F&s=10');

-- --------------------------------------------------------

--
-- Table structure for table `trangthai`
--

CREATE TABLE `trangthai` (
  `MaTrangThai` int(11) NOT NULL,
  `TenTrangThai` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD PRIMARY KEY (`MSSV`,`MaHD`,`MaCauHoi`),
  ADD KEY `MSSV` (`MSSV`),
  ADD KEY `MaHD` (`MaHD`),
  ADD KEY `MaCauHoi` (`MaCauHoi`);

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
  ADD KEY `fk_mcdhd` (`MaMucCongDiem`);

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `donvi`
--
ALTER TABLE `donvi`
  MODIFY `IdDonVi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `hoatdong`
--
ALTER TABLE `hoatdong`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `nganh`
--
ALTER TABLE `nganh`
  MODIFY `IdNghanh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
