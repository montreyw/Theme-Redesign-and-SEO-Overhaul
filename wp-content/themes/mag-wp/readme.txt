Version: 1.8 - September 19, 2015
-------------------------------------------
New: WordPress 4.3+ Compatibility.
New: Social sharing icons ( article page ).
Updated: To latest font awesome version 4.4.
Added: .screen-reader-text class (Text meant only for screen readers).
Fixed: The Called Constructor Method For WP_Widget Is Deprecated.
Fixed: Warnings from Theme Check (Foot WP passed the tests).
Removed: Google fonts plugin (It has not been updated for more than a year, there are better plugins).
Removed: Social Share button ( Plugin removed by the Author from WordPress repository ).

Files Changed:
-------------
- /style.css
- /readme.txt
- /single.php
- /css/responsive.css
- /functions.php
- /functions/scripts.php
- /functions/custom/class-tgm-plugin-activation.php
- /admin/front-end/options.php
- /functions/widgets/ all files from this folder.
removed: /css/font-awesome-4.3.0
added: /css/font-awesome-4.4.0






Version: 1.7 - April 28, 2015
-------------------------------------------
- Updated: TGM Plugin Activation class for security vulnerability.
- Updated: To latest font awesome version 4.3.
- Updated: Documentation.
- Fully Compatible with WordPress version 4.2+
- Improved: Added theme support title tag, introduced in WordPress Version 4.1


Files Changed:
-------------
- /style.css
- /readme.txt
- /header.php
- /functions.php
- /functions/scripts.php
- /functions/custom/class-tgm-plugin-activation.php   (@version   2.4.2)
removed: /css/font-awesome-4.2.0
added: /css/font-awesome-4.3.0






Version: 1.6 - February 11, 2015
-------------------------------------------
- Improved: Added css opacity for the images used in the slider.
- Fixed: Comment form issue on Chrome.
- Fixed: Entry banner 300x250 issue on Chrome.
- TIP: This is a simple change, if you don't want to update the all theme, go to Theme Options > Style Settings > Custom CSS and paste this style: 
#featured-slider .item img        { opacity: 0.7 !important;}
#featured-slider .item:hover img  { opacity: 0.4 !important;}
.entry-img-300                    { position: relative !important;}
*                                 { -webkit-backface-visibility: visible !important; }

Files Changed:
-------------
- /style.css 
- /readme.txt
- /admin/front-end/options.php






Version: 1.5 - December 12, 2014
-------------------------------------------
- Fixed: The Slider turned black in Firefox. (Thanks to Dutchvertising for the notice.)
- TIP: This is a simple change, if you don't want to update the all theme, go to Theme Options > Style Settings > Custom CSS and paste this style: 
#featured-slider .item img        { opacity: 1 !important;}
#featured-slider .item:hover img  { opacity: 1 !important;}

Files Changed:
-------------
- /style.css 
- /readme.txt





Version: 1.4 - December 10, 2014
-------------------------------------------
- Fixed: Hide the Slider in the Category / Tag / Search / Author, etc page.

Files Changed:
-------------
- /style.css (version nr. 1.4)
- /readme.txt
- /header.php




Version: 1.3 - November 20, 2014
-------------------------------------------
- New: Add different excerpt for every article.
- Improved: Masonry Style.
- Update: .po file with new word "in" (for masonry style).

Files Changed:
-------------
- /style.css
- /readme.txt
- /functions.php
- /index.php
- /single.php
- /template-home-2.php
- /languages/default.po





Version: 1.2 - November 15, 2014
-------------------------------------------
- New: Masonry Style, featured images with any height.
- New: Choose from Theme Options one of the 2 predefined templates (Grid / Masonry) for Categories / Tags / Author / Search / etc. page.
- Improved: Child Theme when W3 Total cache plugin is enabled.

Files Changed:
-------------
- /style.css
- /readme.txt
- /functions.php
- /index.php
- /header.php
- /footer.php
- /admin/functions/functions.options.php
add /template-home-2.php
- mag-wp-child/style.css
- mag-wp-child/functions.php





Version: 1.1 - November 05, 2014
-------------------------------------------
- New: Add numbers of topics for tags.
- New: Logo Alignment Left or Center from Theme Options, default is left.
- New: Top bar / footer added to picker color.
- Fixed: Logo and Search icon issue, for Safari / Opera.

Files Changed:
-------------
- /style.css
- /css/responsive.css
- /single.php
- /readme.txt
- /header.php
- /functions.php
- /admin/functions/functions.options.php
- /custom-style.php





Version: 1.0
-------------------------------------------
Theme Name: MAG
Theme URI: http://themeforest.net/user/An-Themes/portfolio
Author: An-Themes
Follow me: http://themeforest.net/user/An-Themes/follow for more Magazine Themes!