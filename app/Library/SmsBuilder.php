<?php

// namespace App\Library;

// use smpp\{Address, SMPP, Client as SmppClient, transport\Socket};
// use Exception;

// class SmsBuilder
// {
//     const DEFAULT_SENDER = 'Codeglen';
//     protected Socket $transport;
//     protected SmppClient $smppClient;
//     protected bool $debug = true;
//     protected Address $from;
//     protected $to;
//     protected string $login;
//     protected string $password;
//     protected mixed $tags;

//     public function __construct(
//         string $address,
//         int $port,
//         string $login,
//         string $password,
//         mixed $tags,
//         int $timeout = 10000,
//         bool $debug = false
//     ) {
//         SmppClient::$smsNullTerminateOctetstrings = false;
//         Socket::$forceIpv4 = true;
//         SmppClient::$csmsMethod = SmppClient::CSMS_8BIT_UDH;
//         SmppClient::$smsRegisteredDeliveryFlag = SMPP::REG_DELIVERY_SMSC_BOTH;
//         SmppClient::$smsNullTerminateOctetstrings = false;

//         $this->transport = new Socket(['10.32.9.99'], 5016);
//         $this->transport->setRecvTimeout($timeout);
//         $this->transport->setSendTimeout($timeout);
//         $this->smppClient = new SmppClient($this->transport);

//         $this->smppClient->debug = $debug;
//         $this->transport->debug = $debug;

//         $this->login = $login;
//         $this->password = $password;

//         $this->tags = $tags;

//         $this->from = new Address(self::DEFAULT_SENDER, SMPP::TON_ALPHANUMERIC);
//         // Set a default recipient. You should modify this as needed.
//         $this->setRecipient('123456789', SMPP::TON_INTERNATIONAL);
//     }

//     public function setSender($sender, $ton): SmsBuilder
//     {
//         return $this->setAddress($sender, 'from', $ton);
//     }

//     public function setRecipient($address, $ton): SmsBuilder
//     {
//         return $this->setAddress($address, 'to', $ton);
//     }

//     protected function setAddress($address, string $type, int $ton = SMPP::TON_UNKNOWN, int $npi = SMPP::NPI_UNKNOWN): SmsBuilder
//     {
//         if ($ton === SMPP::TON_INTERNATIONAL) {
//             $npi = SMPP::NPI_E164;
//         }
//         $this->$type = new Address($address, $ton, $npi);

//         return $this;
//     }

//     public function sendMessage(string $message, bool $unicode = false): bool|string
//     {
//         try {
//             $this->transport->open();
//             // $this->smppClient->bindTransceiver('VasTests', 'VasTests');
            
//             $this->smppClient->bindTransceiver($this->login, $this->password);
    
//             if ($unicode) {
//                 $output = $this->smppClient->sendSMS($this->from, $this->to, $message, $this->tags, SMPP::DATA_CODING_UCS2);
//             } else {
//                 $output = $this->smppClient->sendSMS($this->from, $this->to, $message, $this->tags);
//             }
    
//             // Wait for the response PDU
//             $response = $this->smppClient->readPDU();
    
//             // Print the received response for debugging
//             print_r($response);
    
//             if (isset($response['status'])) {
//                 return $response['status'] == 0;
//             } else {
//                 return "Error: Invalid or no response from SMPP server.";
//             }
//         } catch (Exception $e) {
//             // Log or handle the exception as needed
//             return "Error: " . $e->getMessage();
//         } finally {
//             // Close the connection in a finally block to ensure it happens even if an exception occurs
//             $this->smppClient->close();
//         }
//     }





    // public function sendMessage(string $message, bool $unicode = false): bool|string
    // {
    //     try {
    //         $this->transport->open();
    //         $this->smppClient->bindReceiver('bekitest', 'bekitest');
    
    //         // if ($unicode) {
    //         //     $output = $this->smppClient->sendSMS($this->from, $this->to, $message, $this->tags, SMPP::DATA_CODING_UCS2);
    //         // } else {
    //         //     $output = $this->smppClient->sendSMS($this->from, $this->to, $message, $this->tags);
    //         // }
    //         $output = $this->smppClient->sendSMS('251700405140', '251700405140','Hey');
    //         return $output;
    //     } catch (Exception $e) {
    //         // Log or handle the exception as needed
    //         return "eError: " . $e->getMessage();
    //     } finally {
    //         // Close the connection in a finally block to ensure it happens even if an exception occurs
    //         $this->smppClient->close();
    //     }
    // }
    

    

// }








































namespace App\Library;

use smpp\{Address, SMPP, Client as SmppClient, transport\Socket};
use Exception;

class SmsBuilder
{


    const DEFAULT_SENDER = 'VAS';
    protected Socket     $transport;
    protected SmppClient $smppClient;
    protected bool       $debug = false;
    protected Address    $from;
    protected            $to;
    protected string     $login;
    protected string     $password;
    protected mixed      $tags;

    /**
     * SmsBuilder constructor.
     *
     * @param  string  $address  SMSC IP
     * @param  int  $port  SMSC port
     * @param  string  $login
     * @param  string  $password
     * @param  array  $tags
     * @param  int  $timeout  timeout of reading PDU in milliseconds
     * @param  bool  $debug  - debug flag when true output additional info
     */
    public function __construct(
            string $address,
            int $port,
            string $login,
            string $password,
            mixed $tags,
            int $timeout = 10000,
            bool $debug = false
    ) {

        SmppClient::$smsNullTerminateOctetstrings = false;
        Socket::$forceIpv4                        = true;
        SmppClient::$csmsMethod                   = SmppClient::CSMS_8BIT_UDH;
        SmppClient::$smsRegisteredDeliveryFlag    = SMPP::REG_DELIVERY_SMSC_BOTH;
        SmppClient::$smsNullTerminateOctetstrings = false;

        // $this->transport = new Socket([$address], $port);
        $this->transport = new Socket(['10.32.9.99'], 5016);
        $this->transport->setRecvTimeout($timeout);
        $this->transport->setSendTimeout($timeout);
        $this->smppClient = new SmppClient($this->transport);

        // Activate binary hex-output of server interaction
        $this->smppClient->debug = $debug;
        $this->transport->debug  = $debug;

        $this->login    = $login;
        $this->password = $password;

        $this->tags = $tags;

        $this->from = new Address(self::DEFAULT_SENDER, SMPP::TON_ALPHANUMERIC);
    }

    /**
     * @param $sender
     * @param $ton
     *
     * @return $this
     * @throws Exception
     */
    public function setSender($sender, $ton): SmsBuilder
    {
        return $this->setAddress($sender, 'from', $ton);
    }

    /**
     * @param $address
     * @param $ton
     *
     * @return $this
     * @throws Exception
     */
    public function setRecipient($address, $ton): SmsBuilder
    {
        return $this->setAddress($address, 'to', $ton);
    }

    /**
     * @param        $address
     * @param  string  $type
     * @param  int  $ton
     * @param  int  $npi
     *
     * @return $this
     * @throws Exception
     */
    protected function setAddress($address, string $type, int $ton = SMPP::TON_UNKNOWN, int $npi = SMPP::NPI_UNKNOWN): SmsBuilder
    {
        // some example of data preparation
        if ($ton === SMPP::TON_INTERNATIONAL) {
            $npi = SMPP::NPI_E164;
        }
        $this->$type = new Address($address, $ton, $npi);

        return $this;
    }

    /**
     * send smpp message
     *
     * @param  string  $message
     * @param  bool  $unicode
     *
     * @return false|string
     * @throws Exception
     */
    public function sendMessage(string $message, bool $unicode = false): bool|string
    {
        $this->transport->open();
        // $this->smppClient->bindTransceiver($this->login, $this->password);
        $this->smppClient->bindReceiver('bekitest', 'bekitest');

        if ($unicode) {
            // strongly recommend use SMPP::DATA_CODING_UCS2 as default encoding in project to prevent problems with non latin symbols
            $output = $this->smppClient->sendSMS($this->from, $this->to, $message, $this->tags, SMPP::DATA_CODING_UCS2);
        } else {
            $output = $this->smppClient->sendSMS($this->from, $this->to, $message, $this->tags);
        }
        $response=$this->smppClient->readPDU();

        return $response;
    }

}
