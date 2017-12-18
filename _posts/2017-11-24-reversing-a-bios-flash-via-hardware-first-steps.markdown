---
layout: article
title: Reversing a BIOS flash via hardware - First Steps
tags:
  - reverseengineering
  - security
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

The rusult of binary dumped by minipro can be seen with the program "hexdump" ("# apt-get install hexdump", to install the program), for this enter with the line command bellow:

{% highlight text %}
hexdump -C images/cmos.bin
{% endhighlight %}

{% highlight text %}
00000000  da 00 00 00 00 00 00 00  00 00 00 00 00 00 00 00  |................|
00000010  00 00 00 00 00 00 00 00  00 00 00 00 00 00 00 00  |................|
*
00000040  00 00 00 20 20 20 20 20  20 20 20 20 20 20 20 20  |...             |
00000050  20 20 20 20 20 20 20 20  20 20 20 20 20 20 20 20  |                |
*
00000090  20 20 00 e0 b9 23 8c aa  61 24 42 42 53 00 03 00  |  ...#..a$BBS...|
000000a0  04 01 00 03 02 ff ff ff  ff ff ff ff ff ff ff ff  |................|
000000b0  ff ff ff ff ff ff ff 01  00 00 80 4b 5f 00 f0 09  |...........K_...|
000000c0  ea 00 f0 02 00 01 09 cc  5f 00 f0 41 ea 00 f0 05  |........_..A....|
000000d0  00 ff 00 66 14 80 cc d8  e9 00 f0 03 00 02 81 e0  |...f............|
000000e0  5d 00 f0 25 ea 00 f0 25  d4 91 5c 5a 48 44 22 11  |]..%...%..\ZHD".|
000000f0  02 02 76 75 73 76 77 74  70 77 73 72 79 72 73 75  |..vusvwtpwsryrsu|
00000100  73 74 07 07 00 10 00 50  a5 ce da 0f 54 24 14 73  |st.....P....T$.s|
00000110  04 64 15 24 64 73 54 74  34 55 25 24 00 a0 30 30  |.d.$dsTt4U%$..00|
00000120  20 50 70 71 90 90 00 20  10 40 50 50 14 15 01 02  | Ppq... .@PP....|
00000130  12 05 03 00 13 13 14 10  16 06 06 03 21 10 20 20  |............!.  |
00000140  21 20 20 00 10 10 21 21  21 20 20 20 60 50 80 90  |!  ...!!!   `P..|
00000150  80 00 20 11 30 30 60 70  70 a0 00 a0 03 04 04 11  |.. .00`pp.......|
00000160  01 11 13 15 06 05 01 02  03 15 10 13 10 10 10 10  |................|
00000170  10 21 21 01 10 10 10 10  10 10 21 10 80 ce 00 00  |.!!.......!.....|
00000180  80 ce 30 09 00 00 01 94  00 00 01 94 04 4b 0c 33  |..0..........K.3|
00000190  53 48 35 36 34 35 36 38  46 48 38 4e 36 4c 43 53  |SH564568FH8N6LCS|
000001a0  46 47 53 48 35 36 34 35  36 38 46 48 38 4e 36 50  |FGSH564568FH8N6P|
000001b0  48 53 46 47 06 10 16 00  06 00 00 00 ff ff ff ff  |HSFG............|
000001c0  ff ff ff ff ff ff ff 42  52 30 48 4e 37 58 4e 31  |.......BR0HN7XN1|
000001d0  30 38 31 39 30 34 43 30  30 45 42 00 41 30 30 00  |081904C00EB.A00.|
000001e0  69 20 20 20 20 20 20 20  20 20 20 40 ff ff ff ff  |i          @....|
000001f0  ff ff ff ff ff ff ff ff  ff ff 0c 8c c0 cd 60 01  |..............`.|
00000200  61 00 62 00 63 e0 64 00  65 00 66 00 67 00 90 10  |a.b.c.d.e.f.g...|
00000210  91 11 92 11 93 00 94 00  95 00 96 00 52 50 53 03  |............RPS.|
00000220  97 00 98 40 99 00 9a 4b  9b 00 b0 00 b1 d0 9e 39  |...@...K.......9|
00000230  a0 40 a1 00 a2 00 a3 13  a4 00 a5 00 a6 00 a7 ce  |.@..............|
00000240  a8 00 a9 00 aa e0 ab cd  ac 00 ad 00 ae d0 af cd  |................|
00000250  fe 00 02 10 01 02 00 02  02 20 03 02 00 04 02 20  |......... ..... |
00000260  05 02 00 06 02 20 07 02  00 08 02 86 09 02 86 0a  |..... ..........|
00000270  02 00 0b 02 00 50 02 99  51 02 04 52 02 3c 53 02  |.....P..Q..R.<S.|
00000280  f0 54 02 88 55 02 06 56  02 78 57 02 74 58 02 49  |.T..U..V.xW.tX.I|
00000290  59 02 e8 5a 02 0e 69 02  4b 6a 02 d0 6b 02 cf 6c  |Y..Z..i.Kj..k..l|
000002a0  02 37 6d 02 5f 6e 02 55  9c 02 78 9d 02 07 9e 02  |.7m._n.U..x.....|
000002b0  00 9f 02 00 00 06 10 01  06 00 02 06 20 03 06 00  |............ ...|
000002c0  04 06 20 05 06 00 06 06  20 07 06 00 08 06 86 09  |.. ..... .......|
000002d0  06 86 0a 06 00 0b 06 00  50 06 99 51 06 04 52 06  |........P..Q..R.|
000002e0  3c 53 06 f0 54 06 88 55  06 06 56 06 78 57 06 74  |<S..T..U..V.xW.t|
000002f0  58 06 49 59 06 e8 5a 06  0e 69 06 4b 6a 06 d0 6b  |X.IY..Z..i.Kj..k|
00000300  06 cf 6c 06 37 6d 06 5f  6e 06 55 9c 06 78 9d 06  |..l.7m._n.U..x..|
00000310  07 9e 06 00 9f 06 00 ff  ff 05 05 05 05 05 05 05  |................|
00000320  05 05 05 05 05 05 05 05  05 00 00 00 00 00 00 00  |................|
.
.
.
001ffed0  ff ff ff ff 32 30 31 30  30 34 32 30 32 30 31 30  |....201004202010|
001ffee0  30 36 30 37 ff ff ff ff  ff ff ff ff 43 52 54 43  |0607........CRTC|
001ffef0  02 02 02 02 02 02 02 02  02 02 02 02 02 02 02 02  |................|
001fff00  42 52 30 48 4e 37 58 4e  31 30 38 31 39 30 34 43  |BR0HN7XN1081904C|
001fff10  30 30 45 42 00 41 30 30  00 69 ff ff ff ff ff ff  |00EB.A00.i......|
001fff20  ff ff ff ff ff ff ff ff  ff ff ff ff ff ff ff ff  |................|
001fff30  43 6f 70 79 72 69 67 68  74 20 31 39 38 35 2d 31  |Copyright 1985-1|
001fff40  39 38 38 20 50 68 6f 65  6e 69 78 20 54 65 63 68  |988 Phoenix Tech|
001fff50  6e 6f 6c 6f 67 69 65 73  20 4c 74 64 2e 20 20 20  |nologies Ltd.   |
001fff60  43 6f 70 79 72 69 67 68  74 20 31 39 38 38 2d 32  |Copyright 1988-2|
001fff70  30 30 39 20 44 65 6c 6c  20 49 6e 63 2e 20 20 20  |009 Dell Inc.   |
001fff80  20 20 20 20 20 20 20 20  20 20 20 20 20 20 20 20  |                |
001fff90  41 6c 6c 20 72 69 67 68  74 73 20 72 65 73 65 72  |All rights reser|
001fffa0  76 65 64 2e 00 ff ff ff  ff ff ff ff ff ff ff ff  |ved.............|
001fffb0  44 65 6c 6c 20 53 79 73  74 65 6d 20 33 38 30 00  |Dell System 380.|
001fffc0  00 00 00 00 00 00 00 00  00 00 00 00 00 00 00 00  |................|
*
001fffe0  41 30 31 fe 00 04 00 01  41 30 31 fe 00 04 00 01  |A01.....A01.....|
001ffff0  e9 ed 9c ff ff ff ff ff  ff ff ff ff ff ff ff ff  |................|
00200000
{% endhighlight %}

Now we use the program "binwalk" (# apt-get install binwalk ) to investigate the content dumped.

{% highlight text %}
binwalk -e images/cmos.bin
{% endhighlight %}

{% highlight text %}
DECIMAL       HEXADECIMAL     DESCRIPTION
--------------------------------------------------------------------------------
65544         0x10008         Microsoft executable, portable (PE)
182374        0x2C866         Copyright string: "Copyright (C) 2000-2003 Intel Corp. All Rights Reserved."
2015309       0x1EC04D        Copyright string: "Copyright 2008 JETWAY SECURITY MICRO.INC   Build on 2008-05-04"
2086230       0x1FD556        mcrypt 2.2 encrypted data, algorithm: blowfish-448, mode: CBC, keymode: 8bit
2096944       0x1FFF30        Copyright string: "Copyright 1985-1988 Phoenix Technologies Ltd. Copyright 1988-2009 Dell Inc.   All rights reserved."
2096992       0x1FFF60        Copyright string: "Copyright 1988-2009 Dell Inc.   All rights reserved."
{% endhighlight %}

For a while I am going to restrict to say that the segment containing the BIOS is identified for "STING". So, we are going to extract the BIOS binary from this file entering with following line command:

{% highlight text %}
dd if=images/cmos.bin of=images/bios_dell.bin bs=1 skip=65544 count=116830
{% endhighlight %}

We certificate that the content is correct running the program "binwalk" again and we compare the output with the output we get in first time we run this program.

{% highlight text %}
binwalk -e images/bios_dell.bin
{% endhighlight %}

{% highlight text %}
00000000  4d 5a 90 00 03 00 00 00  04 00 00 00 ff ff 00 00  |MZ..............|
00000010  b8 00 00 00 00 00 00 00  40 00 00 00 00 00 00 00  |........@.......|
00000020  00 00 00 00 00 00 00 00  00 00 00 00 00 00 00 00  |................|
00000030  00 00 00 00 00 00 00 00  00 00 00 00 c0 00 00 00  |................|
00000040  0e 1f ba 0e 00 b4 09 cd  21 b8 01 4c cd 21 54 68  |........!..L.!Th|
00000050  69 73 20 70 72 6f 67 72  61 6d 20 63 61 6e 6e 6f  |is program canno|
00000060  74 20 62 65 20 72 75 6e  20 69 6e 20 44 4f 53 20  |t be run in DOS |
00000070  6d 6f 64 65 2e 0d 0d 0a  24 00 00 00 00 00 00 00  |mode....$.......|
00000080  5d e5 ea c6 19 84 84 95  19 84 84 95 19 84 84 95  |]...............|
00000090  97 93 8b 95 18 84 84 95  97 93 e7 95 1c 84 84 95  |................|
{% endhighlight %}

Now we can only see the BIOS binary in a file!

{% highlight text %}
hexdump -C images/bios_dell.bin | head
{% endhighlight %}

Well, now that we extract the BIOS content from Flash memory we go take a look better inside the file using a collection of tools called "pev" (https://www.github.com/merces/pev). It comprises some programs to analyzer PE files. Hummm, maybe a new word?! So, the BIOS is a program defined like Portable Executable and in the next articles we talk more about this type of file and its format, I will explain mor about its goals and structure.

The program "readpe", contained inside pev tools, is used to do some analyzis. We could investigate the bios_dell.bin typing the line command bellow:

{% highlight text %}
readpe --header optional bios_dell.bin
{% endhighlight %}

{% highlight text %}
Optional/Image header
    Magic number:                    0x10b (PE32)
    Linker major version:            7
    Linker minor version:            10
    Size of .text section:           0x65a0
    Size of .data section:           0x1680
    Size of .bss section:            0
    Entrypoint:                      0
    Address of .text section:        0x220
    Address of .data section:        0x67c0
    ImageBase:                       0xffe10008
    Alignment of sections:           0x20
    Alignment factor:                0x20
    Major version of required OS:    4
    Minor version of required OS:    0
    Major version of image:          0
    Minor version of image:          0
    Major version of subsystem:      4
    Minor version of subsystem:      0
    Size of image:                   0x7e40
    Size of headers:                 0x220
    Checksum:                        0
    Subsystem required:              0x3 (IMAGE_SUBSYSTEM_WINDOWS_CUI)
    DLL characteristics:             0
    DLL characteristics names
    Size of stack to reserve:        0x100000
    Size of stack to commit:         0x1000
    Size of heap space to reserve:   0x100000
    Size of heap space to commit:    0x1000
{% endhighlight %}

The command above return some informations about header of my BIOS. If you want to realize your own test, you can download the BIOS binary that we used here on (https://github.com/dr-kino/Data/tree/master/bios/images.zip), before you use, please verify the file integrity with the hash (sha1sum) bellow:

{% highlight text %}
c9ae0279e536f47cee49d71a477bdf33695a14c5
{% endhighlight %}

This is all for now. I hope that this contents is useful and from it you continue studying the reverse engineering subject. In a close future, I will teach how to be sure that the code segmented, in steps explained in this article, is correct and I will talk about how to disassembly the binary with a powerfull tool called Radare. In the next steps we will continue using some tools has been used up to here, maily the "readpe" and "binwalk".

I hope you had fun here!
