---
layout: article
title: KeePass Integration with AutoHotKey
tags:
  - security
  - taskautomation
author:
  name: Rafael Cavalcanti
  url: /profile/rafaelcavalcanti/
licence: cc_attrib
---

If you have to handle several passwords through some pass phrase manager like KeePass, I hope this post can help you to do less efort to get your passwords and bring it in a safe/secure way. To do that I propose a solution using [KeePass](https://keepass.info/) and [AutoHotKey](https://www.autohotkey.com/) tools, that will automate part of this process. Below I list the requirements for this little project:
  * Keep the KeePass database safe;
  * Protect the KeePass master key safe; and
  * Clear any evidence about the extrated keys from the database;

Basically this project will create a hostring (name given by AutoHotKey Tool) to fetch the required password and to do that you will be asked for the master key of your KeePass Database.

Is important to say that any suggestion to make it more robust in terms of security will be welcome, and I would like to encourage you to raise a pull request with your suggestion or, if you prefer, just send me a message pointing the improvements.

Unfortunately I do not have much time to explain about the [Keepass](https://keepass.info/) neither [AutoHotKey](https://www.autohotkey.com/), but information regarding these tools can be easily found on the internet, including how to install it. After the installation of the dependencies (AutoHotKey, KeePass and KPScript), you have to double-click in [HarpocratesAuto.ahk](https://github.com/dr-kino/HarpocratesAuto/blob/main/HarpocratesAuto.ahk) to enable the hotstring.

To use the hotstring is so easy (an example KeePass is provided into this project), just type pswd@haa + <\TAB> key or pswd@hab + <\TAB> to get one of two examples provided into this project. Look:

  <div style="text-align:center"><img src="/images/posts/gif/00020-A.gif" /></div>

In resume, the project is composed by two script types: AutoHotKey and Batch.

One of them is a AutoHotKey script that will call a batch file and later on will check if the batch was successful executed or not, then it will get the password (from a temporary file, created by the second script), override the temporary file and print the password got from the KeePass.

```c
;----------------------------------------------------------------------------------
; Getting Passwords - My Password HarpocratesAuto A
; <pswd@haa+TAB>
;----------------------------------------------------------------------------------
::pswd@haa::
TempVar := "Error"
RunWait Scripts\HarpocratesAuto_GetMyPassword.bat Database\HarpocratesAuto.kdbx Database\HarpocratesAuto.key "Harpocrates Auto A" HarpocratesAuto_A
FileReadLine, ContentsA, tmp.txt, 1
if ErrorLevel {
	MsgBox Keybind Failed: Data base doesn't exist or wrong master key 
	return
}
else
{
	SendRaw %ContentsA%
	file := FileOpen("tmp.txt", "w")
	file.write("!Wrinting some garbage into the file!")
	file.close()
	FileDelete, tmp.txt
}
return
```

The second script is a batch file that will execute the KPScript to get the desired password, this script is responsible to store the password in a temporary file tha will be deleted by AutoHotKey script.

```batch
@echo off
set Database=%1
set CompositeKey=%2
set KeePassDBName=%3
set ReferenceTitle=%4

if exist "%Database%" (
	echo ### Opening Database...
) else (
	echo ### Database does not exist
	pause
	goto :EOF
)

echo ### KeyPass %KeePassDBName% Database ###
set "psCommand=powershell -Command "$pword = read-host '### Enter Password' -AsSecureString ; ^
	$BSTR=[System.Runtime.InteropServices.Marshal]::SecureStringToBSTR($pword); ^
       	[System.Runtime.InteropServices.Marshal]::PtrToStringAuto($BSTR)""
for /f "usebackq delims=" %%p in (`%psCommand%`) do set password=%%p

KPScript -c:GetEntryString "%Database%" -pw:%password% -keyfile:"%CompositeKey%" -Field:Password -ref-Title:"%ReferenceTitle%" > tmp.txt

KeePass.exe --exit-all

set/pz=<tmp.txt
echo %z%

if "%z%" == "The composite key is invalid!" (
	del tmp.txt
	pause
	goto :EOF
)
```

So, feel free to use and adapt it to your purpose.

Repository: [https://github.com/dr-kino/HarpocratesAuto](https://github.com/dr-kino/HarpocratesAuto)
