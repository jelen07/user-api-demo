# Installation

You have several options:
1. [![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy) **[Recommended]** - the easiest way, just 3 clicks if you have an account
1. :wrench: Install manually
1. :whale: ~~Install via Docker~~ *@todo*

## Install manually

This demo expects that you have the whole server stack (Linux, Apache, MySQL, PHP) installed on your machine.

### Requirements
- PHP 7.1
- MySQL 5.7
- Apache 2.2
- Linux or any other unix-like system that could handle all things mentioned above
- Composer
- See [composer.json](/composer.json) for any further informations (about php extensions etc.)

```bash
git clone https://github.com/jelen07/user-api-demo.git
cd user-api-demo
```

Copy configuration file (`.env`) and fill the credentials. First of all the *database*. Other follows the "Convention over configuration" design paradigm.
It's recommend to use *Environment variables* as primary configuration, but fell free to use local configs like *yaml* for development purpose.

```bash
cp .env.dist .env
```

Install all dependencies

```bash
composer self-update
composer install
```

And finaly start the built-in PHP server in the root directory of your project.

```bash
php -S localhost:8000 -t public
```

Then visit [http://localhost:8000](http://localhost:8000) in your browser to see running application.

> For full functionality it's **recommended** to set up an Apache *virtualhost* heading to `/public` directory.

# User API
For further information see [:blue_book: Documentation](docs/index.md).

# Todo
- Pagination of user list on frontend
- Simplify routing via annotations
- Styles and JavaScript files are loaded from external resources, so it won't work without internet connections, install them localy
- Deserialization of the user entity without unnecessary encoding it
- File structure and namespaces were not chosen thoughtfully, some refactor would be nice later
- Use some verified bundle for API ([FOSRestBundle](https://github.com/FriendsOfSymfony/FOSRestBundle)) due `DRTW`
- Better API documentation, maybe Apiary?
- Refactor the processing of exceptions
- Create components from GUI parts (navigation, form, ...)
- Separate app into the two bundles
- Write some tests
- ~~Add user fixtures~~

Note that the demo application is running in `dev` mode as well as that the database restarts after each installation. This is done for test / revision purposes only and must not be used in production. 

# Contributing :busts_in_silhouette:
You can take a part. Before committing any changes, don't forget to run
```
vendor/bin/php-cs-fixer fix --config=.php_cs.dist -v --dry-run
```

---

:email: Fell free to contact me via [email](mailto:MoraviaD1@gmail.com) of [phone](tel:+0420774553322) (`bug`, see raw file), that we can discuss any questions you may have. 
