# I'd like this

*Add an "I'd like this" button anywhere in a WordPress post and get user feedback on your ideas, proposals and plans.*

## Installation
Clone the plugin repository in a WordPress plugin directory:

```bash
cd /var/www/wordpress/wp-content/plugins
git clone lucautume/idlikethis
```

Cd into the plugin folder and install [Composer](https://getcomposer.org/) dependencies:

```bash
cd idlikethis
composer install
```

## Usage
Activate the plugin in WordPress plugin administration screen.  
The plugin has not options and will add support for the `[idlikethis]` shortcode.  
The shortcode can be used in its short form to generate a button that will register a generic "I'd liket this" comment:

```
How would you like me to undergo the steamy hot bucket challenge? [idlikethis]
```

Or in its long form to specify an idea:

```
Would you like me to undergo the steamy hot bucket challenge? [idlikethis]Steamy hot bucket[/idlikethis]
Or rather the ice bucket challenge? [idlikethis]Ice bucket[/idlikethis]
```

## Tests
The plugin was built to give a concrete example of [dependency injection](https://en.wikipedia.org/wiki/Dependency_injection "Dependency injection - Wikipedia, the free encyclopedia") usage in WordPress with  [DI52](https://github.com/lucatume/DI52) and test-driven development using [Codeception](http://codeception.com/ "Codeception - BDD-style PHP testing.") and [wp-browser](https://github.com/lucatume/wp-browser "lucatume/wp-browser · GitHub")
.  
The test coverage is far from being complete but it contains a lot of hints and practical examples in the `/tests` folder.
