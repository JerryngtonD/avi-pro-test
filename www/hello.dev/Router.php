<?php class Router
{
    private $request;

    /**
    * Constructor
    *
    * Initializes the Rou with the request object
    *
    * @param Request $request
    */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
    * handleGetId
    *
    * Returns the view with the generated id
    *
    * @return string or null
    */
    public function handleGetId() : ?string
    {
        $url_info = parse_url($_SERVER['REQUEST_URI']);
        $method_type = $_SERVER['REQUEST_METHOD'];
        $path = $url_info['path'];
        $query = $url_info['query'];

        if ($path == '/api/generate/' and $method_type == 'POST') {
            $this->request->generateUniqPair();
            $template = '<h3>Твой уникальный id: $id </h3>';
            return strtr($template, array( '$id' => $this->request->getRequestId()));
        }
        return null;
    }

    /**
    * handleGetId
    *
    * Returns the view with the generated id and generated value
    *
    * @return string or null
    */
    public function handleGetValueOnId() : ?string
    {
        $url_info = parse_url($_SERVER['REQUEST_URI']);
        $method_type = $_SERVER['REQUEST_METHOD'];
        $path = $url_info['path'];
        $query = $url_info['query'];

        if ($path == '/api/retrieve' and isset($query) and !empty($_GET['id']) and $method_type == 'GET') {
            $template = '
          <h3>Твой уникальный id: $id </h3>
          <h3>Значение по id: $response_value </h3>
          ';
            return strtr($template, array('$id' => $this->request->getRequestId(),
           '$response_value' => $this->request->getResponseValue()));
        }
        return null;
    }
}
