Overview
========

This Symfony bundle allows you to:

* import translation files content into the database and provide a GUI to edit translations.
* export translations from the database into files.
* have an overview to check translation domains are completely translated.
* add new translations in the database.

[![Build Status](https://travis-ci.com/joakdatradesegur/LexikTranslationBundle.svg?branch=master)](https://travis-ci.com/github/joakdatradesegur/LexikTranslationBundle)
[![Latest Stable Version](https://poser.pugx.org/tradesegur/translation-bundle/v)](//packagist.org/packages/tradesegur/translation-bundle)
[![License](https://poser.pugx.org/tradesegur/translation-bundle/license)](//packagist.org/packages/tradesegur/translation-bundle)

The idea is to:

* write your translations files (xliff, yml or php) as usual for at least one language (the default language of your website for example).
* load translations into the database by using a command line.
* freely edit/add translation through an edition page.

The bundle overrides the translator service and provides a DatabaseLoader.
Database translations content is loaded last so it overrides content from xliff, yml and php translations files.
You can also export translations from the database into files in case you need to get translations files with the same content as the database.

Documentation
=============

For installation and configuration refer to [Resources/doc/index.md](https://github.com/lexik/LexikTranslationBundle/blob/master/Resources/doc/index.md)

___________________

Here is a little screen shot of the edition page :)

![edition page screen](https://github.com/lexik/LexikTranslationBundle/raw/master/Resources/doc/screen/grid.jpg)
