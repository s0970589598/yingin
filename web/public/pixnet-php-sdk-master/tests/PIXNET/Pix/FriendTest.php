<?php
class Pix_FriendTest extends PHPUnit_Framework_TestCase
{
    public static $pixapi;
    public static $group_id;

    public static function setUpBeforeClass()
    {
        Authentication::setUpBeforeClass();
        self::$pixapi = Authentication::$pixapi;
    }

    public static function tearDownAfterClass()
    {
        Authentication::tearDownAfterClass();
    }

    /**
     * @expectedException PixAPIException
     */
    public function testGetException()
    {
        $actual = self::$pixapi->friend->subscription->search();
    }

    public function testNews()
    {
        self::$pixapi->friend->friendships->create('emmatest2');
        $actual_all = self::$pixapi->friend->news()['data'];
        self::$pixapi->friend->friendships->delete('emmatest2');
        self::$pixapi->friend->subscriptions->delete('emmatest2');
        foreach ($actual_all as $news) {
            $actual = array(
                'content_type'      => $news['content_type'],
                'wording'           => $news['wording'],
                'blogarticle_title' => $news['blog_article']['title'],
                'blogarticle_body'  => $news['blog_article']['body'],
                'user_name'         => $news['user']['name']
            );
        }

        $expected = array(
            'content_type'      => 'blog',
            'wording'           => '文章更新',
            'blogarticle_title' => 'test new',
            'blogarticle_body'  => 'test',
            'user_name'         => 'emmatest2'
        );

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException PixAPIException
     * @expectedExceptionCode PixAPIException::CLASS_NOT_FOUND
     */
    public function testSubClassNotFoundException()
    {
        $actual = self::$pixapi->friend->notfound;
    }
}
