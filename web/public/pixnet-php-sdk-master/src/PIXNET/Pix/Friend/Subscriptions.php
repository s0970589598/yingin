<?php
/**
 * Copyright (c) 2014, PIXNET Digital Media Corporation
 * All rights reserved.
 */

class Pix_Friend_Subscriptions extends PixAPI
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
            $response = $this->query('friend/subscriptions/' . $options, $parameters, 'GET');
            return $this->getResult($response, 'subscription');
        }
        $parameters = $this->mergeParameters(
            array(),
            $options,
            array('page', 'per_page'),
            array()
        );

        $response = $this->query('friend/subscriptions', $parameters, 'GET');
        return $this->getResult($response, 'subscriptions');
    }

    public function create($name, $options = array())
    {
        if ('' == $name) {
            throw new PixAPIException('Required parameters missing', PixAPIException::REQUIRE_PARAMETERS_MISSING);
        }
        $parameters = $this->mergeParameters(
            array('user' => $name),
            $options,
            array(),
            array('group_ids')
        );
        $response = $this->query('friend/subscriptions', $parameters, 'POST');
        return $this->getResult($response, 'subscription');
    }

    public function joinSubscriptionGroup($name, $group_id)
    {
        if ('' == $name or '' == $group_id) {
            throw new PixAPIException('Required parameters missing', PixAPIException::REQUIRE_PARAMETERS_MISSING);
        }
        $parameters = $this->mergeParameters(
            array('name' => $name),
            $group_id,
            array(),
            array('group_ids')
        );
        $response = $this->query('friend/subscriptions/' . $name . '/join_subscription_group', $parameters, 'POST');
        return $this->getResult($response, 'subscription');
    }

    public function leaveSubscriptionGroup($name, $group_id)
    {
        if ('' == $name or '' == $group_id) {
            throw new PixAPIException('Required parameters missing', PixAPIException::REQUIRE_PARAMETERS_MISSING);
        }
        $parameters = $this->mergeParameters(
            array('name' => $name),
            $group_id,
            array(),
            array('group_ids')
        );
        $response = $this->query('friend/subscriptions/' . $name . '/leave_subscription_group', $parameters, 'POST');
        return $this->getResult($response, 'subscription');
    }

    public function delete($name)
    {
        if ('' == $name) {
            throw new PixAPIException('Required parameters missing', PixAPIException::REQUIRE_PARAMETERS_MISSING);
        }
        $parameters = $this->mergeParameters(
            array(),
            $group_id,
            array(),
            array()
        );
        $response = $this->query('friend/subscriptions/' . $name, $parameters, 'DELETE');
        return $response;
    }
}
