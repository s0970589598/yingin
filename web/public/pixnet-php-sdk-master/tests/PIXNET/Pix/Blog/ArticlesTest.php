<?php
class Pix_Blog_ArticlesTest extends PHPUnit_Framework_TestCase
{
    public static $pixapi;

    public static function setUpBeforeClass()
    {
        Authentication::setUpBeforeClass();
        self::$pixapi = Authentication::$pixapi;
    }

    private function createTempArticle()
    {
        return self::$pixapi->blog->articles->create('Emma unit test article', 'unit test body')['data'];
    }

    private function destroyTempArticle($article)
    {
        self::$pixapi->blog->articles->delete($article['id']);
    }

    /**
     * @expectedException PixAPIException
     * @expectedExceptionCode PixAPIException::CLASS_NOT_FOUND
     */
    public function testSubClassNotFoundException()
    {
        $actual = self::$pixapi->blog->articles->notfound;
    }

    public function testHot()
    {
        $hot = self::$pixapi->blog->articles->hot();
        $this->assertEquals(0, $hot['error']);
    }

    public function testLatest()
    {
        $latest = self::$pixapi->blog->articles->latest();
        $this->assertEquals(0, $latest['error']);
    }

    /**
     * @expectedException PixAPIException
     */
    public function testDeleteException()
    {
        self::$pixapi->blog->articles->delete('');
    }

    public function testDelete()
    {
        $temp_article = $this->createTempArticle();
        $ret = self::$pixapi->blog->articles->delete($temp_article['id']);
        $this->assertEquals(0, $ret['error']);
    }

    /**
     * @expectedException PixAPIException
     */
    public function testUpdateException()
    {
        self::$pixapi->blog->articles->update('','','');
    }
    public function testUpdate()
    {
        $temp_article = $this->createTempArticle();
        $expected['title'] = "Just Give me a reason";
        $expected['body'] = "OVER My DeaD BoDy";
        $ret = self::$pixapi->blog->articles->update($temp_article['id'], $expected['title'], $expected['body'])['data'];
        $this->destroyTempArticle($temp_article);
        $this->assertEquals($ret['title'], $expected['title']);
        $this->assertEquals($ret['body'], $expected['body']);
    }

    /**
     * @expectedException PixAPIException
     */
    public function testCreateException()
    {
        self::$pixapi->blog->articles->create('', '');
    }

    public function testCreate()
    {
        $temp_article = self::$pixapi->blog->articles->create('Emma unit test article', 'unit test body');
        $this->destroyTempArticle($temp_article['data']);
        $this->assertEquals(0, $temp_article['error']);
    }

    /**
     * @expectedException PixAPIException
     */
    public function testRelatedException()
    {
        self::$pixapi->blog->articles->related('');
    }

    public function testRelated()
    {
        $temp_article = $this->createTempArticle();
        $ret = self::$pixapi->blog->articles->related($temp_article['id']);
        $this->destroyTempArticle($temp_article);
        $this->assertEquals(0, $ret['error']);
    }

    /**
     * @expectedException PixAPIException
     */
    public function testCommentsException()
    {
        self::$pixapi->blog->articles->comments('');
    }

    public function testComments()
    {
        $temp_article = $this->createTempArticle();
        $expected = time();
        self::$pixapi->blog->comments->create(self::$pixapi->getUserName(), $temp_article['id'], $expected);
        $ret = self::$pixapi->blog->articles->comments($temp_article['id']);
        $this->destroyTempArticle($temp_article);
        $this->assertEquals($ret['data'][0]['body'], $expected);
    }

    public function testSearch()
    {
        $temp_article = $this->createTempArticle();
        $ret = self::$pixapi->blog->articles->search($temp_article['id']);
        $this->destroyTempArticle($temp_article);
        $this->assertEquals($ret['data']['body'], $temp_article['body']);
        $ret = self::$pixapi->blog->articles->search();
        $this->assertEquals(0, $ret['error']);
    }
}
