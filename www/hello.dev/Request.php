<?php class Request
{
    private $uniq_pair;
    private $required_type;
    private $required_length;

    /**
    * Constructor
    *
    * Initializes the Request  with the uniq_pair on default
    */
    public function __construct()
    {
        $this->uniq_pair = array();
    }

    /**
    * getGUID
    *
    * returns string with GUID as value
    *
    * @return string
    */
    public function getGUID() : string
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double)microtime()*10000);
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = substr($charid, 0, 8)
                .substr($charid, 8, 4)
                .substr($charid, 12, 4)
                .substr($charid, 16, 4)
                .substr($charid, 20, 12);

            return $uuid;
        }
    }

    /**
    * generateUniqPair
    *
    * generates a pair of id and value
    *
    * @return void
    */
    public function generateUniqPair() : void
    {
        $url_info = parse_url($_SERVER['REQUEST_URI']);
        $method_type = $_SERVER['REQUEST_METHOD'];


        // each post generation request reset previous values
        if ($method_type == 'POST') {
            $this->uniq_pair = array();
            $this->required_type = $_POST['type'];
            $this->required_length = (int) $_POST['length'];
        }

        $request_id = uniqid();

        // by default, the value will be a hash of the key, and then we will
        // modify it according to the parameters in the request
        $response = sha1($request_id);

        // process the parameter of type wished value
        if ($this->required_type == 'string') {
            $response = strtolower(preg_replace('/[0-9_\/]+/', '', base64_encode($response)));
        } elseif ($this->required_type == 'digit') {
            $response = crc32($request_id);
        } elseif ($this->required_type == 'guid') {
            $response = $this->getGUID();
        }

        // process the parameter of length wished value
        if (empty($this->required_length)) {
            $this->uniq_pair[$request_id] = $response;
        } elseif (is_numeric($this->required_length)) {
            $this->uniq_pair[$request_id] = mb_strimwidth($response, 0, $this->required_length);
        }
    }

    /**
    * generateUniqPair
    *
    *  getter for getting the generated id
    *
    * @return string
    */
    public function getRequestId() : string
    {
        return array_keys($this->uniq_pair)[0];
    }

    /**
    * getResponseValue
    *
    * getter for getting the generated value on id
    *
    * @return string
    */
    public function getResponseValue() : string
    {
        return array_values($this->uniq_pair)[0];
    }
}
