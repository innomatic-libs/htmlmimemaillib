<?php
/***************************************
** Filename.......: example.2.php
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
** embedded images, no attachments, but
** using the third argument of add_html(),
** which will try to automatically find the
** images (though not limited to images),
** and embed them. It will send the mail
** using the send() function, which will
** use the built in php mail() function.
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
		** Here we're using the third argument of
		** add_html(), which is the path to the
		** directory that holds the images. By
		** adding this third argument, the class
		** will try to find all the images in the
		** html, and auto load them in. not 100%
		** accurate, and you MUST enclose your
		** image references in quotes, so src="img.jpg"
		** and NOT src=img.jpg. Also, where possible,
		** duplicates will be avoided.
        ***************************************/

        $mail->add_html($html, $text, './');

        /***************************************
        ** Set character set. Not necessary, unless
		** of course you need to specify one.
        ***************************************/

        $mail->set_charset('iso-8859-1');

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