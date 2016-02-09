<?php
/*
Template Name: Template - Contact
*/
?>
<?php
    // Options from admin panel
    global $smof_data;
    if (empty($smof_data['contact_email'])) { $smof_data['contact_email'] = ''; }
    if (empty($smof_data['contact_confirmation'])) { $smof_data['contact_confirmation'] = 'Thanks, your email was sent successfully.'; }
?>
<?php
if(isset($_POST['submitted'])) {
  if(trim($_POST['contactName']) === '') {
    $nameError = 'Please enter your name.';
    $hasError = true;
  } else {
    $name = trim($_POST['contactName']);
  }
  if(trim($_POST['emaill']) === '')  {
    $emailError = 'Please enter your email address.';
    $hasError = true;
  } else if (preg_match("/^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$/", trim($_POST['emaill']))) {
    $emailError = 'You entered an invalid email address.';
    $hasError = true;
  } else {
    $emaill = trim($_POST['emaill']);
  }
  if(trim($_POST['subject']) === '') {
    $subjectError = 'Please enter your subject.';
    $hasError = true;
  } else {
    $subject = trim($_POST['subject']);
  }
  if(trim($_POST['comments']) === '') {
    $commentError = 'Please enter a message.';
    $hasError = true;
  } else {
    if(function_exists('stripslashes')) {
      $comments = stripslashes(trim($_POST['comments']));
    } else {
      $comments = trim($_POST['comments']);
    }
  }
  if(!isset($hasError)) {
    $emailTo = $smof_data['contact_email'];
    if (!isset($emailTo) || ($emailTo == '') ){
    $emailTo = get_option('admin_email');
    }
    $body = "Name: $name \nEmail: $emaill \nSubject: $subject \n\nMessage: $comments";
    $headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $emaill;
    mail($emailTo, $subject, $body, $headers);
    $emailSent = true;
  }
} ?>
<?php get_header(); // add header  ?>
<!-- Begin Content -->
<div class="wrap-fullwidth hfeed h-feed">
    <div class="single-content hentry h-entry">
        <article>
            <?php if (have_posts()) : while (have_posts()) : the_post();  ?>
            <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
                        <div class="entry">
                          <h1 class="page-title entry-title"><?php the_title(); ?></h1>
                          <div class="p-first-letter entry-content">
                              <?php the_content(''); // content ?>
                          </div><!-- end .p-first-letter -->
                          <?php wp_link_pages(); // content pagination ?>
                          <div class="clear"></div>
                           <?php if(isset($emailSent) && $emailSent == true) { ?>
                           <div class="boxsucces"> <p><?php echo $smof_data['contact_confirmation']; ?></p> </div>
                           <?php } else { ?>
                           <div class="error">
                              <?php if(isset($hasError) || isset($captchaError)) { ?>
                              <div class="boxerror">
                                <span><?php _e('Sorry, an error occured.', 'anthemes'); ?></span>
                              </div>
                              <?php } ?>
                           </div>
                            <script type="text/javascript">jQuery(document).ready(function() { if (jQuery().validate) { jQuery("#contactform").validate(); } }); // jQuery(document).</script>
                            <form id="contactform" method="post" action="<?php the_permalink(); ?>">
                            <fieldset id="contactform">
                             <div class="one_half_c">
                                 <label for="contactName"><?php _e('Name:', 'anthemes'); ?><span>*</span></label>
                                 <input type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="required requiredField contactName"  />
                             </div>
                             <div class="one_half_last_c">
                                 <label for="emaill"><?php _e('Email:', 'anthemes'); ?><span>*</span></label>
                                 <input type="text" name="emaill" id="emaill" value="<?php if(isset($_POST['emaill']))  echo $_POST['emaill'];?>" class="required requiredField email" />
                             </div>
                             <div class="one_full_c">
                                 <label for="subject"><?php _e('Subject:', 'anthemes'); ?><span>*</span></label>
                                 <input type="text" name="subject" id="subject" value="<?php if(isset($_POST['subject'])) echo $_POST['subject'];?>" class="required requiredField subject" />
                             </div>
                             <div class="one_full_c">
                                 <label for="comments"><?php _e('Message:', 'anthemes'); ?><span>*</span> </label>
                                 <textarea name="comments" id="contactmessage" rows="" cols=""><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
                             </div>
                                <input type="submit" name="submit" class="sendemail" value="<?php _e('Submit Message', 'anthemes'); ?>"  /> <span>*</span><?php _e('All Fields are mandatory!', 'anthemes'); ?>
                                <input type="hidden" name="submitted" id="submitted" value="true" />
                            </fieldset>
                            </form>
                          <?php } ?><br />
                        </div><!-- end #entry -->
            </div><!-- end .post -->
            <?php endwhile; endif; ?>
        </article>
    </div><!-- end .single-content -->
    <!-- Begin Sidebar (right) -->
    <?php  get_sidebar(); // add sidebar ?>
    <!-- end #sidebar  (right) -->
    <div class="clear"></div>
</div><!-- end .wrap-fullwidth -->
<?php get_footer(); // add footer  ?>