<?php
require('fpdf.php');
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "roda28";
$dbName = "resortdb";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword,$dbName);



$sql ="select * from room ";//*where id = '$pid'*/ "
  $re = mysqli_query($conn,$sql);
  while($row=mysqli_fetch_array($re))
  {
    $repid = $row['roomId'];
    $resid =  $row['roomName'];
    $custname = $row['roomRate'];
    $resdate = $row['roomQuantity'];
    $checkin = $row['roomStatus'];
     /*$cin_date = $row['cin'];
    $cout_date = $row['cout'];
    $nodays = $row['nodays'];*/
  
  }
$pdf = new FPDF( 'P','mm','A4');

$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
//$pdf->Cell(40,10,'Hola, Mundo!');

$pdf->Cell(60,20,'',20,20);

$pdf->Output();
$file = $re;

class PDF extends FPDF 
{

	Function LoadData($file)
	{

		$lines=file($file);
		$data=array();
		foreach ($lines as $line)  
			$data[] = exlpode(';',chop($line));
			return $data;
			# code...
		
	}
	function BasicTable($header,$data)
	{

		foreach ($header as $col) 
			$this->Cell(40,7,$col,1);
			$this->Ln();

			foreach ($data as $row) 
				{
				foreach ($row as $col)
					# code...
				$this->Cell(40,6,$col,1);
				$this->Ln();
					# code...
					# code...
				}
		
	}
	function ImprovedTable($header,$data)
	{

			$w= array(40,35,40,45);

			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],7,$header[$i],1,0,'C');
			$this->Ln();

			foreach($data as $row)
			{

				$this->Cell($w[0],6,$row[0],'LR');
				$this->Cell($w[1],6,$row[1],'LR');
				$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
				$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
				$this->Ln();
			}

			$this->Cell(array_sum($w),0,'','T');
	}

	function FancyTable($header,$data)
	{
		$this->SetFillColor(255,0,0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('','B');

		$w=array(40,35,40,45);
		for($i =0; $i<count($header);$i++)
			$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
			$this->Ln();

			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');

			$fill =false;
			foreach ($data as $row) 
			{ 
				$this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
				$this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
				$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
				$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
				$this->Ln();

				$fill=!$fill;

				# code...
			}
			$this->Cell(array_sum($w),0,'','T');

	}

}

$pdf = new PDF();

$header =array('Pais','Capital','Superficie','Pobl.(en Miles)');

$data=$pdf->LoadData('data.php');
$pdf->SetFont('Arial','',12);
$pdf->AddPage();
$pdf->BasicTable($header,$data);
$pdf->AddPage();
$pdf->ImprovedTable($header,$data);
$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Output();

?>