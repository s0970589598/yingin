<?php
/**
 * Copyright (c) 2014, PIXNET Digital Media Corporation
 * All rights reserved.
 */

class Pix_Album_Folders extends PixAPI
{
    public function __construct($client)
    {
        $this->client = $client;
    }

    public function __get($class_name)
    {
        throw new PixAPIException('CLASS [' . $class_name . '] NOT FOUND', PixAPIException::CLASS_NOT_FOUND);
    }

    public function search($name, $options = null)
    {
        if (empty($name)) {
            throw new PixAPIException('Required parameters missing', PixAPIException::REQUIRE_PARAMETERS_MISSING);
        }
        $parameters = $this->mergeParameters(
            array('user' => $name),
            $options,
            array('trim_user', 'page', 'per_page'),
            array()
        );
        if (isset($options['folder_id']) and is_numeric($options['folder_id'])) {
            $response = $this->query('album/folders/' . $options['folder_id'], $parameters, 'GET');
            return $this->getResult($response, 'folder');
        } else {
            $response = $this->query('album/folders', $parameters, 'GET');
            return $this->getResult($response, 'folders');
        }
    }

    public function create($title, $desc)
    {
        if (empty($title) or empty($desc)) {
            throw new PixAPIException('Required parameters missing', PixAPIException::REQUIRE_PARAMETERS_MISSING);
        }
        $parameters = $this->mergeParameters(
            array('title' => $title, 'description' => $desc),
            array(),
            array(),
            array()
        );
        $response = $this->query('album/folders', $parameters, 'POST');
        return $this->getResult($response, 'folder');
    }

    public function update($folder_id, $title, $desc)
    {
        if (!is_numeric($folder_id) or empty($title) or empty($desc)) {
            throw new PixAPIException('Required parameters missing', PixAPIException::REQUIRE_PARAMETERS_MISSING);
        }
        $parameters = $this->mergeParameters(
            array('title' => $title, 'description' => $desc),
            array(),
            array(),
            array()
        );
        $response = $this->query('album/folders/' . $folder_id, $parameters, 'POST');
        return $this->getResult($response, 'folder');
    }

    public function delete($folder_id)
    {
        if ('' == $folder_id) {
            throw new PixAPIException('Required parameters missing', PixAPIException::REQUIRE_PARAMETERS_MISSING);
        }
        $parameters = $this->mergeParameters(
            array(),
            $options,
            array(),
            array()
        );
        $response = $this->query('album/folders/' . $folder_id, $parameters, 'DELETE');
        return $response;
        return $this->getResult($response, 'folders');
    }
}
