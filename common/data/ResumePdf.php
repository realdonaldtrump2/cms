<?php

namespace common\data;

use TCPDF;


class ResumePdf extends TCPDF
{


    public function Header()
    {

//        $this->SetFont('Gotham Medium', 'C', 50);
//        $this->SetTextColor(209,183,49);

//        $this->Ln(5);
//        $this->Cell(278, 15, 'custom header', 0, false, 'C', 0, '', 0, false, 'M', 'M');
//
//        $headerData = $this->getHeaderData();
//        $this->SetFont('helvetica', 'B', 10);
//        $this->writeHTML($headerData['string']);

        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set background image
        $img_file = "https://qn.hbqingze.com/6f612202008231533291863.png";
        $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();

        $this->SetTopMargin(15);
        $this->SetFooterMargin(0);

    }


//    public function Footer()
//    {
//
//        // Position at 15 mm from bottom
//        $this->SetY(-15);
//        // Set font
//        $this->SetFont('stsongstdlight', 'B', 16);
//        // Page number
//        $this->Cell(0, 10, '' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
//
//    }


}