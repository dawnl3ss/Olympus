<?php

class WebSocket {

    /** @var string $adress */
    private $adress;

    /** @var int $port */
    private $port;

    /** @var $socket */
    public $socket;

    public function __construct(string $adress, int $port){
        $this->adress = $adress;
        $this->port = $port;
    }

    /**
     * @return false|resource
     */
    public function create_websocket(){
        $this->socket = socket_create();
        return $this->socket;
    }

    public function listening_socket(){
    }
}