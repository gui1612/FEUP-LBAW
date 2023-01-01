<?php

    use Carbon\Carbon;

    function displayDate($date) {
        return Carbon::parse($date)->diffForHumans();
    }

?>