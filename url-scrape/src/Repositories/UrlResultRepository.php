<?php
namespace Topicmine\UrlScrape\Repositories;

use Symfony\Component\DomCrawler\Crawler;
use Topicmine\UrlScrape\Models\UrlResult;
use Topicmine\Core\Repositories\CoreRepository;
use Topicmine\UrlScrape\Repositories\UrlResult\DomFilter;

class UrlResultRepository extends CoreRepository implements UrlResultRepositoryInterface {

    use DomFilter;

    public function model()
    {
        return UrlResult::class;
    }

    public function getDomResults($html)
    {
        $results = [];

        $this->crawler = new Crawler($html);

        $results['root_elements'] = $this->getRootElementsNodeHtml();

        // json - text
        $results['title'] = $this->getTitle();
        $results['description'] = $this->getDescription();
        $results['h1'] = $this->getH1();

        // json - longtext
        $results['h2'] = $this->getH2();
        $results['h3'] = $this->getH3();
        $results['h4'] = $this->getH4();
        $results['h5'] = $this->getH5();
        $results['h6'] = $this->getH6();
        $results['a'] = $this->getA();
        $results['b'] = $this->getB();
        $results['i'] = $this->getI();
        $results['u'] = $this->getU();
        $results['p'] = $this->getP();
        $results['ul_li'] = $this->getUlLi();
        $results['ul_li_a'] = $this->getUlLiA();
        $results['ul_li_children'] = $this->getUlLiChildren();

        $results['ol_li'] = $this->getOlLi();
        $results['ol_li_a'] = $this->getOlLiA();
        $results['header'] = $this->getHeader();
        $results['footer'] = $this->getFooter();

        // images
        // videos
        // products
        // ads
        // sponsored content
        // internal links
        // external links (get IPs)

        return $results;
    }

    public function getSectors($results)
    {
        $selectors = [];

        // as an example, get selectors of root elements
        // will want to extend this to many dom elements when model is working

        foreach($results['root_elements'] as $el) {
            $selectors[] = $el['selector'];
        }

        return $selectors;
    }

    /*
     * Notes
     */

    // match
    // for header / footer
    // for links list
    // sidebar left/right
    // paragraph length
    // link number / non-link word count ratio
    // image count
    // contains h1
    // countains img with name / id / class / title of logo
    // contains link with either login / contact / home - not sure

    // pixel positions
    // width height ratio
    // get root elements parent width = full width
    // header - width > height, and full width
    // sidebar = width < height
    //
}