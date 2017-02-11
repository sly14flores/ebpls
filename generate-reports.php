<?php

$app_form = array(""=>"","new_app"=>"New","renew_app"=>"Renewal","additional_app"=>"Additional");

$app_amendment = array(""=>"","single_partnership"=>"From Single to Partnership","single_corporation"=>"From Single to Corporation","partnership_single"=>"From Partnership to Single","partnership_corporation"=>"From Partnership to Corporation","corporation_single"=>"From Corporation to Single","corporation_partnership"=>"From Corporation to Partnership");

$app_organization = array(""=>"","single_organization"=>"Single","partnership_organization"=>"Partnership","corporation_organization"=>"Corporation","cooperative_organization"=>"Cooperative");

$app_mode_of_payment = array(""=>"","pay_annually"=>"Annually","pay_bi_annually"=>"Bi-Annually","pay_quarterly"=>"Quarterly");

$columns = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL");

require_once 'Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("ebpls Bacnotan")
							 ->setLastModifiedBy("ebpls Bacnotan")
							 ->setTitle("Report")
							 ->setSubject("Report")
							 ->setDescription("Business Licenses Report")
							 ->setKeywords("Business Licenses Report")
							 ->setCategory("Reports");

require 'config.php';

$application_no = (isset($_GET['application_no'])) ? $_GET['application_no'] : "";
$application_reference_no = (isset($_GET['application_reference_no'])) ? $_GET['application_reference_no'] : "";
$applicant_fullname = (isset($_GET['applicant_fullname'])) ? $_GET['applicant_fullname'] : "";
$application_form = (isset($_GET['application_form'])) ? $_GET['application_form'] : "all";
$application_organization_type = (isset($_GET['application_organization_type'])) ? $_GET['application_organization_type'] : "all";
$application_mode_of_payment = (isset($_GET['application_mode_of_payment'])) ? $_GET['application_mode_of_payment'] : "all";
$application_date = (isset($_GET['application_date'])) ? $_GET['application_date'] : "";
if ($application_date != "") $application_date = date("Y-m-d",strtotime($application_date));
$application_month = (isset($_GET['application_month'])) ? $_GET['application_month'] : "0";
$application_year = (isset($_GET['application_year'])) ? $_GET['application_year'] : "";

$filter = " WHERE application_id != 0";
$c1 = " and application_reference_no like '%$application_reference_no%'";
$c2 = " and concat(application_taxpayer_lastname, ', ', application_taxpayer_firstname, ' ', application_taxpayer_middlename) = '$applicant_fullname'";
$c3 = " and application_form = '$application_form'";
$c4 = " and application_organization_type = '$application_organization_type'";
$c5 = " and application_mode_of_payment = '$application_mode_of_payment'";
$c6 = " and substring(application_date,1,10) = '$application_date'";
$c7 = " and application_date like '%-$application_month-%'";
$c8 = " and application_date like '$application_year-%'";
$c9 = " and application_no like '%$application_no%'";

if ($application_reference_no == "") $c1 = "";
if ($applicant_fullname == "") $c2 = "";
if ($application_form == "all") $c3 = "";
if ($application_organization_type == "all") $c4 = "";
if ($application_mode_of_payment == "all") $c5 = "";
if ($application_date == "") $c6 = "";
if ($application_month == "0") $c7 = "";
if ($application_year == "") $c8 = "";
if ($application_no == "") $c9 = "";

$filter .= $c1 . $c2 . $c3 . $c4 . $c5 . $c6 . $c7 . $c8 . $c9;

$sql = "SELECT application_id, business_status, application_no, application_form, application_amendment, application_taxpayer_business_name, application_mode_of_payment, application_date, application_reference_no, application_dti_sec_cda, application_dti_sec_cda_date, application_organization_type, application_ctc_no, application_ctc_date, application_tin, application_entity, application_taxpayer_lastname, application_taxpayer_firstname, application_taxpayer_middlename, application_taxpayer_gender, application_taxpayer_business_name, application_trade_franchise, application_treasurer_lastname, application_treasurer_firstname, application_treasurer_middlename, application_business_address_no, application_business_address_bldg, application_business_address_unit_no, application_business_address_street, application_business_address_brgy, application_business_address_subd, application_business_address_mun_city, application_business_address_province, application_business_address_tel_no, application_business_address_email, application_owner_address_no, application_owner_address_bldg, application_owner_address_unit_no, application_owner_address_street, application_owner_address_brgy, application_owner_address_subd, application_owner_address_mun_city, application_owner_address_province, application_owner_address_tel_no, application_owner_address_email, application_pin, application_business_area, application_no_employees, application_no_residing, application_lessor_lastname, application_lessor_firstname, application_lessor_middlename, application_monthly_rental, application_lessor_address_no, application_lessor_address_street, application_lessor_address_brgy, application_lessor_address_subd, application_lessor_address_mun_city, application_lessor_address_province, application_lessor_address_tel_no, application_lessor_address_email, application_contact_person, application_position_title, (concat(application_taxpayer_lastname, ', ', application_taxpayer_firstname, ' ', application_taxpayer_middlename)) full_name, if((concat(application_treasurer_lastname, application_treasurer_firstname, application_treasurer_middlename)) = '','',(concat(application_treasurer_lastname, ', ', application_treasurer_firstname, ' ', application_treasurer_middlename))) president_fullname, (concat(application_business_address_no, ' ', application_business_address_bldg, ' ', application_business_address_unit_no, ' ', application_business_address_street, ' ', application_business_address_brgy, ' ', application_business_address_subd, ' ', application_business_address_mun_city, ' ', application_business_address_province)) business_address, (concat(application_owner_address_no, ' ', application_owner_address_bldg, ' ', application_owner_address_unit_no, ' ', application_owner_address_street, ' ', application_owner_address_brgy, ' ', application_owner_address_subd, ' ', application_owner_address_mun_city, ' ', application_owner_address_province)) owner_address, (if(concat(application_lessor_lastname, application_lessor_firstname, application_lessor_middlename) = '','',concat(application_lessor_lastname, ', ', application_lessor_firstname, ' ', application_lessor_middlename))) lessor_fullname, (concat(application_lessor_address_no, ' ', application_lessor_address_street, ' ', application_lessor_address_brgy, ' ', application_lessor_address_subd, ' ', application_lessor_address_mun_city, ' ', application_lessor_address_province)) lessor_address, (SELECT ba_line FROM business_activities WHERE ba_id = (SELECT aba_b_line FROM application_business_activities WHERE aba_fid = application_id)) business_line, (SELECT aba_units FROM application_business_activities WHERE aba_fid = application_id) business_units, (SELECT aba_gross_base FROM application_business_activities WHERE aba_fid = application_id) business_base, (SELECT if(aba_gross_base = 'capitalization',aba_gross_amount,'') FROM application_business_activities WHERE aba_fid = application_id) capitalization, (SELECT if(aba_gross_base = 'essential',aba_gross_amount,'') FROM application_business_activities WHERE aba_fid = application_id) essential, (SELECT if(aba_gross_base = 'non-essential',aba_gross_amount,'') FROM application_business_activities WHERE aba_fid = application_id) non_essential, if(concat(application_signatory_lastname, application_signatory_firstname, application_signatory_middlename) = '','',concat(application_signatory_lastname, ', ', application_signatory_firstname, ' ', application_signatory_middlename)) signatory_name, IFNULL((SELECT payment_schedule_or FROM billing WHERE payment_schedule_fid = application_id ORDER BY payment_schedule_id ASC LIMIT 1),'') or_no, IF((SELECT payment_schedule_date_paid FROM billing WHERE payment_schedule_fid = application_id ORDER BY payment_schedule_id ASC LIMIT 1) = '0000-00-00','',DATE_FORMAT((SELECT payment_schedule_date_paid FROM billing WHERE payment_schedule_fid = application_id ORDER BY payment_schedule_id ASC LIMIT 1),'%m-%d-%Y')) or_date, (SELECT if(aba_item_not_applicable = 0,aba_item_amount,0) FROM aba_items WHERE aba_item_fid = application_id AND aba_item_assessment = 1) tax_due, (SELECT sum(if(aba_item_not_applicable = 0,aba_item_amount,0)) FROM aba_items WHERE aba_item_fid = application_id AND aba_item_assessment != 1) others_due FROM applications $filter";

db_connect();
$rs = $db_con->query($sql);
$rc = $rs->num_rows;
if ($rc) {

$objPHPExcel->getDefaultStyle()->getFont()->setSize(14);

for ($n=0; $n<count($columns); ++$n) {
	$objPHPExcel->getActiveSheet()->getColumnDimension($columns[$n])->setAutoSize(true);
}

$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue("A1","Date")
			->setCellValue("B1","Ref.No.")
			->setCellValue("C1","App.No.")
			->setCellValue("D1","Type")
			->setCellValue("E1","Mode of Payment")
			->setCellValue("F1","DTI/SEC/CDA No.")
			->setCellValue("G1","DTI/SEC/CDA Date")
			->setCellValue("H1","Organization")
			->setCellValue("I1","TIN")
			->setCellValue("J1","Taxpayer Full Name")
			->setCellValue("K1","Gender")
			->setCellValue("L1","Business Name")
			->setCellValue("M1","Trade Name/Franchise")
			->setCellValue("N1","President/Treasurer Name")
			->setCellValue("O1","Business Address")
			->setCellValue("P1","Tel. No.")
			->setCellValue("Q1","Email")
			->setCellValue("R1","Owner Address")
			->setCellValue("S1","Tel. No.")
			->setCellValue("T1","Email")
			->setCellValue("U1","PIN")
			->setCellValue("V1","Business Area")
			->setCellValue("W1","No. of Employees")
			->setCellValue("X1","No. of Employees Residing in LGU")
			->setCellValue("Y1","Lessor Name")
			->setCellValue("Z1","Lessor Address")
			->setCellValue("AA1","Contact Person in case of Emergency")
			->setCellValue("AB1","Line of Business")
			->setCellValue("AC1","No. of Units")
			->setCellValue("AD1","Capitalization")
			->setCellValue("AE1","Essential")
			->setCellValue("AF1","Non-essential")
			->setCellValue("AG1","Signatory")
			->setCellValue("AH1","Position/Title")
			->setCellValue("AI1","OR No.")
			->setCellValue("AJ1","OR Date")
			->setCellValue("AK1","Tax Due")
			->setCellValue("AL1","Total Amount Due")
			->setCellValue("AM1","Business Status");
			
			for ($n=0; $n<count($columns); ++$n) {
				$objPHPExcel->getActiveSheet()->getStyle($columns[$n]."1")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->getStyle($columns[$n]."1")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->getStyle($columns[$n]."1")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->getStyle($columns[$n]."1")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);				
			}
			
			$objPHPExcel->getActiveSheet()->getRowDimension("1")->setRowHeight(25);
			
			$objPHPExcel->getActiveSheet()->getStyle('A1:AL1')->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()->setARGB('8A8A8A');
						
$c = 2;
$business_status = array(""=>"","operating"=>"Operating","not_renewed"=>"Not Renewed","closed_terminated"=>"Closed/Terminated","delinquent"=>"Delinquent");
$renewal_due = date("Y-01-20");
	for ($i=0; $i<$rc; ++$i) {
		$rec = $rs->fetch_array();
		
		/*
		**	filter business status
		*/
		$bs = $rec['business_status'];
		
		$bs = $rec['business_status'];
		$succeeding_year = date("Y",strtotime("+1 Year",strtotime($rec['application_date'])));
		$sql1 = "SELECT * FROM applications WHERE application_reference_no = '$rec[application_reference_no]' AND SUBSTRING(application_date,1,4) = $succeeding_year";
		$rs1 = $db_con->query($sql1);
		$rc1 = $rs1->num_rows;
		if ($rc1 == 0) $bs = "delinquent";
		else $bs = "operating";
		if (date("Y",strtotime($rec['application_date'])) == date("Y")) $bs = "operating";		

		$total_amount_due = $rec['tax_due'] + $rec['others_due'];
		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue("A$c", date("m/d/Y",strtotime($rec['application_date'])))
					->setCellValue("B$c", $rec['application_reference_no'])
					->setCellValue("C$c", $rec['application_no'])
					->setCellValue("D$c", $app_form[$rec['application_form']])
					->setCellValue("E$c", $app_mode_of_payment[$rec['application_mode_of_payment']])
					->setCellValue("F$c", $rec['application_dti_sec_cda'])
					->setCellValue("G$c", ($rec['application_dti_sec_cda_date'] != "0000-00-00") ? date("m/d/Y",strtotime($rec['application_dti_sec_cda_date'])) : "")
					->setCellValue("H$c", $app_organization[$rec['application_organization_type']])
					->setCellValue("I$c", $rec['application_tin'])
					->setCellValue("J$c", $rec['full_name'])
					->setCellValue("K$c", $rec['application_taxpayer_gender'])
					->setCellValue("L$c", $rec['application_taxpayer_business_name'])
					->setCellValue("M$c", $rec['application_trade_franchise'])
					->setCellValue("N$c", $rec['president_fullname'])
					->setCellValue("O$c", $rec['business_address'])
					->setCellValue("P$c", $rec['application_business_address_tel_no'])
					->setCellValue("Q$c", $rec['application_business_address_email'])
					->setCellValue("R$c", $rec['owner_address'])
					->setCellValue("S$c", $rec['application_owner_address_tel_no'])
					->setCellValue("T$c", $rec['application_owner_address_email'])
					->setCellValue("U$c", $rec['application_pin'])
					->setCellValue("V$c", $rec['application_business_area'])
					->setCellValue("W$c", $rec['application_no_employees'])
					->setCellValue("X$c", $rec['application_no_residing'])
					->setCellValue("Y$c", $rec['lessor_fullname'])
					->setCellValue("Z$c", $rec['lessor_address'])
					->setCellValue("AA$c", $rec['application_contact_person'])
					->setCellValue("AB$c", $rec['business_line'])
					->setCellValue("AC$c", $rec['business_units'])
					->setCellValue("AD$c", $rec['capitalization'])
					->setCellValue("AE$c", $rec['essential'])
					->setCellValue("AF$c", $rec['non_essential'])
					->setCellValue("AG$c", $rec['signatory_name'])
					->setCellValue("AH$c", $rec['application_position_title'])
					->setCellValue("AI$c", $rec['or_no'])
					->setCellValue("AJ$c", $rec['or_date'])
					->setCellValue("AK$c", $rec['tax_due'])
					->setCellValue("AL$c", $total_amount_due)
					->setCellValue("AM$c", $business_status[$bs]);
					
		for ($n=0; $n<count($columns); ++$n) {
			$objPHPExcel->getActiveSheet()->getStyle($columns[$n].$c)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle($columns[$n].$c)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle($columns[$n].$c)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle($columns[$n].$c)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		}					
		
		$objPHPExcel->getActiveSheet()->getRowDimension($c)->setRowHeight(25);		
		
		$c++;
	}
}
db_close();							
			
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Licenses');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);		

// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// $objWriter->save(str_replace('.php', '.xlsx', __FILE__));

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Business Licenses ' . date("Y-m-d h:i A") . '.xlsx"');
header('Cache-Control: max-age=0');

/*
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
*/

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

?>