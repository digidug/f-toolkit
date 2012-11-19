<?php

class Pdf_Controller extends Base_Controller {

	public $restful = true;
	
	public function get_generate(){
		$pdf = new PDF();
		
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);
		for($i=1;$i<=40;$i++){
			$pdf->Cell(0,10,'Printing line number '.$i,0,1);
			$pdf->Output();
		}
		
		//return View::make('pages.generate-pdf');
	}
}