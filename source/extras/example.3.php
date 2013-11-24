<?php
/***************************************
** Filename.......: example.3.php
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
** how to use the class to send a plain
** text email with an attachment. No html,
** or embedded images. Uses the send() 
** method to send the email.
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
        ** Read the file test.zip into $attachment.
        ***************************************/

		$attachment = $mail->get_file('example.zip');

        /***************************************
        ** Since we're sending a plain text email,
		** we only need to read in the text file.
        ***************************************/

		$text = $mail->get_file('example.txt');

        /***************************************
        ** To set the text body of the email, we
		** are using the set_body() function. This
		** is an alternative to the add_html() function
		** which would obviously be inappropriate here.
        ***************************************/

		$mail->set_body($text);

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
        ** Sends the message. $mail->build_message()
        ** is seperate to $mail->send so that the
        ** same email can be sent many times to
        ** differing recipients simply by putting
        ** $mail->send() in a loop.
        ***************************************/

		$mail->send('Richard', 'richard.heyes@[10.1.1.2]', 'Joe', 'joe@example.com', 'Example email using HTML Mime Mail class');

        /***************************************
        ** Debug stuff. Entirely unnecessary.
        ***************************************/

        echo '<PRE>'.htmlentities($mail->get_rfc822('Richard', 'richard.heyes@[10.1.1.2]', 'Joe', 'joe@example.com', 'Example email using HTML Mime Mail class')).'</PRE>';
?>