<?php
if ( ! defined( 'ABSPATH' ) ) exit;
global $user_id;
global $current_user;
get_currentuserinfo();
$current_user->ID; ?>
<div class="wrap">
<h2>پشتیبانی</h2>
<br/>
<br/>
<?php




	session_start();
if(isset($_POST['submit'])) {

if ( 
    ! isset( $_POST['ariafont_nonce_field'] ) 
    || ! wp_verify_nonce( $_POST['ariafont_nonce_field'], 'check_nonce_ariafont' ) 
) {

   print 'پوزش می خواهیم درخواست شما قابل اجرا نیست.';
   exit;

} else {


if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message'])  && !empty($_POST['subject'])) {
if($_POST['code'] == $_SESSION['rand_code']) {
// send email
$accept = __('پیام شما با موفقیت ارسال شد.', 'awp');
$to = "info@ariawp.com";
$subject = sanitize_text_field($_POST['subject']);
$name= sanitize_text_field($_POST['name']);
$from = sanitize_email($_POST['email']);
$user_message = sanitize_text_field($_POST['message']);
$body = "\n".
"Name: $name\n".
"Email: $from \n".
"Message: \n ".
"$user_message\n".
$headers = "From: $from \r\n";
$headers .= "Reply-To: $from \r\n";
wp_mail($to, $subject, $body, $headers);
}
} else {
$error = __('لطفا همه فیلد ها را پر کنید!', 'awp');
}
}

}



?>
<div class="bodyawp">
<div id="mainawp">
<div class="contentawp">
<h2><?php _e('از این بخش می توانید با پشتیبانی افزونه تماس بگیرید. شما می توانید فونت های درخواستیتان را نیز برای ما ارسال کنید تا آن ها را در نسخه جدید قرار دهیم.', 'awp') ?></h2>
<?php if(!empty($error)) echo '<div class="errorwppafe">'.$error.'</div>'; ?>
<?php if(!empty($accept)) echo '<div class="okwppafe">'.$accept.'</div>'; ?>
<p>
<div class="formsparsi">     
<form action="" method="post">

<?php wp_nonce_field( 'check_nonce_ariafont', 'ariafont_nonce_field' ); ?>

<label for="username"><?php _e('نام شما', 'awp') ?></label>
<br/>
<input class="textare2" type="text" id="username" class="ariaform" value="" name="name">
<br/><br/>
<label for="email"><?php _e('ایمیل شما', 'awp') ?></label>
<br/>
<input class="textare2" type="text" id="email" value="" class="form-ltr" name="email">
<br/><br/>
<label for="sub"><?php _e('موضوع', 'awp') ?></label>
<br/>
<input class="textare2" type="text" id="sub" value="" class="ariaform" name="subject">
<br/><br/>
<label for="mess"><?php _e('پیام شما', 'awp') ?></label>
<br/>
<textarea style="resize: auto;" id="mess" rows="7" name="message"></textarea>
<br/><br/>
<input class="button-primary" type="submit" name="submit" value="<?php _e('ارسال', 'awp') ?>">
</form>
</div>
</p>
</div>

</div>
</div>
</div>
