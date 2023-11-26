# Changelog

All notable changes to `tjvb/gitlab-webhooks-receiver-for-laravel` will be documented in this file.

## Unreleased

### Added
- Add PHP 8.3 support.


## 2.1.0 - 2023-02-14

### Added
- Add Laravel 10 support.

## 2.0.0 - 2023-01-03

### Added
- Add PHP 8.2 support
- Add infection to level up the test quality
- Add [Safe php](https://packagist.org/packages/thecodingmachine/safe) as requirement.
- Breaking: Add the getBody, getEventType, getEventName, getObjectKind, getCreatedAt, store and remove functions to the GitLabHookModel interface.
- Add ext-json as required php extension, this was already needed but now explicit required in composer.json.

### Removed
- Remove Laravel 8 support.
- Remove PHP 7.4 support.
- Remove PHP 8.0 support.

## 1.2.0 - 2022-02-08
### Added
- Add support for Laravel 9

## 1.1.0 - 2021-12-02
### Added
- Add PHP 8.1 support

## 1.0.1 - 2021-11-17
- Fixed migration, use boolean false and not the string false. Thanks to @outofcontrol

## 1.0.0 - 2021-07-04
- Initial release