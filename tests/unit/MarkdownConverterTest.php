<?php

use App\Services\MarkdownConverter;

class MarkdownConverterTest extends TestCase
{
    /**
     * @var MarkdownConverter
     */
    private $markdownConverter;

    protected function setUp()
    {
        parent::setUp();

        $this->markdownConverter = new MarkdownConverter();
    }


    /** @test */
    public function should_return_html()
    {
        $input = <<<'EOD'
Text **bold** *italic* [link][1]

    print('hello');
    print('world');
    return 0;

Text text text

 1. ol1
 2. ol2

text

 - ul1
 - ul2

> Quote text

text

![image description][2]


  [1]: http://google.com
  [2]: http://i.imgur.com/WHqLxs1.jpg
EOD;

        $expected = <<<'EOD'
<p>Text <strong>bold</strong> <em>italic</em> <a href="http://google.com">link</a></p>
<pre><code>print('hello');
print('world');
return 0;</code></pre>
<p>Text text text</p>
<ol>
<li>ol1</li>
<li>ol2</li>
</ol>
<p>text</p>
<ul>
<li>ul1</li>
<li>ul2</li>
</ul>
<blockquote>
<p>Quote text</p>
</blockquote>
<p>text</p>
<p><img src="http://i.imgur.com/WHqLxs1.jpg" alt="image description" /></p>
EOD;
;

        $result = $this->markdownConverter->toHtml($input);

        self::assertEquals($this->normalizeHtml($expected), $this->normalizeHtml($result));
    }

    /** @test */
    public function should_escape_html()
    {
        $input = '<script>alert();</script>';

        $result = $this->markdownConverter->toHtml($input);

        self::assertNotContains('<script>', $result);
    }

    private function normalizeHtml($html)
    {
        $domDoc = new DomDocument();
        $domDoc->preserveWhiteSpace = false;
        $domDoc->formatOutput = true;

        $domDoc->loadHTML($html);
        return $domDoc->saveHTML();

    }
}
