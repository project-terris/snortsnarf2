# snortsnarf2

By: Ben & Sean

snortsnarf2 is a Java re-implementation of the popular snortsnarf perl script program used for parsing snort alert files
and snort mysql databases. 

The idea of this implementation is to create a more efficient implementation using multi-threading
and numerous tools available in Java that may make live parsing and updating of web content easier

Additionally the hope is to make the source code more easily available, allowing others an opportunity to learn
and understand this popular script

# Setup
_Installation instructions are currently in progress_ 

Below contains only documentation on installation and minimal basic
information on usage. Full documentation on functionality and use of 
various tools and how they are implemented on snortsnarf2 can be found
in the [wiki page on github](https://github.com/project-terris/snortsnarf2/wiki)


## Prerequisites
To use snortsnarf2 you will need the open JDK.

For Windows. TODO pending

For linux:
Fedora >22: sudo dnf install java-1.8.0-openjdk
Fedora <=23: sudo yum install java-1.8.0-openjdk
Ubuntu :sudo apt-get install java-1.8.0-openjdk
For other linux distros just use your package manager

NOTE, you may use other versions of the openjdk or java, 1.8.0 jdk was just what we developed and test it with
TODO maven

## Installation
1. Download the snortsnarf2 release version from the releases page at 
[https://github.com/project-terris/snortsnarf2/releases](https://github.com/project-terris/snortsnarf2/releases)
2. Extract the folder to any desired location
3. TODO running
4. Read the Wiki page for full documentation on the current 
capabilities of snortsnarf2 at [https://github.com/project-terris/snortsnarf2/wiki](https://github.com/project-terris/snortsnarf2/wiki)

## Basic Examples

Simply read in any fast or full formatted snort log file with the following command
```
TODO pending
//php snortsnarf2 -a /path/to/alert/file
```


# Versioning
Currently we are in version 0.0.0 as nothing actually works yet. Version 1.0.0 is defined as the first version where all features from the
previous snortsnarf program have been implemented in snortsnarf2. As features are added, we will be incrementing with the 2nd and 3rd version
numbers depending on the scale of the feature. As bugs are found/fixed and new features are added to snortsnarf2, version numbering will continue
past 1.0.0

# Development Notes
*Feb 22/16*
Currently this re-implementation is under massive research and development and is not usable at this time