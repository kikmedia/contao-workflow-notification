Notification Center Integration for Contao 
==========================================

[![Build Status](http://img.shields.io/travis/netzmacht/contao-workflow-notification/master.svg?style=flat-square)](https://travis-ci.org/netzmacht/contao-workflow-notification)
[![Version](http://img.shields.io/packagist/v/netzmacht/contao-workflow-notification.svg?style=flat-square)](http://packagist.com/packages/netzmacht/contao-workflow-notification)
[![License](http://img.shields.io/packagist/l/netzmacht/contao-workflow-notification.svg?style=flat-square)](http://packagist.com/packages/netzmacht/contao-workflow-notification)
[![Downloads](http://img.shields.io/packagist/dt/netzmacht/contao-workflow-notification.svg?style=flat-square)](http://packagist.com/packages/netzmacht/contao-workflow-notification)
[![Contao Community Alliance coding standard](http://img.shields.io/badge/cca-coding_standard-red.svg?style=flat-square)](https://github.com/contao-community-alliance/coding-standard)

This extension provides the [notification center](https://github.com/terminal42/contao-notification_center) integration 
for the Contao [workflow extension](https://github.com/netzmacht/contao-workflow). It ships with a predefined 
`workflow_notification` workflow type and a notification workflow action.

Install
-------

You can install this extension via Composer:

```
$ php composer.phar require netzmacht/contao-workflow-notification:~1.0
```

Usage
-----

 1. Create and configure a notification of the type `workflow_notification`. See the documentation of the notification
    center for more details.
 2. Create a `Notification action` for your workflow transition and select the created notification.
 3. Enjoy it.

Customization
-------------

The notification action supports all notification types which begins with `workflow_`. So you are free to create your
custom notifications with custom tokens.

Have a look for the `workflow.notification.prepare-tokens` event to adjust the generated tokens.
