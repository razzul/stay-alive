<?php

session_start();
require __DIR__ . '/vendor/autoload.php';

//These values are automatically POSTed by the Pusher client library
$socket_id = $_POST['socket_id'];
$channel_name = $_POST['channel_name'];
 
//You should put code here that makes sure this person has access to this channel
/*
if( $user->hasAccessTo($channel_name) == false ) {
    header('', true, 403);
    echo( "Not authorized" );
    exit();
}
*/

$options      = get_option('stay_alive_credentials');
$current_user = $user_obj = get_user_by('login', $current_user );
$channel_name = 'private-stay-alive-channel';
$pusher = new Pusher\Pusher($options['pusher_key'], $options['pusher_secret'], $options['pusher_app_id'], array('cluster' => $options['pusher_cluster']));
 
//Any data you want to send about the person who is subscribing
$presence_data = array(
    'name' => $current_user->display_name
);
 
echo $pusher->presence_auth(
    $channel_name, //the name of the channel the user is subscribing to 
    $socket_id, //the socket id received from the Pusher client library
    $current_user->id,  //a UNIQUE USER ID which identifies the user
    $presence_data //the data about the person
);
exit();
?>