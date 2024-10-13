<?php 
namespace App\Traits;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use League\Fractal;

trait HelperTrait{


const SITE_CURRENCY = 'EUR';
/**
 * Returns formated money value
 * @param	$amount				Amount
 * @param	$hide_currency		Hide or Show currency sign
 * @param	$hide_zeros			Show as $5.00 or $5
 * @return	string				returns formated money value
*/


public function DisplayMoney($amount, $hide_currency = 0, $hide_zeros = 0)
	{
		$newamount = number_format($amount, 2, '.', '');

		if ($hide_zeros == 1)
		{
			$cents = substr($newamount, -2);
			if ($cents == "00") $newamount = substr($newamount, 0, -3);
		}

		if ($hide_currency != 1)
		{
			switch (SITE_CURRENCY_FORMAT)
			{
				case "1": $newamount = HelperTrait::SITE_CURRENCY.$newamount; break;
				case "2": $newamount = HelperTrait::SITE_CURRENCY." ".$newamount; break;
				case "3": $newamount = HelperTrait::SITE_CURRENCY.number_format($amount, 2, ',', ''); break;
				case "4": $newamount = $newamount." ".HelperTrait::SITE_CURRENCY; break;
				case "5": $newamount = $newamount.HelperTrait::SITE_CURRENCY; break;
				default: $newamount = HelperTrait::SITE_CURRENCY.$newamount; break;
			}	
		} 

		return $newamount;
	}
	
	
/**
 * Returns random key
 * @param	$text		string
 * @return	string		random key for user verification
*/
public	function GenerateKey($text)
	{
		$text = preg_replace("/[^0-9a-zA-Z]/", " ", $text);
		$text = substr(trim($text), 0, 50);
		$key = md5(time().$text.mt_rand(1000,9999));
		return $key;
	}



/**
 * Calculate percentage
 * @param	$amount				Amount
 * @param	$percent			Percent value
 * @return	string				returns formated money value
*/
public	function CalculatePercentage($amount, $percent)
	{
		return number_format(($amount/100)*$percent,2,'.','');
	}

/**
 * Returns formated cashback value
 * @param	$value		Cashback value
 * @return	string		returns formated cashback value
*/

public	function DisplayCashback($value)
	{
		if (empty($value) || $value == "") {
			return "";
		}; //else if ($value=0) return 'N/A';
		

		if (strstr($value,'%')) {
			$cashback = $value; 
			if ($cashback < 0) return 'έως '.abs($cashback).'%';
			//else if ($cashback == 0) return 'N/A';
		} elseif (strstr($value,'points')) {
			$cashback = str_replace("points"," ".CBE1_POINTS,$value);
		} else {
			switch (SITE_CURRENCY_FORMAT) {
				case "1":
					$cashback = SITE_CURRENCY.$value;
					break;
				case "2":
					$cashback = SITE_CURRENCY." ".$value;
					break;
				case "3":
					$cashback = SITE_CURRENCY.number_format($value, 2, ',', '');
					break;
				case "4":
					$cashback = $value." ".SITE_CURRENCY;
					break;
				case "5":
					$cashback = $value.SITE_CURRENCY;
					break;
				default:
					$cashback = SITE_CURRENCY.$value;
					break;
			}
		}

		return $cashback;
	}
	

/**
 * Returns time left
 * @return	string	time left
*/


public	function GetTimeLeft($time_left)
	{
		$days		= floor($time_left / (60 * 60 * 24));
		$remainder	= $time_left % (60 * 60 * 24);
		$hours		= floor($remainder / (60 * 60));
		$remainder	= $remainder % (60 * 60);
		$minutes	= floor($remainder / 60);
		$seconds	= $remainder % 60;

		$days == 1 ? $dw = CBE1_TIMELEFT_DAY : $dw = CBE1_TIMELEFT_DAYS;
		$hours == 1 ? $hw = CBE1_TIMELEFT_HOUR : $hw = CBE1_TIMELEFT_HOURS;
		$minutes == 1 ? $mw = CBE1_TIMELEFT_MIN : $mw = CBE1_TIMELEFT_MINS;
		$seconds == 1 ? $sw = CBE1_TIMELEFT_SECOND : $sw = CBE1_TIMELEFT_SECONDS;

		if ($time_left > 0)
		{
			//$new_time_left = $days." $dw ".$hours." $hw ".$minutes." $mw";
			$new_time_left = $days." $dw ".$hours." $hw";
			return $new_time_left;
		}
		else
		{
			return "<span class='expired'>".CBE1_TIMELEFT_EXPIRED."</span>";
		}
	}

/**
 * Returns random password
 * @param	$length		length of string
 * @return	string		random password
*/


	public function generatePassword($length = 8)
	{
		$password = "";
		$possible = "0123456789abcdefghijkmnpqrstvwxyzABCDEFGHJKLMNPQRTVWXYZ!(@)";
		$i = 0; 

		while ($i < $length)
		{ 
			$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);

			if (!strstr($password, $char))
			{ 
				$password .= $char;
				$i++;
			}
		}
		return $password;
	}

	/**
 * Returns random string
 * @param	$len	string length
 * @param	$chars	chars in the string
 * @return	string	random string
*/


	public function GenerateRandString($len, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789')
	{
		$string = '';
		for ($i = 0; $i < $len; $i++)
		{
			$pos = rand(0, strlen($chars)-1);
			$string .= $chars{$pos};
		}
		return $string;
	}

/**
 * Returns payment reference ID
 * @return	string	Reference ID
*/


	public function GenerateReferenceID()
	{
		unset($num);

		$num = GenerateRandString(9,"0123456789");
    
		$check = smart_mysql_query("SELECT * FROM cashbackengine_transactions WHERE reference_id='$num'");
    
		if (mysqli_num_rows($check) == 0)
		{
			return $num;
		}
		else
		{
			return GenerateReferenceID();
		}
	}
	
	
	/**
 * Returns Encrypted password
 * @param	$password	User's ID
 * @return	string		encrypted password
*/


	public function PasswordEncryption($password, $sha1=true)
	{
	    if ($sha1==false) return md5($password);
		
		return md5(sha1($password));
		
	}




	/**
 * Returns trancated text
 * @param	$text		Text
 * @param	$limit		characters limit
 * @param	$more_link	Show/Hide 'read more' link
 * @return	string		text
*/


	public function TruncateText($text, $limit, $more_link = 0)
	{
		$limit = (int)$limit;

		if ($limit > 0 && strlen($text) > $limit)
		{
			$ntext = substr($text, 0, $limit);
			$ntext = substr($ntext, 0, strrpos($ntext, ' '));
			$ttext = $ntext;
			if ($more_link == 1)
			{
				$ttext .= ' <a id="next-button">'.CBE1_TRUNCATE_MORE.' &raquo;</a><span id="hide-text-block" style="display: none">'.str_replace($ntext, '', $text, $count = 1).' <a id="prev-button" style="display: none">&laquo; '.CBE1_TRUNCATE_LESS.'</a></span>';
			}
			else
			{
				$ttext .= " ...";
			}
		}
		else
		{
			$ttext = $text;
		}
		return $ttext;
	}

/**
 * Returns formatted sctring
 * @param	$str		string
 * @return	string		formatted sctring
*/


	public function well_formed($str) {
		$str = strip_tags($str);
		$str = preg_replace("/[^a-zA-Z0-9_ (\n|\r\n)]+/", "", $str);
		$str = str_replace("&nbsp;", "", $str);
		$str = str_replace("&", "&amp;", $str);
		return $str;
	}



   

  
 
/**
 * image processing
 * @return img link
 */

	public function ImageResize($infile, $neww, $newh, $quality = '75', $outfile = '') {

		$file_name = explode('.', $infile);

		$outfile_link = 'images/apopou/gr/cache/'.$file_name[0].'-'.$neww.'-'.$newh.'.'.$file_name[1];
		$outfile = DOCS_ROOT.'/images/apopou/gr/cache/'.$file_name[0].'-'.$neww.'-'.$newh.'.'.$file_name[1];


		if(!file_exists($infile)){
			$infile = DOCS_ROOT.'/'.'images/home_img.png';
		}

		if(!file_exists($outfile)){

			$path = '';

			$directories = explode('/', dirname($outfile));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir($path)) {
					@mkdir($path, 0777);
				}
			}

			$im = imagecreatefromjpeg($infile);
			$k1 = $neww / imagesx($im);
			$k2 = $newh / imagesy($im);
			$k = $k1 > $k2 ? $k2 : $k1;

			$w = intval(imagesx($im)*$k);
			$h = intval(imagesy($im)*$k);

			$im1 = imagecreatetruecolor($w,$h);
			imagecopyresampled($im1,$im,0,0,0,0,$w,$h,imagesx($im),imagesy($im));

			imagejpeg($im1,$outfile,$quality);
			imagedestroy($im);
			imagedestroy($im1);
		}

		return $outfile_link;
	}	
	
	
	
    function mb_ucfirst($str, $encoding = "UTF-8", $lower_str_end = false) {
      $first_letter = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding);
      $str_end = "";
      if ($lower_str_end) {
        $str_end = mb_strtolower(mb_substr($str, 1, mb_strlen($str, $encoding), $encoding), $encoding);
      }
      else {
        $str_end = mb_substr($str, 1, mb_strlen($str, $encoding), $encoding);
      }
      $str = $first_letter . $str_end;
      return $str;
    }
}


