---
layout: article
title: Control Systems - The Step Response
tags:
  - control
author:
  name: Rafael Cavalcanti
  url: /profile/rafaelcavalcanti/
licence: cc_attrib
---

In this post I want to cover some interesting things about step response and I hope to clarify via examples what the step response is and how it can be used to specify the design for closed-loop control systems, to do that I will use program laguage for [Octave](https://www.gnu.org/software/octave/). So, to answer the question "What is the step response?" we can simply say that it is how a system responds to a step input, it means that we can input a unit step function into a system and we can measure how the systems responds to that.

But I know, maybe you are asking yourself "And what about the step function?", it is simple also, the step function is a transition from one state to another in a very very small time, instantly.

```c
clear all                   # clear all variable
clc                         # clear screen

t=-10:0.001:10;             # time declaration
y=heaviside(t);             # step function

plot(t,y, "linewidth",5);   # plot
axis([-5 5 -1 2]);          # axis delimitation

###############################################
# Plot Configs                                #
###############################################
title("Step Function","fontsize", 20);
xlabel("time","fontsize", 16);
ylabel("amplitude","fontsize", 16);
set(gca,"linewidth", 4,"fontsize", 18);
```

<div style="text-align:center"><img src="/images/posts/00015-A.png" width="600" height="400" /></div>


### The Step Response