<?php declare(strict_types=1);
/**
 * This file is part of silex-twig-breadcrumb-extension
 *
 * (c) Gregor Panek <gp@gregorpanek.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace nymo\Resources\Library;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGenerator;

/**
 * Testcases for the BreadCrumbCollection class
 * @author Gregor Panek <gp@gregorpanek.de>
 */
class BreadCrumbCollectionTest extends TestCase
{

    /**
     * @var BreadCrumbCollection
     */
    protected $breadCrumbColl;

    public function setUp()
    {
        $this->breadCrumbColl = new BreadCrumbCollection();
    }

    public function testAddItem(): void
    {

        $generator = $this->createMock(UrlGenerator::class);
        $generator->method('generate')->willReturn('www.yahoo.com');

        $this->breadCrumbColl->setUrlGenerator($generator);

        $this->breadCrumbColl->addItem('Google', 'www.google.de');
        $this->breadCrumbColl->addItem('No Target');
        $this->breadCrumbColl->addItem('Yahoo', ['route' => 'foo']);
        $this->breadCrumbColl->addItem('Yahoo', ['params' => 'bar', 'route' => 'foo']);


        $breadCrumbs = $this->breadCrumbColl->getItems();

        $this->assertCount(4, $breadCrumbs);
        $this->assertEquals('Google', $breadCrumbs[0]['linkName']);
        $this->assertEquals('Google', $breadCrumbs[0]['linkName']);
        $this->assertEquals('No Target', $breadCrumbs[1]['linkName']);
        $this->assertNull($breadCrumbs[1]['target']);
        $this->assertEquals('www.yahoo.com', $breadCrumbs[2]['target']);
        $this->assertEquals('www.yahoo.com', $breadCrumbs[3]['target']);
    }

    public function testAddSimpleItem(): void
    {
        $this->breadCrumbColl->addSimpleItem('Google', 'www.google.com');
        $this->breadCrumbColl->addSimpleItem('Amazon');

        $breadCrumbs = $this->breadCrumbColl->getItems();

        $this->assertCount(2, $breadCrumbs);
        $this->assertEquals('Google', $breadCrumbs[0]['linkName']);
        $this->assertEquals('www.google.com', $breadCrumbs[0]['target']);
        $this->assertEquals('Amazon', $breadCrumbs[1]['linkName']);
        $this->assertNull($breadCrumbs[1]['target']);
    }

    public function testAddRouteItem(): void
    {
        $generator = $this->createMock(UrlGenerator::class);
        $generator->method('generate')->willReturn('www.yahoo.com');

        $this->breadCrumbColl->setUrlGenerator($generator);

        $this->breadCrumbColl->addRouteItem('Yahoo', ['route' => 'foo']);
        $this->breadCrumbColl->addRouteItem('Yahoo', ['params' => 'bar', 'route' => 'foo']);

        $breadCrumbs = $this->breadCrumbColl->getItems();

        $this->assertCount(2, $breadCrumbs);
        $this->assertEquals('Yahoo', $breadCrumbs[0]['linkName']);
        $this->assertEquals('www.yahoo.com', $breadCrumbs[0]['target']);
        $this->assertEquals('Yahoo', $breadCrumbs[1]['linkName']);
        $this->assertEquals('www.yahoo.com', $breadCrumbs[1]['target']);
    }
}
