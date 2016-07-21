<?php

/**
 * @file
 * Default theme implementation to format an HTML mail.
 *
 * Copy this file in your default theme folder to create a custom themed mail.
 * Rename it to mimemail-message--[module]--[key].tpl.php to override it for a
 * specific mail.
 *
 * Available variables:
 * - $recipient: The recipient of the message
 * - $subject: The message subject
 * - $body: The message body
 * - $css: Internal style sheets
 * - $module: The sending module
 * - $key: The message identifier
 *
 * @see template_preprocess_mimemail_message()
 */
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
      <!--
      body {
        background: #D9D9D9;
      }
      td {
        font-size: 18px;
      }
      #main {
        text-align: center;
      }
      .post__header {
        background-color: #d5d5d5;
        color: black;
      }
      .post__body {
        width: 60%
      }
      .post__content {
        background-color: white;
      }
      -->
    </style>
</head>
<body id="mimemail-body" <?php if ($module && $key): print 'class="'. $module .'-'. $key .'"'; endif; ?>>
<div id="center">
  <div id="main">
    <?php print $body ?>
  </div>
</div>
</body>
</html>
