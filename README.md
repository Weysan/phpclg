# PHP Changelog Generator (phpclg)

That library will provide a simple tool to generate a changelog file for your projects.

## Installation

Use composer with :
~~~
composer require --dev weysan/phpclg:dev-master
~~~

## Utilisation
The library will generate a file CHANGELOG.md according to merge requests into a specific branch and will group them
by git tags.

if a project has tags :
~~~
git tags
v1
v1.1
v1.2
v1.3
v1.4
v2
v2.1
~~~
To generate a changelog file from tag `v1` to `v2` we will use :
~~~
./vendor/bin/phpclg --dir=/path/to/te/project --from=v1 --to=v2
~~~