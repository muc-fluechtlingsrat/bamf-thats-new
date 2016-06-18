<?php

function normalizeUrl ($url) {
    $normalized = preg_replace('/;jsessionid=(.*)$/', '', $url);
    $normalized = preg_replace('/\?nn=(.*)$/', '', $normalized);

    return 'http://www.bamf.de/' . $normalized;
}
