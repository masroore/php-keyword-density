<?php

declare(strict_types=1);

namespace Kaiju\KeywordDensity;

use Kaiju\Snowball\Stemmer\Stemmer;
use Kaiju\Snowball\StemmerFactory;
use Kaiju\Stopwords\Stopwords;
use Soundasleep\Html2Text;
use voku\helper\UTF8;
use writecrow\Lemmatizer\Lemmatizer;

class KeywordDensity
{
    const DEFAULT_MAX_KEYWORD_LENGTH = 50;
    const DEFAULT_MIN_KEYWORD_LENGTH = 3;

    private bool $stemming = false;

    private bool $lemmatize = false;

    private string $lang;   // en|ru|fr|de|...

    private string $text = '';

    /**
     * @var string[]
     */
    private array $keywords = [];

    private Stemmer $stemmer; // stemmer instance

    private array $words_rank = [];

    private Stopwords $stopWords;

    private int $keywordCount = 0;

    private int $minKeywordLength = self::DEFAULT_MIN_KEYWORD_LENGTH;

    private int $maxKeywordLength = self::DEFAULT_MAX_KEYWORD_LENGTH;

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
        return $this->keywords;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setHtml(string $html): void
    {
        $this->setText(Html2Text::convert($html, ['ignore_errors' => true, 'drop_links' => true]));
    }

    public function setText(string $text): void
    {
        $this->text = strip_tags($text);
        $this->keywords = [];
    }

    public function calcDensity(): void
    {
        $this->splitWords();
        $this->words_rank = array_count_values($this->keywords);
        arsort($this->words_rank);
    }

    public function getPopularWords(int $max = -1): array
    {
        if ($max > 0) {
            return array_keys(array_slice($this->words_rank, 0, $max));
        }

        return array_keys($this->words_rank);
    }

    private function splitWords(): void
    {
        $this->keywordCount = 0;
        $this->keywords = [];
        $words = $this->stopWords->strip($this->text);
        foreach ($words as $word) {
            $word = $this->normalizeWord($word);
            if (!empty($word)) {
                ++$this->keywordCount;
                $this->keywords[] = $word;
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

    public function normalizeWord(string $word): string
    {
        $word = UTF8::strtolower($word);
        $len = UTF8::strlen($word);
        if (ctype_digit($word) ||
            $len <= $this->getMinKeywordLength() ||
            $len >= $this->getMaxKeywordLength() ||
            $this->stopWords->isStopword($word)) {
            return '';
        }

        if ($this->stemming) {
            $word = $this->stemmer->stem($word);
        } elseif ($this->lemmatize) {
            $word = Lemmatizer::getLemma($word);
        }

        return $word;
    }

    public function getMinKeywordLength(): int
    {
        return $this->minKeywordLength;
    }

    public function setMinKeywordLength(int $minKeywordLength): void
    {
        $this->minKeywordLength = $minKeywordLength;
    }

    public function getMaxKeywordLength(): int
    {
        return $this->maxKeywordLength;
    }

    public function setMaxKeywordLength(int $maxKeywordLength): void
    {
        $this->maxKeywordLength = $maxKeywordLength;
    }

    public function getWordsRank(int $max = -1): array
    {
        $words = $max > 0 ? array_slice($this->words_rank, 0, $max) : $this->words_rank;
        $keywords = [];
        foreach ($words as $word => $count) {
            $percent = 100 / $this->keywordCount * $count;
            $keywords[] = [
                'keyword' => $word,
                'count' => $count,
                'percent' => round($percent, 1),
            ];
        }

        return $keywords;
    }

    public function getKeywordCount(): int
    {
        return $this->keywordCount;
    }

    public function setStemming(bool $enabled): self
    {
        $this->stemming = $enabled;

        return $this;
    }

    public function setLemmatize(bool $enabled): self
    {
        $this->lemmatize = $enabled;

        return $this;
    }
}
