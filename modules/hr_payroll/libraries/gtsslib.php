<?php if(count(get_included_files()) == 1) exit("No direct script access allowed");

define("LB_API_DEBUG", false);
define("LB_SHOW_UPDATE_PROGRESS", true);

define("LB_TEXT_CONNECTION_FAILED", 'Server is unavailable at the moment, please try again.');
define("LB_TEXT_INVALID_RESPONSE", 'Server returned an invalid response, please contact support.');
define("LB_TEXT_VERIFIED_RESPONSE", 'Verified! Thanks for purchasing.');
define("LB_TEXT_PREPARING_MAIN_DOWNLOAD", 'Preparing to download main update...');
define("LB_TEXT_MAIN_UPDATE_SIZE", 'Main Update size:');
define("LB_TEXT_DONT_REFRESH", '(Please do not refresh the page).');
define("LB_TEXT_DOWNLOADING_MAIN", 'Downloading main update...');
define("LB_TEXT_UPDATE_PERIOD_EXPIRED", 'Your update period has ended or your license is invalid, please contact support.');
define("LB_TEXT_UPDATE_PATH_ERROR", 'Folder does not have write permission or the update file path could not be resolved, please contact support.');
define("LB_TEXT_MAIN_UPDATE_DONE", 'Main update files downloaded and extracted.');
define("LB_TEXT_UPDATE_EXTRACTION_ERROR", 'Update zip extraction failed.');
define("LB_TEXT_PREPARING_SQL_DOWNLOAD", 'Preparing to download SQL update...');
define("LB_TEXT_SQL_UPDATE_SIZE", 'SQL Update size:');
define("LB_TEXT_DOWNLOADING_SQL", 'Downloading SQL update...');
define("LB_TEXT_SQL_UPDATE_DONE", 'SQL update files downloaded.');
define("LB_TEXT_UPDATE_WITH_SQL_IMPORT_FAILED", 'Application was successfully updated but automatic SQL importing failed, please import the downloaded SQL file in your database manually.');
define("LB_TEXT_UPDATE_WITH_SQL_IMPORT_DONE", 'Application was successfully updated and SQL file was automatically imported.');
define("LB_TEXT_UPDATE_WITH_SQL_DONE", 'Application was successfully updated, please import the downloaded SQL file in your database manually.');
define("LB_TEXT_UPDATE_WITHOUT_SQL_DONE", 'Application was successfully updated, there were no SQL updates.');

if(!LB_API_DEBUG){
	@ini_set('display_errors', 0);
}

if((@ini_get('max_execution_time')!=='0')&&(@ini_get('max_execution_time'))<600){
	@ini_set('max_execution_time', 600);
}
@ini_set('memory_limit', '256M');

class HRPayrollLic {

	private $product_id;
	private $api_url;
	private $api_key;
	private $api_language;
	private $current_version;
	private $verify_type;
	private $verification_period;
	private $current_path;
	private $root_path;
	private $license_file;

	public function __construct(){ 
		$this->product_id = 'F38A4CAC';
		$this->api_url = $this->decrypt('o1CMEVwBlKjeV42JHCwfd7i6DxIp/+JUMV23mhkcpY1m3CMRGqYlXW0P3MP56wKJDMw61UYaKCWqill3oZrFLVKC1G5w0nX1Nw7zGr6dsLCkAqa8JbAP1b/Bw4GAEnSO');
		$this->api_key = '801929B0DF7AFE6F02C6';
		$this->api_language = 'english';
		$this->current_version = 'v1.0.0';
		$this->verify_type = 'envato';
		$this->verification_period = 180;
		$this->current_path = realpath(__DIR__);
		$this->root_path = realpath($this->current_path.'/..');
		$this->license_file = $this->current_path.'/.lic';
		$this->check_interval_file = $this->current_path.'/.licint';
	}

	/**
	 * check local license_exist
	 * @return bool
	 */
	public function check_local_license_exist(){
		return true; // Sempre retorna que a licença existe
	}

	/**
	 * get current version
	 * @return string
	 */
	public function get_current_version(){
		return $this->current_version;
	}

	/**
	 * call api 
	 * @param  string $method 
	 * @param  string $url   
	 * @param  string $data 
	 * @return json
	 */
	private function call_api($method, $url, $data = null){
		// Ignora a chamada da API e retorna um status verdadeiro
		$rs = array(
			'status' => TRUE, 
			'message' => LB_TEXT_VERIFIED_RESPONSE
		);
		return json_encode($rs);
	}

	/**
	 * check connection
	 * @return json
	 */
	public function check_connection(){
		$rs = array(
			'status' => TRUE,
			'message' => LB_TEXT_VERIFIED_RESPONSE
		);
		return $rs;
	}

	/**
	 * get latest version
	 * @return json
	 */
	public function get_latest_version(){
		$rs = array(
			'status' => TRUE,
			'version' => $this->current_version
		);
		return $rs;
	}

	/**
	 * activate license
	 * @param  string  $license
	 * @param  string  $client
	 * @param  string  $create_lic
	 * @return array
	 */
	public function activate_license($license, $client, $create_lic = true){
		// Sempre retorna status verdadeiro para ativação
		$response = array(
			'status' => TRUE,
			'message' => LB_TEXT_VERIFIED_RESPONSE
		);
		return $response;
	}

	/**
	 * verify license
	 * @param  boolean $time_based_check
	 * @param  boolean $license  
	 * @param  boolean $client   
	 * @return array
	 */
	public function verify_license($time_based_check = false, $license = false, $client = false){
		$res = array('status' => TRUE, 'message' => LB_TEXT_VERIFIED_RESPONSE);
		return $res;
	}

	/**
	 * deactivate license 
	 * @param  boolean $license 
	 * @param  boolean $client  
	 * @return json
	 */
	public function deactivate_license($license = false, $client = false){
		$response = array(
			'status' => TRUE,
			'message' => 'License deactivated successfully.'
		);
		return $response;
	}

	/**
	 * check_update
	 * @return json
	 */
	public function check_update(){
		$response = array(
			'status' => TRUE,
			'version' => $this->current_version
		);
		return $response;
	}

	/**
	 * download_update
	 * @param  [type]  $update_id 
	 * @param  [type]  $type         
	 * @param  [type]  $version      
	 * @param  boolean $license      
	 * @param  boolean $client       
	 * @param  boolean $db_for_import
	 * @return object               
	 */
	public function download_update($update_id, $type, $version, $license = false, $client = false, $db_for_import = false){ 
		// Mantém a lógica original de download de atualização
		$data_array = array();
		ob_end_flush(); 
		ob_implicit_flush(true);  
		$version = str_replace(".", "_", $version);
		ob_start();
		$source_size = $this->api_url."api/get_update_size/main/".$update_id; 
		echo LB_TEXT_PREPARING_MAIN_DOWNLOAD."<br>";
		if(LB_SHOW_UPDATE_PROGRESS){echo '<script>document.getElementById(\'prog\').value = 1;</script>';}
		ob_flush();
		echo LB_TEXT_MAIN_UPDATE_SIZE." ".$this->get_remote_filesize($source_size)." ".LB_TEXT_DONT_REFRESH."<br>";
		if(LB_SHOW_UPDATE_PROGRESS){echo '<script>document.getElementById(\'prog\').value = 5;</script>';}
		ob_flush();
		$temp_progress = '';
		$ch = curl_init();
		$source = $this->api_url."api/download_update/main/".$update_id; 
		curl_setopt($ch, CURLOPT_URL, $source);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_array);
		$this_server_name = getenv('SERVER_NAME')?:
			$_SERVER['SERVER_NAME']?:
			getenv('HTTP_HOST')?:
			$_SERVER['HTTP_HOST'];
		$this_http_or_https = ((
			(isset($_SERVER['HTTPS'])&&($_SERVER['HTTPS']=="on"))or
			(isset($_SERVER['HTTP_X_FORWARDED_PROTO'])and
				$_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
		)?'https://':'http://');
		$this_url = $this_http_or_https.$this_server_name.$_SERVER['REQUEST_URI'];
		$this_ip = getenv('SERVER_ADDR')?:
			$_SERVER['SERVER_ADDR']?:
			$this->get_ip_from_third_party()?:
			gethostbyname(gethostname());
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'LB-API-KEY: '.$this->api_key, 
			'LB-URL: '.$this_url, 
			'LB-IP: '.$this_ip, 
			'LB-LANG: '.$this->api_language)
		);
		if(LB_SHOW_UPDATE_PROGRESS){curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, array($this, 'progress'));}
		if(LB_SHOW_UPDATE_PROGRESS){curl_setopt($ch, CURLOPT_NOPROGRESS, false);}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30); 
		echo LB_TEXT_DOWNLOADING_MAIN."<br>";
		if(LB_SHOW_UPDATE_PROGRESS){echo '<script>document.getElementById(\'prog\').value = 10;</script>';}
		ob_flush();
		$data = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if($http_status != 200){
			if($http_status == 401){
				curl_close($ch);
				exit("<br>".LB_TEXT_UPDATE_PERIOD_EXPIRED);
			}else{
				curl_close($ch);
				exit("<br>".LB_TEXT_INVALID_RESPONSE);
			}
		}
		curl_close($ch);
		$destination = $this->root_path."/update_main_".$version.".zip"; 
		$file = fopen($destination, "w+");
		if(!$file){
			exit("<br>".LB_TEXT_UPDATE_PATH_ERROR);
		}
		fputs($file, $data);
		fclose($file);
		if(LB_SHOW_UPDATE_PROGRESS){echo '<script>document.getElementById(\'prog\').value = 65;</script>';}
		ob_flush();
		$zip = new ZipArchive;
		$res = $zip->open($destination);
		if($res === TRUE){
			$zip->extractTo($this->root_path."/"); 
			$zip->close();
			unlink($destination);
			echo LB_TEXT_MAIN_UPDATE_DONE."<br><br>";
			if(LB_SHOW_UPDATE_PROGRESS){echo '<script>document.getElementById(\'prog\').value = 75;</script>';}
			ob_flush();
		}else{
			echo LB_TEXT_UPDATE_EXTRACTION_ERROR."<br><br>";
			ob_flush();
		}
		if($type == true){
			$source_size = $this->api_url."api/get_update_size/sql/".$update_id; 
			echo LB_TEXT_PREPARING_SQL_DOWNLOAD."<br>";
			ob_flush();
			echo LB_TEXT_SQL_UPDATE_SIZE." ".$this->get_remote_filesize($source_size)." ".LB_TEXT_DONT_REFRESH."<br>";
			if(LB_SHOW_UPDATE_PROGRESS){echo '<script>document.getElementById(\'prog\').value = 85;</script>';}
			ob_flush();
			$temp_progress = '';
			$ch = curl_init();
			$source = $this->api_url."api/download_update/sql/".$update_id;
			curl_setopt($ch, CURLOPT_URL, $source);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_array);
			$this_server_name = getenv('SERVER_NAME')?:
				$_SERVER['SERVER_NAME']?:
				getenv('HTTP_HOST')?:
				$_SERVER['HTTP_HOST'];
			$this_http_or_https = ((
				(isset($_SERVER['HTTPS'])&&($_SERVER['HTTPS']=="on"))or
				(isset($_SERVER['HTTP_X_FORWARDED_PROTO'])and
					$_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
			)?'https://':'http://');
			$this_url = $this_http_or_https.$this_server_name.$_SERVER['REQUEST_URI'];
			$this_ip = getenv('SERVER_ADDR')?:
				$_SERVER['SERVER_ADDR']?:
				$this->get_ip_from_third_party()?:
				gethostbyname(gethostname());
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'LB-API-KEY: '.$this->api_key, 
				'LB-URL: '.$this_url, 
				'LB-IP: '.$this_ip, 
				'LB-LANG: '.$this->api_language)
			); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			echo LB_TEXT_DOWNLOADING_SQL."<br>";
			if(LB_SHOW_UPDATE_PROGRESS){echo '<script>document.getElementById(\'prog\').value = 90;</script>';}
			ob_flush();
			$data = curl_exec($ch);
			$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($http_status!=200){
				curl_close($ch);
				exit(LB_TEXT_INVALID_RESPONSE);
			}
			curl_close($ch);
			$destination = $this->root_path."/update_sql_".$version.".sql"; 
			$file = fopen($destination, "w+");
			if(!$file){
				exit(LB_TEXT_UPDATE_PATH_ERROR);
			}
			fputs($file, $data);
			fclose($file);
			echo LB_TEXT_SQL_UPDATE_DONE."<br><br>";
			if(LB_SHOW_UPDATE_PROGRESS){echo '<script>document.getElementById(\'prog\').value = 95;</script>';}
			ob_flush();
			if(is_array($db_for_import)){
				if(!empty($db_for_import["db_host"])&&!empty($db_for_import["db_user"])&&!empty($db_for_import["db_name"])){
					$db_host = strip_tags(trim($db_for_import["db_host"]));
            		$db_user = strip_tags(trim($db_for_import["db_user"]));
            		$db_pass = strip_tags(trim($db_for_import["db_pass"]));
            		$db_name = strip_tags(trim($db_for_import["db_name"]));
					$con = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);
					if(mysqli_connect_errno()){
						echo LB_TEXT_UPDATE_WITH_SQL_IMPORT_FAILED;
					}else{
						$templine = '';
						$lines = file($destination);
						foreach($lines as $line){
							if(substr($line, 0, 2) == '--' || $line == '')
								continue;
							$templine .= $line;
							$query = false;
							if(substr(trim($line), -1, 1) == ';'){
								$query = mysqli_query($con, $templine);
								$templine = '';
							}
						}
						@chmod($destination,0777);
						if(is_writeable($destination)){
							unlink($destination);
						}
						echo LB_TEXT_UPDATE_WITH_SQL_IMPORT_DONE;
					}
				}else{
					echo LB_TEXT_UPDATE_WITH_SQL_IMPORT_FAILED;
				}
			}else{
				echo LB_TEXT_UPDATE_WITH_SQL_DONE;
			}
			if(LB_SHOW_UPDATE_PROGRESS){echo '<script>document.getElementById(\'prog\').value = 100;</script>';}
			ob_flush();
		}else{
			if(LB_SHOW_UPDATE_PROGRESS){echo '<script>document.getElementById(\'prog\').value = 100;</script>';}
			echo LB_TEXT_UPDATE_WITHOUT_SQL_DONE;
			ob_flush();
		}
		ob_end_flush(); 
	}

	/**
	 * progress description
	 * @param  string $resource     
	 * @param  string $download_size
	 * @param  string $downloaded   
	 * @param  string $upload_size  
	 * @param  string $uploaded     
	 * @return object               
	 */
	private function progress($resource, $download_size, $downloaded, $upload_size, $uploaded){
		static $prev = 0;
		if($download_size == 0){
			$progress = 0;
		}else{
			$progress = round( $downloaded * 100 / $download_size );
		}
		if(($progress!=$prev) && ($progress == 25)){
			$prev = $progress;
			echo '<script>document.getElementById(\'prog\').value = 22.5;</script>';
			ob_flush();
		}
		if(($progress!=$prev) && ($progress == 50)){
			$prev=$progress;
			echo '<script>document.getElementById(\'prog\').value = 35;</script>';
			ob_flush();
		}
		if(($progress!=$prev) && ($progress == 75)){
			$prev=$progress;
			echo '<script>document.getElementById(\'prog\').value = 47.5;</script>';
			ob_flush();
		}
		if(($progress!=$prev) && ($progress == 100)){
			$prev=$progress;
			echo '<script>document.getElementById(\'prog\').value = 60;</script>';
			ob_flush();
		}
	}

	/**
	 * get_ip_from_third_party
	 * @return object 
	 */
	private function get_ip_from_third_party(){
		$curl = curl_init ();
		curl_setopt($curl, CURLOPT_URL, "http://ipecho.net/plain");
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10); 
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	/**
	 * get remote filesize
	 * @param  string $url 
	 * @return int      
	 */
	private function get_remote_filesize($url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_HEADER, TRUE);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_NOBODY, TRUE);
		$this_server_name = getenv('SERVER_NAME')?:
			$_SERVER['SERVER_NAME']?:
			getenv('HTTP_HOST')?:
			$_SERVER['HTTP_HOST'];
		$this_http_or_https = ((
			(isset($_SERVER['HTTPS'])&&($_SERVER['HTTPS']=="on"))or
			(isset($_SERVER['HTTP_X_FORWARDED_PROTO'])and
				$_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
		)?'https://':'http://');
		$this_url = $this_http_or_https.$this_server_name.$_SERVER['REQUEST_URI'];
		$this_ip = getenv('SERVER_ADDR')?:
			$_SERVER['SERVER_ADDR']?:
			$this->get_ip_from_third_party()?:
			gethostbyname(gethostname());
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'LB-API-KEY: '.$this->api_key, 
			'LB-URL: '.$this_url, 
			'LB-IP: '.$this_ip, 
			'LB-LANG: '.$this->api_language)
		);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30); 
		$result = curl_exec($curl);
		$filesize = curl_getinfo($curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
		if ($filesize){
			switch ($filesize){
				case $filesize < 1024:
					$size = $filesize .' B'; break;
				case $filesize < 1048576:
					$size = round($filesize / 1024, 2) .' KB'; break;
				case $filesize < 1073741824:
					$size = round($filesize / 1048576, 2) . ' MB'; break;
				case $filesize < 1099511627776:
					$size = round($filesize / 1073741824, 2) . ' GB'; break;
			}
			return $size; 
		}
	}

	/**
     * decrypt
     * @param  string $data
     * @return string
     */
    private function decrypt($data) {
        $key = 'greentech_solutions';
        $c = base64_decode($data);
        $ivlen = openssl_cipher_iv_length($cipher = 'AES-128-CBC');
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
        if (hash_equals($hmac, $calcmac))
        {
            return $original_plaintext;
        }
    }
}
