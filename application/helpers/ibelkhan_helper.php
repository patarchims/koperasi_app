<?php
function cetak($str)
{
  return strip_tags(htmlentities($str, ENT_QUOTES, 'UTF-8'));
}
function rupiah($angka)
{
  if ($angka == 0) {
    $hasil = '-';
  } else if ($angka < 0) {
    $hasil = "(" . number_format(abs($angka), 0, ',', '.') . ")";
  } else {
    $hasil = number_format($angka, 0, ',', '.');
  }
  return $hasil;
}
function angka($angka, $dec = 2)
{
  $rupiah = number_format($angka, $dec, ',', '.');
  return $rupiah;
}

function zeropad($bilangan, $pad = 2)
{

  $fzeropadded = sprintf("%0" . $pad . "d", $bilangan);
  return $fzeropadded;
}

function usia($date1, $date2 = '')
{
  if ($date2 == '') {
    $date2 = date('Y-m-d');
  }
  $awal  = date_create($date1);
  $akhir = date_create($date2); // waktu sekarang
  $diff  = date_diff($awal, $akhir);
  return $diff->y . ' Tahun ' . $diff->m . ' Bulan ' . $diff->d . ' Hari';
}

function ultah($date1, $date2 = '')
{
  if ($date2 == '') {
    $date2 = date('Y-m-d');
  }
  $awal  = date_create($date1);
  $akhir = date_create($date2); // waktu sekarang
  $diff  = date_diff($awal, $akhir);
  return $diff->y . ' Tahun ';
}

function gambar($path, $gambar)
{

  if ($gambar == '') {
    return base_url('assets/img/no-foto.jpg');
  } else {
    return base_url('assets/img/' . $path . '/' . $gambar);
  }
}

function gambarAws($gambar)
{

  if ($gambar == '') {
    return base_url('assets/img/no-foto.jpg');
  } else {
    return $gambar;
  }
}

function gambarUser($gambar)
{

  if ($gambar == '') {
    return base_url('assets/img/no-foto.jpg');
  } else {
    return base_url('assets/img/user/' . $gambar);
  }
}



function masaKerja($date1, $date2 = '')
{
  if ($date2 == '') {
    $date2 = date('Y-m-d');
  }
  $awal  = date_create($date1);
  $akhir = date_create($date2); // waktu sekarang
  $diff  = date_diff($awal, $akhir);
  return $diff->y . " Tahun, " . $diff->m . " Bulan, " . $diff->d . " Hari ";
}



function namahari($tanggal)
{


  $tgl = substr($tanggal, 8, 2);
  $bln = substr($tanggal, 5, 2);
  $thn = substr($tanggal, 0, 4);

  $info = date('w', mktime(0, 0, 0, $bln, $tgl, $thn));

  switch ($info) {
    case '0':
      return "Minggu";
      break;
    case '1':
      return "Senin";
      break;
    case '2':
      return "Selasa";
      break;
    case '3':
      return "Rabu";
      break;
    case '4':
      return "Kamis";
      break;
    case '5':
      return "Jumat";
      break;
    case '6':
      return "Sabtu";
      break;
  };
}

function tglAkhirBulan($thn, $bln)
{
  $bulan[1] = 31;
  $bulan[2] = 28;
  $bulan[3] = 31;
  $bulan[4] = 30;
  $bulan[5] = 31;
  $bulan[6] = 30;
  $bulan[7] = 31;
  $bulan[8] = 31;
  $bulan[9] = 30;
  $bulan[10] = 31;
  $bulan[11] = 30;
  $bulan[12] = 31;

  if ($thn % 4 == 0) {
    $bulan[2] = 29;
  }
  return $bulan[$bln];
}

function GenerateCode()
{
  $possible = '123456789';
  $operator = '+';
  $a = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
  $b = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
  $opr = substr($operator, mt_rand(0, strlen($operator) - 1), 1);
  if ($opr == '+') {
    $res = $a + $b;
  }

  $code['res']  = $res;
  $code['text'] = $a . ' ' . $opr . ' ' . $b . ' = ?';
  return $code;
}

function kekata($x)
{
  $x = abs($x);
  $angka = array(
    "", "satu", "dua", "tiga", "empat", "lima",
    "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"
  );
  $temp = "";
  if ($x < 12) {
    $temp = " " . $angka[$x];
  } else if ($x < 20) {
    $temp = kekata($x - 10) . " belas";
  } else if ($x < 100) {
    $temp = kekata($x / 10) . " puluh" . kekata($x % 10);
  } else if ($x < 200) {
    $temp = " seratus" . kekata($x - 100);
  } else if ($x < 1000) {
    $temp = kekata($x / 100) . " ratus" . kekata($x % 100);
  } else if ($x < 2000) {
    $temp = " seribu" . kekata($x - 1000);
  } else if ($x < 1000000) {
    $temp = kekata($x / 1000) . " ribu" . kekata($x % 1000);
  } else if ($x < 1000000000) {
    $temp = kekata($x / 1000000) . " juta" . kekata($x % 1000000);
  } else if ($x < 1000000000000) {
    $temp = kekata($x / 1000000000) . " milyar" . kekata(fmod($x, 1000000000));
  } else if ($x < 1000000000000000) {
    $temp = kekata($x / 1000000000000) . " trilyun" . kekata(fmod($x, 1000000000000));
  }
  return $temp;
}


function terbilang($x, $style = 4)
{
  if ($x < 0) {
    $hasil = "minus " . trim(kekata($x));
  } else {
    $hasil = trim(kekata($x));
  }
  switch ($style) {
    case 1:
      $hasil = strtoupper($hasil);
      break;
    case 2:
      $hasil = strtolower($hasil);
      break;
    case 3:
      $hasil = ucwords($hasil);
      break;
    default:
      $hasil = ucfirst($hasil);
      break;
  }
  return $hasil;
}

function cetak_meta($str, $mulai, $selesai)
{
  return strip_tags(html_entity_decode(substr(str_replace('"', '', $str), $mulai, $selesai), ENT_COMPAT, 'UTF-8'));
}

function sensor($teks)
{
  $ci = &get_instance();
  $query = $ci->db->query("SELECT * FROM katajelek");
  foreach ($query->result_array() as $r) {
    $teks = str_replace($r['kata'], $r['ganti'], $teks);
  }
  return $teks;
}

function getSearchTermToBold($text, $words)
{
  preg_match_all('~[A-Za-z0-9_äöüÄÖÜ]+~', $words, $m);
  if (!$m)
    return $text;
  $re = '~(' . implode('|', $m[0]) . ')~i';
  return preg_replace($re, '<b style="color:red">$0</b>', $text);
}

function tgl_bulan($tgl = '')
{
  if ($tgl == '') {
    return '';
  } else {
    $tanggal = substr($tgl, 8, 2);
    $bulan = substr($tgl, 5, 2);
    return $tanggal . '/' . $bulan;
  }
}

function tgl_indo($tgl)
{
  $tanggal = substr($tgl, 8, 2);
  $bulan = get_bulan(substr($tgl, 5, 2));
  $tahun = substr($tgl, 0, 4);
  return $tanggal . ' ' . $bulan . ' ' . $tahun;
}

function tgl_indo_dua($tgl1, $tgl2)
{
  $tanggal1 = substr($tgl1, 8, 2);
  $bulan1 = get_bulan(substr($tgl1, 5, 2));
  $tahun1 = substr($tgl1, 0, 4);

  $tanggal2 = substr($tgl2, 8, 2);
  $bulan2 = get_bulan(substr($tgl2, 5, 2));
  $tahun2 = substr($tgl2, 0, 4);

  if ($tgl1 == $tgl2) {
    return $tanggal1 . ' ' . $bulan1 . ' ' . $tahun1;
  } else {
    if ($tahun1 == $tahun2) {
      if ($bulan1 == $bulan2) {
        return $tanggal1 . ' s/d ' . $tanggal2 . ' ' . $bulan1 . ' ' . $tahun1;
      } else {
        return $tanggal1 . ' ' . $bulan1 . ' s/d ' . $tanggal2 . ' ' . $bulan2 . ' ' . $tahun1;
      }
    } else {
      return $tanggal1 . ' ' . $bulan1 . ' ' . $tahun2 . ' s/d ' . $tanggal2 . ' ' . $bulan2 . ' ' . $tahun2;
    }
  }
}

function get_bulan_dua($bulan1, $bulan2)
{


  if ($bulan1 == $bulan2) {
    return get_bulan($bulan1);
  } else {
    return get_bulan($bulan1) . ' s/d ' . get_bulan($bulan2);
  }
}

function tgl_waktu_full($waktu)
{
  $pecah = explode(" ", $waktu);
  $waktu = $pecah[1];
  $tgl = $pecah[0];
  return tgl_indo($tgl) . ' ' . $waktu . ' WIB';
}

function getTahun($tgl)
{

  $tahun = substr($tgl, 0, 4);
  return $tahun;
}

function tgl_simpan($tgl)
{
  $tanggal = substr($tgl, 0, 2);
  $bulan = substr($tgl, 3, 2);
  $tahun = substr($tgl, 6, 4);
  return $tahun . '-' . $bulan . '-' . $tanggal;
}

function ganti_tgl($tgl)
{
  $tanggal = str_replace('-', '/', $tgl);
  return $tanggal;
}

function tgl_view($tgl)
{
  $tanggal = substr($tgl, 8, 2);
  $bulan = substr($tgl, 5, 2);
  $tahun = substr($tgl, 0, 4);
  return $tanggal . '/' . $bulan . '/' . $tahun;
}

function tgl_grafik($tgl)
{
  $tanggal = substr($tgl, 8, 2);
  $bulan = getBulan(substr($tgl, 5, 2));
  $tahun = substr($tgl, 0, 4);
  return $tanggal . '_' . $bulan;
}


function generateRandomString($length = 10)
{
  return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

function seo_title($s)
{
  $s = trim($s);
  $c = array(' ');
  $d = array('-', '/', '\\', ',', '.', '#', ':', ';', '\'', '"', '[', ']', '{', '}', ')', '(', '|', '`', '~', '!', '@', '%', '$', '^', '&', '*', '=', '?', '+', '–');
  $s = str_replace($d, '', $s); // Hilangkan karakter yang telah disebutkan di array $d
  $s = strtolower(str_replace($c, '-', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
  return $s;
}

function hilangkanspasi($s)
{
  $c = array(' ');
  $d = array('-', '/', '\\', ',', '.', '#', ':', ';', '\'', '"', '[', ']', '{', '}', ')', '(', '|', '`', '~', '!', '@', '%', '$', '^', '&', '*', '=', '?', '+', '–');
  $s = str_replace($d, '', $s); // Hilangkan karakter yang telah disebutkan di array $d
  $s = strtolower(str_replace($c, '', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
  return $s;
}

function hari_ini($w)
{
  $seminggu = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
  $hari_ini = $seminggu[$w];
  return $hari_ini;
}



function get_bulan($bln)
{
  switch ($bln) {
    case 1:
      return "Januari";
      break;
    case 2:
      return "Februari";
      break;
    case 3:
      return "Maret";
      break;
    case 4:
      return "April";
      break;
    case 5:
      return "Mei";
      break;
    case 6:
      return "Juni";
      break;
    case 7:
      return "Juli";
      break;
    case 8:
      return "Agustus";
      break;
    case 9:
      return "September";
      break;
    case 10:
      return "Oktober";
      break;
    case 11:
      return "November";
      break;
    case 12:
      return "Desember";
      break;
  }
}


function getBulan($bln)
{
  switch ($bln) {
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

function cek_terakhir($datetime, $full = false)
{
  $today = time();
  $createdday = strtotime($datetime);
  $datediff = abs($today - $createdday);
  $difftext = "";
  $years = floor($datediff / (365 * 60 * 60 * 24));
  $months = floor(($datediff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
  $days = floor(($datediff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
  $hours = floor($datediff / 3600);
  $minutes = floor($datediff / 60);
  $seconds = floor($datediff);
  //year checker  
  if ($difftext == "") {
    if ($years > 1)
      $difftext = $years . " Tahun";
    elseif ($years == 1)
      $difftext = $years . " Tahun";
  }
  //month checker  
  if ($difftext == "") {
    if ($months > 1)
      $difftext = $months . " Bulan";
    elseif ($months == 1)
      $difftext = $months . " Bulan";
  }
  //month checker  
  if ($difftext == "") {
    if ($days > 1)
      $difftext = $days . " Hari";
    elseif ($days == 1)
      $difftext = $days . " Hari";
  }
  //hour checker  
  if ($difftext == "") {
    if ($hours > 1)
      $difftext = $hours . " Jam";
    elseif ($hours == 1)
      $difftext = $hours . " Jam";
  }
  //minutes checker  
  if ($difftext == "") {
    if ($minutes > 1)
      $difftext = $minutes . " Menit";
    elseif ($minutes == 1)
      $difftext = $minutes . " Menit";
  }
  //seconds checker  
  if ($difftext == "") {
    if ($seconds > 1)
      $difftext = $seconds . " Detik";
    elseif ($seconds == 1)
      $difftext = $seconds . " Detik";
  }
  return $difftext;
}



function selisihBulan(\DateTime $date1, \DateTime $date2)
{
  $diff =  $date1->diff($date2);

  $months = $diff->y * 12 + $diff->m + $diff->d / 30;

  return (int) round($months);
}

function selisihTanggal($date1, $date2 = '')
{
  $tanggal_lahir  = strtotime($date1);
  if ($date2 == '') {
    $sekarang    = time();
  } else {
    $sekarang = strtotime($date1);
  }
  $diff   = $sekarang - $tanggal_lahir;
  $hari = floor($diff / (60 * 60 * 24));
  return $hari;
}


function opTahun($p)
{

  $opsi = '<option value="" >..::Pilih Tahun::..</option>';
  $awal = date('Y') - 80;
  $akhir = date('Y');
  for ($i = $akhir; $i >= $awal; $i--) {
    $cl = ($i == $p) ? 'selected' : '';
    $opsi .= '<option value="' . $i . '" ' . $cl . '>' . $i . '</option>';
  }
  return $opsi;
}



function opHari($p)
{

  $opsi = '<option value="" >..::Pilih Hari::..</option>';
  for ($i = 0; $i <= 6; $i++) {
    $cl = ($i == $p) ? 'selected' : '';
    $opsi .= '<option value="' . $i . '" ' . $cl . '>' . hari_ini($i) . '</option>';
  }
  return $opsi;
}


function opBulan($p)
{

  $opsi = '<option value="" >..::Pilih Bulan::..</option>';
  for ($i = 1; $i <= 12; $i++) {
    $cl = ($i == $p) ? 'selected' : '';
    $opsi .= '<option value="' . $i . '" ' . $cl . '>' . get_bulan($i) . '</option>';
  }
  return $opsi;
}

function opTanggal($p)
{

  $opsi = '<option value="" >..::Pilih Tanggal::..</option>';
  for ($i = 1; $i <= 31; $i++) {
    $cl = ($i == $p) ? 'selected' : '';
    $opsi .= '<option value="' . $i . '" ' . $cl . '>' . $i . '</option>';
  }
  return $opsi;
}


function getIP()
{
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
  //to check ip passed from proxy
  {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}



function getOS()
{

  $user_agent = $_SERVER['HTTP_USER_AGENT'];

  $os_platform  = "Unknown OS Platform";

  $os_array     = array(
    '/windows nt 10/i'      =>  'Windows 10',
    '/windows nt 6.3/i'     =>  'Windows 8.1',
    '/windows nt 6.2/i'     =>  'Windows 8',
    '/windows nt 6.1/i'     =>  'Windows 7',
    '/windows nt 6.0/i'     =>  'Windows Vista',
    '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
    '/windows nt 5.1/i'     =>  'Windows XP',
    '/windows xp/i'         =>  'Windows XP',
    '/windows nt 5.0/i'     =>  'Windows 2000',
    '/windows me/i'         =>  'Windows ME',
    '/win98/i'              =>  'Windows 98',
    '/win95/i'              =>  'Windows 95',
    '/win16/i'              =>  'Windows 3.11',
    '/macintosh|mac os x/i' =>  'Mac OS X',
    '/mac_powerpc/i'        =>  'Mac OS 9',
    '/linux/i'              =>  'Linux',
    '/ubuntu/i'             =>  'Ubuntu',
    '/iphone/i'             =>  'iPhone',
    '/ipod/i'               =>  'iPod',
    '/ipad/i'               =>  'iPad',
    '/android/i'            =>  'Android',
    '/blackberry/i'         =>  'BlackBerry',
    '/webos/i'              =>  'Mobile'
  );

  foreach ($os_array as $regex => $value)
    if (preg_match($regex, $user_agent))
      $os_platform = $value;

  return $os_platform;
}

function getBrowser()
{

  $user_agent = $_SERVER['HTTP_USER_AGENT'];

  $browser        = "Unknown Browser";

  $browser_array = array(
    '/msie/i'      => 'Internet Explorer',
    '/firefox/i'   => 'Firefox',
    '/safari/i'    => 'Safari',
    '/chrome/i'    => 'Chrome',
    '/edge/i'      => 'Edge',
    '/opera/i'     => 'Opera',
    '/netscape/i'  => 'Netscape',
    '/maxthon/i'   => 'Maxthon',
    '/konqueror/i' => 'Konqueror',
    '/mobile/i'    => 'Handheld Browser'
  );

  foreach ($browser_array as $regex => $value)
    if (preg_match($regex, $user_agent))
      $browser = $value;

  return $browser;
}

function getBrowserX()
{
  $u_agent = $_SERVER['HTTP_USER_AGENT'];
  $bname = 'Unknown';
  $platform = 'Unknown';
  $version = "";

  // First get the platform?
  if (preg_match('/linux/i', $u_agent)) {
    $platform = 'linux';
  } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
    $platform = 'mac';
  } elseif (preg_match('/windows|win32/i', $u_agent)) {
    $platform = 'windows';
  }

  // Next get the name of the useragent yes seperately and for good reason
  if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
    $bname = 'Internet Explorer';
    $ub = "MSIE";
  } elseif (preg_match('/Firefox/i', $u_agent)) {
    $bname = 'Mozilla Firefox';
    $ub = "Firefox";
  } elseif (preg_match('/Chrome/i', $u_agent)) {
    $bname = 'Google Chrome';
    $ub = "Chrome";
  } elseif (preg_match('/Safari/i', $u_agent)) {
    $bname = 'Apple Safari';
    $ub = "Safari";
  } elseif (preg_match('/Opera/i', $u_agent)) {
    $bname = 'Opera';
    $ub = "Opera";
  } elseif (preg_match('/Netscape/i', $u_agent)) {
    $bname = 'Netscape';
    $ub = "Netscape";
  }

  // finally get the correct version number
  $known = array('Version', $ub, 'other');
  $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
  if (!preg_match_all($pattern, $u_agent, $matches)) {
    // we have no matching number just continue
  }

  // see how many we have
  $i = count($matches['browser']);
  if ($i != 1) {
    //we will have two since we are not using 'other' argument yet
    //see if version is before or after the name
    if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
      $version = $matches['version'][0];
    } else {
      $version = $matches['version'][1];
    }
  } else {
    $version = $matches['version'][0];
  }

  // check if we have a number
  if ($version == null || $version == "") {
    $version = "?";
  }

  return $bname;
}

function tgl_waktu($waktu)
{
  $pecah = explode(" ", $waktu);
  $waktu = $pecah[1];
  $tgl = $pecah[0];
  $tanggal = substr($tgl, 8, 2);
  $bulan = substr($tgl, 5, 2);
  $tahun = substr($tgl, 0, 4);
  return $tanggal . '/' . $bulan . '/' . $tahun . ' ' . $waktu;
}

function tgl_waktu_indo($waktu)
{
  $pecah = explode(" ", $waktu);
  $waktu = $pecah[1];
  $tgl = $pecah[0];
  $tanggal = tgl_indo($tgl);
  return $tanggal;
}

function hari_tanggal($waktu)
{
  $pecah = explode(" ", $waktu);
  $waktu = $pecah[1];
  $tgl = $pecah[0];

  $hari = namahari($tgl);
  $tanggal = tgl_indo($tgl);


  return $hari . ', ' . $tanggal . ' ' . $waktu;
}

function ubahTanggal($tgl)
{
  $tanggal = strtotime($tgl);
  $tgl1 = date('Y-m-d H:i:s', $tanggal);
  return $tgl1;
}

function ambilWaktu($tgl)
{
  $tanggal = strtotime($tgl);
  $tgl1 = date('H:i', $tanggal);
  return $tgl1;
}

function ubahTanggalExcel($tgl)
{
  var_dump($tgl);

  // create DateTime object from timestamp
  $dt = new DateTime();
  $dt->setTimestamp($tgl);

  // print datetime formatted
  var_dump($dt->format('Y-m-d H:i:s'));
  return $dt;
}

function bulan($bln)
{
  switch ($bln) {
    case "January":
      return 1;
      break;
    case "February":
      return 2;
      break;
    case "March":
      return 3;
      break;
    case "April":
      return 4;
      break;
    case "May":
      return 5;
      break;
    case "June":
      return 6;
      break;
    case "July":
      return 7;
      break;
    case "August":
      return 8;
      break;
    case "September":
      return 9;
      break;
    case "October":
      return 10;
      break;
    case "November":
      return 11;
      break;
    case "December":
      return 12;
      break;
  }
}

function enkrip($string)
{
  $output = false;
  /*
    * read security.ini file & get encryption_key | iv | encryption_mechanism value for generating encryption code
    */
  $security       = parse_ini_file("security.ini");
  $secret_key     = $security["encryption_key"];
  $secret_iv      = $security["iv"];
  $encrypt_method = $security["encryption_mechanism"];
  // hash
  $key    = hash("sha256", $secret_key);
  // iv – encrypt method AES-256-CBC expects 16 bytes – else you will get a warning
  $iv     = substr(hash("sha256", $secret_iv), 0, 16);
  //do the encryption given text/string/number
  $result = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
  $output = base64_encode($result);
  return $output;
}
function dekrip($string)
{
  $output = false;
  /*
    * read security.ini file & get encryption_key | iv | encryption_mechanism value for generating encryption code
    */
  $security       = parse_ini_file("security.ini");
  $secret_key     = $security["encryption_key"];
  $secret_iv      = $security["iv"];
  $encrypt_method = $security["encryption_mechanism"];
  // hash
  $key    = hash("sha256", $secret_key);
  // iv – encrypt method AES-256-CBC expects 16 bytes – else you will get a warning
  $iv = substr(hash("sha256", $secret_iv), 0, 16);
  //do the decryption given text/string/number
  $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
  return $output;
}

function posttext($p)
{
  $ci = &get_instance();
  $fav = $ci->db->escape_str($ci->input->post($p));
  return $fav;
}

function postnumber($p)
{
  $ci = &get_instance();
  $fav = $ci->input->post($p);
  return $fav;
}

function formInputText($name, $value, $placeholder, $req = '')
{

  return '<input type="text" class="form-control" name="' . $name . '" id="' . $name . '" value="' . $value . '" placeholder="' . $placeholder . '" ' . $req . '>';
}

function formInputNumber($name, $value, $placeholder, $req = '')
{

  return '<input type="number" class="form-control" step="0.01" name="' . $name . '" id="' . $name . '" value="' . $value . '" placeholder="' . $placeholder . '" ' . $req . '>';
}

function formInputNumberInt($name, $value, $placeholder, $req = '')
{

  return '<input type="number" class="form-control" step="1" name="' . $name . '" id="' . $name . '" value="' . $value . '" placeholder="' . $placeholder . '" ' . $req . '>';
}

function formInputUrl($name, $value, $placeholder, $req = '')
{

  return '<input type="url" class="form-control"  name="' . $name . '" id="' . $name . '" value="' . $value . '" placeholder="' . $placeholder . '" ' . $req . '>';
}

function formInputEmail($name, $value, $placeholder, $req = '')
{

  return '<input type="email" class="form-control"  name="' . $name . '" id="' . $name . '" value="' . $value . '" placeholder="' . $placeholder . '" ' . $req . '>';
}

function formInputPassword($name, $value, $placeholder, $req = '')
{

  return '<input type="password" class="form-control"  name="' . $name . '" id="' . $name . '" value="' . $value . '" placeholder="' . $placeholder . '" ' . $req . '>';
}

function formInputGambar($name, $req = '')
{

  return '<input type="file" class="form-control"  name="' . $name . '" accept="image/*" id="' . $name . '" ' . $req . '>';
}

function formInputFile($name, $req = '')
{

  return '<input type="file" class="form-control"  name="' . $name . '" id="' . $name . '" ' . $req . '>';
}

function formInputTime($name, $value, $placeholder, $req = '')
{

  return '<input type="time" class="form-control" name="' . $name . '" id="' . $name . '" value="' . $value . '" placeholder="' . $placeholder . '" ' . $req . '>';
}

function formInputDate($name, $value, $placeholder, $req = '')
{

  return '<input type="date" class="form-control hide-inputbtns" name="' . $name . '" id="' . $name . '" value="' . $value . '" placeholder="' . $placeholder . '" ' . $req . '>';
}

function formInputTextarea($name, $value, $class, $placeholder = '', $rows = '5')
{

  return '<textarea name="' . $name . '" class="' . $class . '" placeholder="' . $placeholder . ' " rows=' . $rows . '>' . $value . '</textarea>';
}

function waktuSekarang()
{
  $waktu = date('H:i:s');

  if ($waktu >= '00:00:00' and $waktu < '10:00:00') {
    return 'Pagi';
  } else if ($waktu >= '10:00:00' and $waktu < '15:00:00') {
    return 'Siang';
  } else if ($waktu >= '15:00:00' and $waktu < '18:00:00') {
    return 'Sore';
  } else {
    return 'Malam';
  }
}
function gantiSpasi($string)
{
  $hasil = stripslashes(str_replace(array('\r\n', '\r', '\n'), ' ', $string));
  return $hasil;
}

function gantiEnter($string)
{
  $hasil = stripslashes(str_replace(array('\r\n', '\r', '\n'), '<br />', $string));
  return $hasil;
}

function gantiKoma($string)
{
  $hasil = stripslashes(str_replace(array('\r\n', '\r', '\n'), ', ', $string));
  return $hasil;
}

function gantiEdit($string)
{
  $hasil = stripslashes(str_replace(array('\r\n', '\r', '\n'), '&#13;&#10;', $string));
  return $hasil;
}

function labelGrafik($arr, $var)
{
  $arr1 = array();
  foreach ($arr as $data) {
    $arr1[] = '"' . $data[$var] . '"';
  }

  $hasil = implode(",", $arr1);

  return $hasil;
}

function labelGrafikBulan($arr, $var)
{
  $arr1 = array();
  foreach ($arr as $data) {
    $arr1[] = '"' . get_bulan($data[$var]) . '"';
  }

  $hasil = implode(",", $arr1);

  return $hasil;
}

function dataGrafik($arr, $var)
{
  $arr1 = array();
  foreach ($arr as $data) {
    $arr1[] = $data[$var];
  }

  $hasil = implode(",", $arr1);

  return $hasil;
}

function random_color($alpha = 1)
{
  $red = mt_rand(0, 255);
  $green = mt_rand(0, 255);
  $blue = mt_rand(0, 255);
  $color = "'rgba(" . $red . "," . $green . "," . $blue . "," . $alpha . ")'";

  return $color;
}

function dataWarna($arr, $alpha)
{
  $arr1 = array();
  foreach ($arr as $data) {
    $arr1[] = random_color($alpha);
  }

  $hasil = implode(",", $arr1);

  return $hasil;
}

function satuWarna($arr, $alpha)
{
  $arr1 = array();
  $warna = random_color($alpha);
  foreach ($arr as $data) {
    $arr1[] = $warna;
  }

  $hasil = implode(",", $arr1);

  return $hasil;
}

function transpose($array_one)
{
  $array_two = [];
  foreach ($array_one as $key => $item) {
    foreach ($item as $subkey => $subitem) {
      $array_two[$subkey][$key] = $subitem;
    }
  }
  return $array_two;
}

function is_in_array($array, $key, $key_value)
{
  $within_array = 'no';
  foreach ($array as $k => $v) {
    if (is_array($v)) {
      $within_array = is_in_array($v, $key, $key_value);
      if ($within_array == 'yes') {
        break;
      }
    } else {
      if ($v == $key_value && $k == $key) {
        $within_array = 'yes';
        break;
      }
    }
  }
  return $within_array;
}

function value_array($array, $key, $p = 'status')
{
  foreach ($array as $k) {
    if ($key == $k->idm) {
      $hasil = $k->$p;
      break;
    }
  }
  return $hasil;
}


function cleanStr($value)
{
  $value = str_replace('Â', '', $value);
  $value = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
  return $value;
}

function aksiModalPerbaiki($target, $id, $kata = '')
{
  $aksi = '<a title="Tambah Data" href="" data-toggle="modal" data-target="' . $target . '" data-id="' . $id . '" class="btn btn-xs btn-warning" ><i class="fa fa-sync"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiValidasi($link, $id, $kata = '')
{
  $aksi = '<a title="Validasi Data" href="' . base_url($link . '/' . $id) . '" class="btn btn-xs btn-success" onclick="return confirm(\'Anda Yakin Akan Memvalidasi Data Ini ?\');" ><i class="fa fa-check"></i> ' . $kata . '</a>';
  return $aksi;
}



function aksiAktif($target, $id, $status)
{
  if ($status == 0) {
    $aksi = '<a title="Aktifkan Data" href="' . base_url($target . '/' . $id . '/1') . '" class="btn btn-xs btn-danger tombol-aktif" ><i class="fa fa-times"></i></a>';
  } else {
    $aksi = '<a title="Non Aktifkan Data" href="' . base_url($target . '/' . $id . '/0') . '" class="btn btn-xs btn-success tombol-aktif" ><i class="fa fa-check"></i></a>';
  }

  return $aksi;
}

function aksiTambahAkun($link, $id, $kata = '')
{
  $aksi = '<a title="Tambah Akun" href="' . base_url($link . '/' . $id) . '" class="btn btn-xs btn-success" ><i class="fa fa-plus"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiPost($link, $post, $kata = '')
{
  $aksi = '   <form action="' . base_url($link) . '" method="post" accept-charset="utf-8">';
  $aksi .= '<input type="hidden" name="cari" value="Cari">';
  foreach ($post as $key => $value) {
    $aksi .= '<input type="hidden" name="' . $key . '" value="' . $value . '">';
  }
  $aksi .= '<button class="btn btn-xs btn-info" type="submit">' . $kata . '</button>';
  $aksi .= '</form>';
  return $aksi;
}

function aksiHapus($link, $id, $kata = '')
{
  $aksi = '<a title="Hapus Data" href="' . base_url($link . '/' . $id) . '" class="btn btn-xs btn-danger" onclick="return confirm(\'Anda Yakin Akan Menghapus Data Ini ?\');"><i class="fa fa-trash"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiHapusSwal($link, $id, $kata = '')
{
  $aksi = '<a title="Hapus Data" href="' . base_url($link . '/' . $id) . '" class="btn btn-xs btn-danger tombol-hapus" ><i class="fa fa-trash"></i> ' . $kata . '</a>';
  return $aksi;
}
function aksiValidasiSwal($link, $id, $kata = '')
{
  $aksi = '<a title="Validasi Data" href="' . base_url($link . '/' . $id) . '" class="btn btn-xs btn-success tombol-valid" ><i class="fa fa-check"></i> ' . $kata . '</a>';
  return $aksi;
}
function aksiReset($link, $id, $kata = '')
{
  $aksi = '<a title="Reset Validasi" href="' . base_url($link . '/' . $id) . '" class="btn btn-xs btn-danger" onclick="return confirm(\'Anda Yakin Akan Mereset Validasi Data Ini ?\');"><i class="fa fa-sync"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiEdit($link, $id, $kata = '')
{
  $aksi = '<a title="Edit Data" href="' . base_url($link . '/' . $id) . '" class="btn btn-xs btn-warning" ><i class="fa fa-edit"></i> ' . $kata . '</a>';
  return $aksi;
}


function aksiDetail($link, $id, $kata = '')
{
  $aksi = '<a title="Detail Data" target="_blank" href="' . base_url($link . '/' . $id) . '" class="btn btn-xs btn-info"><i class="fa fa-info-circle"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiBiasa($link, $kata = '')
{
  $aksi = '<a title="Detail Data" href="' . base_url($link) . '" >' . $kata . '</a>';
  return $aksi;
}

function aksiBiasaBlank($link, $kata = '')
{
  $aksi = '<a title="Detail Data" target="_blank" href="' . base_url($link) . '" >' . $kata . '</a>';
  return $aksi;
}

function aksiDetailBlank($link, $id, $kata = '')
{
  $aksi = '<a title="Detail Data" href="' . base_url($link . '/' . $id) . '" class="btn btn-xs btn-info" target="_blank"><i class="fa fa-info-circle"></i> ' . $kata . '</a>';
  return $aksi;
}


function aksiUrl($link, $kata = '')
{
  $aksi = '<a title="Detail Data" href="' . $link . '" class="btn btn-xs btn-info" target="_blank"><i class="fa fa-link"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiKembali($link)
{
  $aksi = '<a title="Kembali" href="' . base_url($link) . '" class="btn btn-xs btn-success" ><i class="fa fa-backward"></i> Kembali</a>';
  return $aksi;
}

function aksiTambah($link, $kata = 'Tambah')
{
  $aksi = '<a title="Tambah Data" href="' . base_url($link) . '" class="btn btn-xs btn-info" ><i class="fa fa-plus"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiBuka($link, $kata = '')
{
  $aksi = '<a title="Tambah Data" href="' . base_url($link) . '" class="btn btn-xs btn-success" ><i class="fa fa-folder-open"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiCetak($link, $id, $kata = '')
{
  $aksi = '<a title="Cetak Data" href="' . base_url($link . '/' . $id) . '" class="btn btn-xs btn-info" onclick="window.open(this.href, \'popupwindow\',\'width=800,height=600,left=200, top=50, scrollbars=yes,resizable=yes\'); return false;"><i class="fa fa-print"></i> ' . $kata . '</a>';
  return $aksi;
}
function aksiDownload($link, $id, $kata = '')
{
  $aksi = '<a title="Detail Data" href="' . base_url($link . '/' . $id) . '" class="btn btn-xs btn-success" target="_blank"><i class="fa fa-download"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiDownloadFile($link, $kata = '')
{
  $aksi = '<a title="Detail Data" href="' . $link . '" class="btn btn-xs btn-success" target="_blank"><i class="fa fa-download"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiModalImport($target, $kata = '')
{
  $aksi = '<a title="Tambah Data" href="" data-toggle="modal" data-target="' . $target . '" class="btn btn-xs btn-info" ><i class="fa fa-upload"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiModalUpload($target, $kata = '')
{
  $aksi = '<a title="Tambah Data" href="" data-toggle="modal" data-target="' . $target . '" class="btn btn-lg btn-info" ><i class="fa fa-upload"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiModalLihatBukti($target, $kata = '')
{
  $aksi = '<a title="Tambah Data" href="" data-toggle="modal" data-target="' . $target . '" class="btn btn-lg btn-success" ><i class="fa fa-eye"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiModalValidasi($target, $kata = '')
{
  $aksi = '<a title="Tambah Data" href="" data-toggle="modal" data-target="' . $target . '" class="btn btn-xs btn-info" ><i class="fa fa-check"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiModalTambah($target, $kata = '')
{
  $aksi = '<a title="Tambah Data" href="" data-toggle="modal" data-target="' . $target . '" class="btn btn-xs btn-info" ><i class="fa fa-plus"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiModalEdit($target, $id, $kata = '')
{
  $aksi = '<a title="Edit Data" href="" data-toggle="modal" data-target="' . $target . '" data-id="' . $id . '" class="btn btn-xs btn-warning" ><i class="fa fa-edit"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiModalReset($target, $id, $kata = '')
{
  $aksi = '<a title="Reset Data" href="" data-toggle="modal" data-target="' . $target . '" data-id="' . $id . '" class="btn btn-xs btn-danger" ><i class="fa fa-sync"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiModalRuangan($target, $id, $ruangan, $kata = '')
{
  $aksi = '<a title="Tambah Data" href="" data-toggle="modal" data-target="' . $target . '" data-id="' . $id . '" data-id="' . $ruangan . '" class="btn btn-xs btn-warning" ><i class="fa fa-edit"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiModalLihat($target, $id, $kata = '')
{
  $aksi = '<a title="Lihat Data" href="" data-toggle="modal" data-target="' . $target . '" data-id="' . $id . '" class="btn btn-xs btn-info" ><i class="fa fa-eye"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiModalView($target, $id, $kode, $kata = '')
{
  $aksi = '<a title="Lihat Data" href="" data-toggle="modal" data-target="' . $target . '" data-id="' . $id . '" data-kode="' . $kode . '" class="btn btn-xs btn-info" ><i class="fa fa-eye"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiModalBiasa($target, $id, $kata = '')
{
  $aksi = '<a title="Lihat Data" href="" data-toggle="modal" data-target="' . $target . '" data-id="' . $id . '" >' . $kata . '</a>';
  return $aksi;
}

function lihatVideo($url, $kata = '')
{
  $aksi = '<a title="Lihat Video" href="' . $url . '" data-toggle="lightbox" class="btn btn-xs btn-info"><i class="fa fa-play"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiModalUploadBukti($target, $id, $jenis, $kata = '')
{
  $aksi = '<a title="Tambah Data" href="" data-toggle="modal" data-target="' . $target . '" data-id="' . $id . '" data-jenis="' . $jenis . '" class="btn btn-xs btn-info" ><i class="fa fa-upload"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiModalTambahId($target, $id, $kata = '')
{
  $aksi = '<a title="Tambah Data" href="" data-toggle="modal" data-target="' . $target . '" data-id="' . $id . '" class="btn btn-xs btn-info" ><i class="fa fa-plus"></i> ' . $kata . '</a>';
  return $aksi;
}

function opEnumRadio($table, $field, $value = '')
{
  $ci = &get_instance();
  $opsi = '';
  $ss = $ci->db->query("SHOW FIELDS FROM $table")->result_array();
  foreach ($ss as $as) {
    # code...

    $arrs = $as['Type'];
    if (substr($arrs, 0, 4) == 'enum' && $as['Field'] == $field) break;
  }
  $arr5 = array();
  $arrs = '' . substr($arrs, 4);
  $arr = eval('$arr5 = array' . $arrs . ';');
  $no = 0;
  foreach ($arr5 as $k => $v) {
    $no++;
    $cl = ($v == $value) ? 'checked' : '';
    $opsi .= '<div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="' . $field . '" id="' . $field . $no . '" value="' . $v . '" ' . $cl . ' required />
                    <label class="form-check-label" for="' . $field . $no . '">' . $v . '</label>
                </div>';
  }
  return $opsi;
}

function aksiModalUploadId($target, $id, $kata = '')
{
  $aksi = '<a title="Upload File" href="" data-toggle="modal" data-target="' . $target . '" data-id="' . $id . '" class="btn btn-xs btn-info" ><i class="fa fa-upload"></i> ' . $kata . '</a>';
  return $aksi;
}


function aksiSync($link, $id, $kata = '')
{
  $aksi = '<a title="Reset Validasi" href="' . base_url($link . '/' . $id) . '" class="btn btn-xs btn-success" onclick="return confirm(\'Anda Yakin Akan Menyinkronkan Data Ini ?\');"><i class="fa fa-sync"></i> ' . $kata . '</a>';
  return $aksi;
}

function aksiExport($link, $id, $kata = 'Excel')
{
  $aksi = '<a title="Export Data" href="' . base_url($link . '/' . $id) . '" class="btn btn-xs btn-success" ><i class="fa fa-file-excel"></i> ' . $kata . '</a>';
  return $aksi;
}
