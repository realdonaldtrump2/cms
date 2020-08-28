<?php

namespace common\components;

use Yii;
use yii\base\Component;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Excel extends Component
{


    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function jobfairGenerate()
    {

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

        $spreadsheet->createSheet();

        $sheet = $spreadsheet->setActiveSheetIndex(0);

        $sheet->setTitle('选项卡1');

        $sheet->setCellValue('A1', 'ID1');
        $sheet->setCellValue('B1', '姓名1');
        $sheet->setCellValue('C1', '年龄1');
        $sheet->setCellValue('D1', '身高1');

        $sheet->setCellValueByColumnAndRow(1, 2, 1);
        $sheet->setCellValueByColumnAndRow(2, 2, '李雷');
        $sheet->setCellValueByColumnAndRow(3, 2, '18岁');
        $sheet->setCellValueByColumnAndRow(4, 2, '188cm');

        $sheet->setCellValueByColumnAndRow(1, 3, 2);
        $sheet->setCellValueByColumnAndRow(2, 3, '韩梅梅');
        $sheet->setCellValueByColumnAndRow(3, 3, '17岁');
        $sheet->setCellValueByColumnAndRow(4, 3, '165cm');

        $spreadsheet->createSheet();

        $sheet = $spreadsheet->setActiveSheetIndex(1);

        $sheet->setTitle('选项卡2');

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', '姓名');
        $sheet->setCellValue('C1', '年龄');
        $sheet->setCellValue('D1', '身高');

        $sheet->setCellValueByColumnAndRow(1, 2, 1);
        $sheet->setCellValueByColumnAndRow(2, 2, '李雷');
        $sheet->setCellValueByColumnAndRow(3, 2, '18岁');
        $sheet->setCellValueByColumnAndRow(4, 2, '188cm');

        $sheet->setCellValueByColumnAndRow(1, 3, 2);
        $sheet->setCellValueByColumnAndRow(2, 3, '韩梅梅');
        $sheet->setCellValueByColumnAndRow(3, 3, '17岁');
        $sheet->setCellValueByColumnAndRow(4, 3, '165cm');

        $writer = new Xlsx($spreadsheet);
        // $writer->save('hello world.xlsx');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="01simple.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $writer->save('php://output');
        exit;

    }


}
