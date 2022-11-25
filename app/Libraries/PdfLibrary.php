<?php

namespace App\Libraries;

use TCPDF;

/**
 * Description of Pdf Library
 *
 * @author https://roytuts.com
 */
class PdfLibrary extends TCPDF
{

    function __construct()
    {
        parent::__construct();
    }

    //Page header
    public function Header()
    {
        // Set font
        $this->SetFont('times',  12);
        // Title
        $this->Cell(0, 15, 'Laporan Bimbingan', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('times', 12);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
