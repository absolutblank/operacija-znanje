#!/usr/bin/env python

import RPi.GPIO as gpio
import time

gpio.setmode(gpio.BOARD)
gpio.setup(16, gpio.OUT)
gpio.setup(18, gpio.OUT)

p = gpio.PWM(16, 1000)

num_steps=1399
gpio.output(18, False)
while num_steps > 0:
        p.start(1)
        time.sleep(0.001)
        num_steps -= 1
p.stop()

time.sleep(1)

gpio.output(18, True)
while num_steps < 1399:
        p.start(1)
        time.sleep(0.001)
        num_steps += 1
p.stop()

gpio.cleanup()
