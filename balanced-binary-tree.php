<?php

// Assignment research for balanced binary trees that tends to be more difficult
// than just implementing binary search trees. Here’s an example in PHP.
class Node
{
    protected $_parent = null;
    protected $_left = null;
    protected $_right = null;
    protected $_key;
    protected $_data = null;

    /**
     * @param int $key
     * @param mixed $data
     */
    public function __construct($key, $data)
    {
        $this->_key = $key;
        $this->_data = $data;
    }

    /**
     * Empty the node by keeping up the key, but
     * setting up the data to NULL
     */
    public function doEmpty()
    {
        $this->_data = null;
    }

    /**
     * Print the key
     *
     * @return string
     */
    public function __toString()
    {
        return 'First name: ' . $this->_data['f_name']
            . '<br />'
            . 'Last name: ' . $this->_data['l_name']
            . '<br />'
            . 'Birthday: ' . $this->_data['b_day'];
    }

    public function &getParent()
    {
        return $this->_parent;
    }

    public function setParent($parent)
    {
        $this->_parent = $parent;
    }

    public function &getLeft()
    {
        return $this->_left;
    }

    public function setLeft($left)
    {
        $this->_left = $left;
    }

    public function &getRight()
    {
        return $this->_right;
    }

    public function setRight($right)
    {
        $this->_right = $right;
    }

    public function &getKey()
    {
        return $this->_key;
    }

    public function setKey($key)
    {
        $this->_key = $key;
    }

    public function &getData()
    {
        return $this->_data;
    }

    public function setData($data)
    {
        $this->_data = $data;
    }
}

class BalancedBinaryTree
{
    /**
     * Reference to the root tree
     *
     * @var Node
     */
    protected $_root = null;
    /**
     * @var int
     */
    private $iterations = 0;

    /**
     * @param type $new
     * @param type $node
     * @return type
     */
    protected function _insert($new, &$root)
    {
        // in case the tree is empty
        // make the new node the root of
        // the tree
        if ($root == null) {
            $root = $new;
            return;
        }

        if ($new->getKey() <= $root->getKey()) {
            if ($root->getLeft() == null) {
                $root->setLeft($new);
                $new->setParent($root);
            } else {
                $this->_insert($new, $root->getLeft());
            }
        } else {
            if ($root->getRight() == null) {
                $root->setRight($new);
                $new->setParent($root);
            } else {
                $this->_insert($new, $root->getRight());
            }
        }
    }

    /**
     * FALSE on not found
     *
     * @param string $firstName
     * @param BalancedBinaryTree $tree
     * @return boolean
     */
    protected function _search($firstName, &$tree)
    {
        if ($tree == null) {
            return FALSE;
        }

        $data = $tree->getData();

        if ($firstName == $data['f_name']) {
            return $tree;
        }

        // search the left sub-tree
        return $this->_search($firstName, $tree->getLeft())
            . $this->_search($firstName, $tree->getRight());
    }

    /**
     *
     * @param int $key
     * @param Node $tree
     * @return FALSE or Node
     */
    protected function _searchByKey($key, &$tree)
    {
        $this->iterations++;

        if ($tree == null) {
            return FALSE;
        }

        if ($tree->getKey() == $key) {
            return $tree;
        } else if ($tree->getKey() > $key) {
            return $this->_searchByKey($key, $tree->getLeft());
        } else {
            return $this->_searchByKey($key, $tree->getRight());
        }
    }

    /**
     * Returns a list out of the tree by emptying the tree.
     * In other way the tree and the list will allocate memory
     *
     * @param BalancedBinaryTree $tree
     */
    protected function _leftRootRight($tree)
    {
        if ($tree == null) {
            return array();
        }

        return array_merge(
            $this->_leftRootRight($tree->getLeft()),
            array(array('key' => $tree->getKey(), 'data' => $tree->getData())),
            $this->_leftRootRight($tree->getRight()));
    }

    public function _balance($list)
    {
        if (empty($list)) {
            return;
        }

        // split the list
        $chunks = array_chunk($list, ceil(count($list) / 2));
        $mid = array_pop($chunks[0]);

        $node = new Node($mid['key'], $mid['data']);
        $this->insert($node);

        $this->_balance($chunks[0]);
        if (isset($chunks[1]))
            $this->_balance($chunks[1]);
    }

    /**
     * Balance a binary search tree
     */
    public function balance()
    {
        $list = array();
        // make a list out of the tree
        $list = $this->_leftRootRight($this->_root);

        // find the medium! Because the list is ordered
        // we can find the middle element in various ways
        $chunks = array_chunk($list, ceil(count($list) / 2));
        $mid = array_pop($chunks[0]);

        // empty the tree
        $this->_root = null;

        // inser the root
        $node = new Node($mid['key'], $mid['data']);
        $this->insert($node);

        $this->_balance($chunks[0]);
        $this->_balance($chunks[1]);
    }

    /**
     * Insert a new item into the tree
     *
     * @param type $node
     */
    public function insert($newNode)
    {
        $this->_insert($newNode, $this->_root);
    }

    /**
     * Search by item key
     *
     * @param int $key
     * @return Node or FALSE
     */
    public function searchByKey($key)
    {
        $this->iterations = 0;
        return $this->_searchByKey($key, $this->_root);
    }

    /**
     * @param BalancedBinary $tree
     * @return string
     */
    protected function _print($tree)
    {
        if ($tree == null) {
            return '';
        }

        return $this->_print($tree->getLeft()) . ' '
            . $tree->getKey() . ' '
            . $this->_print($tree->getRight());
    }

    /**
     * Print the tree from left through the root and the right
     */
    public function __toString()
    {
        if ($this->_root == null) {
            return 'The tree is empty!';
        }

        return $this->_print($this->_root->getLeft()) . ' '
            . $this->_root->getKey() . ' '
            . $this->_print($this->_root->getRight());
    }

    public function getIterationsCount()
    {
        return $this->iterations;
    }
}


$t = new BalancedBinaryTree();

for ($i = 0; $i < 100; $i++) {
    $t->insert(
        new Node($i, array(
            'f_name' => 'W.A.' . mt_rand(1,1000),
            'l_name' => 'Mozart' . mt_rand(1,1000),
            'b_day' =>  mt_rand(1000,2000) . '-01-27',
        ))
    );
}

echo $t->searchByKey(70) . "\n";
echo $t->getIterationsCount() . "\n";

$t->balance();

echo $t->searchByKey(70) . "\n";
echo $t->getIterationsCount() . "\n";