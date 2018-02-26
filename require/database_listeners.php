<?php

    use EasyDb\Events\Event;

    return [
        /**
         * Add a the fully qualified name
         * of a class which implements EasyDb\Events\Listener
         * to any of the following arrays in order to subscribe
         * to the associated event
         */
        Event::ON_ERROR => [],

        Event::BEFORE_QUERY => [],
        Event::AFTER_QUERY  => [],

        // Update and Insert
        Event::BEFORE_SAVE  => [],
        Event::AFTER_SAVE   => [],

        Event::BEFORE_UPDATE => [],
        Event::AFTER_UPDATE  => [],

        Event::BEFORE_INSERT => [],
        Event::AFTER_INSERT  => [],

        Event::BEFORE_DELETE => [],
        Event::AFTER_DELETE  => []
    ];