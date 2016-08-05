<?php

require_once('vendor/autoload.php');

class Blunderbuss {

    /* Relay Options */
    protected $host = false;
    protected $user = null;
    protected $pass = null;
    protected $ssl = false;
    protected $port = 25;

    protected $_twig = null;
    protected $_recipients = array();
    protected $_defaults = array();

    protected $_responses = array();

    protected $lastError = false;

    public function __construct($params = array()) {
        foreach ($params as $k => $v) {
            // Blind assignment, because really we only use what we need later
            if ($v) {
                $this->$k = $v;
            }
        }

        // If host has a port on it, split that off
        if (strpos($this->host, ':') !== false) {
            list($this->host, $this->port) = explode(':', $this->host);
        }

        // Create our SMTP transport
        $this->_smtp = new \Zend\Mail\Transport\Smtp();
        $opts = array (
            'host' => $this->host,
            'port' => $this->port,
        );
        if (!empty($this->user) && !empty($this->pass)) {
            $opts['auth'] = 'login';
            $opts['username'] = $this->user;
            $opts['password'] = $this->pass;
        }
        if ($this->port == 587 || $this->ssl) {
            $opts['ssl'] = 'tls';
        }
        $options = new \Zend\Mail\Transport\SmtpOptions($opts);
        $this->_smtp->setOptions($options);

        return $this;
    }

    public function load($json) {
        $config = json_decode($json);
        foreach ($config->defaults as $key => $val) {
            $this->_defaults[$key] = $val;
        }
        $this->_recipients = $config->recipients;

        // Work-around for Twig carriage-return stripping
        $config->template = str_replace("\r\n", '{{ CRLF }}', $config->template);
        $this->_defaults['CRLF'] = "\r\n";

        // Load Twig template
        try {
            $loader = new Twig_Loader_Array(array(
                'message' => $config->template
            ));
            $this->_twig = new Twig_Environment($loader);
        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            return false;
        }

        return $this;
    }

    public function send() {

        foreach ($this->_recipients as $i => $r) {
            // Build replacements array
            $re = array();

            $repeat = 1;
            $opt = '!repeat';
            if (isset($r->$opt)) {
                $repeat = $r->$opt;
                unset($r->$opt);
            }
            
            foreach ($r as $k => $v) {
                $re[$k] = $v;
            }
            $re = array_merge($this->_defaults, $re);
            $src = $this->_twig->render('message', $re);
            
            $email = \Zend\Mail\Message::fromString($src);
            $toAddrs = $email->getTo();
            $toAddr = array();
            foreach ($toAddrs as $to) {
                $toAddr[] = $to->getEmail();
            }
            
            for ($j = 0; $j < $repeat; $j++) {
                $this->_smtp->send($email);
                $response = $this->_smtp->getConnection()->getResponse();
                if ($this->streamOutput === true) {
                    echo ($i+1) . '.' . ($j+1) . ": 'to' => " . implode(',', $toAddr) . ", 'response' => " . trim($response[0]) . "\n";
                    ob_flush();
                    flush();
                } else {
                    $this->_responses["$i.$j"] = array( 'to' => implode(',', $toAddr), 'response' => $response[0]);
                }
            }
        }

        return $this;
    }

    public function getResponses() {
        return $this->_responses;
    }

}