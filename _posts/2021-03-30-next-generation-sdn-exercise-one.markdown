---
layout: article
title: Next Generation SDN - P4Runtime Basics {In Progress}
tags:
  - computernetwork
  - security
author:
  name: Rafael Cavalcanti
  url: /profile/rafaelcavalcanti/
licence: cc_attrib
---

This post brings more details about the execution of [P4Runtime Basics Tutorial](https://github.com/opennetworkinglab/ngsdn-tutorial/blob/advanced/EXERCISE-1.md) that is part of the Next Generation SDN Tutorial. This post will cover the following topics:

1. Look at the P4 starter code
2. Compile it for the BMv2 software switch and understand the output (P4Info and BMv2 JSON files)
3. Start Mininet with a 2x2 topology of stratum_bmv2 switches
4. Use the P4Runtime Shell to manually insert table entries in one of the switches to provide connectivity between hosts

## 1. Look at the P4 program
To get started, let's have a look a the P4 program: [p4src/main.p4](https://github.com/dr-kino/ngsdn-tutorial/blob/advanced/p4src/main.p4)

In the rest of the exercises, you will be asked to build a leaf-spine data center fabric based on IPv6. To make things easier, we provide a starter P4 program which contains:

* Header definitions

    <div style="text-align:center"><img src="/images/posts/00019-A.png" /></div>


* Parser implementation

    <div style="text-align:center"><img src="/images/posts/00019-F.png" /></div>
    <div style="text-align:center">There are more states in the parser implementation, see the code.</div>


* Ingress and egress pipeline implementation (incomplete)

    <div style="text-align:center"><img src="/images/posts/00019-G.png" /></div>

    <div style="text-align:center"><img src="/images/posts/00019-H.png" /></div>
    <div style="text-align:center">See the ingress and the egress pipeline implementation for more details.</div>


* Checksum verification/update

    <div style="text-align:center"><img src="/images/posts/00019-E.png" /></div>

    <div style="text-align:center"><img src="/images/posts/00019-D.png" /></div>

The implementation already provides logic for L2 bridging and ACL behaviors. We suggest you start by taking a quick look at the whole program to understand its structure. When you're done, try answering the following questions, while referring to the P4 program to understand the different parts in more details.

### Parser

* List all the protocol headers that can be extracted from a packet.
    * <span style="color:cyan">ethernet</span>
    * <span style="color:cyan">ipv4</span>
    * <span style="color:cyan">ipv6</span>
    * <span style="color:cyan">srv6h</span>
    * <span style="color:cyan">srv6_list</span>
    * <span style="color:cyan">tcp</span>
    * <span style="color:cyan">udp</span>
    * <span style="color:cyan">icmp</span>
    * <span style="color:cyan">icmpv6</span>
    * <span style="color:cyan">ndp</span>
    

* Which header is expected to be the first one when parsing a new packet
    * <span style="color:cyan">The first one will be the ethernet header, in the parser implementation it is in the "start" state.</span>


### Ingress pipeline

* For the L2 bridging case, which table is used to replicate NDP requests to all host-facing ports? What type of match is used in that table?
    * <span style="color:cyan">The l2_ternary_table is used to replicate NDP requests to all host-facing ports, to do that the ternary match is used.</span>

* In the ACL table, what's the difference between send_to_cpu and clone_to_cpu actions?
    * <span style="color:red">TBD</span>

* In the apply block, what is the first table applied to a packet? Are P4Runtime packet-out treated differently?
    * <span style="color:cyan">The first table applied is the l2_exact_table. Yes, first it need to be validated.</span>

### Egress pipeline

* For multicast packets, can they be replicated to the ingress port?
    * <span style="color:cyan">No, it cannot be replicated and if it is a multicast packet then it is droped. See below:</span>
    <div style="text-align:center"><img src="/images/posts/00019-I.png" /></div>

### Deparser

* What is the first header to be serialized on the wire and in which case?
    * <span style="color:cyan">The first header is the cpu_in_header and there is no condition for that, it will happen always.</span>

## 2. Compile P4 program

The next step is to compile the P4 program for the BMv2 `simple_switch` target. For this, we will use the open source P4_16 compiler ([p4c](https://github.com/p4lang/p4c)) which includes a backend for this specific target, named `p4c-bm2-ss`.

To compile the program, open a terminal window in the exercise VM and type the following command:

```c
make p4-build
```

You should see the following output:

```c
*** Building P4 program...
docker run --rm -v /home/sdn/ngsdn-tutorial:/workdir -w /workdir
 opennetworking/p4c:stable \
                p4c-bm2-ss --arch v1model -o p4src/build/bmv2.json \
                --p4runtime-files p4src/build/p4info.txt --Wdisable=unsupported \
                p4src/main.p4
*** P4 program compiled successfully! Output files are in p4src/build
```

<div style="text-align:center"><img src="/images/posts/00019-J.png" /></div>

We have instrumented the [Makefile](https://github.com/dr-kino/ngsdn-tutorial/blob/advanced/Makefile) to use a containerized version of the `p4c-bm2-ss` compiler. If you look at the arguments when calling `p4c-bm2-ss`, you will notice that we are asking the compiler to:

* Compile for the v1model architecture (`--arch` argument);
* Put the main output in `p4src/build/bmv2.json` (`-o`);
* Generate a P4Info file in p4src/build/p4info.txt (`--p4runtime-files`);
* Ignore some warnings about unsupported features (`--Wdisable=unsupported`). It's ok to ignore such warnings here, as they are generated because of a bug in p4c.

### Compiler output

[bmv2.json](https://github.com/dr-kino/ngsdn-tutorial/tree/advanced/solvings/exercise-1/bmv2.json)

This file defines a configuration for the BMv2 `simple_switch` target in JSON format. When `simple_switch` receives a new packet, it uses this configuration to process the packet in a way that is consistent with the P4 program.

This is quite a big file, but don't worry, there's no need to understand its content for the sake of this exercise. If you want to learn more, a specification of the BMv2 JSON format is provided here: https://github.com/p4lang/behavioral-model/blob/master/docs/JSON_format.md

[p4info.txt](https://github.com/dr-kino/ngsdn-tutorial/tree/advanced/solvings/exercise-1/p4info.txt)

This file contains an instance of a P4Info schema for our P4 program, expressed using the Protobuf Text format.

Take a look at this file and try to answer the following questions:

1. What is the fully qualified name of the l2_exact_table? What is its numeric ID?
* <span style="color:cyan">`IngressPipeImpl.l2_exact_table`</span>

2. To which P4 entity does the ID 16812802 belong to? A table, an action, or something else? What is the corresponding fully qualified name?
* <span style="color:cyan">It belongs to the `egress_port` entity and it is associated to an action. Its fully qualified name is `IngressPipeImpl.set_egress_port`.</span>

3. For the IngressPipeImpl.set_egress_port action, how many parameters are defined for this action? What is the bitwidth of the parameter named port_num?
* <span style="color:cyan">Only one parameter is defined for this action and its bitwidth is 9.</span>

<div style="text-align:center"><img src="/images/posts/00019-L.png" /></div>

4. At the end of the file, look for the definition of the controller_packet_metadata message with name packet_out at the end of the file. Now look at the definition of header cpu_out_header_t in the P4 program. Do you see any relationship between the two?
* <span style="color:cyan">Yes, the controller_packet_metadata  has two metadatas as the same way we can see in the definition of the header cpu_out_header_t. See the following images:</span>

<div style="text-align:center"><img src="/images/posts/00019-M.png" /></div>

<div style="text-align:center"><img src="/images/posts/00019-N.png" /></div>

## 3. Start Mininet topology

It's now time to start an emulated network of `stratum_bmv2` switches. We will program one of the switches using the compiler output obtained in the previous step.

To start the topology, use the following command:

```c
make start
```

This command will start two Docker containers, one for mininet and one for ONOS. You can ignore the ONOS one for now, we will use that in exercises 3 and 4.

To make sure the container is started without errors, you can use the make mn-log command to show the Mininet log. Verify that you see the following output (press Ctrl-C to exit):
```c
$ make mn-log
docker-compose logs -f mininet
Attaching to mininet
mininet    | *** Error setting resource limits. Mininet's performance may be affected.
mininet    | *** Creating network
mininet    | *** Adding hosts:
mininet    | h1a h1b h1c h2 h3 h4
mininet    | *** Adding switches:
mininet    | leaf1 leaf2 spine1 spine2
mininet    | *** Adding links:
mininet    | (h1a, leaf1) (h1b, leaf1) (h1c, leaf1) (h2, leaf1) (h3, leaf2) (h4, leaf2) (spine1, leaf1) (spine1, leaf2) (spine2, leaf1) (spine2, leaf2)
mininet    | *** Configuring hosts
mininet    | h1a h1b h1c h2 h3 h4
mininet    | *** Starting controller
mininet    |
mininet    | *** Starting 4 switches
mininet    | leaf1 stratum_bmv2 @ 50001
mininet    | leaf2 stratum_bmv2 @ 50002
mininet    | spine1 stratum_bmv2 @ 50003
mininet    | spine2 stratum_bmv2 @ 50004
mininet    |
mininet    | *** Starting CLI:
```
You can ignore the "*** Error setting resource limits...".

<div style="text-align:center"><img src="/images/posts/gif/00019-A.gif" /></div>

The parameters to start the mininet container are specified in [docker-compose.yml](https://github.com/dr-kino/ngsdn-tutorial/blob/advanced/docker-compose.yml). The container is configured to execute the topology script defined in [mininet/topo-v6.py](https://github.com/dr-kino/ngsdn-tutorial/blob/advanced/mininet/topo-v6.py).

The topology includes 4 switches, arranged in a 2x2 fabric topology, as well as 6 hosts attached to leaf switches. 3 hosts h1a, h1b, and h1c, are configured to be part of the same IPv6 subnet. In the next step you will be asked to use P4Runtime to insert table entries to be able to ping between two hosts of this subnet.

<div style="text-align:center"><img src="/images/posts/00019-O.png" /></div>

stratum_bmv2 temporary files

When starting the Mininet container, a set of files related to the execution of each stratum_bmv2 instance is generated in the tmpdirectory. Examples include:

* [tmp/leaf1/stratum_bmv2.log](https://github.com/dr-kino/ngsdn-tutorial/tree/advanced/solvings/exercise-1/stratum_bmv2.log): contains the stratum_bmv2 log for switch `leaf1`;
* [tmp/leaf1/chassis-config.txt](https://github.com/dr-kino/ngsdn-tutorial/tree/advanced/solvings/exercise-1/tmp/leaf1/chassis-config.txt): the Stratum "chassis config" file used to specify the initial port configuration to use at switch startup; This file is automatically generated by the `StratumBmv2Switch` class invoked by [mininet/topo-v6.py](https://github.com/dr-kino/ngsdn-tutorial/blob/advanced/mininet/topo-v6.py).
* `tmp/leaf1/write-reqs.txt`: a log of all P4Runtime write requests processed by the switch (the file might not exist if the switch has not received any write request).
