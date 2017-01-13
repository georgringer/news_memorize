TYPO3 Extension `news_memorize`
===============================

This extensions makes it possible for **logged in** users to collect news records to a kind of cart.

Requirements
------------

- TYPO3 7.6 LTS
- EXT:news 3.2.0+
- jQuery

Usage
-----

Installation
^^^^^^^^^^^^

The recommended way to install the extension is by using *Composer*.
In your Composer based TYPO3 project root, just do `composer require georgringer/news-memorize`.

Otherwise you can install the extension from TYPO3 Extension Repository (TER) by downloading and installing the extension with the extension manager module.


Include JavaScript
^^^^^^^^^^^^^^^^^^

You need to include an additional JavaScript file. You can either use the one shipped by this extension or take it as inspiration.

```
page.includeJS.99 = typo3conf/ext/news_memorize/Resources/Public/JavaScript/memorize.js
```

Adopt templates
^^^^^^^^^^^^^^^

Additionally, the templates need to be adopted.

The `Partials/List/Item.html` needs to be changed and the following part needs to be added:

```
<button class="btn btn-secondary news-memorize" data-newsid="{newsItem.uid}" data-hash="{memorize:hash(id:newsItem.uid)}">
    <span class="add">Auf die Merkliste</span>
    <span class="remove" style="display: none;">Von Merkliste entfernen</span>
</button>
```

As a new action has been added, you can copy `Templates/News/List.html` to `Templates/News/MemorizeList.html` which is used as cart.

Create new plugin
^^^^^^^^^^^^^^^^^

The cart is being rendered by a new action of the news plugin. Create a new page and add a plugin of type *News system* and choose Memorize List` as action.



