---
layout: article
title: KeePass Integration with AutoHotKey {In Progress}
tags:
  - security
  - taskautomation
author:
  name: Rafael Cavalcanti
  url: /profile/rafaelcavalcanti/
licence: cc_attrib
---

If you need to handle several passwords through some pass phrase manager like KeePass, I hope this post can help you to do less efort to get your passwords and bring it in a safe/secure way. To do that I propose a solution using KeePass and AutoHotKey tools, that will automate part of this process. Below I list the requirements for this little project:
  * Keep the KeePass data base safe;
  * Protect the KeePass master key safe; and
  * Clear any evidence about the keys extrated from the data base;

Basically this project will create a hostring (name given by AutoHotKey Tool) to get your password and to do that you will be asked for your master key of the KeePass Data Base that you will try to fetch the password.

Is important to say that any suggestion to make it more robust in terms of security will be welcome, and i would like to encourage you to raise a pull request with your suggestion or, if you prefer, just send me a message pointinf the improvements.

Unfortunately I do not have much time to explain about the Keepass neither AutoHotKey, but information regarding these tools can be easily found on the internet.
