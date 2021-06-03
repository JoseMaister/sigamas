<?php
	include_once('config.php');
	//include_once('conexion.php');
	// prevent the server from timing out
	set_time_limit(0);

	// include the web sockets server script (the server is started at the far bottom of this file)
	require 'class.PHPWebSocket.php';

	// when a client sends data to the server
	function wsOnMessage($clientID, $message, $messageLength, $binary) 
	{
		global $Server;
		$ip = long2ip( $Server->wsClients[$clientID][6] );

		// check if message length is 0
		if ($messageLength == 0) {
			$Server->wsClose($clientID);
			return;
		}

		//The speaker is the only person in the room. Don't let them feel lonely.
		if ( sizeof($Server->wsClients) == 1 )
			$Server->wsSend($clientID, "");
		else
			//Send the message to everyone but the person who said it
			foreach ( $Server->wsClients as $id => $client )
				//if ( $id != $clientID )
					//$Server->wsSend($id, "Visitor $clientID ($ip) said \"$message\"");
					//aqui recibimos la accion con los demas parametros e identificadores
					$Server->wsSend($id, $message);
	}


	// when a client connects
	function wsOnOpen($clientID)
	{
		global $Server;
		foreach ( $Server->wsClients as $id => $client )
		{
			if ( $id == $clientID ) //ENVIO AL USUARIO ACTUAL
			{
				$Server->wsSend($id, '{ "type" : "connect_db", "chat_server" : "' . $clientID . '" }');
			}
		}
	}

	// when a client closes or lost connection
	
	function wsOnClose($clientID, $status) {
		/*
			$ip = long2ip( $Server->wsClients[$clientID][6] );
		*/

		$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$sql = "UPDATE usuarios set chat_server = 0 where chat_server = $clientID";
		$conn->query($sql);

		global $Server;
		foreach ( $Server->wsClients as $id => $client )
		{
			$Server->wsSend($id, '{ "type" : "disconnect", "chat_server" : "' . $clientID . '", "query" : "'.$sql.'" }');
		}

		
		
	}

	$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$sql = "UPDATE usuarios set chat_server = 0";
	$conn->query($sql);

	$Server = new PHPWebSocket();
	$Server->bind('message', 'wsOnMessage');
	$Server->bind('open', 'wsOnOpen');
	$Server->bind('close', 'wsOnClose');

	$Server->wsStartServer(SOCKET_BACKEND_IP, SOCKET_BACKEND_PORT);

?>