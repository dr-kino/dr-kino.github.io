---
layout: article
title: Reversing a BIOS flash via hardware - First Steps
tags:
  - Reverse Engineering
  - Security
author:
  name: Rafael Cavalcanti
  url: /profile/rafaelcavalcanti/
licence: cc_attrib
---
Hello everyone!!!

This brief tutorial about dumping the BIOS (Basic Input/Output System) content directly via hardware (Programmer MiniPro TL866), will pass to you the procedure executed to get BIOS binary code. Other articles of this blog will cover binary contents analysis and some modifications based on its disassambly.

As you might know, BIOS is an important security component inside the system/computer. Keeping it always updated is indispensable! The code is stored in a non-volatile memory (Flash) that runs every time the computer starts. There are also some sistemic failures (hardware), as improper written permission allowing partially changes in the code. Ingenious BIOS atacks are very efficient achieving system administrative privilege.

Firstly, identify in the motherboard which memory stores the BIOS code. Historically this type of memory was known as CMOS due to the technology of the integrated circuit. Now a days, it is still usual to refer to this chip in this way. Anyway, you shall look for a Flash memory. This tutorial is using a motherboard (0HN7XN) present in a computer DELL Optiplex 380. The image bellow shows where the memory is located.

<img src="/images/posts/00001-A_CHANGED.png" />

The memory model that stores the BIOS code is MX25L1605 and its encapsulation is SOP8.

To read the memory content we need to remove it from the circuit board. To do this, use a iron soldering with a temperature of 250°C, solder sticks with a low melting point and after heating the chip terminals, remove it with a tweezers.

Then, solder the memory in an adapter board (DIP) to be able to read the memory with Programmer MiniPro TL866. The image bellow shows the final result.

<img src="/images/posts/00001-B.png" />

Now we have the hardware finished to reading, we are able to use a program that will control the Programmer MiniPro TL866. I used an open source program (https://github.com/vdudouyt/minipro) called "minipro", all informations about installation is provided in the page project. I installed the program in a Debian 9 (Stretch) system and I don't have any problems to do this.

To dump the BIOS binary, I entered with the line command bellow:

{% highlight text %}
sudo ./minipro -r images/flashmemory.bin -p "MX25L1605 @SOP8"
{% endhighlight %}

[RESULT I]

The rusult of binary dumped by minipro can be seen with the program "hexdump" ("# apt-get install hexdump", to install the program), for this enter with the line command bellow:

{% highlight text %}
hexdump -C images/cmos.bin
{% endhighlight %}

[RESULT II]

Now we use the program "binwalk" (# apt-get install binwalk ) to investigate the content dumped.

{% highlight text %}
binwalk -e images/cmos.bin
{% endhighlight %}

[RESULT III]

For a while I am going to restrict to say that the segment containing the BIOS is identified for "STING". So, we are going to extract the BIOS binary from this file entering with following line command:

{% highlight text %}
dd if=images/cmos.bin of=images/bios_dell.bin bs=1 skip=65544 count=116830
{% endhighlight %}

We certificate that the content is correct running the program "binwalk" again and we compare the output with the output we get in first time we run this program.

{% highlight text %}
binwalk -e images/bios_dell.bin
{% endhighlight %}

[RESULT IV]

Now we can only see the BIOS binary in a file!

{% highlight text %}
hexdump -C images/bios_dell.bin | head
{% endhighlight %}

Well, now that we extract the BIOS content from Flash memory we go take a look better inside the file using a collection of tools called "pev" (https://www.github.com/merces/pev). It comprises some programs to analyzer PE files. Hummm, maybe a new word?! So, the BIOS is a program defined like Portable Executable and in the next articles we talk more about this type of file and its format, I will explain mor about its goals and structure.

The program "readpe", contained inside pev tools, is used to do some analyzis. We could investigate the bios_dell.bin typing the line command bellow:

{% highlight text %}
readpe --header optional bios_dell.bin
{% endhighlight %}

The command above return some informations about header of my BIOS. If you want to realize your own test, you can download the BIOS binary that we used here on (ADDRESS), before you using, please verify the file integrity with the hash bellow:

[HASH]

This is all for now. I hope that this contents is useful and from it you continue studying the reverse engineering subject. In a close future, I will teach how to be sure that the code segmented, in steps explained in this article, is correct and I will talk about how to disassembly the binary with a powerfull tool called Radare. In the next steps we will continue using some tools has been used up to here, maily the "readpe" and "binwalk".

I hope you had fun here!
