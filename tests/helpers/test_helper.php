<?php

/**
 * @param  int  $count
 * @return mixed
 */
function create_test_navigation($count = 1)
{
    return factory(Motor\CMS\Models\Navigation::class, $count)->create();
}

/**
 * @param  int  $count
 * @return mixed
 */
function create_test_page($count = 1)
{
    return factory(Motor\CMS\Models\Page::class, $count)->create();
}
