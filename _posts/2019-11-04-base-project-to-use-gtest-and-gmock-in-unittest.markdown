---
layout: article
title: Base project to use gtest and gmock for unit tests
tags:
  - embeddedsystems
author:
  name: Rafael Cavalcanti
  url: /profile/rafaelcavalcanti/
licence: cc_attrib
---

The goal of this post is to create a base to be used in all unit tests project that uses google test and google mock framework. Here I am configuring the environment for a Debian distribution and, of course, the commands below is valid only for distribution Debian based. So, first thing first, we need to install all dependencies as following:

```
#apt-get install libgtest-dev
#apt-get install google-mock
#apt-get install libgmock-dev
```

