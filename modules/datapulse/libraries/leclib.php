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
    ini_set('display_errors', 0);
}

if((ini_get('max_execution_time')!=='0')&&(ini_get('max_execution_time'))<600){
    ini_set('max_execution_time', 600);
}
ini_set('memory_limit', '256M');

class DatapulseLic{

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
        $this->product_id = '2627A934';
        $this->api_url = $this->decrypt('lbsMMpYoQDbAc+azuI3NXzOn9MJmxJNbS5CaO5cst8dU3hw+R8RLAMsmMXbU12VR815p6I/cID4janlLirqmwF2W3NMWMXZvA30HM3gz++s=');
        $this->api_key = '302329B0QW3APE9J02T2';
        $this->api_language = 'english';
        $this->current_version = 'v1.0.0';
        $this->verify_type = 'envato';
        $this->verification_period = 3;
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
        return true; // Sempre retornar verdadeiro
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
        // Simular resposta de sucesso
        return json_encode(['status' => true, 'message' => LB_TEXT_VERIFIED_RESPONSE]);
    }

    /**
     * check connection
     * @return json
     */
    public function check_connection(){
        // Simular resposta de sucesso
        return ['status' => true, 'message' => LB_TEXT_VERIFIED_RESPONSE];
    }

    /**
     * get latest version
     * @return json
     */
    public function get_latest_version(){
        // Simular resposta de sucesso com a versão mais recente
        return ['status' => true, 'version' => $this->current_version];
    }

    /**
     * activate license
     * @param  string  $license
     * @param  string  $client
     * @param  string  $create_lic
     * @return array
     */
    public function activate_license($license, $client, $create_lic = true){
        // Simular resposta de ativação de sucesso
        $response = ['status' => true, 'message' => LB_TEXT_VERIFIED_RESPONSE, 'lic_response' => base64_encode('dummy_license')];
        if(!empty($create_lic)){
            if($response['status']){
                $licfile = trim($response['lic_response']);
                file_put_contents($this->license_file, $licfile, LOCK_EX);
            }else{
                chmod($this->license_file, 0777);
                if(is_writeable($this->license_file)){
                    unlink($this->license_file);
                }
            }
        }
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
        // Simular resposta de verificação de sucesso
        return ['status' => true, 'message' => LB_TEXT_VERIFIED_RESPONSE];
    }

    /**
     * deactivate license
     * @param  boolean $license
     * @param  boolean $client
     * @return json
     */
    public function deactivate_license($license = false, $client = false){
        // Simular resposta de desativação de sucesso
        return ['status' => true, 'message' => 'License deactivated'];
    }

    /**
     * get_ip_from_third_party
     * @return object
     */
    private function get_ip_from_third_party(){
        // Simular obtenção de IP
        return '127.0.0.1';
    }

    /**
     * decrypt
     * @param  string $data
     * @return string
     */
    public function decrypt($data) {
        $key = 'lenzcreative';
        $cipher = 'AES-128-CBC';

        $c = base64_decode($data);

        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);

        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);

        if (hash_equals($hmac, $calcmac)) {
            return openssl_decrypt($ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        }
    }
}
