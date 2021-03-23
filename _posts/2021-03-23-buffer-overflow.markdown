---
layout: article
title: Buffer Overflow Through Vulnerable Program (Linux OS)
tags:
  - security
author:
  name: Rafael Cavalcanti
  url: /profile/rafaelcavalcanti/
licence: cc_attrib
---

The following program is an example of insecure implementation that enable the user to inject shell commands during its execution. It uses the system() function that executes commands into the host environment through the command processor and it returns after the command has
been completed.

### System Function Declaration

```c
int system(const char *command)
```

### Parameters

* command -  C string containing the name of the requested variable.

### Return Value

* The value returned is -1 on error, and the return status of the command otherwise.