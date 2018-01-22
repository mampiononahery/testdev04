<?php

/**
 * QR_BarCode - Barcode QR Code Image Generator
 * @author CodexWorld
 * @url http://www.codexworld.com
 * @license http://www.codexworld.com/license/
 */
class QR_BarCode{
    // Google Chart API URL
    private $googleChartAPI = 'https://chart.googleapis.com/chart';
    // Code data
    private $codeData;

    /**
     * URL QR code
     * @param string $url
     */
    public function url($url = null){
        $this->codeData = preg_match("#^https?\:\/\/#", $url) ? $url : "http://{$url}";
    }

    /**
     * Text QR code
     * @param string $text
     */
    public function text($text){
        $this->codeData = $text;
    }

    /**
     * Email address QR code
     *
     * @param string $email
     * @param string $subject
     * @param string $message
     */
    public function email($email = null, $subject = null, $message = null) {
        $this->codeData = "MATMSG:TO:{$email};SUB:{$subject};BODY:{$message};;";
    }

    /**
     * Phone QR code
     * @param string $phone
     */
    public function phone($phone){
        $this->codeData = "TEL:{$phone}";
    }

    /**
     * SMS QR code
     *
     * @param string $phone
     * @param string $text
     */
    public function sms($phone = null, $msg = null) {
        $this->codeData = "SMSTO:{$phone}:{$msg}";
    }

    /**
     * VCARD QR code
     *
     * @param string $name
     * @param string $address
     * @param string $phone
     * @param string $email
     */
    public function contact($name = null, $address = null, $phone = null, $email = null) {
        $this->codeData = "MECARD:N:{$name};ADR:{$address};TEL:{$phone};EMAIL:{$email};;";
    }

    /**
     * Content (gif, jpg, png, etc.) QR code
     *
     * @param string $type
     * @param string $size
     * @param string $content
     */
    public function content($type = null, $size = null, $content = null) {
        $this->codeData = "CNTS:TYPE:{$type};LNG:{$size};BODY:{$content};;";
    }

    /**
     * Generate QR code image
     *
     * @param int $size
     * @param string $filename
     * @return bool
     */
    public function qrCode($size = 200, $filename = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->googleChartAPI);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "chs={$size}x{$size}&cht=qr&chl=" . urlencode($this->codeData) . "&choe=UTF-8");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $img = curl_exec($ch);
        curl_close($ch);

        if($img) {
            if($filename) {
                if(!preg_match("#\.png$#i", $filename)) {
                    $filename .= ".png";
                }

                return file_put_contents($filename, $img);
            } else {
                header("Content-type: image/png");
                print $img;
                return true;
            }
        }
        return false;
    }

    function incrementalHash($str, $len = 9){
        $charset = $str;
        $base = strlen($charset);
        $result = '';

        $now = explode(' ', microtime())[1];
        while ($now >= $base){
            $i = $now % $base;
            $result = $charset[$i] . $result;
            $now /= $base;
        }
        return substr($result, -$len);
    }

    /**
     * Generate QR code activity
     *
     * @param string $prestation
     * @param string $prestataire
     * @param string $client
     * @param string $quantity
     * @param string $dt
     * @param string $hour
     */
    public function qrCodeActivity($prestation, $prestataire, $client, $quantity, $dt, $hour)
    {
        $this->codeData = "PRESTATION:NAME:{$prestation};PRESTATAIRE:NAME:{$prestataire};CLIENT:{$client};QTY:{$quantity};DT:{$dt};HR:{$hour};;" ;
    }
}

$qrCode = new QR_BarCode() ;
//$qrCode->text('raharinivoson+fehiniaina') ;
//$qrCode->qrCode() ;
$prestation = 'Base Nautique' ;
$prestataire = 'Jet Ski' ;
$client = 'fehiniaina' ;
$quantity = 2 ;
$date = new \DateTime('now') ;
$dt = strtotime($date->format('Y-m-d'));
$hour = 13 ;


$str = "PRESTATION:NAME:{$prestation};PRESTATAIRE:NAME:{$prestataire};CLIENT:{$client};QTY:{$quantity};DT:{$dt};HR:{$hour};;" ;
echo $str . "\n" ;
$str = base64_encode(hash('sha1', $str)) ;
echo substr($str, 5, 14) ;

//$qrCode->qrCodeActivity($prestation, $prestataire, $client, $quantity, $dt, $hour) ;
//$qrCode->qrCode() ;
