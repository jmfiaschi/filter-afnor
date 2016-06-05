<?php
/**
 * Filter an address as an AFNOR address
 *
 * @author jean-marc.fiaschi
 * @link https://github.com/jmfiaschi/zf-filter-afnor
 * @licence https://github.com/jmfiaschi/zf-filter-afnor/blob/master/LICENSE
 */

namespace Zend\Filter\Address;

use Zend\Filter\AbstractUnicode;

class Afnor extends AbstractUnicode
{
    /**
     * Constructor
     *
     * @param string|array|Traversable $encodingOrOptions OPTIONAL
     */
    public function __construct($encodingOrOptions = null)
    {
        if ($encodingOrOptions !== null) {
            if (!static::isOptions($encodingOrOptions)) {
                $this->setEncoding($encodingOrOptions);
            } else {
                $this->setOptions($encodingOrOptions);
            }
        }
    }

    /**
     * Filter a string ISO AFNOR Address
     * @param string $value
     * @return string
     */
    public function filter($value)
    {
        //converts accented words 
        $value = htmlentities($value, ENT_NOQUOTES, $this->options['encoding']);
        $value = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $value);
        $value = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $value);
        $value = preg_replace('#&[^;]+;#', '', $value);

        if (null !== $this->getEncoding()) {
            $value = mb_strtoupper($value, $this->options['encoding']);
        }

        //delete special word
        if (null !== $this->getEncoding()) {
            $value = mb_ereg_replace('[/"\'\\\@^%;:!§?}{|_-`&~#)(£$¤*°²+]', ' ', $value, 'ix');
        }
        //delete if to much spaces
        $value = preg_replace('#\s+#', ' ', $value);
        $value = trim($value);

        return $value;
    }

}
