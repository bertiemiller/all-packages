<?php

namespace Topicmine\UrlScrape\Repositories\UrlResult;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelectorConverter;

trait DomFilter {
    
    public function getRootElementsNodeHtml()
    {
        $html = $this->crawler->filter('body')->html();

        return $this->loopElementForElements($html);
    }

    public function loopElementForElements($html)
    {
        static $selector = 'body';

        $crawler = new Crawler($html);
        static $level = 0;
        $level++;

        $items = [];
        $selectorNew = [];
        
        foreach ($crawler->filter('body')->children() as $k=>$domElement) 
        {
            if(! array_intersect(
                [$domElement->nodeName], 
                ['header', 'footer', 'script', 'noscript', 'svg', 'span', 'a']
            )) {
                
                $childrenCount = $crawler->filter('body')->children()->eq($k)->children()->count();
                $nodeName = $domElement->nodeName;
                $selectorNew[] = $selector . ' > ' . $domElement->nodeName;
                $position = count( array_keys( $selectorNew, $selector . ' > ' . $domElement->nodeName ));
                $sel = $selector . ' > ' . $domElement->nodeName . ':nth-child('.$position.')';
                
                if($childrenCount > 0) 
                {
                    $converter = new CssSelectorConverter();
                    $xpath = $converter->toXPath($sel);
                    $html2 = null;
                    foreach ($domElement->childNodes as $domElementC) {
                        $html2 .= $domElementC->ownerDocument->saveHTML($domElementC);
                    }

                    $items[] = [
                        'name' => $domElement->nodeName,
                        'class' => $crawler->filter('body')->children()->eq($k)->attr('class'),
                        'id' => $crawler->filter('body')->children()->eq($k)->attr('id'),
                        'selector' => $sel,
                        'xpath' => $xpath,
                        'level' => $level,
                        'in_parent_position' => $k,
                        'in_parent_of_type_position' => $position,
                        'children_count' => $childrenCount,
                        'item' => $crawler->filter('body')->children()->eq($k),
                        'html' => [$domElement->ownerDocument->saveHTML($domElement)],
                        'html2' => [$html2],
                    ];
                }
            }
        }

        if(count($items) == 1)
        {
            $selector .= ' > ' . $nodeName;

            return $this->loopElementForElements($html2);
        }

        return $items;
    }

    public function getTitle()
    {
        if(! $this->crawler->filter('title')->count()) return false;

        return $this->crawler->filter('title')->text();
    }

    public function getDescription()
    {
        if(! $this->crawler->filterXpath("//meta[@name='description']")->count()) return false;

        return $this->crawler->filterXpath("//meta[@name='description']")->extract(['content']);
    }

    public function getH1()
    {
        if(! $this->crawler->filter('h1')->count()) return false;

        return $this->crawler->filter('h1')->text();
    }

    public function getH2()
    {
        if(! $this->crawler->filter('h2')->count()) return false;

        return $this->crawler->filter('h2')->text();
    }

    public function getH3()
    {
        if(! $this->crawler->filter('h3')->count()) return false;

        return $this->crawler->filter('h3')->text();
    }
    public function getH4()
    {
        if(! $this->crawler->filter('h4')->count()) return false;

        return $this->crawler->filter('h4')->text();
    }
    public function getH5()
    {
        if(! $this->crawler->filter('h5')->count()) return false;

        return $this->crawler->filter('h5')->text();
    }
    public function getH6()
    {
        if(! $this->crawler->filter('h6')->count()) return false;

        return $this->crawler->filter('h6')->text();
    }
    public function getA()
    {
        if(! $this->crawler->filter('a')->count()) return false;

        return $this->crawler->filter('a')->extract(['_text', 'href']);

    }
    public function getB()
    {
        if(! $this->crawler->filter('b')->count()) return false;

        return $this->crawler->filter('b')->text();
    }

    public function getI()
    {
        if(! $this->crawler->filter('i')->count()) return false;

        return $this->crawler->filter('i')->text();
    }

    public function getU()
    {
        if(! $this->crawler->filter('u')->count()) return false;

        return $this->crawler->filter('u')->text();
    }

    public function getP()
    {
        if(! $this->crawler->filter('p')->count()) return false;

        return $this->crawler->filter('p')->extract(['_html']);
    }

    public function getUlLi()
    {
        if(! $this->crawler->filter('ul > li')->count()) return false;

        return $this->crawler->filter('ul > li');
    }

    public function getUlLiA()
    {
        if(! $this->crawler->filter('ul > li > a')->count()) return false;

        return $this->crawler->filter('ul > li > a')->extract(['_text', 'href']);
    }
    public function getUlLiChildren()
    {
        if(! $this->crawler->filter('ul > li')->children()->count()) return false;

        $els = $this->crawler->filter('ul > li');

        $htmlNew = [];
        foreach ($els as $domElement) {
            $htmlNew[] = $domElement->ownerDocument->saveHTML($domElement);
        }

        return $htmlNew;
    }

    public function getOlLi()
    {
        if(! $this->crawler->filter('ol > li')->count()) return false;

        return $this->crawler->filter('ol > li');
    }

    public function getOlLiA()
    {
        if(! $this->crawler->filter('ol > li > a')->count()) return false;

        return $this->crawler->filter('ol > li > a')->extract(['_text', 'href']);
    }

    public function getHeader()
    {
        if(! $this->crawler->filter('header')->count()) return false;

        // array makes response easier to read - can be deleted
        return [$this->crawler->filter('header')->html()];
    }

    public function getFooter()
    {
        if(! $this->crawler->filter('footer')->count()) return false;

        // array makes response easier to read - can be deleted
        return [$this->crawler->filter('footer')->html()];
    }




}