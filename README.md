# Dr-Kino
[Dr-Kino](https://dr-kino.github.io) is a blog devoted to articles about Embedded Systems, RF, Control, Digital Processing, Analog Electronic, Security and Reverse Engineering. It's main author is [Rafael Cavalcanti](https://dr-kino.github.io/profile/rafaelcavalcanti).

Dr-Kino uses [jekyll](http://jekyllrb.com/) to create a statically generated site and the source for the site is hosted on [GitHub](https://github.com/dr-kino/dr-kino.github.io).

# Contributions
If you would like to write an article for the site or make a correction, please send a pull request. I would love to hear from you.

# Licence
I need to clarify the licence situation for the code and images.  However, the situation for the posts is a little clearer, to find out the licence for each post look at the article on-line and at the bottom you will see what licence it is under.  The YAML header also gives a clue to this.

# Build
To build this projct, enter the commands bellow in the root folder:
```console
	$ jekyll build
	$ jekyll server
```
Then access the page via the following address: http://127.0.0.1:4000

Then copy the content from gh-pages, generated in the same level of the root folder, to directorie dr-kino.github.io. The most important folder to link the references are generated in tag folder. IMPORTANT: Before enter the command ```console $ jekyll build ``` is important to exclude the content of tag folder.
