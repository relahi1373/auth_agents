<?php
/**
 * download latest posts from the Wordpress blog
 * - will only return 3 latest posts with a $tag homepage by default
 *
 * you will need PHP Curl extension - I'm too lazy to use native php sockets :)
 * and also xmlrpc so please:
 *
 * apt-get install php5-curl php5-xmlrpc
 *
 * @see http://wp.tutsplus.com/tutorials/creative-coding/xml-rpc-in-wordpress/
 * @version 2013-10-10
 */
class WordPressClient {
    var $wp_username;
    var $wp_password;
    var $wp_xmlrpc_url;
    public function __construct($url = '', $username = '', $password = '')
    {
        $this->wp_username = $username;
        $this->wp_password = $password;
        $this->wp_xmlrpc_url = $url;
        if (!function_exists('xmlrpc_encode_request')) {
            trigger_error(__METHOD__.'(): xmlrpc_encode_request() function is not defined. Please turn on the xmlrpc extension.');
        }
    }
    public function send_request($requestname, $params)
    {
        // does not work?!
        $options = array('encoding' => 'utf-8');
        $request = xmlrpc_encode_request($requestname, $params, $options);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $this->wp_xmlrpc_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);

        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml; encoding="UTF-8"'));

        $results = curl_exec($ch);
        if (!$results && substr($_SERVER['HTTP_HOST'], 0, 3) !== 'www') {
            echo __METHOD__.'(): curl error: '.print_r(curl_error($ch), true).' on '.$this->wp_xmlrpc_url
                .': '.print_r($request, true).PHP_EOL;
        }
        //curl_close($ch);
        return iconv('iso-8859-1', 'utf-8', $results);
    }
    function say_hello()
    {
        $params = array();
        return $this->send_request('demo.sayHello',$params);
    }
    function display_authors()
    {
        $params = array(0, $this->wp_username, $this->wp_password);
        return $this->send_request('wp.getAuthors',$params);
    }
    /**
     * Get posts by the tag.
     *
     * @see http://codex.wordpress.org/XML-RPC_WordPress_API/Posts
     */
    function get_posts_by_tag($tag, $limit = 3) {

        $filter = array(
            'number' => 20,
            'post_status' => 'publish',
            'post_type' => 'post',
            'orderby' => 'post_modified',
            'order' => 'desc'
        );
        $params = array(
            0, $this->wp_username, $this->wp_password, $filter
        );
        $raw = $this->send_request('wp.getPosts', $params);
        $data = xmlrpc_decode($raw);
        $return = array();
        if (empty($data)) {
            return array();
        }
        foreach ($data as $d) {

            foreach ($d['terms'] as $t) {

                if (strcasecmp($t['name'], $tag) === 0) {
                    $return[] = $d;
                    break;
                }
            }
            if (count($return) >= $limit) {
                return $return;
            }
        } // foreach
        return $return;
    } // function
}