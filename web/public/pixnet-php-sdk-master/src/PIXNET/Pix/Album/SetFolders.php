<?php
/**
 * Copyright (c) 2014, PIXNET Digital Media Corporation
 * All rights reserved.
 */

class Pix_Album_SetFolders extends PixAPI
{
    public function __construct($client)
    {
        $this->client = $client;
    }

    public function __get($class_name)
    {
        throw new PixAPIException('CLASS [' . $class_name . '] NOT FOUND', PixAPIException::CLASS_NOT_FOUND);
    }

    public function search($name, $options = array())
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
        $response = $this->query('album/setfolders', $parameters, 'GET');
        return $this->getResult($response, 'setfolders');
    }

    public function position($ids)
    {
        if (empty($ids)) {
            throw new PixAPIException('Required parameters missing', PixAPIException::REQUIRE_PARAMETERS_MISSING);
        }
        $parameters = $this->mergeParameters(
            array('parent_id' => $parent_id, 'ids' => $ids),
            $options,
            array(),
            array()
        );
        $response = $this->query('album/sets/position', $parameters, 'POST');
        return $this->getResult($response, 'sets');
    }
}
