<?php

namespace KnpU\Gladiator\Grading;

use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\CodingChallenge\Exception\GradingException;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Helper to grade HTML output
 */
class HtmlOutputGradingTool
{
    private $output;

    private $crawler;

    public function __construct(CodingExecutionResult $result)
    {
        $this->output = $result->getOutput();
    }

    /**
     * @param string $needle
     * @param string $gradingErrorMessage
     * @param bool|false $caseSensitive
     * @throws GradingException
     */
    public function assertOutputContains($needle, $gradingErrorMessage = null, $caseSensitive = false)
    {
        if (!$this->stringContains($this->output, $needle, $caseSensitive)) {
            if ($gradingErrorMessage === null) {
                $gradingErrorMessage = sprintf('I don\'t see "%s" in the output.', $needle);
            }

            throw new GradingException($gradingErrorMessage);
        }
    }

    public function doesOutputContain($needle, $caseSensitive = false)
    {
        return $this->stringContains($this->output, $needle, $caseSensitive);
    }

    /**
     * @param string $needle
     * @param string $gradingErrorMessage
     * @param bool|false $caseSensitive
     * @throws GradingException
     */
    public function assertOutputDoesNotContain($needle, $gradingErrorMessage = null, $caseSensitive = false)
    {
        if ($this->stringContains($this->output, $needle, $caseSensitive)) {
            if ($gradingErrorMessage === null) {
                $gradingErrorMessage = sprintf('I see "%s" in the output, but it should not be there!', $needle);
            }

            throw new GradingException($gradingErrorMessage);
        }
    }

    /**
     * Returns the text in the *first* matched element
     *
     * @param $cssSelector
     * @return string|false if the element is not found
     */
    public function getElementText($cssSelector)
    {
        $eles = $this->getCrawler()->filter($cssSelector);

        if (count($eles) === 0) {
            return false;
        }

        return $eles->text();
    }

    /**
     * Assert text is found somewhere inside the CSS selector
     *
     * @param string $cssSelector e.g. h2
     * @param string $needle
     * @param string $gradingErrorMessage
     * @param bool|false $caseSensitive
     * @throws GradingException
     */
    public function assertElementContains($cssSelector, $needle, $gradingErrorMessage = null, $caseSensitive = false)
    {
        /** @var Crawler $nodes */
        $nodes = $this->getCrawler()->filter($cssSelector);

        $result = $this;
        foreach ($nodes as $node) {
            /** @var \DOMElement $node */
            if ($result->stringContains($node->nodeValue, $needle, $caseSensitive)) {
                // we found an element!
                return;
            }
        };

        if ($gradingErrorMessage === null) {
            $gradingErrorMessage = sprintf(
                'I don\'t see any "%s" HTML element with the text "%s" in it.',
                $cssSelector,
                $needle
            );
        }

        throw new GradingException($gradingErrorMessage);
    }

    /**
     * @return Crawler
     */
    public function getCrawler()
    {
        if ($this->crawler === null) {
            // http://localhost:8000 is used here so that the Crawler is happy with
            // selecting forms and links (otherwise it fails in the Link::__construct()
            // I don't think that has any side effects
            $this->crawler = new Crawler($this->output, 'http://localhost:8000');
        }

        return $this->crawler;
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @param bool|false $caseSensitive
     * @return bool
     */
    private function stringContains($haystack, $needle, $caseSensitive = false)
    {
        $needle = (string) $needle;
        if ($caseSensitive) {
            $position = strpos($haystack, $needle);
        } else {
            $position = stripos($haystack, $needle);
        }
        return $position !== false;
    }
}
