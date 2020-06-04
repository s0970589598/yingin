<?php
/**
 * Copyright (c) 2014, PIXNET Digital Media Corporation
 * All rights reserved.
 */

class Pix_Blog_Categories extends PixAPI
{
    public function __construct($client)
    {
        $this->client = $client;
    }

    public function __get($class_name)
    {
        throw new PixAPIException('CLASS [' . $class_name . '] NOT FOUND', PixAPIException::CLASS_NOT_FOUND);
    }

    public function search($name, $options = [])
    {
        if ('' == $name) {
            throw new PixAPIException('Required parameters missing', PixAPIException::REQUIRE_PARAMETERS_MISSING);
        }
        if (isset($options['category_id']) and is_numeric($options['category_id'])) {
            $api['path'] = 'blog/categories/' . $options['category_id'];
            $api['response'] = 'category';
        } else {
            $api['path'] = 'blog/categories';
            $api['response'] = 'categories';
        }
        $parameters = $this->mergeParameters(
            array('name' => $name, 'type' => 'category'),
            $options,
            array('show_index', 'site_category_id', 'site_category_done'),
            array('description')
        );
        $response = $this->query($api['path']);
        return $this->getResult($response, $api['response']);
    }

    public function create($name, $is_folder = false, $options = array())
    {
        if ('' == $name) {
            throw new PixAPIException('Required parameters missing', PixAPIException::REQUIRE_PARAMETERS_MISSING);
        }
        $parameters = $this->mergeParameters(
            array('name' => $name, 'type' => ($is_folder) ? 'folder' : 'category'),
            $options,
            array('show_index', 'site_category_id', 'site_category_done'),
            array('description')
        );
        $response = $this->query('blog/categories', $parameters, 'POST');
        return $this->getResult($response, 'category');
    }

    public function update($category_id, $name, $is_folder = false, $options = array())
    {
        if ('' == $category_id or '' == $name) {
            throw new PixAPIException('Required parameters missing', PixAPIException::REQUIRE_PARAMETERS_MISSING);
        }
        $parameters = $this->mergeParameters(
            array('name' => $name, 'type' => ($is_folder) ? 'folder' : 'category'),
            $options,
            array('show_index', 'site_category_id', 'site_category_done'),
            array('description')
        );
        $response = $this->query('blog/categories/' . $category_id, $parameters, 'POST');
        return $this->getResult($response, 'category');
    }

    public function delete($category_id, $is_folder = false)
    {
        if ('' == $category_id) {
            throw new PixAPIException('Required parameters missing', PixAPIException::REQUIRE_PARAMETERS_MISSING);
        }
        $parameters = array(
            'type' => ($is_folder) ? 'folder' : 'category'
        );
        $response = $this->query('blog/categories/' . $category_id, $parameters, 'DELETE');
        return $response;
    }

    public function position($category_ids)
    {
        if ('' == $category_ids) {
            throw new PixAPIException('Required parameters missing', PixAPIException::REQUIRE_PARAMETERS_MISSING);
        }
        $parameters = array(
            'ids' => $category_ids
        );
        $response = $this->query('blog/categories/position', $parameters, 'POST');
        return  $this->getResult($response, 'categories');
    }
}
