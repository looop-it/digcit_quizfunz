<?php
namespace App\Helpers;

use Purifier;
use Cache;
use Log;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
* helper class
*/
class Utility
{
    /**
     * decode unicode to utf-8 for chinese answer
     * @param  String $str [description]
     * @return String      [description]
     */
    public static function decodeUnicode($str)
    {
        return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', create_function('$matches', 'return iconv("UCS-2BE","UTF-8",pack("H*", $matches[1]));'), $str);
    }

    /**
     * [makeExcept description]
     * @param  String $html rich-media html code
     * @return String       except without html code
     */
    public static function makeExcerpt($body, $lenth = 200)
    {
        $html = $body;
        $excerpt = trim(preg_replace('/\s\s+/', ' ', strip_tags(Purifier::clean($html))));
        return str_limit($excerpt, $lenth);
    }

    /**
     * make slug for posts
     * @param  String $title [description]
     * @return String        [description]
     */
    public static function makeSlug($title)
    {
        $slug = trim($title);
        // $slug = preg_replace('/(([\xa1-\xa9][\xa1-\xfe]))+/', '-', $slug);
        $slug =urlencode($slug);//将关键字编码
        //下面的必须写在一行，不可换行截断
        $slug=preg_replace("/(%7E|%60|%21|%40|%23|%24|%25|%5E|%26|%27|%2A|%28|%29|%2B|%7C|%5C|%3D|\-|_|%5B|%5D|%7D|%7B|%3B|%22|%3A|%3F|%3E|%3C|%2C|\.|%2F|%7D|%E3%80%82|%EF%BC%81|%EF%BC%8C|%EF%BC%9B|%EF%BC%9F|%EF%BC%9A|%E3%80%81|%E2%80%A6|%E2%80%9D|%E2%80%9C|%E2%80%98|%E2%80%99|%EF%BD%9E|%EF%BC%8E|%EF%BC%88|%E3%80%90|%E3%80%91|%E3%80%8A|%E3%80%8B|%E3%80%8C|%E3%80%8D|%E3%80%8E|%E3%80%8F)+/", '-', $slug);
        // $slug=preg_replace("/(%7E|%60|%21|%40|%23|%24|%25|%5E|%26|%27|%2A|%28|%29|%2B|%7C|%5C|%3D|\-|_|%5B|%5D|%7D|%7B|%3B|%22|%3A|%3F|%3E|%3C|%2C|\.|%2F|%A3%BF|%A1%B7|%A1%B6|%A1%A2|%A1%A3|%A3%AC|%7D|%A1%B0|%A3%BA|%A3%BB|%A1%AE|%A1%AF|%A1%B1|%A3%FC|%A3%BD|%A1%AA|%A3%A9|%A3%A8|%A1%AD|%A3%A4|%A1%A4|%A3%A1|%A1%AB|%A3%FB|%A3%FD|%A1%BE|%A1%BF|)+/",'',$slug);
        $slug =urldecode($slug);
        //先去掉英文标点符号、空格等
        $slug = preg_replace('/[[:punct:]\s\n\t\r]/', '-', $slug);

        return $slug;
    }

    /**
     * [getPreviewUrl description]
     * @param  String $channel Article channel name
     * @param  Int $id      Article id
     * @param  String  $slug    Article slug
     * @return String          public url
     */
    public static function getPreviewUrl($channel = null, $id, $slug = null)
    {
        if (\Config::get('app.public_url')) {
            return \Config::get('app.public_url').'/'.$channel.'/'.$id.'/'.$slug ;
        } else {
            return false;
        }
    }

    public static function getVideoInfo($video_url)
    {
        if (str_contains($video_url, 'vimeo.com')) {
            $oembed_endpoint = 'http://vimeo.com/api/oembed';
            $json_url = $oembed_endpoint . '.json?url=' . rawurlencode($video_url) . '&title=false&portrait=false&api=true';
            $oembed_json = json_decode(self::curlGet($json_url));

            return $oembed_json;
        } elseif (str_contains($video_url, 'youtu')) {
            $oembed_endpoint = 'http://www.youtube.com/oembed';
            $json_url = $oembed_endpoint . '?url=' . rawurlencode($video_url) . '&format=json';
            $oembed_json = json_decode(self::curlGet($json_url));

            return $oembed_json;
        } else {
            return false;
        }
    }

    public static function isVideoPost($video_url)
    {
        if (str_contains(trim($video_url), 'vimeo.com') || str_contains(trim($video_url), 'youtube.com')) {
            return true;
        } else {
            return false;
        }
    }

    public static function getVimeoId($video_url)
    {
        // https://vimeo.com/168516762
        if (starts_with($video_url, 'https://vimeo.com/')) {
            $vimeoId = str_replace('https://vimeo.com/', '', $video_url);
            if (is_numeric($vimeoId)) {
                return $vimeoId;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public static function getUrlRootDomain($url)
    {
        $urlMap = ['hk', 'cn', 'com', 'co.uk'];

        $host = "";

        $urlData = parse_url($url);
        if ($urlData) {
            $hostData = explode('.', $urlData['host']);
            $hostData = array_reverse($hostData);

            if (array_search($hostData[1] . '.' . $hostData[0], $urlMap) !== false) {
                $host = $hostData[2] . '.' . $hostData[1] . '.' . $hostData[0];
            } elseif (array_search($hostData[0], $urlMap) !== false) {
                $host = $hostData[1] . '.' . $hostData[0];
            }

            return $host;
        } else {
            return $url;
        }
    }

    private static function curlGet($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $return = curl_exec($curl);
        curl_close($curl);
        return $return;
    }

    public static function getFacebookAccessToken()
    {
        // get access token form cache
        $access_token = Cache::remember('facebook_access_token', 60*24*7, function () {
            return self::issueFacebookAccessToekn();
        });
        return $access_token;
    }

    private static function issueFacebookAccessToekn()
    {
        $client_id     = env('FACEBOOK_CLIENT_ID');
        $client_secret = env('FACEBOOK_CLIENT_SECRET');
        $facebook_api_uri = 'https://graph.facebook.com/oauth/access_token?client_id='.$client_id.'&client_secret='.$client_secret.'&grant_type=client_credentials';

        $access_token = null;

        if (isset($client_id) && isset($client_secret)) {
            $response = json_decode(self::curlGet($facebook_api_uri));
            if (isset($response->access_token)) {
                return $response->access_token;
            }
        }
        return $access_token;
    }
}
