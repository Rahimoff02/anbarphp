<?php
session_start();

$con=mysqli_connect('localhost','faiq','555','anbar');

/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                             ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', '#')
            ->setCellValue('C2', 'Musteri')
            ->setCellValue('E2', 'Mehsul')
            ->setCellValue('F2', 'Brand')
            ->setCellValue('G2', 'Alish')
            ->setCellValue('H2', 'Satish')
            ->setCellValue('I2', 'Stok')
            ->setCellValue('J2', 'Sifarish')
            ->setCellValue('K2', 'Qazanc')
            ->setCellValue('L2', 'Tarix');

$secim=mysqli_query($con,"SELECT * FROM orders WHERE user_id ='".$_SESSION['user_id']."' ORDER BY id DESC");

$i=0;
$n=2;

 while($info=mysqli_fetch_array($secim))
  {
    $i++;
    $n++;

     $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$n, $i)
            ->setCellValue('C'.$n, $info['musteri'])
            ->setCellValue('E'.$n, $info['mehsul'])
            ->setCellValue('F'.$n, $info['brend'])
            ->setCellValue('G'.$n, $info['alish'])
            ->setCellValue('H'.$n, $info['satish'])
            ->setCellValue('I'.$n, $info['stok'])
            ->setCellValue('J'.$n, $info['sifarish'])
            ->setCellValue('K'.$n, $info['tarix']);
  }

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client???s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="anbar_orders_'.date('Ymd_His').'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
