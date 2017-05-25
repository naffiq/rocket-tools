# RocketTools

This little php script helps you generate and manage nginx configuration for your project.

## Installation

### Via composer
Install this project globally by running
```bash
$ composer global require naffiq/rocket-tools
```
Make sure, that you have your composer's `bin` directory linked to your `PATH` environment
variable.

### Download PHAR executable
You can get the latest version this utility on [releases page](https://github.com/naffiq/rocket-tools/releases/latest). 
Just grab `rocket-tools.phar` and put it to your `/usr/local/bin` directory (if you're on macOS/Linux) or just any 
folder listed in your `PATH` on Windows.

## Usage

Check the version by running
```bash
$ rocket-tools --version
```

### Generate nginx configurations

You can create nginx config in sites-available for your Yii2 project (basic for now) by running
```bash
$ rocket-tools nginx:generate <server-name> [<document-root>] [<sites-available>] [<config-name>] [<port>] [<fast-cgi-pass>]
```

This command takes following arguments:
-  `server-name`           Domain (server_name) for newly created app
-  `document-root`         Document root for your project. If not set, taken from run directory. **default: "CURRENT/RUNNING/DIRECTORY"**
-  `sites-available`       Path of sites-available folder **default: "/etc/nginx/sites-available"**
-  `config-name`           File name for your config file. If not set first `server-name` is used
-  `port`                  Listen port. **default: 80**
-  `fast-cgi-pass`         Fast CGI pass. **default: "unix:/var/run/php7.1-fpm.sock"**

You can override defaults by configuring `rocket-tools` with [config:update](#Configuring RocketTools) command. 

### Link/unlink nginx sites available

Run this command to link config from `sites-available` to `sites-enabled` folder:
```bash
$ rocket-tools nginx:link <site-name> [<sites-available>] [<sites-enabled>] 
```

Arguments:
-  `site-name`             Configuration file name
-  `sites-available`       Sites available directory (without .conf) **default: "/etc/nginx/sites-available"**
-  `sites-enabled`         Sites enabled directory **default: "/etc/nginx/sites-enabled"**

To unlink config run:
```bash
$ rocket-tools nginx:unlink <site-name> [<sites-enabled>]
```

Arguments:
-  `site-name`             Configuration file name
-  `sites-enabled`         Sites enabled directory **default: "/etc/nginx/sites-enabled"**

You can override defaults by configuring `rocket-tools` with [config:update](#Configuring RocketTools) command. 

### Configuring RocketTools

To override default configurations run:
```
$ config:update <config-name> <config-value>
$ config:set <config-name> <config-value>
```

Arguments:
-  `config-name`           Configuration key
-  `config-value`          Configuration value

So in order to override `nginx:generate` configurations simply take it's argument 
(for example `sites-available`), add `nginx-` prefix to it and use it as configuration key.
The only exception is `fast-cgi-pass`, which is related to `php-fpm` and hand

**Example:**
```bash
$ config:update nginx-sites-available /usr/local/etc/nginx/sites-available
```

There is also a command for viewing your current configuration:
```bash
$ config:get [<config-name>]
```

Arguments:
-  `config-name`           Configuration key. If not set, displays all config values.

#### Configuration files
All of the configuration files are stored in `$HOME/.rocket-tools/` directory. 
If you want to change it, set `ROCKET_TOOLS_HOME` environment variable to desired path.

### Updating RocketTools
If you are using `composer` run:
```bash
$ composer global update naffiq/rocket-tools
```

Just like `composer.phar`, `rocket-tools.phar` file contains `self-update` command, if
you manually downloaded it from releases page.

#### Under the hood:

- [Symfony Console](https://github.com/symfony/console)
- [box-project/box2](https://github.com/box-project/box2/)
- [humbug/phar-updater](https://github.com/humbug/phar-updater)

#### TODO:
- [ ] Add default templates for nginx configs (Yii2 advanced, Laravel, Symfony)
- [ ] Custom templates for nginx config
- [ ] Apache2 config generator
- [ ] Automated MySQL DB/User creation
- [ ] Automated `.env` file generator
- [ ] hosts file editor
- [ ] All of the steps in one command master

### License: MIT

> Crafted with ♥