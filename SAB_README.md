Simple Address Book = "SAB"
========================
Welcome to the Simple Address Book and we called it **SAB**.

For details on how to download and get started with SAB, see the
**Installation** chapter of the SAB Documentation.

What's inside?
--------------
SAB uses *symfony* framework. You can find a database file for importing in the root directory.
Database connection properties can be setted when *symfony* framework installed.

***Installation***
========================
```yaml
git clone https://github.com/nrlozdemir/sab.git
cd sab
composer install
composer update
```
```sql
# Create a database as named "sab";
# Check properties /app/config/parameters.yml
mysql -h hostname -u username -p sab < sab.sql
```

***Run your browser with "hostname/web/app_dev.php"***

**Requirements**
========================
* A person has a first name and a last name.
* A person may have one or more street addresses.
* A person may have one or more email addresses.
* A person may have one or more phone numbers.
* A person can be a member of one or more groups.
* An address book is a collection of persons and groups.
* Add a person to the address book.
* Add a group to the address book.
* Given a group we want to easily find its members.
* Given a person we want to easily find the groups the person belongs to.
* Find person by name (can supply either first name, last name, or both).
* Find person by email address (can supply either the exact string or a prefix
  string, ie. both "alexander@company.com" and "alex" should work).
 
**Design-only questions**:
* Find person by email address (can supply any substring, ie. "comp" should
  work assuming "alexander@company.com" is an email address in the address
  book) - discuss how you would implement this without coding the solution.

Answer
--------------
```php
/**
 * Find src/AddressBookBundle/Entity/Persons.php 
 * function getListFindByEmail(.... 
 * and add/write the below code.
 * So, you can search a person with given sting.
 * eg: alexander@company.com, alex, xander, der@comp, any.com, .com etc.
 * That's mean the magic is %search%
 */
 
->where('em.emailAddress LIKE :searchTag1')
->setParameter('searchTag1', "%$email%")
```

***Truncating SQL Tables***
========================
```sql
SET foreign_key_checks = 0;
TRUNCATE `email_addresses`;
TRUNCATE `groups`;
TRUNCATE `group_relationships`;
TRUNCATE `persons`;
TRUNCATE `phone_numbers`;
TRUNCATE `streets`;
SET foreign_key_checks = 1;
```