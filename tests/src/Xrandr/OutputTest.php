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
require_once dirname(__FILE__) . '/../../../src/Xrandr/Geometry.php';
require_once dirname(__FILE__) . '/../../../src/Xrandr/Output.php';

use \Xrandr\Output;
use \Xrandr\Geometry;
use \Xrandr\Mode;
use \Xrandr\Reflection;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-11-21 at 00:20:20.
 */
class OutputTest extends PHPUnit_Framework_TestCase {

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {

	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown() {

	}

	/**
	 * @covers \Xrandr\Output::parseLine
	 * @covers \Xrandr\Output::isConnected
	 * @covers \Xrandr\Output::isPrimary
	 * @covers \Xrandr\Output::getGeometry
	 * @covers \Xrandr\Output::getRotation
	 * @covers \Xrandr\Output::getPhysicalWidth
	 * @covers \Xrandr\Output::getPhysicalHeight
	 * @covers \Xrandr\Output::__construct
	 * @afterClass \Xrandr\Geometry
	 */
	public function testParseLine() {
		$object = Output::parseLine("eDP1 connected primary 1360x768+0+0 (normal left inverted right x axis y axis) 344mm x 193mm");
		$this->assertEquals("eDP1", $object->getName());
		$this->assertTrue($object->isConnected());
		$this->assertTrue($object->isPrimary());
		$this->assertNotNull($object->getGeometry());
		$this->assertEquals(1360, $object->getGeometry()->width);
		$this->assertEquals(768, $object->getGeometry()->height);
		$this->assertEquals(344, $object->getPhysicalWidth());
		$this->assertEquals(193, $object->getPhysicalHeight());

		$object = Output::parseLine("eDP1 connected primary 1360x768+0+0 left (normal left inverted right x axis y axis) 344mm x 193mm");
		$this->assertEquals("eDP1", $object->getName());
		$this->assertEquals("left", $object->getRotation());

		$object = Output::parseLine("eDP1 connected primary 1360x768+0+0 X axis (normal left inverted right x axis y axis) 344mm x 193mm");
		$this->assertEquals("eDP1", $object->getName());
		$this->assertEquals(Reflection::X, $object->getReflection());

		$object = Output::parseLine("eDP1 connected primary 1360x768+0+0 right X and Y axis (normal left inverted right x axis y axis) 344mm x 193mm");
		$this->assertEquals("eDP1", $object->getName());
		$this->assertEquals("right", $object->getRotation());
		$this->assertEquals(Reflection::XY, $object->getReflection());

		$object = Output::parseLine("DP1 disconnected (normal left inverted right x axis y axis)");
		$this->assertEquals("DP1", $object->getName());
		$this->assertFalse($object->isConnected());
		$this->assertFalse($object->isPrimary());
		$this->assertNull($object->getGeometry());
		$this->assertEquals(0, $object->getPhysicalWidth());
		$this->assertEquals(0, $object->getPhysicalHeight());

		$object = Output::parseLine("DP1 partying hard (normal left inverted right x axis y axis)");
		$this->assertNull($object);
	}

	/**
	 * @covers \Xrandr\Output::parseLine
	 * @covers \Xrandr\Output::__construct
	 * @covers \Xrandr\Output::_addExistingMode
	 * @covers \Xrandr\Output::getCurrentMode
	 * @afterClass \Xrandr\Mode
	 */
	public function testGetCurrentMode() {
		$object = Output::parseLine("eDP1 connected primary 1360x768+0+0 (normal left inverted right x axis y axis) 344mm x 193mm");
		$object->_addExistingMode(Mode::parseLine("   1366x768       60.0 +"));
		$object->_addExistingMode(Mode::parseLine("   1360x768       59.8*    60.0"));
		$object->_addExistingMode(Mode::parseLine("   1024x768       60.0 "));

		$this->assertEquals("1360x768", $object->getCurrentMode()->getName());
	}

	/**
	 * @covers \Xrandr\Output::parseLine
	 * @covers \Xrandr\Output::__construct
	 * @covers \Xrandr\Output::_addExistingMode
	 * @covers \Xrandr\Output::getPreferredMode
	 * @afterClass \Xrandr\Mode
	 */
	public function testGetPreferredMode() {
		$object = Output::parseLine("eDP1 connected primary 1360x768+0+0 (normal left inverted right x axis y axis) 344mm x 193mm");
		$object->_addExistingMode(Mode::parseLine("   1366x768       60.0 +"));
		$object->_addExistingMode(Mode::parseLine("   1360x768       59.8*    60.0"));
		$object->_addExistingMode(Mode::parseLine("   1024x768       60.0 "));

		$this->assertEquals("1366x768", $object->getPreferredMode()->getName());
	}

}
