<style type="text/css"><?php
    // Options from admin panel
    global $smof_data;

    if (empty($smof_data['custom_css_style'])) { $smof_data['custom_css_style'] = ''; }
    if (empty($smof_data['main_color1'])) { $smof_data['main_color1'] = ''; }
    if (empty($smof_data['footer_background_img'])) { $smof_data['footer_background_img'] = ''; }
    if (empty($smof_data['topbar_color'])) { $smof_data['topbar_color'] = ''; }

    if (empty($smof_data['r-number-footer'])) { $smof_data['r-number-footer'] = '30'; }
    if (empty($smof_data['g-number-footer'])) { $smof_data['g-number-footer'] = '31'; }
    if (empty($smof_data['b-number-footer'])) { $smof_data['b-number-footer'] = '32'; }

    if (empty($smof_data['r-number-footer-copy'])) { $smof_data['r-number-footer-copy'] = '26'; }
    if (empty($smof_data['g-number-footer-copy'])) { $smof_data['g-number-footer-copy'] = '26'; }
    if (empty($smof_data['b-number-footer-copy'])) { $smof_data['b-number-footer-copy'] = '27'; }

?>
<?php
if($smof_data['custom_css_style']) {
	echo $smof_data['custom_css_style']; //Custom CSS 
}

if($smof_data['topbar_color']) { 
    // Top bar Background color
    echo '.top-navigation  { background-color: '. $smof_data['topbar_color'] .' !important;}';    
}    


if($smof_data['r-number-footer'] || $smof_data['g-number-footer'] || $smof_data['b-number-footer']) {
    echo '.footer-section  { background-color: rgba('. $smof_data['r-number-footer'] .', '. $smof_data['g-number-footer'] .', '. $smof_data['b-number-footer'] .', 0.95) !important; }';
}

if($smof_data['r-number-footer-copy'] || $smof_data['g-number-footer-copy'] || $smof_data['b-number-footer-copy']) {
    echo '.copyright  { background-color: rgba('. $smof_data['r-number-footer-copy'] .', '. $smof_data['g-number-footer-copy'] .', '. $smof_data['b-number-footer-copy'] .', 0.8) !important; }';
}

if($smof_data['main_color1']) {// main color.
	echo 'a:hover, .popular-words span, .top-social li a, .jquerycssmenu ul li.current_page_item > a, .jquerycssmenu ul li.current-menu-ancestor > a, .jquerycssmenu ul li.current-menu-item > a, .jquerycssmenu ul li.current-menu-parent > a, .jquerycssmenu ul li a:hover, .jquerycssmenu-right ul li.current_page_item > a, .jquerycssmenu-right ul li.current-menu-ancestor > a, .jquerycssmenu-right ul li.current-menu-item > a, .jquerycssmenu-right ul li.current-menu-parent > a, .jquerycssmenu-right ul li a:hover, ul.big-thing li .an-display-author a, .review-box-nr i, .review-box-nr, ul.article_list .review-box-nr, div.feed-info i, .article_list li .an-display-author a, ul.article_list .an-widget-title i, .widget_anthemes_categories li, div.tagcloud span, .widget_archive li, .widget_meta li, #mcTagMap .tagindex h4, #sc_mcTagMap .tagindex h4, .copyright a { color: '. $smof_data['main_color1'] .' !important;}'; //Main color = color
    echo '.popular-words strong, .jquerycssmenu ul li ul li:hover, .jquerycssmenu-right ul li ul li:hover, a.btn-featured:hover, ul.big-thing .article-category, ul.classic-blog .article-category, .wp-pagenavi a:hover, .wp-pagenavi span.current, a.author-nrposts, .entry-btn, .my-paginated-posts span, #newsletter-form input.newsletter-btn, ul.article_list .article-category, #contactform .sendemail, .social-section, footer #wp-calendar tbody td#today, #back-top span { background-color: '. $smof_data['main_color1'] .' !important;}'; //Main bg color

    // Entry link bg color
    echo '.p-first-letter p a  { background-color: '. $smof_data['main_color1'] .';}';

    echo 'footer { background: url('. $smof_data['footer_background_img'] .'); }';
   
    // Tags and Cats border
	echo '#mcTagMap .tagindex h4, #sc_mcTagMap .tagindex h4 { border-bottom: 5px solid '. $smof_data['main_color1'] .' !important;}';

    // Btn. featured articles
    echo 'a.btn-featured:hover { border-color: '. $smof_data['main_color1'] .' !important;}';

    // Border 1px bottom
    echo 'ul.big-thing .an-widget-title span a, ul.classic-blog .an-content span a, .entry-top span a, div.feed-info strong, ul.article_list .an-widget-title span a, .copyright a  { border-bottom: 1px solid '. $smof_data['main_color1'] .' !important;}';

    // Border arrow 8px top
    echo 'ul.big-thing .arrow-down-cat, ul.classic-blog .arrow-down-cat, ul.article_list .arrow-down-cat { border-top: 8px solid '. $smof_data['main_color1'] .' !important;}';

    // Category ribbon
    echo 'ul.big-thing .article-category i, ul.classic-blog .article-category i, ul.article_list .article-category i  { border-color: '. $smof_data['main_color1'] .' transparent '. $smof_data['main_color1'] .' '. $smof_data['main_color1'] .' !important;}';
}
?>
</style>
