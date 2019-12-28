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

<center><img src="/images/posts/00006-E.jpg" alt="drawing" width="400" /></center>

<img src="/images/posts/00006-A.png" />

<img src="/images/posts/00006-B.png" />

<img src="/images/posts/00006-C.png" />

<img src="/images/posts/00006-D.png" />