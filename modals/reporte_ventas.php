<?php
//sleep(1);
require '../pdf/fpdf.php';
require '../cn/cnt.php';
date_default_timezone_set("america/mexico_city");

class PDF extends FPDF
{    
    // Cabecera de página
    function Header()
    {
        $this->Image('../logo.jpeg', 230, 0, 50); // logo, posicion X, posicion Y, tamaño                
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        $fecha = date("d-m-Y");
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Helvetica', '', 8);
        // Número de página
        $this->Cell(170, 10, utf8_decode('Fecha:  ' . $fecha));
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 1, 'C');        
    }
    /* ------------------- METODO PARA ADAPTAR LAS CELDAS ------------------------------- */
    var $widths;
    var $aligns;

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data, $setX) //yo modifique el script a  mi conveniencia :D
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }

        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h, $setX);        
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {            
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h, 'DF');
            //Print the text            
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);            
        }
        //Go to the next line
        $this->Ln($h);
    }

    /* CUANDO SE HACE UN SALTO DE PAGINA, SE HACE LO SIGUIENTE */
    function CheckPageBreak($h, $setX)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);            
            $this->SetX($setX);            
            //volvemos a definir el  encabezado cuando se crea una nueva pagina                        
            $this->SetFont('Helvetica', 'B', 6);
            $this->SetFillColor(226, 226, 210);         
            $this->Cell(20, 8, 'CODIGO', 1, 0, 'C', 1);
            $this->Cell(100, 8, 'PRODUCTO', 1, 0, 'C', 1);
            $this->Cell(20, 8, 'EXISTENCIAS', 1, 0, 'C', 1);
            $this->Cell(25, 8, 'P. UNITARIO', 1, 0, 'C', 1);
            $this->Cell(25, 8, 'U. VENDIDAS', 1, 0, 'C', 1);
            $this->Cell(25, 8, 'TOTAL', 1, 0, 'C', 1);
            $this->Cell(23, 8, 'UTILIDAD', 1, 0, 'C', 1);
            $this->Cell(25, 8, 'PROPIETARIO', 1, 1, 'C', 1);
            $this->SetFont('Courier', '', 6); //tipo de letra para las celdas              
            $this->SetFillColor(255, 255, 255);
        }

        if ($setX == 100) {
            $this->SetX(100);
        } else {
            $this->SetX($setX);
        }
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }

        $wmax = ($w - 1 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n") {
            $nb--;
        }

        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }

            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }

                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }
    /* ------------------- AQUI TERMINA ------------------------------- */
}

/* --------------------------------- CONEXION A LA BD ------------------------------------ */
$fechaInicial = $_REQUEST['fechaInicial'];
$fechaFinal = $_REQUEST['fechaFinal'];

$strConsulta = "SELECT idVenta, codigoArticulo, unidades, costoUnidades, total, fechaVenta, utilidad, 
descripcion, existencias, precioUnitario, propietario 
FROM ventas1 INNER JOIN productos ON ventas1.codigoArticulo = productos.codigoProducto 
WHERE DATE(fechaVenta) >= '$fechaInicial' AND DATE(fechaVenta)<= '$fechaFinal' ORDER BY idVenta ASC; ";

$datos = $Oxi->query($strConsulta);
$numfilas = $datos->num_rows;


// Creación del objeto de la clase heredada
$pdf = new PDF('L', 'mm', 'Letter'); //Hacemos la instancia de FPDF
$pdf->AliasNbPages();
$pdf->AddPage(); //añadimos una nueva página en blanco
$pdf->SetMargins(10, 10, 10); //margen a toda la hoja
$pdf->SetAutoPageBreak(true, 20); // salto de página 

/* ---------------------------------------------------------------------------------------- */
//cell (ancho, largo, contenido, borde?, salto de linea)
//Ajustamos el tipo de letra antes de los encabezados
$pdf->SetFont('Helvetica', 'B', 6);
//aquí ya no hay salto de línea, por lo tanto las celdas van a continuar
$pdf->SetFillColor(226, 226, 210);
$pdf->Cell(20, 8, 'CODIGO', 1, 0, 'C', 1);
$pdf->Cell(100, 8, 'PRODUCTO', 1, 0, 'C', 1);
$pdf->Cell(20, 8, 'EXISTENCIAS', 1, 0, 'C', 1);
$pdf->Cell(25, 8, 'P. UNITARIO', 1, 0, 'C', 1);
$pdf->Cell(25, 8, 'U. VENDIDAS', 1, 0, 'C', 1);
$pdf->Cell(25, 8, 'TOTAL', 1, 0, 'C', 1);
$pdf->Cell(23, 8, 'UTILIDAD', 1, 0, 'C', 1);
$pdf->Cell(25, 8, 'PROPIETARIO', 1, 1, 'C', 1);

//Ok, es hora de darle color a las celdas y color a las líneas
$pdf->SetFillColor(255, 255, 255); // color de fondo rgba
//$pdf->SetDrawColor(61, 61, 61); // color de la linea

$pdf->SetFont('Courier', '', 6); //tipo de letra para las celdas
//El ancho de las celdas
$pdf->SetWidths(array(20, 100, 20, 25, 25, 25, 23, 25));
$pdf->SetAligns(array('C','L','C','C','C','C','C', 'C'));

/* AQUI CALCULAR TOAL, UTILIDAD, REPONER */
$total = 0;
$total_articulos = 0;
$total_ventas = 0;
$utilidad = 0;
$reponer = 0;

for ($i = 0; $i < $numfilas; $i++) {    
    $fila = $datos->fetch_array();    
    $pdf->Row(array(
        $fila['codigoArticulo'], utf8_decode($fila['descripcion']), $fila['existencias'],
        '$' . $fila['precioUnitario'], $fila['unidades'], $fila['total'], '$' . $fila['utilidad'], $fila['propietario']
    ), 10);    
    $total_articulos = $total_articulos + $fila['unidades'];
    $total_ventas += $fila['total'];
    $utilidad += $fila['utilidad'];
}
$reponer = $total_ventas - $utilidad;

/* --------------------------------- AQUÍ VA EL TOTAL -------------------------------------  */
$pdf->Ln(1);
//cell (ancho, largo, contenido, borde?, salto de linea)
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(35, 15,'ARTICULOS: '. $total_articulos,0, 0, 0);
$pdf->Cell(50, 15, 'TOTAL: $' . number_format($total_ventas, 2), 0, 0, 0);
$pdf->Cell(60, 15, 'UTILIDAD: $' . number_format($utilidad, 2), 0, 0, 0);
$pdf->Cell(70, 15, 'REPONER: $' . number_format($reponer, 2), 0, 0, 0);
/* ----------------------------------------------------------------------------------------  */
$fecha = date("dmY_his");
$pdf->Output('COTIZACION_' . $fecha . '.pdf', 'I');