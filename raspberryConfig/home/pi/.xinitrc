#!/bin/bash

#x-terminal-emulator

xset s off
xset -dpms
xset s noblank

bsetbg -center Downloads/background.png

unclutter & 

name=`cat /etc/sis.conf`
chromium-browser --app="http://sis.clients.htlinn.ac.at/monitors/?$name" &

i () {
	sleep 1s
	bsetbg -center Downloads/background.png
}

h () {
	sleep 20s
	xdotool key F11
}

h &
i &
blackbox
