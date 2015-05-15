<?php
	class sendNotification {
		
		public function loadChecksFailed() {
			$event=file_get_contents("php://stdin");
			print_r($event);$arr = array('saubi1993@gmail.com','s.kushwaha@naukri.com');
			$this->sendEmail($arr,'consul@saubi','notification',$event);
		}

		public function sendEmail($toEmailIds, $fromEmailId, $subject, $body = '') {
	         $strToEmailIds = implode(',', $toEmailIds);
	         $fileDescriptor = popen("/usr/sbin/sendmail -t -f $fromEmailId ", 'w');
	          echo "\n Sending mail  \n";
	         if ($fileDescriptor) { echo "\nin fileDescriptor\n";
	             fputs($fileDescriptor, "To: $strToEmailIds\n");
	             fputs($fileDescriptor, "From: $fromEmailId\n");
	             fputs($fileDescriptor, "Subject: $subject\n");
	             fputs($fileDescriptor, "MIME-Version: 1.0\n");

	             if (trim($body) != '') {
	                 $contentType = (stristr($body, '<html>')) ? 'text/html' : 'text/plain';

	                 fputs($fileDescriptor, "Content-Type: $contentType; charset=iso-8859-1\n");
	                 fputs($fileDescriptor, "Content-Transfer-Encoding: 8bit\n");
	                 fputs($fileDescriptor, "Content-Disposition: inline\n\n");
	                 fputs($fileDescriptor, $body."\n");
	             }

	             fputs($fileDescriptor, "\n.\n");
	             return pclose($fileDescriptor);
	         }
	         else {
	             mail($strToEmailIds, $subject, $body, "From: $fromEmailId");
	         }
	         echo "\n mail sent \n";
     	}
	}
	$obj =new sendNotification;
	$obj->loadChecksFailed();