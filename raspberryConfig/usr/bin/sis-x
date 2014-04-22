#!/bin/bash

if test "`whoami`" = "root"; then
     	echo "we are root - restarting"
	exec /bin/su - pi -c "$0"
        exit 1;
fi

echo "changing to /home/pi"

cd /home/pi

echo "executing x11"

startx
