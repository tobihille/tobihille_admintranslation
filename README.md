# Target

* Create an admin-grid to provide posibility to maintain translations for templates in admin
* don't interact with default translation
* only react to prepared strings in templates (.phtml, not XML)
* fallback to default translation if no string is found
* include all features of default translation (e.g. replace %s)

# Use

* replace "\_\_(" with "\_\_\_("
