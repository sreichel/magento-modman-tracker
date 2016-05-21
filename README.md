# Magento: modman-Tracker

This extension lists all moduldes inside your `.modman` folder and give you some information, if it's up to date.

* Module name
* Remote URL
* # of commit behind/in front of remote repo

Thanks to [firegento/debug](https://github.com/firegento/firegento-debug) for some lines of code :)

## Known bugs/limitations

* only tested on linux system (don't know if `exec()` works on windows too)
* no support for extensions installed via composer.json so far
* code is ugly as hell ... :P

## Install

`modman clone https://github.com/sreichel/magento-modman-tracker.git`