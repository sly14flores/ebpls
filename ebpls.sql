-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 03, 2015 at 10:13 AM
-- Server version: 5.6.20
-- PHP Version: 5.4.31

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ebpls`
--

-- --------------------------------------------------------

--
-- Table structure for table `aba_items`
--

CREATE TABLE IF NOT EXISTS `aba_items` (
  `aba_item_id` int(10) NOT NULL AUTO_INCREMENT,
  `aba_item_fid` int(4) unsigned zerofill NOT NULL,
  `aba_item_assessment` int(10) NOT NULL,
  `aba_item_amount` float NOT NULL,
  `aba_item_assessed_by` int(10) NOT NULL,
  `aba_item_not_applicable` int(10) NOT NULL,
  `aba_item_custom` int(11) NOT NULL,
  `aba_item_aid` int(10) NOT NULL,
  PRIMARY KEY (`aba_item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `account_id` int(10) NOT NULL AUTO_INCREMENT,
  `account_username` varchar(50) NOT NULL,
  `account_password` varchar(50) NOT NULL,
  `account_fname` varchar(100) NOT NULL,
  `account_mname` varchar(100) NOT NULL,
  `account_lname` varchar(100) NOT NULL,
  `account_privileges` int(10) NOT NULL,
  `account_contact` varchar(50) NOT NULL,
  `account_title_position` varchar(100) NOT NULL,
  `account_email` varchar(50) NOT NULL,
  `account_department` int(10) NOT NULL,
  `account_date_registered` datetime NOT NULL,
  `account_log` text NOT NULL,
  `is_login` int(1) NOT NULL,
  `account_aid` int(10) NOT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `account_username`, `account_password`, `account_fname`, `account_mname`, `account_lname`, `account_privileges`, `account_contact`, `account_title_position`, `account_email`, `account_department`, `account_date_registered`, `account_log`, `is_login`, `account_aid`) VALUES
(6, 'francis', '4x9KRei2icsJsv0mMsPqsDKY1rwSlhu6Bp1/RAf2HxM=', 'Francisco Angelito', 'L.', 'Fontanilla', 0, '', 'Municipal Mayor', '', 6, '2014-12-22 07:00:43', '', 0, 1),
(5, 'jocelyn', 'SMQzvHARANPS0/sasUTMbFXkMRtrlgOLfwJLNU7E4lE=', 'Jocelyn', 'G.', 'Estandian', 0, '', 'OIC-Municipal Treasurer', '', 1, '2014-12-20 21:36:01', '', 0, 1),
(4, 'amado', 'V07cOnat9yGKxuTNqsurnHRLdCXJ1L5V2CMms3Zjbm0=', 'Amado', 'B.', 'Valmores', 0, '', 'LRCO III', '', 1, '2014-12-20 21:35:23', '', 0, 1),
(3, 'mario', 'ooQwLKvPzLT28tYh/GxsT8lFTU5AEtEGUQ8NgkAKoMQ=', 'Mario', 'Halaman', 'Ilagan', 0, '', 'Administrator', '', 8, '2014-12-19 01:59:30', '', 0, 1),
(1, 'admin', 'QrUgcNdRjaE74hfEIeThKa/RaqA9N/KpBI+X7VeiyfE=', 'Sly', 'Bulilan', 'Flores', 1114, '', 'Software Engineer', '', 8, '2014-12-17 00:00:00', '', 1, 0),
(7, 'vannie', 'R/wtuvvLTQcoNrcP4B8ybMx5HpkN1l6+eIuOU5TuJTY=', 'Vannie', 'Valmores', 'Partible', 0, '', '', '', 1, '2014-12-29 11:37:08', '', 0, 1),
(8, 'elma', 'L37EYcNCv++yAhtsHMpTm77jK6R63cduc6IS+MPgQfg=', 'Elma', 'Ancheta', 'Quinque', 0, '', '', '', 1, '2014-12-29 11:39:15', '', 0, 1),
(9, 'mho', 'hXe6hDuaRlEnRdF52BlR+XZ6Pz8Id3ZoXnwVWUmeMoI=', 'Annabelle', 'O', 'Pada, M.D.', 0, '', 'Municipal Health Officer', '', 3, '2014-12-29 14:36:08', '', 0, 1),
(10, 'eng', 'ZFi6I981BgsZFOhjrPw+KeK3Tht6mu/ZRN08TFakBYI=', 'Zaldy', 'Difuntorum', 'Almoite', 0, '', '', '', 4, '2014-12-29 14:37:26', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `applicant_profiles`
--

CREATE TABLE IF NOT EXISTS `applicant_profiles` (
  `applicant_profile_id` int(10) NOT NULL AUTO_INCREMENT,
  `application_form` varchar(20) NOT NULL,
  `application_amendment` varchar(50) NOT NULL,
  `application_mode_of_payment` varchar(20) NOT NULL,
  `application_reference_no` varchar(50) NOT NULL,
  `application_dti_sec_cda` varchar(50) NOT NULL,
  `application_dti_sec_cda_date` date NOT NULL,
  `application_organization_type` varchar(50) NOT NULL,
  `application_ctc_no` varchar(50) NOT NULL,
  `application_ctc_date` date NOT NULL,
  `application_tin` varchar(50) NOT NULL,
  `application_entity` varchar(100) NOT NULL,
  `application_taxpayer_lastname` varchar(50) NOT NULL,
  `application_taxpayer_firstname` varchar(50) NOT NULL,
  `application_taxpayer_middlename` varchar(50) NOT NULL,
  `application_taxpayer_gender` varchar(10) NOT NULL,
  `application_taxpayer_business_name` varchar(50) NOT NULL,
  `application_trade_franchise` varchar(100) NOT NULL,
  `application_treasurer_lastname` varchar(50) NOT NULL,
  `application_treasurer_firstname` varchar(50) NOT NULL,
  `application_treasurer_middlename` varchar(50) NOT NULL,
  `application_business_address_no` varchar(10) NOT NULL,
  `application_business_address_bldg` varchar(50) NOT NULL,
  `application_business_address_unit_no` varchar(10) NOT NULL,
  `application_business_address_street` varchar(50) NOT NULL,
  `application_business_address_brgy` varchar(50) NOT NULL,
  `application_business_address_subd` varchar(50) NOT NULL,
  `application_business_address_mun_city` varchar(50) NOT NULL,
  `application_business_address_province` varchar(50) NOT NULL,
  `application_business_address_tel_no` varchar(50) NOT NULL,
  `application_business_address_email` varchar(50) NOT NULL,
  `application_owner_address_no` varchar(10) NOT NULL,
  `application_owner_address_bldg` varchar(50) NOT NULL,
  `application_owner_address_unit_no` varchar(10) NOT NULL,
  `application_owner_address_street` varchar(50) NOT NULL,
  `application_owner_address_brgy` varchar(50) NOT NULL,
  `application_owner_address_subd` varchar(50) NOT NULL,
  `application_owner_address_mun_city` varchar(50) NOT NULL,
  `application_owner_address_province` varchar(50) NOT NULL,
  `application_owner_address_tel_no` varchar(50) NOT NULL,
  `application_owner_address_email` varchar(50) NOT NULL,
  `application_pin` varchar(50) NOT NULL,
  `application_business_area` varchar(50) NOT NULL,
  `application_no_employees` varchar(10) NOT NULL,
  `application_no_residing` varchar(10) NOT NULL,
  `application_business_rented` varchar(50) NOT NULL,
  `application_lessor_lastname` varchar(50) NOT NULL,
  `application_lessor_firstname` varchar(50) NOT NULL,
  `application_lessor_middlename` varchar(50) NOT NULL,
  `application_monthly_rental` float NOT NULL,
  `application_lessor_address_no` varchar(10) NOT NULL,
  `application_lessor_address_street` varchar(50) NOT NULL,
  `application_lessor_address_brgy` varchar(50) NOT NULL,
  `application_lessor_address_subd` varchar(50) NOT NULL,
  `application_lessor_address_mun_city` varchar(50) NOT NULL,
  `application_lessor_address_province` varchar(50) NOT NULL,
  `application_lessor_address_tel_no` varchar(50) NOT NULL,
  `application_lessor_address_email` varchar(50) NOT NULL,
  `application_contact_person` varchar(200) NOT NULL,
  `application_position_title` varchar(100) NOT NULL,
  `application_date_issued` date NOT NULL,
  PRIMARY KEY (`applicant_profile_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE IF NOT EXISTS `applications` (
  `application_id` int(4) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `application_no` varchar(20) NOT NULL,
  `application_form` varchar(20) NOT NULL,
  `application_amendment` varchar(50) NOT NULL,
  `application_mode_of_payment` varchar(20) NOT NULL,
  `application_date` datetime NOT NULL,
  `application_reference_no` varchar(50) NOT NULL,
  `application_dti_sec_cda` varchar(50) NOT NULL,
  `application_dti_sec_cda_date` date NOT NULL,
  `application_organization_type` varchar(50) NOT NULL,
  `application_ctc_no` varchar(50) NOT NULL,
  `application_ctc_date` date NOT NULL,
  `application_tin` varchar(50) NOT NULL,
  `application_entity` varchar(100) NOT NULL,
  `application_taxpayer_lastname` varchar(50) NOT NULL,
  `application_taxpayer_firstname` varchar(50) NOT NULL,
  `application_taxpayer_middlename` varchar(50) NOT NULL,
  `application_taxpayer_gender` varchar(10) NOT NULL,
  `application_taxpayer_business_name` varchar(50) NOT NULL,
  `application_trade_franchise` varchar(100) NOT NULL,
  `application_treasurer_lastname` varchar(50) NOT NULL,
  `application_treasurer_firstname` varchar(50) NOT NULL,
  `application_treasurer_middlename` varchar(50) NOT NULL,
  `application_business_address_no` varchar(10) NOT NULL,
  `application_business_address_bldg` varchar(50) NOT NULL,
  `application_business_address_unit_no` varchar(10) NOT NULL,
  `application_business_address_street` varchar(50) NOT NULL,
  `application_business_address_brgy` varchar(50) NOT NULL,
  `application_business_address_subd` varchar(50) NOT NULL,
  `application_business_address_mun_city` varchar(50) NOT NULL,
  `application_business_address_province` varchar(50) NOT NULL,
  `application_business_address_tel_no` varchar(50) NOT NULL,
  `application_business_address_email` varchar(50) NOT NULL,
  `application_owner_address_no` varchar(10) NOT NULL,
  `application_owner_address_bldg` varchar(50) NOT NULL,
  `application_owner_address_unit_no` varchar(10) NOT NULL,
  `application_owner_address_street` varchar(50) NOT NULL,
  `application_owner_address_brgy` varchar(50) NOT NULL,
  `application_owner_address_subd` varchar(50) NOT NULL,
  `application_owner_address_mun_city` varchar(50) NOT NULL,
  `application_owner_address_province` varchar(50) NOT NULL,
  `application_owner_address_tel_no` varchar(50) NOT NULL,
  `application_owner_address_email` varchar(50) NOT NULL,
  `application_pin` varchar(50) NOT NULL,
  `application_business_area` varchar(50) NOT NULL,
  `application_no_employees` varchar(10) NOT NULL,
  `application_no_residing` varchar(10) NOT NULL,
  `application_business_rented` varchar(50) NOT NULL,
  `application_lessor_lastname` varchar(50) NOT NULL,
  `application_lessor_firstname` varchar(50) NOT NULL,
  `application_lessor_middlename` varchar(50) NOT NULL,
  `application_monthly_rental` float NOT NULL,
  `application_lessor_address_no` varchar(10) NOT NULL,
  `application_lessor_address_street` varchar(50) NOT NULL,
  `application_lessor_address_brgy` varchar(50) NOT NULL,
  `application_lessor_address_subd` varchar(50) NOT NULL,
  `application_lessor_address_mun_city` varchar(50) NOT NULL,
  `application_lessor_address_province` varchar(50) NOT NULL,
  `application_lessor_address_tel_no` varchar(50) NOT NULL,
  `application_lessor_address_email` varchar(50) NOT NULL,
  `application_contact_person` varchar(200) NOT NULL,
  `application_position_title` varchar(100) NOT NULL,
  `application_date_issued` date NOT NULL,
  PRIMARY KEY (`application_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `application_business_activities`
--

CREATE TABLE IF NOT EXISTS `application_business_activities` (
  `aba_id` int(10) NOT NULL AUTO_INCREMENT,
  `aba_fid` int(4) unsigned zerofill NOT NULL,
  `aba_code` int(10) NOT NULL,
  `aba_b_line` int(10) NOT NULL,
  `aba_units` int(10) NOT NULL,
  `aba_gross_base` varchar(50) NOT NULL,
  `aba_gross_amount` float NOT NULL,
  `aba_date` datetime NOT NULL,
  `aba_aid` int(10) NOT NULL,
  PRIMARY KEY (`aba_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `application_verifications`
--

CREATE TABLE IF NOT EXISTS `application_verifications` (
  `verification_id` int(11) NOT NULL AUTO_INCREMENT,
  `verification_fid` int(4) unsigned zerofill NOT NULL,
  `verification_verification_id` int(10) NOT NULL,
  `verification_issued` datetime NOT NULL,
  `verification_verified_by` int(10) NOT NULL,
  PRIMARY KEY (`verification_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

CREATE TABLE IF NOT EXISTS `assessments` (
  `assessment_id` int(10) NOT NULL AUTO_INCREMENT,
  `assessment_order` int(10) NOT NULL,
  `assessment_type` varchar(50) NOT NULL,
  `assessment_description` varchar(250) NOT NULL,
  `assessment_reference` varchar(50) NOT NULL,
  `assessment_note` varchar(50) NOT NULL,
  `assessment_date` datetime NOT NULL,
  `assessment_aid` int(10) NOT NULL,
  PRIMARY KEY (`assessment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `assessments`
--

INSERT INTO `assessments` (`assessment_id`, `assessment_order`, `assessment_type`, `assessment_description`, `assessment_reference`, `assessment_note`, `assessment_date`, `assessment_aid`) VALUES
(1, 0, 'local_taxes', 'Gross Sales Tax', 'M.O. 2012-75', '', '2014-11-30 16:15:29', 1),
(2, 0, 'local_taxes', 'Retail - Cigars & Cigts.', '', '', '2014-11-30 16:18:16', 1),
(3, 0, 'local_taxes', 'Retail - Fermented Liquor', '', '', '2014-11-30 16:18:31', 1),
(4, 0, 'local_taxes', 'Retail - Domestic Liqour', '', '', '2014-11-30 16:18:48', 1),
(5, 0, 'local_taxes', 'Tax on delivery vans/trucks', '', '', '2014-11-30 16:18:58', 1),
(6, 0, 'local_taxes', 'Tax on storage for combustible/flammable or explosive substance', '', '', '2014-11-30 16:19:29', 1),
(7, 0, 'local_taxes', 'Tax on signboard/billboards', '', '', '2014-11-30 16:19:48', 1),
(8, 0, 'fees_charges', 'Mayor''s Permit Fee', '', '', '2014-11-30 21:38:08', 1),
(9, 0, 'fees_charges', 'Garbage Charges', '', '', '2014-11-30 21:38:26', 1),
(10, 0, 'fees_charges', 'Water Fee', '', '', '2014-11-30 21:38:38', 1),
(11, 0, 'fees_charges', 'Business Plate No.', '', '', '2014-11-30 21:38:56', 1),
(12, 0, 'fees_charges', 'Delivery Trucks/Vans Permit Fee', '', '', '2014-11-30 21:40:06', 1),
(13, 0, 'fees_charges', 'Sanitary Inspection Fee', '', '', '2014-11-30 21:40:31', 1),
(14, 0, 'fees_charges', 'Building Inspection Fee', '', '', '2014-11-30 21:40:45', 1),
(15, 0, 'fees_charges', 'Electrical Inspection Fee', '', '', '2014-11-30 21:41:04', 1),
(16, 0, 'fees_charges', 'Mechanical Inspection Fee', '', '', '2014-11-30 21:41:23', 1),
(17, 0, 'fees_charges', 'Plumbing Inspection Fee', '', '', '2014-11-30 21:41:46', 1),
(18, 0, 'fees_charges', 'Signboard/Billboard Renewal Fee', '', '', '2014-11-30 21:42:11', 1),
(19, 0, 'fees_charges', 'Signboard/Billboard Permit Fee', '', '', '2014-11-30 21:43:04', 1),
(20, 0, 'fees_charges', 'Storage and Sale of Cumbustible/Flammable or Explosive Substance', '', '', '2014-11-30 21:43:56', 1);

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE IF NOT EXISTS `billing` (
  `payment_schedule_id` int(10) NOT NULL AUTO_INCREMENT,
  `payment_schedule_fid` int(4) unsigned zerofill NOT NULL,
  `payment_schedule_payment_mode` varchar(20) NOT NULL,
  `payment_schedule_duedate` date NOT NULL,
  `payment_schedule_due_amount` float NOT NULL,
  `payment_schedule_penalty` int(10) NOT NULL,
  `payment_schedule_or` varchar(50) NOT NULL,
  `payment_schedule_payment` float NOT NULL,
  `payment_schedule_date` date NOT NULL,
  `payment_schedule_date_paid` date NOT NULL,
  `payment_schedule_aid` int(10) NOT NULL,
  PRIMARY KEY (`payment_schedule_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `business_activities`
--

CREATE TABLE IF NOT EXISTS `business_activities` (
  `ba_id` int(10) NOT NULL AUTO_INCREMENT,
  `ba_organization` varchar(50) NOT NULL,
  `ba_cen` varchar(50) NOT NULL,
  `ba_code` varchar(50) NOT NULL,
  `ba_line` varchar(150) NOT NULL,
  `ba_note` varchar(250) NOT NULL,
  `ba_date` datetime NOT NULL,
  `ba_aid` int(10) NOT NULL,
  PRIMARY KEY (`ba_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `business_activities`
--

INSERT INTO `business_activities` (`ba_id`, `ba_organization`, `ba_cen`, `ba_code`, `ba_line`, `ba_note`, `ba_date`, `ba_aid`) VALUES
(1, 'All', 'essential', '', 'Retailers', '', '2014-12-15 22:46:16', 1),
(2, 'All', 'essential', '', 'Manufacturers', '', '2014-12-15 22:49:30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `business_activity_items`
--

CREATE TABLE IF NOT EXISTS `business_activity_items` (
  `ba_item_id` int(10) NOT NULL AUTO_INCREMENT,
  `ba_item_baid` int(10) NOT NULL,
  `ba_assessment_id` int(10) NOT NULL,
  `ba_item_is_tax` int(10) NOT NULL,
  `ba_item_tax_formula` int(10) NOT NULL,
  `ba_item_amount` float NOT NULL,
  `ba_item_penalty` varchar(100) NOT NULL,
  `ba_item_date` datetime NOT NULL,
  `ba_item_aid` int(10) NOT NULL,
  PRIMARY KEY (`ba_item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `business_activity_items`
--

INSERT INTO `business_activity_items` (`ba_item_id`, `ba_item_baid`, `ba_assessment_id`, `ba_item_is_tax`, `ba_item_tax_formula`, `ba_item_amount`, `ba_item_penalty`, `ba_item_date`, `ba_item_aid`) VALUES
(1, 1, 1, 1, 3, 0, '', '2014-12-15 22:46:24', 1),
(2, 2, 1, 1, 2, 0, '', '2014-12-15 22:49:40', 1),
(3, 1, 8, 0, 0, 500, '', '2014-12-15 23:06:39', 1),
(4, 2, 8, 0, 0, 500, '', '2014-12-15 23:06:50', 1),
(5, 1, 12, 0, 0, 100, '', '2014-12-21 08:40:18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `department_id` int(10) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(100) NOT NULL,
  `department_head` int(10) NOT NULL,
  `department_note` varchar(100) NOT NULL,
  `department_aid` int(10) NOT NULL,
  `department_date_added` datetime NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`, `department_head`, `department_note`, `department_aid`, `department_date_added`) VALUES
(1, 'Treasurer''s Office', 0, '', 1, '2014-11-17 10:45:19'),
(2, 'MPDC', 0, '', 1, '2014-11-17 14:37:43'),
(3, 'Municipal Health Office', 0, '', 1, '2014-11-18 23:25:13'),
(4, 'Engineering', 0, '', 1, '2014-11-18 23:25:28'),
(5, 'Bureau of Fire', 0, '', 1, '2014-11-18 23:27:48'),
(6, 'Mayor''s Office', 0, '', 1, '2014-12-17 09:01:01'),
(7, 'Municipal Health Office', 0, '', 1, '2014-12-18 13:25:22'),
(8, 'MIS', 0, '', 1, '2014-12-18 14:59:08');

-- --------------------------------------------------------

--
-- Table structure for table `manage_verification`
--

CREATE TABLE IF NOT EXISTS `manage_verification` (
  `manage_verification_id` int(10) NOT NULL AUTO_INCREMENT,
  `manage_verification_order` int(10) NOT NULL,
  `manage_verification_description` varchar(50) NOT NULL,
  `manage_verification_agency` varchar(50) NOT NULL,
  `manage_verification_department` int(10) NOT NULL,
  `manage_verification_date` datetime NOT NULL,
  `manage_verification_aid` int(10) NOT NULL,
  PRIMARY KEY (`manage_verification_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `manage_verification`
--

INSERT INTO `manage_verification` (`manage_verification_id`, `manage_verification_order`, `manage_verification_description`, `manage_verification_agency`, `manage_verification_department`, `manage_verification_date`, `manage_verification_aid`) VALUES
(1, 0, 'Barangay Clearance', 'Barangay', 1, '2014-12-18 13:20:45', 1),
(2, 0, 'Zoning Clearance', 'Zoning Admin.', 2, '2014-12-18 13:21:15', 1),
(3, 0, 'Sanitary/Health Clearance', 'Municipal Health Office', 3, '2014-12-18 13:22:16', 1),
(4, 0, 'Occupancy Permit', 'Building Official', 4, '2014-12-18 13:22:47', 1),
(5, 0, 'Fire Safety Inspection Certificate', 'Municipal Fire Departmant', 5, '2014-12-18 13:24:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `permits`
--

CREATE TABLE IF NOT EXISTS `permits` (
  `permit_id` int(10) NOT NULL AUTO_INCREMENT,
  `permit_fid` int(4) unsigned zerofill NOT NULL,
  `permit_application_no` varchar(20) NOT NULL,
  `permit_reference_no` varchar(50) NOT NULL,
  `permit_fee` float NOT NULL,
  `permit_tax` float NOT NULL,
  `permit_mode_of_payment` varchar(20) NOT NULL,
  `permit_or_no` varchar(50) NOT NULL,
  `permit_or_date` date NOT NULL,
  `permit_date_issued` date NOT NULL,
  `permit_aid` int(10) NOT NULL,
  PRIMARY KEY (`permit_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

CREATE TABLE IF NOT EXISTS `privileges` (
  `privilege_id` int(10) NOT NULL AUTO_INCREMENT,
  `privilege_department` int(10) NOT NULL,
  `privilege_date` datetime NOT NULL,
  `privilege_aid` int(10) NOT NULL,
  `add_application` int(10) NOT NULL,
  `view_application` int(10) NOT NULL,
  `edit_application` int(10) NOT NULL,
  `delete_application` int(10) NOT NULL,
  `add_department` int(10) NOT NULL,
  `edit_department` int(10) NOT NULL,
  `delete_department` int(10) NOT NULL,
  PRIMARY KEY (`privilege_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`privilege_id`, `privilege_department`, `privilege_date`, `privilege_aid`, `add_application`, `view_application`, `edit_application`, `delete_application`, `add_department`, `edit_department`, `delete_department`) VALUES
(1, 1, '2014-12-17 21:37:02', 1, 1, 1, 1, 1, 0, 0, 0),
(2, 2, '2014-12-17 21:37:19', 1, 1, 1, 0, 1, 0, 0, 0),
(3, 7, '2014-12-18 13:25:23', 1, 0, 0, 0, 0, 0, 0, 0),
(4, 8, '2014-12-18 14:59:09', 1, 0, 0, 0, 0, 0, 0, 0),
(5, 3, '2014-12-19 08:06:10', 1, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `signatories`
--

CREATE TABLE IF NOT EXISTS `signatories` (
  `signatory_id` int(10) NOT NULL AUTO_INCREMENT,
  `signatory_account` int(10) NOT NULL,
  `signatory_for` varchar(100) NOT NULL,
  `signatory_date` date NOT NULL,
  `signatory_aid` int(10) NOT NULL,
  PRIMARY KEY (`signatory_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `signatories`
--

INSERT INTO `signatories` (`signatory_id`, `signatory_account`, `signatory_for`, `signatory_date`, `signatory_aid`) VALUES
(1, 4, 'assessment_reviewer', '2014-12-20', 1),
(2, 5, 'approval_recommendation', '2014-12-20', 1),
(3, 6, 'business_permit', '2014-12-22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE IF NOT EXISTS `taxes` (
  `tax_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_description` varchar(50) NOT NULL,
  `tax_note` varchar(50) NOT NULL,
  `tax_date` date NOT NULL,
  `tax_aid` int(11) NOT NULL,
  PRIMARY KEY (`tax_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`tax_id`, `tax_description`, `tax_note`, `tax_date`, `tax_aid`) VALUES
(1, 'Retailer', '', '2014-12-28', 1),
(2, 'Manufacturer', '', '2014-12-28', 1),
(3, 'Essential', '', '2014-12-28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tax_formulas`
--

CREATE TABLE IF NOT EXISTS `tax_formulas` (
  `formula_id` int(10) NOT NULL AUTO_INCREMENT,
  `formula_tax_id` int(10) NOT NULL,
  `formula_ba_item_id` int(10) NOT NULL,
  `formula_param` varchar(50) NOT NULL,
  `formula_start` float NOT NULL,
  `formula_end` float NOT NULL,
  `formula_amount_percentage` float NOT NULL,
  `formula_percentage_of` float NOT NULL,
  `formula_date` datetime NOT NULL,
  `formula_aid` int(10) NOT NULL,
  PRIMARY KEY (`formula_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `tax_formulas`
--

INSERT INTO `tax_formulas` (`formula_id`, `formula_tax_id`, `formula_ba_item_id`, `formula_param`, `formula_start`, `formula_end`, `formula_amount_percentage`, `formula_percentage_of`, `formula_date`, `formula_aid`) VALUES
(1, 1, 1, 'percentage', 1, 400000, 2.52, 0, '2014-12-15 22:46:28', 1),
(2, 1, 1, 'percentage', 400000, 0, 1.26, 0, '2014-12-15 22:47:15', 1),
(3, 2, 2, 'block', 1, 10000, 207.9, 0, '2014-12-15 22:49:43', 1),
(4, 2, 2, 'block', 10000, 15000, 277.2, 0, '2014-12-15 22:50:09', 1),
(5, 2, 2, 'block', 15000, 20000, 380.52, 0, '2014-12-15 22:52:27', 1),
(6, 2, 2, 'block', 20000, 30000, 554.4, 0, '2014-12-15 22:52:48', 1),
(7, 2, 2, 'block', 30000, 40000, 831.6, 0, '2014-12-15 22:53:10', 1),
(8, 2, 2, 'block', 40000, 50000, 1039.5, 0, '2014-12-15 22:53:42', 1),
(9, 2, 2, 'block', 50000, 75000, 1663.2, 0, '2014-12-15 22:53:59', 1),
(10, 2, 2, 'block', 75000, 100000, 2079, 0, '2014-12-15 22:54:17', 1),
(11, 2, 2, 'block', 100000, 150000, 2772, 0, '2014-12-15 22:54:46', 1),
(12, 2, 2, 'block', 150000, 200000, 3465, 0, '2014-12-15 22:55:13', 1),
(13, 2, 2, 'block', 200000, 300000, 4851, 0, '2014-12-15 22:55:47', 1),
(14, 2, 2, 'block', 300000, 500000, 6930, 0, '2014-12-15 22:56:08', 1),
(15, 2, 2, 'block', 500000, 750000, 10080, 0, '2014-12-15 22:57:57', 1),
(16, 2, 2, 'block', 750000, 1000000, 12600, 0, '2014-12-15 22:58:31', 1),
(17, 2, 2, 'block', 1000000, 2000000, 17325, 0, '2014-12-15 22:59:01', 1),
(18, 2, 2, 'block', 2000000, 3000000, 20790, 0, '2014-12-15 22:59:38', 1),
(19, 2, 2, 'block', 3000000, 4000000, 24948, 0, '2014-12-15 23:00:07', 1),
(20, 2, 2, 'block', 4000000, 5000000, 29106, 0, '2014-12-15 23:00:34', 1),
(21, 2, 2, 'block', 5000000, 6500000, 30712.5, 0, '2014-12-15 23:01:04', 1),
(22, 2, 2, 'percentage_of_percentage', 6500000, 0, 37.5, 1, '2014-12-15 23:01:43', 1),
(23, 2, 2, 'percentage_increment', 6500000, 0, 26, 0, '2014-12-15 23:03:13', 1),
(24, 3, 0, 'percentage', 1, 100000, 10, 0, '2014-12-28 09:58:08', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
