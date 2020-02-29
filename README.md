# Compliance Tools

## Introduction

The Compliance Tools module provides Drush commands to help with government
compliance. Currently, the module will list privileged users based either on
roles or permissions and will return the settings for failed logins.

## Requirements

This module is designed to work with Drupal 8.4 or greater and Drush 9 or
greater.

## Installation

* Install as you would normally install a contributed Drupal module.
  Visit [Installing Drupal 8 Modules](https://www.drupal.org/node/1897420]) for further information.

## Usage

### List Privileged Users

To list all users with the _Administrator_ role run:
`drush ct:privilege-users --role=Administrator`

You can list multiple roles using a comma separated list, for example:
`drush ct:privilege-users --role=Administrator, Manager`

You can also use the _drush_ alias, for example:
`drush ct-lpu --perms="Administer users, Change own username"`
to list all users with the _Administer users_ and _Change own users_
permissions.

### Get Failed Login attempt settings

To get the settings for failed logins and lockout window run:
`drush ct:failed-logins`

This commands validates NIST 800-53 control AC-7 (a) and AC-7 (b) and SC-5.

### Validate email verification required

Get the setting for require email verification when a visitor creates an
account: `drush ct:email-verification`

This commands validates NIST 800-53 control IA-4 (b).

## Maintainers

Current maintainers:

* [Tom Camp (Tom.Camp)](https://www.drupal.org/u/tomcamp)

This project has been sponsored by:

* [CivicActions, Inc.](https://www.drupal.org/civicactions)
  CivicActions empowers U.S. government agencies to deliver delightful digital
  experiences that are as innovative and rewarding as popular online and mobile
  consumer services.
