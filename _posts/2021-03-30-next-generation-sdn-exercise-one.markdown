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
