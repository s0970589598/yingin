<?php
/**
 * Copyright (c) 2014, PIXNET Digital Media Corporation
 * All rights reserved.
 */

class Pix_Friend_Groups extends PixAPI
{
    public function __construct($client)
    {
        $this->client = $client;
    }

    public function __get($class_name)
    {
        throw new PixAPIException('CLASS [' . $class_name . '] NOT FOUND', PixAPIException::CLASS_NOT_FOUND);
    }

    public function search($options = array())
    {
        if (!is_array($options)) {
            $parameters = $this->mergeParameters(
                array(),
                $options,
                array('page', 'per_page'),
                array()
            );
            $response = $this->query('friend/groups/' . $options, $parameters, 'GET');
            return $this->getResult($response, 'friend_group');
        }
        $parameters = $this->mergeParameters(
            array(),
            $options,
            array('page', 'per_page'),
            array()
        );

        $response = $this->query('friend/groups', $parameters, 'GET');
        return $this->getResult($response, 'friend_groups');
    }

    public function create($name)
    {
        if ('' == $name) {
            throw new PixAPIException('Required parameters missing', PixAPIException::REQUIRE_PARAMETERS_MISSING);
        }
        $parameters = $this->mergeParameters(
            array('name' => $name),
            $options,
            array(),
            array()
        );
        $response = $this->query('friend/groups', $parameters, 'POST');
        return $this->getResult($response, 'friend_group');
    }

    public function update($group_id, $name)
    {
        if ('' == $group_id or '' == $name) {
            throw new PixAPIException('Required parameters missing', PixAPIException::REQUIRE_PARAMETERS_MISSING);
        }
        $parameters = $this->mergeParameters(
            array('name' => $name),
            $options,
            array(),
            array()
        );
        $response = $this->query('friend/groups/' . $group_id, $parameters, 'POST');
        return $this->getResult($response, 'friend_group');
    }

    public function delete($group_id)
    {
        if ('' == $group_id) {
            throw new PixAPIException('Required parameters missing', PixAPIException::REQUIRE_PARAMETERS_MISSING);
        }
        $parameters = $this->mergeParameters(
            array(),
            $options,
            array(),
            array()
        );
        $response = $this->query('friend/groups/' . $group_id, $parameters, 'DELETE');
        return $response;
    }
}
