#!/bin/bash

if test "`whoami`" != "root"; then
        echo "You are not root!"
        exit 1;
fi

echo 4 > /sys/class/gpio/export 2>&1
echo out > /sys/class/gpio/gpio4/direction
echo 0 > /sys/class/gpio/gpio4/value

