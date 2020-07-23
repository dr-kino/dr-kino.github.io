---
layout: article
title: Beaglebone Black - Soldering Jtag Connector 
tags:
  - hardware
author:
  name: Rafael Cavalcanti
  url: /profile/rafaelcavalcanti/
licence: cc_attrib
---

The mostly goal in this article is to show how to soldering a JTAG connector in the Beaglebone Black (BBB) board, then in the next post I hope to show you how to connect it with J-Link Segger 8.08.90, at least if it works :). Otherwise, at least you can see here the pinout related to P2 connector in BBB.

<div style="text-align:center"><img src="/images/posts/00017-A.png" width="600" height="400" /></div>

To execute this job I am using a wire-rapping 32 AWG, the final work in the board you can see in the next image. Note that the P2 mark in BBB is in the left side, it means that the schematic is inverted with the board image.

<div style="text-align:center"><img src="/images/posts/00017-B.png" width="600" height="400" /></div>

<div style="text-align:center"><img src="/images/posts/00017-D.png" width="300" height="300" /></div>

Regarding the connector in J-Link probe, you can see the pinout below and is very important to say that the reference for the pinout is not the cable, but the probe box. At the first time that I soldered the wires it not worked because I took as reference the cable.

<div style="text-align:center"><img src="/images/posts/00017-E.png" width="300" height="300" /></div>

<div style="text-align:center"><img src="/images/posts/00017-I.png" width="500" height="400" /></div>

Below you can see the final results:

<div style="text-align:center"><img src="/images/posts/00017-F.png" width="500" height="400" /></div>

And the success to connect the J-Link to the target, in the BBB the target is a TI (Texas Instruments) AM3359 - ARM Cortex-A8.

<div style="text-align:center"><img src="/images/posts/00017-G.png" width="600" height="400" /></div>

<div style="text-align:center"><img src="/images/posts/00017-H.png" width="600" height="400" /></div>

