<?php

namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use App\Models\m_a_menu;
use App\Models\m_a_user;
use App\Models\m_a_group;
use App\Models\m_division;
use CodeIgniter\Controller;

class BaseController extends Controller
{
	protected $users;
	protected $groups;
	protected $menus;
	protected $divisions;
	protected $session;

	public function __construct()
	{
		$this->users =  new m_a_user();
		$this->groups =  new m_a_group();
		$this->menus =  new m_a_menu();
		$this->divisions =  new m_division();
		$this->session = \Config\Services::session();
		if ($_SERVER["REQUEST_URI"] != "/login" && !$this->session->get("loggedin")) {
			echo "<script> window.location='" . base_url() . "/login'; </script>";
			exit();
		}
	}
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
	}

	public function common()
	{
		if ($this->session->get("loggedin")) {
			$__submenu = [];
			$grouplogin = @$this->groups->where("id", $this->session->get("user")->group_id)->where("is_deleted", 0)->findAll()[0];
			$menu_ids = substr("0," . @$grouplogin->menu_ids, 0, -1);
			if (@$grouplogin->id > 0)
				$__mainmenu = $this->menus->where("parent_id", 0)->where("is_deleted", 0)->where("id IN (" . $menu_ids . ")")->orderBy('seqno', 'asc')->findAll();
			else
				$__mainmenu = $this->menus->where("parent_id", 0)->where("is_deleted", 0)->orderBy('seqno', 'asc')->findAll();

			foreach ($__mainmenu as $mainmenu) {
				if (@$grouplogin->id > 0) {
					if ($_submenu = $this->menus->where("parent_id", $mainmenu->id)->where("is_deleted", 0)->where("id IN (" . $menu_ids . ")")->orderBy('seqno', 'asc')->findAll()) {
						$__submenu[$mainmenu->id] = $_submenu;
					}
				} else {
					if ($_submenu = $this->menus->where("parent_id", $mainmenu->id)->where("is_deleted", 0)->orderBy('seqno', 'asc')->findAll()) {
						$__submenu[$mainmenu->id] = $_submenu;
					}
				}
			}
		} else {
			$__mainmenu = $this->menus->where("id", 1)->orderBy('seqno', 'asc')->findAll();
			$__submenu = [];
		}
		$data["__session"] = $this->session;
		$data["__users"]["id"] = $this->session->get("user_id");
		$data["__users"]["name"] = $this->session->get("username");
		$data["__mainmenu"] = $__mainmenu;
		$data["__submenu"] = $__submenu;
		$data["__menu_ids"] = @$this->get_menu_ids(explode("/", $_SERVER["PATH_INFO"])[1]);
		return $data;
	}

	public function get_menu_ids($url)
	{
		$return = [];
		foreach (@$this->menus->where(["is_deleted" => 0, "url" => $url])->findAll() as $menus) {
			$return[] = $menus->id;
		}
		return $return;
	}

	public function privilege_check($menu_ids, $mode = "0", $return_url = "")
	{
		$allowed = false;
		$grouplogin = @$this->groups->where("id", $this->session->get("user")->group_id)->where("is_deleted", 0)->findAll()[0];
		$_menu_ids = explode(",", @$grouplogin->menu_ids);
		$_privileges = explode(",", @$grouplogin->privileges);
		$privileges = [];

		foreach ($_privileges as $key => $privilege) {
			$privileges[$_menu_ids[$key]] = $privilege;
		}

		if ($this->session->get("user")->group_id == 0) $allowed = true;

		foreach ($menu_ids as $menu_id) {
			if ($mode == "0") {
				if (isset($privileges[$menu_id])) $allowed = true;
			} else {
				if (@$privileges[$menu_id] & $mode) $allowed = true;
			}
		}

		if (!$allowed) {
			$this->session->setFlashdata("flash_message", ["error", "Sorry, you don`t have the privilege!"]);
?> <script>
				window.location = "<?= base_url(); ?>/<?= $return_url; ?>";
			</script> <?php
						exit();
					}
				}

				public function numberToRoman($num)
				{
					$n = intval($num);
					$result = '';

					$lookup = array(
						'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
						'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
						'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
					);

					foreach ($lookup as $roman => $value) {
						$matches = intval($n / $value);
						$result .= str_repeat($roman, $matches);
						$n = $n % $value;
					}
					return $result;
				}

				public function namabulan($bulan)
				{
					$arr["01"] = "Januari";
					$arr["02"] = "Februari";
					$arr["03"] = "Maret";
					$arr["04"] = "April";
					$arr["05"] = "Mei";
					$arr["06"] = "Juni";
					$arr["07"] = "Juli";
					$arr["08"] = "Agustus";
					$arr["09"] = "September";
					$arr["10"] = "Oktober";
					$arr["11"] = "November";
					$arr["12"] = "Desember";
					return $arr[$bulan];
				}

				public function format_tanggal($tanggal, $mode = "d Fi Y")
				{
					if ($mode == "d Fi Y")
						return date("d", strtotime($tanggal)) . " " . $this->namabulan(date("m", strtotime($tanggal))) . " " . date("Y", strtotime($tanggal));
					else return date($mode, strtotime($tanggal));
				}

				public function number_to_words($number, $numdecimal = 0)
				{
					if ($number == "" || !isset($number)) $number = 0;
					$number = str_replace(",", "", $number);
					$number = number_format($number, $numdecimal, ".", "") * 1;
					$_string = "";
					$hyphen      = '-';
					$conjunction = ' and ';
					$separator   = ', ';
					$negative    = 'negative ';
					$decimal     = ' point ';
					$dictionary  = array(
						0                   => 'zero',
						1                   => 'one',
						2                   => 'two',
						3                   => 'three',
						4                   => 'four',
						5                   => 'five',
						6                   => 'six',
						7                   => 'seven',
						8                   => 'eight',
						9                   => 'nine',
						10                  => 'ten',
						11                  => 'eleven',
						12                  => 'twelve',
						13                  => 'thirteen',
						14                  => 'fourteen',
						15                  => 'fifteen',
						16                  => 'sixteen',
						17                  => 'seventeen',
						18                  => 'eighteen',
						19                  => 'nineteen',
						20                  => 'twenty',
						30                  => 'thirty',
						40                  => 'fourty',
						50                  => 'fifty',
						60                  => 'sixty',
						70                  => 'seventy',
						80                  => 'eighty',
						90                  => 'ninety',
						100                 => 'hundred',
						1000                => 'thousand',
						1000000             => 'million',
						1000000000          => 'billion',
						1000000000000       => 'trillion',
						1000000000000000    => 'quadrillion',
						1000000000000000000 => 'quintillion'
					);

					if (!is_numeric($number)) {
						return false;
					}

					if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
						// overflow
						trigger_error(
							'number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
							E_USER_WARNING
						);
						return false;
					}

					if ($number < 0) {
						return $negative . $this->number_to_words(abs($number));
					}

					$string = $fraction = null;

					if (strpos($number, '.') !== false) {
						list($number, $fraction) = explode('.', $number);
					}

					switch (true) {
						case $number < 21:
							$string = $dictionary[$number];
							break;
						case $number < 100:
							$tens   = ((int) ($number / 10)) * 10;
							$units  = $number % 10;
							$string = $dictionary[$tens];
							if ($units) {
								$string .= $hyphen . $dictionary[$units];
							}
							break;
						case $number < 1000:
							$hundreds  = $number / 100;
							$remainder = $number % 100;
							$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
							if ($remainder) {
								$string .= $conjunction . $this->number_to_words($remainder);
							}
							break;
						default:
							$baseUnit = pow(1000, floor(log($number, 1000)));
							$numBaseUnits = (int) ($number / $baseUnit);
							$remainder = $number % $baseUnit;
							$string = $this->number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
							if ($remainder) {
								$string .= $remainder < 100 ? $conjunction : $separator;
								$string .= $this->number_to_words($remainder);
							}
							break;
					}

					if (null !== $fraction && is_numeric($fraction)) {
						//$string .= $decimal;
						$number = $fraction . substr("000000000000000000000000000000000000000000000", 0, $numdecimal - strlen($fraction));
						/* $words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words); */
						if (substr($number, 0, 1) == "0") {
							$numberX = $number;
							$_string = "";
							for ($xx = 0; $xx < strlen($numberX); $xx++) {
								$number = substr($numberX, $xx, 1);
								switch (true) {
									case $number < 21:
										$_string .= $dictionary[$number] . " ";
										break;
									case $number < 100:
										$tens   = ((int) ($number / 10)) * 10;
										$units  = $number % 10;
										$_string .= $dictionary[$tens] . " ";
										if ($units) {
											$_string .= $hyphen . $dictionary[$units];
										}
										break;
									case $number < 1000:
										$hundreds  = $number / 100;
										$remainder = $number % 100;
										$_string .= $dictionary[$hundreds] . ' ' . $dictionary[100] . " ";
										if ($remainder) {
											$_string .= $conjunction . $this->number_to_words($remainder);
										}
										break;
									default:
										$baseUnit = pow(1000, floor(log($number, 1000)));
										$numBaseUnits = (int) ($number / $baseUnit);
										$remainder = $number % $baseUnit;
										$_string .= $this->number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit] . " ";
										if ($remainder) {
											$_string .= $remainder < 100 ? $conjunction : $separator;
											$_string .= $this->number_to_words($remainder);
										}
										break;
								}
							}
						} else {
							switch (true) {
								case $number < 21:
									$_string .= $dictionary[$number] . " ";
									break;
								case $number < 100:
									$tens   = ((int) ($number / 10)) * 10;
									$units  = $number % 10;
									$_string .= $dictionary[$tens] . " ";
									if ($units) {
										$_string .= $hyphen . $dictionary[$units];
									}
									break;
								case $number < 1000:
									$hundreds  = $number / 100;
									$remainder = $number % 100;
									$_string .= $dictionary[$hundreds] . ' ' . $dictionary[100] . " ";
									if ($remainder) {
										$_string .= $conjunction . $this->number_to_words($remainder);
									}
									break;
								default:
									$baseUnit = pow(1000, floor(log($number, 1000)));
									$numBaseUnits = (int) ($number / $baseUnit);
									$remainder = $number % $baseUnit;
									$_string .= $this->number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit] . " ";
									if ($remainder) {
										$_string .= $remainder < 100 ? $conjunction : $separator;
										$_string .= $this->number_to_words($remainder);
									}
									break;
							}
						}
						$string .= $decimal . " " . $_string;
					}

					return $string;
				}

				public function angka_kalimat($number, $numdecimal = 0)
				{
					$number = str_replace(",", "", $number);
					$number = number_format(($number * 1), $numdecimal, ".", "");

					$hyphen      = ' ';
					$conjunction = ' ';
					$separator   = ', ';
					$negative    = 'min ';
					$decimal     = ' koma ';
					$dictionary  = array(
						0                   => 'nol',
						1                   => 'satu',
						2                   => 'dua',
						3                   => 'tiga',
						4                   => 'empat',
						5                   => 'lima',
						6                   => 'enam',
						7                   => 'tujuh',
						8                   => 'delapan',
						9                   => 'sembilan',
						10                  => 'sepuluh',
						11                  => 'sebelas',
						12                  => 'dua belas',
						13                  => 'tiga belas',
						14                  => 'empat belas',
						15                  => 'lima belas',
						16                  => 'enam belas',
						17                  => 'tujuh belas',
						18                  => 'delapan belas',
						19                  => 'sembilan belas',
						20                  => 'dua puluh',
						30                  => 'tiga puluh',
						40                  => 'empat puluh',
						50                  => 'lima puluh',
						60                  => 'enam puluh',
						70                  => 'tujuh puluh',
						80                  => 'delapan puluh',
						90                  => 'sembilan puluh',
						100                 => 'ratus',
						1000                => 'ribu',
						1000000             => 'juta',
						1000000000          => 'miliyar',
						1000000000000       => 'triliun',
						1000000000000000    => 'quatriliun',
						1000000000000000000 => 'quintriliun'
					);

					if (!is_numeric($number)) {
						return false;
					}

					if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
						// overflow
						trigger_error(
							'number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
							E_USER_WARNING
						);
						return false;
					}

					if ($number < 0) {
						return $negative . $this->angka_kalimat(abs($number));
					}

					$string = $fraction = null;

					if (strpos($number, '.') !== false) {
						list($number, $fraction) = explode('.', $number);
					}

					switch (true) {
						case $number < 21:
							$string = $dictionary[$number];
							break;
						case $number < 100:
							$tens   = ((int) ($number / 10)) * 10;
							$units  = $number % 10;
							$string = $dictionary[$tens];
							if ($units) {
								$string .= $hyphen . $dictionary[$units];
							}
							break;
						case $number < 1000:
							$hundreds  = $number / 100;
							$remainder = $number % 100;
							$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
							if ($remainder) {
								$string .= $conjunction . $this->angka_kalimat($remainder);
							}
							break;
						default:
							$baseUnit = pow(1000, floor(log($number, 1000)));
							$numBaseUnits = (int) ($number / $baseUnit);
							$remainder = $number % $baseUnit;
							$string = $this->angka_kalimat($numBaseUnits) . ' ' . $dictionary[$baseUnit];
							if ($remainder) {
								$string .= $remainder < 100 ? $conjunction : $separator;
								$string .= $this->angka_kalimat($remainder);
							}
							break;
					}

					if (null !== $fraction && is_numeric($fraction)) {
						$string .= $decimal;
						$words = array();
						foreach (str_split((string) $fraction) as $number) {
							$words[] = $dictionary[$number];
						}
						$string .= implode(' ', $words);
					}
					$arr1 = array("satu ratus", "satu ribu", "satu juta", "satu miliyar", "satu triliun", "satu quatriliun", "satu quintriliun");
					$arr2 = array("seratus", "seribu", "sejuta", "semiliyar", "setriliun", "sequatriliun", "sequintriliun");
					return str_replace($arr1, $arr2, $string);
				}

				public function format_amount($amount, $decimalnum = 0, $currency_id = "IDR", $isexport = false)
				{
					$isnegative = false;
					if ($isexport) return $amount;
					if ($amount < 0) {
						$amount  *= -1;
						$isnegative = true;
					}
					if ($currency_id == "IDR") $return = number_format($amount, $decimalnum, ",", ".");
					else $return = number_format($amount, $decimalnum);
					if ($isnegative) $return = "(" . $return . ")";
					return $return;
				}

				public function numberpad($number, $pad)
				{
					return sprintf("%0" . $pad . "d", $number);
				}

				public function supplier_invoice_no_template()
				{
					return "INV/{month}/{year}/{seqno}";
				}

				public function so_no_template()
				{
					return "{seqno}/PO-{div}/{month}/{year}";
				}

				public function invoice_no_template()
				{
					return "{seqno}/KL/TUT/{year}";
				}

				public function amountformat($value)
				{
					return number_format($value, 2, ",", ".");
				}

				public function created_values()
				{
					$data["created_at"] = date("Y-m-d H:i:s");
					$data["created_by"] = $this->session->get("username");
					$data["created_ip"] = $_SERVER["REMOTE_ADDR"];
					return $data;
				}

				public function updated_values()
				{
					$data["updated_at"] = date("Y-m-d H:i:s");
					$data["updated_by"] = $this->session->get("username");
					$data["updated_ip"] = $_SERVER["REMOTE_ADDR"];
					return $data;
				}

				public function deleted_values()
				{
					$data["is_deleted"] = 1;
					$data["deleted_at"] = date("Y-m-d H:i:s");
					$data["deleted_by"] = $this->session->get("username");
					$data["deleted_ip"] = $_SERVER["REMOTE_ADDR"];
					return $data;
				}
			}
