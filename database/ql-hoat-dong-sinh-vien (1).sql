-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2026 at 06:43 PM
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
  `MaHoatDong` int(11) NOT NULL,
  `MaToChuc` int(11) NOT NULL,
  `TenHoatDong` varchar(250) NOT NULL,
  `DiaDiem` varchar(250) NOT NULL,
  `ThoiGian` datetime NOT NULL,
  `DiemRenLuyen` int(11) NOT NULL,
  `MucCongDiem` varchar(150) NOT NULL,
  `NoiDungHD` text NOT NULL,
  `Token` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `SoDienThoai` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sinhvien`
--

INSERT INTO `sinhvien` (`MSSV`, `MaTaiKhoan`, `MaNghanh`, `HoTen`, `GioiTinh`, `NgaySinh`, `SoDienThoai`) VALUES
('b123', 1, 'Luật Thương', 'Ngoc Han', 0, '2026-06-24', '2354687645'),
('b489615', 3, 'Luật Thương', 'Ngoc Han', 0, '2026-06-24', '2354687645'),
('b489615tcu', 6, 'Luật Thương', 'Ngoc Han', 0, '2026-06-24', '2354687645');

-- --------------------------------------------------------

--
-- Table structure for table `taikhoandangnhap`
--

CREATE TABLE `taikhoandangnhap` (
  `MaTaiKhoan` int(11) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `MatKhau` varchar(100) NOT NULL,
  `Role` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taikhoandangnhap`
--

INSERT INTO `taikhoandangnhap` (`MaTaiKhoan`, `Email`, `MatKhau`, `Role`) VALUES
(1, 'had@gmail.com', '', 0),
(3, 'ha@gmail.com', '', 0),
(6, 'haghjk@gmail.com', 'H123456', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tochuc`
--

CREATE TABLE `tochuc` (
  `MaToChuc` int(10) NOT NULL,
  `MaTaiKhoan` int(11) NOT NULL,
  `MaDonVi` int(10) NOT NULL,
  `TenToChuc` varchar(250) NOT NULL,
  `NgayThanhLap` date NOT NULL,
  `MoTa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  MODIFY `MaTaiKhoan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
