Important to know
=================
I would not used that right now anywhere except in my own fun projects.
Be warned, this can change quickly resulting in nothing works anymore without major changes.

Unit Tests
==========

Prerequisites
-------------
PhpUnit of course
On debian/ubuntu simply apt-get install phpunit

PHP INI Settings
----------------
Make sure precesion and precision_serialize is set to max 16 in your php.ini. I used to use 14 which seems to handle floats right. 
If wrong, config-tests where the format is converted from anything to serialized can fail because of a floating value in the test.
Your tests will fail with something like "7.1 not equals 7.09999999996"

Data setup for the tests
------------------------
Usually everything is just there, except one file which should be none-readable for the user running the tests. So change into the folder you checked out Spaf and create an empty file under root.

    cd /var/www/Spaf
    sudo touch tests/Data/Directory/ToRead/notReadable
    sudo chmod 0700 tests/Data/Directory/ToRead/notReadable

Run tests
---------
To run the unit tests now simply change into the folder you checked out the codebase and run test.php under the tools directory.
Example shell commands

    cd /var/www/Spaf/tests
    phpunit UnitTests


Documentation
=============

Prerequisites
-------------
- PhpDoc of course - see http://phpdoc.org/
- php5-xsl
- graphviz

Generate docs
---------
To generate the docs simply run phpdoc in the folder you checked out Spaf. The output is generated in ./docs then.
Example shell commands

    cd /var/www/Spaf/tests
    phpdoc



Something
=========

Spaf means Simple Php Application Framework.
As the name says, its supposed to be SIMPLE, thats my most important goal.
Of course i try to reach high code-quality. Therefore ive implemented unit tests with, at least i hope, 
usefull test cases. There is still alot to do and to optimize.
I also try to document EVERYTHING as good as possible. There might be a few documentation bugs already
but i hope i dont did a too bad job until now :-P

The concept is complete different from anything else ive seen yet. Its based on a "DataServiceLayer" Pattern.
Basicly, the idea is: "let the view ask for what it needs from the controller" instead of
"let the controller put some values for the view"


Zend Framework for example is nice, but its concept is to close to HTTP in my opinion.
Webdevelopers are whores of a state-less protocol.
Thatswhy we are thinking a bit different in concept than any developer from a different environment than web.

As soon as we are doing ajax request, we change our mind immeadiatly :-P.

I already did a proof of concept over the last few years. And it turned out very successful for me.
It solves a lot of problems, for example, Controllers are extendible and reusable in any position of your application.
Thats a known problem of the MVC pattern to not have reuasable controllers. HMVC is trying to fix this problem,
and probably it does fix it. In my opinion it just adds tons of complexity.

So, thats what i can tell (show in code) yet. Hope i get a working app together soon, unfortunately, the framework needs alot of work first.
But i keep hacking ;-)

Sincerly, Claudio