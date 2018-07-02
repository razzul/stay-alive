# stayalive
Stay Alive: wordpress plugin to check logged in user's status 

# Short Code

[sa_online_users]

# Download
[2.2.0](https://github.com/razzul/stay-alive/releases) latest version of **stay-alive**

# How to use it
*Update pusher details and callback function from admin [plugin page](http://localhost/wordpress-talk/wp-admin/options-general.php?page=stay-alive-admin)*

Apply the shortcode in your page or enable the widget

At any point of time in you application call javascript funciton 
```HTML
<script>
        // online users
        stay_alive.users()
        
        // number of online users
        stay_alive.count()
        
        // your details
        stay_alive.me()
</script>
```

It will return user online status as `true` and `false` as per login in status in json format like below: 

```JSON
{1: {name: "admin"}, 2: {name: "Rajul Mondal"}}
```

# Installation 
Step 1: [Download](https://github.com/razzul/stay-alive/releases) latest version of **stay-alive** 

Step 2: Extract the file under `your_project\wp-content\plugins\` <br>
        OR<br>
        Open [Plugin installation](http://localhost/wordpress-talk/wp-admin/plugin-install.php) page and upload the file
        
![alt tag](https://raw.githubusercontent.com/razzul/stay-alive/master/screenshoots/plugin-installer.jpg)

Step 3: Go to `your_project\wp-content\plugins\stay-alive\` run `composer install`<br>
**N.B.:** In case you don't have composer installed in your system [download](https://getcomposer.org/download/) composer then run `composer install` again

Step 4: Activate the plugin

![alt tag](https://raw.githubusercontent.com/razzul/stay-alive/master/screenshoots/plugins-page.jpg)

Step 5: Go to **stay-alive** admin page to update pusher credential from the menu **`Settings -> stay-alive`**

![alt tag](https://raw.githubusercontent.com/razzul/stay-alive/master/screenshoots/menu.jpg)

![alt tag](https://raw.githubusercontent.com/razzul/stay-alive/master/screenshoots/plugin-admin.jpg)

To get Pusher credentials go to pusher dashboard and create new channel app 
![alt tag](https://raw.githubusercontent.com/razzul/stay-alive/master/screenshoots/pusher.jpg)

--------------------------------------------
# Please report issues over [here](https://github.com/razzul/stay-alive/issues/new)
