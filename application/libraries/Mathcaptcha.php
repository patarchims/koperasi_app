<?php

class Mathcaptcha
{
    private $bil1;
    private $bil2;
    private $operator;
    private $img;

    function initial()
    {
        $listoperator = array('+', 'x');
        $this->bil1 = rand(1, 9);
        $this->bil2 = rand(1, 9);
        $this->operator = $listoperator[array_rand($listoperator)];
    }

    function generatekode()
    {
        $this->initial();

        if ($this->operator == '+') $hasil = $this->bil1 + $this->bil2;
        else if ($this->operator == '-') $hasil = $this->bil1 - $this->bil2;
        else if ($this->operator == 'x') $hasil = $this->bil1 * $this->bil2;
        $_SESSION['kode'] = $hasil;
    }



   function showcaptcha()
    {
    
        return "Hasil dari ".$this->bil1." ".$this->operator." ".$this->bil2." = ?";

       
    }	

 

    function resultcaptcha()
    {
        return $_SESSION['kode'];
    }

}
?>