<?php
namespace app\http;

use think\swoole\Server;

class Swoole extends Server
{
	protected $host = '127.0.0.1';
	protected $port = 9501;
	protected $option = [ 
		'worker_num'=> 4,
		'daemonize'	=> true,
		'backlog'	=> 128
	];

	public function onReceive($server, $fd, $from_id, $data)
	{
		$server->send($fd, 'Swoole22: '.$data);
    }
    
    
}
