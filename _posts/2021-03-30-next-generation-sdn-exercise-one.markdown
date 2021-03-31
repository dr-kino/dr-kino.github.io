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

This post brings more details about the execution of [P4Runtime Basics Tutorial](https://github.com/opennetworkinglab/ngsdn-tutorial/blob/advanced/EXERCISE-1.md) that is part of the Next Generation SDN Tutorial.

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
* Ingress and egress pipeline implementation (incomplete)
* Checksum verification/update

    <div style="text-align:center"><img src="/images/posts/00019-E.png" /></div>
    <div style="text-align:center"><img src="/images/posts/00019-D.png" /></div>

The implementation already provides logic for L2 bridging and ACL behaviors. We suggest you start by taking a quick look at the whole program to understand its structure. When you're done, try answering the following questions, while referring to the P4 program to understand the different parts in more details.

### Parser

* List all the protocol headers that can be extracted from a packet.
    <span style="color:blue">
    ethernet
    ipv4
    ipv6
    srv6h
    srv6_list
    tcp
    udp
    icmp
    icmpv6
    ndp
    </span>

* Which header is expected to be the first one when parsing a new packet
    The first one will be the ethernet header, in the parser implementation it is in the "start" state

### Ingress pipeline

* For the L2 bridging case, which table is used to replicate NDP requests to all host-facing ports? What type of match is used in that table?
    The l2_ternary_table is used to replicate NDP requests to all host-facing ports, to do that the ternary match.

* In the ACL table, what's the difference between send_to_cpu and clone_to_cpu actions?

* In the apply block, what is the first table applied to a packet? Are P4Runtime packet-out treated differently?
    The first table applied is the l2_exact_table. Yes, first it need to validated.
### Egress pipeline

* For multicast packets, can they be replicated to the ingress port?

### Deparser

* What is the first header to be serialized on the wire and in which case?
