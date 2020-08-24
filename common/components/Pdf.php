<?php

namespace common\components;

use Yii;
use yii\base\Component;
use TCPDF;
use common\data\ResumePdf;


class Pdf extends Component
{


    public function resumeGenerate()
    {

        $application_name = '应用名称';

        // 实例化
        $pdf = new ResumePdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // 设置文档信息
        // set document information
        $pdf->SetCreator($application_name);
        $pdf->SetAuthor($application_name);
        $pdf->SetTitle($application_name);
        $pdf->SetSubject($application_name);
        $pdf->SetKeywords($application_name);


        // 去掉页眉页脚
        // remove default header/footer
        // $pdf->setPrintHeader(false);
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        // $pdf->setPrintFooter(false);

        // 自动分页
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // 设置字体
        // set font
        $pdf->SetFont('stsongstdlight', '', 14);

        // 进行自动分页
        // add a page
        $pdf->AddPage();

        $html = <<<EOD
<table border="0" style="padding: 5px;">
<tr >
    <td style="border: 1px solid grey;text-align: left;" rowspan="3" > 
        <img src="https://qn.hbqingze.com/b830d20200820183036398.png" style="height:320px;width: 320px;" alt="">
    </td>
    <td style="border-bottom: 2px solid grey;text-align: left; height: 68px;" > 
        <b style="font-size: 48px;" >安安</b>
    </td>
    <td style="border-bottom: 2px solid grey;text-align: left;line-height: 50px;" colspan="2" > 
        <span style="font-size: 20px;" >求职意向：UI设计师</span>
    </td>
</tr>
<tr>
    <td style="border: 1px solid grey;line-height: 100px;" align="center"> 
        1
    </td>
    <td style="border: 1px solid grey;" align="right"> 
        2
    </td>
    <td></td>
</tr>
<tr>
    <td style="border: 1px solid grey;line-height: 100px;" align="center"> 
        1
    </td>
    <td style="border: 1px solid grey;" align="right"> 
        2
    </td>
    <td></td>
</tr>
</table>
EOD;

        $pdf->writeHTML($html, true, false, false, false, '');

        $pdf_name = $application_name . '.pdf';
        $pdf->Output($pdf_name, 'I');
        exit();

    }


}
