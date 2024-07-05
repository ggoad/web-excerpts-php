<?php
require_once(__DIR__."/phpmailer/phpmailer.php");
require_once(__DIR__."/ensureDirectory.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function LogMailAttempt($host, $fromEmail, $info, $errorMessage=''){
    $fedir=str_replace("@",'_',$fromEmail);
    $info['errorMessage']=$errorMessage;
	$host=str_replace(['/',':'],['',''],$host);
	EnsureDirectory(__DIR__."/phpmailer/logs/$host");
	
    if(!is_dir(__DIR__."/phpmailer/logs/$host/$fedir")){
        mkdir(__DIR__."/phpmailer/logs/$host/$fedir");
        file_put_contents(__DIR__."/phpmailer/logs/$host/$fedir/ind.int","1");
        $ind=1;
    }else{
        $ind=intval(file_get_contents(__DIR__."/phpmailer/logs/$host/$fedir/ind.int"));
        $ind++;
        file_put_contents(__DIR__."/phpmailer/logs/$host/$fedir/ind.int", $ind);
    }
    file_put_contents(__DIR__."/phpmailer/logs/$host/$fedir/$ind.json", json_encode($info));
}
function BasicSendMailComplete($host, $userNFromEmail, $fromName, $pass, $to, $subject, $bodys, $attachments=[], $CCs=[], $otherInfo=[]){
	//other info : port, SMTPSecure, SMTPAuth, isSMTP
	$isSMTP=$otherInfo['isSMTP'] ?? true;
	$SMTPSecure=$otherInfo['SMTPSecure'] ?? 'tls';
	$SMTPAuth=$otherInfo['SMTPAuth'] ?? true;
	$port=$otherInfo['port'] ?? 587;
	if(gettype($bodys) === 'array'){
		$body=$bodys['body'];
		$altBody=$bodys['alt'] ?? '';
	}else{
		$body=$bodys;
	}
	if(gettype($userNFromEmail) === 'array'){
		$fromEmail=$userNFromEmail['fromEmail'];
		$user=$userNFromEmail['user'];
	}else{
		$fromEmail=$userNFromEmail;
		$user=$userNFromEmail;
	}
	
	if(!is_array($to)){$to=[$to];}
	
	
	
    $info=[
        'host'=>$host,
		'user'=>$user,
        'fromEmail'=>$fromEmail,
        'fromName'=>$fromName,
        'to'=>join(',',$to),
        'subject'=>$subject,
        'body'=>$body,
		'altBody'=>$altBody,
        'attachments'=>$attachments,
        'CCs'=>$CCs
    ];
    if(!$host || !$fromEmail || !$pass || !$to || !$subject){
        if(!$host){$host="nohost";}
        if(!$fromEmail){$fromEmail="nouser";}
        LogMailAttempt($host, $fromEmail, $info, 'failed');
        return false;
    }
    
    
    $mailer=new PHPMailer(false);
    
    $mms="";
    
    try{
		/*
        $mailer->SMTPDebug = 2;
        $mailer->Debugoutput=function($msg,$lvl){
            global $mms;
            $mms=$msg;
        };*/
		if($isSMTP){
			$mailer->isSMTP();
		}
    
        $mailer->SMTPOptions = [
            'ssl'=> [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            ]
        ];
        
    
        
        $mailer->Host = $host;
        $mailer->SMTPAuth = $SMTPAuth;
        $mailer->Username = $user;
        $mailer->Password = $pass;
		if($SMTPSecure){
			$mailer->SMTPSecure = $SMTPSecure;
		}
        $mailer->Port = $port;
      // echo ($_POST['from']." $passName");
        $mailer->setFrom($fromEmail, $fromName);
		
			foreach($to as $addr)
			{
				$mailer->addAddress($addr);
			}
		
        //if($_POST['to'] !== 'ggoadmusic@gmail.com'){
        //    $mailer->addAddress('ggoadmusic@gmail.com');
        //}
        
        foreach($CCs as $cc)
        {
            if(array_search($cc,$to) !== false){continue;}
            $mailer->addCC($cc);
        }
    
        $mailer->isHTML(true);
        $mailer->Subject = $subject;
        $mailer->Body = $body;
		$mailer->AltBody= $altBody;
        
        foreach($attachments as $at)
        {
            $mailer->addAttachment($at);
        }
    
        $mailer->send();
        $mailer->ClearAllRecipients();
       // echo "SUCCESS";
        LogMailAttempt($host,$fromEmail, $info);
        return "SUCCESS";
    }catch(Exception $e){
        LogMailAttempt($host, $fromEmail, $info, $mailer->ErrorInfo);
		
        return "Email Sending Failed: ".$mailer->ErrorInfo;
    }
}
function BasicSendMail($host, $fromEmail, $fromName, $pass, $to, $subject, $body, $attachments=[], $CCs=[]){
    BasicSendMailComplete($host, $fromEmail, $fromName, $pass, $to, $subject, ['body'=>$body], $attachments, $CCs);
    
}
?>