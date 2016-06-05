<?php

namespace ZendTest\Filter\Address;


use Zend\Filter\Address\Afnor;

class AfnorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Afnor $filter
     */
    protected $filter;

    public function setUp()
    {
        parent::setUp();

        $this->filter = new Afnor('UTF-8');
    }
    
    public function testAddressFilter()
    {
        $filteredValue = $this->filter->filter("11 Rue du ''\"Château d'Eau 75010 Paris Bâtiment 3-A$&~");
        $this->assertEquals('11 RUE DU CHATEAU D EAU 75010 PARIS BATIMENT 3-A', $filteredValue);
    }
}
