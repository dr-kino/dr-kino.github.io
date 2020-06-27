---
layout: article
title: Heterogeneous Co-Simulation - Software and Hardware
tags:
  - embeddedsystems
  - digitalprocessing
author:
  name: Rafael Cavalcanti
  url: /profile/rafaelcavalcanti/
licence: cc_attrib
---

The idea to write this post appeared some years ago when I was working as a FPGA Developer, I was amazed with the possibility to test my stuffs in a complete simulated environment, my goal here is make this tutorial simple and guided by practical exercise to clarify the co-simulation usage. When I had the opportunity to work with this test methodology I really stayed excited, imagine test software and hardware (worlds completelly differents) interacting via command line, it was so cool.

I will go straigth on this subject but before the practice I will answer quicly two questions: Why use co-simulation and where I can apply this knowledgement? In resume, there are a lot of heterogeneous architectures and it is dependent of the technology, in general an architecture composed by different technologies responsible to process pieces of the project is considered a heterogeneous system  and is very painful to test and integrate it, using a co-simulation environment is  way to minimize this complex task and it is a smart approach to do this.

Here I will present a simulation environment focused in embedded systems that it architecture uses C and VHDL languages, it can be composed by microcontrollers and FPGA for instance, and  this kind of mechanism (co-simulation) is very usefull to spped up the development, tests and integration.

<img src="/images/posts/00014-A.png" />

<img src="/images/posts/00014-B.png" />

<img src="/images/posts/00014-C.png" />

<img src="/images/posts/00014-D.png" />

<img src="/images/posts/00014-E.png" />

<img src="/images/posts/00014-F.png" />

<img src="/images/posts/00014-G.png" />

<img src="/images/posts/00014-H.png" />
