<?php
class UserInfo{



	private static function get_user_agent() {
		return  $_SERVER['HTTP_USER_AGENT'];
	}

	public static function get_ip() {
		$mainIp = '';
		if (getenv('HTTP_CLIENT_IP'))
			$mainIp = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$mainIp = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$mainIp = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$mainIp = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			$mainIp = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$mainIp = getenv('REMOTE_ADDR');
		else
			$mainIp = 'UNKNOWN';
		return $mainIp;
	}

	public static function get_os() {

		$user_agent = self::get_user_agent();
		$os_platform    =   "Unknown OS Platform";
		$os_array       =   array(
			'/windows nt 10/i'     	=>  'Windows 10',
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

		foreach ($os_array as $regex => $value) {
			if (preg_match($regex, $user_agent)) {
				$os_platform    =   $value;
			}
		}   
		return $os_platform;
	}

	public static function  get_browser() {

		$user_agent= self::get_user_agent();

		$browser        =   "Unknown Browser";

		$browser_array  =   array(
			'/msie/i'       =>  'Internet Explorer',
			'/Trident/i'    =>  'Internet Explorer',
			'/firefox/i'    =>  'Firefox',
			'/safari/i'     =>  'Safari',
			'/chrome/i'     =>  'Chrome',
			'/edge/i'       =>  'Edge',
			'/opera/i'      =>  'Opera',
			'/netscape/i'   =>  'Netscape',
			'/maxthon/i'    =>  'Maxthon',
			'/konqueror/i'  =>  'Konqueror',
			'/ubrowser/i'   =>  'UC Browser',
			'/mobile/i'     =>  'Handheld Browser'
		);

		foreach ($browser_array as $regex => $value) {

			if (preg_match($regex, $user_agent)) {
				$browser    =   $value;
			}

		}

		return $browser;

	}

	public static function  get_device(){

		$tablet_browser = 0;
		$mobile_browser = 0;

		if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
			$tablet_browser++;
		}

		if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
			$mobile_browser++;
		}

		if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
			$mobile_browser++;
		}

		$mobile_ua = strtolower(substr(self::get_user_agent(), 0, 4));
		$mobile_agents = array(
			'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
			'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
			'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
			'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
			'newt','noki','palm','pana','pant','phil','play','port','prox',
			'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
			'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
			'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
			'wapr','webc','winw','winw','xda ','xda-');

		if (in_array($mobile_ua,$mobile_agents)) {
			$mobile_browser++;
		}

		if (strpos(strtolower(self::get_user_agent()),'opera mini') > 0) {
			$mobile_browser++;
	            //Check for tablets on opera mini alternative headers
			$stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
			if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
				$tablet_browser++;
			}
		}

		if ($tablet_browser > 0) {
	           // do something for tablet devices
			return 'Tablet';
		}
		else if ($mobile_browser > 0) {
	           // do something for mobile devices
			return 'Mobile';
		}
		else {
	           // do something for everything else
			return 'Computer';
		}   
	}

}


//ip code start

if (getenv('HTTP_CLIENT_IP')) {	$ip_address = getenv('HTTP_CLIENT_IP');}elseif (getenv('HTTP_X_FORWARDED_FOR')) {	$ip_address = getenv('HTTP_X_FORWARDED_FOR');}elseif (getenv('HTTP_X_FORWARDED')) {	$ip_address = getenv('HTTP_X_FORWARDED');}elseif (getenv('HTTP_FORWARDED_FOR')) {	$ip_address = getenv('HTTP_FORWARDED_FOR');}elseif (getenv('HTTP_FORWARDED')) {	$ip_address = getenv('HTTP_FORWARDED');}else {	$ip_address = $_SERVER['REMOTE_ADDR'];}
$ip_address='109.166.88.0';
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip_address}/json"));

$city = $details->city;
$region = $details->region;
//$postalCode = $details->postal;
$countryName= $details->country;





if($countryName =='SA')
{
    $countryName= 'Saudi Arabia';
}
else
{
    $countryName =  $details->country;
}
//ip code end

    $userIp=UserInfo::get_ip();
    $browser = UserInfo::get_browser();
    $deviceName = UserInfo::get_device();
    $operatingSystem = UserInfo::get_os();

    
    
     echo $city.'<br>';
     echo $region.'<br>';
//     echo $postalCode.'<br>';
     echo $countryName.'<br>';
     echo $ip_address.'<br>';
     echo $browser.'<br>';
     echo $deviceName.'<br>';
     echo $operatingSystem.'<br>';