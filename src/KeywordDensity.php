<?php

declare(strict_types=1);

namespace Kaiju\KeywordDensity;

use Kaiju\Snowball\Stemmer\Stemmer;
use Kaiju\Snowball\StemmerFactory;
use Kaiju\Stopwords\Stopwords;
use voku\helper\UTF8;

class KeywordDensity
{
    private bool $stemmer_normalisation = false;

    private string $lang;   // en|ru|fr|de|...

    private string $text = '';

    /**
     * @var string[]
     */
    private array $words = [];

    private Stemmer $stemmer; // stemmer instance

    private array $words_rank = [];

    private Stopwords $stopWords;

    public function __construct(string $lang = 'en')
    {
        $this->lang = $lang;
        $this->stopWords = Stopwords::make();
        $this->stemmer = StemmerFactory::create($this->lang);
    }

    /**
     * @return string[]
     */
    public function getWords(): array
    {
        return $this->words;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = strip_tags($text);
        $this->words = [];
    }

    public function setStemmerNormalisation(bool $normalize): void
    {
        $this->stemmer_normalisation = $normalize;
    }

    public function getPopularWords(int $max = -1): array
    {
        $this->splitWords();
        $this->words_rank = array_count_values($this->words);
        arsort($this->words_rank);
        if ($max > 0) {
            return array_keys(array_slice($this->words_rank, 0, $max));
        }

        return array_keys($this->words_rank);
    }

    private function splitWords(): void
    {
        $this->words = [];
        $words = $this->stopWords->strip($this->text);
        foreach ($words as $word) {
            $word = $this->prepareWord($word);
            if (!blank($word)) {
                $this->words[] = $word;
            }
        }

        /*
        preg_match_all('/\pL+/ui', $this->text, $m);
        foreach ($m[0] as $word) {
            $word = $this->prepareWord($word);
            if (!blank($word)) {
                $this->words[] = $word;
            }
        }
        */
    }

    public function prepareWord(string $word): string
    {
        $word = UTF8::strtolower($word);

        if ((!ctype_digit($word) && UTF8::strlen($word) <= 1)
            || $this->stopWords->isStopword($word)) {
            return '';
        }

        if ($this->stemmer_normalisation) {
            $word = $this->stemmer->stem($word);
        }

        return $word;
    }
}
