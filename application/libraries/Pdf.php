<?php
class Pdf
{
	function easytable()
	{
		include_once APPPATH . '/third_party/fpdf/easyTable.php';
	}

	function portrait()
	{
		include_once APPPATH . '/third_party/fpdf/portrait.php';
	}

	function portraitnopage()
	{
		include_once APPPATH . '/third_party/fpdf/portraitnopage.php';
	}

	function landscapea4()
	{
		include_once APPPATH . '/third_party/fpdf/landscapea4.php';
	}

	function landscapef4()
	{
		include_once APPPATH . '/third_party/fpdf/landscapef4.php';
	}

	function mergepdf()
	{
		include_once APPPATH . '/third_party/fpdf/mergepdf.php';
	}
}
