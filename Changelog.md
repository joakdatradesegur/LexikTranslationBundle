Changelog
=========

v4.0.22
-------
* Added support for Symfony 5. 
* Fix errors in tests.

v4.0.21
-------
* Include mysql service in travis.yml

v4.0.20
------
* Remove support for Propel ORM and MongoDB.
* Fix an issue with JsonExporter when translations contain accented characters.
* Update libraries to latest version (Support for only Symfony 4 or Symfony 5).
* Update tests.

v4.0.19
------
* Added Use statements to Import and Export Commands.
* Export Command didn't call to parent constructor.

v4.0.18
------
* Fixed an error with function getContainer() on Import and Export Console Commands.

v4.0.17
------
* It removes a deprecation message on ImportTranslationsCommand.php and ExportTranslationsCommand.php replacing ContainerAwareCommand with Command.

v4.0.16
------
* Fixed error getting RootNode on Configuration.php.
* Change root dir from "lexik" to "tradesegur" (caused by the new fork of the repository) in LexikTranslationExtension.php.
* Update .gitignore to ignore PhpStorm ".idea" folder.

v1.1.0
------

* Add support for MongoDB
* Change primany key mapping for the Translation entity, PK is now `id` instead of `(trans_unit_id, locale)`.
* Improve import task.
* Allow to show/hide columns on edition page.
* Use yaml for translation files instead of xliff.

v1.0.0
------

Initial release.