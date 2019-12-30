---
layout: article
title: Setting up uncrustify tool for git automation (C/C++ Languages)
tags:
  - softwaredevelopment
author:
  name: Rafael Cavalcanti
  url: /profile/rafaelcavalcanti/
licence: cc_attrib
---

[Uncrustify](https://github.com/uncrustify/uncrustify) is a tool used to fit a standard for a program language aplying style according to the configuration file, it turns the code as a standardized code. This tool is very used in cases of large projects that is difficult to disseminate a coding conventions or in cases of each team member used to use different IDE to program. In this post I will describe two ways for use uncrustify integrated with version control tool - [Git](https://git-scm.com/), the first one example should be executed via script and the second one should be integrated to [Git Hook](https://git-scm.com/book/en/v2/Customizing-Git-Git-Hooks) mechanism.

Note that I am providing a gneric configuration file style.cfg, but you can adapt it for your own necessity changing number of spaces, newlines, blanklines and identation, for instance. I am using Vim to devolop my software projects and I used to use it to edit that configuration file as a text editor, Visual Code has an interface to make the configuration job easier and to use that you need to install the appropriate plugin called Uncrutify, developed by Laurent Tréguier.

#### Shell Script Using Git

The script below uses the command git status as the main step in the execution, after executed it will list all modified files. Then the command sed wil separete all lines, outputed from the git status, that contains the "modified" tag, after this step the command grep will search for all outputs that contains the folowing extensions: *.h, *.c, *.hpp and *.cpp. Finally this output will be passed for the uncrustify as one of inputs. This script should be applied/used in case that you want to see the formated code before you add it for the commit process.
```shell
git status | sed -n '/modified:/{s/^.*://;p}' | grep "\.h$\|\.c$\|\.cpp$\|\.hpp$" | \
		xargs -Inome uncrustify -c style.cfg --replace nome
```

#### Git Hook on Pre-Commit
Now I will present for you the second way prepared to use the uncrustify, in this case you will used it embedded in hook mechanism provided by git. The hook mechanism is a serie of script that is called automatically during some git operations, in this study case I used "pre-commit", ie it will be called always during the "git commit" command.

The code below is part of "pre-commit" file, the entire code could be seen in the [repository](https://github.com/dr-kino/UncrustifyShip) that contains this project. First of all, the scrip stores the configuration file path (style.cfg) and stores all files, with required extensions, included in current commit via "git add". Then it there some file to be checked, the tool uncrustify will apply the standard in all files listed.
```shell
UNCRUST_CONFIG="scripts/style.cfg"
# get list of staged files
staged_files=$(git diff --name-only --staged | grep -i -E -- 'src' | grep -E '\.(c|h|cpp|hpp)$')
if [ -n "$staged_files" ]; then
    echo "## Executing uncrustify"
    uncrustify -c $UNCRUST_CONFIG $staged_files --replace --no-backup
    if [ $? -ne 0 ]; then
        exit 1
    fi
    git add $staged_files
    echo "## Style checked and changes commited"
fi
```
The full project could be verified in my github, it is named as [UncrustifyShip](https://github.com/dr-kino/UncrustifyShip). The next video shows how to use both mechanism decribed before, first I made some changes in the code changing its formatation then I called the git status to know if the file was staged, after that I ran the script sh_uncrustify to apply the standard in the code. The execution of the second script was automatically done through the git commit command, I mean it was executed via pre-commit script.

<center><iframe width="560" height="315" src="https://www.youtube.com/embed/DBQ7n28d7SM" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></center>

I hope this post is useful for anyone who wants to start a project using coding standards in terms of style.