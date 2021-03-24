---
layout: article
title: Buffer Overflow Through Vulnerable Program (Linux OS)
tags:
  - reverseengineering
  - security
author:
  name: Rafael Cavalcanti
  url: /profile/rafaelcavalcanti/
licence: cc_attrib
---

The following program is an example of insecure implementation that enable the user to inject shell commands during its execution. It uses the system() function that executes commands into the host environment through the command processor and it returns after the command has
been completed.

#### System Function Declaration
```c
int system(const char *command)
```

#### Parameters
* command -  C string containing the name of the requested variable.

#### Return Value
* The value returned is -1 on error, and the return status of the command otherwise.

### Vulnerable Program

```c
#include <string.h>
#include <stdio.h>

int systemInfo(char *userName, char *systemInfo) {
        char userNameBuf[50];
        char systemInfoBuf[50];

        printf("userName buffer address:    %x\n", userNameBuf);
        printf("systemInfo buffer address: %x\n", systemInfoBuf);

        strcpy(userNameBuf, userName);
        strcpy(systemInfoBuf, systemInfo);

        printf("User Name: %s!\n", userNameBuf);
        printf("System Info: %s\n", systemInfoBuf);

        fflush(stdout);
        system(systemInfoBuf);
}

main() {
        char userName[200];

        printf("Please, insert your user name:\n");
        scanf("%s", userName);

        systemInfo(userName, "uname -a");
}
```

Save the code in a file and compile the program using the gcc command below:
```c
gcc -g -fno-stack-protector -z execstack <file-name.c> -o <file-name>
```

The option -g passed to gcc means that the compiler will generate debug information to be used by GDB debugger, the -fno-stack-protector disables the stack protection check and -z option