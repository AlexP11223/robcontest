<?php


namespace App\Services;


use Parsedown;

class MarkdownConverter
{

    /**
     * @param $input string markdown text
     * @return string HTML
     */
    public function toHtml($input)
    {
        $parsedown = new Parsedown();
        $parsedown->setMarkupEscaped(true);

        return $parsedown->text($input);
    }
}
