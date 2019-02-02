# earc/tree

Basic tree composite blueprint.

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

If you want to add the tree composite functionality to a existing class use the
`eArc\Tree\Node\NodeTrait`.