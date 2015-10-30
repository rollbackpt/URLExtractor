# URLExtractor v1.0.0 #

![travis-build](https://api.travis-ci.org/rollbackpt/URLExtractor.svg?branch=master)

PHP Class to extract images and meta data information from URLs

**Usage**

With composer:
```shell
composer require rollbackpt/url-extractor
```

... or manually:
```php
require_once 'src/UrlExtractor/UrlExtractor.php';
$urlExtractor = new \rollbackpt\UrlExtractor\UrlExtractor();
echo $urlExtractor->extractAll("http://some-url.com");
```

**Demo Screenshots**

Test the demo here: http://urlextractor.joaoperibeiro.com/demo/index.html

![urlextractor1](http://s21.postimg.org/63lvd5b3r/Screenshot_from_2015_10_12_22_26_53.png)
![urlextractor2](http://s21.postimg.org/40bg5hbav/Screenshot_from_2015_10_12_22_27_07.png)
![urlextractor3](http://s21.postimg.org/8nhi78ynr/Screenshot_from_2015_10_12_22_27_11.png)

**About the author**
   - Email: joaopedrocr@gmail.com
   - Blog: http://joaoperibeiro.com
   - Personal Page: http://joaopcribeiro.branded.me
