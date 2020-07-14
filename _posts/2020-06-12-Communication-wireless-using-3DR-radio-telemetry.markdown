---
layout: article
title: Communication wireless using 3DR Telemetry Radio 
tags:
  - rf
  - embeddedsystems
  - control
author:
  name: Rafael Cavalcanti
  url: /profile/rafaelcavalcanti/
licence: cc_attrib
---

The 3DR Radio is the easiest way to setup a telemetry connection between your autopilot and a ground station. Bellow you can see the simple test setup using a computer, any serial-usb adapter and a couple of telemetry radio, to prepare the setup you just need to connect the ground module directly in the computer USB port and the other module (Air Module) you will need the serial-usb connected in the following schema:

Air Module: Serial-USB Adapter

* Black (GND): GND
* Yellow (TX): RX
* Green (RX): TX
* Red (+5V): +5V

<div style="text-align:center"><img src="/images/posts/00010-A.png" width="500" height="400" /></div>

<div style="text-align:center"><img src="/images/posts/00010-C.png" width="300" height="200" /></div>

After complete the connection between the Air Module and the Serial-USB Adapter, you can choose any software to open the serial communication in your computer. In my case I am using the Minicom that is a text-based serial port communication program.

You can find the telemetry radio entering the following command:

```console
sudo dmesg | grep tty
```

Then you can see the USB-to-Serial adapter, in my case it was mapped in ttyUSB0 and ttyUSB1, and you can enter the following command to open the first connection:

```console
sudo minicom -D /dev/tty/USB0 -b 57600
```

And open another prompt command and type:

```console
sudo minicom -D /dev/tty/USB' -b 57600
```

After this point you can type any key in one of the terminal and you will see the key in the other terminal. It is important to say that Minicom uses as default configuration: 8-Bit Data, no parity and 1 stop-bit.

<div style="text-align:center"><img src="/images/posts/00010-D.png" /></div>

So, have fun!