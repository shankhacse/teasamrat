/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.6.39-cll-lve : Database - teasamrat
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`teasamrat` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `teasamrat`;

/*Table structure for table `TempTable1` */

DROP TABLE IF EXISTS `TempTable1`;

CREATE TABLE `TempTable1` (
  `vchId` int(11) DEFAULT NULL,
  `vchNumber` varchar(50) DEFAULT NULL,
  `debitamount` decimal(12,2) DEFAULT NULL,
  `creditamount` decimal(12,2) DEFAULT NULL,
  `isdebit` char(1) DEFAULT NULL,
  `Naration` text,
  `VchType` varchar(50) DEFAULT NULL,
  `VchDate` date DEFAULT NULL,
  `VchAccountDetailscrdrtag` text,
  `VchAccountDetailsAccountName` text,
  `VchAccountDetailsAmount` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `account_master` */

DROP TABLE IF EXISTS `account_master`;

CREATE TABLE `account_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(100) DEFAULT NULL,
  `group_master_id` int(10) DEFAULT NULL,
  `is_special` enum('Y','N') DEFAULT 'N',
  `company_id` int(10) DEFAULT NULL,
  `is_closingstk` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `FK_account_group_master_id` (`group_master_id`),
  CONSTRAINT `FK_account_group_master_id` FOREIGN KEY (`group_master_id`) REFERENCES `group_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=910 DEFAULT CHARSET=latin1;

/*Table structure for table `account_opening_master` */

DROP TABLE IF EXISTS `account_opening_master`;

CREATE TABLE `account_opening_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `account_master_id` int(10) DEFAULT NULL,
  `opening_balance` decimal(10,2) DEFAULT NULL,
  `company_id` int(10) DEFAULT NULL,
  `financialyear_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_company_id` (`company_id`),
  KEY `FK_financialyear_id` (`financialyear_id`),
  KEY `FK_account_master_id` (`account_master_id`),
  CONSTRAINT `FK_account_master_id` FOREIGN KEY (`account_master_id`) REFERENCES `account_master` (`id`),
  CONSTRAINT `FK_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  CONSTRAINT `FK_financialyear_id` FOREIGN KEY (`financialyear_id`) REFERENCES `financialyear` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9125 DEFAULT CHARSET=latin1;

/*Table structure for table `auctionareamaster` */

DROP TABLE IF EXISTS `auctionareamaster`;

CREATE TABLE `auctionareamaster` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `auctionarea` varchar(255) DEFAULT NULL,
  `transcost` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Table structure for table `bagtypemaster` */

DROP TABLE IF EXISTS `bagtypemaster`;

CREATE TABLE `bagtypemaster` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `bagtype` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Table structure for table `blending_details` */

DROP TABLE IF EXISTS `blending_details`;

CREATE TABLE `blending_details` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `blending_master_id` int(20) DEFAULT NULL,
  `purchase_dtl_id` int(20) DEFAULT NULL,
  `purchasebag_id` int(20) DEFAULT NULL,
  `number_of_blended_bag` int(20) DEFAULT NULL,
  `qty_of_bag` double(10,2) DEFAULT NULL,
  `costperkg` double(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_blendingmaster` (`blending_master_id`),
  KEY `FK_purDtlId` (`purchase_dtl_id`),
  KEY `FK_bagDtlId` (`purchasebag_id`),
  CONSTRAINT `FK_bagDtlId` FOREIGN KEY (`purchasebag_id`) REFERENCES `purchase_bag_details` (`id`),
  CONSTRAINT `FK_blendingmaster` FOREIGN KEY (`blending_master_id`) REFERENCES `blending_master` (`id`),
  CONSTRAINT `FK_purDtlId` FOREIGN KEY (`purchase_dtl_id`) REFERENCES `purchase_invoice_detail` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39948 DEFAULT CHARSET=utf8;

/*Table structure for table `blending_master` */

DROP TABLE IF EXISTS `blending_master`;

CREATE TABLE `blending_master` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `blending_number` varchar(255) DEFAULT NULL,
  `blending_ref` varchar(255) DEFAULT NULL,
  `blending_date` datetime DEFAULT NULL,
  `warehouseid` int(20) NOT NULL,
  `blendedprice` double(10,2) DEFAULT NULL,
  `avgblendCost` double(10,2) DEFAULT NULL,
  `blendedBag` double(10,2) DEFAULT NULL,
  `blendedKgs` double(10,2) DEFAULT NULL,
  `companyid` int(20) DEFAULT NULL,
  `yearid` int(20) DEFAULT NULL,
  `productid` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_productid` (`productid`),
  KEY `INDX_BlendKG` (`blendedKgs`),
  KEY `INDX_COMPID` (`companyid`),
  CONSTRAINT `FK_productid` FOREIGN KEY (`productid`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1715 DEFAULT CHARSET=utf8;

/*Table structure for table `branch_master` */

DROP TABLE IF EXISTS `branch_master`;

CREATE TABLE `branch_master` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `branch` varchar(255) DEFAULT NULL,
  `branch_address` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `broker` */

DROP TABLE IF EXISTS `broker`;

CREATE TABLE `broker` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `closing_stock_accnt_mapping` */

DROP TABLE IF EXISTS `closing_stock_accnt_mapping`;

CREATE TABLE `closing_stock_accnt_mapping` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `closing_stk_dr_accId` int(20) DEFAULT NULL,
  `closing_stk_cr_accid` int(20) DEFAULT NULL,
  `companyId` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `company` */

DROP TABLE IF EXISTS `company`;

CREATE TABLE `company` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `vat_number` varchar(255) DEFAULT NULL,
  `cst_number` varchar(255) DEFAULT NULL,
  `gst_number` varchar(255) DEFAULT NULL,
  `pan_number` varchar(255) DEFAULT NULL,
  `pin_number` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `bill_tag` varchar(255) DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_ac_no` varchar(255) DEFAULT NULL,
  `ifsc_code` varchar(50) DEFAULT NULL,
  `bank_branch_add` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Table structure for table `consignee_master` */

DROP TABLE IF EXISTS `consignee_master`;

CREATE TABLE `consignee_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `consignee_name` varchar(100) DEFAULT NULL,
  `customer_id` int(10) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `gstin` varchar(100) DEFAULT NULL,
  `companyid` int(10) DEFAULT NULL,
  `yearid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_consignee_cust_id` (`customer_id`),
  KEY `fk_consignee_state_id` (`state_id`),
  CONSTRAINT `fk_consignee_cust_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  CONSTRAINT `fk_consignee_state_id` FOREIGN KEY (`state_id`) REFERENCES `state_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Table structure for table `cst` */

DROP TABLE IF EXISTS `cst`;

CREATE TABLE `cst` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cst_rate` decimal(10,2) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Table structure for table `customer` */

DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `account_master_id` int(10) DEFAULT NULL,
  `tin_number` varchar(50) DEFAULT NULL,
  `cst_number` varchar(50) DEFAULT NULL,
  `pan_number` varchar(50) DEFAULT NULL,
  `service_tax_number` varchar(50) DEFAULT NULL,
  `GST_Number` varchar(50) DEFAULT NULL,
  `pin_number` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `credit_days` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_customer_account_master_id` (`account_master_id`),
  KEY `FK_customer_state_id` (`state_id`),
  CONSTRAINT `FK_customer_account_master_id` FOREIGN KEY (`account_master_id`) REFERENCES `account_master` (`id`),
  CONSTRAINT `FK_customer_state_id` FOREIGN KEY (`state_id`) REFERENCES `state_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=177 DEFAULT CHARSET=latin1;

/*Table structure for table `customer_bill_master` */

DROP TABLE IF EXISTS `customer_bill_master`;

CREATE TABLE `customer_bill_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `bill_amount` double(10,4) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `voucher_id` int(11) DEFAULT NULL,
  `due_amount` double(11,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_customer_bill_master_voucher_id` (`voucher_id`),
  KEY `FK_customer_bill_master_company_id` (`company_id`),
  KEY `FK_customer_bill_master_year_id` (`year_id`),
  KEY `FK_customer_bill_master_bill_id` (`bill_id`),
  CONSTRAINT `FK_customer_bill_master_bill_id` FOREIGN KEY (`bill_id`) REFERENCES `purchase_invoice_master` (`id`),
  CONSTRAINT `FK_customer_bill_master_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  CONSTRAINT `FK_customer_bill_master_voucher_id` FOREIGN KEY (`voucher_id`) REFERENCES `voucher_master` (`id`),
  CONSTRAINT `FK_customer_bill_master_year_id` FOREIGN KEY (`year_id`) REFERENCES `financialyear` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `customeradvance` */

DROP TABLE IF EXISTS `customeradvance`;

CREATE TABLE `customeradvance` (
  `advanceId` int(20) NOT NULL AUTO_INCREMENT,
  `dateofadvance` datetime NOT NULL,
  `voucherid` int(20) NOT NULL,
  `advanceamount` decimal(10,2) NOT NULL,
  `customeraccountid` int(20) NOT NULL,
  `isfulladjusted` enum('Y','N') DEFAULT 'N',
  `companyid` int(20) NOT NULL,
  `yearid` int(20) NOT NULL,
  `payment_type` enum('RC','PY') DEFAULT 'RC',
  PRIMARY KEY (`advanceId`),
  KEY `fk_customer_account` (`customeraccountid`),
  KEY `fk_voucher_master` (`voucherid`),
  CONSTRAINT `fk_customer_account` FOREIGN KEY (`customeraccountid`) REFERENCES `account_master` (`id`),
  CONSTRAINT `fk_voucher_master` FOREIGN KEY (`voucherid`) REFERENCES `voucher_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=763 DEFAULT CHARSET=utf8;

/*Table structure for table `customeradvanceadadjustment` */

DROP TABLE IF EXISTS `customeradvanceadadjustment`;

CREATE TABLE `customeradvanceadadjustment` (
  `adjustmentid` int(20) NOT NULL AUTO_INCREMENT,
  `adjustmentrefno` varchar(255) NOT NULL,
  `dateofadjustment` datetime DEFAULT NULL,
  `customeraccid` int(20) NOT NULL,
  `advanceid` int(20) DEFAULT NULL,
  `totalamountadjusted` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`adjustmentid`),
  KEY `FK_cust_acc_id` (`customeraccid`),
  KEY `FK_advance_master_id` (`advanceid`),
  CONSTRAINT `FK_advance_master_id` FOREIGN KEY (`advanceid`) REFERENCES `customeradvance` (`advanceId`),
  CONSTRAINT `FK_cust_acc_id` FOREIGN KEY (`customeraccid`) REFERENCES `account_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*Table structure for table `customeradvanceadjstdtl` */

DROP TABLE IF EXISTS `customeradvanceadjstdtl`;

CREATE TABLE `customeradvanceadjstdtl` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `custadjmstid` int(20) DEFAULT NULL,
  `customerbillmaster` int(20) NOT NULL,
  `adjustedamount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_adj_mst` (`custadjmstid`),
  KEY `fk_customer_bill` (`customerbillmaster`),
  CONSTRAINT `fk_adj_mst` FOREIGN KEY (`custadjmstid`) REFERENCES `customeradvanceadadjustment` (`adjustmentid`),
  CONSTRAINT `fk_customer_bill` FOREIGN KEY (`customerbillmaster`) REFERENCES `customerbillmaster` (`customerbillmasterid`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

/*Table structure for table `customerbillmaster` */

DROP TABLE IF EXISTS `customerbillmaster`;

CREATE TABLE `customerbillmaster` (
  `customerbillmasterid` int(10) NOT NULL AUTO_INCREMENT,
  `billdate` datetime NOT NULL,
  `billamount` decimal(10,2) NOT NULL,
  `invoicemasterid` int(10) NOT NULL,
  `saletype` enum('R','T') DEFAULT NULL,
  `customeraccountid` int(10) NOT NULL,
  `companyid` int(10) NOT NULL,
  `yearid` int(10) NOT NULL,
  PRIMARY KEY (`customerbillmasterid`),
  KEY `fk_customer_accid` (`customeraccountid`),
  CONSTRAINT `fk_customer_accid` FOREIGN KEY (`customeraccountid`) REFERENCES `account_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5387 DEFAULT CHARSET=latin1;

/*Table structure for table `customerreceiptdetail` */

DROP TABLE IF EXISTS `customerreceiptdetail`;

CREATE TABLE `customerreceiptdetail` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `customerrecptmstid` int(20) NOT NULL,
  `customerbillmasterid` int(20) NOT NULL,
  `receiptamount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rcpt_mst` (`customerrecptmstid`),
  KEY `bill_id` (`customerbillmasterid`),
  CONSTRAINT `bill_id` FOREIGN KEY (`customerbillmasterid`) REFERENCES `customerbillmaster` (`customerbillmasterid`),
  CONSTRAINT `rcpt_mst` FOREIGN KEY (`customerrecptmstid`) REFERENCES `customerreceiptmaster` (`customerpaymentid`)
) ENGINE=InnoDB AUTO_INCREMENT=3608 DEFAULT CHARSET=latin1;

/*Table structure for table `customerreceiptmaster` */

DROP TABLE IF EXISTS `customerreceiptmaster`;

CREATE TABLE `customerreceiptmaster` (
  `customerpaymentid` int(20) NOT NULL AUTO_INCREMENT,
  `dateofpayment` datetime NOT NULL,
  `customeraccountid` int(20) NOT NULL,
  `totalreceipt` decimal(10,2) NOT NULL,
  `voucherid` int(20) NOT NULL,
  `customerchqbank` varchar(255) DEFAULT NULL,
  `customerchqbankbranch` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`customerpaymentid`),
  KEY `customer_account_id` (`customeraccountid`),
  KEY `voucher_recpt` (`voucherid`),
  CONSTRAINT `customer_account_id` FOREIGN KEY (`customeraccountid`) REFERENCES `account_master` (`id`),
  CONSTRAINT `voucher_recpt` FOREIGN KEY (`voucherid`) REFERENCES `voucher_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2691 DEFAULT CHARSET=utf8;

/*Table structure for table `do_to_transporter` */

DROP TABLE IF EXISTS `do_to_transporter`;

CREATE TABLE `do_to_transporter` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `transporterId` int(20) DEFAULT NULL,
  `do` varchar(255) DEFAULT NULL,
  `purchase_inv_mst_id` int(20) DEFAULT NULL,
  `purchase_inv_dtlid` int(20) DEFAULT NULL,
  `transportationdt` datetime DEFAULT NULL,
  `chalanNumber` varchar(255) DEFAULT NULL,
  `chalanDate` datetime DEFAULT NULL,
  `is_sent` enum('N','Y') DEFAULT 'N',
  `shortkgs` decimal(10,2) DEFAULT NULL,
  `locationId` int(20) DEFAULT NULL,
  `in_Stock` enum('Y','N') DEFAULT 'N',
  `typeofpurchase` enum('AS','PS','SB','OP','STI') DEFAULT NULL,
  `yearid` int(20) DEFAULT NULL,
  `companyid` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_purchase_master` (`purchase_inv_mst_id`),
  KEY `indx_purchase_dtl` (`purchase_inv_dtlid`),
  KEY `indx_location_id` (`locationId`),
  KEY `indx_transporter_id` (`transporterId`),
  CONSTRAINT `fk_location_id` FOREIGN KEY (`locationId`) REFERENCES `location` (`id`),
  CONSTRAINT `fk_purchase_dtl` FOREIGN KEY (`purchase_inv_dtlid`) REFERENCES `purchase_invoice_detail` (`id`),
  CONSTRAINT `fk_purchase_mst` FOREIGN KEY (`purchase_inv_mst_id`) REFERENCES `purchase_invoice_master` (`id`),
  CONSTRAINT `fk_transporter_id` FOREIGN KEY (`transporterId`) REFERENCES `transport` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15366 DEFAULT CHARSET=utf8;

/*Table structure for table `excise_master` */

DROP TABLE IF EXISTS `excise_master`;

CREATE TABLE `excise_master` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(300) DEFAULT NULL,
  `rate` double(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `financialyear` */

DROP TABLE IF EXISTS `financialyear`;

CREATE TABLE `financialyear` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `year` varchar(20) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Table structure for table `finished_product` */

DROP TABLE IF EXISTS `finished_product`;

CREATE TABLE `finished_product` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `productId` int(20) DEFAULT NULL,
  `blended_id` int(20) DEFAULT NULL,
  `blended_qty_kg` decimal(10,2) DEFAULT NULL,
  `consumed_kgs` decimal(10,2) DEFAULT NULL,
  `packing_date` datetime DEFAULT NULL,
  `warehouse_id` int(20) DEFAULT NULL,
  `created_by` int(20) DEFAULT NULL,
  `company_id` int(20) DEFAULT NULL,
  `year_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_blend` (`blended_id`),
  KEY `FK_warehouse` (`warehouse_id`),
  KEY `fk_finishproduct` (`productId`),
  KEY `INDX_consumeproducts` (`consumed_kgs`),
  CONSTRAINT `FK_blend` FOREIGN KEY (`blended_id`) REFERENCES `blending_master` (`id`),
  CONSTRAINT `FK_warehouse` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouse` (`id`),
  CONSTRAINT `fk_finishproduct` FOREIGN KEY (`productId`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2304 DEFAULT CHARSET=utf8;

/*Table structure for table `finished_product_dtl` */

DROP TABLE IF EXISTS `finished_product_dtl`;

CREATE TABLE `finished_product_dtl` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `finishProductId` int(20) DEFAULT NULL,
  `product_packet` int(20) DEFAULT NULL,
  `numberof_packet` int(20) DEFAULT NULL,
  `net_in_packet` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_prod_pack` (`product_packet`),
  KEY `fk_finish_prod_id` (`finishProductId`),
  CONSTRAINT `fk_finish_prod_id` FOREIGN KEY (`finishProductId`) REFERENCES `finished_product` (`id`),
  CONSTRAINT `fk_prod_pack` FOREIGN KEY (`product_packet`) REFERENCES `product_packet` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6709 DEFAULT CHARSET=utf8;

/*Table structure for table `finished_product_op_stock` */

DROP TABLE IF EXISTS `finished_product_op_stock`;

CREATE TABLE `finished_product_op_stock` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `finished_product_id` int(11) DEFAULT NULL,
  `opening_balance` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=186 DEFAULT CHARSET=latin1;

/*Table structure for table `garden_master` */

DROP TABLE IF EXISTS `garden_master`;

CREATE TABLE `garden_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `garden_name` varchar(100) NOT NULL,
  `address` varchar(500) DEFAULT 'null',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=998 DEFAULT CHARSET=latin1;

/*Table structure for table `grade_master` */

DROP TABLE IF EXISTS `grade_master`;

CREATE TABLE `grade_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `grade` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;

/*Table structure for table `group_category` */

DROP TABLE IF EXISTS `group_category`;

CREATE TABLE `group_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `group_name_id` int(100) NOT NULL,
  `sub_group_name_id` int(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_group_name_id` (`group_name_id`),
  KEY `FK_sub_group_name_id` (`sub_group_name_id`),
  CONSTRAINT `FK_group_name_id` FOREIGN KEY (`group_name_id`) REFERENCES `group_name` (`id`),
  CONSTRAINT `FK_sub_group_name_id` FOREIGN KEY (`sub_group_name_id`) REFERENCES `subgroup_name` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Table structure for table `group_master` */

DROP TABLE IF EXISTS `group_master`;

CREATE TABLE `group_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(100) DEFAULT NULL,
  `group_category_id` int(10) DEFAULT NULL,
  `is_special` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `FK_group_category_id` (`group_category_id`),
  CONSTRAINT `FK_group_category_id` FOREIGN KEY (`group_category_id`) REFERENCES `group_category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*Table structure for table `group_name` */

DROP TABLE IF EXISTS `group_name`;

CREATE TABLE `group_name` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `gstmaster` */

DROP TABLE IF EXISTS `gstmaster`;

CREATE TABLE `gstmaster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gstDescription` varchar(255) DEFAULT NULL,
  `gstType` enum('CGST','SGST','IGST') DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `accountId` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `yearId` int(11) DEFAULT NULL,
  `usedfor` enum('I','O') DEFAULT NULL COMMENT 'I=''INPUT'',O=''OUTPUT''',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

/*Table structure for table `item_master` */

DROP TABLE IF EXISTS `item_master`;

CREATE TABLE `item_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `grade_id` int(10) DEFAULT NULL,
  `garden_id` int(10) DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `package` int(10) DEFAULT NULL,
  `net` int(10) DEFAULT NULL,
  `gross` varchar(255) DEFAULT NULL,
  `bill_id` int(10) DEFAULT NULL,
  `from_where` enum('AS','PS','SB') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_grade_id` (`grade_id`),
  KEY `FK_garden_id` (`garden_id`),
  KEY `FK_purchase_invoice_id` (`bill_id`),
  CONSTRAINT `FK_garden_id` FOREIGN KEY (`garden_id`) REFERENCES `garden_master` (`id`),
  CONSTRAINT `FK_grade_id` FOREIGN KEY (`grade_id`) REFERENCES `grade_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=445 DEFAULT CHARSET=latin1;

/*Table structure for table `location` */

DROP TABLE IF EXISTS `location`;

CREATE TABLE `location` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `location` varchar(255) DEFAULT NULL,
  `warehouseid` int(20) DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT 'Y',
  PRIMARY KEY (`id`),
  KEY `fk_warehouse_location` (`warehouseid`),
  CONSTRAINT `fk_warehouse_location` FOREIGN KEY (`warehouseid`) REFERENCES `warehouse` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=utf8;

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) DEFAULT NULL,
  `menu_link` varchar(255) DEFAULT NULL,
  `is_parent` enum('C','P','SC') DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `menu_code` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=latin1;

/*Table structure for table `menu_design` */

DROP TABLE IF EXISTS `menu_design`;

CREATE TABLE `menu_design` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) DEFAULT NULL,
  `menu_link` varchar(255) DEFAULT NULL,
  `is_parent` enum('P','C','SC','SCC') DEFAULT NULL COMMENT 'P=Parent,C=Child,SC=Sub Child,SCC=Sub Child Child',
  `parent_id` int(10) DEFAULT NULL,
  `menu_srl` int(10) DEFAULT NULL,
  `menu_title` varchar(255) DEFAULT NULL,
  `is_new` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8;

/*Table structure for table `othercharges` */

DROP TABLE IF EXISTS `othercharges`;

CREATE TABLE `othercharges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `accountid` int(11) DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `yearid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Table structure for table `packet` */

DROP TABLE IF EXISTS `packet`;

CREATE TABLE `packet` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `packet` varchar(255) DEFAULT NULL,
  `PacketQty` double DEFAULT NULL,
  `qtyinBag` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `product` varchar(255) NOT NULL,
  `productdesc` varchar(255) DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT 'Y',
  `insertiondate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;

/*Table structure for table `product_packet` */

DROP TABLE IF EXISTS `product_packet`;

CREATE TABLE `product_packet` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `productid` int(20) DEFAULT NULL,
  `packetid` int(20) DEFAULT NULL,
  `sale_rate` decimal(10,2) DEFAULT NULL,
  `net_kgs` decimal(10,2) DEFAULT NULL,
  `hsn_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_prduct` (`productid`),
  KEY `indx_pckt` (`packetid`),
  CONSTRAINT `fk_packet` FOREIGN KEY (`packetid`) REFERENCES `packet` (`id`),
  CONSTRAINT `fk_product` FOREIGN KEY (`productid`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=utf8;

/*Table structure for table `product_rawmaterial_consumption` */

DROP TABLE IF EXISTS `product_rawmaterial_consumption`;

CREATE TABLE `product_rawmaterial_consumption` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `rawmaterialid` int(20) DEFAULT NULL,
  `quantity_required` decimal(10,2) DEFAULT NULL,
  `product_packetId` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rawmaterialid` (`rawmaterialid`),
  KEY `fk_product_packet` (`product_packetId`),
  CONSTRAINT `fk_product_packet` FOREIGN KEY (`product_packetId`) REFERENCES `product_packet` (`id`),
  CONSTRAINT `fk_rawmaterialid` FOREIGN KEY (`rawmaterialid`) REFERENCES `raw_material_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=utf8;

/*Table structure for table `purchase_bag_details` */

DROP TABLE IF EXISTS `purchase_bag_details`;

CREATE TABLE `purchase_bag_details` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `purchasedtlid` int(20) DEFAULT NULL,
  `bagtypeid` int(20) DEFAULT NULL,
  `no_of_bags` int(20) DEFAULT NULL,
  `net` double(10,2) DEFAULT NULL,
  `shortkg` double(10,2) DEFAULT NULL,
  `parent_bag_id` int(20) DEFAULT NULL,
  `actual_bags` int(20) DEFAULT NULL,
  `chestSerial` varchar(255) DEFAULT NULL,
  `challanno` varchar(50) DEFAULT NULL,
  `challandate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_purchase_dtlId` (`purchasedtlid`),
  CONSTRAINT `fk_purchase_dtlId` FOREIGN KEY (`purchasedtlid`) REFERENCES `purchase_invoice_detail` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32878 DEFAULT CHARSET=utf8;

/*Table structure for table `purchase_finishproductdetail` */

DROP TABLE IF EXISTS `purchase_finishproductdetail`;

CREATE TABLE `purchase_finishproductdetail` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `purchase_finishmasterId` int(20) DEFAULT NULL,
  `productpacketid` int(20) DEFAULT NULL,
  `packingbox` decimal(12,2) DEFAULT NULL,
  `packingnet` decimal(12,2) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT NULL,
  `rate` decimal(12,2) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `HSN` varchar(255) DEFAULT NULL,
  `discount` double(10,2) DEFAULT NULL,
  `freightamount` double(10,2) DEFAULT NULL,
  `taxableamount` double(10,2) DEFAULT NULL,
  `cgstrateid` int(10) DEFAULT NULL,
  `cgstamount` double(10,2) DEFAULT NULL,
  `sgstrateid` int(10) DEFAULT NULL,
  `sgstamount` double(10,2) DEFAULT NULL,
  `igstrateid` int(10) DEFAULT NULL,
  `igstamount` double(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_finish_purchase_master` (`purchase_finishmasterId`),
  CONSTRAINT `fk_finish_purchase_master` FOREIGN KEY (`purchase_finishmasterId`) REFERENCES `purchase_finishproductmaster` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3621 DEFAULT CHARSET=latin1;

/*Table structure for table `purchase_finishproductmaster` */

DROP TABLE IF EXISTS `purchase_finishproductmaster`;

CREATE TABLE `purchase_finishproductmaster` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `srl_no` int(20) NOT NULL,
  `purchasebillno` varchar(255) DEFAULT NULL,
  `purchasebilldate` datetime DEFAULT NULL,
  `vendorId` int(20) DEFAULT NULL,
  `voucher_master_id` int(20) DEFAULT NULL,
  `vehicleno` varchar(255) DEFAULT NULL,
  `taxrateType` char(1) DEFAULT NULL,
  `taxtRateTypeId` int(20) DEFAULT NULL,
  `taxAmount` decimal(12,2) DEFAULT NULL,
  `discountRate` decimal(12,2) DEFAULT NULL,
  `discountAmount` decimal(12,2) DEFAULT NULL,
  `deliverycharges` decimal(12,2) DEFAULT NULL,
  `totalpacket` decimal(12,2) DEFAULT NULL,
  `totalquantity` decimal(12,2) DEFAULT NULL,
  `totalamount` decimal(12,2) DEFAULT NULL,
  `roundoff` decimal(12,2) DEFAULT NULL,
  `grandtotal` decimal(12,2) DEFAULT NULL,
  `yearid` int(20) DEFAULT NULL,
  `companyid` int(20) DEFAULT NULL,
  `creationdate` datetime DEFAULT NULL,
  `userid` int(20) DEFAULT NULL,
  `GST_Discountamount` decimal(12,2) DEFAULT NULL,
  `GST_Taxableamount` decimal(12,2) DEFAULT NULL,
  `GST_Totalgstincluded` decimal(12,2) DEFAULT NULL,
  `GST_Freightamount` decimal(12,2) DEFAULT NULL,
  `GST_Insuranceamount` decimal(12,2) DEFAULT NULL,
  `GST_PFamount` decimal(12,2) DEFAULT NULL,
  `totalCGST` decimal(12,2) DEFAULT NULL,
  `totalSGST` decimal(12,2) DEFAULT NULL,
  `totalIGST` decimal(12,2) DEFAULT NULL,
  `IsGST` enum('Y','N') DEFAULT 'N',
  `GST_placeofsupply` varchar(255) DEFAULT NULL,
  `GST_FreightamountNew` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vendorId` (`vendorId`),
  KEY `FK_VoucherMasterId` (`voucher_master_id`),
  CONSTRAINT `FK_VoucherMasterId` FOREIGN KEY (`voucher_master_id`) REFERENCES `voucher_master` (`id`),
  CONSTRAINT `FK_vendorId` FOREIGN KEY (`vendorId`) REFERENCES `vendor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=403 DEFAULT CHARSET=latin1;

/*Table structure for table `purchase_invoice_detail` */

DROP TABLE IF EXISTS `purchase_invoice_detail`;

CREATE TABLE `purchase_invoice_detail` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `purchase_master_id` int(10) DEFAULT NULL,
  `lot` varchar(255) DEFAULT NULL,
  `doRealisationDate` date DEFAULT NULL,
  `do` varchar(255) DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `garden_id` int(10) DEFAULT NULL,
  `grade_id` int(10) DEFAULT NULL,
  `location_id` int(10) DEFAULT NULL,
  `warehouse_id` int(10) DEFAULT NULL,
  `gp_number` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `package` int(10) DEFAULT NULL,
  `stamp` decimal(10,2) DEFAULT NULL,
  `gross` decimal(10,2) DEFAULT NULL,
  `brokerage` decimal(10,2) DEFAULT NULL,
  `total_weight` decimal(10,2) DEFAULT NULL,
  `rate_type_value` double(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `service_tax` decimal(10,2) DEFAULT NULL,
  `total_value` decimal(10,2) DEFAULT NULL,
  `chest_from` int(10) DEFAULT NULL,
  `chest_to` int(10) DEFAULT NULL,
  `value_cost` decimal(10,2) DEFAULT NULL,
  `net` int(10) DEFAULT NULL,
  `rate_type` enum('V','C') DEFAULT NULL,
  `rate_type_id` int(11) NOT NULL,
  `service_tax_id` int(11) NOT NULL,
  `teagroup_master_id` int(11) DEFAULT NULL,
  `cost_of_tea` decimal(10,2) DEFAULT NULL,
  `transportation_cost` decimal(10,2) DEFAULT NULL,
  `tb_charges` decimal(10,2) DEFAULT NULL,
  `gst_teavalue` decimal(12,2) DEFAULT NULL,
  `gst_discount` decimal(12,2) DEFAULT NULL,
  `gst_taxable` decimal(12,2) DEFAULT NULL,
  `cgst_id` int(11) DEFAULT NULL,
  `cgst_amt` decimal(12,2) DEFAULT NULL,
  `sgst_id` int(11) DEFAULT NULL,
  `sgst_amt` decimal(12,2) DEFAULT NULL,
  `igst_id` int(11) DEFAULT NULL,
  `igst_amt` decimal(12,2) DEFAULT NULL,
  `gst_netamount` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_purchase_master_id` (`purchase_master_id`),
  KEY `FK_DETAIL_garden_id` (`garden_id`),
  KEY `FK_DETAIL_grade_id` (`grade_id`),
  KEY `FK_DETAIL_warehouse_id` (`warehouse_id`),
  KEY `rate_type_id` (`rate_type_id`,`service_tax_id`),
  KEY `teagroup_master_id` (`teagroup_master_id`),
  CONSTRAINT `FK_DETAIL_garden_id` FOREIGN KEY (`garden_id`) REFERENCES `garden_master` (`id`),
  CONSTRAINT `FK_DETAIL_grade_id` FOREIGN KEY (`grade_id`) REFERENCES `grade_master` (`id`),
  CONSTRAINT `FK_DETAIL_warehouse_id` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouse` (`id`),
  CONSTRAINT `FK_purchase_master_id` FOREIGN KEY (`purchase_master_id`) REFERENCES `purchase_invoice_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18256 DEFAULT CHARSET=latin1;

/*Table structure for table `purchase_invoice_master` */

DROP TABLE IF EXISTS `purchase_invoice_master`;

CREATE TABLE `purchase_invoice_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `purchase_invoice_number` varchar(255) DEFAULT NULL,
  `purchase_invoice_date` date DEFAULT NULL,
  `transfer_date` datetime DEFAULT NULL,
  `auctionareaid` int(20) DEFAULT '0',
  `vendor_id` int(10) DEFAULT NULL,
  `voucher_master_id` int(11) DEFAULT NULL,
  `sale_number` varchar(10) DEFAULT NULL,
  `sale_date` datetime DEFAULT NULL,
  `promt_date` datetime DEFAULT NULL,
  `cn_no` varchar(100) DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `challan_date` datetime DEFAULT NULL,
  `transporter_id` int(10) DEFAULT NULL,
  `tea_value` decimal(10,2) DEFAULT NULL,
  `brokerage` decimal(10,2) DEFAULT NULL,
  `service_tax` decimal(10,2) DEFAULT NULL,
  `total_cst` double(10,2) DEFAULT NULL,
  `total_vat` double(10,2) DEFAULT NULL,
  `chestage_allowance` decimal(10,2) DEFAULT NULL,
  `stamp` decimal(10,2) DEFAULT NULL,
  `other_charges` decimal(10,2) DEFAULT NULL,
  `totalTbCharges` decimal(10,2) DEFAULT NULL,
  `round_off` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `from_where` enum('AS','PS','SB','OP','STI') DEFAULT NULL COMMENT 'AS=Auction Sale,PS=Private Sale,SB=Seller To byuer',
  `isGST` enum('Y','N') DEFAULT 'N',
  `GST_totalcgst` decimal(12,2) DEFAULT NULL,
  `GST_totalsgst` decimal(12,2) DEFAULT NULL,
  `GST_totaligst` decimal(12,2) DEFAULT NULL,
  `GST_gstincldamt` decimal(12,2) DEFAULT NULL,
  `GST_HSN` varchar(255) DEFAULT NULL,
  `total_bags` decimal(12,2) DEFAULT NULL,
  `total_kgs` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vendor_id` (`vendor_id`),
  KEY `voucher_master_id` (`voucher_master_id`),
  KEY `company_id` (`company_id`,`year_id`),
  KEY `year_id` (`year_id`),
  KEY `purchaseDate` (`purchase_invoice_date`),
  CONSTRAINT `FK_vendor_id` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`),
  CONSTRAINT `FK_vouchermaster_id` FOREIGN KEY (`voucher_master_id`) REFERENCES `voucher_master` (`id`),
  CONSTRAINT `purchase_invoice_master_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `purchase_invoice_master_ibfk_2` FOREIGN KEY (`year_id`) REFERENCES `financialyear` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3372 DEFAULT CHARSET=latin1;

/*Table structure for table `purchase_invoice_sample` */

DROP TABLE IF EXISTS `purchase_invoice_sample`;

CREATE TABLE `purchase_invoice_sample` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `purchase_invoice_detail_id` int(10) DEFAULT NULL,
  `sample_number` int(10) DEFAULT NULL,
  `sample_net` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_purchase_invoice_detail_id` (`purchase_invoice_detail_id`),
  CONSTRAINT `FK_purchase_invoice_detail_id` FOREIGN KEY (`purchase_invoice_detail_id`) REFERENCES `purchase_invoice_detail` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `raw_material_master` */

DROP TABLE IF EXISTS `raw_material_master`;

CREATE TABLE `raw_material_master` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `product_description` varchar(300) DEFAULT NULL,
  `purchase_rate` decimal(10,2) DEFAULT NULL,
  `unitid` int(20) DEFAULT NULL,
  `type` enum('R','S') DEFAULT 'R',
  `hsncode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=latin1;

/*Table structure for table `raw_material_opening` */

DROP TABLE IF EXISTS `raw_material_opening`;

CREATE TABLE `raw_material_opening` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `rawmaterialId` int(20) NOT NULL,
  `opening` decimal(12,2) DEFAULT NULL,
  `yearid` int(20) DEFAULT NULL,
  `companyid` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rawmaterial` (`rawmaterialId`),
  CONSTRAINT `fk_rawmaterial` FOREIGN KEY (`rawmaterialId`) REFERENCES `raw_material_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=344 DEFAULT CHARSET=utf8;

/*Table structure for table `rawmaterial_purchase_master` */

DROP TABLE IF EXISTS `rawmaterial_purchase_master`;

CREATE TABLE `rawmaterial_purchase_master` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(100) DEFAULT NULL,
  `invoice_date` datetime DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `challan_date` datetime DEFAULT NULL,
  `order_no` varchar(100) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `excise_invoice_no` varchar(100) DEFAULT NULL,
  `excise_invoice_date` datetime DEFAULT NULL,
  `vendor_id` int(10) DEFAULT NULL,
  `item_amount` decimal(10,2) DEFAULT NULL,
  `excise_id` int(20) DEFAULT NULL,
  `excise_amount` decimal(10,2) DEFAULT NULL,
  `voucher_id` int(10) DEFAULT NULL,
  `taxrateType` enum('V','C') DEFAULT NULL,
  `taxrateTypeId` int(10) DEFAULT NULL,
  `taxamount` decimal(10,2) DEFAULT NULL,
  `round_off` decimal(10,2) DEFAULT NULL,
  `invoice_value` decimal(10,2) DEFAULT NULL,
  `companyid` int(20) DEFAULT NULL,
  `yearid` int(20) DEFAULT NULL,
  `userid` int(20) DEFAULT NULL,
  `GST_Discountamount` decimal(12,2) DEFAULT NULL,
  `GST_Taxableamount` decimal(12,2) DEFAULT NULL,
  `GST_Totalgstincluded` decimal(12,2) DEFAULT NULL,
  `totalCGST` decimal(12,2) DEFAULT NULL,
  `totalSGST` decimal(12,2) DEFAULT NULL,
  `totalIGST` decimal(12,2) DEFAULT NULL,
  `IsGST` enum('Y','N') DEFAULT 'N',
  `GST_placeofsupply` varchar(255) DEFAULT NULL,
  `IsService` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2903 DEFAULT CHARSET=latin1;

/*Table structure for table `rawmaterial_purchasedetail` */

DROP TABLE IF EXISTS `rawmaterial_purchasedetail`;

CREATE TABLE `rawmaterial_purchasedetail` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `rawmat_purchase_masterId` int(20) DEFAULT NULL,
  `productid` int(20) DEFAULT NULL,
  `quantity` double(10,2) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `gstdiscount` decimal(10,2) DEFAULT NULL,
  `gstTaxableamount` decimal(10,2) DEFAULT NULL,
  `cgstRateId` decimal(10,2) DEFAULT NULL,
  `cgstamt` decimal(10,2) DEFAULT NULL,
  `sgstRateId` decimal(10,2) DEFAULT NULL,
  `sgstamt` decimal(10,2) DEFAULT NULL,
  `igstRateId` decimal(10,2) DEFAULT NULL,
  `igstamt` decimal(10,2) DEFAULT NULL,
  `HSN` varchar(255) DEFAULT NULL,
  `serviceaccountId` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rawmaterial_purchase_master` (`rawmat_purchase_masterId`),
  CONSTRAINT `FK_rawmaterial_purchase_master` FOREIGN KEY (`rawmat_purchase_masterId`) REFERENCES `rawmaterial_purchase_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4238 DEFAULT CHARSET=latin1;

/*Table structure for table `rawteasale_detail` */

DROP TABLE IF EXISTS `rawteasale_detail`;

CREATE TABLE `rawteasale_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rawteasale_master_id` int(10) DEFAULT NULL,
  `purchase_detail_id` int(10) DEFAULT NULL,
  `purchase_bag_id` int(10) DEFAULT NULL,
  `num_of_sale_bag` int(10) DEFAULT NULL,
  `qty_of_sale_bag` double(10,2) DEFAULT NULL,
  `rate` double(10,2) DEFAULT NULL,
  `amt` double(10,2) DEFAULT NULL,
  `cgstRateId` int(11) DEFAULT NULL,
  `cgstamt` double(10,2) DEFAULT NULL,
  `sgstRateId` int(11) DEFAULT NULL,
  `sgstamt` double(10,2) DEFAULT NULL,
  `igstRateId` int(11) DEFAULT NULL,
  `igstamt` double(10,2) DEFAULT NULL,
  `gstdiscount` double(10,2) DEFAULT NULL,
  `delivery_charge` double(10,2) DEFAULT '0.00',
  `gstTaxableamount` double(10,2) DEFAULT NULL,
  `HSN` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_purchaseDtlId` (`purchase_detail_id`),
  KEY `FK_bagDtl_Id` (`purchase_bag_id`),
  KEY `FK_rawteasale_masterId` (`rawteasale_master_id`),
  CONSTRAINT `FK_bagDtl_Id` FOREIGN KEY (`purchase_bag_id`) REFERENCES `purchase_bag_details` (`id`),
  CONSTRAINT `FK_purchaseDtlId` FOREIGN KEY (`purchase_detail_id`) REFERENCES `purchase_invoice_detail` (`id`),
  CONSTRAINT `FK_rawteasale_masterId` FOREIGN KEY (`rawteasale_master_id`) REFERENCES `rawteasale_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9364 DEFAULT CHARSET=latin1;

/*Table structure for table `rawteasale_master` */

DROP TABLE IF EXISTS `rawteasale_master`;

CREATE TABLE `rawteasale_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(100) DEFAULT NULL,
  `invoice_no_old` varchar(255) DEFAULT NULL,
  `sale_date` datetime DEFAULT NULL,
  `customer_id` int(10) DEFAULT NULL,
  `voucher_master_id` int(10) DEFAULT NULL,
  `vehichleno` varchar(50) DEFAULT NULL,
  `taxrateType` enum('V','C') DEFAULT NULL,
  `taxrateTypeId` int(10) DEFAULT NULL,
  `taxamount` double(10,2) DEFAULT NULL,
  `discountRate` double(10,2) DEFAULT NULL,
  `discountAmount` double(10,2) DEFAULT NULL,
  `deliverychgs` double(10,2) DEFAULT NULL,
  `total_sale_bag` double(10,2) DEFAULT NULL,
  `total_sale_qty` double(10,2) DEFAULT NULL,
  `totalamount` double(10,2) DEFAULT NULL,
  `roundoff` double(10,2) DEFAULT NULL,
  `grandtotal` double(10,2) DEFAULT NULL,
  `company_id` int(10) DEFAULT NULL,
  `year_id` int(10) DEFAULT NULL,
  `isGST` enum('Y','N') DEFAULT 'N',
  `placeofsupply` varchar(255) DEFAULT NULL,
  `gstTaxableAmount` double(10,2) DEFAULT NULL,
  `gstTaxincludedAmt` double(10,2) DEFAULT NULL,
  `totalCGST` double(10,2) DEFAULT NULL,
  `totalSGST` double(10,2) DEFAULT NULL,
  `totalIGST` double(10,2) DEFAULT NULL,
  `state_code` int(10) DEFAULT NULL,
  `hsn` varchar(255) DEFAULT NULL,
  `transporter_id` int(10) DEFAULT NULL,
  `consignee_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_customer_id` (`customer_id`),
  KEY `FK_voucher_master_id` (`voucher_master_id`),
  CONSTRAINT `FK_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  CONSTRAINT `FK_voucher_master_id` FOREIGN KEY (`voucher_master_id`) REFERENCES `voucher_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=601 DEFAULT CHARSET=latin1;

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `role_name` varchar(50) NOT NULL,
  `id` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `sale_bill_details` */

DROP TABLE IF EXISTS `sale_bill_details`;

CREATE TABLE `sale_bill_details` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `salebillmasterid` int(20) DEFAULT NULL,
  `HSN` varchar(255) DEFAULT NULL,
  `productpacketid` int(20) DEFAULT NULL,
  `packingbox` double(10,2) DEFAULT NULL,
  `packingnet` double(10,2) DEFAULT NULL,
  `quantity` double(10,2) DEFAULT NULL,
  `rate` double(10,2) DEFAULT NULL,
  `amount` double(10,2) DEFAULT NULL,
  `discount_rate` double(10,2) DEFAULT NULL,
  `discount` double(10,2) DEFAULT NULL,
  `delivery_charge` double(10,2) DEFAULT NULL,
  `taxableamount` double(10,2) DEFAULT NULL,
  `cgstrateid` int(11) DEFAULT NULL,
  `cgstamount` double(10,2) DEFAULT NULL,
  `sgstrateid` int(11) DEFAULT NULL,
  `sgstamount` double(10,2) DEFAULT NULL,
  `igstrateid` int(11) DEFAULT NULL,
  `igstamount` double(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_salebill_master` (`salebillmasterid`),
  KEY `fk_product_packet_id` (`productpacketid`),
  CONSTRAINT `fk_product_packet_id` FOREIGN KEY (`productpacketid`) REFERENCES `product_packet` (`id`),
  CONSTRAINT `fk_salebill_master` FOREIGN KEY (`salebillmasterid`) REFERENCES `sale_bill_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20539 DEFAULT CHARSET=utf8;

/*Table structure for table `sale_bill_master` */

DROP TABLE IF EXISTS `sale_bill_master`;

CREATE TABLE `sale_bill_master` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `srl_no` int(20) DEFAULT NULL,
  `salebillno` varchar(255) DEFAULT NULL,
  `salebillno_old` varchar(255) DEFAULT NULL,
  `salebilldate` datetime DEFAULT NULL,
  `customerId` int(20) DEFAULT NULL,
  `taxinvoiceno` varchar(255) DEFAULT NULL,
  `taxinvoicedate` datetime DEFAULT NULL,
  `voucher_master_id` int(11) DEFAULT NULL,
  `transporterId` int(10) DEFAULT NULL,
  `vehichleno` varchar(50) DEFAULT NULL,
  `duedate` datetime DEFAULT NULL,
  `taxrateType` enum('C','V') DEFAULT NULL COMMENT 'C=CST,V=VAT',
  `taxrateTypeId` int(20) DEFAULT NULL,
  `taxamount` double(10,2) DEFAULT NULL,
  `discountRate` double(10,2) DEFAULT NULL,
  `discountAmount` double(10,2) DEFAULT NULL,
  `deliverychgs` double(10,2) DEFAULT NULL,
  `totalpacket` double(10,2) DEFAULT NULL,
  `totalquantity` double(10,2) DEFAULT NULL,
  `totalamount` double(10,2) DEFAULT NULL,
  `roundoff` double(10,2) DEFAULT NULL,
  `grandtotal` double(10,2) DEFAULT NULL,
  `yearid` int(20) DEFAULT NULL,
  `companyid` int(20) DEFAULT NULL,
  `creationdate` int(20) DEFAULT NULL,
  `userid` int(20) DEFAULT NULL,
  `GST_Discountamount` decimal(12,2) DEFAULT NULL,
  `GST_Taxableamount` decimal(12,2) DEFAULT NULL,
  `GST_Totalgstincluded` decimal(12,2) DEFAULT NULL,
  `GST_Freightamount` decimal(12,2) DEFAULT NULL,
  `GST_Insuranceamount` decimal(12,2) DEFAULT NULL,
  `GST_PFamount` decimal(12,2) DEFAULT NULL,
  `totalCGST` decimal(12,2) DEFAULT NULL,
  `totalSGST` decimal(12,2) DEFAULT NULL,
  `totalIGST` decimal(12,2) DEFAULT NULL,
  `IsGST` enum('Y','N') DEFAULT 'N',
  `GST_placeofsupply` varchar(255) DEFAULT NULL,
  `state_code` int(10) DEFAULT NULL,
  `consignee_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_customer` (`customerId`),
  KEY `fk_voucher_mast_id` (`voucher_master_id`),
  CONSTRAINT `fk_customer` FOREIGN KEY (`customerId`) REFERENCES `customer` (`id`),
  CONSTRAINT `fk_voucher_mast_id` FOREIGN KEY (`voucher_master_id`) REFERENCES `voucher_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3382 DEFAULT CHARSET=utf8;

/*Table structure for table `saler_to_buyer_details` */

DROP TABLE IF EXISTS `saler_to_buyer_details`;

CREATE TABLE `saler_to_buyer_details` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `saler_to_buyer_master_id` int(10) DEFAULT NULL,
  `lot` int(10) DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `garden_id` int(10) DEFAULT NULL,
  `grade_id` int(10) DEFAULT NULL,
  `gp_number` int(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `package` int(10) DEFAULT NULL,
  `stamp` decimal(10,2) DEFAULT NULL,
  `gross` decimal(10,2) DEFAULT NULL,
  `brokerage` decimal(10,2) DEFAULT NULL,
  `total_weight` decimal(10,2) DEFAULT NULL,
  `rate_type_value` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `service_tax` decimal(10,2) DEFAULT NULL,
  `total_value` decimal(10,2) DEFAULT NULL,
  `chest_from` int(10) DEFAULT NULL,
  `chest_to` int(10) DEFAULT NULL,
  `value_cost` decimal(10,2) DEFAULT NULL,
  `net` int(10) DEFAULT NULL,
  `rate_type` enum('V','C') DEFAULT NULL,
  `rate_type_id` int(11) DEFAULT NULL,
  `service_tax_id` int(11) DEFAULT NULL,
  `teagroup_master_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_STBD_saler_to_buyer_master` (`saler_to_buyer_master_id`),
  KEY `FK_STBD_garden_id` (`garden_id`),
  KEY `FK_STBD_grade_id` (`grade_id`),
  CONSTRAINT `FK_STBD_garden_id` FOREIGN KEY (`garden_id`) REFERENCES `garden_master` (`id`),
  CONSTRAINT `FK_STBD_grade_id` FOREIGN KEY (`grade_id`) REFERENCES `grade_master` (`id`),
  CONSTRAINT `FK_STBD_saler_to_buyer_master` FOREIGN KEY (`saler_to_buyer_master_id`) REFERENCES `saler_to_buyer_master` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `saler_to_buyer_master` */

DROP TABLE IF EXISTS `saler_to_buyer_master`;

CREATE TABLE `saler_to_buyer_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `salertobuyer_invoice_number` varchar(255) DEFAULT NULL,
  `salertobuyer_invoice_date` date DEFAULT NULL,
  `vendor_id` int(10) DEFAULT NULL,
  `sale_number` varchar(10) DEFAULT NULL,
  `sale_date` date DEFAULT NULL,
  `promt_date` date DEFAULT NULL,
  `tea_value` decimal(10,2) DEFAULT NULL,
  `brokerage` decimal(10,2) DEFAULT NULL,
  `service_tax` decimal(10,2) DEFAULT NULL,
  `total_vat` decimal(10,2) DEFAULT NULL,
  `chestage_allowance` decimal(10,2) DEFAULT NULL,
  `stamp` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `voucher_master_id` int(11) DEFAULT NULL,
  `total_cst` decimal(10,2) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_STB_vendor_id` (`vendor_id`),
  KEY `FK_STB_vouchermaster_id` (`voucher_master_id`),
  KEY `FK_STB_company_id` (`company_id`),
  KEY `PK_STB_year_id` (`year_id`),
  CONSTRAINT `FK_STB_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_STB_vendor_id` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_STB_vouchermaster_id` FOREIGN KEY (`voucher_master_id`) REFERENCES `voucher_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `PK_STB_year_id` FOREIGN KEY (`year_id`) REFERENCES `financialyear` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `saler_to_buyer_sample` */

DROP TABLE IF EXISTS `saler_to_buyer_sample`;

CREATE TABLE `saler_to_buyer_sample` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `saler_to_buyer_detail_id` int(10) DEFAULT NULL,
  `sample_number` int(10) DEFAULT NULL,
  `sample_net` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_STBS_saler_to_buyer_detail_id` (`saler_to_buyer_detail_id`),
  CONSTRAINT `FK_STBS_saler_to_buyer_detail_id` FOREIGN KEY (`saler_to_buyer_detail_id`) REFERENCES `saler_to_buyer_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `serialmaster` */

DROP TABLE IF EXISTS `serialmaster`;

CREATE TABLE `serialmaster` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `Serial` int(20) NOT NULL,
  `moduleTag` varchar(50) DEFAULT NULL,
  `lastnumber` int(20) DEFAULT NULL,
  `noofpaddingdigit` int(20) DEFAULT NULL,
  `module` varchar(255) DEFAULT NULL,
  `companyid` int(20) DEFAULT NULL,
  `yearid` int(20) DEFAULT NULL,
  `yeartag` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Table structure for table `serials` */

DROP TABLE IF EXISTS `serials`;

CREATE TABLE `serials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `moduleType` varchar(100) DEFAULT NULL,
  `srl_number` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `service_tax` */

DROP TABLE IF EXISTS `service_tax`;

CREATE TABLE `service_tax` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tax_rate` decimal(10,2) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Table structure for table `state_master` */

DROP TABLE IF EXISTS `state_master`;

CREATE TABLE `state_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(255) DEFAULT NULL,
  `state_code` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

/*Table structure for table `stock` */

DROP TABLE IF EXISTS `stock`;

CREATE TABLE `stock` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `stock_related_detail_id` int(10) DEFAULT NULL,
  `from_where` enum('PR','SB') DEFAULT NULL,
  `received_master_id` int(10) DEFAULT NULL,
  `company_id` int(10) DEFAULT NULL,
  `year_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_stock_company_id` (`company_id`),
  KEY `FK_stock_year_id` (`year_id`),
  CONSTRAINT `FK_stock_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  CONSTRAINT `FK_stock_year_id` FOREIGN KEY (`year_id`) REFERENCES `financialyear` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `stocktransfer_out_detail` */

DROP TABLE IF EXISTS `stocktransfer_out_detail`;

CREATE TABLE `stocktransfer_out_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stocktransfer_out_master_id` int(10) DEFAULT NULL,
  `purchase_detail_id` int(10) DEFAULT NULL,
  `purchase_bag_id` int(10) DEFAULT NULL,
  `num_of_stockout_bag` int(10) DEFAULT NULL,
  `qty_stockout_kg` double(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_purBagdtlId` (`purchase_bag_id`),
  KEY `FK_purchase_detailId` (`purchase_detail_id`),
  KEY `FK_stcktransfr_out_mast_id` (`stocktransfer_out_master_id`),
  CONSTRAINT `FK_purBagdtlId` FOREIGN KEY (`purchase_bag_id`) REFERENCES `purchase_bag_details` (`id`),
  CONSTRAINT `FK_purchase_detailId` FOREIGN KEY (`purchase_detail_id`) REFERENCES `purchase_invoice_detail` (`id`),
  CONSTRAINT `FK_stcktransfr_out_mast_id` FOREIGN KEY (`stocktransfer_out_master_id`) REFERENCES `stocktransfer_out_master` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `stocktransfer_out_master` */

DROP TABLE IF EXISTS `stocktransfer_out_master`;

CREATE TABLE `stocktransfer_out_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `refrence_number` varchar(255) DEFAULT NULL,
  `transfer_date` datetime DEFAULT NULL,
  `customer_id` int(10) DEFAULT NULL,
  `cn_no` varchar(200) DEFAULT NULL,
  `stock_outBags` int(10) DEFAULT NULL,
  `stock_outPrice` decimal(10,2) DEFAULT NULL,
  `stock_outKgs` double(10,2) DEFAULT NULL,
  `company_id` int(10) DEFAULT NULL,
  `year_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `subgroup_name` */

DROP TABLE IF EXISTS `subgroup_name`;

CREATE TABLE `subgroup_name` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `subledger` */

DROP TABLE IF EXISTS `subledger`;

CREATE TABLE `subledger` (
  `subledgerid` int(20) NOT NULL AUTO_INCREMENT,
  `subledger` varchar(255) NOT NULL,
  `isActive` enum('Y','N') DEFAULT 'Y',
  `company_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`subledgerid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `teagroup_master` */

DROP TABLE IF EXISTS `teagroup_master`;

CREATE TABLE `teagroup_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_code` varchar(50) DEFAULT NULL,
  `group_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Table structure for table `transport` */

DROP TABLE IF EXISTS `transport`;

CREATE TABLE `transport` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` text CHARACTER SET utf8,
  `Phone` varchar(255) DEFAULT NULL,
  `pin` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

/*Table structure for table `unitmaster` */

DROP TABLE IF EXISTS `unitmaster`;

CREATE TABLE `unitmaster` (
  `unitid` int(20) NOT NULL AUTO_INCREMENT,
  `unitName` varchar(255) NOT NULL,
  `isActive` enum('Y','N') DEFAULT 'Y',
  PRIMARY KEY (`unitid`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Table structure for table `unreleaseddo` */

DROP TABLE IF EXISTS `unreleaseddo`;

CREATE TABLE `unreleaseddo` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `purchase_invoice_master_id` int(10) DEFAULT NULL,
  `do_number` int(10) DEFAULT NULL,
  `do_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_unreleaseddo_purchase_invoice_master_id` (`purchase_invoice_master_id`),
  CONSTRAINT `FK_unreleaseddo_purchase_invoice_master_id` FOREIGN KEY (`purchase_invoice_master_id`) REFERENCES `purchase_invoice_master` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `user_activity_report` */

DROP TABLE IF EXISTS `user_activity_report`;

CREATE TABLE `user_activity_report` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `activity_date` datetime DEFAULT NULL,
  `activity_module` varchar(225) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `narration` varchar(500) DEFAULT NULL,
  `from_method` varchar(255) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

/*Table structure for table `userole` */

DROP TABLE IF EXISTS `userole`;

CREATE TABLE `userole` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `role_id` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_USERROLE_UID` (`user_id`),
  KEY `FK_USERROLE_RID` (`role_id`),
  CONSTRAINT `FK_USERROLE_RID` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `FK_USERROLE_UID` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `login_id` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL,
  `First_Name` varchar(255) DEFAULT NULL,
  `Last_Name` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Contact_Number` varchar(255) DEFAULT NULL,
  `IS_ACTIVE` enum('Y','N') DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `vat` */

DROP TABLE IF EXISTS `vat`;

CREATE TABLE `vat` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `vat_rate` decimal(10,2) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Table structure for table `vendor` */

DROP TABLE IF EXISTS `vendor`;

CREATE TABLE `vendor` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `account_master_id` int(10) DEFAULT NULL,
  `tin_number` varchar(50) DEFAULT NULL,
  `cst_number` varchar(50) DEFAULT NULL,
  `pan_number` varchar(50) DEFAULT NULL,
  `service_tax_number` varchar(50) DEFAULT NULL,
  `GST_Number` varchar(50) DEFAULT NULL,
  `pin_number` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vendor_account_master_id` (`account_master_id`),
  KEY `state_id` (`state_id`),
  CONSTRAINT `FK_vendor_account_master_id` FOREIGN KEY (`account_master_id`) REFERENCES `account_master` (`id`),
  CONSTRAINT `FK_vendor_state_id` FOREIGN KEY (`state_id`) REFERENCES `state_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=248 DEFAULT CHARSET=latin1;

/*Table structure for table `vendor_bill_master` */

DROP TABLE IF EXISTS `vendor_bill_master`;

CREATE TABLE `vendor_bill_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `bill_amount` double(10,4) DEFAULT NULL,
  `due_amount` double(10,4) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `voucher_id` int(11) DEFAULT NULL,
  `from_where` enum('PR','SB') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_billmaster_voucher_id` (`voucher_id`),
  KEY `FK_billmaster_company_id` (`company_id`),
  KEY `FK_billmaster_year_id` (`year_id`),
  KEY `bill_id` (`bill_id`),
  CONSTRAINT `FK_billmaster_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  CONSTRAINT `FK_billmaster_voucher_id` FOREIGN KEY (`voucher_id`) REFERENCES `voucher_master` (`id`),
  CONSTRAINT `FK_billmaster_year_id` FOREIGN KEY (`year_id`) REFERENCES `financialyear` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `vendor_opening_balance_noneed` */

DROP TABLE IF EXISTS `vendor_opening_balance_noneed`;

CREATE TABLE `vendor_opening_balance_noneed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) DEFAULT NULL,
  `bill_number` varchar(255) DEFAULT NULL,
  `bill_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `bill_amount` double(10,4) DEFAULT NULL,
  `due_amount` double(10,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vbalnc_vendor_id` (`vendor_id`),
  CONSTRAINT `FK_vbalnc_vendor_id` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `vendoradjustmentdetails` */

DROP TABLE IF EXISTS `vendoradjustmentdetails`;

CREATE TABLE `vendoradjustmentdetails` (
  `vendAdjstDtlId` int(20) NOT NULL AUTO_INCREMENT,
  `vendAdjstMstId` int(20) DEFAULT NULL,
  `vendorBillMasterId` int(20) DEFAULT NULL,
  `adjustedAmount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`vendAdjstDtlId`),
  KEY `FK_adjstMst_id` (`vendAdjstMstId`),
  KEY `FK_Bill_mst_id` (`vendorBillMasterId`),
  CONSTRAINT `FK_Bill_mst_id` FOREIGN KEY (`vendorBillMasterId`) REFERENCES `vendorbillmaster` (`vendorBillMasterId`),
  CONSTRAINT `FK_adjstMst_id` FOREIGN KEY (`vendAdjstMstId`) REFERENCES `vendoradvanceadjustmentmaster` (`AdjustmentId`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Table structure for table `vendoradvanceadjustmentmaster` */

DROP TABLE IF EXISTS `vendoradvanceadjustmentmaster`;

CREATE TABLE `vendoradvanceadjustmentmaster` (
  `AdjustmentId` int(20) NOT NULL AUTO_INCREMENT,
  `AdjustmentRefNo` varchar(256) DEFAULT NULL,
  `DateOfAdjustment` datetime DEFAULT NULL,
  `vendorAccId` int(20) DEFAULT NULL,
  `advanceMasterId` int(20) DEFAULT NULL,
  `TotalAmountAdjusted` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`AdjustmentId`),
  KEY `FK_vendor_accId` (`vendorAccId`),
  KEY `FK_AdvanceMstId` (`advanceMasterId`),
  CONSTRAINT `FK_AdvanceMstId` FOREIGN KEY (`advanceMasterId`) REFERENCES `vendoradvancemaster` (`advanceId`),
  CONSTRAINT `FK_vendor_accId` FOREIGN KEY (`vendorAccId`) REFERENCES `account_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Table structure for table `vendoradvancemaster` */

DROP TABLE IF EXISTS `vendoradvancemaster`;

CREATE TABLE `vendoradvancemaster` (
  `advanceId` int(20) NOT NULL AUTO_INCREMENT,
  `advanceDate` datetime DEFAULT NULL,
  `voucherId` int(20) DEFAULT NULL,
  `advanceAmount` decimal(10,2) DEFAULT NULL,
  `vendorId` int(20) DEFAULT NULL,
  `isFullAdjusted` enum('Y','N') DEFAULT NULL,
  `companyId` int(20) DEFAULT NULL,
  `yearId` int(20) DEFAULT NULL,
  `payment_type` enum('PY','RC') DEFAULT 'PY',
  PRIMARY KEY (`advanceId`),
  KEY `FK_VOUCHER` (`voucherId`),
  KEY `FK_VENDOR` (`vendorId`),
  CONSTRAINT `FK_VENDOR` FOREIGN KEY (`vendorId`) REFERENCES `account_master` (`id`),
  CONSTRAINT `FK_VOUCHER` FOREIGN KEY (`voucherId`) REFERENCES `voucher_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=354 DEFAULT CHARSET=latin1;

/*Table structure for table `vendorbillmaster` */

DROP TABLE IF EXISTS `vendorbillmaster`;

CREATE TABLE `vendorbillmaster` (
  `vendorBillMasterId` int(20) NOT NULL AUTO_INCREMENT,
  `billDate` datetime NOT NULL,
  `billAmount` decimal(10,2) NOT NULL,
  `invoiceMasterId` int(20) NOT NULL,
  `purchaseType` enum('T','O','F') DEFAULT NULL COMMENT 'T=Tea O=Others F= Finish purchase',
  `vendorAccountId` int(20) NOT NULL,
  `companyId` int(20) NOT NULL,
  `yearId` int(20) NOT NULL,
  PRIMARY KEY (`vendorBillMasterId`),
  KEY `FK_vendor_acc_id` (`vendorAccountId`),
  CONSTRAINT `FK_vendor_acc_id` FOREIGN KEY (`vendorAccountId`) REFERENCES `account_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5874 DEFAULT CHARSET=utf8;

/*Table structure for table `vendorbillpaymentdetail` */

DROP TABLE IF EXISTS `vendorbillpaymentdetail`;

CREATE TABLE `vendorbillpaymentdetail` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `vendorpaymentid` int(20) DEFAULT NULL,
  `vendorBillMaster` int(20) DEFAULT NULL,
  `paidAmount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Vendor_payment_master` (`vendorpaymentid`),
  KEY `FK_Vendor_Bill_Master` (`vendorBillMaster`),
  CONSTRAINT `FK_Vendor_Bill_Master` FOREIGN KEY (`vendorBillMaster`) REFERENCES `vendorbillmaster` (`vendorBillMasterId`),
  CONSTRAINT `FK_Vendor_payment_master` FOREIGN KEY (`vendorpaymentid`) REFERENCES `vendorbillpaymentmaster` (`vendorPaymentId`)
) ENGINE=InnoDB AUTO_INCREMENT=2626 DEFAULT CHARSET=latin1;

/*Table structure for table `vendorbillpaymentmaster` */

DROP TABLE IF EXISTS `vendorbillpaymentmaster`;

CREATE TABLE `vendorbillpaymentmaster` (
  `vendorPaymentId` int(20) NOT NULL AUTO_INCREMENT,
  `dateofpayment` datetime NOT NULL,
  `vendorid` int(20) NOT NULL,
  `totalpaidamount` decimal(10,2) DEFAULT NULL,
  `voucherId` int(20) NOT NULL,
  `typeofpayment` enum('T','O') DEFAULT NULL COMMENT 'T=Teabill,O=Others',
  PRIMARY KEY (`vendorPaymentId`),
  KEY `FK_Voucher_bill_pay` (`voucherId`),
  KEY `FK_Vendor_bill_pay` (`vendorid`),
  CONSTRAINT `FK_Vendor_bill_pay` FOREIGN KEY (`vendorid`) REFERENCES `account_master` (`id`),
  CONSTRAINT `FK_Voucher_bill_pay` FOREIGN KEY (`voucherId`) REFERENCES `voucher_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1991 DEFAULT CHARSET=latin1;

/*Table structure for table `voucher_detail` */

DROP TABLE IF EXISTS `voucher_detail`;

CREATE TABLE `voucher_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_master_id` int(11) DEFAULT NULL,
  `account_master_id` int(11) DEFAULT NULL,
  `voucher_amount` double(10,2) DEFAULT NULL,
  `is_debit` enum('Y','N') DEFAULT 'N',
  `account_id_for_trial` int(10) DEFAULT NULL,
  `subledger_id` int(10) DEFAULT NULL,
  `is_master` enum('Y','N') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_voucherdetail_voucher_master_id` (`voucher_master_id`),
  KEY `FK_voucherdetail_account_master_id` (`account_master_id`),
  CONSTRAINT `FK_voucherdetail_account_master_id` FOREIGN KEY (`account_master_id`) REFERENCES `account_master` (`id`),
  CONSTRAINT `FK_voucherdetail_voucher_master_id` FOREIGN KEY (`voucher_master_id`) REFERENCES `voucher_master` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=94989 DEFAULT CHARSET=latin1;

/*Table structure for table `voucher_master` */

DROP TABLE IF EXISTS `voucher_master`;

CREATE TABLE `voucher_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_number` varchar(255) DEFAULT NULL,
  `voucher_date` date DEFAULT NULL,
  `narration` varchar(255) DEFAULT NULL,
  `cheque_number` varchar(255) DEFAULT NULL,
  `cheque_date` datetime DEFAULT NULL,
  `chq_clear_on` datetime DEFAULT NULL,
  `is_chq_clear` enum('N','Y') DEFAULT NULL,
  `transaction_type` varchar(50) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `serial_number` int(11) NOT NULL,
  `vouchertype` varchar(10) DEFAULT NULL,
  `branchid` int(10) DEFAULT NULL,
  `paid_to` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_voucher_created_by` (`created_by`),
  KEY `FK_voucher_company_id` (`company_id`),
  KEY `FK_voucher_year_id` (`year_id`),
  CONSTRAINT `FK_voucher_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  CONSTRAINT `FK_voucher_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_voucher_year_id` FOREIGN KEY (`year_id`) REFERENCES `financialyear` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23713 DEFAULT CHARSET=latin1;

/*Table structure for table `warehouse` */

DROP TABLE IF EXISTS `warehouse`;

CREATE TABLE `warehouse` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `area` varchar(100) DEFAULT 'null',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
