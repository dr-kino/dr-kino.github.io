---
layout: article
title: Buffer Overflow Through Vulnerable Program (Unix OS)
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

### System Function Declaration
```c
int system(const char *command)
```

Parameters:
* command -  C string containing the name of the requested variable.

Return Value:
* The value returned is -1 on error, and the return status of the command otherwise.

### Program Compilation

```c
#include <string.h>
#include <stdio.h>

int systemInfo(char *userName, char *sysInfo){
        char sysInfoBuf[40];
        char userNameBuf[40];

        printf("userName buffer address:    %x\n", userNameBuf);
        printf("systemInfo buffer address: %x\n", sysInfoBuf);

	      strcpy(sysInfoBuf, sysInfo);
        strcpy(userNameBuf, userName);

	      printf("User Name: %s!\n", userNameBuf);
        printf("System Info: %s\n", sysInfoBuf);
        
	      fflush(stdout);
        system(sysInfoBuf);
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

The option -g passed to gcc means that the compiler will generate debug information to be used by GDB debugger, the -fno-stack-protector disables the stack protection check and -z option enables the stack to execute part of the program. In general this last compile flag (execstack) is passed to make our program less secure, by default gcc prevent buffer overflow exploits disabling some code in a program's data area or stack. If all writable addresses are non-executable, such an attack is prevented.

In Unix OS, the executable file (ELF) has in its header a field called PT_GNU_STACK that indicates whether an executable stack is needed. As mentioned before, by default gcc will mark the stack as non-executable. Lets invetigate this ELF field for each case.

Flag: execstack
<div style="text-align:center"><img src="/images/posts/00018-A.png" width="800" height="600" /></div>

Flag: noexecstack
<div style="text-align:center"><img src="/images/posts/00018-B.png" width="800" height="600" /></div>

### Running the Program

Executing the program via ./file-name, in my case ./bufOverflow, we have this result in the console:

<div style="text-align:center"><img src="/images/posts/00018-C.png" width="800" height="600" /></div>

Note that the addresses always change for each execution, it happens because the linux kernel randomize the base address of the stack. This is a point that is not really important in this example because, but just to test this mechanism we can execute the following command:

```c
# echo 0 > /proc/sys/kernel/randomize_va_space
```

The execution result after change the randomize_va_space parameter:

<div style="text-align:center"><img src="/images/posts/00018-D.png" width="800" height="600" /></div>

Now lets investigate deeper how is possible to insert malicious command in such kind of program. To do that we will use the gdb debugger to analyse the program flow and the stack.

Lets execute the gdb passing using the command ```$ gdb -q ./bufferOverflow```, then list the existing functions generated as symbols from compilation output. After this point, we will insert a break point at line 18 and we will continue running the program til it asks us to insert the username parameter. Lets enter 40 bytes/characters as following: 0000000011111111222222223333333344444444. Then we can proceed with the execution and see both buffers addresses, the user name one and system information.

Now the program execution stops at line 18, as we commanded previously through the break point insertion.

<div style="text-align:center"><img src="/images/posts/00018-E.png" width="800" height="600" /></div>

To analyse the register, we are going to execute the ```info list``` command in gdb, now we can see the base address of the stack pointer.

<div style="text-align:center"><img src="/images/posts/00018-F.png" width="800" height="600" /></div>

Executing the command ```x/80x $rsp``` we will 80 addresses of the stack. Note, highlighted in red, the userName variable and in yellow the systemInfo variable.

<div style="text-align:center"><img src="/images/posts/00018-G.png" width="800" height="600" /></div>

Now lets execute the program and enter the string bellow, then we will be able to see the ```ls -la``` command being executed.

```c
000000001111111122222222333333334444444455555555ls$IFS-la
```
 Then the command above will execute the command mentioned before.

 The problem on this program is happens because the input string is not handled in terms of size, if a simple test in the input size is done, then it can protect the stack against this kind of problem.