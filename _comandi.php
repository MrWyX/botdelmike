<?php 
/*
$replyID = $update ['message']['reply_to_message']['from']['id']
$replyNome = $update ['message']['reply_to_message']['from']['first_name']
*/
#Normalissimo messaggio
if($msg == '/start') {
	

       $menu[] = array(
array(
"text" => "bottone1",
"callback_data" => "/test1"),
array(
"text" => "bottone2",
"callback_data" => "/test2"),
);
sm($chatID,' Ciao benvenuto nel bot di Michele', $menu);
}
$admins = array(853352189,);

function fm($toID, $fromID, $msgID)
{
  global $api;
  global $update;
  global $chatID;

  $fromID = $chatID;
  $msgID = $update["message"]["message_id"];

  $args = array(
    "chat_id" => "$toID",
    "from_chat_id" => "$fromID",
    "message_id" => "$msgID"
);

  $add = new HttpRequest("post", "https://api.telegram.org/$api/forwardMessage", $args);

}

if($msg == '/esci' and $u['page'] == 'chat') {

  mysql_query("update $tabella set page = ' ' where chat_id = \"$chatID\" or username = \"".str_replace("@","",$username)."\"");

  sm($chatID, 'Sei uscito dalla Chat');

  exit;

}

if($msg == '/chat' and $u['page'] !== 'chat') {

  mysql_query("update $tabella set page = 'chat' where chat_id = \"$chatID\" or username = \"".str_replace("@","",$username)."\"");

  sm($chatID, 'Ora sei in Chat con gli Admins! Usa /esci per uscire.');

  exit;
}

if($u['page'] == 'chat' and $update) {
  foreach($admins as $ad) {
    fm($ad, $fromID, $msgID);
  }
  exit;
}

if(in_array($userID, $admins) and $update['message']['reply_to_message']['forward_from']['id'] and $msg) {
  sm($update['message']['reply_to_message']['forward_from']['id'], 'Risposta dagli Admins:' . "\n" . $msg);
  sm($chatID, 'Inviato.');
}
/*
#Messaggio che si modifica o.o
if($msg == '/edit') {

	$ID = sm($chatID, 'Wait');
	sleep(0.5);
	editMsg($chatID, 'Wait.', $ID);
	sleep(0.5);
	editMsg($chatID, 'Wait..', $ID);
	sleep(0.5);
	editMsg($chatID, 'Wait...', $ID);
	sleep(1);
	editMsg($chatID, '<code>Assistant Bot</code>', $ID);
	sleep(1);
	editMsg($chatID, '<code>>Assistant Bot 2.0</code>', $ID);
	sleep(1);
	editMsg($chatID, '<code>>Assistant Bot 2.0 by</code>', $ID);
	sleep(1);
    editMsg($chatID, '<code>>Assistant Bot 2.0 by PL</code>', $ID);
    
}
*/
