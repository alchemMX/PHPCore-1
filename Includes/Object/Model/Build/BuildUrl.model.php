<?php

namespace Model\Build;

/**
 * BuildUrl
 */
class BuildUrl extends Build
{    
    /**
     * Converts url to the set format
     *
     * @param  string $url Url to convert
     * 
     * @return string
     */
    private function convertToURL( string $url )
    {
        return $this->system->url->build($url);
    }

    /**
     * Builds url to post
     *
     * @param  array $data Post data
     * 
     * @return string
     */
    public function post( $data )
    {
        $page = isset($data['position']) ? ceil($data['position'] / MAX_POSTS) : 1;

        return $this->convertToURL('/forum/topic/' . $data['topic_id'] . '.' . $data['topic_url'] . '/page-' . $page . '/select-' . $data['post_id'] . '/#' . $data['post_id']);
    }

    /**
     * Builds url to topic
     *
     * @param  array $data Topic data
     * 
     * @return string
     */
    public function topic( $data )
    {
        return $this->convertToURL('/forum/topic/' . $data['topic_id'] . '.' . $data['topic_url']);
    }

    /**
     * Builds url to forum
     *
     * @param  array $data Forum data
     * 
     * @return string
     */
    public function forum( $data )
    {
        return $this->convertToURL('/forum/show/' . $data['forum_id'] . '.' . $data['forum_url']);
    }

    /**
     * Builds url to profile post
     *
     * @param  array $data Profile post data
     * 
     * @return string
     */
    public function profilePost( $data )
    {
        $page = isset($data['position']) ? ceil($data['position'] / MAX_PROFILE_POSTS) : 1;

        return $this->convertToURL('/profile/' . $data['profile_user_id'] . '.' . $data['profile_user_name'] . '/page-' . $page . '/select-' . $data['profile_post_id'] . '/#' . $data['profile_post_id']);
    }

    /**
     * Builds url to profile post comment
     *
     * @param  array $data Profile post comment data
     * 
     * @return string
     */
    public function profilePostComment( $data )
    {
        $page = isset($data['position']) ? ceil($data['position'] / MAX_PROFILE_POSTS) : 1;

        return $this->convertToURL('/profile/' . $data['profile_user_id'] . '.' . $data['profile_user_name'] . '/page-' . $page . '/select-c' . $data['profile_post_comment_id'] . '/#c' . $data['profile_post_comment_id']);
    }

    /**
     * Builds url to user profile
     *
     * @param  array $data User profile data
     * 
     * @return string
     */
    public function profile( $data )
    {
        return $this->convertToURL('/profile/' . $data['user_id'] . '.' . $data['user_name']);
    }
}