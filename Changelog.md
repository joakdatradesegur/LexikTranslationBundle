Changelog
=========

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