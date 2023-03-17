<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once dirname(__FILE__) . '/mpdf/mpdf.php';

class Pdf extends MPDF {

    const DPI = 96;
    const MM_IN_INCH = 25.4;
    const A4_HEIGHT = 297;
    const A4_WIDTH = 210;
    // tweak these values (in pixels)
    const MAX_WIDTH = 800;
    const MAX_HEIGHT = 500;

    function __construct() {
        parent::__construct();
    }

    public function create_pdf($path='', $filename = '', $html = '', $footer = '', $stream = true, $show_page_num = true, $showwatermarker = false, $watermarkertext = '',$watermarkerimage='',$header = '') {
        $mpdf = new mPDF('utf-8', 'A4',0,'ctimes',7,7,35,10,5,0);
//        ('utf-8', 'A4',0,'',5,5,5,5,60);
//        ($mode, $format, $default_font_size, $default_font, $mgl, $mgr, $mgt, $mgb, $mgh,$mgf)
        if ($show_page_num)
            $mpdf->setFooter('Page {PAGENO} / {nbpg}');
        if ($showwatermarker) {
            //call watermark content aand image
            $mpdf->SetWatermarkText($watermarkertext);
            $mpdf->watermarkTextAlpha = 0.1;
            $mpdf->showWatermarkText = true;
            $mpdf->SetWatermarkImage($watermarkerimage,0.2);
            $mpdf->showWatermarkImage = true;
            
        }
        
        
//        var_dump($header);die();
        $mpdf->SetHTMLHeader($header);
//        $mpdf->SetHTMLHeader('<img src="'. base_url().'ressources/img/logo_test.PNG" width="100%" height="50px" />');
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($html);
        

        if ($stream) {
            $mpdf->Output($filename . '.pdf', 'I');
        } else {

//    		$path   =   BASEPATH . 'pdfinvoices/';
//    		$path   =   APPPATH . 'pdfinvoices/';
//            $path = RESOURCESFOLDER . 'ordonnance/';

            if (is_dir($path)) {
                $mpdf->Output(realpath($path) . '/' . $filename . '.pdf', 'F');
            } else {
                echo realpath($path);
            }
            return $path . $filename . '.pdf';
        }
    }

    public function create_mini_pdf($filename = '', $html = '', $stream = true, $show_page_num = false) {
        $mpdf = new mPDF('utf-8', 'A5-L');
        if ($show_page_num)
            $mpdf->setFooter('{PAGENO}');

        $mpdf->WriteHTML($html);
//    	$mpdf->AddPage('L');

        if ($stream) {
            $mpdf->Output($filename . '.pdf', 'I');
        } else {

            $path = BASEPATH . 'pdfinvoices/';
            if (is_dir($path)) {
                $mpdf->Output(realpath($path) . '/' . $filename . '.pdf', 'F');
            } else {
                echo realpath($path);
            }
            return $path . $filename . '.pdf';
        }
    }

    public function image_pdf($image) {

        $pdf = new MPDF();
        $pdf->AddPage("L");
        $pdf->Image(ASSETSFOLDER . 'attachements/cheque.jpg', 0, 0, 524, 240, 'jpg', '', true, false);
//        $pdf->Image($image,0,0,170,170);
        $pdf->Output();
    }

    function pixelsToMM($val) {
        return $val * self::MM_IN_INCH / self::DPI;
    }

    function resizeToFit($imgFilename) {
        list($width, $height) = getimagesize($imgFilename);
        $widthScale = self::MAX_WIDTH / $width;
        $heightScale = self::MAX_HEIGHT / $height;
        $scale = min($widthScale, $heightScale);
        return array(
            round($this->pixelsToMM($scale * $width)),
            round($this->pixelsToMM($scale * $height))
        );
    }

    function centreImage($img) {
        list($width, $height) = $this->resizeToFit($img);
        // you will probably want to swap the width/height
        // around depending on the page's orientation
        $this->Image(
                $img, (self::A4_HEIGHT - $width) / 2, (self::A4_WIDTH - $height) / 2, $width, $height
        );
    }

}
