### Installation

This demo expects that you have the whole server stack (Linux, Apache, MySQL, PHP) installed on your machine.

##### Requiremenets
- PHP 7.1
- MySQL 5.7
- Apache 2.2
- Linux or any other unix-like system that could handle all things mentioned above

```bash
git clone @todo
composer self-update
composer install
composer dump-autoload --optimize
```

Copy configuration file (`.ENV`) and fill the credentials. First of all the *database*. Other follows the "Convention over configuration" design paradigm.
It's recommend to use *Environment variables* as primary configuration, but fell free to use local configs like *yaml* for development purpose.


 ```bash
 cp .env.dist /.env
 ```

##### Todo
- Pagination of user list
- Improve routing via annotations
- Styles and JavaScript files are loaded from external resources, so it won't work without internet connections, install them localy
- Deserialization of the user entity without unnecessary encoding it
- File structure and namespaces were not chosen thoughtfully, some refactour would be nice
- Use some verified bundle for API ([FOSRestBundle](https://github.com/FriendsOfSymfony/FOSRestBundle)) due `DRTW`
- Create components from GUI parts (navigation, form, ...)
- Create two bundles

---

Fell free to contact me via [email](mailto:MoraviaD1@gmail.com) of [phone](tel:+0420774553322) (`bug`), that we can discuss any questions you may have. 
