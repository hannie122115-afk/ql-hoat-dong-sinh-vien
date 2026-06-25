-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2026 at 05:34 PM
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
-- Table structure for table `cauhoi`
--

CREATE TABLE `cauhoi` (
  `MaCauHoi` int(11) NOT NULL,
  `MaHoatDong` int(11) NOT NULL,
  `NoiDung` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `MaDonVi` varchar(11) NOT NULL,
  `TenDonVi` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donvi`
--

INSERT INTO `donvi` (`MaDonVi`, `TenDonVi`) VALUES
('BK', 'Trường Bách khoa'),
('CN', 'Khoa Công nghệ'),
('CNSTP', 'Viện Công nghệ Sinh học và Thực phẩm'),
('CNTT', 'Trường Công nghệ Thông tin & Truyền thông'),
('CTU', 'Đại học Cần Thơ'),
('DBDT', 'Khoa Dự bị Dân tộc'),
('GDTC', 'Khoa Giáo dục Thể chất'),
('KHCT', 'Khoa Khoa học Chính trị'),
('KHTN', 'Trường Khoa học Tự nhiên'),
('KHXHNV', 'Khoa Khoa học Xã hội & Nhân văn'),
('KT', 'Trường Kinh tế'),
('LUAT', 'Khoa Luật'),
('MT', 'Khoa Môi trường & Tài nguyên Thiên nhiên'),
('NN', 'Trường Nông nghiệp'),
('NNG', 'Khoa Ngoại ngữ'),
('SDAH', 'Khoa Sau đại học'),
('SP', 'Trường Sư phạm'),
('TS', 'Trường Thủy sản');

-- --------------------------------------------------------

--
-- Table structure for table `hoatdong`
--

CREATE TABLE `hoatdong` (
  `MaHoatDong` varchar(11) NOT NULL,
  `MaToChuc` varchar(11) NOT NULL,
  `TenHoatDong` varchar(250) NOT NULL,
  `NgayTao` date NOT NULL,
  `DiaDiem` varchar(250) NOT NULL,
  `SoLuongToiDa` int(11) NOT NULL,
  `ThoiGianBatDau` datetime NOT NULL,
  `ThoiGianKetThuc` datetime NOT NULL,
  `DiemRenLuyen` int(11) NOT NULL,
  `MucCongDiem` varchar(150) NOT NULL,
  `NoiDungHD` text NOT NULL,
  `HinhAnh` varchar(256) NOT NULL,
  `Token` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hoatdong`
--

INSERT INTO `hoatdong` (`MaHoatDong`, `MaToChuc`, `TenHoatDong`, `NgayTao`, `DiaDiem`, `SoLuongToiDa`, `ThoiGianBatDau`, `ThoiGianKetThuc`, `DiemRenLuyen`, `MucCongDiem`, `NoiDungHD`, `HinhAnh`, `Token`) VALUES
('HD001', 'HMTN', 'Xuân tình nguyện 2026', '2026-01-10', 'Khu dân cư An Bình', 100, '2026-02-15 07:00:00', '2026-02-15 11:30:00', 5, 'Hoạt động xã hội', 'Tham gia hỗ trợ người dân và vệ sinh môi trường địa phương', '', ''),
('HD002', 'HMTN', 'Hiến máu nhân đạo', '2026-03-01', 'Hội trường Rùa', 50, '2026-04-12 07:30:00', '2026-04-12 11:00:00', 10, 'Hoạt động xã hội', 'Phối hợp cùng bệnh viện tổ chức ngày hội hiến máu tình nguyện', '', ''),
('HD003', 'HMTN', 'Ngày hội môi trường xanh', '2026-06-10', 'Sân trường', 100, '2026-06-22 07:00:00', '2026-06-22 11:30:00', 8, 'Hoạt động cộng đồng', 'Ra quân thu gom rác và trồng cây trong khuôn viên trường', '', ''),
('HD004', 'HMTN', 'Workshop Kỹ năng lãnh đạo', '2026-06-15', 'Phòng C201', 20, '2026-06-22 13:30:00', '2026-06-22 17:00:00', 6, 'Kỹ năng mềm', 'Chia sẻ kỹ năng lãnh đạo, quản lý nhóm và giải quyết xung đột', '', ''),
('HD005', 'HMTN', 'Tiếp sức mùa thi 2026', '2026-06-18', 'Cổng trường', 30, '2026-07-01 06:00:00', '2026-07-07 17:00:00', 15, 'Hoạt động xã hội', 'Hỗ trợ thí sinh và phụ huynh trong kỳ thi tuyển sinh', '', ''),
('HD006', 'HMTN', 'Trung thu yêu thương', '2026-06-20', 'Nhà văn hóa thiếu nhi', 40, '2026-09-20 18:00:00', '2026-09-20 21:00:00', 10, 'Hoạt động cộng đồng', 'Tổ chức vui chơi và trao quà cho trẻ em có hoàn cảnh khó khăn', '', ''),
('HD007', 'ECCIT', 'English Speaking Club: Daily Communication', '2026-03-01', 'Phòng E201', 50, '2026-04-05 18:00:00', '2026-04-05 20:00:00', 5, 'Kỹ năng mềm', 'Buổi sinh hoạt nâng cao kỹ năng giao tiếp tiếng Anh hằng ngày', '', ''),
('HD008', 'ECCIT', 'English Debate Contest 2026', '2026-04-10', 'Hội trường lớn', 20, '2026-05-15 18:30:00', '2026-05-15 21:00:00', 10, 'Học thuật', 'Cuộc thi tranh biện bằng tiếng Anh dành cho sinh viên', '', ''),
('HD009', 'ECCIT', 'English Movie Night', '2026-06-15', 'Phòng đa phương tiện', 50, '2026-06-22 18:00:00', '2026-06-22 20:30:00', 5, 'Văn hóa', 'Xem phim tiếng Anh và thảo luận nội dung sau buổi chiếu', '', ''),
('HD010', 'ECCIT', 'IELTS Speaking Workshop', '2026-06-18', 'Phòng B305', 30, '2026-06-22 08:00:00', '2026-06-22 11:30:00', 8, 'Học thuật', 'Chia sẻ kinh nghiệm và thực hành kỹ năng IELTS Speaking', '', ''),
('HD011', 'ECCIT', 'English Camp 2026', '2026-06-20', 'Khu du lịch Mỹ Khánh', 40, '2026-07-12 07:00:00', '2026-07-13 17:00:00', 15, 'Kỹ năng mềm', 'Trại hè giao tiếp tiếng Anh kết hợp hoạt động nhóm', '', ''),
('HD012', 'ECCIT', 'Talk Show: English for Career Development', '2026-06-21', 'Hội trường A', 70, '2026-08-10 18:30:00', '2026-08-10 21:00:00', 10, 'Định hướng nghề nghiệp', 'Giao lưu với diễn giả về việc ứng dụng tiếng Anh trong công việc', '', ''),
('HD013', 'HMTN', 'Tập huấn kỹ năng chăm sóc người hiến máu', '2026-07-15', 'Phòng họp Đội tình nguyện', 60, '2026-07-26 14:00:00', '2026-07-26 17:00:00', 5, 'Khuyến khích', 'Trang bị kiến thức xử lý các trường hợp chóng mặt, ngất xỉu sau hiến máu.', '', ''),
('HD014', 'HMTN', 'Ngày hội Hiến máu khẩn cấp đợt dịch hè', '2026-08-01', 'Bệnh viện Huyết học', 100, '2026-08-08 07:30:00', '2026-08-08 11:00:00', 15, 'Xuất sắc', 'Đáp ứng nhu cầu nhóm máu O đang khan hiếm trầm trọng tại bệnh viện.', '', ''),
('HD015', 'HMTN', 'Truyền thông Online: Nhận thức về hiến tiểu cầu', '2026-08-10', 'Nền tảng Zoom / Facebook Live', 500, '2026-08-18 19:30:00', '2026-08-18 21:00:00', 5, 'Khuyến khích', 'Chia sẻ kiến thức chuyên sâu về hiến tiểu cầu và sự khác biệt với hiến máu toàn phần.', '', ''),
('HD016', 'HMTN', 'Sự kiện: Trung thu hồng cho em', '2026-08-25', 'Viện Nhi Trung ương', 80, '2026-09-05 15:00:00', '2026-09-05 20:00:00', 8, 'Tiêu chuẩn', 'Tổ chức phá cỗ và tặng quà cho các bệnh nhi cần truyền máu định kỳ.', '', ''),
('HD017', 'HMTN', 'Ngày hội hiến máu Chào tân sinh viên', '2026-09-01', 'Nhà thi đấu đa năng', 600, '2026-09-15 07:00:00', '2026-09-15 16:30:00', 15, 'Xuất sắc', 'Sự kiện lớn nhất quý III nhằm lan tỏa tinh thần tình nguyện đến khóa mới.', '', ''),
('HD018', 'HMTN', 'Giao lưu các CLB Hiến máu tình nguyện cụm', '2026-10-02', 'Hội trường lớn Tòa nhà C', 120, '2026-10-10 08:00:00', '2026-10-10 12:00:00', 5, 'Tiêu chuẩn', 'Chia sẻ mô hình hoạt động hiệu quả giữa các trường đại học lân cận.', '', ''),
('HD019', 'HMTN', 'Chiến dịch Giọt hồng mùa đông đợt 1', '2026-10-20', 'Sảnh chính khu hiệu bộ', 300, '2026-11-05 07:30:00', '2026-11-05 16:00:00', 10, 'Đặc cách', 'Chuỗi sự kiện hiến máu chuẩn bị lượng máu dự trữ cho dịp cuối năm.', '', ''),
('HD020', 'HMTN', 'Gala tổng kết hoạt động hiến máu năm 2026', '2026-11-25', 'Trung tâm sự kiện', 200, '2026-12-15 18:00:00', '2026-12-15 21:30:00', 5, 'Xuất sắc', 'Vinh danh các tập thể, cá nhân có đóng góp xuất sắc trong phong trào hiến máu.', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `nganh`
--

CREATE TABLE `nganh` (
  `MaNganh` varchar(11) NOT NULL,
  `MaDonVi` varchar(10) NOT NULL,
  `TenNganh` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nganh`
--

INSERT INTO `nganh` (`MaNganh`, `MaDonVi`, `TenNganh`) VALUES
('BK01', 'BK', 'Kỹ thuật Cơ khí (Cơ khí chế tạo máy, Cơ khí ô tô)'),
('BK02', 'BK', 'Kỹ thuật Cơ điện tử'),
('BK03', 'BK', 'Kỹ thuật Điện'),
('BK04', 'BK', 'Tự động hóa'),
('BK05', 'BK', 'Điện tử Viễn thông'),
('BK06', 'BK', 'Kỹ thuật Máy tính (Thiết kế vi mạch bán dẫn)'),
('BK07', 'BK', 'Kỹ thuật Y sinh'),
('BK08', 'BK', 'Kỹ thuật Xây dựng'),
('BK09', 'BK', 'Kỹ thuật Xây dựng Công trình Giao thông'),
('BK10', 'BK', 'Kỹ thuật Thủy lợi'),
('BK11', 'BK', 'Công nghệ Kỹ thuật Hóa học'),
('BK12', 'BK', 'Kỹ thuật Vật liệu'),
('BK13', 'BK', 'Quản lý Công nghiệp'),
('BK14', 'BK', 'Logistics và Quản lý chuỗi cung ứng'),
('CNSTP01', 'CNSTP', 'Ngành Công nghệ Sinh học'),
('CNSTP02', 'CNSTP', 'Ngành Công nghệ Sinh học Tiên tiến'),
('CNSTP03', 'CNSTP', 'Ngành Công nghệ Thực phẩm'),
('CNSTP04', 'CNSTP', 'Ngành Công nghệ Thực phẩm Chất lượng cao'),
('CNSTP05', 'CNSTP', 'Ngành Công nghệ Sau thu hoạch'),
('CNSTP06', 'CNSTP', 'Ngành Công nghệ Chế biến Thủy sản'),
('CNTT01', 'CNTT', 'Công nghệ Thông tin'),
('CNTT02', 'CNTT', 'Công nghệ Thông tin Chất lượng cao'),
('CNTT03', 'CNTT', 'Kỹ thuật Phần mềm'),
('CNTT04', 'CNTT', 'Kỹ thuật Phần mềm chương trình Chất lượng cao'),
('CNTT05', 'CNTT', 'Hệ thống Thông tin'),
('CNTT06', 'CNTT', 'Khoa học Máy tính'),
('CNTT07', 'CNTT', 'Mạng máy tính và Truyền thông dữ liệu'),
('CNTT08', 'CNTT', 'An toàn Thông tin'),
('CNTT09', 'CNTT', 'Truyền thông Đa phương tiện'),
('CNTT10', 'CNTT', 'Trí tuệ Nhân tạo'),
('KHCT01', 'KHCT', 'Chính trị học'),
('KHCT02', 'KHCT', 'Xã hội học'),
('KHCT03', 'KHCT', 'Triết học'),
('KHCT04', 'KHCT', 'Giáo dục Kinh tế và Pháp luật'),
('KHTN01', 'KHTN', 'Khoa học Dữ liệu'),
('KHTN02', 'KHTN', 'Toán Ứng dụng'),
('KHTN03', 'KHTN', 'Thống kê'),
('KHTN04', 'KHTN', 'Hóa học'),
('KHTN05', 'KHTN', 'Hóa dược'),
('KHTN06', 'KHTN', 'Sinh học'),
('KHTN07', 'KHTN', 'Vật lý Kỹ thuật'),
('KHXHNV01', 'KHXHNV', 'Văn học'),
('KHXHNV02', 'KHXHNV', 'Việt Nam học'),
('KHXHNV03', 'KHXHNV', 'Xã hội học'),
('KHXHNV04', 'KHXHNV', 'Quản trị thông tin - Thư viện'),
('KHXHNV05', 'KHXHNV', 'Chính trị học'),
('KHXHNV06', 'KHXHNV', 'Báo chí'),
('KHXHNV07', 'KHXHNV', 'Giáo dục Kinh tế và Pháp luật'),
('KT01', 'KT', 'Quản trị kinh doanh'),
('KT02', 'KT', 'Marketing'),
('KT03', 'KT', 'Kinh doanh quốc tế'),
('KT04', 'KT', 'Kinh doanh thương mại'),
('KT05', 'KT', 'Quản trị dịch vụ du lịch và lữ hành'),
('KT06', 'KT', 'Tài chính – Ngân hàng'),
('KT07', 'KT', 'Kế toán'),
('KT08', 'KT', 'Kiểm toán'),
('KT09', 'KT', 'Kinh tế học'),
('KT10', 'KT', 'Kinh tế nông nghiệp'),
('KT11', 'KT', 'Kinh tế tài nguyên thiên nhiên'),
('LUAT01', 'LUAT', 'Luật Hành chính'),
('LUAT02', 'LUAT', 'Luật Dân sự & Tố tụng dân sự'),
('LUAT03', 'LUAT', 'Luật Thương mại'),
('LUAT04', 'LUAT', 'Luật Kinh tế'),
('MT01', 'MT', 'Khoa học Môi trường'),
('MT02', 'MT', 'Kỹ thuật Môi trường'),
('MT03', 'MT', 'Quản lý Tài nguyên và Môi trường'),
('MT04', 'MT', 'Quản lý Đất đai'),
('MT05', 'MT', 'Kỹ thuật Cấp thoát nước'),
('NN01', 'NN', 'Khoa học cây trồng'),
('NN02', 'NN', 'Nông học'),
('NN03', 'NN', 'Bảo vệ thực vật'),
('NN04', 'NN', 'Công nghệ rau hoa quả và cảnh quan'),
('NN05', 'NN', 'Công nghệ giống cây trồng'),
('NN06', 'NN', 'Chăn nuôi'),
('NN07', 'NN', 'Thú y'),
('NN08', 'NN', 'Sinh học ứng dụng'),
('NNG01', 'NNG', 'Ngôn ngữ Anh'),
('NNG02', 'NNG', 'Ngôn ngữ Pháp'),
('NNG03', 'NNG', 'Phiên dịch - Biên dịch tiếng Anh'),
('NNG04', 'NNG', 'Sư phạm tiếng Anh'),
('NNG05', 'NNG', 'Sư phạm tiếng Pháp'),
('SP01', 'SP', 'Giáo dục Mầm non'),
('SP02', 'SP', 'Giáo dục Tiểu học'),
('SP03', 'SP', 'Giáo dục Công dân'),
('SP04', 'SP', 'Giáo dục Thể chất'),
('SP05', 'SP', 'Sư phạm Toán học'),
('SP06', 'SP', 'Sư phạm Tin học'),
('SP07', 'SP', 'Sư phạm Vật lý'),
('SP08', 'SP', 'Sư phạm Hoá học'),
('SP09', 'SP', 'Sư phạm Sinh học'),
('SP10', 'SP', 'Sư phạm Ngữ văn'),
('SP11', 'SP', 'Sư phạm Lịch sử'),
('SP12', 'SP', 'Sư phạm Địa lý'),
('SP13', 'SP', 'Sư phạm Khoa học Tự nhiên'),
('TS01', 'TS', 'Nuôi trồng thủy sản'),
('TS02', 'TS', 'Nuôi trồng thủy sản (Chương trình tiên tiến)'),
('TS03', 'TS', 'Bệnh học thủy sản'),
('TS04', 'TS', 'Quản lý thủy sản'),
('TS05', 'TS', 'Công nghệ chế biến thủy sản'),
('TS06', 'TS', 'Đảm bảo chất lượng và an toàn thực phẩm');

-- --------------------------------------------------------

--
-- Table structure for table `sinhvien`
--

CREATE TABLE `sinhvien` (
  `MSSV` varchar(10) NOT NULL,
  `MaTaiKhoan` int(11) NOT NULL,
  `MaNghanh` varchar(11) NOT NULL,
  `HoTen` varchar(250) NOT NULL,
  `GioiTinh` tinyint(1) NOT NULL,
  `NgaySinh` date NOT NULL,
  `SoDienThoai` varchar(12) NOT NULL,
  `AnhDaiDien` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sinhvien`
--

INSERT INTO `sinhvien` (`MSSV`, `MaTaiKhoan`, `MaNghanh`, `HoTen`, `GioiTinh`, `NgaySinh`, `SoDienThoai`, `AnhDaiDien`) VALUES
('b123', 1, 'Luật Thương', 'Ngoc Han', 0, '2026-06-24', '2354687645', ''),
('b489615', 3, 'Luật Thương', 'Ngoc Han', 0, '2026-06-24', '2354687645', ''),
('b489615tcu', 6, 'Luật Thương', 'Ngoc Han', 0, '2026-06-24', '2354687645', '');

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
(1, 'clbhienmau@gmail.com', 'clbhienmau', 1),
(2, 'clbtienganh@gmail.com', 'clbtienganh', 1),
(7, 'admin@gmail.com', 'tuilaadmin', 2);

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
-- Indexes for table `cauhoi`
--
ALTER TABLE `cauhoi`
  ADD PRIMARY KEY (`MaCauHoi`),
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
  ADD PRIMARY KEY (`MaDonVi`);

--
-- Indexes for table `hoatdong`
--
ALTER TABLE `hoatdong`
  ADD PRIMARY KEY (`MaHoatDong`),
  ADD KEY `MaToChuc` (`MaToChuc`);

--
-- Indexes for table `nganh`
--
ALTER TABLE `nganh`
  ADD PRIMARY KEY (`MaNganh`),
  ADD KEY `MaDonVi` (`MaDonVi`);

--
-- Indexes for table `sinhvien`
--
ALTER TABLE `sinhvien`
  ADD PRIMARY KEY (`MSSV`),
  ADD KEY `MaTaiKhoan` (`MaTaiKhoan`),
  ADD KEY `MaNghanh` (`MaNghanh`);

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
-- AUTO_INCREMENT for table `taikhoandangnhap`
--
ALTER TABLE `taikhoandangnhap`
  MODIFY `MaTaiKhoan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
