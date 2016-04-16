# snortsnarf2

By: Ben & Sean

snortsnarf2 is a php re-implementation of the popular snortsnarf perl script program used for parcing snort alert files
and snort mysql databases. 

The idea of this implementation is to create a more efficient implementation using multi-threading
and numerous tools available tools in php that may make live parcing and updating of web content easier

Additionally the hope is to make the source code more easily available, allowing others an opportunity to learn
and understand this popular script

# Setup
_Installation instructions are currently in progress_ 

Below contains only documentation on installation and minimal basic
information on usage. Full documentation on functionality and use of 
various tools and how they are implemented on snortsnarf2 can be found
in the [wiki page on github](https://github.com/project-terris/snortsnarf2/wiki)

## Prerequisites
To use snortsnarf2 you will need a threadsafe version of PHP 5.6.20. If you are in windows this is fairly easy. Linux, not so much.

For Windows. Simply install Thread Safe PHP 5.6.20 from [windows.php.net/download](http://windows.php.net/download/). Select the
version that is compatable with either your x86 or x64 system.


For Linux, you will have to build PHP 5.6.20 from source. An excellent 
script that builds and compiles this for you on Ubuntu Linux is available 
at [https://gist.github.com/Divi/9696838](https://gist.github.com/Divi/9696838)
. Tweaking of this script or stepping through it for Fedora 22 has also 
been tested to work. 

NOTE, the above script has a BUG in it. When building the pthread 
extension (starting at line 37), you will need to `git checkout PHP5 ` 
after cloning (cloning command on line 39) as the current implimentation 
on the master branch is for PHP7. More details of this is available in 
the README of the pthreads repo at [https://github.com/krakjoe/pthreads/tree/master](https://github.com/krakjoe/pthreads/tree/master)

A full tutorial on how to install and compile a thread safe version 
of PHP 5.6.20 will be coming soon

## Installation
1. Download the snortsnarf2 release version from the releases page at 
[https://github.com/project-terris/snortsnarf2/releases](https://github.com/project-terris/snortsnarf2/releases)
2. Extract the folder to any desired location
3. At the root of the project will be the file `snortsnarf2.php`. This 
is the main file to execute all snortsnarf2 commands. Start with 
`snortsnarf2.php --HELP`
4. Read the Wiki page for full documentation on the current 
capabilities of snortsnarf2 at [https://github.com/project-terris/snortsnarf2/wiki](https://github.com/project-terris/snortsnarf2/wiki)

## Basic Examples

Simply read in any fast or full formatted snort log file with the following command
```
php snortsnarf2 -a /path/to/alert/file
```


# Versioning
Currently we are in version 0.0.0 as nothing actualy works yet. Version 1.0.0 is defined as the first version where all features from the
previous snortsnarf program have been implemented in snortsnarf2. As features are added, we will be incrementing with the 2nd and 3rd version
numbers depending on the scale of the feature. As bugs are found/fixed and new features are added to snortsnarf2, version numbering will continue
past 1.0.0

# Development Notes
*Feb 22/16*
Currently this re-implementation is under massive research and development and is not usable at this time