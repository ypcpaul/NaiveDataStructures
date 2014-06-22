<?php
namespace tunalaruan\NaiveDataStructures;

use tunalaruan\NaiveDataStructures\Set as Set;

/**
 * Naive implementation of a set.
 * Here's the criteria I used to define what is a "set"
 * 1) Unordered (meaning {1,2,3}==={3,2,1}
 * 2) Unique elements
 * 3) Must be of the same type (integer, string, bool, object, etc)
 * @TODO: better handling of objects as elements
 */
class Set implements \Countable, \IteratorAggregate
{
    //collection of elements
    private $content = [];
    //type of elements required in this set
    private $type = "";
    const TYPE_ERROR = "Elements do not match type";

    /**
     * Create a new set.
     *
     * Accept variable number of parameters that would serve as the initial 
     * set contents; or pass a single array of elements.  Data type of the
     * first element would be used as the set's allowed type.
     */
    public function __construct() {
        $args = func_get_args();
        if(is_array($args[0]) && func_num_args() === 1)
            $this->content = $args[0];
        else
            $this->content = $args;
        //get first element's type.  this would serve as the only type that
        //this set would accept
        $this->type = gettype(array_values($this->content)[0]);
        foreach($this->content as $elem) {
            if(!$this->checkType($elem)) 
                throw new \InvalidArgumentException(self::TYPE_ERROR);
        }
    }

    /**
     * Check an element's type if it is equal to the set's accepted type.
     */
    private function checkType($elem) {
        if(gettype($elem) !== $this->type)
            return false;
        return true;
    }

    /**
     * Returns the type of elements this set accepts.
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Count the number of elements of this set.
     * @return integer
     */
    public function count() {
        return count($this->content);
    }

    /**
     * Get iterator for this set.  This would allow us to loop through the set
     * @return \ArrayIterator
     */
    public function getIterator() {
        return new \ArrayIterator($this->content);
    }

    /**
     * Get contents of this set in array form
     * @return array
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Gets the union of this set and another set
     * @param Set $set
     * @return Set
     */
    public function union(Set $set) {
        return new Set(array_unique(
            array_merge($this->content, $set->getContent()))); 
    }

    /**
     * Get the intersection of this set and another set
     * @param Set $set
     * @return Set
     */
    public function intersection(Set $set) {
        return new Set(array_intersect($this->content, $set->getContent()));
    }

    /**
     * Get the difference of this set to another set
     * @param Set $set
     * @return Set
     */
    public function difference(Set $set) {
        return new Set(array_diff($this->content, $set->getContent()));
    }

    /**
     * Check if this set is a subset of another set
     * @param Set $set
     * @return boolean
     */
    public function isSubsetOf(Set $set) {
        if(count(array_diff($this->content, $set->getContent())) === 0)
            return true;
        return false;
    }

    /**
     * Add an element to this set
     *
     * Would not add duplicate elements.
     * @return Set
     */
    public function add($element) {
        if(!$this->checkType($element)) {
            throw new \InvalidArgumentException(self::TYPE_ERROR);
        }
        if(!is_int(array_search($element, $this->content)))
            $this->content[] = $element;
        return $this;
    }

    /**
     * Remove an element from this set
     * @return Set
     */ 
    public function remove($element) {
        $index = array_search($element, $this->content);
        if(is_int($index))
            array_splice($this->content, $index, 1);
        return $this;
    }
    
    /**
     * Checks if $element is member of this set.
     * @return boolean
     */
    public function isMemberOf($element) {
        $index = array_search($element, $this->content);
        if(is_int($index))
            return true;
        return false;
    }
}
