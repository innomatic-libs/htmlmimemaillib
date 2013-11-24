<?php
/***************************************
** Filename.......: example.5.php
** Project........: HTML Mime Mail class
** Last Modified..: 15 September 2001
***************************************/

/*

	Having trouble? Read this article on HTML email: http://www.arsdigita.com/asj/mime/

*/

        error_reporting(63);
        include('class.html.mime.mail.inc');

/***************************************
** Example of usage. This example shows
** how to use the class to send an email
** attached to another email. First email
** built is plain text with an attachment.
** This is then attached to the second email
** which is also plain text.
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

        $mail_1 = new html_mime_mail('X-Mailer: Html Mime Mail Class');

		/***************************************
        ** First email.
        ***************************************/

        $text = $mail_1->get_file('example.txt');
		$mail_1->set_body($text);

		/***************************************
        ** Add the attachment
        ***************************************/

		$file = $mail_1->get_file('example.zip');
		$mail_1->add_attachment($file, 'example.zip', 'application/zip');

        /***************************************
        ** Builds the message.
        ***************************************/

        $mail_1->build_message();

        /***************************************
        ** Don't send this email, but use the
		** get_rfc822() method to assign it to a
		** variable.
        ***************************************/

		$mail = $mail_1->get_rfc822('John Doe', 'john@example.com', 'Some one', 'someone@example.com', 'Test for attached email');

		/***************************************
        ** Now start a new mail, and add the first
		** (which is now built and contained in
		** $mail) to it.
        ***************************************/

		$mail_2 = new html_mime_mail('X-Mailer: Html Mime Mail Class');

		$mail_2->set_body('This email has an attached email');
		$mail_2->add_attachment($mail, 'Test for attached email', 'message/rfc822');
		$mail_2->build_message();

		$mail_2->send('Richard Heyes', 'richard@[10.1.1.2]', 'A Nother', 'another@example.com', 'This email has another email attached');

        /***************************************
        ** Debug stuff. Entirely unnecessary.
        ***************************************/

        echo '<PRE>'.htmlentities($mail_2->get_rfc822('Richard Heyes', 'richard@[10.1.1.2]', 'A Nother', 'another@example.com', 'This email has another email attached')).'</PRE>';
?>