<?php

/*********************************************************************
 * exFPDF  extend FPDF v1.81                                                    *
 *                                                                    *
 * Version: 2.2                                                       *
 * Date:    12-10-2017                                                *
 * Author:  Dan Machado                                               *
 * Require  FPDF v1.81, formatedstring v1.0                                                *
 **********************************************************************/
require('fpdf.php');
require('formatedstring.php');
require('easyTable.php');
class ST extends FPDF
{
   protected $wLine; // Maximum width of the line
   protected $hLine; // Height of the line
   protected $Text; // Text to display
   protected $border;
   protected $align; // Justification of the text
   protected $fill;
   protected $Padding;
   protected $lPadding;
   protected $tPadding;
   protected $bPadding;
   protected $rPadding;
   protected $TagStyle; // Style for each tag
   protected $Indent;
   protected $Space; // Minimum space between words
   protected $PileStyle;
   protected $Line2Print; // Line to display
   protected $NextLineBegin; // Buffer between lines 
   protected $TagName;
   protected $Delta; // Maximum width minus width
   protected $StringLength;
   protected $LineLength;
   protected $wTextLine; // Width minus paddings
   protected $nbSpace; // Number of spaces in the line
   protected $Xini; // Initial position
   protected $href; // Current URL
   protected $TagHref; // URL for a cell
   var $angle = 0;
   function Header()
   {
      $this->SetFont('Arial', 'B', 50);
      $this->SetTextColor(255, 192, 203);
      $this->RotatedText(60, 120, 'D U P L I K A T', 45);
   }

   function Footer()
   {
   }

   function RotatedText($x, $y, $txt, $angle)
   {
      //Text rotated around its origin
      $this->Rotate($angle, $x, $y);
      $this->Text($x, $y, $txt);
      $this->Rotate(0);
   }

   function Rotate($angle, $x = -1, $y = -1)
   {
      if ($x == -1)
         $x = $this->x;
      if ($y == -1)
         $y = $this->y;
      if ($this->angle != 0)
         $this->_out('Q');
      $this->angle = $angle;
      if ($angle != 0) {
         $angle *= M_PI / 180;
         $c = cos($angle);
         $s = sin($angle);
         $cx = $x * $this->k;
         $cy = ($this->h - $y) * $this->k;
         $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
      }
   }

   function _endpage()
   {
      if ($this->angle != 0) {
         $this->angle = 0;
         $this->_out('Q');
      }
      parent::_endpage();
   }

   public function PageBreak()
   {
      return $this->PageBreakTrigger;
   }

   public function current_font($c)
   {
      if ($c == 'family') {
         return $this->FontFamily;
      } elseif ($c == 'style') {
         return $this->FontStyle;
      } elseif ($c == 'size') {
         return $this->FontSizePt;
      }
   }

   public function get_color($c)
   {
      if ($c == 'fill') {
         return $this->FillColor;
      } elseif ($c == 'text') {
         return $this->TextColor;
      }
   }

   public function get_page_width()
   {
      return $this->w;
   }

   public function get_margin($c)
   {
      if ($c == 'l') {
         return $this->lMargin;
      } elseif ($c == 'r') {
         return $this->rMargin;
      } elseif ($c == 't') {
         return $this->tMargin;
      }
   }

   public function get_linewidth()
   {
      return $this->LineWidth;
   }

   public function get_orientation()
   {
      return $this->CurOrientation;
   }
   static private $hex = array(
      '0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9,
      'A' => 10, 'B' => 11, 'C' => 12, 'D' => 13, 'E' => 14, 'F' => 15
   );

   public function is_rgb($str)
   {
      $a = true;
      $tmp = explode(',', trim($str, ','));
      foreach ($tmp as $color) {
         if (!is_numeric($color) || $color < 0 || $color > 255) {
            $a = false;
            break;
         }
      }
      return $a;
   }

   public function is_hex($str)
   {
      $a = true;
      $str = strtoupper($str);
      $n = strlen($str);
      if (($n == 7 || $n == 4) && $str[0] == '#') {
         for ($i = 1; $i < $n; $i++) {
            if (!isset(self::$hex[$str[$i]])) {
               $a = false;
               break;
            }
         }
      } else {
         $a = false;
      }
      return $a;
   }

   public function hextodec($str)
   {
      $result = array();
      $str = strtoupper(substr($str, 1));
      $n = strlen($str);
      for ($i = 0; $i < 3; $i++) {
         if ($n == 6) {
            $result[$i] = self::$hex[$str[2 * $i]] * 16 + self::$hex[$str[2 * $i + 1]];
         } else {
            $result[$i] = self::$hex[$str[$i]] * 16 + self::$hex[$str[$i]];
         }
      }
      return $result;
   }
   static private $options = array('F' => '', 'T' => '', 'D' => '');

   public function resetColor($str, $p = 'F')
   {
      if (isset(self::$options[$p]) && self::$options[$p] != $str) {
         self::$options[$p] = $str;
         $array = array();
         if ($this->is_hex($str)) {
            $array = $this->hextodec($str);
         } elseif ($this->is_rgb($str)) {
            $array = explode(',', trim($str, ','));
            for ($i = 0; $i < 3; $i++) {
               if (!isset($array[$i])) {
                  $array[$i] = 0;
               }
            }
         } else {
            $array = array(null, null, null);
            $i = 0;
            $tmp = explode(' ', $str);
            foreach ($tmp as $c) {
               if (is_numeric($c)) {
                  $array[$i] = $c * 256;
                  $i++;
               }
            }
         }
         if ($p == 'T') {
            $this->SetTextColor($array[0], $array[1], $array[2]);
         } elseif ($p == 'D') {
            $this->SetDrawColor($array[0], $array[1], $array[2]);
         } elseif ($p == 'F') {
            $this->SetFillColor($array[0], $array[1], $array[2]);
         }
      }
   }
   static private $font_def = '';

   public function resetFont($font_family, $font_style, $font_size)
   {
      if (self::$font_def != $font_family . '-' . $font_style . '-' . $font_size) {
         self::$font_def = $font_family . '-' . $font_style . '-' . $font_size;
         $this->SetFont($font_family, $font_style, $font_size);
      }
   }

   public function resetStaticData()
   {
      self::$font_def = '';
      self::$options = array('F' => '', 'T' => '', 'D' => '');
   }
   /***********************************************************************
    *
    * Based on FPDF method SetFont
    *
    ************************************************************************/

   private function &FontData($family, $style, $size)
   {
      if ($family == '')
         $family = $this->FontFamily;
      else
         $family = strtolower($family);
      $style = strtoupper($style);
      if (strpos($style, 'U') !== false) {
         $this->underline = true;
         $style = str_replace('U', '', $style);
      }
      if ($style == 'IB')
         $style = 'BI';
      $fontkey = $family . $style;
      if (!isset($this->fonts[$fontkey])) {
         if ($family == 'arial')
            $family = 'helvetica';
         if (in_array($family, $this->CoreFonts)) {
            if ($family == 'symbol' || $family == 'zapfdingbats')
               $style = '';
            $fontkey = $family . $style;
            if (!isset($this->fonts[$fontkey]))
               $this->AddFont($family, $style);
         } else
            $this->Error('Undefined font: ' . $family . ' ' . $style);
      }
      $result['FontSize'] = $size / $this->k;
      $result['CurrentFont'] = &$this->fonts[$fontkey];
      return $result;
   }


   private function setLines(&$fstring, $p, $q)
   {
      $parced_str = &$fstring->parced_str;
      $lines = &$fstring->lines;
      $linesmap = &$fstring->linesmap;
      $cfty = $fstring->get_current_style($p);
      $ffs = $cfty['font-family'] . $cfty['style'];
      if (!isset($fstring->used_fonts[$ffs])) {
         $fstring->used_fonts[$ffs] = &$this->FontData($cfty['font-family'], $cfty['style'], $cfty['font-size']);
      }
      $cw = &$fstring->used_fonts[$ffs]['CurrentFont']['cw'];
      $wmax = $fstring->width * 1000 * $this->k;
      $j = count($lines) - 1;
      $k = strlen($lines[$j]);
      if (!isset($linesmap[$j][0])) {
         $linesmap[$j] = array($p, $p, 0);
      }
      $sl = $cw[' '] * $cfty['font-size'];
      $x = $a = $linesmap[$j][2];
      if ($k > 0) {
         $x += $sl;
         $lines[$j] .= ' ';
         $linesmap[$j][2] += $sl;
      }
      $u = $p;
      $t = '';
      $l = $p + $q;
      $ftmp = '';
      for ($i = $p; $i < $l; $i++) {
         if ($ftmp != $ffs) {
            $cfty = $fstring->get_current_style($i);
            $ffs = $cfty['font-family'] . $cfty['style'];
            if (!isset($fstring->used_fonts[$ffs])) {
               $fstring->used_fonts[$ffs] = &$this->FontData($cfty['font-family'], $cfty['style'], $cfty['font-size']);
            }
            $cw = &$fstring->used_fonts[$ffs]['CurrentFont']['cw'];
            $ftmp = $ffs;
         }
         $x += $cw[$parced_str[$i]] * $cfty['font-size'];
         if ($x > $wmax) {
            if ($a > 0) {
               $t = substr($parced_str, $p, $i - $p);
               $lines[$j] = substr($lines[$j], 0, $k);
               $linesmap[$j][1] = $p - 1;
               $linesmap[$j][2] = $a;
               $x -= ($a + $sl);
               $a = 0;
               $u = $p;
            } else {
               $x = $cw[$parced_str[$i]] * $cfty['font-size'];
               $t = '';
               $u = $i;
            }
            $j++;
            $lines[$j] = $t;
            $linesmap[$j] = array();
            $linesmap[$j][0] = $u;
            $linesmap[$j][2] = 0;
         }
         $lines[$j] .= $parced_str[$i];
         $linesmap[$j][1] = $i;
         $linesmap[$j][2] = $x;
      }
      return;
   }

   public function &extMultiCell($font_family, $font_style, $font_size, $font_color, $w, $txt)
   {
      $result = array();
      if ($w == 0) {
         return $result;
      }
      $this->current_font = array('font-family' => $font_family, 'style' => $font_style, 'font-size' => $font_size, 'font-color' => $font_color);
      $fstring = new formatedString($txt, $w, $this->current_font);
      $word = '';
      $p = 0;
      $i = 0;
      $n = strlen($fstring->parced_str);
      while ($i < $n) {
         $word .= $fstring->parced_str[$i];
         if ($fstring->parced_str[$i] == "\n" || $fstring->parced_str[$i] == ' ' || $i == $n - 1) {
            $word = trim($word);
            $this->setLines($fstring, $p, strlen($word));
            $p = $i + 1;
            $word = '';
            if ($fstring->parced_str[$i] == "\n" && $i < $n - 1) {
               $z = 0;
               $j = count($fstring->lines);
               $fstring->lines[$j] = '';
               $fstring->linesmap[$j] = array();
            }
         }
         $i++;
      }
      if ($n == 0) {
         return $result;
      }
      $n = count($fstring->lines);
      for ($i = 0; $i < $n; $i++) {
         $result[$i] = $fstring->break_by_style($i);
      }
      return $result;
   }

   private function GetMixStringWidth($line)
   {
      $w = 0;
      foreach ($line['chunks'] as $i => $chunk) {
         $t = 0;
         $cf = &$this->FontData($line['style'][$i]['font-family'], $line['style'][$i]['style'], $line['style'][$i]['font-size']);
         $cw = &$cf['CurrentFont']['cw'];
         $s = implode('', explode(' ', $chunk));
         $l = strlen($s);
         for ($j = 0; $j < $l; $j++) {
            $t += $cw[$s[$j]];
         }
         $w += $t * $line['style'][$i]['font-size'];
      }
      return $w;
   }

   public function CellBlock($w, $lh, &$lines, $align = 'J')
   {
      if ($w == 0) {
         return;
      }
      $ctmp = '';
      $ftmp = '';
      foreach ($lines as $i => $line) {
         $k = $this->k;
         if ($this->y + $lh * $line['height'] > $this->PageBreakTrigger) {
            break;
         }
         $dx = 0;
         $dw = 0;
         if ($line['width'] != 0) {
            if ($align == 'R') {
               $dx = $w - $line['width'] / ($this->k * 1000);
            } elseif ($align == 'C') {
               $dx = ($w - $line['width'] / ($this->k * 1000)) / 2;
            }
            if ($align == 'J') {
               $tmp = explode(' ', implode('', $line['chunks']));
               $ns = count($tmp);
               if ($ns > 1) {
                  $sx = implode('', $tmp);
                  $delta = $this->GetMixStringWidth($line) / ($this->k * 1000);
                  $dw = ($w - $delta) * (1 / ($ns - 1));
               }
            }
         }
         $xx = $this->x + $dx;
         foreach ($line['chunks'] as $tj => $txt) {
            $this->resetFont($line['style'][$tj]['font-family'], $line['style'][$tj]['style'], $line['style'][$tj]['font-size']);
            $this->resetColor($line['style'][$tj]['font-color'], 'T');
            $y = $this->y + 0.5 * $lh * $line['height'] + 0.3 * $line['height'] / $this->k;
            if ($dw) {
               $tmp = explode(' ', $txt);
               foreach ($tmp as $e => $tt) {
                  if ($e > 0) {
                     $xx += $dw;
                     if ($tt == '') {
                        continue;
                     }
                  }
                  $this->Text($xx, $y, $tt);
                  if ($line['style'][$tj]['href']) {
                     $yr = $this->y + 0.5 * ($lh * $line['height'] - $line['height'] / $this->k);
                     $this->Link($xx, $yr, $this->GetStringWidth($txt), $line['height'] / $this->k, $line['style'][$tj]['href']);
                  }
                  $xx += $this->GetStringWidth($tt);
               }
            } else {
               $this->Text($xx, $y, $txt);
               if ($line['style'][$tj]['href']) {
                  $yr = $this->y + 0.5 * ($lh * $line['height'] - $line['height'] / $this->k);
                  $this->Link($xx, $yr, $this->GetStringWidth($txt), $line['height'] / $this->k, $line['style'][$tj]['href']);
               }
               $xx += $this->GetStringWidth($txt);
            }
         }
         unset($lines[$i]);
         $this->y += $lh * $line['height'];
      }
   }

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

   function Row($data)
   {
      //Calculate the height of the row
      $nb = 0;
      for ($i = 0; $i < count($data); $i++)
         $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
      $h = 5 * $nb;
      //Issue a page break first if needed
      $this->CheckPageBreak($h);
      //Draw the cells of the row
      for ($i = 0; $i < count($data); $i++) {
         $w = $this->widths[$i];

         $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'J';

         //Save the current position
         $x = $this->GetX();
         $y = $this->GetY();
         //Draw the border
         $this->Rect($x, $y, 0, 0);
         //Print the text
         $this->MultiCell($w, 5, $data[$i], 0, $a);
         //Put the position to the right of the cell
         $this->SetXY($x + $w, $y);
      }
      //Go to the next line
      $this->Ln($h);
   }

   function RowNoLine($data)
   {
      //Calculate the height of the row
      $nb = 0;
      for ($i = 0; $i < count($data); $i++)
         $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
      $h = 5 * $nb;
      //Issue a page break first if needed
      $this->CheckPageBreak($h);
      //Draw the cells of the row
      for ($i = 0; $i < count($data); $i++) {
         $w = $this->widths[$i];
         if ($i == 1) {
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
         } else {
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
         }
         //Save the current position
         $x = $this->GetX();
         $y = $this->GetY();
         //Draw the border
         $this->Rect($x, $y, 0, 0);
         //Print the text
         $this->MultiCell($w, 5, $data[$i], 0, $a);
         //Put the position to the right of the cell
         $this->SetXY($x + $w, $y);
      }
      //Go to the next line
      $this->Ln($h);
   }

   function CheckPageBreak($h)
   {
      //If the height h would cause an overflow, add a new page immediately
      if ($this->GetY() + $h > $this->PageBreakTrigger)
         $this->AddPage($this->CurOrientation);
   }

   function NbLines($w, $txt)
   {
      //Computes the number of lines a MultiCell of width w will take
      $cw = &$this->CurrentFont['cw'];
      if ($w == 0)
         $w = $this->w - $this->rMargin - $this->x;
      $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
      $s = str_replace("\r", '', $txt);
      $nb = strlen($s);
      if ($nb > 0 and $s[$nb - 1] == "\n")
         $nb--;
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
         if ($c == ' ')
            $sep = $i;
         $l += $cw[$c];
         if ($l > $wmax) {
            if ($sep == -1) {
               if ($i == $j)
                  $i++;
            } else
               $i = $sep + 1;
            $sep = -1;
            $j = $i;
            $l = 0;
            $nl++;
         } else
            $i++;
      }
      return $nl;
   }

   function WriteText($text)
   {
      $intPosIni = 0;
      $intPosFim = 0;
      if (strpos($text, '<') !== false && strpos($text, '[') !== false) {
         if (strpos($text, '<') < strpos($text, '[')) {
            $this->Write(5, substr($text, 0, strpos($text, '<')));
            $intPosIni = strpos($text, '<');
            $intPosFim = strpos($text, '>');
            $this->SetFont('', 'B');
            $this->Write(5, substr($text, $intPosIni + 1, $intPosFim - $intPosIni - 1));
            $this->SetFont('', '');
            $this->WriteText(substr($text, $intPosFim + 1, strlen($text)));
         } else {
            $this->Write(5, substr($text, 0, strpos($text, '[')));
            $intPosIni = strpos($text, '[');
            $intPosFim = strpos($text, ']');
            $w = $this->GetStringWidth('a') * ($intPosFim - $intPosIni - 1);
            $this->Cell($w, $this->FontSize + 0.75, substr($text, $intPosIni + 1, $intPosFim - $intPosIni - 1), 1, 0, 'J');
            $this->WriteText(substr($text, $intPosFim + 1, strlen($text)));
         }
      } else {
         if (strpos($text, '<') !== false) {
            $this->Write(5, substr($text, 0, strpos($text, '<')));
            $intPosIni = strpos($text, '<');
            $intPosFim = strpos($text, '>');
            $this->SetFont('', 'B');
            $this->WriteText(substr($text, $intPosIni + 1, $intPosFim - $intPosIni - 1));
            $this->SetFont('', '');
            $this->WriteText(substr($text, $intPosFim + 1, strlen($text)));
         } elseif (strpos($text, '[') !== false) {
            $this->Write(5, substr($text, 0, strpos($text, '[')));
            $intPosIni = strpos($text, '[');
            $intPosFim = strpos($text, ']');
            $w = $this->GetStringWidth('a') * ($intPosFim - $intPosIni - 1);
            $this->Cell($w, $this->FontSize + 0.75, substr($text, $intPosIni + 1, $intPosFim - $intPosIni - 1), 1, 0, '');
            $this->WriteText(substr($text, $intPosFim + 1, strlen($text)));
         } else {
            $this->Write(5, $text);
         }
      }
   }


   function WriteTag($w, $h, $txt, $border = 0, $align = "J", $fill = false, $padding = 0)
   {
      $this->wLine = $w;
      $this->hLine = $h;
      $this->Text = trim($txt);
      $this->Text = preg_replace("/\n|\r|\t/", "", $this->Text);
      $this->border = $border;
      $this->align = $align;
      $this->fill = $fill;
      $this->Padding = $padding;

      $this->Xini = $this->GetX();
      $this->href = "";
      $this->PileStyle = array();
      $this->TagHref = array();
      $this->LastLine = false;
      $this->NextLineBegin = array();

      $this->SetSpace();
      $this->Padding();
      $this->LineLength();
      $this->BorderTop();

      while ($this->Text != "") {
         $this->MakeLine();
         $this->PrintLine();
      }

      $this->BorderBottom();
   }


   function SetStyle($tag, $family, $style, $size, $color, $indent = -1)
   {
      $tag = trim($tag);
      $this->TagStyle[$tag]['family'] = trim($family);
      $this->TagStyle[$tag]['style'] = trim($style);
      $this->TagStyle[$tag]['size'] = trim($size);
      $this->TagStyle[$tag]['color'] = trim($color);
      $this->TagStyle[$tag]['indent'] = $indent;
   }


   // Private Functions

   function SetSpace() // Minimal space between words
   {
      $tag = $this->Parser($this->Text);
      $this->FindStyle($tag[2], 0);
      $this->DoStyle(0);
      $this->Space = $this->GetStringWidth(" ");
   }


   function Padding()
   {
      if (preg_match("/^.+,/", $this->Padding)) {
         $tab = explode(",", $this->Padding);
         $this->lPadding = $tab[0];
         $this->tPadding = $tab[1];
         if (isset($tab[2]))
            $this->bPadding = $tab[2];
         else
            $this->bPadding = $this->tPadding;
         if (isset($tab[3]))
            $this->rPadding = $tab[3];
         else
            $this->rPadding = $this->lPadding;
      } else {
         $this->lPadding = $this->Padding;
         $this->tPadding = $this->Padding;
         $this->bPadding = $this->Padding;
         $this->rPadding = $this->Padding;
      }
      if ($this->tPadding < $this->LineWidth)
         $this->tPadding = $this->LineWidth;
   }


   function LineLength()
   {
      if ($this->wLine == 0)
         $this->wLine = $this->w - $this->Xini - $this->rMargin;

      $this->wTextLine = $this->wLine - $this->lPadding - $this->rPadding;
   }


   function BorderTop()
   {
      $border = 0;
      if ($this->border == 1)
         $border = "TLR";
      $this->Cell($this->wLine, $this->tPadding, "", $border, 0, 'C', $this->fill);
      $y = $this->GetY() + $this->tPadding;
      $this->SetXY($this->Xini, $y);
   }


   function BorderBottom()
   {
      $border = 0;
      if ($this->border == 1)
         $border = "BLR";
      $this->Cell($this->wLine, $this->bPadding, "", $border, 0, 'C', $this->fill);
   }


   function DoStyle($tag) // Applies a style
   {
      $tag = trim($tag);
      $this->SetFont(
         $this->TagStyle[$tag]['family'],
         $this->TagStyle[$tag]['style'],
         $this->TagStyle[$tag]['size']
      );

      $tab = explode(",", $this->TagStyle[$tag]['color']);
      if (count($tab) == 1)
         $this->SetTextColor($tab[0]);
      else
         $this->SetTextColor($tab[0], $tab[1], $tab[2]);
   }


   function FindStyle($tag, $ind) // Inheritance from parent elements
   {
      $tag = trim($tag);

      // Family
      if ($this->TagStyle[$tag]['family'] != "")
         $family = $this->TagStyle[$tag]['family'];
      else {
         foreach ($this->PileStyle as $val) {
            $val = trim($val);
            if ($this->TagStyle[$val]['family'] != "") {
               $family = $this->TagStyle[$val]['family'];
               break;
            }
         }
      }

      // Style
      $style = "";
      $style1 = strtoupper($this->TagStyle[$tag]['style']);
      if ($style1 != "N") {
         $bold = false;
         $italic = false;
         $underline = false;
         foreach ($this->PileStyle as $val) {
            $val = trim($val);
            $style1 = strtoupper($this->TagStyle[$val]['style']);
            if ($style1 == "N")
               break;
            else {
               if (strpos($style1, "B") !== false)
                  $bold = true;
               if (strpos($style1, "I") !== false)
                  $italic = true;
               if (strpos($style1, "U") !== false)
                  $underline = true;
            }
         }
         if ($bold)
            $style .= "B";
         if ($italic)
            $style .= "I";
         if ($underline)
            $style .= "U";
      }

      // Size
      if ($this->TagStyle[$tag]['size'] != 0)
         $size = $this->TagStyle[$tag]['size'];
      else {
         foreach ($this->PileStyle as $val) {
            $val = trim($val);
            if ($this->TagStyle[$val]['size'] != 0) {
               $size = $this->TagStyle[$val]['size'];
               break;
            }
         }
      }

      // Color
      if ($this->TagStyle[$tag]['color'] != "")
         $color = $this->TagStyle[$tag]['color'];
      else {
         foreach ($this->PileStyle as $val) {
            $val = trim($val);
            if ($this->TagStyle[$val]['color'] != "") {
               $color = $this->TagStyle[$val]['color'];
               break;
            }
         }
      }

      // Result
      $this->TagStyle[$ind]['family'] = $family;
      $this->TagStyle[$ind]['style'] = $style;
      $this->TagStyle[$ind]['size'] = $size;
      $this->TagStyle[$ind]['color'] = $color;
      $this->TagStyle[$ind]['indent'] = $this->TagStyle[$tag]['indent'];
   }


   function Parser($text)
   {
      $tab = array();
      // Closing tag
      if (preg_match("|^(</([^>]+)>)|", $text, $regs)) {
         $tab[1] = "c";
         $tab[2] = trim($regs[2]);
      }
      // Opening tag
      else if (preg_match("|^(<([^>]+)>)|", $text, $regs)) {
         $regs[2] = preg_replace("/^a/", "a ", $regs[2]);
         $tab[1] = "o";
         $tab[2] = trim($regs[2]);

         // Presence of attributes
         if (preg_match("/(.+) (.+)='(.+)'/", $regs[2])) {
            $tab1 = preg_split("/ +/", $regs[2]);
            $tab[2] = trim($tab1[0]);
            foreach ($tab1 as $i => $couple) {
               if ($i > 0) {
                  $tab2 = explode("=", $couple);
                  $tab2[0] = trim($tab2[0]);
                  $tab2[1] = trim($tab2[1]);
                  $end = strlen($tab2[1]) - 2;
                  $tab[$tab2[0]] = substr($tab2[1], 1, $end);
               }
            }
         }
      }
      // Space
      else if (preg_match("/^( )/", $text, $regs)) {
         $tab[1] = "s";
         $tab[2] = ' ';
      }
      // Text
      else if (preg_match("/^([^< ]+)/", $text, $regs)) {
         $tab[1] = "t";
         $tab[2] = trim($regs[1]);
      }

      $begin = strlen($regs[1]);
      $end = strlen($text);
      $text = substr($text, $begin, $end);
      $tab[0] = $text;

      return $tab;
   }


   function MakeLine()
   {
      $this->Text .= " ";
      $this->LineLength = array();
      $this->TagHref = array();
      $Length = 0;
      $this->nbSpace = 0;

      $i = $this->BeginLine();
      $this->TagName = array();

      if ($i == 0) {
         $Length = $this->StringLength[0];
         $this->TagName[0] = 1;
         $this->TagHref[0] = $this->href;
      }

      while ($Length < $this->wTextLine) {
         $tab = $this->Parser($this->Text);
         $this->Text = $tab[0];
         if ($this->Text == "") {
            $this->LastLine = true;
            break;
         }

         if ($tab[1] == "o") {
            array_unshift($this->PileStyle, $tab[2]);
            $this->FindStyle($this->PileStyle[0], $i + 1);

            $this->DoStyle($i + 1);
            $this->TagName[$i + 1] = 1;
            if ($this->TagStyle[$tab[2]]['indent'] != -1) {
               $Length += $this->TagStyle[$tab[2]]['indent'];
               $this->Indent = $this->TagStyle[$tab[2]]['indent'];
            }
            if ($tab[2] == "a")
               $this->href = $tab['href'];
         }

         if ($tab[1] == "c") {
            array_shift($this->PileStyle);
            if (isset($this->PileStyle[0])) {
               $this->FindStyle($this->PileStyle[0], $i + 1);
               $this->DoStyle($i + 1);
            }
            $this->TagName[$i + 1] = 1;
            if ($this->TagStyle[$tab[2]]['indent'] != -1) {
               $this->LastLine = true;
               $this->Text = trim($this->Text);
               break;
            }
            if ($tab[2] == "a")
               $this->href = "";
         }

         if ($tab[1] == "s") {
            $i++;
            $Length += $this->Space;
            $this->Line2Print[$i] = "";
            if ($this->href != "")
               $this->TagHref[$i] = $this->href;
         }

         if ($tab[1] == "t") {
            $i++;
            $this->StringLength[$i] = $this->GetStringWidth($tab[2]);
            $Length += $this->StringLength[$i];
            $this->LineLength[$i] = $Length;
            $this->Line2Print[$i] = $tab[2];
            if ($this->href != "")
               $this->TagHref[$i] = $this->href;
         }
      }

      trim($this->Text);
      if ($Length > $this->wTextLine || $this->LastLine == true)
         $this->EndLine();
   }


   function BeginLine()
   {
      $this->Line2Print = array();
      $this->StringLength = array();

      if (isset($this->PileStyle[0])) {
         $this->FindStyle($this->PileStyle[0], 0);
         $this->DoStyle(0);
      }

      if (count($this->NextLineBegin) > 0) {
         $this->Line2Print[0] = $this->NextLineBegin['text'];
         $this->StringLength[0] = $this->NextLineBegin['length'];
         $this->NextLineBegin = array();
         $i = 0;
      } else {
         preg_match("/^(( *(<([^>]+)>)* *)*)(.*)/", $this->Text, $regs);
         $regs[1] = str_replace(" ", "", $regs[1]);
         $this->Text = $regs[1] . $regs[5];
         $i = -1;
      }

      return $i;
   }


   function EndLine()
   {
      if (end($this->Line2Print) != "" && $this->LastLine == false) {
         $this->NextLineBegin['text'] = array_pop($this->Line2Print);
         $this->NextLineBegin['length'] = end($this->StringLength);
         array_pop($this->LineLength);
      }

      while (end($this->Line2Print) === "")
         array_pop($this->Line2Print);

      $this->Delta = $this->wTextLine - end($this->LineLength);

      $this->nbSpace = 0;
      for ($i = 0; $i < count($this->Line2Print); $i++) {
         if ($this->Line2Print[$i] == "")
            $this->nbSpace++;
      }
   }


   function PrintLine()
   {
      $border = 0;
      if ($this->border == 1)
         $border = "LR";
      $this->Cell($this->wLine, $this->hLine, "", $border, 0, 'C', $this->fill);
      $y = $this->GetY();
      $this->SetXY($this->Xini + $this->lPadding, $y);

      if ($this->Indent != -1) {
         if ($this->Indent != 0)
            $this->Cell($this->Indent, $this->hLine);
         $this->Indent = -1;
      }

      $space = $this->LineAlign();
      $this->DoStyle(0);
      for ($i = 0; $i < count($this->Line2Print); $i++) {
         if (isset($this->TagName[$i]))
            $this->DoStyle($i);
         if (isset($this->TagHref[$i]))
            $href = $this->TagHref[$i];
         else
            $href = '';
         if ($this->Line2Print[$i] == "")
            $this->Cell($space, $this->hLine, "         ", 0, 0, 'C', false, $href);
         else
            $this->Cell($this->StringLength[$i], $this->hLine, $this->Line2Print[$i], 0, 0, 'C', false, $href);
      }

      $this->LineBreak();
      if ($this->LastLine && $this->Text != "")
         $this->EndParagraph();
      $this->LastLine = false;
   }


   function LineAlign()
   {
      $space = $this->Space;
      if ($this->align == "J") {
         if ($this->nbSpace != 0)
            $space = $this->Space + ($this->Delta / $this->nbSpace);
         if ($this->LastLine)
            $space = $this->Space;
      }

      if ($this->align == "R")
         $this->Cell($this->Delta, $this->hLine);

      if ($this->align == "C")
         $this->Cell($this->Delta / 2, $this->hLine);

      return $space;
   }


   function LineBreak()
   {
      $x = $this->Xini;
      $y = $this->GetY() + $this->hLine;
      $this->SetXY($x, $y);
   }


   function EndParagraph()
   {
      $border = 0;
      if ($this->border == 1)
         $border = "LR";
      $this->Cell($this->wLine, $this->hLine / 2, "", $border, 0, 'C', $this->fill);
      $x = $this->Xini;
      $y = $this->GetY() + $this->hLine / 2;
      $this->SetXY($x, $y);
   }
}
