---
layout: article
title: Test coverage using Google Test, GCov and LCov
tags:
  - softwaredevelopment
author:
  name: Rafael Cavalcanti
  url: /profile/rafaelcavalcanti/
licence: cc_attrib
---

This post will describe a setup to start working with test coverage. First of all, I would like to highlight the GitHub link of this project [BraveCoverage](https://github.com/dr-kino/BraveCoverage)

It is related to a very small piece of code to demonstrate how to start a project providing test coverage metrics. But for what it is important? In resume, there are many motives to do that but I like to concentrante in one: The Quality of Your Job. When you provide unit tests for your code it means that you are a person concerned about the quality of your delivered work and want to improve your skills, for instance. And the way to know if you are testing all the lines is through code coverage tool.

The tool chosen to execute code coverage is [gcov](https://linux.die.net/man/1/gcov), with this tool you will be able to know how many times the lines of your program was executed and if there are lines non executed by your tests cases. You can see the results provided by the gcov, basically it shows the total of line in your program and the lines runned by test program.

<img src="/images/posts/00005-E.png" />


``` 

```

<img src="/images/posts/00005-A.png" />

<img src="/images/posts/00005-C.png" />

<img src="/images/posts/00005-B.png" />

<img src="/images/posts/00005-D.png" />
