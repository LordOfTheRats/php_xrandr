<?php

/*
 * The MIT License
 *
 * Copyright 2015 - 2016 René Vögeli <rvoegeli@vhtec.de>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
require_once dirname(__FILE__) . '/../../../src/Xrandr/Xrandr.php';

use \Xrandr\Xrandr;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-11-21 at 02:02:22.
 */
class XrandrTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var Xrandr
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {
		$raw[] = "Screen 0: minimum 8 x 8, current 1360 x 768, maximum 32767 x 32767";
		$raw[] = "eDP1 connected primary 1360x768+0+0 (normal left inverted right x axis y axis) 344mm x 193mm";
		$raw[] = "   1366x768       60.0 +";
		$raw[] = "   1360x768       59.8*    60.0  ";
		$raw[] = "   1024x768       60.0  ";
		$raw[] = "   800x600        60.3     56.2  ";
		$raw[] = "   640x480        59.9  ";
		$raw[] = "DP1 disconnected (normal left inverted right x axis y axis)";
		$raw[] = "HDMI1 disconnected (normal left inverted right x axis y axis)";
		$raw[] = "VIRTUAL1 disconnected (normal left inverted right x axis y axis)";
		$raw[] = "  800x600_60.00 (0x1db)   38.2MHz";
		$raw[] = "        h: width   800 start  832 end  912 total 1024 skew    0 clock   37.4KHz";
		$raw[] = "        v: height  600 start  603 end  607 total  624           clock   59.9Hz";

		$this->object = new Xrandr($raw);
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown() {

	}

	/**
	 * @covers \Xrandr\Xrandr::getPrimaryOutput
	 */
	public function testGetPrimaryOutput() {
		$this->assertEquals("eDP1", $this->object->getPrimaryOutput()->getName());
	}

	/**
	 * @covers \Xrandr\Xrandr::getConnectedOutputs
	 */
	public function testGetConnectedOutputs() {
		$this->assertCount(1, $this->object->getConnectedOutputs());
		$this->assertArrayHasKey("eDP1", $this->object->getConnectedOutputs());
	}

	/**
	 * @covers \Xrandr\Xrandr::parseRaw
	 * @covers \Xrandr\Xrandr::getScreens
	 * @covers \Xrandr\Xrandr::getFirstScreen
	 * @covers \Xrandr\Xrandr::getOutputs
	 * @before
	 */
	public function testParseRaw() {
		$this->object->parseRaw();

		$this->assertCount(1, $this->object->getScreens());
		$this->assertEquals(1360, $this->object->getScreens()[0]->getCurrentGeometry()->width);
		$this->assertSame($this->object->getScreens()[0], $this->object->getFirstScreen());

		$this->assertCount(4, $this->object->getOutputs());
		$this->assertArrayHasKey("eDP1", $this->object->getOutputs());
		$this->assertArrayHasKey("DP1", $this->object->getOutputs());
		$this->assertArrayHasKey("HDMI1", $this->object->getOutputs());
		$this->assertArrayHasKey("VIRTUAL1", $this->object->getOutputs());
	}

}
