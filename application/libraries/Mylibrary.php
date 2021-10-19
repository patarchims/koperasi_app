<?php
date_default_timezone_set('Asia/Jakarta');

class Mylibrary{
	function Size($path){
	    $bytes = sprintf('%u', filesize($path));
		    if ($bytes > 0){
		        $unit = intval(log($bytes, 1024));
		        $units = array('B', 'KB', 'MB', 'GB');

		        if (array_key_exists($unit, $units) === true){
		            return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
		        }
		    }
	    return $bytes;
	}
	
	
	
	

	function seo_title($s) {
		$s=trim($s);
	    $c = array (' ');
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+','–');
	    $s = str_replace($d, '', $s); // Hilangkan karakter yang telah disebutkan di array $d
	    $s = strtolower(str_replace($c, '-', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
	    return $s;
	}

	function kdauto($tabel, $inisial) {
		$struktur = mysql_query("SELECT * FROM $tabel");
		$field = mysql_field_name($struktur,0);
		$panjang = mysql_field_len($struktur,0);
		
		$qry = mysql_query("SELECT max(".$field.") FROM ".$tabel);
		$row = mysql_fetch_array($qry);
		if ($row[0]=="") {
			$angka=0;
		}
		else {
			$angka = substr($row[0], strlen($inisial));
		}
		
		$angka++;
		$angka =strval($angka);
		$tmp ="";
		for ($i=1; $i <= ($panjang-strlen($inisial)-strlen($angka)); $i++) {
				$tmp=$tmp."0";
		}
		return $inisial.$tmp.$angka;
	}

	function autolink($str){
	  $str = eregi_replace("([[:space:]])((f|ht)tps?:\/\/[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_.;-]+)", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $str); //http
	  $str = eregi_replace("([[:space:]])(www\.[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_.;-]+)", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $str); // www.
	  $str = eregi_replace("([[:space:]])([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})","\\1<a href=\"mailto:\\2\">\\2</a>", $str); // mail
	  $str = eregi_replace("^((f|ht)tp:\/\/[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_.;-]+)", "<a href=\"\\1\" target=\"_blank\">\\1</a>", $str); //http
	  $str = eregi_replace("^(www\.[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_.;-]+)", "<a href=\"http://\\1\" target=\"_blank\">\\1</a>", $str); // www.
	  $str = eregi_replace("^([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})","<a href=\"mailto:\\1\">\\1</a>", $str); // mail
	  return $str;
	}

	function anti_injection($data){
	  $filter = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
	  return $filter;
	}

	function greeting() {
		//mengatur zona waktu
		  date_default_timezone_set("Asia/Jakarta");
		//variables 
		$welcome_string="Welcome!"; 
		$numeric_date=date("G"); 
		 
		//kondisioal untuk menampilkan ucapan menurut waktu/jam 
		if($numeric_date>=0&&$numeric_date<=11) 
		$welcome_string="Selamat pagi!"; 
		else if($numeric_date>=12&&$numeric_date<=14) 
		$welcome_string="Selamat siang!";
		else if($numeric_date>=15&&$numeric_date<=17) 
		$welcome_string="Selamat sore!"; 
		else if($numeric_date>=18&&$numeric_date<=23) 
		$welcome_string="Selamat malam!"; 
		 
		echo "$welcome_string"; 
	}

	function rupiah($angka){
	  $rupiah=number_format($angka,0,',','.');
	  return $rupiah;
	}

	function getBulan($bln){
			switch ($bln){
					case 1: 
						return "Jan";
						break;
					case 2:
						return "Feb";
						break;
					case 3:
						return "Mar";
						break;
					case 4:
						return "Apr";
						break;
					case 5:
						return "Mei";
						break;
					case 6:
						return "Jun";
						break;
					case 7:
						return "Jul";
						break;
					case 8:
						return "Agu";
						break;
					case 9:
						return "Sep";
						break;
					case 10:
						return "Okt";
						break;
					case 11:
						return "Nov";
						break;
					case 12:
						return "Des";
						break;
			}
	}

	function tgl_indo($tgl){
		$tanggal = substr($tgl,8,2);
		$bulan = $this->getBulan(substr($tgl,5,2));
		$tahun = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;		 
	}	

	function tgl_indoo($tgl){
		$tanggal = substr($tgl,8,2);
		$bulan = $this->getBulan(substr($tgl,5,2));
		$tahun = substr($tgl,0,4);
		return $tanggal.'/'.$bulan;		 
	}
}







function phpmu($s) {
    $c = array (' ');
    $d = array ('&amp;','amp;','nbsp;','&nbsp;','-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+','–');
    $s = str_replace($d, '', $s); // Hilangkan karakter yang telah disebutkan di array $d
    $s = strtolower(str_replace($c, ' ', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
    return $s;
}


function randomSalt($len = 8) {
	$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789`~!@#$%^&*()-=_+';
	$l = strlen($chars) - 1;
	$str = '';
	for ($i = 0; $i < $len; $i++) 
	{
		$str .= $chars[rand(0, $l)];
 	}
	return $str;
}

function token($len = 64) {
	$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	$l = strlen($chars) - 1;
	$str = '';
	for ($i = 0; $i < $len; $i++) 
	{
		$str .= $chars[rand(0, $l)];
 	}
	return $str;
}

function create_hash($string, $salt, $hash_method = 'sha1') {
        // generate random salt
        
	if (function_exists('hash') && in_array($hash_method, hash_algos())) {
		return hash($hash_method, $salt . $string);
	}
	return sha1($salt . $string);
}

/**
 * @param string $pass The user submitted password
 * @param string $hashed_pass The hashed password pulled from the database
 * @param string $salt The salt pulled from the database
 * @param string $hash_method The hashing method used to generate the hashed password
 */
function validateLogin($pass, $hashed_pass, $salt, $hash_method = 'sha1') {
  if (function_exists('hash') && in_array($hash_method, hash_algos())) {
    return ($hashed_pass === hash($hash_method, $salt . $pass));
  }
  return ($hashed_pass === sha1($salt . $pass));
}