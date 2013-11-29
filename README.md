Christmasleds
=============

An Arduino project for (web page controled) christmas tree lights.

How it works
------------
On one end a  chain of RGB leds is attached to an Arduino UNO with the 
ethernet shield. On the other end there is a web page that lets the user
describe how the colors are to change: For each color (red/green/blue)
the user writes a function f(t)=A*sin*((B/C)t+D)+E by deciding values for the
contstants A, B, C, D and E.

With the help of a custom designed protocol, these three functions are transferd
via the internet (or LAN) to the Arduino which updates the leds.

Can I try it?
-------------
Here is a video demonstrating this project:

<!--
During a limited time you can also control the leds and watch with a web cam 
on [this](http://tallr.se/julgran) page (in Swedish, you could probably use 
Google Translate, or go directly to the bottom of the page). If you see this
text, the web cam should be online.
-->

How do I build one of these?
----------------------------
1. Get yourself one or more RGB leds, an Arduino, an Arduino ethernet shield,
   some wires and basic soldering gear. You probably need some resistors and
   transistors as well. 
2. For each color channel, connect a PWM port on the Arduino to a transistor.
3. Use resistors to limit the current flowing through the leds and connect to 
   the tranistors so you are able to control the leds without draining a high
   current from the Arduino pins.
4. Adjust your LAN settings (such as gateway and ip address) and load the .ino
   file. Also set the host in christmastree.php to the correct ip address.
5. Move christmastree.php and index.php to a web server (local, or do some port
   forwarding).
5. Connect the Arduino to a power source and the ethernet shield to your LAN. 
   Naviage to index.php in a browser.
6. Have fun!
