<?php
$amministratore = $adminID;
if($msg)
{
	if($chatID > 0)
	{
mkdir("database");
mkdir("database/databasenosql");
mkdir("database/databasenosql/utenti");
mkdir("database/databasenosql/gruppi");
$iscrittiold1 = file_get_contents("database/databasenosql/utentiiscritti");
if($iscrittiold1 == "")
{
	file_put_contents("database/databasenosql/utentiiscritti", "0");
}
$iscrittiold2 = file_get_contents("database/databasenosql/gruppiiscritti");
if($iscrittiold2 == "")
{
	file_put_contents("database/databasenosql/gruppiiscritti", "0");
}
$controllo1 = file_get_contents("database/databasenosql/post.php");
if($controllo1 == "")
{
	file_put_contents("database/databasenosql/post.php", '<?php
	$post = file_get_contents("database/databasenosql/post");');
}

$controllo2 = file_get_contents("database/databasenosql/utenti/$chatID");
if($controllo2 == "")
{

if($chatID == "")
{
} else {
file_put_contents("database/databasenosql/utenti/$chatID", "$chatID");
$dati .= "\n";
$dati .= "\n";
$dati .= 'if($msg == "post-utenti" and $chatID == $amministratore) {';
$dati .= "\n";
$dati .= 'sm(';
$dati .= "$chatID";
$dati .= ', "$post");';
$dati .= "\n";
$dati .= "}";
$var=fopen("database/databasenosql/post.php","a");
fwrite($var,$dati);
fclose($var);


$iscrittiold = file_get_contents("database/databasenosql/utentiiscritti");
$newiscritti = $iscrittiold + 1;
file_put_contents("database/databasenosql/utentiiscritti", "$newiscritti");

}
}
}

} else {
	
mkdir("database");
mkdir("database/databasenosql");
mkdir("database/databasenosql/utenti");
mkdir("database/databasenosql/gruppi");
$controllo1 = file_get_contents("database/databasenosql/post.php");
if($controllo1 == "")
{
	file_put_contents("database/databasenosql/post.php", '<?php
	$post = file_get_contents("database/databasenosql/post");');
}

$controllo2 = file_get_contents("database/databasenosql/gruppi/$chatID");
if($controllo2 == "")
{

if($chatID == "")
{
} else {
file_put_contents("database/databasenosql/gruppi/$chatID", "$chatID");

$dati .= "\n";
$dati .= "\n";
$dati .= 'if($msg == "post-gruppi" and $chatID == $amministratore) {';
$dati .= "\n";
$dati .= 'sm(';
$dati .= "$chatID";
$dati .= ', "$post");';
$dati .= "\n";
$dati .= "}";
$var=fopen("database/databasenosql/post.php","a");
fwrite($var,$dati);
fclose($var);

$iscrittiold = file_get_contents("database/databasenosql/gruppiiscritti");
$newiscritti = $iscrittiold + 1;
file_put_contents("database/databasenosql/gruppiiscritti", "$newiscritti");


}
}
}





if(strpos($msg, "/post")===0 and $amministratore == $chatID)
{

$t = array(array(array(
"text" => "ðŸ‘¤ Utenti",
"callback_data" => "post-utenti"
),
array(
"text" => "Gruppi ðŸ‘¥",
"callback_data" => "post-gruppi"
)),
array(array(
"text" => "\xf0\x9f\x93\xa8 Cambia post \xf0\x9f\x93\xa8",
"callback_data" => "change-post"
)));

sm($chatID, "POST TRAMITE NO-SQL

Ok $nome, dove vuoi inviare il messaggio globale?

_Se selezioni gruppi, invia anche nei canali conosciuti._", $t, 'Markdown', false, false, true);
}


$controllopost = file_get_contents("database/databasenosql/postpermission");
if($msg == "\xe2\x9d\x8cAnnulla\xe2\x9d\x8c" and $controllopost == "true")
{
$text = "Annullato.";
sm($chatID, $text, 'nascondi');
	file_put_contents("database/databasenosql/postpermission", "false");
}

$controllopost = file_get_contents("database/databasenosql/postpermission");
if($msg and $controllopost == "true")
{
$text = "Post modificato.";
sm($chatID, $text, 'nascondi');
	file_put_contents("database/databasenosql/postpermission", "false");
	file_put_contents("database/databasenosql/post", "$msg");
}
	

if($msg == "change-post" and $chatID == $amministratore)
{
	file_put_contents("database/databasenosql/postpermission", "true");

$menu[] = array("\xe2\x9d\x8cAnnulla\xe2\x9d\x8c");
$text = "Ok $nome, invia ora il nuovo messaggio.";
sm($chatID, $text, $menu, '', false, false, false);
}



if($msg == "/iscritti" and $chatID == $amministratore)
{
	$iscrittichat = file_get_contents("database/databasenosql/utentiiscritti");
    $iscrittigruppi = file_get_contents("database/databasenosql/gruppiiscritti");
$iscrittio .= "ISCRITTI DATABASE NO SQL";
$iscrittio .= "\n";
$iscrittio .= "ðŸ”ˆ*ISCRITTI AL BOT*";
$iscrittio .= "\n  ðŸ‘¤ Chat Private: $iscrittichat";
$iscrittio .= "\n  ðŸ‘¥ Chat Gruppi: $iscrittigruppi";


sm($chatID, $iscrittio, false, 'Markdown');	
}
