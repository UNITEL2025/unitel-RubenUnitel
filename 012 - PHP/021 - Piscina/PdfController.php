<?php
# PdfController.php
# https://www.fpdf.org/

require_once "librerias/fpdf/fpdf.php";

class PdfController extends FPDF {
    //Tamaño A4: 210 x 297 milímetros

    protected $widths;
    protected $aligns;

    protected $isFooter;

    function SetFooter($w)
    {
        $this->isFooter = $w;
    }

    function SetWidths($w)
    {
        // Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        // Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data)
    {
        // Calculate the height of the row
        $nb = 0;
        for($i=0;$i<count($data);$i++)
            $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h = 5*$nb;
        // Issue a page break first if needed
        $this->CheckPageBreak($h);
        // Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Draw the border
            $this->Rect($x,$y,$w,$h);
            // Print the text
            $this->MultiCell($w,5,mb_convert_encoding($data[$i], "ISO-8859-1"),0,$a);
            // Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        // Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        // If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        // Compute the number of lines a MultiCell of width w will take
        if(!isset($this->CurrentFont))
            $this->Error('No font has been set');
        $cw = $this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',(string)$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i<$nb)
        {
            $c = $s[$i];
            if($c=="\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep = $i;
            $l += $cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i = $sep+1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    function truncate($str, $length) {
        $isCut = false;
        while ($this->GetStringWidth($str) > $length) {
            $str = substr($str, 0, strlen($str) - 1);
            $isCut = true;
        }
        if ($isCut == true) {
            $str = substr($str, 0, strlen($str) - 3)."...";
        }
        return $str;
    }

    // Tabla simple
    public function BasicTable($titulo, $header, $data)
    {
        //Título
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(20,10,mb_convert_encoding($titulo, "ISO-8859-1"),0);
        $this->Ln();
        $this->SetFont('Arial', 'B', 12);
        // Cabecera
        $this->Row($header);
        $this->SetFont('Arial', '', 12);
        //foreach($header as $col)
           // $this->Cell(40,7,mb_convert_encoding($col, "ISO-8859-1"),1);
        //$this->Ln();
        // Datos
        foreach($data as $row)
        {
            $this->Row($row);
            //foreach($row as $col)
                //$this->Cell(40,6,mb_convert_encoding($this->truncate($col, 40), "ISO-8859-1"),1);
            //$this->Ln();
        }
    }

    function Footer()
    {
        if ($this->isFooter == true) {
            // Go to 1.5 cm from bottom
            $this->SetY(-15);
            // Select Arial italic 8
            $this->SetFont('Arial', 'I', 8);
            // Print centered page number
            $this->Cell(0, 10, mb_convert_encoding('Página '.$this->PageNo(), "ISO-8859-1"), 0, 0, 'C');
        }
    }

    // Una tabla más completa
    public function ImprovedTable($header, $data)
    {
        // Anchuras de las columnas
        $w = array(40, 35, 45, 40);
        // Cabeceras
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C');
        $this->Ln();
        // Datos
        foreach($data as $row)
        {
            $this->Cell($w[0],6,$row[0],'LR');
            $this->Cell($w[1],6,$row[1],'LR');
            $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
            $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
            $this->Ln();
        }
        // Línea de cierre
        $this->Cell(array_sum($w),0,'','T');
    }

    // Tabla coloreada
    public function FancyTable($header, $data)
    {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(255,0,0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128,0,0);
        $this->SetLineWidth(.3);
        $this->SetFont('','B');
        // Cabecera
        $w = array(40, 35, 45, 40);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos
        $fill = false;
        foreach($data as $row)
        {
            $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
            $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
            $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
            $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
        $this->Cell(array_sum($w),0,'','T');
    }

    function sanitize($input)
    {
        return preg_replace( '/[^a-z0-9]+/', '_', strtolower( $input ) );
    }

    public function create(string $titulo, array $header, array $data, array $len) {
        $pdf = new FPDF();//Instanciar la clase PDF
        $this->SetFont('Arial', '', 12); //Indicar la fuente
        $this->AddPage("L");//Añadir página
        $this->SetWidths($len);
        $this->BasicTable($titulo, $header,$data);
        /*$this->AddPage();
        $this->ImprovedTable($header,$data);
        $this->AddPage();
        $this->FancyTable($header,$data);*/
        $this->Output("I", $this->sanitize($titulo).".pdf");
    }

    public function createTicket(object $venta) {

        $pdf = new FPDF();
        $this->SetFooter(false);

        $empleado = empleado::getById($venta->empleado_id);

        foreach ($venta->detalles as $detalle) {
            $producto = producto::getById($detalle->producto_id);

            for ($i=0; $i < $detalle->ctd; $i++) {
                $this->AddPage('P', array(80, 90));
                $w = $h = 0;
                
                $this->SetFont('Arial', '', 12);
                //(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
                $text = "************************************";
                $this->Cell($w, $h, mb_convert_encoding($text, "ISO-8859-1"), 0, 1, "L");
                
                $w += 5;
                $h += 5;
                $text = "*              MI PISCINA              *";
                $this->Cell($w, $h, mb_convert_encoding($text, "ISO-8859-1"), 0, 1, "L");
                
                $text = "************************************";
                $this->Cell($w, $h, mb_convert_encoding($text, "ISO-8859-1"), 0, 1, "L");

                $this->SetFont('Arial', '', 10);
                $text = "Excmo Ayuntamiento de Oropesa";
                $this->Cell($w, $h, mb_convert_encoding($text, "ISO-8859-1"), 0, 1, "L");

                $text = "PISCINA MUNICIPAL";
                $this->Cell($w, $h, mb_convert_encoding($text, "ISO-8859-1"), 0, 1, "L");

                $this->SetFont('Arial', '', 12);
                $text = "************************************";
                $this->Cell($w, $h, mb_convert_encoding($text, "ISO-8859-1"), 0, 1, "L");

                $this->SetFont('Arial', '', 12);
                $text = "************************************";
                $this->Cell($w, $h, mb_convert_encoding("REF: ".$detalle->referencias[$i]->referencia, "ISO-8859-1"), 0, 1, "L");

                $this->SetFont('Arial', '', 12);
                $text = "************************************";
                $this->Cell($w, $h, mb_convert_encoding($text, "ISO-8859-1"), 0, 1, "L");
                
                $this->SetFont('Arial', '', 10);
                $this->Cell($w, $h, mb_convert_encoding($producto->nombre, "ISO-8859-1"), 0, 1, "L");
                $this->Cell($w, $h, mb_convert_encoding("Precio: ".$detalle->precio, "ISO-8859-1"), 0, 1, "L");
                $this->Cell($w, $h, mb_convert_encoding("Pago: ".$venta->metodo_pago, "ISO-8859-1"), 0, 1, "L");

                $this->SetFont('Arial', '', 8);
                $this->Cell($w, $h, mb_convert_encoding("Le atendio ".$empleado->nombre." | ".$venta->id_venta." | ".$venta->fecha, "ISO-8859-1"), 0, 1, "L");

                
            }
        }
        $this->Output("I", $venta->id_venta.".pdf");
    }
}