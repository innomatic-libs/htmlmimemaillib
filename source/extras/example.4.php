<?php
/***************************************
** Filename.......: example.4.php
** Project........: HTML Mime Mail class
** Last Modified..: 08 September 2001
***************************************/

/*

	Having trouble? Read this article on HTML email: http://www.arsdigita.com/asj/mime/

*/

        error_reporting(63);
        include('class.html.mime.mail.inc');

/***************************************
** Example of usage. This example shows
** how to use the class to send Bcc: 
** and/or Cc: recipients.
***************************************/

		/***************************************
        ** This is optional, it will default to \n
		** If you're having problems, try changing
		** this to either \n (unix) or \r (Mac)
        ***************************************/

		define('CRLF', "\r\n", TRUE);

        /***************************************
        ** Create the mail object. Optional headers
        ** argument. Do not put From: here, this
        ** will be added when $mail->send
        ** Does not have to have trailing \r\n
        ** but if adding multiple headers, must
        ** be seperated by whatever you're using
		** as line ending (usually either \r\n or \n)
        ***************************************/

        $mail = new html_mime_mail('X-Mailer: Html Mime Mail Class');

		/***************************************
        ** We will just send a text email
        ***************************************/

        $text = $mail->get_file('example.txt');
		$mail->set_body($text);

        /***************************************
        ** Builds the message.
        ***************************************/

        $mail->build_message();

        /***************************************
        ** Send the email using smtp method.
		** This is the preferred method of sending.
        ***************************************/

        include('class.smtp.inc');
        $smtp = new smtp_class();

        $smtp->host_name = '10.1.1.2';	// Address/host of mailserver
        $smtp->localhost = 'localhost';	// Address/host of this machine (HELO)

        $from    = 'joe@example.com';
        $to      = array(
							'richard@[10.1.1.2]',
							'cc-recipient@[10.1.1.2]',	// This recipient has a corresponding Cc: header, so it will
														// effectively be a Cc: recipient.
							'bcc-recipient@[10.1.1.2]'	// Since this recipient has no corresponding to: or Cc: header,
														// it will effectively be a Bcc: recipient.
						);

        $headers = array(	'From: "Joe" <joe@example.com>',						// A To: header is necessary, but does
							'Subject: Example email using HTML Mime Mail class',	// not have to match the list in $to.
							'To: "Richard" <richard@[10.1.1.2]>',
							'Cc: cc-recipient@[10.1.1.2]');

        $mail->smtp_send($smtp, $from, $to, $headers);

        /***************************************
        ** Debug stuff. Entirely unnecessary.
        ***************************************/

        echo '<PRE>'.htmlentities($mail->get_rfc822('Richard', 'richard@[10.1.1.2]', 'Joe', 'joe@example.com', 'Example email using HTML Mime Mail class')).'</PRE>';
?>