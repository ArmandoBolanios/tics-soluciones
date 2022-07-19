<?php
sleep(1);
require 'pdf/fpdf.php';
require 'cn/cnt.php';
require 'pdf/NumeroALetras.php';

use Luecano\NumeroALetras\NumeroALetras;

date_default_timezone_set("america/mexico_city");

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        $idCotizacion = $_REQUEST['cotizacion'];
        $this->SetFont('Helvetica', 'B', 12); //tipo de letra y tamaño        
        $this->Image('logo.jpeg', 180, 10, 90); // logo, posicion X, posicion Y, tamaño        
        $this->Cell(35, 15, utf8_decode('COTIZACIÓN No.'), 0);
        $this->Cell(10, 15, $idCotizacion, 0);
        $this->Ln(10);
        $this->SetFont('Helvetica', 'B', 11); //tipo de letra y tamaño
        $this->Cell(58, 8, utf8_decode('SOLUCIONES TICS TLAPA'), 0);
        $this->Ln(6);
        $this->SetFont('Helvetica', '', 11);
        $this->Cell(65, 8, utf8_decode('C. Añorve #93 Col. San Francisco'), 0);
        $this->Ln(5);
        $this->Cell(72, 8, utf8_decode('Tlapa de Comonfort, Gro. C.P. 41304'), 0);
        $this->Ln(5);
        $this->Cell(40, 8, utf8_decode('Tel. Cel.  y WhatsApp: '), 0);
        $this->SetFont('Helvetica', 'B', 11);
        $this->Cell(10, 8, '757 121 2338', 0);
        $this->Ln(5);
        $this->SetFont('Helvetica', '', 11);
        $this->Cell(19, 8, utf8_decode('Sitio Web:'), 0);
        $this->SetFont('Helvetica', 'B', 11);
        $this->Cell(38, 8, 'www.tics-tlapa.com', 0);
        $this->Ln(5);
        $this->SetFont('Helvetica', '', 11);
        $this->Cell(35, 8, utf8_decode('Correo Electrónico: '), 0);
        $this->SetFont('Helvetica', 'B', 11);
        $this->Cell(50, 8, 'soluciones@tics-tlapa.com', 0);
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        $fecha_hora = $_REQUEST['fecha_hora'];
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Helvetica', '', 8);
        // Número de página
        $this->Cell(170, 10, utf8_decode('Fecha de cotización:  ' . $fecha_hora));
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 1, 'C');
        $this->Cell(170, 0, utf8_decode('Horarios de Lunes a Viernes de 8:00 AM a 6:00 PM. Sábados de 8:00 AM a 3:30 PM.'));
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
            // clave, descripcion, factor, precio_unitario             
            $this->SetFont('Helvetica', 'B', 10);
            $this->Cell(10, 8, 'No', 1, 0, 'C', 0);
            $this->Cell(130, 8, 'PRODUCTO', 1, 0, 'C', 0);
            $this->Cell(20, 8, 'FACTOR', 1, 0, 'C', 0);
            $this->Cell(25, 8, 'CONTENIDO', 1, 0, 'C', 0);
            $this->Cell(25, 8, 'P. UNITARIO', 1, 0, 'C', 0);
            $this->Cell(23, 8, 'CANTIDAD', 1, 0, 'C', 0);
            $this->Cell(25, 8, 'SUBTOTAL', 1, 1, 'C', 0);
            $this->SetFont('Arial', '', 12);
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
$claveAfter = $_REQUEST['clave'];
$strConsulta = "SELECT DISTINCT producto_cotizacion.clave, cantidad, descripcion, factor, contenido, 
    precio_unitario, sub_total FROM producto_cotizacion INNER JOIN cotizacion 
    ON producto_cotizacion.clave = cotizacion.clave AND cotizacion.clave = '$claveAfter' ";

$datos = $Oxi->query($strConsulta);
$numfilas = $datos->num_rows;


// Creación del objeto de la clase heredada
$pdf = new PDF('L', 'mm', 'Letter'); //Hacemos la instancia de FPDF
$pdf->AliasNbPages();
$pdf->AddPage(); //añadimos una nueva página en blanco
$pdf->SetMargins(10, 10, 10); //margen a toda la hoja
$pdf->SetAutoPageBreak(true, 20); // salto de página 


/* ---------------------------------------------------------------------------------------- */
$nombre_cliente = mb_strtoupper($_REQUEST['nombre_cliente']);
$telefono = $_REQUEST['telefono'];
$correo = $_REQUEST['correo'];
$direccion = ucwords($_REQUEST['direccion']);

//$pdf->Ln(5);        
$pdf->SetFont('Helvetica', '', 11);
$pdf->Cell(55, 8, utf8_decode('Cliente:'), 0);
$pdf->SetFont('Helvetica', 'B', 11);
$pdf->SetX(30);
$pdf->Cell(115, 8, utf8_decode($nombre_cliente), 0);
$pdf->Ln(5);
$pdf->SetFont('Helvetica', '', 11);
$pdf->Cell(55, 8, utf8_decode('Dirección:'), 0);
$pdf->SetFont('Helvetica', 'B', 11);
$pdf->SetX(30);
$pdf->Cell(100, 8, utf8_decode($direccion), 0, 0, 'L');
$pdf->SetFont('Helvetica', '', 11);
$pdf->Ln(5);
$pdf->Cell(10, 8, utf8_decode('Contacto:'), 0);
$pdf->SetFont('Helvetica', 'B', 11);
$pdf->SetX(30);
$pdf->Cell(90, 8, utf8_decode($correo . ' - ' . $telefono), 0, 0, 'L');
$pdf->Ln(15);

/* ---------------------------------------------------------------------------------------- */
//cell (ancho, largo, contenido, borde?, salto de linea)
//Ajustamos el tipo de letra antes de los encabezados
$pdf->SetFont('Helvetica', 'B', 8);
//aquí ya no hay salto de línea, por lo tanto las celdas van a continuar
$pdf->SetFillColor(255, 212, 0, 0.96);
$pdf->Cell(10, 8, 'No', 1, 0, 'C', 1);
$pdf->Cell(130, 8, 'PRODUCTO', 1, 0, 'C', 1);
$pdf->Cell(20, 8, 'FACTOR', 1, 0, 'C', 1);
$pdf->Cell(25, 8, 'CONTENIDO', 1, 0, 'C', 1);
$pdf->Cell(25, 8, 'P. UNITARIO', 1, 0, 'C', 1);
$pdf->Cell(23, 8, 'CANTIDAD', 1, 0, 'C', 1);
$pdf->Cell(25, 8, 'SUBTOTAL', 1, 1, 'C', 1);

//Ok, es hora de darle color a las celdas y color a las líneas
$pdf->SetFillColor(226, 226, 226); // color de fondo rgba
//$pdf->SetDrawColor(61, 61, 61); // color de la linea

$pdf->SetFont('Courier', '', 7); //tipo de letra para las celdas
//El ancho de las celdas
$pdf->SetWidths(array(10, 130, 20, 25, 25, 23, 25));
$pdf->SetAligns(array('C', 'L', 'C', 'C', 'C', 'C', 'C'));
$total = 0;
$total_articulos = 0;
for ($i = 0; $i < $numfilas; $i++) {
    $fila = $datos->fetch_array();
    $pdf->Row(array(
        $i + 1, utf8_decode($fila['descripcion']), utf8_decode($fila['factor']),
        utf8_decode($fila['contenido']), '$' . $fila['precio_unitario'], $fila['cantidad'], '$' . $fila['sub_total']
    ), 10);
    $total = $total + $fila['sub_total'];
    $total_articulos = $total_articulos + $fila['cantidad'];
}

/* --------------------------------- AQUÍ VA EL TOTAL -------------------------------------  */
//cell (ancho, largo, contenido, borde?, salto de linea)
$pdf->SetFont('Arial', 'B', 12);
//$pdf->Cell(246,15,'Cantidad de articulos: '. $total_articulos,0,0,'R');
$pdf->Cell(255, 15, 'TOTAL A PAGAR: $' . number_format($total, 2), 0, 1, 'R', 0);
/* --------------------------------- IMPORTE CON LETRA ------------------------------------  */
$formatter = new NumeroALetras();
$formatter->conector = 'Y';
$numero = $total;
$pdf->SetFont('Arial', '', 11);
//Cell(ancho, Alto, texto, borde, salto de linea, alineacion de texto)
$pdf->Cell(43, 0, 'IMPORTE CON LETRA: ', 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(80, 0, utf8_decode($formatter->toMoney($numero, 2, 'PESOS', 'CENTAVOS')) . ' (M.N. 00/100)',  0, 0, 'L');
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(15, 8, 'NOTA:', 0, 0, 'L', 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(90, 8, 'TODOS LOS PRECIOS YA INCLUYEN IVA', 0, 0, 'L');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(80, 0, utf8_decode('PERIODO DE VIGENCIA DE LA COTIZACIÓN: '), 0, 1, 'L', 0);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(100, 0, utf8_decode('15 DÍAS'), 0, 0, 'R', 0);

/* ----------------------------------------------------------------------------------------  */
$fecha = date("dmY_his");
$pdf->Output('COTIZACION_' . $fecha . '.pdf', 'I');
