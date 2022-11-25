<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\PdfLibrary;
use App\Models\BImbinganModel;
use Dompdf\Dompdf;
use TCPDF;

class Export extends BaseController
{
    public $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = $this->db->table("bimbingan")->get()->getResult();
        return view('bimbingan', [
            "bimbingan" => $data
        ]);
    }

    public function generate_pdf()
    {
        $pdf = new PdfLibrary(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetTitle('Sales Information for Products');
        $pdf->SetSubject('Report generated using Codeigniter and TCPDF');

        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set font
        $pdf->SetFont('times', 12);

        // ---------------------------------------------------------


        //Generate HTML table data from MySQL - start
        $table = new \CodeIgniter\View\Table();

        $template = array(
            'table_open' => '<table border="1" cellpadding="2" cellspacing="1">'
        );

        $table->setTemplate($template);

        $table->setHeading('Product Id', 'Price', 'Sale Price', 'Sales Count', 'Sale Date');

        $model = new BImbinganModel();

        $salesinfo = $model->get();

        // foreach ($salesinfo as $sf) :
        //     $table->addRow($sf->id, $sf->price, $sf->sale_price, $sf->sales_count, $sf->sale_date);
        // endforeach;

        $html = $table->generate();
        //Generate HTML table data from MySQL - end

        // add a page
        $pdf->AddPage();

        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // reset pointer to the last page
        $pdf->lastPage();

        //Close and output PDF document
        $pdf->Output(md5(time()) . '.pdf', 'D');
    }
}
