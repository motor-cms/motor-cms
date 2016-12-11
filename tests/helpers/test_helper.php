<?php

function create_test_navigation($count = 1)
{
    return factory(Motor\CMS\Models\Navigation::class, $count)->create();
}
