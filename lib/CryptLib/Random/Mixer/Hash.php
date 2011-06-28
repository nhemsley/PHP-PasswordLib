<?php
/**
 * The Hash medium strength mixer class
 *
 * This class implements a mixer based upon the recommendations in RFC 4086
 * section 5.2
 *
 * PHP version 5.3
 *
 * @see        http://tools.ietf.org/html/rfc4086#section-5.2
 * @category   PHPCryptLib
 * @package    Random
 * @subpackage Mixer
 * @author     Anthony Ferrara <ircmaxell@ircmaxell.com>
 * @copyright  2011 The Authors
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @license    http://www.gnu.org/licenses/lgpl-2.1.html LGPL v 2.1
 * @version    Build @@version@@
 */

namespace CryptLib\Random\Mixer;

use \CryptLib\Hash\Factory      as HashFactory;
use \CryptLib\Core\Strength\Low as LowStrength;

/**
 * The Hash medium strength mixer class
 *
 * This class implements a mixer based upon the recommendations in RFC 4086
 * section 5.2
 *
 * @see        http://tools.ietf.org/html/rfc4086#section-5.2
 * @category   PHPCryptLib
 * @package    Random
 * @subpackage Mixer
 * @author     Anthony Ferrara <ircmaxell@ircmaxell.com>
 */
class Hash extends \CryptLib\Random\AbstractMixer {

    /**
     * @var Hash The hash instance to use
     */
    protected $hash = null;

    /**
     * Build the hash mixer
     *
     * @param Hash $hash The hash instance to use (defaults to sha512)
     *
     * @return void
     */
    public function __construct(\CryptLib\Hash\Hash $hash = null) {
        if (is_null($hash)) {
            $factory = new HashFactory();
            $hash    = $factory->getHash('sha512');
        }
        $this->hash = $hash;
    }

    /**
     * Return an instance of Strength indicating the strength of the source
     *
     * @return Strength An instance of one of the strength classes
     */
    public static function getStrength() {
        return new LowStrength();
    }

    /**
     * Test to see if the mixer is available
     *
     * @return boolean If the mixer is available on the system
     */
    public static function test() {
        return true;
    }

    /**
     * Get the block size (the size of the individual blocks used for the mixing)
     * 
     * @return int The block size
     */
    protected function getPartSize() {
        return $this->hash->getSize();
    }

    /**
     * Mix 2 parts together using one method
     *
     * @param string $part1 The first part to mix
     * @param string $part2 The second part to mix
     * 
     * @return string The mixed data
     */
    protected function mixParts1($part1, $part2) {
        return $this->hash->hmac($part1, $part2);
    }

    /**
     * Mix 2 parts together using another different method
     *
     * @param string $part1 The first part to mix
     * @param string $part2 The second part to mix
     * 
     * @return string The mixed data
     */
    protected function mixParts2($part1, $part2) {
        return $this->hash->hmac($part2, $part1);
    }

}
