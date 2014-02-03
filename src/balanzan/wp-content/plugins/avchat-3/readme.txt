=== Video Chat Plugin ===
Tags: chat, video chat, chatroom, flash, flash video chat, flash chat, videochat, streaming, image, images, red5, fms, wowza, avchat, Buddypress
Requires at least: 3.0.0
Tested up to: 3.8
Stable tag: 1.4.2
Version : 1.4.2
Contributors: stefan.avchat, naicuoctavian, radu.patron
License: GPLv2 or later

The AVChat Video Chat Plugin for WordPress is designed to increase members engagement and web site revenues with a stunning video chat solution.

== Description ==

> #### 05 March Update !!! The HTML5 version is now compatible with the Red5 media server!
> #### 21 December Update! Now you can chat from your tablets or mobile phones with the HTML5 version of AVChat 3. You can benefit form the mobile version if you have <a href='https://www.adobe.com/cfusion/tdrc/index.cfm?product=adobemediaserver'>Adobe Media Server (ex FMS)</a>.


The Video Chat Plugin for WordPress handles the integration between AVChat and your WordPress website.

<a href='http://avchat.net' onclick="window.open(this.href);return false;" title='AVChat software'>AVChat</a> is an highly appreciated video chat script that can be hosted by you and installed on your website. You can find out <a href='http://avchat.net' onclick="window.open(this.href);return false;" title='AVChat software'>more about it</a> and purchase it from <a href='http://avchat.net/buy-now' onclick="window.open(this.href);return false;" title='Buy AVChat'>here</a>.

If you have AVChat then this Standard version of the plugin will take care of :

* username integration (users logged in the WordPress web site will not have to login again in the video chat )
* setting up the most important permissions/limits/features for each user role from WordPress admin area
* compatible with BuddyPress: BuddyPress avatars are automatically recognized and added to users profiles in the video chat (users profiles can be accessed directly from AVChat also)
* visitors are able to login with Facebook
* compatible with SEO friendly URL's in WordPress

The above features are for the Standard version which you can use to see the potential of the video chat solution on your site. You can download it for free from this page.

> #### Get your  <a href='http://avchat.net/integrations/wordpress' title='AVChat plugin for WordPress'>PRO version </a>  now !!! .  
> Offering more advanced features, multisite support, additional settings and permissions, free installation and 3 months of support and updates, the <a href='http://avchat.net/integrations/wordpress' title='AVChat Video Chat plugin for WordPress'>AVChat Video Chat plugin PRO</a> is the ultimate sollution for a perfect WordPress video chat. 

With the PRO version you get more than 28 new configuration options and permissions that you can customize for each user role. Also you get free installation and 3 months of full support and updates. And of course, our gratitude for helping us sustain this plugin and for the countless late-night hours that have been poured into development.

The AVChat Video Chat plugin for WordPress is licensed under GPL v2. See the full text of the GPL v2 license in license.txt.

> #***"Our users are very happy with the chat system and we see that more and more are using it every day... outstanding email support... quick to reply and always extremely helpful...easy to setup and reliable chat system"*** -
Mike Johnsen.  


== Installation ==
These instructions cover installing the Standard version of the plugin (available on this page on wordpress.org/plugins). The installation instructions for the PRO version are at http://avchat.net/support/documentation/wordpress together with more documentation.

For this plugin to work, **you first need to purchase (or get a 15 days trial) the AVChat 3 Video Chat software ** from <a href='http://avchat.net' title='Purchase AVChat Video Chat Software'>here</a>. This plugin only takes care of the integration between WordPress and the AVChat 3 software. It does not contain the actual AVChat 3 software.

Once you purchase or get a trial of AVChat 3 from the http://avchat.net website, follow these steps :

0. Download the plugin archive (avchat-3.1.4.1.zip) from this page.
1. Upload the **avchat-3** folder (from the avchat-3.1.4.1.zip archive) to your **/wp-content/plugins** folder.
2. Download the AVChat archive (AVChat 3.0 Build XXXX.zip) from the link sent by avchat.net.
3. Extract the archive and upload the contents of the **Files to upload to your web site** to your new **/wp-content/plugins/avchat-3/** folder.
4. Go to the WordPress admin area - > Plugins page and activate the **AVChat Video Chat Plugin for WordPress** plugin.
5. Go to the WordPress admin area -> Settings -> AVChat 3 and  set the **Connection string** to: **rtmp://my-media-server.com/avchat30/_definst_** where my-media-server.com is the domain name or ip of the dedicated/VPS server where your media server is installed.
6. Set up the **avchat30** app on your media server. Details at http://avchat.net/support/documentation/wordpress#111 .
7. Create a new page on your WordPress website with this content: **[chat]**.
8. Go to that page and enter the video chat. You will be asked for the license key (it's in your private client/trial area on nusofthq.com).

Get **FREE** installation with the <a href='http://avchat.net/integrations/wordpress' title='AVChat Plugin for WordPress'>PRO version </a> of the plugin, plus much more features that you can customize to make the chat the way you want it.

For further information, see <a href='http://avchat.net/support/documentation/wordpress' title='AVChat Plugin for WordPress Documentation'>our detailed WP documentation</a>.

== Frequently Asked Questions ==

= What do I need to use this plugin ? =

A WordPress web site, AVChat 3 from http://avchat.net/ and a media server.

= Why do I need a media server ? =

AVChat - and all video chat web apps - uses a media server to send real time audio video and text between users.

= What media servers does AVChat support ? =

Red5, AMS Pro and Wowza. For a complete list of supported versions please visit http://avchat.net/support/requirements#fms .
Red5 is free and open source: http://code.google.com/p/red5/
Wowza: http://www.wowza.com/
Adobe Media Server Pro: http://www.adobe.com/products/adobe-media-server-professional.html

= What if I need help ? =

1. Post a question in the Support area of this page: http://wordpress.org/support/plugin/avchat-3
2. Post a question in our official support forum: http://nusofthq.com/forum/index.php?/forum/3-avchat-3-httpavchatnet/ (free account needed).

AVChat customers also receive dedicated tech support by email.

== Screenshots ==

1. Video chat with another person

2. Login Screen 

3. Create a new room

4. Video chat permissions 

5. Video chat settings

6. PRO vs Standard

7. PRO vs Standard

== Changelog ==

= 1.4.2 (14.01.2014) =
* Fixed security issue

= 1.4.1 (28.10.2013) = 
* Fixed issue with tablets not receiving the mobile version *
* Fixed issue with permissions not loading correctly in some cases *
* Fixed issue with "Headers already sent" error when using AVChat in pop up *
* Visitors and logged in members can not change their chat username (visitors get a random visitor_XYZ username) *
* Admins do not get 99 maxRoomsOneCanBeIn, 99 maxStreams and unlimited freeVideoTime anymore. All their abilities are controlled from the WP backend *

= 1.4.0 (10.05.2013) = 
* Updated plugin description in WP Plugins backend area
* Added FP 11.1 requirement to match the FP requirement in the recent 2330 AVChat 3 build: http://avchathq.com/blog/avchat-build-2330-introduces-h-264-support/
* Better detection for missing JavaScript and Flash Player version
* Better AVChat 3 files detection
* Better mobile device detection
* FB application ID is now sent to AVChat 3 even when the plugin is configured to open AVChat 3 in a pop-up
* Removed default FB app id
* Better JS code for opening up AVChat 3 in an pop-up window
* WP Administrators are now granted access by default, through a pre-checked permission, to the admin area of AVChat 3 (admin.swf) 
* Fixed issue that made it impossible to deny WP Administrators access to the admin area of AVChat 3 (admin.swf)
* Fixed issue that prevented the permissions from being applied to WP Administrators
* Default visitors usernames will now have the "visitor_" prefix instead of the "user_" prefix
* The admin column was not present in the AVChat 3 Settings & Permissions page
* Better explanation of AVChat 3 permissions and options in the AVChat 3 Settings & Permissions page

= 1.3.3 (11.04.2013) =
* fixed some minor typos including removing the "PRO" from the plugin name as it shows up in the WP backend

= 1.3.2 (06.03.2013) =

= 1.3.1 (21.02.2013) =

= 1.3 (17.12.2012) =
* *NEW!*     HTML5 mobile version, now available for iOS and Android. Automatic recognition of mobile version.
* Added support for Administrators user role.
* Don't miss new messages. Now you will see if you have notifications in the browser tab, while browsing other tabs.
* Fixed issue with chat appearing lower on the page.

= 1.2.1 (29.11.2012) =
* Added support to know when the AVChat files are not copied into the plugin directory.
* Fixed bug with javascripts missing.
* Removed padding in AVChat Settings in WordPress backend.
* More explicit texts in AVChat Settings in WordPress backend.
 
= 1.2 (27.11.2012) =
* Added Facebook integration.
* Added iPad detection.
* Added new "Visitors" column to better control what a visitor can have access to.
* Added lots of new features in WordPress backend.
* Now the changes made to the background are made from the style.css and not from the WordPress backend settings.
* Fixed the bug where guests can access the admin area of AVChat.
* Fixed the bug where the added user roles were not recognized by the AVChat and were not saved the changes made in WordPress backend.
 
= 1.1 (29.10.2012) =
* Fixed bug with "session already sent".
* Fixed the bug where IE didn't recognize the path to the video chat and couldn't log in.
* Updated the documentation.
 
= 1.0 (12.06.2012) =
* First release in WordPress plugin directory.