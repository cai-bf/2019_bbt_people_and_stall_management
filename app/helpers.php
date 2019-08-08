<?php


function getCaptcha() {
    return random_int(10000000, 99999999);
}