<?php
/***************************************
** Filename.......: example.1.php
** Project........: HTML Mime Mail class
** Last Modified..: 27 August 2001
***************************************/

/*

	Having trouble? Read this article on HTML email: http://www.arsdigita.com/asj/mime/

*/

        error_reporting(63);
        include('class.html.mime.mail.inc');

/***************************************
** Example of usage. This example shows
** how to use the class with html,
** embedded images, and an attachment,
** using the usual methods.
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
        ** Read the image background.gif into
		** $background
        ***************************************/

        $background = $mail->get_file('background.gif');

        /***************************************
        ** Read the file test.zip into $attachment.
        ***************************************/

        $attachment = $mail->get_file('example.zip');

        /***************************************
        ** If sending an html email, then these
        ** two variables specify the text and
        ** html versions of the mail. Don't
        ** have to be named as these are. Just
        ** make sure the names tie in to the
        ** $mail->add_html() call further down.
        ***************************************/

        $text = $mail->get_file('example.txt');
        $html = $mail->get_file('example.html');

        /***************************************
        ** Add the text, html and embedded images.
        ** Each embedded image has to be added
        ** using $mail->add_html_image() BEFORE
        ** calling $mail->add_html(). The name
        ** of the image should match exactly
        ** (case-sensitive) to the name in the html.
        ***************************************/

        $mail->add_html_image($background, 'background.gif', 'image/gif');
        $mail->add_html($html, $text);

        /***************************************
        ** This is used to add an attachment to
        ** the email.
        ***************************************/

        $mail->add_attachment($attachment, 'example.zip', 'application/zip');

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
        $to      = array('richard@[10.1.1.2]');	// Can be more than one address in this array.

        $headers = array(	'From: "Joe" <joe@example.com>',						// A To: header is necessary, but does
							'Subject: Example email using HTML Mime Mail class',	// not have to match the list in $to.
							'To: "Richard" <richard@[10.1.1.2]>');

        $mail->smtp_send($smtp, $from, $to, $headers);

        /***************************************
        ** Debug stuff. Entirely unnecessary.
        ***************************************/

        echo '<PRE>'.htmlentities($mail->get_rfc822('Richard', 'richard@[10.1.1.2]', 'Joe', 'joe@example.com', 'Example email using HTML Mime Mail class')).'</PRE>';
?>