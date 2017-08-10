Gloo FacebookSSO Extension
=====================
An SSO provider that depends on the Base Magento SSO extension
Facts
-----
- version: 1.0.0
- extension key: Gloo_FacebookSSO
- [extension on GitHub](https://github.com/gloong/Facebook-SSO)


Description
-----------
It allows single sign on using facebook

Requirements
------------
- PHP >= 5.6.0
- Mage_Core
- ...

Compatibility
-------------
- Magento >= 2.0

Installation Instructions
-------------------------
1. Add the repository key to your composer.json:
```
"reositories": {
        "gloo-facebook-sso": {
            "type": "vcs",
            "url": "https://github.com/gloong/Facebook-SSO.git"
        }
 }
```
2. Run `composer require gloo/module-facebook-sso
Uninstallation
--------------
1. Remove all extension files from your Magento installation


Support
-------
If you have any issues with this extension, open an issue on [GitHub](https://github.com/gloong/Facebook-SSO/issues).

Contribution
------------
Any contribution is highly appreciated. The best way to contribute code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Developer
---------
David Umoh
[http://www.davidumoh.com](http://www.davidumoh.com)
[@umohdave](https://twitter.com/@umohdave)

Licence
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)

Copyright
---------
(c) 2017 Gloo
