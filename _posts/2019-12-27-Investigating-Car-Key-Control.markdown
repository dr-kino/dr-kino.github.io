---
layout: article
title: Investigating Car Key (RF Remote Control) With HackRF One - Part 1
tags:
  - reverseengineering
  - security
  - rf
author:
  name: Rafael Cavalcanti
  url: /profile/rafaelcavalcanti/
licence: cc_attrib
---

First of all, I would like to register that this post has no intention to teach how to break the laws, to ensure this I will omit the car model and suppress any other information that could open a window for malicius people. I want to mension that it is just a theme that should be developed for study and research purposes, I will write the next article as soon as relevant findings emerge. As I have no much time to be dedicated in this research, maybe it will take long time until next publication, because of this the current article will talsk a little bit about some tools devoted to Software Defined Radio, this way you can start your proper research related to SDR.

To write this post I am using the [HackRF One](https://greatscottgadgets.com/hackrf/one/) as a hadrware to interfaces with real world. The main characteristics of the HackRF hardware/project are:

    * 1 MHz to 6 GHz operating frequency
    * half-duplex transceiver
    * up to 20 million samples per second
    * 8-bit quadrature samples (8-bit I and 8-bit Q)
    * compatible with GNU Radio, SDR#, and more
    * software-configurable RX and TX gain and baseband filter
    * software-controlled antenna port power (50 mA at 3.3 V)
    * SMA female antenna connector
    * SMA female clock input and output for synchronization
    * convenient buttons for programming
    * internal pin headers for expansion
    * Hi-Speed USB 2.0
    * USB-powered
    * open source hardware

To identify the correct frequency of remote control I used a tool called osmocom_fft with -F as parameter, you can see below the interface and highlighted, in red color, is possible to see the signal from remote control. To find this frequency I used the internet to research the most common RF signal characteristics, after tune the SDR in 433MHz was possibel to see the signal 1.8MHz (+) diverted from the center.

<img src="/images/posts/00006-A.png" />

In the video below is possible to see the time behaviour of signal as well as the deviation from 433MHz frequency.

<center><iframe width="560" height="315" src="https://www.youtube.com/embed/cPqFquCdkTw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></center>

Next steps will be analyse the data, probably I will need to investigate hot to decoding the signal, before that of course I will try to open my car with replay attack. I believe it will not work because for this kind of system the minimum security mechanism used to be present.

In two next image is possible to observe that the signal is using the [Amplitude Modulation](https://en.wikipedia.org/wiki/Amplitude_modulation) ASK (short brief on wiki). Another thhing that could be noticed is related to the first part of the transmission, there are 14 square waveform cycles, it is used to synchonize transmitter and receiver targets.

<img src="/images/posts/00006-B.png" />

<img src="/images/posts/00006-C.png" />

## Gnu Radio Companion

With [Gnu Radio Companion](https://www.gnuradio.org/)

<img src="/images/posts/00006-D.png" />

<center><iframe width="560" height="315" src="https://www.youtube.com/embed/8gAM07suhzY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></center>