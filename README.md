# earc/tree

Basic tree composite object and interface.

# installation

```bash
$ composer install earc/tree
```

# basic usage

```php
use eArc\Tree\Node;

$root = new Node();

$root->addChild(new Node($root), 'identifier');

$root->getChild('identifier');
```

Please refer to the 
[NodeInterface](https://github.com/Koudela/eArc-tree/blob/master/src/Interfaces/NodeInterface.php) 
for details.
