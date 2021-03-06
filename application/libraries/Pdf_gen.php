<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("./vendor/dompdf/dompdf/autoload.inc.php");
use Dompdf\Dompdf;
use Dompdf\Options;


class Pdf_gen
{
  public function generate($html, $filename='', $stream=TRUE, $paper = 'A4', $orientation = "portrait")
  {
    $options = new Options();
    $options->set('isHtml5ParserEnabled', TRUE);
    $options->set('isRemoteEnabled', TRUE);
    
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper($paper, $orientation);
    $dompdf->set_base_path("./assets/bootstrap/css/bootstrap.min.css");
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf", array("Attachment" => false));
		exit(0);
    } else {
        return $dompdf->output();
    }
  }
}