# Gitium

Automatic git version control and deployment for your plugins and themes integrated into wp-admin.

This is a [fork](https://github.com/presslabs/gitium) of the original Presslabs plugin

## Description

Gitium enables continuous deployment for WordPress, integrating with tools such as Github, Bitbucket or Travis-CI. Theme or plugin updates, installs and removals are all automatically versioned. Ninja code edits from the WordPress editor are also tracked by the version control system.

Gitium is designed with sane development environments in mind, allowing staging and production to follow different branches of the same repository. You can also deploy code by simply using `git push`.

Gitium requires `git` command line tool with a minimum version of 1.7 installed on the server and the `proc_open` PHP function enabled.

## Installation

### Manual Installation
1. Upload `gitium.zip` to the `/wp-content/plugins/` directory;
2. Extract the `gitium.zip` archive into the `/wp-content/plugins/` directory;
3. Activate the plugin through the 'Plugins' menu in WordPress.

### Usage

Activate the plugin, configure your repository directly on the server and get the Webhook route in the settings.

## Frequently Asked Questions ==

### Could not connect to remote repository?

If you encounter this kind of error you can try to fix it by setting the proper username of the .git directory.

Example: chown -R www-data:www-data .git

### Is this plugin considered stable?

Yes, we consider the plugin stable after extensive usage in production environments at Presslabs, with hundreds of users and powering sites with hundreds of millions of pageviews per month.

### What will happen in case of conflicts?

The behavior in case of conflicts is to overwrite the changes on the `origin` repository with the local changes (ie. local modifications take precedence over remote ones).

### How to deploy automatically after a push?

You can ping the webhook url after a push to automatically deploy the new code. The webhook url can be found under `Gitium` menu, `Settings` section. This url also plays well with Github or Bitbucket webhooks.

### Does it works on multi site setups?

Gitium does not support multisite setups at the moment.

### How does gitium handle submodules?

Submodules are currently not supported.

### Upgrade Notice
#### 1.0.4
- PHP8 support
- Git key settings must be done server side, all screens and logs in plugin have been removed
- Added Portuguese-Brazil translation.