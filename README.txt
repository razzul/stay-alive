=== Stay Alive ===

Contributors: rajulmondal5
Donate link: https://profiles.wordpress.org/rajulmondal5
Tags: users, online, active, live, pusher, chat, login
Requires at least: 2.4.1
Tested up to: 2.4.1
Stable tag: 2.4.1
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Stay Alive wordpress plugin to check online user's in your website in just minutes with widget or shortcode using Pusher 3rd party socket service.

== Description ==

* Stay Alive plugin will help you to show online users 
* Plugin is manageable using widget and shortcode 
* Pusher credentials are need to use this plugin

<a target="_blank" href="https://profiles.wordpress.org/rajulmondal5">wordpress.rajulmondal5</a> | <a target="_blank" href="https://github.com/razzul">github.razzul</a>

= Features =
<ul>
	<li><strong>Online Users list</strong></li>
	<li><strong>Manageable Widget</strong></li>
	<li><strong>Short Code at any point</strong></li>
	<li><strong>Secure</strong>
	<li><strong>Free for all</strong>
	<li><strong>Pusher</strong>

== Screenshots ==

1. Plugin installation
2. Plugins activation
3. Menu
4. Plugin admin page
5. Pusher (//js.pusher.com/4.1/pusher.min.js)
6. Widget after activation

== Frequently Asked Questions ==

= Is it free ? =

Yes, it is free but as we are using pusher it has some limits

= What is the limit for pusher free account (FREE: Sandbox Plan) ? =

Yes, there is limit in pusher. 100 connections, 200,000 messages, and unlimited channels.

== Installation ==

* [Download](https://github.com/razzul/stay-alive/releases) latest version of **stay-alive** 
* Extract the file under `your_project\wp-content\plugins\` <br> OR <br> Open [Plugin installation](http://localhost/wordpress-talk/wp-admin/plugin-install.php) page and upload the file ![alt tag](https://raw.githubusercontent.com/razzul/stay-alive/master/screenshoots/1.jpg)
* Go to `your_project\wp-content\plugins\stay-alive\` run `composer install`<br>
  **N.B.:** In case you don't have composer installed in your system [download](https://getcomposer.org/download/) composer then run `composer install` again
* Activate the plugin ![alt tag](https://raw.githubusercontent.com/razzul/stay-alive/master/screenshoots/2.jpg)
* Go to **stay-alive** admin page to update pusher credential from the menu **`Settings -> stay-alive`** ![alt tag](https://raw.githubusercontent.com/razzul/stay-alive/master/screenshoots/3.jpg) ![alt tag](https://raw.githubusercontent.com/razzul/stay-alive/master/screenshoots/4.jpg) To get Pusher credentials go to pusher dashboard and create new channel app ![alt tag](https://raw.githubusercontent.com/razzul/stay-alive/master/screenshoots/5.jpg)

= Short Code =
[sa_online_users]

= Download =
[2.4.1](https://github.com/razzul/stay-alive/releases) latest version of **stay-alive**

= How to use it =
*Update pusher details and callback function from admin [plugin page](http://localhost/wordpress-talk/wp-admin/options-general.php?page=stay-alive-admin)* There are 2 ways to use it :
## 1. Apply the shortcode in your page 
```
[sa_online_users]
```
## 2. Enable widget: Stay Alive ![alt tag](https://raw.githubusercontent.com/razzul/stay-alive/master/screenshoots/6.jpg)

= 3rd Party Service = 
We have used Pusher as a 3rd party socket service provider for free. 
```
//js.pusher.com/4.1/pusher.min.js
```
--------------------------------------------
# Please report issues over [here](https://github.com/razzul/stay-alive/issues/new)

== Changelog ==

= 2.4.0 =
* 08-07-2018
* Updated readme.txt to mention pusher service used in our application
* https://github.com/razzul/stay-alive/releases

= 2.4.0 =
* 06-07-2018
* Added widget feature-option
* https://github.com/razzul/stay-alive/releases
  
== Upgrade Notice ==
* Added widget feature-option

== Official Site ==
* For More Information
* https://github.com/razzul/stay-alive
* Or Advanced feature drop mail:developer.rajul@gmail.com
