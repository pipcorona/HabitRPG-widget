HabitRPG-widget
======

This project was designed to be used as a widget on your website to show your [HabitRPG](https://habitrpg.com) character and some stats on your own personal website. It can be used two different ways which are explained below. There is a WordPress specific version that [gersande](https://github.com/gersande) modified that is available [here](http://gersande.github.io/HabitRPG-widget/).

Running on your own server
------

To run this on your own server you will need the following files:

* get-character.php
* habitrpg.css (inside inc folder)
* habitrpg-api.php (inside inc folder)
* habitrpg and its contents in the img folder

After placing all the files where they belong, edit the habitrpg-api.php file to have your api key and user id for the appropriate variables. Then chmod the file to have read and write for user only (600) to keep those keys secure.

Wherever you want the widget to show up, use a php include and include get-character.php.

You also might need to edit the include or image paths if you don't have the files placed in the "inc" or "img" folder.

Running through an iframe
------

This method has two options. If you don't want to host all the files on your server you can accomplish this two ways.

###Method 1

Place the habitrpg-api.php file in your inc folder. Edit it to have you api key and user id and then chmod the file to read and write for user only (600) to keep those secure. Then grab the php include code from index.html between the method 1 tags. Place that at the very top of your webpage, even above the html tag. Then place the iframe code between the method one tags where you want it on your webpage. This will place an iframe that will display your info.

###Method 2

This method is the least secure but the only method I've been able to think of if you have a site where you want to display this but can't upload files (like blogger or something similar). In this one you copy the code from index.html between the method 2 tags and paste it where you want it. Then you have to replace PUT\_USER\_ID\_HERE and PUT\_API\_KEY\_HERE with your user id and api key. The reason this isn't secure is because those would be visible in the html source so someone could use that and then access your account through the API.