# Earmilk
Earmilk redesign project

<h2 id="table-of-contents">Table of Contents</h2>
1. [To Do](#to-do-sec)
2. [Theme Changes](#theme-changes-sec)
3. [SEO Work](#seo-work-sec)
  *  [Fixing Incomplete, Missing, or Broken hAtom hEntries](#seo-hatom-sec)
  *  [Schema.org Markup](#seo-schema-sec)
  *  [Other SEO Improvements](#seo-other-sec)
4. [Miscellaneous Work](#misc-work-sec)
5. [EARMILK Links](#earmilk-links)
6. [EARMILK License](#earmilk-license)



----------

<h2 id="to-do-sec">To Do</h2>
- [x] Implement new header
- [x] Restructure new header further to remove unnecessary actions and make more compatible with all pages
- [x] Remove Main Stage from all pages but the Front
- [x] Normalize posts on Videos, Album Reviews and others
- [x] Widen Latest Posts on mobile view
- [x] Improve layout of Author Pages
- [ ] Add unique headers to individual category pages
- [x] Fix sitemap (fixed but how?)
- [x] Add Facebook Like Buttons to Social Sidebar
- [x] Add Google+ Buttons to Social Sidebar
- [x] Add Funtime Out Events Festivals to the nav menu
- [ ] Place ads
- [ ] Pull share count to posts grid
- [x] Show year of post on Author Pages if not current year
- [x] Make YouTube embed size more responsive to different screen sizes
- [ ] Look into and stop Google indexing post attachments / robots.txt
- [x] Look into Facebook native comments solution
- [x] Make all facebook comment count reflect in the posts-grid comment count
- [x] Make all comment-counts (facebook, disqus, native) reflect in the posts-grid comment count
- [ ] Change all image attachments image-link-type's in posts to file or none
- [ ] Add Extra AUthor Disclosure info to author meta
- [x] Implement Colorful Genre Bar from old.V2
- [ ] Remove all MP3 links from posts
- [ ] Ability to play a post's first song right from the posts grid
- [ ] Ability to play a post's first video right from the posts grid
- [ ] Finish Schema.org markup
- [ ] Get into [Google News](https://support.google.com/news/publisher/answer/40787?hl=en#general)
- [ ] Changes "archives" to "crates" for archive links of tags/categories
- [ ] Album Review Details custom widget
- [ ] AJAX site navigation engine
- [ ] Site wide persistent MP3 player
- [ ] iOS App 
- [ ] Implement backend templating capability for Events
- [ ] Implement a solution for Hreflang tags for indexing in foreign languages
- [x] Author Page pagination needs to be fixed
- [ ] Backend/Front end widget to give photographers credit for their photos
- [ ] A solution for photo sourcing (possible a community effort or a filtering functionality plugn)
- [ ] Remove all `&quot;`s from posts in `src="&quot;http...`
- [ ] LazyLoader for SoundCloud embeds
- [ ] STARTBALL OVER :D -- New Theme / PHP Infrastructure
- [ ] ...

- [Back to top ^](#table-of-contents)  

----------

<h2 id="theme-changes-sec">Theme Changes</h2>

1.  All ads have been removed -- the list of ads and their respective code can be found [in this file](https://github.com/iamandrebulatov/Earmilk/blob/master/google_ad_code_removed.html)
2.  Black to White -- style [code has been added](https://github.com/iamandrebulatov/Earmilk/commit/76d8365db5bd6f39aee36620a45ac9f06ee1eb23) to default.css, in wp-mag > css > colors
3.  Custom JS file [edited](https://github.com/iamandrebulatov/Earmilk/commit/219c0c4fef38c5675267fbf6e0994ab2d9324c83) to add ".sticky" class to whole `<body>` as well as the `<header>` so that the jitteriness can be fixed when Sticky Nav Header is trigger on scroll down by user
4.  All mobile sizing issues resolved
5.  Broken behavior of Header and logo jerkiness fixed, especially on mobile
6.  Various texts, sizing, and minor spacing issues (particularly with sidebar widgets and texts) have been resolved
7.  Footer widgets re-arranged a bit, less posts in left column, and location of language-flag changed
8.  Main Stage centered and spacing above increased
9.  Header navigation dropdown [changed](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/2b238ca733386d81ee469e30a536f7d302fa3fd2) from black to white
10.  Fixed [Author Page Bio & Search Results Dropdown](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/daae898d119f05d3d2e1cdf7d70cd2fb0041a9d5) to go with new theme
11.  Overahued [Posts Layout Grid](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/9d4a1c6172d42ee777bccf3f3dc981f0ae6da540), then touched up [a bit](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/7957d6620180102b85bc20d26a4078bd3a53f53a)
12.  Milky Harlem Shake Easter Egg! ([uploaded](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/c4def416f5cbfe6b85892275aa9f64ab191108a7), [initialized](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/30dd4a130a6853e4cc22767904c770d0d4031ef5), [customized](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/4299872c04786433a892952af7c290aa1776e767))
13.  Made the color of the [various title bars](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/f3eb88b5eca4e0e1528313411e9ba332c1017d06) and the [search field](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/bd9b43708e82a8ed9df30ad0b27c209678dc2bf5) a bit darker
14.  Fixed up footer: [left Trending posts widget](Fixed up latest posts left Footer widget), Google Translator plugin, Music Vibes links and Music Magazine Subscription text
15.  Applied New ["Quantum Paper Input Style" to Search](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/bb457e91b08bfd7a71cec4422062272358cb615a)
16.  Header Overhaul ([strucutre](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/4a20c510c1dd740cfc7445d8216d5929f8d6771b), [style](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/2097af47067b36670ef11db1268e621210aef968))
17.  "Main Stage" Overhaul ([strucutre](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/4a20c510c1dd740cfc7445d8216d5929f8d6771b), [style](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/2097af47067b36670ef11db1268e621210aef968))
18.  Restructured new header further to [remove unnecessary actions](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/6ae1a7ce8cde345982acfc416943b790d855e4fb) and make more compatible with all pages
19.  Main Stage [removed](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/6560cb4b35fc0610dff64dd6e01536849126eeb7) from all pages but the Home
20.  Removed Main Srage [from all pages](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/6560cb4b35fc0610dff64dd6e01536849126eeb7) but Home
21.  Widened [front page posts](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/220644980edf6d4fa9c1dfba2c176a1aba6d9b98) on mobile
22.  Purrtied up and normalized [Album Review](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/92fefc630cbcbdc4b51e23a8896afca533aa443d), [VOICES](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/06f704e4df608f38d7fba7378999709ed5922686),  [Gear](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/8c37de1f60429aa6e68b09205317f9024e708358), and [News](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/3f7c5e7a990efe851e81765a114e7ea82e57c63c) post type grids 
23.  Prettied and restructured single post's [Title and Author Meta](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/86f4d24bbf749956ae1225728aa7cc93161af5c4)
24.  Changed [site-wide font to Helvetica](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/3ebecc827ab4a8de65f0c4e574a76611211de7c2) for aesthetics and better readibility
25.  Improved [single post view on mobile](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/a6fb8c94025b5a23b1acdc3610ed7356ea5764a1)
26.  Jazzed up and updated [structure](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/a9050e0ebf33a15d482164d4ae2648c2d394552b) and [style](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/fec9fcc7313f605d20e5812b06e8a81622a52be3) of Author Pages
27.  Slicked up and pdated [structure](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/a9050e0ebf33a15d482164d4ae2648c2d394552b) and [style](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/fec9fcc7313f605d20e5812b06e8a81622a52be3) of Archive Pages
28.  Restructutred, simplified and improved the main [Fixed Header](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/845d4f3b80aa6df664ae812888e3431fdfe0e2fb)
29.  Implemented colorful category navigation [Genre Bar](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/5fb3cf07a1abf18eb08732d798a13d797f932362)
30.  ...


- [Back to top ^](#table-of-contents)  

--------


<h2 id="seo-work-sec">SEO Work</h2>

<h3 id="seo-hatom-sec">Fixing Incomplete, Missing, or Broken hAtom hEntries</h2>

1.  [Commented](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/f739b32c3a899139df1f09f8503bb7e3b889c595) out line 481 in wp-includes/post-template.php * **
	*this is the line that was commented out
	```php
		// hentry for hAtom compliance
		$classes[] = 'hentry';
	```
	
	**for a new, modern, properly coded theme, it'd be a bit cleaner to use the following PHP filter to remove broken WP-default hentry
	```php 
	function remove_hentry( $classes ) {
	
		$classes = array_diff($classes, array('hentry'));	
	
		return $classes;
	}
	```
2.  [Fixed/added](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/ee7a6f878ce6059e7928fb035c7097e1c8af71af) hEntry tags to single.php for hAtom compliance 
3.  [Fixed/added](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/a8d43e50ff6e36abbb060696bdd341c515830e96) hEntry tags to single-album_review.php for hAtom compliance
4.  [Fixed/added](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/a019edc974797065dc7907d668cce4cd1db23161) hEntry tags to single-gear_review.php for hAtom compliance
5.  [Fixed/added](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/85dff92be297808caad3ca5669d8df8f64fba686) hEntry tags to single-news.php for hAtom compliance
6.  [Fixed/added](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/9ee1ce9fad6d9873e0a89fce5949e414215239e0) hEntry tags to single-opinion_post.php for hAtom compliance
7.  [Upgraded](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/428245db1b09509477f1083e7074fb6fc27b3d55) hAtom markup to h-Atom micro formats draft 2.0  
8.  [Added](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/7c3ffe91e9356fb5eaf6f0a2809c13850683fc6f) hAtom to more template files  
9.  [Added](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/650f67978b9d55bf8d4ffbe4318096a73909161a) hAtom to Main Stage  
10.  [Added](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/13444148516b57421122eebdcd23801f8a397721) hAtom to main index.php file, which affects most posts
11.  Fixed broken hAtom entries on [Ultimate Posts Widget](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/8c3de90e46576ab4cb04c91aa186def3fdd4d0ad)


<h3 id="seo-schema-sec">Schema.org Markup</h2>

1.  Added [Organization](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/a2bf2a07e859375ba648f950fbb9191dba17ddb9) to header.php `<head>` 
2.  Added [WPHeader](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/3050ed60394655363ed560486c89b06cade8370e) to header.php 
3.  Added [WPFooter](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/27d372ccd87769f519af096f281c88e1140f6b22) to footer.php
4.  Added [SiteNavigationElement](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/c1aa8d1a4d10f8d75ef0ae884eb337c03690587c) to re-structured Header
5.  ...



<h3 id="seo-other-sec">Other SEO Improvements</h2>

1.  Fixed [several SEO meta tags](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/e1c3ea5b8bec65dfd01133c80fed9b6ac2bc64fb) in the `<head>`
2.  Properly implemented [non-WWW to WWW](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/b8cf6d709cdbd301c313d19446f7e60b6babc4b9), fixing [a major issue](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/issues/7)
3.  Implemented WWW to non-WWW ([nginx conf file](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/4a8542f3e97eb5bbc1284fcaacf6fd9703c35d45) and [wp-config.php](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/53677c65e5cc31da7501774d5cdd86dcc0f1c38c))
4.  Disabled [Yoast Schema](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/d301eb3407232d5b013cca4d4cb0a49a3216740d) and some metas
5.  Fixed W3TC and nginx settings conflict ([issue #9](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/issues/9)) which resulted in vrious bugs ([1st attempt](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/052036f4d05161d8517bd753301017d95a527a0d), [removed faulty code](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/9dab1576dd21e8abb28171c09ad41d750f73aa22), [pre-re-installed W3TC nginx.conf](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/19563ceb9adb83931704c66386d7201cad678782), [new nginx.conf after re-install](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/726bec3e5e0ca09a04b82222f384d5ac1dcd4f57), [proper include to W3TC WP-root nginx.conf](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/f00971312eb2af3849e50f8bb73412ca2faa5744))
6.  Fixed Sitemap (several plugin issues were resolved to make it work)
7.  Added robot.txt to `mooks.` and `file2.` subdomains to prevent caching unnecessary files (Montrey)



- [Back to top ^](#table-of-contents)  

--------

<h2 id="misc-work-sec">Misc Work</h2>

1.  Backups made ([Google Drive](https://drive.google.com/open?id=0B_40KgH9jS_Nckt0SW5JTFo0Qnc), [MEGA](http://mega.nz))
2.  [GitHub Project](https://github.com/iamandrebulatov/Earmilk) set up
3.  Clone set up at [allmilknoduds.com](http://allmilknoduds.com)
4.  Google Analytics [hardcoded](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/e1d21cade3c382300f30241dfcefe850a32d2dbd) into header.php
5.  Yoast Google Analytics plugin deactivated
6.  Fixed a CSS alignment of fields bug in [ALbum Review Details](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/c1aa8d1a4d10f8d75ef0ae884eb337c03690587c) backend plugin (Resolved [Issue #16](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/issues/16))
7.  Restructured [Header](https://github.com/iamandrebulatov/Theme-Redesign-and-SEO-Overhaul/commit/845d4f3b80aa6df664ae812888e3431fdfe0e2fb) for flexibility, to fix Schema Nav and to allow Genre Bar
8.  ...


- [Back to top ^](#table-of-contents)  

--------

<h2 id="earmilk-links">EARMILK Links</h2>

##Earmilk Development Enviornment Clone Site
-- [allmilknoduds.com](http://allmilknoduds.com)


##Earmilk "throwaway" email account
login:  allmilknoduds@gmail.com  
password:  [a truth we share]


##Earmilk Asset Storage
-- [Earmilk project assets cloud folder](https://drive.google.com/open?id=0B_40KgH9jS_Nckt0SW5JTFo0Qnc)  
-- [Mega.nz](http://mega.nz) (large; full site backup for safe keeping)  
----- Mega login:  allmilknoduds@gmail.com  
----- Mega password:  [a truth we share]


##Earmilk GitHub
- https://github.com/iamandrebulatov/Earmilk

- [Back to top ^](#table-of-contents)  

----------

<h2 id="earmilk-license">EARMILK License</h2>

Copyright (c) 2016 Earmilk.com
