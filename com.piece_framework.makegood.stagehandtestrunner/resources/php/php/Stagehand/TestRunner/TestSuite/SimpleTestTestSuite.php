<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * PHP version 5.3
 *
 * Copyright (c) 2009-2012 KUBO Atsuhiro <kubo@iteman.jp>,
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    Stagehand_TestRunner
 * @copyright  2009-2012 KUBO Atsuhiro <kubo@iteman.jp>
 * @license    http://www.opensource.org/licenses/bsd-license.php  New BSD License
 * @version    Release: 3.2.0
 * @link       http://simpletest.org/
 * @since      File available since Release 2.10.0
 */

namespace Stagehand\TestRunner\TestSuite;

use Stagehand\TestRunner\Core\TestTargets;

/**
 * @package    Stagehand_TestRunner
 * @copyright  2009-2012 KUBO Atsuhiro <kubo@iteman.jp>
 * @license    http://www.opensource.org/licenses/bsd-license.php  New BSD License
 * @version    Release: 3.2.0
 * @link       http://simpletest.org/
 * @since      Class available since Release 2.10.0
 */
class SimpleTestTestSuite extends \TestSuite
{
    /**
     * @var \Stagehand\TestRunner\Core\TestTargets
     * @since Property available since Release 3.0.0
     */
    protected $testTargets;

    /**
     * @var array
     */
    protected $testCases = array();

    public function add($test_case)
    {
        parent::add($test_case);
        $this->testCases[] = $test_case;
    }

    /**
     * @return integer
     */
    public function countTests()
    {
        $testCount = 0;
        foreach ($this->testCases as $testCase) {
            $testCount += $this->countTestsInTestCase($testCase);
        }

        return $testCount;
    }

    /**
     * @param \SimpleTestCase $testCase
     * @return integer
     * @since Method available since Release 2.11.1
     */
    public function countTestsInTestCase(\SimpleTestCase $testCase)
    {
        $tests = $this->getTestsInTestCase($testCase);
        $testCount = 0;
        if ($this->testTargets->testsOnlySpecifiedMethods()) {
            foreach ($tests as $method) {
                if ($this->testTargets->shouldTreatElementAsTest(get_class($testCase), $method)) {
                    ++$testCount;
                }
            }
        } elseif ($this->testTargets->testsOnlySpecifiedClasses()) {
            if ($this->testTargets->shouldTreatElementAsTest(get_class($testCase))) {
                $testCount = count($tests);
            }
        } else {
            $testCount = count($tests);
        }

        return $testCount;
    }

    /**
     * @param \Stagehand\TestRunner\Core\TestTargets $testTargets
     * @since Method available since Release 3.0.0
     */
    public function setTestTargets(TestTargets $testTargets)
    {
        $this->testTargets = $testTargets;
    }

    /**
     * @param \SimpleTestCase $testCase
     * @return integer
     * @since Method available since Release 2.14.0
     */
    protected function getTestsInTestCase(\SimpleTestCase $testCase)
    {
        return $testCase->getTests();
    }
}

/*
 * Local Variables:
 * mode: php
 * coding: iso-8859-1
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * indent-tabs-mode: nil
 * End:
 */